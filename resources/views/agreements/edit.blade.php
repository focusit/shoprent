<!-- agreement/edit.blade.php -->
@extends('masterlist')
@section('title', 'Edit agreement')
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
        <form action="{{ route('agreements.update', $agreement->agreement_id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('property-allocation.allocate_shop')
        </form>
    </div>
@endsection
