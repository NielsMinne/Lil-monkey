<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendNotifyParentsMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order, $productItems)
    {
        $this->order = $order;
        $this->products= $productItems;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Er zijn producten van uw lijst gekocht')->markdown('emails.checkout.notification' ,[
            'order' => $this->order,
            'products' => $this->products
        ]);
    }
}
