<!-- allocate_shop.blade.php -->
@extends('masterlist')
@section('title', 'Allocate Shop')
@section('body')

    <head>
        <style>
            .ui-autocomplete {
                position: absolute;
                top: 100%;
                left: 0;
                height: 300px;
                z-index: 1000;
                float: left;
                display: none;
                min-width: 160px;
                padding: 5px 0;
                margin: 2px 0 0;
                list-style: none;
                font-size: 14px;
                text-align: left;
                background-color: #ffffff;
                border: 1px solid #ccc;
                border: 1px solid rgba(0, 0, 0, 0.15);
                border-radius: 4px;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
                overflow-y: scroll
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
@section('body')
    <div class="content-wrapper">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card card-success mt-5">
                    <div class="card-header">
                        <h2 class="card-title">Allocate Shop</h2>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form
                            action="{{ isset($agreement) ? route('agreements.update', $agreement->agreement_id) : route('allocate.shop.form') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (isset($agreement))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_search">Search for a vacant shop:</label>
                                        <input type="text" id="shop_search" name="shop_search" class="form-control"
                                            value="{{ old('shop_search', isset($agreement) ? $agreement->shop_id : '') }}"
                                            placeholder="Search for a vacant shop..." required>
                                        @error('shop_search')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="hidden" id="shop_id" name="shop_id"
                                            value="{{ old('shop_id', isset($agreement) ? $agreement->shop_id : '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tenant_search">Search for a tenant:</label>
                                        <input type="text" id="tenant_search" name="tenant_search" class="form-control"
                                            value="{{ old('tenant_search', isset($agreement) ? $agreement->tenant_id : '') }}"
                                            placeholder="Search for a tenant..." required>
                                        @error('tenant_search')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="hidden" id="tenant_id" name="tenant_id"
                                            value="{{ old('tenant_id', isset($agreement) ? $agreement->tenant_id : '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="agreement_id">Agreement ID:</label>
                                        <input type="text" id="agreement_id" name="agreement_id" class="form-control"
                                            value="{{ old('agreement_id', isset($agreement) ? $agreement->agreement_id : '') }}"
                                            placeholder="Agreement ID" required>
                                        @error('agreement_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="with_effect_from">With Effect From:</label>
                                        <input type="date" id="with_effect_from" name="with_effect_from"
                                            class="form-control"
                                            value="{{ old('with_effect_from', isset($agreement) ? $agreement->with_effect_from : '') }}"
                                            required>
                                        @error('with_effect_from')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="valid_till">Valid Till:</label>
                                        <input type="date" id="valid_till" name="valid_till" class="form-control"
                                            value="{{ old('valid_till', isset($agreement) ? $agreement->valid_till : '') }}"
                                            required>
                                        @error('valid_till')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rent">Rent:</label>
                                        <input type="text" id="rent" name="rent" class="form-control"
                                            placeholder="Rent"
                                            value="{{ old('rent', isset($agreement) ? $agreement->rent : '') }}" required>
                                    </div>
                                    @error('rent')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status (Active/Inactive):</label>
                                        <select id="status" name="status" class="form-control" required>
                                            <option value="select" disabled>Please Select</option>
                                            <option value="active"
                                                {{ old('status', isset($agreement) && $agreement->status == 'active' ? 'selected' : '') }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ old('status', isset($agreement) && $agreement->status == 'inactive' ? 'selected' : '') }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="remark">Remark:</label>
                                        <textarea id="remark" name="remark" class="form-control" placeholder="Remark">{{ old('remark', isset($agreement) ? $agreement->remark : '') }}</textarea>
                                    </div>
                                    @error('remark')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="document_field">Document Field (PDF-JPEG):</label>
                                <input type="file" id="document_field" name="document_field" class="form-control"
                                    value="{{ old('rent', isset($agreement) ? $agreement->document_field : '') }}"
                                    accept=".pdf, .jpeg, .jpg">
                                @error('document_field')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-danger toastsDefaultDefault">Allocate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        //date validation 
        document.getElementById('valid_till').addEventListener('change', function() {
            var withEffectFrom = document.getElementById('with_effect_from').value;
            var validTill = this.value;

            if (withEffectFrom && validTill && withEffectFrom > validTill) {
                document.getElementById('date-error').innerText =
                    'Valid Till date should not be less than With Effect From date.';
                this.value = ''; // Reset the input value
            } else {
                document.getElementById('date-error').innerText = 'invalid';
            }
        });
        // Initialize jQuery UI Autocomplete for Shop Search
        $('#shop_search').autocomplete({
            source: function(request, response) {
                $.post('{{ route('autocomplete.search') }}', {
                    query: request.term,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.shop_id,
                            value: item.shop_id,
                        };
                    }));
                });
            },
            minLength: 0,
            select: function(event, ui) {
                console.log(ui.item.value);
                $('#shop_id').val(ui.item.value);
            }
        });
        //Initialize jQuery UI Autocomplete for Tenant Search
        $('#tenant_search').autocomplete({
            source: function(request, response) {
                $.post('{{ route('autocomplete.tenants') }}', {
                    query: request.term,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value,
                        };
                    }));
                });
            },
            minLength: 0,
            select: function(event, ui) {
                $('#tenant_id').val(ui.item.value);
            }
        });
    </script>
@endsection
