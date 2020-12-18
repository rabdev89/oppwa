@extends('oppwa::layouts.app')

@section('pageTitle', 'Response Message')

@section('merchant_name', $integration['merchant_name'])

@section('merchant_logo', $integration['merchant_logo'])

@section('content')
<div class="col-md-12 text-center">
    <div class="card card-blue p-3 text-white mb-3">
        <span>Processing payment for <span class="yellow decoration">{{ $response['entity_number'] }}</span></span>
        <div class="d-flex flex-row align-items-end mb-3">
            <h1 class="mb-0 yellow">Total Amount: {{ htmlspecialchars($response['amount_formatted']) }}</h1>
        </div>
    </div>
</div>
<div class="col-md-12 mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">

                <h6 class="text-uppercase">{{ $response['response']->result->description }}</h6>

            </div>
        </div>
    </div>
</div>

@endsection

@section('js')


@endsection

@section('css')

@endsection
