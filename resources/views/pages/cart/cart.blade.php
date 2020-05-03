@extends('layouts.app')

@section('content')
    <div class="cart-section">
        @if ($doesCartExist)
            <h1 class="page-header">Your cart</h1>

            @foreach ($products as $product)
                <div class="card" style="color: #3e3636;">
                    <div class="card-body">
                        <div class="card-title">
                            {{ $product['item']['name'] }} <span class="badge badge-primary" style="float: right; margin-top: 7px;">{{ $product['qty'] }}</span>
                            <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" style="float: right;"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="/atc/increase/{{ $product['item']['id'] }}" class="reducer">Increase</a></li>
                                @if ($product['qty'] > 0)
                                <li><a href="/atc/decrease/{{ $product['item']['id'] }}" class="reducer">Reduce</a></li>
                                @endif
                                <li><a href="/atc/remove/{{ $product['item']['id'] }}" class="remover">Remove</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row text-center" style="margin-top: 40px;">
                <div class="col-lg">
                    <h2>Total Price: ${{ $totalPrice }}</h2>
                </div>

                <div class="col-lg">
                    <h2>Total Quantity: {{ $totalQuantity }}</h2>
                </div>
            </div>
            <div class="row text-center" style="margin-top: 50px;">
                <div class="col-xs">
                    <a href="/records" class="btn btn-primary">CONTINUE SHOPPING</a>
                </div>
                <div class="col-xs">
                    @if (Session::has('cart'))
                    <a href="/checkout" class="btn btn-success {{ $totalQuantity > 0 ? '' : 'disabled' }}">CHECKOUT</a>
                    @endif
                </div>
            </div>
        @else
            <h1 class="page-header">Nothing yet</h1>
        @endif
    </div>
@endsection
