@extends('masterindex')

@section('content')
    <h1>Edit Shop</h1>

    @include('shop.form', ['action' => route('shops.update', $shop->id), 'method' => 'PUT'])
@endsection
