@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if($success = Session::get('success_purchase'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'You have successfully purchased the item!',
                    text: 'Congratulations!',
                    footer: "<a href='{{route('user_products')}}'>Go to your purchased items</a>"
                })
            </script>
        @endif
        @foreach($products as $product)
            <div class="card m-1 shadow" style="max-width: 18rem;">
                <img class="card-img-top img-fluid" style="max-height: 250px !important;" src="{{asset("img/$product->image")}}" alt="Card image cap">
                <hr>
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">Price: {{$product->price}}</p>
                    <p class="card-text">Left in stock: {{$product->in_stock}}</p>
                    <form action="/buy/{{$product->id}}" method="post">
                        @csrf
                        <button  class="btn btn-primary" @if($product->in_stock == 0) disabled @endif>Buy</button>
                    </form>

                </div>
            </div>
        @endforeach
        @if(sizeof($products) == 0)
            <div class="card shadow" >
                <div class="card-header"><h1>There are no products</h1></div>
            </div>
        @endif
    </div>
</div>
@endsection
