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
                                <h3 class="card-title"> Generate Bills{{ isset($bills) ? ' ':'' }}</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="pl-4 mt-4">
                                <form action="{{ route('bills.generate') }}" method="post" id="generateForm">
                                    @csrf
                                    <div class="mb-4" hidden>
                                        <label for="year">Select Year:</label>
                                        <select id="year">
                                            {{-- <option value="Please select">Please select</option> --}}
                                            @for ($year = date('Y'); $year >= 2020; $year--)
                                                <option value="{{$year}}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                        <label for="month">Select Month:</label>
                                        <select id="month">
                                            {{-- <option value="Please select">Please select</option> --}}
                                            @foreach (range(1, 12) as $month)
                                                @php
                                                    $currentYear = date('Y');
                                                    $currentMonth = date('m');
                                                    $disabled =
                                                        $year == $currentYear && $month > $currentMonth
                                                            ? 'disabled'
                                                            : '';
                                                    // $disabled = $month == date('n')||$month==date('n')?'':'disabled';
                                                @endphp
                                                <option value="{{ str_pad($month,2,'0',STR_PAD_LEFT) }}"
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
                                    <div class="row">
                                        <div class="card-card-default mb-4 col-6 ">
                                            <button type="submit" title="Generate Bills for this Month" class="btn btn-success" id="generateButton">
                                                Generate Bills
                                            </button>
                                        </div>
                                        <div class="card-card-default mb-4 col-5 d-flex justify-content-end ">
                                            <button title="Export all Bills Pdf" type="button" class="btn btn-success " >
                                                <a class="text-light" href="{{ url('/bills/generate/Pdf') }}" >
                                                    Export Bills
                                                </a>
                                            </button>
                                        </div>
                                        <div class="col-1"></div>
                                    </div>
                                </form>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Agreement ID</th>
                                        <th>Shop ID</th>
                                        <th>Tenant ID</th>
                                        <th>Tenant Name</th>
                                        <th>Shop Address</th>
                                        <th>Rent</th>
                                        <th>Status</th>
                                        <th class="d-print-none">Bill Date</th>
                                        <th class="d-print-none">Action</th>
                                        <th class="d-print-none">Print Bills</th>
                                        @if($paybill="enable")
                                            <th class="d-print-none">Pay Now</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($bills as $bill)
                                        <tr>
                                            <td><a href="{{ route('agreements.show', $bill->agreement_id) }}">{{ $bill->agreement_id }}</a></td>
                                            <td>
                                                @forelse($shops as $shop)
                                                    @if ($shop->id == $bill->shop_id)
                                                        {{ $shop->shop_id }}
                                                    @endif
                                                @empty
                                                    
                                                @endforelse<!--Shop Id-->
                                            </td>
                                            <td>{{ $bill->tenant_id }}</td>
                                            <td>{{ $bill->tenant_full_name }}</td>
                                            <td>{{ $bill->shop_address }}</td>
                                            <td>{{ $bill->rent }}</td>
                                            <td>{{ $bill->status }}</td>
                                            <td>{{ date('d-m-Y',strtotime($bill->bill_date)) }}</td>
                                            <td>
                                                <form action="{{ route('bills.regenerate', $bill->id) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="selectedYear" id="selectedYear"
                                                        value="{{ date('Y') }}">
                                                    <input type="hidden" name="selectedMonth" id="selectedMonth"
                                                        value="{{ date('m') }}">
                                                    <button type="submit" title="Regenerate This Bill" class="btn btn-warning">Regenerate</button>
                                                </form>
                                            </td>
                                            <td>
                                                <a href="{{ route('bills.print', ['id' => $bill->id, 'agreement_id' => $bill->agreement_id]) }}"
                                                    title="Print Bill" class="btn btn-info btn-sm">
                                                    <i class="fas fa-print"></i> Print Bill
                                                </a>
                                            </td>
                                            @if($paybill="enable")
                                            <td>
                                                @if ($bill->status !== 'paid')
                                                    <button type="button" class="btn btn-warning btn-sm" title="Pay Bill">
                                                        <a href="{{ route('payments.create', $bill->id) }}">
                                                            Pay Now
                                                        </a>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-info btn-danger" title="Bill Paid" disabled>
                                                        Paid
                                                    </button>
                                                @endif
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="11">No bills found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
    </div><!-- /.container-fluid -->
    </section><!-- /.content-wrapper -->
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
