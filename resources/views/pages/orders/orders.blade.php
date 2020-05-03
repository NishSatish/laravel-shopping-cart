@extends('layouts.app')

@section('content')
<div class="orders-section">
    <h1 class="page-header">Your orders</h1>

    @foreach ($orders as $order)
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Order on: {{ $order->created_at }}
            </div>
            <ul class="list-group">
                @foreach ($order->cart->items as $item)
                <li class="list-group-item">
                    {{ $item['item']['name'] }} <span class="badge badge-primary float-right">{{ $item['qty'] }}</span>
                    ${{ $item['price'] }}
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach

</div>
@endsection
