@extends('masterlist')

@section('title', 'Reports')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="card p-3 card-secondary">
            <div class="card-header ">
                <h3 class="card-title">Collection Report </h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="start" class="form-label">From :</label>
                        <input  type="date" id="start" name="start" class="form-control" 
                        value="{{old('$start',isset($start) ? $start : now()->toDateString()) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="end" class="form-label">TO :</label>
                        <input type="date" id="end" name="end" class="form-control" 
                        value="{{old('$end',isset($end) ? $end : now()->toDateString()) }}">
                        <span id="date-error" class="text-danger"></span>
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
                                <h4 class="text-center"><b> Collection Report {{$data['duration']}}</b></h4>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-2"></div>
                                <div class="col-md-4">
                                    <span>Total Receipts</span><br>
                                    <b>Payment Receipts</b><br>
                                    <span>Rent</span><br>
                                    <span>Tax</span><br>
                                    <span>Penalty</span><br>
                                    <span>Recovery/Previous Balance</span><br>
                                </div>
                                <div class="col-md-4">
                                    <span class="float-right">{{$data['count']}}</span><br>
                                    <b class="float-right">{{-1*$data['payment']}}</b><br>
                                    <span class="float-right">{{$data['rent']}}</span><br>
                                    <span class="float-right">{{$data['tax']}}</span><br>
                                    <span class="float-right">{{$data['penalty']}}</span><br>
                                    <span class="float-right">{{$data['prevbal']}}</span><br>
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
                            <th>Paid Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bills as $bill)
                            <tr>
                                <td>
                                    <a href="{{ route('agreements.show', $bill['agreement_id']) }}">
                                        {{ $bill['agreement_id'] }}
                                    </a>
                                </td>
                                <td>
                                    @forelse($shops as $shop)
                                        @if ($shop->id == $bill['shop_id'])
                                            {{ $shop->shop_id }}
                                        @endif
                                    @empty
                                        
                                    @endforelse<!--Shop Id-->
                                </td>
                                <td>{{ $bill['tenant_id'] }}</td>
                                <td>{{ $bill['tenant_full_name'] }}</td>
                                <td>{{ $bill['shop_address'] }}</td>
                                <td>{{ $bill['rent'] }}</td>
                                <td>{{ $bill['tax'] }}</td>
                                <td>{{ $bill['penalty'] }}</td>
                                <td>{{ $bill['prevbal'] }}</td>
                                <td>{{ $bill['total_bal'] }}</td>
                                <td>{{ -1*$bill['amount'] }}</td>
                            </tr>
                        @endforeach
                        @if ($bills==null)
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
            var start = $('#start').val();
            console.log(start);
            var end = $('#end').val();
            window.location.href = "{{ route('reports.collections') }}/" + start + "/" + end;

        });
        $('#change').click(function(){
            //$("#details").show();
            var details = document.getElementById('details');
            var summary = document.getElementById('summary');
            var change = document.getElementById('change');
            if (details.style.display === 'none') {
                details.style.display = 'block';
                //summary.style.display = 'none';
            } else {
                //summary.style.display = 'block';
                details.style.display = 'none';
            }
        });
        document.getElementById('end').addEventListener('change', function() {
            var start = document.getElementById('start').value;
            var end = this.value;
            if (start && end && start > end) {
                document.getElementById('date-error').innerText =
                    'End date should not be less than Start date.';
                this.value = start; // Reset the input value
                document.getElementById("search").disabled = true;
            } else {
                document.getElementById('date-error').innerText = '';
                document.getElementById("search").disabled = false;
            }
        });
    });

    </script>
@endsection
