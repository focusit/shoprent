<!-- resources/views/bills/generate.blade.php -->
@extends('masterlist')
@section('title', 'Edit Shop')
@section('body')
    <div class="content-wrapper">
        <h1>Generate Bills</h1>

        <form action="{{ route('bills.generate') }}" method="post">
            @csrf

            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>Shop ID</th>
                        <th>Tenant ID</th>
                        <th>Amount</th>
                        <th>Last Date</th>
                        <th>Due Date</th>
                        <th>Payment Date</th>
                        <th>Previous Balance</th>
                        <th>Discount</th>
                        <th>Subtotal</th>
                        <th>Download</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shops as $shop)
                        <tr>
                            <td>
                                {{ $shop->shop_id }}
                            </td>
                            <td>
                                {{ $shop->tenant_id }}
                            </td>
                            <td>{{ $shop->rent }}</td>
                            <td>{{ app(\App\Services\BillingService::class)->calculateLastDate($shop) }}</td>
                            <td>{{ app(\App\Services\BillingService::class)->calculateDueDate($shop) }}</td>
                            <td>{{ app(\App\Services\BillingService::class)->calculatePaymentDate($shop) }}</td>
                            <td>{{ app(\App\Services\BillingService::class)->calculatePenalty($shop) }}</td>
                            <td>{{ app(\App\Services\BillingService::class)->calculateDiscount($shop) }}</td>
                            <td>{{ app(\App\Services\BillingService::class)->calculateAmount($shop) }}</td>
                            <td>
                                <button type="btn success" onclick="downloadBill({{ $shop->shop_id }})">Download Now</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" onclick="generateBills()">Generate Bills</button>
            <button type="submit" id="generateSubmitButton" style="display: none;">Generate Bills (Hidden)</button>
        </form>

        <script>
            function generateBills() {
                // Add logic to perform any necessary actions before submitting the form
                // For example, you may want to validate inputs or calculate additional data

                // Display the "Download Now" buttons
                document.querySelectorAll('[data-download-button]').forEach(button => {
                    button.style.display = 'inline-block';
                });

                // Submit the form
                document.getElementById('generateSubmitButton').click();
            }

            function downloadBill(shopId) {
                // Add logic to trigger the download for the specific shop
                // You may use AJAX to initiate the download or redirect to a download route
                alert('Download initiated for Shop ID: ' + shopId);
            }
        </script>
    @endsection
