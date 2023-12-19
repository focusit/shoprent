@extends('masterlist')
@section('title', 'Edit Shop')
@section('body')
<div class="content-wrapper">
    <h1>Create Bill</h1>
    
    <form action="{{ route('bills.store') }}" method="post">
        @csrf

        <!-- Add form fields for shop_id, tenant_id, bill_amount, due_date, status, paid_at, etc. -->
        {{-- <label for="shop_id">Shop ID:</label>
        <input type="text" name="shop_id" required>

        <label for="tenant_id">Tenant ID:</label>
        <input type="text" name="tenant_id" required> --}}

        {{-- <label for="bill_amount">Bill Amount:</label>
        <input type="text" name="bill_amount" required> --}}

        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" required>

        <label for="penalty">Penalty:</label>
        <input type="number" name="penalty" required>

        <label for="discount">Discount:</label>
        <input type="number" name="discount" required>

        {{-- <label for="status">Status:</label>
        <select name="status" required>
            <option value="unpaid">Unpaid</option>
            <option value="partial">Partial</option>
            <option value="paid">Paid</option>
        </select> --}}

        {{-- <label for="paid_at">Paid At:</label>
        <input type="date" name="paid_at" required> --}}

        <!-- Add more form fields as needed -->

        <button type="submit">Create</button>
    </form>
@endsection
