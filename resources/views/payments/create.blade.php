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
                                <form action="{{ route('payments.store', $bill->id) }}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="payment_date">Payment Date:</label>
                                                <input type="date" id="payment_date" name="payment_date"
                                                    class="form-control"
                                                    value="{{ old('payment_date', isset($agreement) ? $agreement->payment_date : now()->toDateString()) }}"
                                                    required>
                                            </div>
                                            <div class="form-group">
                                                <label for="agreement_id">Agreement ID:</label>
                                                <input type="text" id="agreement_id" name="agreement_id"
                                                    class="form-control" value="{{ $bill->agreement_id }}" readonly>

                                            </div>
                                            <div class="form-group">
                                                <label for="bill_no">Bill No:</label>
                                                <input type="text" id="bill_no" name="bill_no" class="form-control"
                                                    value="{{ $bill->id }}" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="payment_method">Mode:</label>
                                                <select id="payment_method" name="payment_method" class="form-control">
                                                    <option value="select" disabled selected>Select Mode</option>
                                                    <option value="cash">Cash</option>
                                                    <option value="cheque">Cheque</option>
                                                    <option value="online">Online</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="amount">Amount:</label>
                                                <input type="text" id="amount" name="amount" class="form-control"
                                                    value="{{ $bill->rent }}" required>

                                            </div>
                                            <div id="cheque_fields" style="display: none;">
                                                <div class="form-group">
                                                    <label for="cheque_number">Cheque Number:</label>
                                                    <input type="text" id="cheque_number" name="cheque_number"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="cheque_date">Cheque Date:</label>
                                                    <input type="date" id="cheque_date" name="cheque_date"
                                                        class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label for="bank_name">Bank Name:</label>
                                                    <input type="text" id="bank_name" name="bank_name"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div id="online_fields" style="display: none;">
                                                <div class="form-group">
                                                    <label for="online_method">Online Method:</label>
                                                    <select id="online_method" name="online_method" class="form-control">
                                                        <option value="select" disabled selected>Select Method</option>
                                                        <option value="upi">UPI</option>
                                                        <option value="netbanking">Net Banking</option>
                                                        <option value="card">Card</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="upi_id">UPI ID:</label>
                                                    <input type="text" id="upi_id" name="upi_id"
                                                        class="form-control">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="remark">Remark:</label>
                                                <textarea id="remark" name="remark" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group justify-center">
                                            <button type="submit" class="btn btn-success">Pay Now</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var paymentModeSelect = document.getElementById('payment_method');
            var chequeFields = document.getElementById('cheque_fields');
            var onlineFields = document.getElementById('online_fields');

            paymentModeSelect.addEventListener('change', function() {
                // Show additional fields based on the selected payment mode
                chequeFields.style.display = (paymentModeSelect.value === 'cheque') ? 'block' : 'none';
                onlineFields.style.display = (paymentModeSelect.value === 'online') ? 'block' : 'none';
            });
        });
    </script>
@endsection
