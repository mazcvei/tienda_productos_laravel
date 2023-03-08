<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;


/** All Paypal Details class **/


use Illuminate\Support\Facades\Config;
use Omnipay\Omnipay;
use Symfony\Component\Console\Input\Input;

class PayPalCardController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode(true); //set it to 'false' when go live
    }

    /**
     * Call a view.
     */
    public function index()
    {
        return view('payment');
    }

    /**
     * Initiate a payment on PayPal.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function charge(Request $request)
    {
        if ($request->input('submit'))
            $cartItems = Auth::user()->cartItems;

        if (count($cartItems) == 0) {
            return \redirect()->back()->with('warning', 'No tienes ningún elemento en el carrito.');
        }

        try {
            $amountCart = CartHelper::calcTotalAmount();
            $finalAmount = Auth::user()->credits < $amountCart ?
                $amountCart - Auth::user()->credits  :
                0;
            $user = User::find(Auth::id());
            if ($amountCart >= $user->credits){
                $user->credits  = 0;
            }else{
                $user->credits = $user->credits - $amountCart;
            }

            $user->save();

            if($finalAmount==0){
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'transaction' => null,
                    'total' => $finalAmount,
                    'pay' => 1,
                    'payment_id' => null,
                ]);
                $cartItems = Auth::user()->cartItems;
                foreach ($cartItems as $item) {
                    OrderDetail::create([
                        'product_id' => $item->product_id,
                        'order_id' => $order->id,
                        'quantity' => $item->quantity,
                    ]);
                    if ($item->product->user->rol->name == "usuario_registrado") {
                        $user = User::find($item->product->user->id);
                        $user->credits += ($item->product->price * $item->quantity) / 2;
                        $user->save();
                    }
                    $item->delete();
                }

                return redirect()->route('profile.edit')
                    ->with('success', 'Pedido realizado correctamente');

            }
            $response = $this->gateway->purchase(array(
                'amount' => $finalAmount,
                'currency' => env('PAYPAL_CURRENCY'),
                'returnUrl' => url('success'),
                'cancelUrl' => url('error'),
            ))->send();

            if ($response->isRedirect()) {
                $response->redirect(); // this will automatically forward the customer
            } else {
                // not successful
                return $response->getMessage();
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Charge a payment and store the transaction.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function success(Request $request)
    {
        // Once the transaction has been approved, we need to complete it.
        if ($request->input('paymentId') && $request->input('PayerID')) {
            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId'),
            ));
            $response = $transaction->send();

            if ($response->isSuccessful()) {
                // El cliente ha completado el pago
                $arr_body = $response->getData();
                // Inserta los datos de transaccion en la bd
                $payment = Payment::create([
                    'payment_id' => $arr_body['id'],
                    'payer_id' => $arr_body['payer']['payer_info']['payer_id'],
                    'payer_email' => $arr_body['payer']['payer_info']['email'],
                    'amount' => $arr_body['transactions'][0]['amount']['total'],
                    'currency' => env('PAYPAL_CURRENCY'),
                    'payment_status' => $arr_body['state'],
                ]);

                $order = Order::create([
                    'user_id' => Auth::id(),
                    'transaction' => $payment->payment_id,
                    'total' => $payment->amount,
                    'pay' => 1,
                    'payment_id' => $payment->id,
                ]);
                $cartItems = Auth::user()->cartItems;
                foreach ($cartItems as $item) {
                    OrderDetail::create([
                        'product_id' => $item->product_id,
                        'order_id' => $order->id,
                        'quantity' => $item->quantity,
                    ]);
                    if ($item->product->user->rol->name == "usuario_registrado") {
                        $user = User::find($item->product->user->id);
                        $user->credits += ($item->product->price * $item->quantity) / 2;
                        $user->save();
                    }
                    $item->delete();
                }

                return redirect()->route('profile.edit')
                    ->with('success', 'Pedido realizado correctamente');

            } else {
                return $response->getMessage();
            }
        } else {
            return redirect()->route('cart.index')->with('error', 'Pago cancelado.');
        }
    }

    /**
     * Error Handling.
     */
    public function error()
    {
        return route('cart.index')->with('error', 'Pago cancelado.');
    }


}
