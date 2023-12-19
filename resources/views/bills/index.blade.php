@extends('masterlist')
@section('title', 'Edit Shop')
@section('body')
<div class="content-wrapper">
    <h1>List of Bills</h1>
    
    <!-- Display a table of bills -->
    <table>
        <thead>
            <tr>
                <th>Shop ID</th>
                <th>Tenant ID</th>
                <th>Bill Amount</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Paid At</th>
                <!-- Add more columns as needed -->
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bills as $bill)
                <tr>
                    <td>{{ $bill->shop_id }}</td>
                    <td>{{ $bill->tenant_id }}</td>
                    <td>{{ $bill->bill_amount }}</td>
                    <td>{{ $bill->due_date }}</td>
                    <td>{{ $bill->status }}</td>
                    <td>{{ $bill->paid_at }}</td>
                    <td>{{ $bill->created_at }}</td>
                    <!-- Add more columns as needed -->
                    <td>
                        <a href="{{ route('bills.show', $bill) }}">View</a>
                        <a href="{{ route('bills.edit', $bill) }}">Edit</a>
                        <form action="{{ route('bills.destroy', $bill) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
