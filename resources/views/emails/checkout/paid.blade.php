@component('mail::message')
# {{__("mail.paid")}}
<small>{{__("mail.OrderId")}}{{$order->id}}</small>

{{__('Total price: ')}} <strong>{{__("Euro")}} {{$order->total}}</strong>
<br>
<br>
{{__('Thanks,')}}<br>
{{ config('app.name') }}
@endcomponent
