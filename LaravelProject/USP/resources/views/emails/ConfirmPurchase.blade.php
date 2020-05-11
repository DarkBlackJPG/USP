@component('mail::message')
# Successful purchase!

You have successfully purchased {{$product->name}}.

----
# Reciept

The price is {{$product->price}}.
----
Thanks,<br>
{{ config('app.name') }}
@endcomponent
