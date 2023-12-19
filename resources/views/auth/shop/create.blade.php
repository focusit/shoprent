@extends('masterindex')

@section('content')
    <h1 class="text-center">Add a Shop</h1>

    @include('shop._form', ['action' => route('shops.store')])
    @endsection
