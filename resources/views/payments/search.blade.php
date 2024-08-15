@extends('masterlist')  

@section('body')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Search for Payments</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-lightblue">
                        <div class="card-header">
                            <h3 class="card-title">Search </h3>
                        </div>
                    </div>
    <!-- Main content 
    <section class="content">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif  -->

    <form action="{{ route('payments.searchBy') }}" method="post" enctype="multipart/form-data" autocomplete="off">
    @csrf
        <div class="card card-default">
            <!-- .card-body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                    </div>
                    <div class="col-md-6 ">
                        <label style="font-size:22px"> Search By</label><br>
                        <div class="row">
                            <div class="col-md-6 ">
                                <input type="checkbox" id="full_name" value="full_name"  checked>
                                <label for="full_name"> Full Name</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="checkbox" id="email" value="email" >
                                <label for="email"> Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 ">
                                <input type="checkbox" id="govt_id_number" value="govt_id_number" >
                                <label for="govt_id_number"> Govt ID Number</label>
                            </div>
                            <div class="col-md-6 ">
                                <input type="checkbox" id="contact" value="contact" >
                                <label for="contact"> Contact Number</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="checkbox" id="agreement_id" value="agreement_id" >
                                <label for="agreement_id"> Agreement Id</label>
                            </div>
                            <div class="col-md-4 ">
                                <input type="checkbox" id="tenant_id" value="tenant_id" >
                                <label for="tenant_id"> Tenant ID</label>
                            </div>
                            <div class="col-md-4 ">
                                <input type="checkbox" id="shop_id" value="shop_id" >
                                <label for="shop_id"> Shop Id</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="searchby" id="searchby" class="form-control" hidden>
                            <input type="text" name="search" id="search" class="form-control" >
                        </div>  
                        <div class="form-group">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </div>                  
            </div>
        </div>
    </form>
    @if(isset($bills))
        <table id="" class="table table-bordered table-striped" >
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
                    <th>Payment Status</th>
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
                        <td>{{ $bill->total_bal >$bill->rent? $bill->total_bal:$bill->rent }}</td>
                        <td>{{ $bill->bill_date }}</td>
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
                @if ($bills->isEmpty())
                    <tr>
                        <td colspan="12">No bills found.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    @endif
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script>
$(document).ready(function(){
    document.getElementById("searchby").value = 'full_name';
    $('input:checkbox').click(function() {
        $('input:checkbox').not(this).prop('checked', false);
    });
    $('input:checkbox').click(function(){
        var field=$(this).val();
        //console.log(field);
        document.getElementById("searchby").value = field;
    });
});

</script>
@endsection