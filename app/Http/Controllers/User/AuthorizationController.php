<?php

namespace App\Http\Controllers\User;

use App\Constants\GlobalConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\SetupKyc;
use App\Models\UserAuthorization;
use App\Notifications\User\Auth\SendAuthorizationCode;
use App\Providers\Admin\BasicSettingsProvider;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ControlDynamicInputFields;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthorizationController extends Controller
{
    use ControlDynamicInputFields;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showMailFrom($token)
    {
        $page_title = "Mail Authorization";
        return view('user.auth.authorize.verify-mail',compact("page_title","token"));
    }

    /**
     * Verify authorizaation code.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function mailVerify(Request $request,$token)
    {
        $request->merge(['token' => $token]);
        $request->validate([
            'token'     => "required|string|exists:user_authorizations,token",
            'code'      => "required|array",
            'code.*'    => "required|numeric",
        ]);
        $code = $request->code;
        $code = implode("",$code);
        $otp_exp_sec = BasicSettingsProvider::get()->otp_exp_seconds ?? GlobalConst::DEFAULT_TOKEN_EXP_SEC;
        $auth_column = UserAuthorization::where("token",$request->token)->where("code",$code)->first();
        if(!$auth_column){
            return back()->with(['error' => ['Verification code does not match']]);
        }


        if($auth_column->created_at->addSeconds($otp_exp_sec) < now()) {
            $this->authLogout($request);
            return redirect()->route('index')->with(['error' => ['Session expired. Please try again']]);
        }

        try{
            $auth_column->user->update([
                'email_verified'    => true,
            ]);
            $auth_column->delete();
        }catch(Exception $e) {
            $this->authLogout($request);
            return redirect()->route('user.login')->with(['error' => ['Something went worng! Please try again']]);
        }

        return redirect()->intended(route("user.dashboard"))->with(['success' => ['Account successfully verified']]);
    }
    public function resendCode()
    {
        $user = auth()->user();
        $resend = UserAuthorization::where("user_id",$user->id)->first();
        if(Carbon::now() <= $resend->created_at->addMinutes(GlobalConst::USER_VERIFY_RESEND_TIME_MINUTE)) {
            throw ValidationException::withMessages([
                'code'      => 'You can resend verification code after '.Carbon::now()->diffInSeconds($resend->created_at->addMinutes(GlobalConst::USER_VERIFY_RESEND_TIME_MINUTE)). ' seconds',
            ]);
        }
        $data = [
            'user_id'       =>  $user->id,
            'code'          => generate_random_code(),
            'token'         => generate_unique_string("user_authorizations","token",200),
            'created_at'    => now(),
        ];

        DB::beginTransaction();
        try{
            UserAuthorization::where("user_id",$user->id)->delete();
            DB::table("user_authorizations")->insert($data);
            $user->notify(new SendAuthorizationCode((object) $data));
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }

        return redirect()->route('user.authorize.mail',$data['token'])->with(['success' => ['Varification code resend success!']]);

    }

    public function authLogout(Request $request) {
        auth()->guard("web")->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function showKycFrom() {
        $user = auth()->user();
        $page_title = "KYC Verification";
        $user_kyc = SetupKyc::userKyc()->first();
        if(!$user_kyc) return back();
            $kyc_data = $user_kyc->fields;
            $kyc_fields = [];
        if($kyc_data) {
            $kyc_fields = array_reverse($kyc_data);
        }
        return view('user.sections.verify-kyc',compact("page_title","kyc_fields","user_kyc"));
    }

    public function find_value_by_key($key,$array) {
        foreach ($array as $item) {
            if($item['name'] == $key) {
                return $item['value'];
            }
        }
    }

    public function kycSubmit(Request $request) {

        $user = auth()->user();
        if($user->kyc_verified == GlobalConst::VERIFIED) return back()->with(['success' => ['You are already KYC Verified User']]);

        $user_kyc_fields = SetupKyc::userKyc()->first()->fields ?? [];
        $validation_rules = $this->generateValidationRules($user_kyc_fields);

        $validated = Validator::make($request->all(),$validation_rules)->validate();
        $get_values = $this->placeValueWithFields($user_kyc_fields,$validated);

        // find and get the credit limit from the $get_values array
        $value = $this->find_value_by_key("monthly_income",$get_values);
        $texXCreditLimitInRoundFigure = 0;

        if($value >= 10000 && $value <= 20000) {
            $texXCreditLimitInRoundFigure = 10000;
        }else if($value >= 20001 && $value <= 30000) {
            $texXCreditLimitInRoundFigure = 20000;
        }else if($value >= 30001 && $value <= 40000) {
            $texXCreditLimitInRoundFigure = 30000;
        }else if($value >= 40001 && $value <= 50000) {
            $texXCreditLimitInRoundFigure = 40000;
        }else if($value >= 50001 && $value <= 60000) {
            $texXCreditLimitInRoundFigure = 50000;
        }else if($value >= 60001 && $value <= 70000) {
            $texXCreditLimitInRoundFigure = 60000;
        }else if($value >= 70001 && $value <= 80000) {
            $texXCreditLimitInRoundFigure = 70000;
        }else if($value >= 80001 && $value <= 90000) {
            $texXCreditLimitInRoundFigure = 80000;
        }else if($value >= 90001 && $value <= 100000) {
            $texXCreditLimitInRoundFigure = 90000;
        }else if($value >= 100001 && $value <= 110000) {
            $texXCreditLimitInRoundFigure = 100000;
        } 

        $credit_limit = $texXCreditLimitInRoundFigure * 5;

        $create = [
            'user_id'       => auth()->user()->id,
            'data'          => json_encode($get_values),
            'created_at'    => now(),
        ];

        DB::beginTransaction();
        try{
            DB::table('user_kyc_data')->updateOrInsert(["user_id" => $user->id],$create);
            $user->update([
                'kyc_verified'  => GlobalConst::VERIFIED,
                'credit_limit'  => $credit_limit,
            ]);
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            $user->update([
                'kyc_verified'  => GlobalConst::DEFAULT,
            ]);
            $this->generatedFieldsFilesDelete($get_values);
            return back()->with(['error' => ['Something went worng! Please try again']]);
        }
         

        return redirect()->route("user.dashboard")->with(['success' => ['KYC information successfully submited']]);
    }
}
