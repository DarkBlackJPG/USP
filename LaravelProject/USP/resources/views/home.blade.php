@extends('layouts.app')
@section('head')
    <script src="./src/bootstrap-input-spinner.js"></script>
    <script>
        $("input[type='number']").inputSpinner()
    </script>
@endsection
@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 text-center text-white mt-2">
            <h1 >Dobrodošli na SHM-Auto online prodavnicu!</h1>
            <hr color="darkorange">
        </div>


        @if($success = Session::get('success_purchase'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Uspeh!',
                    text: 'Uspešno ste kupili odabrane uređaje!',
                    footer: "<a href='{{route('user_products')}}'>Pogledajte vaše uređaje</a>"
                })
            </script>
        @elseif ($success = Session::get('success_purchase_item'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Uspeh!',
                    text: 'Uspešno kupljen izabran proizvod!',
                    footer: "<a href='{{route('user_products')}}'>Pogledajte Vaše uređaje</a>"
                })
            </script>
        @elseif ($success = Session::get('cancel_cart'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Uspešno prekinuta transakcija!',
                    text: 'Vaša korpa je sada prazna!',
                })
            </script>
        @elseif ($success = Session::get('place_in_cart'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Uspeh!',
                    text: 'Proizvodi stavljeni u korpu!',
                    footer: "<a href='{{route('cart.show', ['id'=>Auth::id()])}}'>Pogledajte Vašu korpu</a>"
                })
            </script>
        @endif
        @php($i = 0)
        @foreach($products as $product)
            @php($i++)
            <div class="card bg-info m-1 shadow" style="max-width: 18rem;">
                <img class="card-img-top img-fluid" style="max-height: 250px !important;" src="{{asset("img/$product->image")}}" alt="Card image cap">
                <hr>
                <div class="card-body">
                    <h5 class="card-title">{{$product->name}}</h5>
                    <p class="card-text">{{_('Cena: ')}}{{$product->price}}{{__('$')}}</p>
                    <p class="card-text">{{$product->description}}</p>
                    <p class="card-text">{{__('Trenutno na lageru: ')}}<b>{{$product->in_stock}}</b></p>

                    <form action="/buy" method="post">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        @csrf
                        <p class="card-text">{{__('Izabrano komada: ')}}
                            <input id="buy" name="buy" type="number" value="0" min="0" max="{{$product->in_stock}}" step="1"/>
                            <input id="id" name="id" type="hidden" value="{{$product->id}}"/>
                        </p>
                        <button  class="submit btn btn-primary border-bottom-0 @if($product->in_stock == 0) disabled @endif">
                            {{__('Stavi u korpu')}}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
        @if(sizeof($products) == 0)
            <br> <br> <br> <br> <br> <br> <br> <br>
            <div class="card shadow mt-5" >
                <div class="card-header">
                    <h1>{{__('Nema proizvoda na našoj stranici')}}</h1>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
