{{-- <!-- allocate_shop.blade.php -->
@extends('masterlist')
@section('title', 'Allocate Shop')
@section('body')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Allocate Shop</h2>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('allocate.shop.form') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="shop_id">Select a vacant shop:</label>
                                <select id="shop_id" name="shop_id" class="form-control" required
                                    style="max-height: 200px; overflow-y: auto;">
                                    <option value="" selected disabled>Select Shop</option>
                                    @foreach ($shops as $shop)
                                        @if ($shop->status === 'vaccant')
                                            <option value="{{ $shop->shop_id }}">{{ $shop->shop_id }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tenant_id">Select a tenant:</label>
                                <select id="tenant_id" name="tenant_id" class="form-control" required
                                    style=" overflow-y: auto;">
                                    <option value="" selected disabled>Select Tenant</option>
                                    @foreach ($tenants as $tenant)
                                        <option value="{{ $tenant->tenant_id }}">{{ $tenant->tenant_id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Allocate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    .ui-autocomplete {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            float: left;
            display: none;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            font-size: 14px;
            text-align: left;
            background-color: #bda5a5;
            border: 1px solid #ccc;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 4px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
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
@endsection --}}
