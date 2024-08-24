@extends('masterlist')

@section('title', 'Bills')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card p-3">
            <div class="card-header">
                <h2 class="card-title">{{ isset($var) ? "Month-wise Bills" :"Paid Bills"}} </h2>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="year" class="form-label">Select Year:</label>
                        <select id="year" name="year" class="form-select" >
                            @for ($year = date('Y'); $year >= 2020; $year--)
                                <option value="{{ $year }} {{ $selectedYear == $year ? 'selected' : '' }}">
                                    {{ $year }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="month" class="form-label">Select Month:</label>
                        <select id="month" name="month" class="form-select">
                            @for ($month = 1; $month <= 12; $month++)
                                <option value="{{ $month }} {{ $selectedMonth == $month ? 'selected' : '' }}">
                                    {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-info" id="search" >
                            <i class="fa fa-search "> Search</i>
                        </button>
                    </div>
                </div>
            </div>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="text-center bg-info">
                        <th>Agreement ID</th>
                        <th>Shop ID</th>
                        <th>Tenant ID</th>
                        <th>Tenant Name</th>
                        <th>Shop Address</th>
                        <th>Amount</th>
                        <th>Bill Date</th>
                        <th>Print Bills</th>
                        @if(isset($var))
                            @if($paybill=="enable")
                                <th>Payment Status</th>
                            @endif
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($billsByMonth as $monthYear => $bills)
                        @foreach ($bills as $bill)
                            <tr>
                                <td>
                                    <a href="{{ route('agreements.show', $bill->agreement_id) }}">
                                        {{ $bill->agreement_id }}
                                    </a>
                                </td>
                                <td>{{ $bill->shop_id }}</td>
                                <td>{{ $bill->tenant_id }}</td>
                                <td>{{ $bill->tenant_full_name }}</td>
                                <td>{{ $bill->shop_address }}</td>
                                <td>{{ $bill->total_bal >$bill->rent? $bill->total_bal:$bill->rent }}</td>
                                <td>{{ $bill->bill_date }}</td>
                                <td>
                                    <a title="Print Bill" href="{{ route('bills.print', ['id' => $bill->id, 'agreement_id' => $bill->agreement_id]) }}"
                                        target="_blank" class="btn btn-info btn-sm">
                                        <i class="fas fa-print"></i> Print Bill
                                    </a>
                                </td>
                                @if(isset($var))
                                    @if($paybill=="enable")
                                        <td>
                                            @if ($bill->status !== 'paid')
                                                <button title="Pay Bill" type="button" class="btn btn-warning btn-sm">
                                                    <a href="{{ route('payments.create', $bill->id) }}">Pay Now</a>
                                                </button>
                                            @else
                                                <button title="Bill Paid" type="button" class="btn btn-info btn-danger" disabled>
                                                    Paid
                                                </button>
                                            @endif
                                        </td>
                                    @endif
                                @endif
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
        $('#search').click(function(){
            var year = $('#year').val();
            var month = $('#month').val();
            window.location.href = "{{ route('bills.billsList') }}/" + year + "/" + month;
        });

    </script>
@endsection
