@extends('masterlist')

@section('title', 'Bills')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bills Month-wise</h3>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="monthYearSelect" class="form-label md-6">Select Month and Year: </label>
                    <select id="monthYearSelect" class="form-control">
                        @foreach ($billsByMonth as $month => $bills)
                            <option value="{{ \Carbon\Carbon::parse($month)->format('Y-m') }}">
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary" id="viewBillsBtn">View Bills</button>
                </div>

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
                        @forelse ($billsByMonth[\Carbon\Carbon::now()->format('F Y')] ?? [] as $currentMonthBill)
                            @php
                                $billMonth = \Carbon\Carbon::parse($currentMonthBill->bill_date)->format('F Y');
                                $currentMonth = \Carbon\Carbon::now()->format('F Y');
                            @endphp
                            @if ($billMonth === $currentMonth)
                                <tr>
                                    <td>{{ $currentMonthBill->id }}</td>
                                    <td>
                                        <a href="{{ route('agreements.show', $currentMonthBill->agreement_id) }}">
                                            {{ $currentMonthBill->agreement_id }}
                                        </a>
                                    </td>
                                    <td>{{ $currentMonthBill->shop_id }}</td>
                                    <td>{{ $currentMonthBill->shop_address }}</td>
                                    <td>{{ $currentMonthBill->tenant_id }}</td>
                                    <td>{{ $currentMonthBill->tenant_full_name }}</td>
                                    <td>{{ $currentMonthBill->rent }}</td>
                                    <td>{{ $currentMonthBill->status }}</td>
                                    <td>{{ $currentMonthBill->bill_date }}</td>
                                    <td>
                                        <form action="{{ route('bills.regenerate', $currentMonthBill->agreement_id) }}"
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
                                        <a href="{{ route('bills.print', ['id' => $currentMonthBill->id, 'agreement_id' => $currentMonthBill->agreement_id]) }}"
                                            target="_blank" class="btn btn-info btn-sm">
                                            <i class="fas fa-print"></i> Print
                                        </a>
                                    </td>
                                    <td>
                                        @if ($currentMonthBill->status !== 'paid')
                                            <button type="button" class="btn btn-warning btn-sm">
                                                <a href="{{ route('payments.create', $currentMonthBill->id) }}">Pay Now</a>
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-info btn-danger" disabled>
                                                Paid
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="12">No bills found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @foreach ($billsByMonth as $month => $otherMonthBills)
                    <div class="table-container" style="display:none;"
                        id="monthTable{{ \Carbon\Carbon::parse($month)->format('m') }}">
                        <table class="table table-bordered table-striped">
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
                                @forelse ($otherMonthBills as $bill)
                                    @php
                                        $billMonth = \Carbon\Carbon::parse($bill->bill_date)->format('F Y');
                                        $currentMonth = \Carbon\Carbon::now()->format('F Y');
                                    @endphp
                                    @if ($billMonth != $currentMonth)
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
                                                        <a href="{{ route('payments.create', $bill->id) }}">Pay Now</a>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-info btn-danger" disabled>
                                                        Paid
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="12">No bills found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- End of custom content -->
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('viewBillsBtn').addEventListener('click', function() {
                var selectedMonthYear = document.getElementById('monthYearSelect').value;
                var x = showTable('billsTable', 'monthTable' + selectedMonthYear.substring(5, 7));
                console.log(selectedMonthYear);
            });

            @foreach ($billsByMonth as $month => $otherMonthBills)
                document.getElementById('monthBtn{{ \Carbon\Carbon::parse($month)->format('m') }}')
                    .addEventListener('click', function() {
                        var selectedMonthYear = '{{ \Carbon\Carbon::parse($month)->format('Y-m') }}';
                        showTable('monthTable' + selectedMonthYear.substring(5, 7));
                    });
            @endforeach
        });

        function showTable(tableId, containerId) {
            document.querySelectorAll('.table-container').forEach(function(table) {
                table.style.display = 'none';
            });

            document.getElementById(tableId).style.display = 'none';
            document.getElementById(containerId).style.display = 'block';
        }
    </script>
@endsection
