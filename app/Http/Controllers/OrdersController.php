<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class OrdersController extends Controller
{
    public function index() {
        $orders = Auth::user()->orders;

        $orders->transform(function($order, $key) {
            $order->cart = unserialize($order->cart);
            return $order;
        });

        return view('pages.orders.orders')->with('orders', $orders);
    }
}
