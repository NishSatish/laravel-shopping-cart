@extends('layouts.app')

@section('content')
<div class="form-section">
    @if ($error)
        <div id="charge-error" class="alert alert-danger {{ $error ? '' : 'd-none' }}">
            {{ $error }}
        </div>
        <a class="btn btn-success" href="/records">CONTINUE SHOPPING</a>
    @else
        <form id="payment-form">
            <div id="card-element">
            <!-- Elements will create input elements here -->
            </div>

            <!-- We'll put the error or success messages in this element -->
            <div id="card-errors" class="alert alert-danger hidden"></div>
            <div id="card-success" class="alert-success alert hidden"></div>

            <button id="submit" data-mami="{{ $client_secret }}" type="submit">Pay</button>
        </form>
    @endif
</div>
@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
