@extends('masterlist')
@section('title', 'Edit Shop')
@section('body')
<div class="content-wrapper">

@section('content')
    <h1>Bill Details</h1>
    
    <!-- Display details of the bill -->
    <p><strong>Shop ID:</strong> {{ $bill->shop_id }}</p>
    <p><strong>Tenant ID:</strong> {{ $bill->tenant_id }}</p>
    <p><strong>Bill Amount:</strong> {{ $bill->bill_amount }}</p>
    <p><strong>Due Date:</strong> {{ $bill->due_date }}</p>
    <p><strong>Status:</strong> {{ $bill->status }}</p>
    <p><strong>Paid At:</strong> {{ $bill->paid_at }}</p>

    <!-- Add more details as needed -->

    <a href="{{ route('bills.index') }}">Back to Bills</a>
@endsection
