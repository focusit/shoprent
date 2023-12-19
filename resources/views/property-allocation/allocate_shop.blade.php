<!-- allocate_shop.blade.php -->
@extends('masterlist')
@section('title', 'Allocate Shop')

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
                        <form action="{{ route('allocate.shop.form') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="shop_search">Search for a vaccant shop:</label>
                                        <input type="text" id="shop_search" name="shop_search" class="form-control"
                                            placeholder="Search for a vacant shop... " required>
                                        <input type="hidden" id="shop_id" name="shop_id">
                                    </div>
                                    <div class="form-group">
                                        <label for="tenant_search">Search for a tenant:</label>
                                        <input type="text" id="tenant_search" name="tenant_search" class="form-control"
                                            placeholder="Search for a tenant..." required>
                                        <input type="hidden" id="tenant_id" name="tenant_id">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="agreement_id">Agreement ID:</label>
                                <input type="text" id="agreement_id" name="agreement_id" class="form-control"
                                    placeholder="Agreement ID" required>
                            </div>
                            <div class="form-group">
                                <label for="with_effect_from">With Effect From:</label>
                                <input type="date" id="with_effect_from" name="with_effect_from" class="form-control"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="valid_till">Valid Till:</label>
                                <input type="date" id="valid_till" name="valid_till" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="rent">Rent:</label>
                                <input type="text" id="rent" name="rent" class="form-control" placeholder="Rent"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status (Active/Inactive):</label>
                                <select id="status" name="status" class="form-control" required>
                                    <option value="select" disabled selected>Please Select</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="remark">Remark:</label>
                                <textarea id="remark" name="remark" class="form-control" placeholder="Remark"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="document_field">Document Field (PDF-JPEG):</label>
                                <input type="file" id="document_field" name="document_field" class="form-control"
                                    accept=".pdf, .jpeg, .jpg" required>
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
