@extends('masterlist')

@section('title', 'Bills')

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
                    <button class="btn btn-primary" id="currentMonthBtn">{{ \Carbon\Carbon::now()->format('F Y') }}</button>
                    @foreach ($billsByMonth as $month => $bills)
                        <button class="btn btn-secondary" id="monthBtn{{ \Carbon\Carbon::parse($month)->format('m') }}">
                            {{ $month }}
                        </button>
                    @endforeach
                </div>

                <table class="table table-bordered table-striped" id="example1">
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
                        </tr>
                    </thead>
                    <tbody>
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

                @foreach ($billsByMonth as $month => $bills)
                    <div class="table-container" style="display:none;"
                        id="monthTable{{ \Carbon\Carbon::parse($month)->format('m') }}">
                        <table class="table">
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
                            <tbody>
                                @foreach ($bills as $bill)
                                    @php
                                        $billMonth = \Carbon\Carbon::parse($bill->bill_date)->format('F Y');
                                        $currentMonth = \Carbon\Carbon::now()->format('F Y');
                                    @endphp
                                    @if ($billMonth !== $currentMonth)
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
                                    @endif
                                @endforeach
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
            document.getElementById('currentMonthBtn').addEventListener('click', function() {
                showTable('example1');
            });

            @foreach ($billsByMonth as $month => $bills)
                document.getElementById('monthBtn{{ \Carbon\Carbon::parse($month)->format('m') }}')
                    .addEventListener('click', function() {
                        showTable('monthTable{{ \Carbon\Carbon::parse($month)->format('m') }}');
                    });
            @endforeach
        });

        function showTable(tableId) {
            document.querySelectorAll('.table-container').forEach(function(table) {
                table.style.display = 'none';
            });

            document.getElementById(tableId).style.display = 'block';
        }
    </script>
@endsection
