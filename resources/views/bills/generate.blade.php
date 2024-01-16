@extends('masterlist')

@section('title', 'Bills')

<head>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bills Month-wise</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="mb-3">
                    <button class="btn btn-primary" id="currentMonthBtn">Current Month</button>
                    @foreach ($billsByMonth as $month => $bills)
                        <button class="btn btn-secondary monthBtn"
                            data-month="{{ \Carbon\Carbon::parse($month)->format('m') }}">
                            {{ $month }}
                        </button>
                    @endforeach
                </div>

                <table class="table" id="example1">
                    <thead>
                        <tr>
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
                        </tr>
                    </thead>
                    <tbody id="billTableBody">
                        @forelse ($billsByMonth[Carbon\Carbon::now()->format('F Y')] ?? [] as $bill)
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
                                    <form action="{{ route('bills.regenerate', $bill->agreement_id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-warning">Regenerate</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('bills.print', $bill->agreement_id) }}" target="_blank"
                                        class="btn btn-info btn-sm">
                                        <i class="fas fa-print"></i> Print Bill
                                    </a>
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
        </div>
    </div>

    <script>
   document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('currentMonthBtn').addEventListener('click', function() {
        updateTable('example1', '{{ \Carbon\Carbon::now()->format('m') }}');
    });

    var monthButtons = document.querySelectorAll('.monthBtn');
    monthButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var selectedMonth = button.getAttribute('data-month');
            updateTable('example1', selectedMonth);
        });
    });
});

function updateTable(tableId, selectedMonth) {
    var billsByMonth = {!! json_encode($billsByMonth, JSON_FORCE_OBJECT) !!};
    var billsForSelectedMonth = billsByMonth[selectedMonth];

    var tableBody = document.getElementById('billTableBody');
    tableBody.innerHTML = '';

    if (billsForSelectedMonth && billsForSelectedMonth.length > 0) {
        billsForSelectedMonth.forEach(function(bill) {
            var agreementShowUrl = '/agreements/' + bill.agreement_id;
            var regenerateUrl = '/bills/regenerate/' + bill.agreement_id;
            var printUrl = '/bills/print/' + bill.agreement_id;

            var row = '<tr>' +
                '<td>' + bill.id + '</td>' +
                '<td><a href="' + agreementShowUrl + '">' + bill.agreement_id + '</a></td>' +
                '<td>' + bill.shop_id + '</td>' +
                '<td>' + bill.shop_address + '</td>' +
                '<td>' + bill.tenant_id + '</td>' +
                '<td>' + bill.tenant_full_name + '</td>' +
                '<td>' + bill.rent + '</td>' +
                '<td>' + bill.status + '</td>' +
                '<td>' + bill.bill_date + '</td>' +
                '<td>' +
                '<form action="' + regenerateUrl + '" method="post">' +
                '@csrf' +
                '<button type="submit" class="btn btn-warning">Regenerate</button>' +
                '</form>' +
                '</td>' +
                '<td>' +
                '<a href="' + printUrl + '" target="_blank" class="btn btn-info btn-sm">' +
                '<i class="fas fa-print"></i> Print Bill' +
                '</a>' +
                '</td>' +
                '</tr>';
            tableBody.innerHTML += row;
        });
    } else {
        var noDataRow = '<tr><td colspan="11">No bills found.</td></tr>';
        tableBody.innerHTML = noDataRow;
    }
}
</script>
@endsection