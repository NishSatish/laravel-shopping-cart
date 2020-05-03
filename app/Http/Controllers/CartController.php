<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Item;
use App\Cart;
use App\Order;

use Session;
use Auth;

class CartController extends Controller
{
    public $payment_id = null;
    public $copier = null;

    public function __construct() {
        $this->middleware('auth')->except('logout');
        \Stripe\Stripe::setApiKey(env('STRIPE_API_KEY', ''));
    }

    public function store(Request $request, $id) {
        $item = Item::find($id);
        $existingCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($existingCart);

        $cart->add($item, $item->id);
        $request->session()->put('cart', $cart);
        return redirect()->action('ItemsController@index');
    }

    public function showCart() {
        $doesCartExist = true;
        if (Session::has('cart')) {
            $oldCart = Session::get('cart');
            $cart = new Cart($oldCart);

            $arrayOfVars = array(
                'products' => $cart->items,
                'totalPrice' => $cart->totalPrice,
                'totalQuantity' => $cart->totalQuantity,
                'doesCartExist' => $doesCartExist
            );
        }

        if (!Session::has('cart')) {
            $doesCartExist  = false;

            $arrayOfVars = array(
                'products' => null,
                'totalPrice' => null,
                'totalQuantity' => null,
                'doesCartExist' => $doesCartExist
            );
        }
        return view('pages.cart.cart')->with($arrayOfVars);
    }

    // ---------------------------------CART MODIFICATION---------------------------------
    public function increaseItem($id) {
        $item = Item::find($id);
        $existingCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($existingCart);

        $cart->add($item, $item->id);
        Session::put('cart', $cart);
        return redirect()->action('CartController@showCart');
    }

    public function decreaseItem($id) {
        $reqdItem = Item::find($id);
        $existingCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($existingCart);

        $cart->reduce($reqdItem, $reqdItem->id);
        Session::put('cart', $cart);
        return redirect()->action('CartController@showCart');
    }

    public function removeItem($id) {
        $reqdItem = Item::find($id);
        $existingCart = Session::has('cart') ? Session::get('cart') : null;
        $cart = new Cart($existingCart);

        $cart->remove($id);
        Session::put('cart', $cart);
        return redirect()->action('CartController@showCart');
    }

    // ---------------------------------CHECKOUT AND PAYMENT---------------------------------

    public function checkout(){
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
        $total = $cart->totalPrice;

        $error = '';

        //  STRIPE PAYMENT INITIATION
        try {
            $intent = \Stripe\PaymentIntent::create([
                'amount' => $total,
                'currency' => 'inr',
                'metadata' => ['integration_check' => 'accept_a_payment'],
            ]);
            $this->payment_id = $intent->id;

        } catch (\Stripe\Exception\CardException $e) {
            $error = $e->getError()->message;
        } catch (\Stripe\Exception\RateLimitException $e) {
            $error = 'Too many requests made to the API too quickly';

        } catch (\Stripe\Exception\InvalidRequestException $e) {
            $error = 'No orders below INR 0.5 are accepted';

        } catch (\Stripe\Exception\AuthenticationException $e) {
            $error = 'Authentication with API failed; Contact developer';

        } catch (\Stripe\Exception\ApiConnectionException $e) {
            $error = 'Network communication with Stripe failed; Contact support';

        } catch (\Stripe\Exception\ApiErrorException $e) {
            $error = 'Error with the API; Contact shoppy support';

        } catch (Exception $e) {
            $error = 'Uknown Error; Try again later';
        }
        // STRIPE PAYMENT INITIATION COMPLETED

        if($error) {
            $arrayOfVars = array(
                'error' => $error,
                'client_secret' => null
            );
        }
        if (!$error) {
            $arrayOfVars = array(
                'error' => null,
                'client_secret' => $intent->client_secret
            );
        }
        return view('pages.cart.checkout')->with($arrayOfVars);
    }

    public function postCheckout(Request $request) {
        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);

        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->name = Auth::user()->name;
        $order->address = Auth::user()->address;
        $order->cart = serialize($cart);
        $order->save();

        return redirect()->action('OrdersController@index');
    }
}
