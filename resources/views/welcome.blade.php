@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row flex-column justify-content-center align-items-center">
        <h1 class="title m-b-md">
            {{ config('app.name', 'Laravel') }}
        </h1>

        <div class="links">
            Take it to the bank.
        </div>
    </div>
</div>
@endsection
