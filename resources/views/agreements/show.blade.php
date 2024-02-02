@extends('masterlist')

@section('title', 'Agreement Details')

@section('body')
    <div class="content-wrapper">
        <div class="card-body">
            <table class="table sm-table-bordered">
                <thead>
                    <tr>
                        <th class="text-center table-success" colspan="2">Agreement Details</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($agreement->image)
                        <tr>
                            <td class="text-center" colspan="2">
                                <figure>
                                    <img src="{{ asset('images/' . $agreement->image) }}" alt="Agreement Image"
                                        style="max-width: 100%;">
                                </figure>
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <th>Agreement ID</th>
                        <td>{{ $agreement->agreement_id }}</td>
                    </tr>
                    <tr>
                        <th>Shop ID</th>
                        <td>{{ $agreement->shop_id }}</td>
                    </tr>
                    <tr>
                        <th>Tenant ID</th>
                        <td>{{ $agreement->tenant_id }}</td>
                    </tr>
                    <tr>
                        <th>With Effect From</th>
                        <td>{{ $agreement->with_effect_from }}</td>
                    </tr>
                    <tr>
                        <th>Valid Till</th>
                        <td>{{ $agreement->valid_till }}</td>
                    </tr>
                    <tr>
                        <th>Rent</th>
                        <td>{{ $agreement->rent }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $agreement->status }}</td>
                    </tr>
                    <tr>
                        <th>Remark</th>
                        <td>{{ $agreement->remark }}</td>
                    </tr>
                </tbody>
            </table>

            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr class="bg-info">
                        <th>ID</th>
                        <th>Agreement ID</th>
                        <th>Shop ID</th>
                        <th>Tenant ID</th>
                        <th>Tenant Name</th>
                        <th>Rent</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Bill Date</th>
                        <th>Month</th>
                        <th>Year</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($agreement->bills as $bill)
                        <tr>
                            <td>{{ $bill->id }}</td>
                            <td>
                                <a href="{{ route('agreements.show', $bill->agreement_id) }}">
                                    {{ $bill->agreement_id }}
                                </a>
                            </td>
                            <td>{{ $bill->shop_id }}</td>
                            <td>{{ $bill->tenant_id }}</td>
                            <td>{{ $bill->tenant_full_name }}</td>
                            <td>{{ $bill->rent }}</td>
                            <td>{{ $bill->status }}</td>
                            <td>{{ $bill->due_date }}</td>
                            <td>{{ $bill->bill_date }}</td>
                            <td>{{ $bill->month }}</td>
                            <td>{{ $bill->year }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12">No bills found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="text-center mt-3">
                <a href="#" onclick="history.back()" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
