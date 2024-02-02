<!-- resources/views/bills/bills_list.blade.php -->

@extends('masterlist')

@section('title', 'Bills')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bills Month-wise</h3>
            </div>
            <!-- Display cards for each month -->
            <div class="card-deck">
                hii
                @foreach ($billsByMonth as $month => $bills)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ \Carbon\Carbon::parse($month)->format('F Y') }}</h5>
                            <p class="card-text">
                                <a href="{{ route('bills.billsList', ['year' => $selectedYear, 'month' => $month]) }}">
                                    View Bills
                                </a>
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="mb-3">
                    <label for="yearSelect">Select Year: </label>
                    <select id="yearSelect" onchange="loadMonths()">
                        @for ($year = date('Y'); $year >= 2020; $year--)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endfor
                    </select>

                    <label for="monthSelect">Select Month: </label>
                    <select id="monthSelect" onchange="loadBills()">
                        @foreach (range(1, 12) as $month)
                            <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}"
                                {{ $month == $selectedMonth ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div id="billsTableContainer" style="display:none;">
                    <table class="table table-bordered table-striped" id="billsTable">
                        <thead>
                            <tr class="text-center bg-info">
                                <th>ID</th>
                                <th>Agreement ID</th>
                                <th>Shop ID</th>
                                <th>Shop Address</th>
                                <th>Tenant ID</th>
                                <th>Tenant Name</th>
                                <th>Rent</th>
                                <th>Status</th>
                                <th>Bill Date</th>
                                <th>Action</th>
                                <th>Print Bills</th>
                                <th>Payment Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($billsByMonth->flatten() as $bill)
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
                                    <td>{{ $bill->month }}</td>
                                    <td>
                                        <form action="{{ route('bills.regenerate', $bill->agreement_id) }}" method="post">
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
                                                <a href="{{ route('payments.create', $bill->id) }}">Pay Now</a>
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
                                    <td colspan="12">No bills found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- End of custom content -->
    </div>

    <script>
        function loadMonths() {
            document.getElementById('billsTableContainer').style.display = 'none';
        }

        function loadBills() {
            document.getElementById('billsTableContainer').style.display = 'block';
        }
    </script>
@endsection
