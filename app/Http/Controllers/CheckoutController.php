<?php

namespace App\Http\Controllers;

use App\Mail\sendCheckoutMail;
use App\Mail\sendNotifyParentsMail;
use App\Models\Babylist;
use App\Models\Order;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Laravel\Facades\Mollie;

class CheckoutController extends Controller
{
    //
    
    public function checkout(Request $r){
        
        $r->validate([
            'name' => 'required|max:255',
            'list_id' => 'required|exists:babylists,id',
        ]);

        $arr=[];
        foreach($r->productID as $id){
            array_push($arr,$id);
        }
        $products = serialize($arr);

        $productItems = Product::whereIn('id', $arr)->get();
        $babylist = Babylist::where('id', $r->list_id)->first();
       
        $cart = Cart::session(1);
        $total = $cart->getTotal();
        
        $order = new Order();
        $order->name_buyer = $r->name;
        $order->message = $r->message;
        $order->total = $total;
        $order->email = $r->email;
        $order->list_id = $r->list_id;
        $order->products = $products;
        
        $order->save();

        $webhookUrl = route('webhooks.mollie');

        if(App::environment('local')){
            $webhookUrl = 'https://470b-62-238-227-45.eu.ngrok.io/webhooks/mollie';
        }

        Log::alert('Before Mollie Checkout, total price is calculated');


        $total = number_format($total,2);

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "EUR",
                "value" => $total // You must send the correct number of decimals, thus we enforce the use of strings
            ],
            "description" => "Bestelling op " . date('d-m-Y h:i'),
            "redirectUrl" => route('checkout.success'),
            "webhookUrl" => $webhookUrl,
            "metadata" => [
                "order_id" => $order->id,
                "order_from" => $order->name_buyer
            ],
        ]);
        
        $user = $babylist->user->email;
        $recipient = $order->email;
        //Mail to Buyer
        Mail::to($recipient)->send(new sendCheckoutMail($order,$productItems));
        //Mail to creator of list
        Mail::to($user)->send(new sendNotifyParentsMail($order, $productItems));
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function success(){
        
        //clear the cart
        Cart::session(1)->Clear();

        return view('order-success');
    }
    
}
