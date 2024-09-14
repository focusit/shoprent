<!-- allocate_shop.blade.php -->
@extends('masterlist')
@section('title', 'Allocate Shop')
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
                        <form autocomplete="off"
                            action="{{ isset($agreement) ? route('agreements.update', $agreement[0]->agreement_id) : route('allocate.shop.form') }}"
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
                                            value="{{ old('shop_search', 
                                            isset($agreement) ? $agreement[0]->shop_id :( isset($shop) ? $shop->shop_id :'')) }}"
                                            placeholder="Search for a vacant shop..." required>
                                        @error('shop_search')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="hidden" id="shop_id" name="shop_id"
                                            value="{{ old('shop_id', 
                                            isset($agreement) ? $agreement[0]->shop_id : ( isset($shop) ? $shop->id :'') ) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tenant_search">Search for a tenant:</label>
                                        <input type="text" id="tenant_search" name="tenant_search" class="form-control"
                                            value="{{ old('tenant_search', isset($agreement) ? $agreement[0]->tenant_id : '') }}"
                                            placeholder="Search for a tenant..." required>
                                        @error('tenant_search')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        <input type="hidden" id="tenant_id" name="tenant_id"
                                            value="{{ old('tenant_id', isset($agreement) ? $agreement[0]->tenant_id : '') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Shop Address :</label>
                                        <input type="text" id="address" name="address" class="form-control"
                                            value="{{ old('address',
                                            isset($agreement) ? $agreement[0]->shop->address : (isset($shop)? $shop->address:'') ) }}"
                                            placeholder="Shop Address"  readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tenant_name">Tenant Name:</label>
                                        <input type="text" id="tenant_name" name="tenant_name" class="form-control"
                                            value="{{ old('tenant_name', isset($agreement) ? $agreement[0]->tenant->full_name : '')}}"
                                            placeholder="Tenant Name" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="agreement_id">Agreement ID:</label>
                                        <input type="text" id="agreement_id" name="agreement_id" class="form-control"
                                            value="{{ old('agreement_id', isset($agreement) ? $agreement[0]->agreement_id : '') }}"
                                            placeholder="Agreement ID" oninput="checkAgreementId()" required>
                                        <span id="agreementIdStatus"></span>
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
                                            value="{{ old('with_effect_from', isset($agreement) ? $agreement[0]->with_effect_from : now()->toDateString()) }}"
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
                                            value="{{ old('valid_till', isset($agreement) ? $agreement[0]->valid_till : '') }}"
                                            required>
                                        @error('valid_till')
                                            <div class="text-danger" >{{ $message }}</div>
                                        @enderror
                                        <span id="date-error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rent">Rent:</label>
                                        <input type="text" id="rent" name="rent" class="form-control"
                                            placeholder="Rent"
                                            value="{{ old('rent',
                                            isset($agreement) ? $agreement[0]->rent : (isset($shop) ? $shop->rent :('' ) )) }}" required>
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
                                                {{ old('status', isset($agreement) && $agreement[0]->status == 'active' ? 'selected' : '') }}>
                                                Active</option>
                                            <option value="inactive"
                                                {{ old('status', isset($agreement) && $agreement[0]->status == 'inactive' ? 'selected' : '') }}>
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
                                        <textarea id="remark" name="remark" class="form-control" placeholder="Remark">
                                            {{ old('remark', isset($agreement) ? $agreement[0]->remark : '') }}</textarea>
                                    </div>
                                    @error('remark')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="openBal">Opening Balance:</label>
                                        <input id="openBal" name="openBal" class="form-control" placeholder="Opening Balance"
                                        value="{{ old('openBal', isset($agreement) ? $agreement[0]->openBal : '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="document_field">Document Field (PDF-JPEG):</label>
                                        <input type="file" id="document_field" name="document_field" class="form-control"
                                            value="{{ old('rent', isset($agreement) ? $agreement[0]->document_field : '') }}"
                                            accept=".pdf, .jpeg, .jpg">
                                        @error('document_field')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if(isset($agreement))
                                <button type="submit" class="btn btn-warning" id="save" >Update</button>
                            @else
                                <button type="button" class="btn btn-danger" id="button" data-toggle="modal" data-target="#alertModel">
                                    Allocate
                                </button>
                                <button type="submit" class="btn btn-primary" id="save" hidden>Allocate</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal -->
<div class="modal fade" id="alertModel" role="dialog">
    <div class="modal-dialog">  
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                <h4 class="modal-title">Are you sure you want to {{ isset($shop) ? 'Update ' : 'Create ' }} </h4>
            </div>
            <div class="modal-body row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    <span>Shop ID</span><br>
                    <span>Tenant ID</span><br>
                    <span>Agreement ID</span><br>
                    <span>With Effect from </span><br>
                    <span>Valid Till</span><br>
                    <span>Rent </span><br>
                </div>
                <div class="col-md-6">
                    <span id="data1"></span><br>
                    <span id="data2"></span><br>
                    <span id="data3"></span><br>
                    <span id="data4"></span><br>
                    <span id="data5"></span><br>
                    <span id="data6"></span><br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="submit" >Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@if(isset($agreement))
    <script>
        document.getElementById("shop_search").disabled = true;
        document.getElementById("tenant_search").disabled = true;
        document.getElementById("agreement_id").disabled = true;
        document.getElementById("with_effect_from").disabled = true;
        document.getElementById("rent").disabled = true;
        //document.getElementById("status").disabled = true;
    </script>
@endif
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function() {
            document.getElementById("data1").innerText = $('#shop_id').val();
            $('#button').click(function(){
                document.getElementById("data1").innerText = $('#shop_id').val();
                document.getElementById("data2").innerText = $('#tenant_id').val();
                document.getElementById("data3").innerText = $('#agreement_id').val();
                document.getElementById("data4").innerText = $('#with_effect_from').val();
                document.getElementById("data5").innerText = $('#valid_till').val();
                document.getElementById("data6").innerText = $('#rent').val();
            });
            $('#submit').click(function(){
                $('#save').trigger('click');
            });
            var bill="{{ isset($bill) ? $bill : '0' }}";
            if(bill >= 2 ){
                document.getElementById("openBal").disabled = true;
            }
        });
        
        //date validation 
        document.getElementById('valid_till').addEventListener('change', function() {
            var withEffectFrom = document.getElementById('with_effect_from').value;
            var validTill = this.value;

            if (withEffectFrom && validTill && withEffectFrom > validTill) {
                document.getElementById('date-error').innerText =
                    'Valid Till date should not be less than With Effect From date.';
                this.value = withEffectFrom; // Reset the input value
            } else {
                document.getElementById('date-error').innerText = '';
            }
        });
        // Initialize jQuery UI Autocomplete for Shop Search
        $('#shop_search').autocomplete({
            source: function(request, response) {
                $.post('{{ route("autocomplete.search")}}', {
                    query: request.term,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.shop_id,
                            value: item.shop_id,
                            id: item.id,
                            rent: item.rent,
                            address: item.address,
                        }; 
                        
                    }));
                });
            },
            minLength: 0,
            select: function(event, ui) {
                $('#shop_id').val(ui.item.id);
                $('#rent').val(ui.item.rent);
                $('#address').val(ui.item.address);
            }
        });
        //Initialize jQuery UI Autocomplete for Tenant Search
        $('#tenant_search').autocomplete({
            source: function(request, response) {
                $.post('{{ route("autocomplete.tenants") }}', {
                    query: request.term,
                    _token: '{{ csrf_token() }}'
                }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.label,
                            value: item.value,
                            full_name: item.full_name,
                        };
                    }));
                });
            },
            minLength: 0,
            select: function(event, ui) {
                $('#tenant_id').val(ui.item.value);
                $('#tenant_name').val(ui.item.full_name);
            }
        });

        function checkAgreementId() {
            var agreementId = document.getElementById('agreement_id').value;
            var agreementIdStatus = document.getElementById('agreementIdStatus');

            if (agreementId.trim() === '') {
                agreementIdStatus.innerHTML = '<span style="color: red;">Please enter an Agreement ID</span>';
                return;
            }

            console.log('Checking Agreement ID:', agreementId);

            // Perform an AJAX request to check the Agreement ID
            fetch('/checkAgreementId', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token
                    },
                    body: JSON.stringify({
                        agreement_id: agreementId
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    // console.log('Response Data:', data);

                    agreementIdStatus.innerHTML = data.exists ?
                        '<span style="color: red;">Agreement ID already exists!</span>' :
                        '<span style="color: green;">Agreement ID is available!</span>';
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            // document.getElementById('agreement_id').addEventListener('input', checkAgreementId);

        }
    </script>
@endsection
