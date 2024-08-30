<!-- shop/edit.blade.php -->
@extends('masterlist')

@section('title', 'Edit Tenant')

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

    <form action="{{ route('tenants.update', $tenant->tenant_id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('tenants._form')
    </form>
</div>
@endsection
