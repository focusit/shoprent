@extends('masterlist')
@section('title', 'Edit Shop')
@section('body')
<div class="content-wrapper">
    <h1>Edit Bill</h1>
    
    <form action="{{ route('bills.update', $bill) }}" method="post">
        @csrf
        @method('PUT')

        <!-- Add form fields for shop_id, tenant_id, bill_amount, due_date, status, paid_at, etc. -->
        <label for="shop_id">Shop ID:</label>
        <input type="text" name="shop_id" value="{{ $bill->shop_id }}" required>

        <label for="tenant_id">Tenant ID:</label>
        <input type="text" name="tenant_id" value="{{ $bill->tenant_id }}" required>

        <label for="bill_amount">Bill Amount:</label>
        <input type="text" name="bill_amount" value="{{ $bill->bill_amount }}" required>

        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" value="{{ $bill->due_date }}" required>

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="unpaid" {{ $bill->status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
            <option value="partial" {{ $bill->status === 'partial' ? 'selected' : '' }}>Partial</option>
            <option value="paid" {{ $bill->status === 'paid' ? 'selected' : '' }}>Paid</option>
        </select>

        <label for="paid_at">Paid At:</label>
        <input type="date" name="paid_at" value="{{ $bill->paid_at }}" required>

        <!-- Add more form fields as needed -->

        <button type="submit">Update Bill</button>
    </form>
@endsection
