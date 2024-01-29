<!-- shop/edit.blade.php -->
@extends('masterlist')
@section('title', 'Edit Shop')
@section('body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('shops.update', $shop->shop_id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('shop._form')
        </form>
    </div>
@endsection
