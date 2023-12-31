@extends('user.layouts.master')

@push('css')

@endpush

@section('breadcrumb')
@include('user.components.breadcrumb',['breadcrumbs' => [
[
'name' => __("Dashboard"),
'url' => setRoute("user.dashboard"),
]
], 'active' => __(@$page_title)])
@endsection

@section('content')

<div class="body-wrapper">
    <div class="deposit-wrapper ptb-50">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8 pb-30">

                    <!-- check already requested or not -->
                    @if($alreadyRequested)
                    @if($haveCard)
                    <div class="deposit-form" style="background-color: #1b756b; color: #fff;">
                        <div class="form-title text-center">
                            <h3 class="title">Fixed Deposit - FD</h3>
                        </div>
                        <div class="row justify-content-center">
                            <form class="card-form" action="{{ setRoute("user.add.money.submit") }}" method="POST">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Fixed Deposit Amount<span>*</span></label>
                                        <input type="number" required class="form--control" name="amount" value="{{ $fdFees }}" readonly>
                                        <div class="currency" style="border: 1px solid rgba(255, 255, 255, 0.412);">
                                            <p>{{ get_default_currency_code() }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __("Payment Gateway") }}<span>*</span></label>
                                        <div class="method ">
                                            <select class="form--control nice-select gateway-select" name="currency">
                                                @foreach ($payment_gateways_currencies ?? [] as $item)
                                                <option value="{{ $item->alias  }}" data-currency="{{ $item->currency_code }}" data-min_amount="{{ $item->min_limit }}" data-max_amount="{{ $item->max_limit }}" data-percent_charge="{{ $item->percent_charge }}" data-fixed_charge="{{ $item->fixed_charge }}" data-rate="{{ $item->rate }}">
                                                    {{ $item->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="note-area d-flex justify-content-between">
                                    </div>
                                    <div class="button pt-3">
                                        <button type="submit" class="btn--base w-100 btn-loading sendBtn">{{ __("Confirm") }}</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @else
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <h4 class="text-danger">{{ __("You have already requested for card activation, please wait for approval.") }}</h4>
                            </div>
                            <!-- button to go back -->
                            <div class="text-center">
                                <a href="{{ setRoute('user.dashboard') }}" class="btn btn--base mt-4" style="background-color: #1b756b; color: #fff;">{{ __("Go Back") }}</a>
                            </div>
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="deposit-form">
                        <div class="form-title text-center">
                            <h3 class="title">{{ __($page_title) }}</h3>
                        </div>
                        <div class="row justify-content-center">
                            <form class="card-form" action="{{ setRoute("user.add.money.submit") }}" method="POST">
                                @csrf
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label>Card Activation Fees<span>*</span></label>
                                        <input type="number" required class="form--control" name="amount" value="{{ $cardFee }}" readonly>
                                        <div class="currency" style="border: 1px solid rgba(255, 255, 255, 0.412);">
                                            <p>{{ get_default_currency_code() }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ __("Payment Gateway") }}<span>*</span></label>
                                        <div class="method ">
                                            <select class="form--control nice-select gateway-select" name="currency">
                                                @foreach ($payment_gateways_currencies ?? [] as $item)
                                                <option value="{{ $item->alias  }}" data-currency="{{ $item->currency_code }}" data-min_amount="{{ $item->min_limit }}" data-max_amount="{{ $item->max_limit }}" data-percent_charge="{{ $item->percent_charge }}" data-fixed_charge="{{ $item->fixed_charge }}" data-rate="{{ $item->rate }}">
                                                    {{ $item->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="note-area d-flex justify-content-between">
                                    </div>
                                    <div class="button pt-3">
                                        <button type="submit" class="btn--base w-100 btn-loading sendBtn">{{ __("Confirm") }}</i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif

                </div>

            </div>
        </div>
    </div>


</div>
@endsection

@push('script')
<script>
    var defualCurrency = "{{ get_default_currency_code() }}";
    var defualCurrencyRate = "{{ get_default_currency_rate() }}";

    // $('select[name=currency]').on('change',function(){
    //     getExchangeRate($(this));
    //     getLimit();
    //     getFees();
    //     getPreview();
    // });
    // $(document).ready(function(){
    //     getExchangeRate();
    //     getLimit();
    //     getFees();
    //     getPreview();
    // });
    $("input[name=amount]").keyup(function() {
        //  getFees();
        //  getPreview();
    });
    $("input[name=amount]").focusout(function() {
        // enterLimit();
    });
    // function getExchangeRate(event) {
    //     var element = event;
    //     var currencyCode = acceptVar().currencyCode;
    //     var currencyRate = acceptVar().currencyRate;
    //     var currencyMinAmount = acceptVar().currencyMinAmount;
    //     var currencyMaxAmount = acceptVar().currencyMaxAmount;
    //     $('.rate-show').html("1 " + defualCurrency + " = " + parseFloat(currencyRate).toFixed(2) + " " + currencyCode);
    // }
    // function getLimit() {
    //     var sender_currency = acceptVar().currencyCode;
    //     var sender_currency_rate = acceptVar().currencyRate;
    //     var min_limit = acceptVar().currencyMinAmount;
    //     var max_limit =acceptVar().currencyMaxAmount;
    //     if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
    //         var min_limit_calc = parseFloat(min_limit/sender_currency_rate).toFixed(2);
    //         var max_limit_clac = parseFloat(max_limit/sender_currency_rate).toFixed(2);
    //         // $('.limit-show').html("Limit " + min_limit_calc + " " + defualCurrency + " - " + max_limit_clac + " " + defualCurrency);
    //         return {
    //             minLimit:min_limit_calc,
    //             maxLimit:max_limit_clac,
    //         };
    //     }else {
    //         $('.limit-show').html("--");
    //         return {
    //             minLimit:0,
    //             maxLimit:0,
    //         };
    //     }
    // }
    // function enterLimit(){
    //     var sender_currency_rate = acceptVar().currencyRate;
    //     var min_limit = acceptVar().currencyMinAmount;
    //     var max_limit =acceptVar().currencyMaxAmount;
    //     if($.isNumeric(min_limit) || $.isNumeric(max_limit)) {
    //         var min_limit_calc = parseFloat(min_limit/sender_currency_rate).toFixed(2);
    //         var max_limit_clac = parseFloat(max_limit/sender_currency_rate).toFixed(2);

    //     }
    //     var sender_amount = parseFloat($("input[name=amount]").val());

    //     if( sender_amount < min_limit_calc ){
    //         throwMessage('error',["Please follow the mimimum limit"]);
    //         $('.sendBtn').attr('disabled',true)
    //     }else if(sender_amount > max_limit_clac){
    //         throwMessage('error',["Please follow the maximum limit"]);
    //         $('.sendBtn').attr('disabled',true)
    //     }else{
    //         $('.sendBtn').attr('disabled',false)
    //     }

    // }


    // function acceptVar() {
    //     var selectedVal = $("select[name=currency] :selected");
    //     var currencyCode = $("select[name=currency] :selected").attr("data-currency");
    //     var currencyRate = $("select[name=currency] :selected").attr("data-rate");
    //     var currencyMinAmount = $("select[name=currency] :selected").attr("data-min_amount");
    //     var currencyMaxAmount = $("select[name=currency] :selected").attr("data-max_amount");
    //     var currencyFixedCharge = $("select[name=currency] :selected").attr("data-fixed_charge");
    //     var currencyPercentCharge = $("select[name=currency] :selected").attr("data-percent_charge");

    //     return {
    //         currencyCode:currencyCode,
    //         currencyRate:currencyRate,
    //         currencyMinAmount:currencyMinAmount,
    //         currencyMaxAmount:currencyMaxAmount,
    //         currencyFixedCharge:currencyFixedCharge,
    //         currencyPercentCharge:currencyPercentCharge,
    //         selectedVal:selectedVal,

    //     };
    // }

    // function feesCalculation() {
    //     var sender_currency = acceptVar().currencyCode;
    //     var sender_currency_rate = acceptVar().currencyRate;
    //     var sender_amount = $("input[name=amount]").val();
    //     sender_amount == "" ? (sender_amount = 0) : (sender_amount = sender_amount);

    //     var fixed_charge = acceptVar().currencyFixedCharge;
    //     var percent_charge = acceptVar().currencyPercentCharge;
    //     if ($.isNumeric(percent_charge) && $.isNumeric(fixed_charge) && $.isNumeric(sender_amount)) {
    //         // Process Calculation
    //         var fixed_charge_calc = parseFloat(sender_currency_rate * fixed_charge);
    //         var percent_charge_calc = parseFloat(sender_currency_rate)*(parseFloat(sender_amount) / 100) * parseFloat(percent_charge);
    //         var total_charge = parseFloat(fixed_charge_calc) + parseFloat(percent_charge_calc);
    //         total_charge = parseFloat(total_charge).toFixed(2);
    //         // return total_charge;
    //         return {
    //             total: total_charge,
    //             fixed: fixed_charge_calc,
    //             percent: percent_charge,
    //         };
    //     } else {
    //         // return "--";
    //         return false;
    //     }
    // }

    // function getFees() {
    //     var sender_currency = acceptVar().currencyCode;
    //     var percent = acceptVar().currencyPercentCharge;
    //     var charges = feesCalculation();
    //     if (charges == false) {
    //         return false;
    //     }
    //     // $(".fees-show").html("Charge: " + parseFloat(charges.fixed).toFixed(2) + " " + sender_currency + " + " + parseFloat(charges.percent).toFixed(2) + "%" );
    // }
    // function getPreview() {
    //         var senderAmount = $("input[name=amount]").val();
    //         var sender_currency = acceptVar().currencyCode;
    //         var sender_currency_rate = acceptVar().currencyRate;
    //         // var receiver_currency = acceptVar().rCurrency;
    //         senderAmount == "" ? senderAmount = 0 : senderAmount = senderAmount;

    //         // Sending Amount
    //         $('.request-amount').text(senderAmount + " " + defualCurrency);

    //         // Fees
    //         var charges = feesCalculation();
    //         // console.log(total_charge + "--");
    //         $('.fees').text(charges.total + " " + sender_currency);

    //         var conversionAmount = senderAmount * sender_currency_rate;
    //         $('.conversionAmount').text(parseFloat(conversionAmount).toFixed(2) + " " + sender_currency);
    //         // will get amount
    //         // var willGet = parseFloat(senderAmount) - parseFloat(charges.total);
    //         var willGet = parseFloat(senderAmount).toFixed(2);
    //         $('.will-get').text(willGet + " " + defualCurrency);

    //         // Pay In Total
    //         var totalPay = parseFloat(senderAmount) * parseFloat(sender_currency_rate)
    //          var pay_in_total = parseFloat(charges.total) + parseFloat(totalPay);
    //         $('.pay-in-total').text(parseFloat(pay_in_total).toFixed(2) + " " + sender_currency);

    // }
</script>
@endpush