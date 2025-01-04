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
                        <h1>Payments</h1>
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
                                <form autocomplete="off" action="{{ isset($payment) ? (route('payments.update',$payment->id)) : (route('payments.store', $bill->id)) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_date">Payment Date:</label>
                                                <input type="date" id="payment_date" name="payment_date"
                                                    class="form-control"
                                                    value="{{ old('payment_date', isset($payment)?$payment->transaction_date :(isset($agreement) ? $agreement->payment_date : now()->toDateString())) }}"
                                                    required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="agreement_id">Agreement ID:</label>
                                                <input type="text" id="agreement_id" name="agreement_id"
                                                    class="form-control" value="{{ isset($payment)?$payment->agreement_id :$bill->agreement_id }}" readonly>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="bill_no">Bill No:</label>
                                                <input type="text" id="bill_no" name="bill_no" class="form-control"
                                                    value="{{ isset($payment)?$payment->bill_no :$bill->id }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">Balance:</label>
                                                <input type="text" id="amount" name="amount" class="form-control"
                                                value="{{ isset($payment)?$bill->total_bal :($bill->total_bal >= $amount ? $amount : $bill->total_bal) }}"  readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="pay_amt">Amount:</label>
                                                <input type="text" id="pay_amt" name="pay_amt" class="form-control" 
                                                value ="{{isset($payment)?-1*$payment->amount :''}}" required>
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="remark">Remark:</label>
                                                <textarea id="remark" name="remark" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        @if(isset($payment))
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="g8_number">G8 Number:</label>
                                                    <input id="g8_number" name="g8_number" class="form-control" required>
                                                </div>
                                            </div>
                                        @endif
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
                                        @if(isset($payment))
                                            <button id="update" type="submit" class="btn btn-success">Update</button>
                                        @else
                                            <button id="pay" type="button" class="btn btn-success" data-toggle="modal" data-target="#alertModal">Pay Now</button>
                                            <button id="payNow" type="submit" class="btn btn-success" hidden>Pay Now</button>
                                        @endif
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
    @if(isset($payment))
        <script>
            document.getElementById("payment_date").disabled = true;
            document.getElementById("pay_amt").disabled = true;
            document.getElementById("payment_method").disabled = true;
            document.getElementById("remark").disabled = true;
        </script>
    @endif
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
    </script>
@endsection
