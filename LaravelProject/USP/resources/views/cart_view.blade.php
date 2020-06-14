@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="jumbotron-fluid text-center text-white">
            <h1>Vaša korpa</h1>
        </div>
        @if($success = Session::get('cancel_product'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Uspeh!',
                    text: 'Uspešno ste otkazali kupovinu odabranih uređaja!'
                })
            </script>
        @endif
        <div class="row justify-content-center">
            @foreach($products as $product)
                <div class="card bg-info m-1 shadow" style="max-width: 18rem;">
                    <img class="card-img-top img-fluid" style="max-height: 250px !important;" src="{{asset("img/$product->image")}}" alt="Card image cap">
                    <hr>
                    <div class="card-body">
                        <h5 class="card-title">{{$product->name}}</h5>
                        <p class="card-text">{{__('Cena: ')}}{{$product->price}}{{__('$')}}</p>
                        <p class="card-text">{{__('Izabrano komada: ')}}{{$product->pivot->amount}}</p>
                        <form action="/cancel" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @csrf
                            <p class="card-text">{{__('Za izbacivanje: ')}}
                                <input id="amount" name="amount" type="number" value="{{$product->pivot->amount}}" min="0" max="{{$product->pivot->amount}}" step="1"/>
                                <input id="id" name="id" type="hidden" value="{{$product->id}}"/>
                            </p>
                            <button  class="submit btn btn-danger border-bottom-0">
                                {{__('Izbaci iz korpe')}}
                            </button>
                        </form>
                        <form action="{{route('item.buy')}}" class="pt-3 justify-content-end" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            @csrf
                            <p class="card-text">{{__('Za kupovinu: ')}}
                                <input id="amount" name="amount" type="number" value="{{$product->pivot->amount}}" min="0" max="{{$product->pivot->amount}}" step="1"/>
                                <input id="id" name="id" type="hidden" value="{{$product->id}}"/>
                            </p>
                            <button  class="submit btn btn-primary border-bottom-0">
                                {{__('Kupi')}}
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            @if(sizeof($products) == 0)

                <div class="card bg-info shadow mt-5" >
                    <div class="card-header"><h1>{{__('Prazna korpa')}}</h1></div>
                </div>
            @endif
        </div>

        @if(sizeof($products) > 0)
            <div class="col-12 justify-content-center text-center mt-5">
                <form method="post" style="display: inline" action="{{route('cart.buyAll', Auth::id())}}">
                    @csrf
                    <button type="submit" class="btn btn-primary">{{__('Potvrdi kupovinu')}}</button>
                </form>
                <form method="post"  style="display: inline"  action="{{route('cart.cancel', Auth::id())}}">
                    @csrf
                    <button type="submit" class="btn btn-danger">{{__('Odustani od kupovine')}}</button>
                </form>

            </div>

        @endif
    </div>
@endsection
