@extends('masterlist')

@section('title', 'Bills')

@section('body')
    <!-- Content Wrapper. Contains page content -->
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

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success">
                            <div class="card-header">
                                <h3 class="card-title">Recently Generated Bills </h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="  pl-4 mt-4">
                                <form action="{{ route('bills.generate') }}" method="post" id="generateForm">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="year">Select Year:</label>
                                        <select id="year">
                                            @for ($year = date('Y'); $year >= 2020; $year--)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>

                                        <label for="month">Select Month:</label>
                                        <select id="month">
                                            @foreach (range(1, 12) as $month)
                                                @php
                                                    $currentYear = date('Y');
                                                    $currentMonth = date('m');
                                                    $disabled = $year == $currentYear && $month > $currentMonth ? 'disabled' : '';
                                                    
                                                    // $disabled = ($month == date('n') || $month == date('n')) ?'':'disabled' ;
                                                
                                                @endphp
                                                <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}"
                                                    {{ $disabled }}>
                                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="selectedYear" id="selectedYear"
                                            value="{{ date('Y') }}">
                                        <input type="hidden" name="selectedMonth" id="selectedMonth"
                                            value="{{ date('m') }}">
                                    </div>
                                    <div class="card-card-default mb-4">
                                        <button type="submit" class="btn btn-success" id="generateButton">Generate
                                            Bills</button>
                                    </div>
                                </form>
                            </div>
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
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
    </section>
    <!-- /.content-wrapper -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add event listeners for dropdown changes
            document.getElementById('year').addEventListener('change', updateTable);
            document.getElementById('month').addEventListener('change', updateTable);

            // Update hidden inputs when dropdowns change
            document.getElementById('year').addEventListener('change', function() {
                document.getElementById('selectedYear').value = this.value;
            });

            document.getElementById('month').addEventListener('change', function() {
                document.getElementById('selectedMonth').value = this.value;
            });

            function updateTable() {
                var selectedYear = document.getElementById('year').value;
                var selectedMonth = document.getElementById('month').value;

                console.log('Selected Year here:', selectedYear);
                console.log('Selected Month:', selectedMonth);
            }
        });
    </script>

@endsection
