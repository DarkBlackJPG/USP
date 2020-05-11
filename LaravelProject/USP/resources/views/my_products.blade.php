@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @foreach($products as $product)
                <div class="card m-1 shadow" style="max-width: 18rem;">
                    <img class="card-img-top img-fluid" style="max-height: 250px !important;" src="{{asset("img/$product->image")}}" alt="Card image cap">
                    <hr>
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">Price: {{$product->price}}</p>
                    </div>
                </div>
            @endforeach
            @if(sizeof($products) == 0)
                <div class="card shadow" >
                    <div class="card-header"><h1>You have no products on your name</h1></div>
                </div>
            @endif
        </div>
    </div>
@endsection
