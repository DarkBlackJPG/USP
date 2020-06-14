@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card bg-info">
                <div class="card-header">{{ __('Potvrdite e-mail adresu') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Novi link za verifikaciju je poslat na Vašu adresu.') }}
                        </div>
                    @endif

                    {{ __('Pre nego što nastavite potvrdite svoj e-mail putem linka koji smo Vam poslali na istu.') }}
                    {{ __('Niste dobili poruku?') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Pošalji novu poruku') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
