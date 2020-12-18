@extends('oppwa::layouts.app')

@section('pageTitle', 'Checkout')

@section('merchant_name', $integration['merchant_name'])

@section('merchant_logo', $integration['merchant_logo'])



@section('content')
<div class="col-md-12">
    <div class="card card-blue p-3 text-white mb-3">
        <span>Processing payment for <span class="yellow decoration">{{ $response['entity_number'] }}</span></span>
        <div class="d-flex flex-row align-items-end mb-3">
            <h1 class="mb-0 yellow">Total Amount: {{ htmlspecialchars($response['amount_formatted']) }}</h1>
        </div>
    </div>
</div>
<div class="col-md-12 mt-5">
    <!-- <div class="mb-4">
        <h2>Confirm order and pay</h2> <span>please make the payment, after that you can enjoy all the features and benefits.</span>
    </div> -->
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <!-- <form class="form-card" id="billing-details">
                <div class="mt-4 mb-4">
                    <h6 class="text-uppercase">Billing Address</h6>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="inputbox mt-3 mr-2"> <input type="text" value="{{ $response['customer_billing_address1'] }}" name="name" class="form-control" required="required"> <span>Street Address</span> </div>
                        </div>
                        <div class="col-md-6">
                            <div class="inputbox mt-3 mr-2"> <input type="text" value="{{ $response['customer_billing_city'] }}" name="name" class="form-control" required="required"> <span>City</span> </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="inputbox mt-3 mr-2"> <input type="text" value="{{ $response['customer_billing_address1'] }}" name="name" class="form-control" required="required"> <span>State/Province</span> </div>
                        </div>
                        <div class="col-md-6">
                            <div class="inputbox mt-3 mr-2"> <input type="text" value="{{ $response['customer_billing_zip'] }}" name="name" class="form-control" required="required"> <span>Zip code</span> </div>
                        </div>
                    </div>
                </div>
                </form> -->
                <h6 class="text-uppercase">Payment details</h6>
                <form action="{{$response['shopperResultUrl']}}" id="card-details" class="paymentWidgets" data-brands="{{ $response['payment_type_selected'] }}"></form>
<!--
                <div id="card_220921339056" class="wpwl-container wpwl-container-card">
                    <form id="card-details" class="paymentWidgets" class="wpwl-form wpwl-form-card wpwl-clearfix"
                        action="{{$response['shopperResultUrl']}}" method="POST" target="cnpIframe" lang="en">
                        <div class="wpwl-group wpwl-group-brand wpwl-clearfix">
                            <div class="wpwl-label wpwl-label-brand">Brand</div>
                            <div class="wpwl-wrapper wpwl-wrapper-brand">
                                <select class="wpwl-control wpwl-control-brand" name="paymentBrand">
                                    <option value="{{ $response['payment_type_selected'] }}">{{ $response['payment_type_selected'] }}</option>
                                </select>
                            </div>
                            <div class="wpwl-brand wpwl-brand-card wpwl-brand-MASTER"></div>
                        </div>
                        <div class="wpwl-group wpwl-group-cardNumber wpwl-clearfix">
                            <div class="wpwl-label wpwl-label-cardNumber">Card Number</div>
                            <div class="wpwl-wrapper wpwl-wrapper-cardNumber">
                                <input autocomplete="off" type="tel" name="card.number" class="wpwl-control wpwl-control-cardNumber" placeholder="Card Number">
                            </div>a
                        </div>
                        <div class="wpwl-group wpwl-group-expiry wpwl-clearfix">
                            <div class="wpwl-label wpwl-label-expiry">Expiry Date</div>
                            <div class="wpwl-wrapper wpwl-wrapper-expiry">
                                <input autocomplete="off" type="tel" name="card.expiry"b class="wpwl-control wpwl-control-expiry" placeholder="MM / YY">
                            </div>
                        </div>
                        <div class="wpwl-group wpwl-group-cardHolder wpwl-clearfix">
                            <div class="wpwl-label wpwl-label-cardHolder">Card holder</div>
                            <div class="wpwl-wrapper wpwl-wrapper-cardHolder">
                                <input autocomplete="off" type="text" name="card.holder" class="wpwl-control wpwl-control-cardHolder" placeholder="Card holder">
                            </div>
                        </div>
                        <div class="wpwl-group wpwl-group-cvv wpwl-clearfix">
                            <div class="wpwl-label wpwl-label-cvv">CVV</div>
                            <div class="wpwl-wrapper wpwl-wrapper-cvv">
                                <input autocomplete="off" type="tel" name="card.cvv" class="wpwl-control wpwl-control-cvv" placeholder="CVV">
                            </div>
                        </div>
                        <div class="wpwl-group wpwl-group-submit wpwl-clearfix">
                            <div class="wpwl-wrapper wpwl-wrapper-submit">
                                <button type="submit" name="pay" class="wpwl-button wpwl-button-pay">Pay now</button>
                            </div>
                        </div>
                        <input type="hidden" name="shopperResultUrl" value="{{$response['shopperResultUrl']}}">
                        <input type="hidden" name="card.expiryMonth" value="">
                        <input type="hidden" name="card.expiryYear" value="">
                    </form>
                </div> -->
            </div>
            <!-- <div class="mt-4 mb-4 d-flex justify-content-between"> <span>Previous step</span> <button class="btn btn-success px-3">Pay $840</button> </div> -->
        </div>
    </div>
</div>
@endsection

@section('js')
    <script type="text/javascript">
    var checkoutId = '{{ $response['id'] }}'
    </script>

    <script src="https://test.oppwa.com/v1/paymentWidgets.js?checkoutId={{ $response['id'] }}"></script>
@endsection
