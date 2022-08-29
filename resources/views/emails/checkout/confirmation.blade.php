@component('mail::message')
# {{__("mail.New order")}}
<small>{{__("mail.OrderId")}}{{$order->id}}</small>

## {{__("mail.message")}}
{{ $order->message }}

## {{__("mail.order")}}
@foreach ($products as $product)
<strong>1x </strong>{{$product->title}} - <strong>{{__('Euro')}}{{$product->price}}</strong> <br>
@endforeach

{{__('Total price: ')}} <strong>{{__("Euro")}} {{$order->total}}</strong>
<br>
<br>
{{__('Thanks,')}}<br>
{{ config('app.name') }}
@endcomponent
