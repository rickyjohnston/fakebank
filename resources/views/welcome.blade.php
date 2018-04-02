@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-4 flex-column justify-content-center align-items-center">
        <div class="font-heading display-4">
            Take it to the bank.
        </div>
        <div>
            Welcome to FakeBank. Just like a real bank, only fake. If you have a login, please click 'Login' above.
        </div>
    </div>
    <div class="row my-5">
        @component('card', ['title' => 'Safe'])
            @slot('icon')
                @icon('wallet', 'icon-md mx-auto mt-4 fill-dark')
            @endslot

            Feel confident knowing that your fake information is safe within a local database. It doesn't mean anything.
        @endcomponent
        @component('card', ['title' => 'Secure'])
            @slot('icon')
                @icon('lock-closed', 'icon-md mx-auto mt-4 fill-dark')
            @endslot

            Potentially the world's most secure bank. How do we do it? We don't exchange any currency whatsoever.
        @endcomponent
        @component('card', ['title' => 'Fake'])
            @slot('icon')
                @icon('thumbs-up', 'icon-md mx-auto mt-4 fill-dark')
            @endslot

            There's nothing real on this website whatsoever. In fact, many would argue, we're not even a bank.
        @endcomponent
    </div>

    <div class="row justify-content-center mb-5">
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                {{ __('Login') }}
            </a>
        @else
            <a href="{{ route('home') }}" class="btn btn-outline-primary btn-lg">
                {{ __('See Transaction List') }}
            </a>
        @endguest
    </div>
</div>
@endsection
