@component('mail::message')
# {{__("mail.Notify purchase")}}
<small>{{__("mail.OrderId")}}{{$order->id}}</small>

## {{__("mail.Buyer")}}
{{ $order->name_buyer }}

## {{__("mail.messageBuyer")}}
{{ $order->message }}

## {{__("mail.orderBuyer")}}
@foreach ($products as $product)
<strong>1x </strong>{{$product->title}} - <strong>{{__('Euro')}}{{$product->price}}</strong> <br>
@endforeach

{{__('Total price: ')}} <strong>{{__("Euro")}} {{$order->total}}</strong>
<br>
<br>
{{ config('app.name') }}
@endcomponent
