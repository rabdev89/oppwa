@extends('oppwa::layouts.app')

@section('pageTitle', 'Select Card')

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
<div class='col-md-12'>
  <div class="info row">
    <h4>Select your card brand</h4>

  </div>
  <ul class="integration-list">
    @foreach($paymentTypes as $types)
    <li class="integration-list-item">
      <a href="/checkout/{{ $types['payment_brand'] }}?{{ $url }}" class="integration-list-item-link">
        <div class="title-container">
          <p class="integration-list-item-title" >
          <img src="{{ $types['logo'] }}" title="{{ $types['payment_brand'] }}" alt="{{ $types['payment_brand'] }}"/>
          </p>
        </div>
      </a>
    </li>
    @endforeach
  </ul>
</div>
@endsection


@section('css')
<style>
body {
  background-color: #eee;
}
/* Index page */
a {
    text-decoration: none;
}
.main-container {
  margin: auto;
  max-width: 1048px;
  padding: 0 16px;
  display: flex;
  flex-direction: column;
}

.integration-list {
  display: flex;
  margin-top: 6%;
  max-width: 1048px;
  flex-wrap: wrap;
  justify-content: space-between;
  list-style: none;
  margin: 0;
  padding: 0;
}

@media (min-width: 768px) {
  .integration-list {
    margin-left: -8px;
    margin-bottom: -8px;
    margin-right: -8px;
  }
}

@media (min-width: 1024px) {
  .integration-list {
    margin-left: -16px;
    margin-bottom: -16px;
    margin-right: -16px;
  }
}

.integration-list-item {
  background: #FFF;
  border-radius: 6px;
  flex: 1 1 0;
  margin: 4px;
  min-width: 40%;
  position: relative;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 1px solid #f7f8f9;
}

.integration-list-item:hover {
  /* box-shadow: 0 16px 24px 0 #e5eaef; */
  text-decoration: none;
  border: 1px solid #06f;
}

@media (min-width: 768px) {
  .integration-list-item {
    margin-left: 16px;
    margin-bottom: 16px;
    margin-right: 16px;
    margin-top: 16px;
    min-width: 25%;
  }
}

.integration-list-item-link {
  padding: 20px;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

@media (min-width: 768px) {
  .integration-list-item-link {
    padding-left: 28px;
    padding-bottom: 28px;
    padding-right: 28px;
    padding-top: 28px;
  }
}

.integration-list-item-title {
  margin: 0;
  text-align: center;
  color: #FFF;
  font-size: 1em;
  font-weight: 700;
  margin: 10px 0 0;
}

@media (min-width: 768px) {
  .integration-list-item-title {
    font-size: 24px;
    margin-left: 0;
    margin-bottom: 6px;
    margin-right: 0;
  }
}

.integration-list-item-subtitle {
  color: #FFF;
  font-size: 0.67em;
  font-weight: 700;
  margin: 10px 0 0;
}

@media (min-width: 768px) {
  .integration-list-item-subtitle {
    font-size: 16px;
    margin-left: 0;
    margin-bottom: 6px;
    margin-right: 0;
  }
}

.title-container {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.info {
  margin-top: 10%;
  color: #333;
}

.title-container img{
    width: 100%;
}

/* end Index page */

</style>
@endsection
