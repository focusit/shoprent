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
                    <button class="btn btn-primary" id="currentMonthBtn">Current Month</button>
                    @foreach($billsByMonth as $month => $bills)
                        <button class="btn btn-secondary" id="monthBtn{{ \Carbon\Carbon::parse($month)->format('m') }}">
                            {{ $month }}
                        </button>
                    @endforeach
                </div>

                <table class="table" id="example1">
                    <thead>
                        <tr>
                            <th>Bill ID</th>
                            <th>Agreement ID</th>
                            <!-- Add more columns as needed -->
                            <th>Bill Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billsByMonth[Carbon\Carbon::now()->format('F Y')] as $bill)
                            <tr>
                                <td>{{ $bill->id }}</td>
                                <td>{{ $bill->agreement_id }}</td>
                                <!-- Add more columns as needed -->
                                <td>{{ $bill->bill_date }}</td>
                                <td>{{ $bill->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @foreach($billsByMonth as $month => $bills)
                    <div class="table-container" style="display:none;" id="monthTable{{ \Carbon\Carbon::parse($month)->format('m') }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bill ID</th>
                                    <th>Agreement ID</th>
                                    <!-- Add more columns as needed -->
                                    <th>Bill Date</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                    <tr>
                                        <td>{{ $bill->id }}</td>
                                        <td>{{ $bill->agreement_id }}</td>
                                        <!-- Add more columns as needed -->
                                        <td>{{ $bill->bill_date }}</td>
                                        <td>{{ $bill->amount }}</td>
                                    </tr>
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
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('currentMonthBtn').addEventListener('click', function () {
                showTable('example1');
            });

            @foreach($billsByMonth as $month => $bills)
                document.getElementById('monthBtn{{ \Carbon\Carbon::parse($month)->format('m') }}').addEventListener('click', function () {
                    showTable('monthTable{{ \Carbon\Carbon::parse($month)->format('m') }}');
                });
            @endforeach
        });
        function showTable(tableId) {
            document.querySelectorAll('.table-container').forEach(function (table) {
                table.style.display = 'none';
            });

            document.getElementById(tableId).style.display = 'block';
        }
    </script>
@endsection
