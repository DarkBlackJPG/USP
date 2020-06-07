@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 text-center text-white border-bottom border-light mb-5   ">
            <h1 >Dobrodosli na SHM-Auto online prodavnicu!</h1>
        </div>


        @if($success = Session::get('success_purchase'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Super!',
                    text: 'Uspesno ste kupili odabrane uredjaje!',
                    footer: "<a href='{{route('user_products')}}'>Pogledajte vase uredjaje</a>"
                })
            </script>
        @endif

        @if($success = Session::get('cancel_cart'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Uspesno prekinuta transakcija!',
                    text: 'Vasa korpa je sada prazna!',
                })
            </script>
        @endif
        @foreach($products as $product)
            <div class="card bg-info m-1 shadow" style="max-width: 18rem;">
                <img class="card-img-top img-fluid" style="max-height: 250px !important;" src="{{asset("img/$product->image")}}" alt="Card image cap">
                <hr>
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">Price: {{$product->price}}</p>
                    <p class="card-text">{{$product->description}}</p>
                    <p class="card-text">Left in stock: {{$product->in_stock}}</p>
                    <form action="/buy/{{$product->id}}" method="post">
                        @csrf
                        <button  class="btn btn-primary" @if($product->in_stock == 0) disabled @endif>Stavi u korpu</button>
                    </form>

                </div>
            </div>
        @endforeach
        @if(sizeof($products) == 0)
            <div class="card shadow" >
                <div class="card-header"><h1>Nema proizvoda na nasoj stranici</h1></div>
            </div>
        @endif
    </div>
</div>
@endsection
