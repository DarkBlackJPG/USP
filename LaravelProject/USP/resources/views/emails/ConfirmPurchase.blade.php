@component('mail::message')
# Successful purchase!<br><br>

----<br>
# Reciept<br><br>
@foreach($products as $product)
Price for product {{$product->name}} is {{$product->price}}. Amount ordered is {{$product->pivot->amount}}.
---- <br><br>
@endforeach
<br>
----<br>
Thank you for your purchase!<br> <br>
Sincerely,<br>
{{ config('app.name') }}
@endcomponent
