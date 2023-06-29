@extends('layouts.main_master') @section('content')
@section('title')
    Settings | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Settings
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            {{-- <div class="card"> --}}
            <div class="card-body">
                {{-- <form class="browser-default-validation"> --}}
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-home"
                                        aria-controls="navs-pills-justified-home" aria-selected="true">
                                        <i class="tf-icons ti ti-home ti-xs me-1"></i> Product type
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-profile"
                                        aria-controls="navs-pills-justified-profile" aria-selected="false">
                                        <i class="tf-icons ti ti-home-2 ti-xs me-1"></i> Manufacturer
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-messages"
                                        aria-controls="navs-pills-justified-messages" aria-selected="false">
                                        <i class="tf-icons ti ti-home-2 ti-xs me-1"></i> Hub
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-logistic"
                                        aria-controls="navs-pills-justified-logistic" aria-selected="false">
                                        <i class="tf-icons ti ti-truck ti-xs me-1"></i> Logistic
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-customer"
                                        aria-controls="navs-pills-justified-customer" aria-selected="false">
                                        <i class="tf-icons ti ti-users ti-xs me-1"></i> Customer
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="navs-pills-justified-home" role="tabpanel">
                                    <form method="post" action="{{ url('settings-create') }}" name="product_type"
                                        id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Complex Headers -->
                                                {{-- <div class="card"> --}}
                                                <div class="card-datatable table-responsive pt-0">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th rowspan="2">S.no</th>
                                                                <th rowspan="2">Product Type</th>
                                                                <th colspan="3" class="text-center">price
                                                                </th>
                                                                <th colspan="2" class="text-center">Alert
                                                                </th>
                                                            </tr>
                                                            <tr>
                                                                <th>Manufacturer
                                                                    <div class="text-muted p-1">
                                                                        <small class="bg-light p-1">(₹)</small>
                                                                    </div>
                                                                </th>
                                                                <th>Logistic
                                                                    <div class="text-muted p-1">
                                                                        <small class="bg-light p-1">(₹)</small>
                                                                    </div>
                                                                </th>
                                                                <th>Hub
                                                                    <div class="text-muted p-1">
                                                                        <small class="bg-light p-1">(₹)</small>
                                                                    </div>
                                                                </th>
                                                                <th>Before Shipment
                                                                    <div class="text-muted p-1">
                                                                        <small class="bg-light p-1">(mins)</small>
                                                                    </div>
                                                                </th>
                                                                <th>After Shipment
                                                                    <div class="text-muted p-1">
                                                                        <small class="bg-light p-1">(mins)</small>
                                                                    </div>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($products)
                                                                @foreach ($products as $product)
                                                                    <tr>
                                                                        <td>{{ $loop->index + 1 }} <input type="hidden"
                                                                                name="action[{{ $product->id ? $product->id : $loop->index + 1 }}]"
                                                                                value="@if ($product->id != '' || $product->id != null) {{ 'update' }} @else {{ 'new' }} @endif">
                                                                        </td>
                                                                        <td>{{ $product->product_type_name }} 
                                                                            <div class="text-muted p-1">
                                                                                <small class="bg-light p-1">{{  $product->category_name }}</small>
                                                                            </div> 
                                                                            <input
                                                                                type="hidden"
                                                                                name="product_id[{{ $product->id ? $product->id : $loop->index + 1 }}]"
                                                                                value="{{ $product->product_id }}">
                                                                            <input type="hidden" name="id[]"
                                                                                value="{{ $product->id ? $product->id : $loop->index + 1 }}">
                                                                        </td>
                                                                        <td><input type="number"
                                                                                name="man[{{ $product->id ? $product->id : $loop->index + 1 }}]"
                                                                                min="0" step=".01"
                                                                                oninput="validity.valid||(value='');"
                                                                                value="{{ $product->manufacture_price ? $product->manufacture_price : 0 }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="number"
                                                                                name="logistic[{{ $product->id ? $product->id : $loop->index + 1 }}]"
                                                                                min="0" step=".01"
                                                                                oninput="validity.valid||(value='');"
                                                                                value="{{ $product->logistics_price ? $product->logistics_price : 0 }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="number"
                                                                                name="hub[{{ $product->id ? $product->id : $loop->index + 1 }}]"
                                                                                min="0" step=".01"
                                                                                oninput="validity.valid||(value='');"
                                                                                value="{{ $product->hub_price ? $product->hub_price : 0 }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="number"
                                                                                name="before_shipment[{{ $product->id ? $product->id : $loop->index + 1 }}]"
                                                                                min="0" step=".01"
                                                                                oninput="validity.valid||(value='');"
                                                                                value="{{ $product->before_ship_mins_alert ? $product->before_ship_mins_alert : 0 }}"
                                                                                class="form-control"></td>
                                                                        <td><input type="number"
                                                                                name="after_shipment[{{ $product->id ? $product->id : $loop->index + 1 }}]"
                                                                                min="0" step=".01"
                                                                                oninput="validity.valid||(value='');"
                                                                                value="{{ $product->after_ship_mins_alert ? $product->after_ship_mins_alert : 0 }}"
                                                                                class="form-control"></td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                                    
                                                        </tbody>
                                                    </table>
                                                    <div class="d-flex justify-content-center mt-3">
                                                        <button type="submit"
                                                            class="btn btn-success me-1 submit">Update</button>
                                                    </div>
                                                </div>
                                                {{-- </div> --}}
                                                <!--/ Complex Headers -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                    <form method="post" action="{{ url('settings-manufacturer') }}"
                                        name="product_type" id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-4">
                                            <label class="form-label">Deliver products to logistic within <small
                                                    class="text-muted">(hrs)</small><span class="text-danger">*</span>
                                                <span></span>
                                            </label>
                                            <input type="hidden" name="id"
                                                value="@if (isset($manufacturer)) {{ $manufacturer->id ? $manufacturer->id : '' }} @else {{ 'new' }} @endif">
                                            <input type="number" name="deliver_to_logistics_hrs" min="0"
                                                step=".01" oninput="validity.valid||(value='');"
                                                value="@if (isset($manufacturer)) {{ $manufacturer->time }} @endif"
                                                placeholder="Enter Hours" class="form-control numvalidate" />
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="btn btn-success me-1 submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                                    <form method="post" action="{{ url('settings-hub') }}" name="product_type"
                                        id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Extra Charges <small class="text-muted">(per
                                                        km)</small><span class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="hidden" name="id"
                                                        value="@if (isset($hub)) {{ $hub->id ? $hub->id : '' }} @else {{ 'new' }} @endif">
                                                    <input type="number" min="0"
                                                        oninput="validity.valid||(value='');"
                                                        placeholder="Enter Charges"name="extra_charges_per_km"
                                                        value="@if (isset($hub)) {{ $hub->extra_charges_per_km ? $hub->extra_charges_per_km : 0 }}@else {{ 0 }} @endif"
                                                        class="form-control numvalidate" />
                                                    <span class="input-group-text" id="basic-addon11">KM</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="btn btn-success me-1 submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-logistic" role="tabpanel">
                                    <form method="post" action="{{ url('settings-logistic') }}" name="product_type"
                                        id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Receive products from Manufacturer
                                                    within <small class="text-muted">(hrs)</small><span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="hidden" name="id"
                                                    value="@if (isset($logistic)) {{ $logistic->id ? $logistic->id : '' }} @else {{ 'new' }} @endif">
                                                <input type="number" name="receive_from_manufacture_hrs"
                                                    placeholder="Enter Hours" min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="@if (isset($logistic)) {{ $logistic->receive_from_manufacture_hrs }} @endif"
                                                    class="form-control numvalidate" />
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Deliver products within <small
                                                        class="text-muted">(hrs)</small><span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="deliver_to_hub_hrs"
                                                    placeholder="Enter Hours" min="0" step=".01"
                                                    oninput="validity.valid||(value='');"
                                                    value="@if (isset($logistic)) {{ $logistic->deliver_to_hub_hrs }} @endif"
                                                    class="form-control numvalidate" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="btn btn-success me-1 submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-customer" role="tabpanel">
                                    <form method="post" action="{{ url('settings-customer') }}" name="product_type"
                                        id="register-form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label">Customer Not Placed Order Within <small
                                                        class="text-muted">(DAYS)</small><span
                                                        class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="hidden" name="id"
                                                        value="@if (isset($customer)) {{ $customer->id ? $customer->id : '' }} @else {{ 'new' }} @endif">
                                                    <input type="number" name="customer_not_placed_order_within"
                                                        value="@if(isset($customer)){{$customer->customer_not_placed_order_within}}@endif"
                                                        placeholder="Enter Days" class="form-control" />
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Show Invoice to Customer<small
                                                        class="text-muted">(days)</small><span
                                                        class="text-danger">*</span>
                                                </label>
                                                <div class="input-group">
                                                    <input type="number" name="show_invoice_days" 
                                                        min="0" step=".01"
                                                        oninput="validity.valid||(value='');"   
                                                        value="@if(isset($customer)){{ $customer->show_invoice_days ? $customer->show_invoice_days : 0  }}@endif"
                                                        placeholder="Enter Show Invoice to Customer" class="form-control" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="btn btn-success me-1 submit">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- </form> --}}
            </div>
            {{-- </div> --}}
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection
