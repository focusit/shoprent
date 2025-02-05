@extends('masterlist')

@section('title', 'Agreement List')

@section('body')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col">
                        <h1>Agreements List</h1>
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
                                <h3 class="card-title">Agreement Details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" id="myTabs">
                                    <li class="nav-item">
                                        <a class="nav-link " id="allAgreementsTab" data-toggle="tab"
                                            href="#allAgreements">All
                                            Agreements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" id="activeAgreementsTab" data-toggle="tab"
                                            href="#activeAgreements">Active Agreements</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="inactiveAgreementsTab" data-toggle="tab"
                                            href="#inactiveAgreements">Inactive
                                            Agreements</a>
                                    </li>
                                </ul>


                                <!-- Card Body -->
                                <div class="card-body">
                                    <!-- Tab Content -->
                                    <div class="tab-content" id="myTabsContent">
                                        <!-- All Agreements Tab -->
                                        <div class="tab-pane fade show " id="allAgreements" style="height:500px;overflow: scroll;">
                                            <!-- Table for All Shops -->
                                            <table id="example1" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center bg-info">
                                                        <th>ID</th>
                                                        <th>Agreement ID</th>
                                                        <th>Shop ID</th>
                                                        <th>Tenant ID</th>
                                                        <th>Tenant Name</th>
                                                        <th>With Effect From</th>
                                                        <th>Valid Till</th>
                                                        <th>Rent</th>
                                                        <th>Opening Balance</th>
                                                        <th>Document</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($agreements as $agreement)
                                                        <tr class="text-center">
                                                            <td>{{ $agreement->id }}</td>
                                                            <td>{{ $agreement->agreement_id }}</td>
                                                            <td>
                                                                @forelse($shops as $shop)
                                                                    @if ($shop->id == $agreement->shop_id)
                                                                        {{ $shop->shop_id }}
                                                                    @endif
                                                                @empty
                                                                    
                                                                @endforelse<!--Shop Id-->
                                                            </td>
                                                            <td>{{ $agreement->tenant_id }}</td>
                                                            @forelse ($tenants as $tenant)
                                                                @if ($tenant->tenant_id === $agreement->tenant_id)
                                                                    <td>{{ $tenant->full_name }}</td>
                                                                @endif
                                                            @empty
                                                                <td> </td>
                                                            @endforelse
                                                            <td>{{ date('d-m-Y',strtotime($agreement->with_effect_from)) }}</td>
                                                            <td>{{ date('d-m-Y',strtotime($agreement->valid_till ))}}</td>
                                                            <td>{{ $agreement->rent }}</td>
                                                            <td>
                                                                @forelse($transaction as $trans)
                                                                    @if ($trans->agreement_id == $agreement->agreement_id)
                                                                        {{ $trans->amount }}
                                                                    @endif
                                                                @empty
                                                                    
                                                                @endforelse<!--Opening Balance-->
                                                                </td>
                                                            <td>
                                                                @if ($agreement->document_field)
                                                                    @php
                                                                        $extension = pathinfo($agreement->document_field, PATHINFO_EXTENSION);
                                                                    @endphp

                                                                    @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                        <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                            target="_blank">
                                                                            <img src="{{ asset('documents/' . $agreement->document_field) }}"
                                                                                alt="Agreement Image" width="50">
                                                                        </a>
                                                                    @elseif (strtolower($extension) === 'pdf')
                                                                        <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                            target="_blank">
                                                                            View PDF
                                                                        </a>
                                                                    @else
                                                                        No Data
                                                                    @endif
                                                                @else
                                                                    No Data
                                                                @endif
                                                            </td>
                                                            <td class="px-2">
                                                                <a title="Edit Agreement" href="{{ route('agreements.edit', $agreement->agreement_id) }}"
                                                                    class="btn btn-info btn-sm"><i
                                                                        class="fas fa-edit"></i></a>
                                                                <a title="Show Details" href="{{ route('agreements.show', $agreement->agreement_id) }}"
                                                                    class="btn btn-success btn-sm"><i class="fa fa-eye"
                                                                        aria-hidden="true"></i></a>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="11">No agreements found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- <--------------------------------------Active Agreements--------------------------------------------> --}}
                                        <div class="tab-pane fade show active" id="activeAgreements" style="height:500px;overflow: scroll;"> <!-- Table for Occupied Shops -->
                                            <table id="active_agreement" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center bg-info">
                                                        <th>ID</th>
                                                        <th>Agreement ID</th>
                                                        <th>Shop ID</th>
                                                        <th>Tenant ID</th>
                                                        <th>Tenant Name </th>
                                                        <th>With Effect From</th>
                                                        <th>Valid Till</th>
                                                        <th>Rent</th>
                                                        <th>Document</th>
                                                        <th>Opening Balance</th>
                                                        <th>Action</th>
                                                        <th>Generate Bill</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($agreements as $agreement)
                                                        @if ($agreement->status === 'active')
                                                            <tr class="text-center">
                                                                <td>{{ $agreement->id }}</td>
                                                                <td>{{ $agreement->agreement_id }}</td>
                                                                <td>
                                                                @forelse($shops as $shop)
                                                                    @if ($shop->id == $agreement->shop_id)
                                                                        {{ $shop->shop_id }}
                                                                    @endif
                                                                @empty
                                                                    
                                                                @endforelse<!--Shop Id-->
                                                                </td>
                                                                <td>{{ $agreement->tenant_id }}</td>
                                                                @forelse ($tenants as $tenant)
                                                                    @if ($tenant->tenant_id === $agreement->tenant_id)
                                                                        <td>{{ $tenant->full_name }}</td>
                                                                    @endif
                                                                @empty
                                                                    <td> </td>
                                                                @endforelse
                                                                <td>{{ date('d-m-Y',strtotime($agreement->with_effect_from)) }}</td>
                                                                <td>{{ date('d-m-Y',strtotime($agreement->valid_till)) }}</td>
                                                                <td>{{ $agreement->rent }}</td>
                                                                <td>
                                                                    @if ($agreement->document_field)
                                                                        @php
                                                                            $extension = pathinfo($agreement->document_field, PATHINFO_EXTENSION);
                                                                        @endphp

                                                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                            <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                                target="_blank">
                                                                                <img src="{{ asset('documents/' . $agreement->document_field) }}"
                                                                                    alt="Agreement Image" width="50">
                                                                            </a>
                                                                        @elseif (strtolower($extension) === 'pdf')
                                                                            <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                                target="_blank">
                                                                                View PDF
                                                                            </a>
                                                                        @else
                                                                            No Data
                                                                        @endif
                                                                    @else
                                                                        No Data
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                @forelse($transaction as $trans)
                                                                    @if ($trans->agreement_id == $agreement->agreement_id)
                                                                        {{ $trans->amount }}
                                                                    @endif
                                                                @empty
                                                                    
                                                                @endforelse<!--Opening Balance-->
                                                                </td>
                                                                <td class="px-2">
                                                                    <a title="Edit Agreement" href="{{ route('agreements.edit', $agreement->agreement_id) }}"
                                                                        class="btn btn-info btn-sm"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <a title="Show Details" href="{{ route('agreements.show', $agreement->agreement_id) }}"
                                                                        class="btn btn-success btn-sm"><i class="fa fa-eye"
                                                                            aria-hidden="true"></i>
                                                                    </a>
                                                                    {{-- <form action="" method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" title="Delete Agreement" class="btn btn-app btn-danger btn-sm"
                                                                            onclick="return confirm('Are you sure?')"><i class="fa fa-trash"
                                                                                aria-hidden="true"></i>
                                                                        </button>
                                                                    </form> --}}
                                                                </td>
                                                                <td>
                                                                    <a title="Generate Bill for Next Month" href="{{ route('bills.billGenerate', $agreement->agreement_id) }}" 
                                                                    class="btn btn-warning btn-sm">Generate</a>
                                                                    <a title="Show last Bill" href= "{{ route('bills.lastbill', $agreement->agreement_id )}}"
                                                                    class="btn btn-primary btn-sm">Last Bill</a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td colspan="11">No inactive agreements found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <--------------------------------------Inactive Agreements--------------------------------------------> --}}
                                        <div class="tab-pane fade" id="inactiveAgreements" style="height:500px;overflow: scroll;">
                                            <table id="inactiveAgreementsTable" class="table table-bordered table-striped">
                                                <thead>
                                                    <tr class="text-center bg-info">
                                                        <th>ID</th>
                                                        <th>Agreement ID</th>
                                                        <th>Shop ID</th>
                                                        <th>Tenant ID</th>
                                                        <th>Tenant Name</th>
                                                        <th>With Effect From</th>
                                                        <th>Valid Till</th>
                                                        <th>Rent</th>
                                                        <th>Document</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($agreements as $agreement)
                                                        @if ($agreement->status == 'inactive')
                                                            <tr class="text-center">
                                                                <td>{{ $agreement->id }}</td>
                                                                <td>{{ $agreement->agreement_id }}</td>
                                                                <td>{{ $agreement->shop_id }}</td>
                                                                <td>{{ $agreement->tenant_id }}</td>
                                                                @forelse ($tenants as $tenant)
                                                                    @if ($tenant->tenant_id === $agreement->tenant_id)
                                                                        <td>{{ $tenant->full_name }}</td>
                                                                    @endif
                                                                @empty
                                                                    <td> </td>
                                                                @endforelse
                                                                <td>{{ date('d-m-Y',strtotime($agreement->with_effect_from)) }}</td>
                                                                <td>{{ date('d-m-Y',strtotime($agreement->valid_till)) }}</td>
                                                                <td>{{ $agreement->rent }}</td>
                                                                <td>
                                                                    @if ($agreement->document_field)
                                                                        @php
                                                                            $extension = pathinfo($agreement->document_field, PATHINFO_EXTENSION);
                                                                        @endphp

                                                                        @if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                                                            <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                                target="_blank">
                                                                                <img src="{{ asset('documents/' . $agreement->document_field) }}"
                                                                                    alt="Agreement Image" width="50">
                                                                            </a>
                                                                        @elseif (strtolower($extension) === 'pdf')
                                                                            <a href="{{ asset('documents/' . $agreement->document_field) }}"
                                                                                target="_blank">
                                                                                View PDF
                                                                            </a>
                                                                        @else
                                                                            No Data
                                                                        @endif
                                                                    @else
                                                                        No Data
                                                                    @endif
                                                                </td>
                                                                <td class="px-2">
                                                                    <a title="Edit Agreement" href="{{ route('agreements.edit', $agreement->agreement_id) }}"
                                                                        class="btn btn-info btn-sm"><i
                                                                            class="fas fa-edit"></i></a>
                                                                    <a title="Show Details" href="{{ route('agreements.show', $agreement->agreement_id) }}"
                                                                        class="btn btn-success btn-sm"><i class="fa fa-eye"
                                                                            aria-hidden="true"></i>
                                                                    </a>
                                                                    {{-- <a title="Delete Agreement" href="{{ route('agreements.destroy', $agreement->agreement_id) }}"
                                                                        class="btn btn-success btn-sm"><i class="fa fa-eye"
                                                                            aria-hidden="true"></i>
                                                                    </a> --}}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @empty
                                                        <tr>
                                                            <td colspan="11">No active online agreements found.</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize tabs
            $('#myTabs a').on('click', function(e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    </script>
@endpush
