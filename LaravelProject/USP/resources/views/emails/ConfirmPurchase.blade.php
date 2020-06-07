@component('mail::message')
# Successful purchase!

----
# Reciept
@foreach($products as $product)
Price for product {{$product->name}} is {{$product->price}}.
----
@endforeach
----
Thanks,<br>
{{ config('app.name') }}
@endcomponent
