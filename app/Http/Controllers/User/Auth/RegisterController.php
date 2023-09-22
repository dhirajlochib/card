<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\GlobalConst;
use App\Http\Controllers\Controller;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Auth\Events\Registered;
use App\Models\User;
use App\Traits\User\RegisteredUsers;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, RegisteredUsers;

    protected $basic_settings;

    public function __construct()
    {
        $this->basic_settings = BasicSettingsProvider::get();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm() {
        $client_ip = request()->ip() ?? false;
        $user_country = geoip()->getLocation($client_ip)['country'] ?? "";

        $page_title = "User Registration";
        return view('user.auth.register',compact(
            'page_title',
            'user_country',
        ));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validated = $this->validator($request->all())->validate();

        $basic_settings             = $this->basic_settings;

        $validated = Arr::except($validated,['agree']);
        $validated['email_verified']    = ($basic_settings->email_verification == true) ? false : true;
        $validated['sms_verified']      = ($basic_settings->sms_verification == true) ? false : true;
        $validated['kyc_verified']      = ($basic_settings->kyc_verification == true) ? false : true;
        $validated['email']          = $validated['register_email'];
        $validated['password']          = Hash::make($validated['register_password']);
        $validated['raw_password']      = $validated['register_password'];
        $validated['username']          = make_username($validated['firstname'],$validated['lastname']);
        $validated['mobile']            = $validated['mobile'];
        $validated['address']           = [
                                                'country' => '',
                                                'city' => '',
                                                'zip' => '',
                                                'state' => '',
                                                'address' => '',
                                        ];

        event(new Registered($user = $this->create($validated)));
        $this->guard()->login($user);
        return $this->registered($request, $user);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data) {

        $basic_settings = $this->basic_settings;
        $passowrd_rule = "required|string|min:6";
        if($basic_settings->secure_password) {
            $passowrd_rule = ["required",Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()];
        }
        if( $basic_settings->agree_policy){
            $agree ='required|in:on';
        }else{
            $agree ='';
        }

        return Validator::make($data,[
            'firstname'     => 'required|string|max:60',
            'lastname'      => 'required|string|max:60',
            'register_email'         => 'required|string|email|max:150|unique:users,email',
            'register_password'      => $passowrd_rule,
            'mobile'        => 'required|string|max:13|min:10|unique:users,mobile',
            'agree'         => $agree,
        ],
        [
            'mobile.unique' => 'The mobile number has already been taken.',
            'email.unique' => 'The email has already been taken.',
            'mobile.min' => 'The mobile number must be at least 10 characters.',
            'mobile.max' => 'The mobile number may not be greater than 11 characters.',
            'mobile.required' => 'Please enter a valid mobile number.',
        ]);

    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create($data);
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {

        $this->createUserWallets($user);
        $basic_settings = BasicSettingsProvider::get();
        if($basic_settings->kyc_verification) {
            $user = auth()->user();
            if($user->kyc_verified != GlobalConst::APPROVED) {
                $smg = "Please verify your KYC information before any transactional action";
                if($user->kyc_verified == GlobalConst::PENDING) {
                    $smg = "Your KYC information is pending. Please wait for admin confirmation.";
                }
                if(auth()->guard("web")->check()) {
                    return redirect()->route("user.authorize.kyc")->with(['warning' => [$smg]]);
                }
            }
        }
        return redirect()->intended(route('user.dashboard'));
    }
}
