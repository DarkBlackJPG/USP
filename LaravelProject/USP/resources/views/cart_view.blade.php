@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron-fluid text-center text-white">
            <h1>Vasa korpa</h1>
        </div>
        <div class="row justify-content-center">
            @foreach($products as $product)
                <div class="card bg-info m-1 shadow" style="max-width: 18rem;">
                    <img class="card-img-top img-fluid" style="max-height: 250px !important;" src="{{asset("img/$product->image")}}" alt="Card image cap">
                    <hr>
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">Price: {{$product->price}}</p>
                    </div>
                </div>
            @endforeach
            @if(sizeof($products) == 0)
                <div class="card bg-info shadow" >
                    <div class="card-header"><h1>Prazna korpa</h1></div>
                </div>
            @endif
        </div>
        @if(sizeof($products) > 0)
            <div class="col-12 justify-content-center text-center mt-5">
                <form method="post" style="display: inline" action="{{route('cart.buyAll', auth()->user()->id)}}">
                    @csrf
                    <button type="submit" class="btn btn-primary">Potvrdi kupovinu</button>
                </form>
                <form method="post"  style="display: inline"  action="{{route('cart.cancel',  auth()->user()->id)}}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Odbaci kupovinu</button>
                </form>

            </div>

        @endif
    </div>
@endsection
