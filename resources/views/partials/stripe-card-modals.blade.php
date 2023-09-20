<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="modal fade" id="BuyCardModalStripe" tabindex="-1" aria-labelledby="buycard-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php
            $transactions = App\Models\Transaction::auth()->addMoney()->latest()->take(5)->get();
            $alreadyRequested = false;
            if ($transactions->count() > 0) {
                $alreadyRequested = true;
            }
            ?>
            <div class="modal-header" id="buycard-modal">
                <h4 class="modal-title">{{__("Add Card")}}</h4>
                <!-- credit card design here -->
                <div class="card">
                    <!-- Card Front -->
                    <div class="card-front">
                        <div class="card-logo">
                            <!-- Your card logo image here -->
                            <img src="{{asset('public/frontend/images/element/card.png')}}" alt="Card Logo">
                        </div>
                        <div class="card-number">
                            <!-- Your card number here -->
                            <p>1234 5678 9012 3456</p>
                        </div>
                        <div class="card-holder">
                            <!-- Cardholder's name here -->
                            <p>John Doe</p>
                        </div>
                        <div class="card-expiry">
                            <!-- Expiry date here -->
                            <p>12/24</p>
                        </div>
                    </div>
                    <!-- Card Back -->
                    <div class="card-back">
                        <div class="card-cvv">
                            <!-- CVV here -->
                            <p>123</p>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="las la-times"></i></button>
            </div>
            @if($alreadyRequested == true)
            <div class="modal-body stripe-modal">
                <a href="{{ setRoute('user.add.money.index') }}" class="btn btn--base w-100 btn-loading buyBtn">{{ __("Confirm") }}</a>
            </div>
            @else
            <div class="modal-body stripe-modal">
                <div class="alert alert-danger">
                    <p class="mb-0">{{__("You have already requested for a card. Please wait for approval.")}}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Modal
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@push('script')
<script>
    var defualCurrency = "{{ get_default_currency_code() }}";
    var defualCurrencyRate = "{{ get_default_currency_rate() }}";
    $('.buyCard-stripe').on('click', function() {
        var modal = $('#BuyCardModalStripe');

        modal.modal('show');
    });
</script>
@endpush