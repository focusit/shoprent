@extends('masterlist')

@section('title', 'Bills')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card p-3">
            <div class="card-header">
                <h3 class="card-title">Bills Month-wise</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year" name="year" class="form-select" onchange="filterBills()">
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="month" class="form-label">Select Month:</label>
                        <select id="month" name="month" class="form-select" onchange="filterBills()">
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped">
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
                    @foreach ($billsByMonth as $monthYear => $bills)
                        @foreach ($bills as $bill)
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
                                    <form action="{{ route('bills.regenerate', $bill->transaction_number) }}" method="post">
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
                        @endforeach
                    @endforeach
                    @if ($billsByMonth->isEmpty())
                        <tr>
                            <td colspan="12">No bills found.</td>
                        </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>



    <script>
        function filterBills() {
            var year = $('#year').val();
            var month = $('#month').val();
            window.location.href = "{{ route('bills.billsList') }}/" + year + "/" + month;
        }
    </script>
@endsection
