@extends('masterlist')

@section('title', 'ALLBills')

@section('body')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Bills List</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Recently Generated Bills </h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTabs">
                                <li class="nav-item">
                                    <a class="nav-link active" id="allbills" data-toggle="tab" href="#allbills">All
                                        Bills</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="billpaytable" data-toggle="tab"
                                        href="#billpay">Paid Bills</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="unpaidbilltable" data-toggle="tab" href="#unpaidbill">Unpaid
                                        Bills</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <!-- All Shops Tab -->
                                <div class="tab-pane active" id="allbills">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="bg-info">
                                                <th>ID</th>
                                                <th>Agreement ID</th>
                                                <th>Transaction Number</th>
                                                <th>Shop ID</th>
                                                <th>Shop Address</th>
                                                <th>Tenant ID</th>
                                                <th>Tenant Name</th>
                                                <th>Rent</th>
                                                <th>Status</th>
                                                <th>Bill Date</th>
                                                <th>Action</th>
                                                <th>Print Bills</th>
                                                <th>Pay Now</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($bills as $bill)
                                                <tr>
                                                    <td>{{ $bill->id }}</td>
                                                    <td>
                                                        <a href="{{ route('agreements.show', $bill->agreement_id) }}">
                                                            {{ $bill->agreement_id }}
                                                        </a>
                                                    </td>
                                                    <td>{{ $bill->transaction_number }}</td>
                                                    <td>{{ $bill->shop_id }}</td>
                                                    <td>{{ $bill->shop_address }}</td>
                                                    <td>{{ $bill->tenant_id }}</td>
                                                    <td>{{ $bill->tenant_full_name }}</td>
                                                    <td>{{ $bill->rent }}</td>
                                                    <td>{{ $bill->status }}</td>
                                                    <td>{{ $bill->bill_date }}</td>
                                                    <td>
                                                        <form action="{{ route('bills.regenerate', $bill->agreement_id) }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="selectedYear" id="selectedYear"
                                                                value="{{ date('Y') }}">
                                                            <input type="hidden" name="selectedMonth" id="selectedMonth"
                                                                value="{{ date('m') }}">
                                                            <button type="submit" class="btn btn-warning">Regenerate</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('bills.print', ['id' => $bill->id, 'agreement_id' => $bill->agreement_id]) }}"
                                                            target="_blank" class="btn btn-info btn-sm">
                                                            <i class="fas fa-print"></i> Print Bill
                                                        </a>
                                                    </td>
        
                                                    <td>
                                                        @if ($bill->status !== 'paid')
                                                            <button type="button" class="btn btn-warning btn-sm">
                                                                <a href="{{ route('payments.create', $bill->id) }}">
                                                                    Pay Now
                                                                </a>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-info btn-danger" disabled>
                                                                Paid
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="11">No bills found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                   <!-- Occupied Shops Tab -->
                                   <div class="tab-pane" id="billpay">
                                    <table id="billpaytable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="bg-info">
                                                <th>ID</th>
                                                <th>Agreement ID</th>
                                                <th>Shop ID</th>
                                                <th>Shop Address</th>
                                                <th>Tenant ID</th>
                                                <th>Tenant Name</th>
                                                <th>Rent</th>
                                                <th>Status</th>
                                                <th>Bill Date</th>
                                                <th>Print Bills</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($bills as $bill)
                                                @if ($bill->status === 'paid')
                                                    <tr>
                                                        <td>{{ $bill->id }}</td>
                                                        <td>
                                                            <a href="{{ route('agreements.show', $bill->agreement_id) }}">
                                                                {{ $bill->agreement_id }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $bill->shop_id }}</td>
                                                        <td>{{ $bill->shop_address }}</td>
                                                        <td>{{ $bill->tenant_id }}</td>
                                                        <td>{{ $bill->tenant_full_name }}</td>
                                                        <td>{{ $bill->rent }}</td>
                                                        <td>{{ $bill->status }}</td>
                                                        <td>{{ $bill->bill_date }}</td>
                                                        <td>
                                                            <a href="{{ route('bills.print', ['id' => $bill->id, 'agreement_id' => $bill->agreement_id]) }}"
                                                                target="_blank" class="btn btn-info btn-sm">
                                                                <i class="fas fa-print"></i> Print Bill
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="10">No paid bills found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Vacant Shops Tab -->
                                <div class="tab-pane" id="unpaidbill">
                                    <table id="unpaidbilltable" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="bg-info">
                                                <th>ID</th>
                                                <th>Agreement ID</th>
                                                <th>Shop ID</th>
                                                <th>Shop Address</th>
                                                <th>Tenant ID</th>
                                                <th>Tenant Name</th>
                                                <th>Rent</th>
                                                <th>Status</th>
                                                <th>Bill Date</th>
                                                <th>Print Bills</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($bills as $bill)
                                                @if ($bill->status === 'unpaid')
                                                    <tr>
                                                        <td>{{ $bill->id }}</td>
                                                        <td>
                                                            <a href="{{ route('agreements.show', $bill->agreement_id) }}">
                                                                {{ $bill->agreement_id }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $bill->shop_id }}</td>
                                                        <td>{{ $bill->shop_address }}</td>
                                                        <td>{{ $bill->tenant_id }}</td>
                                                        <td>{{ $bill->tenant_full_name }}</td>
                                                        <td>{{ $bill->rent }}</td>
                                                        <td>{{ $bill->status }}</td>
                                                        <td>{{ $bill->bill_date }}</td>
                                                        <td>
                                                            <a href="{{ route('bills.print', ['id' => $bill->id, 'agreement_id' => $bill->agreement_id]) }}"
                                                                target="_blank" class="btn btn-info btn-sm">
                                                                <i class="fas fa-print"></i> Print Bill
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="10">No unpaid bills found.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection