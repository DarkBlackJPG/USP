@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @if(sizeof($products) == 0)
                <div class="card shadow mt-5 mb-5" >
                    <div class="card-body font-weight-bolder">
                        <p style="font-size: xx-large;">{{__('Nemate proizvoda na Vaše ime')}}</p>
                    </div>
                </div>
            @endif
            @foreach($products as $product)
                <div class="card bg-info m-1 shadow" style="max-width: 18rem;">
                    <img class="card-img-top img-fluid" style="max-height: 250px !important;"
                         src="{{asset("img/$product->image")}}" alt="Card image cap">
                    <hr>
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{__('Cena: ')}}{{$product->price}}{{__('$')}}</p>
                        <p class="card-text">{{__('Broj proizvoda: ')}}{{$product->pivot->amount}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
