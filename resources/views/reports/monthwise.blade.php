@extends('masterlist')

@section('title', 'Reports')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card p-3 card-secondary">
            <div class="card-header ">
                <h3 class="card-title">Monthly Bill Report </h3>
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
            <div id="summary" >
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center"><b> Monthly Report of {{ $selectedMonth !=0 ?$selectedMonth :date('M')}} ,
                                {{ $selectedYear !=0 ?$selectedYear :date('Y')}} </b>(Summary)</h4>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <span>Total Shop</span><br>
                                    <span>Active Agreement</span><br>
                                    <span>Total Rent</span><br>
                                    <span>Total Tax</span><br>
                                    <span>Total Previous Balance</span><br>
                                    <span>Total Penalty</span><br>
                                    <b>Total Total Amount</b><br>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-right">{{$data['shop']}}</span><br>
                                    <span class="float-right">{{$data['agreement']}}</span><br>
                                    <span class="float-right">{{$data['rent']}}</span><br>
                                    <span class="float-right">{{$data['tax']}}</span><br>
                                    <span class="float-right">{{$data['prevbal']}}</span><br>
                                    <span class="float-right">{{$data['penalty']}}</span><br>
                                    <b class="float-right">{{$data['total_amt']}}</b><br>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                    </div>
                </div>
            </div>
            <div>
                <button type="button" id="change" class="btn btn-primary float-right">Details</button>
            </div>
            <div id="details" style="display: none;">
                <table id="example1" class="table table-bordered table-striped ">
                    <thead>
                        <tr class="text-center bg-info">
                            <th>Agreement ID</th>
                            <th>Shop ID</th>
                            <th>Tenant ID</th>
                            <th>Tenant Name</th>
                            <th>Shop Address</th>
                            <th>Rent</th>
                            <th>Tax</th>
                            <th>Penalty</th>
                            <th>Previous Balance</th>
                            <th>Total Balance</th>
                        </tr>
                    </thead>
                    <tbody>
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
                                <td>{{ $bill->rent }}</td>
                                <td>{{ $bill->tax }}</td>
                                <td>{{ $bill->penalty }}</td>
                                <td>{{ $bill->prevbal }}</td>
                                <td>{{ $bill->total_bal }}</td>
                            </tr>
                        @endforeach
                        @if ($bills->isEmpty())
                            <tr>
                                <td colspan="12">No bills found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
    
    <script>
    $(document).ready(function(){
        $('#search').click(function(){
            var year = $('#year').val();
            var month = $('#month').val();
            window.location.href = "{{ route('reports.monthswise') }}/" + year + "/" + month;

        });
        $('#change').click(function(){
            //$("#details").show();
            var details = document.getElementById('details');
            var summary = document.getElementById('summary');
            var change = document.getElementById('change');
            if (details.style.display === 'none') {
                details.style.display = 'block';
                summary.style.display = 'none';
                change.innerHTML = 'Summary';
            } else {
                summary.style.display = 'block';
                details.style.display = 'none';
                change.innerHTML = 'Details';
            }
            

        });
    });

    </script>
@endsection
