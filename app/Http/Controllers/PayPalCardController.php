<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/

use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\Input;

class PayPalCardController extends Controller
{
    private $_api_context;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** PayPal api context **/
        $paypal_conf =  config('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
                $paypal_conf['client_id'],
                $paypal_conf['secret'])
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    public function payWithpaypal(Request $request)
    {

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item_1 = new Item();

        $item_1->setName('Compra Mercadovico')/** AQUI DESCRIPCION DE LA COMPRA **/
        ->setCurrency('EUR')
            ->setQuantity(1)
            ->setPrice(session()->get('amount'));
        /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('EUR')
            ->setTotal(500);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Compra mercadovico1');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(URL::to('/'))/** Specify return URL **/
        ->setCancelUrl(URL::to('/'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/


        try {

            $payment->create($this->_api_context);

        } catch (\PayPal\Exception\PPConnectionException $ex) {

            if (Config::get('app.debug')) {

                Session::put('error', 'Connection timeout');
                return Redirect::to('/');

            } else {

                Session::put('error', 'Some error occur, sorry for inconvenient');
                return Redirect::to('/'); //hacer pagina de error

            }

        }

        foreach ($payment->getLinks() as $link) {

            if ($link->getRel() == 'approval_url') {

                $redirect_url = $link->getHref();
                break;

            }

        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            return Redirect::away($redirect_url);

        }

        Session::put('error', 'Unknown error occurred');
        return Redirect::to('/');

    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');

        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            Session::put('error', 'Payment failed');
            return Redirect::to('/');

        }

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        if ($result->getState() == 'approved') { // se ejecuta si pago correcto ->registro pedido bbdd y return
            Log::info("Pago ok, almacenando bd");
            /*
            $date = Carbon::now();
            $date = $date->format('d-M-Y h:i:s');
            $pedido = new Pedidos;
            $componentes = "";
            foreach (session()->get('componentes') as $nombre => $precio) {
                $componentes .= $nombre . ": " . $precio . "€. ";
            }

            $pedido->descripcionPedido = "Servicio: " . session('modelo') . " - Componentes: " . $componentes;
            $pedido->direccion = session()->get('direccion');
            $pedido->movil = session()->get('movil');
            $pedido->precio = session()->get('amount');
            $pedido->pagado = 1;
            $pedido->usuario = session()->get('idusuario');
            $pedido->email = session()->get('email');
            $pedido->realizado = $date;
            $pedido->comentarios = session()->get('comentarios');
            $pedido->estado = "Verificando el pago";

            $pedido->save();
            session(['referencia' => $pedido->idPedido]);
            $usuario = Usuarios::find(session()->get('idusuario'));
            $usuario->puntos = ($usuario->puntos)+round(session()->get('amount'));
            $usuario->save();

            if (session('puntoscanjeados') == 1) {
                $usuario = Usuarios::find(session()->get('idusuario'));
                $usuario->puntos = $usuario->puntos - 150;
                $usuario->save();
                session()->forget('puntoscanjeados');
            }

            if (session('codigoverificado') == 1) {
                //  dd(session()->get('codigousado'));
                $codigo = Codigos::find(session()->get('codigousado'));

                $codigo->usado = 1;
                $codigo->usuario_id = session()->get('idusuario');
                $codigo->save();
                session()->forget('codigousado');
                session()->forget('puntoscanjeados');
                session()->forget('codigoverificado');

            }

            $this->sendEmailOrder();
            session()->forget('referencia');
            session()->forget('componentes');
            session()->forget('precio');
            session()->forget('comentarios');
            session()->forget('direccion');
            session()->forget('modelo');
            session()->forget('precio');
            session()->forget('a_resumen_pedido');
            */

            //\Session::put('success', 'Payment success');
            session(['mensaje' => "Pedido realizado correctamente, accede al área cliente para consultar el estado."]);
            return redirect('/');
        }

        Session::put('error', 'Pago fallido');
        return Redirect::to('/');

    }


}
