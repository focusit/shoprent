@extends('masterlist')

@section('title', 'Bills')

@section('body')
<head>
        <style>
            .ui-autocomplete {
                float: left;
                max-height: 200px;
                padding: 5px 0;
                margin: 2px 0 0;
                list-style: none;
                font-size: 14px;
                background-color: #ffffff;
                overflow-x: hidden; 
                overflow-y: scroll;
            }

            .ui-autocomplete li {
                padding: 8px;
                cursor: pointer;
            }

            .ui-autocomplete li:hover {
                background-color: #f5f5f5;
            }

            .ui-autocomplete li.ui-no-results {
                padding: 8px;
                color: #9d3737;
            }

            .ui-autocomplete li.ui-state-focus {
                background-color: #333;
                color: #6a0808;
            }
        </style>
    </head>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Pay Bill</h1>
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
                                <h3 class="card-title">Pay Now</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('payment.billpaid') }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bill_no">Bill No:</label>
                                                <input type="text" id="bill_no" name="bill_no" class="form-control"
                                                    value="{{ old('bill_no', isset($bill) ? $bill->id :'') }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="agreement_id">Agreement ID:</label>
                                                <input type="text" id="agreement_id" name="agreement_id"
                                                    class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_date">Payment Date:</label>
                                                <input type="date" id="payment_date" name="payment_date"
                                                    value="{{ old('payment_date', isset($agreement) ? $agreement->payment_date : now()->toDateString()) }}"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">Balance:</label>
                                                <input type="text" id="amount" name="amount" class="form-control"
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pay_amt">Amount:</label>
                                                <input type="text" id="pay_amt" name="pay_amt" class="form-control"
                                                    required>

                                            </div>
                                        </div>                                            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_method">Mode:</label>
                                                <select id="payment_method" name="payment_method" class="form-control" required>
                                                    <option value="select" disabled selected>Select Mode</option>
                                                    <option value="cash" selected>Cash</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="upi">UPI</option>
                                                    <option value="netbanking">Net Banking</option>
                                                    <option value="card">Card</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remark">Remark:</label>
                                                <textarea id="remark" name="remark" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="cheque_fields" style="display: none;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cheque_number">Cheque Number:</label>
                                                    <input type="text" id="cheque_number" name="cheque_number"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="cheque_date">Cheque Date:</label>
                                                    <input type="date" id="cheque_date" name="cheque_date"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="bank_name">Bank Name:</label>
                                                    <input type="text" id="bank_name" name="bank_name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="online_fields" style="display: none;">
                                        <div class="row">   
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="upi_id">UPI ID:</label>
                                                    <input type="text" id="upi_id" name="upi_id"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="net_banking_utr" style="display: none;">
                                        <div class="row">   
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="utr_no">UTR No:</label>
                                                    <input type="text" id="utr_no" name="utr_no"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="card_fields" style="display: none;">
                                        <div class="row">   
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="card_no">Card's last four Digits:</label>
                                                    <input type="text" id="card_no" name="card_no"
                                                        class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group justify-center">
                                        <button id="pay" type="button" class="btn btn-success" data-toggle="modal" data-target="#alertModal">Pay Now</button>
                                        <button id="payNow" type="submit" class="btn btn-success" hidden>Pay Now</button>
                                    </div>
                                </form>
                            </div><!-- /.card-body -->
                        </div><!-- /.card -->
                        <div class="modal fade" id="alertModal" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-body ">
                                        <span id="data1"></span>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" id="submit" value="submit">Submit</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Modal -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $('#pay').click(function(){
            pay_amt = document.getElementById('pay_amt').value;
            amount = document.getElementById('amount').value;
            if (pay_amt > 0){
                if(parseInt(pay_amt) > parseInt(amount)){
                    message ='Are you sure you want to pay Extra?';
                }else if(parseInt(pay_amt) < parseInt(amount)){
                    message ='Are you sure you want to partially pay Bill?';
                }
            }else{
                message='Please Enter Amount!!';
            }
            document.getElementById("data1").innerText = message;
        });
        $('#submit').click(function(){
            $('#payNow').trigger('click');
        });
    });
        document.addEventListener('DOMContentLoaded', function() {
            var paymentModeSelect = document.getElementById('payment_method');
            var chequeFields = document.getElementById('cheque_fields');
            var onlineFields = document.getElementById('online_fields');
            var net_banking_utr = document.getElementById('net_banking_utr');
            var card_fields = document.getElementById('card_fields');

            paymentModeSelect.addEventListener('change', function() {
                // Show additional fields based on the selected payment mode
                chequeFields.style.display = (paymentModeSelect.value === 'cheque') ? 'block' : 'none';
                onlineFields.style.display = (paymentModeSelect.value === 'upi') ? 'block' : 'none';
                net_banking_utr.style.display = (paymentModeSelect.value === 'netbanking') ? 'block' : 'none';
                card_fields.style.display = (paymentModeSelect.value === 'card') ? 'block' : 'none';
            });
        });
        $('#bill_no').autocomplete({
            source: function(request, response) {
                $.post('{{ route("autocomplete.bills")}}', {
                    query: request.term,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.id,
                            value: item.id,
                            agreement_id :item.agreement_id,
                            total_bal :item.total_bal,
                        };
                    }));
                });
            },
            minLength: 0,
            select: function(event, ui) {
                $('#bill_no').val(ui.item.value);
                $('#bill_id').val(ui.item.value);
                $('#agreement_id').val(ui.item.agreement_id);
                //$('#amount').val(ui.item.total_bal);
            }
        });

        $('#agreement_id').autocomplete({
            source: function(request, response) {
                $.post('{{ route("autocomplete.agreements")}}', {
                    query: request.term,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.agreement_id,
                            value: item.agreement_id,
                            bill_no :item.id,
                            total_bal :item.total_bal,
                        };
                    }));
                });
            },
            minLength: 0,
            select: function(event, ui) {
                $('#agreement_id').val(ui.item.value);
                $('#bill_no').val(ui.item.bill_no);
                //$('#amount').val(ui.item.total_bal);
            }
        });

        $('#agreement_id').on('change', function(){
            $.ajax({
                url:'{{ route("check.trans")}}',
                type: "GET",
                data: { 
                  agreement_id: document.getElementById('agreement_id').value, 
                },
                success: function(response) {
                    $('#amount').val(response['value']);
                  //console.log(response['value']);
                },
                error: function(xhr) {
                  //Do Something to handle error
                }
            });
        });
        $('#bill_no').on('change', function() {
            $.ajax({
                url:'{{ route("check.trans")}}',
                type: "GET",
                data: { 
                  agreement_id: document.getElementById('agreement_id').value, 
                },
                success: function(response) {
                    $('#amount').val(response['value']);
                  //console.log(response['value']);
                },
                error: function(xhr) {
                  //Do Something to handle error
                }
            });
        });
    </script>
@endsection
