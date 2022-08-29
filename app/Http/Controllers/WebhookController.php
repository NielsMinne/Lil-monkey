<?php

namespace App\Http\Controllers;

use App\Mail\sendPaidMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Mollie\Laravel\Facades\Mollie;

class WebhookController extends Controller
{
    public function handle(Request $request) {
        if (! $request->has('id')) {
            return;
        }

        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid() && !$payment->hasRefunds() && !$payment->hasChargebacks()) {

            $orderId = $payment->metadata->order_id;
            $order = Order::findOrFail($orderId);
            $order->status = 'paid';
            $order->save();

            $recipient = $order->email;
            Mail::to($recipient)->send(new sendPaidMail($order));
            
            Log::alert('De betaling is gelukt');
        }
    }
}
