@extends('layouts.main_master') @section('content')
@section('title')
    Auto Code Settings | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold">
        Auto Code Settings
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            {{-- <div class="card"> --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-12 col-md-12">
                        <div class="nav-align-top mb-4">
                            <ul class="nav nav-pills mb-3 nav-fill" role="tablist">
                                {{-- <li class="nav-item">
                                    <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-home"
                                        aria-controls="navs-pills-justified-home" aria-selected="true">
                                        <i class="tf-icons ti ti-layout-board-split ti-xs me-1"></i> Master
                                    </button>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-profile"
                                        aria-controls="navs-pills-justified-profile" aria-selected="false">
                                        <i class="tf-icons ti ti-location ti-xs me-1"></i> Sales
                                    </button>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-messages"
                                        aria-controls="navs-pills-justified-messages" aria-selected="false">
                                        <i class="tf-icons ti ti-shopping-cart ti-xs me-1"></i> Purchase
                                    </button>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                        data-bs-target="#navs-pills-justified-logistic"
                                        aria-controls="navs-pills-justified-logistic" aria-selected="false">
                                        <i class="tf-icons ti ti-notes ti-xs me-1"></i> Accounts
                                    </button>
                                </li> --}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="navs-pills-justified-home" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card-body">
                                                <form action="{{ route('masterbillsettings') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="hdMasterId" id="hdMasterId"
                                                        value="{{ $data->id ?? '' }}">
                                                    <div class="row">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label></label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <strong>Prefix</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <strong>Length</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <strong>Live</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <strong>Example</strong>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Manufacturer</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtManuPrefix" id="txtManuPrefix"
                                                                        value="{{ $data->manufacture_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" name="txtManuLength"
                                                                        min="0" step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        id="txtManuLength" class="form-control"
                                                                        value="{{ $data->manufacture_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" class="form-control"
                                                                        min="0" step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtManuLive" id="txtManuLive"
                                                                        value="{{ (int) ($data->manufacture_live ?? '') }}"
                                                                        readonly>

                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $manExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Hub</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtHubPrefix" id="txtHubPrefix"
                                                                        value="{{ $data->hub_prefix ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" class="form-control"
                                                                        min="0" step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtHubLength" id="txtHubLength"
                                                                        value="{{ $data->hub_length ?? '' }}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" class="form-control"
                                                                        min="0" step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtHubLive" id="txtHubLive"
                                                                        value="{{ (int) ($data->hub_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $hubExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Logistic</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtLogisticPrefix"
                                                                        id="txtLogisticPrefix"
                                                                        value="{{ $data->logistics_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtLogisticLength"
                                                                        id="txtLogisticLength" class="form-control"
                                                                        value="{{ $data->logistics_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" name="txtLogisticLive"
                                                                        min="0" step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        id="txtLogisticLive" class="form-control"
                                                                        value="{{ (int) ($data->logistics_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $logExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Customer</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" name="txtCusPrefix"
                                                                        id="txtCusPrefix" class="form-control"
                                                                        value="{{ $data->customer_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtCusLength" id="txtCusLength"
                                                                        class="form-control"
                                                                        value="{{ $data->customer_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtCusLive" id="txtCusLive"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->customer_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $cusExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Employee</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtDlPrefix" id="txtDlPrefix"
                                                                        value="{{ $data->employee_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtDlLength" id="txtDlLength"
                                                                        class="form-control"
                                                                        value="{{ $data->employee_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtDlLive" id="txtDlLive"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->employee_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $empExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Delivery Person</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" name="txtEmpPrefix"
                                                                        id="txtEmpPrefix" class="form-control"
                                                                        value="{{ $data->deliveryperson_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" name="txtEmpLength"
                                                                        id="txtEmpLength" class="form-control"
                                                                        value="{{ $data->deliveryperson_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtEmpLive" id="txtEmpLive"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->deliveryperson_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $delExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Ledger</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" name="txtLedPrefix"
                                                                        id="txtLedPrefix" class="form-control"
                                                                        value="{{ $data->ledger_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" name="txtLedLength"
                                                                        id="txtLedLength" class="form-control"
                                                                        value="{{ $data->ledger_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtLedLive" id="txtLedLive"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->ledger_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $ledExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Order</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" name="txtOrderPrefix"
                                                                        id="txtOrderPrefix" class="form-control"
                                                                        value="{{ $data->ORD_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" name="txtOrderLength"
                                                                        id="txtOrderLength" class="form-control"
                                                                        value="{{ $data->ORD_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtOrderLive" id="txtOrderLive"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->ORD_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $ordExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Invoice</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" name="txtInvoicePrefix"
                                                                        id="txtInvoicePrefix" class="form-control"
                                                                        value="{{ $data->INV_prefix ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" name="txtInvoiceLength"
                                                                        id="txtInvoiceLength" class="form-control"
                                                                        value="{{ $data->INV_length ?? '' }}"
                                                                        required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        name="txtInvoiceLive" id="txtInvoiceLive"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->INV_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $invExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Payment</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtPaymentPrefix"
                                                                        value="{{ $data->Pay_prefix ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" class="form-control"
                                                                        value="{{ $data->Pay_length ?? '' }}"
                                                                        name="txtPaymentLength">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->Pay_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $payExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Surrender</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtSurrenderPrefix"
                                                                        value="{{ $data->SUR_prefix ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" class="form-control"
                                                                        value="{{ $data->SUR_length ?? '' }}"
                                                                        name="txtSurrenderLength">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->SUR_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $surExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Stock Outward</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtStockOutwardPrefix"
                                                                        value="{{ $data->outward_prefix ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" class="form-control"
                                                                        value="{{ $data->outward_length ?? '' }}"
                                                                        name="txtStockOutwardLength">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->outward_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $outwardExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Admin Order</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtAdminOrderPrefix"
                                                                        value="{{ $data->adminorder_prefix ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" class="form-control"
                                                                        value="{{ $data->adminorder_length ?? '' }}"
                                                                        name="txtAdminOrderLength">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->adminorder_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $adminorderExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-2">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <strong>Logistic Booking</strong>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="txtLPBookingPrefix"
                                                                        value="{{ $data->LPBooking_prefix ?? '' }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number" min="0"
                                                                        step=".01" class="form-control"
                                                                        value="{{ $data->LPBooking_length ?? '' }}"
                                                                        name="txtLPBookingLength">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <input type="number"
                                                                        oninput="validity.valid||(value='');"
                                                                        class="form-control"
                                                                        value="{{ (int) ($data->LPBooking_live ?? '') }}"
                                                                        readonly>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <span>{{ $LPBookingExample }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center mt-3">
                                                        <button type="submit"
                                                            class="btn btn-success me-1 submit">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-profile" role="tabpanel">
                                    <form>
                                        @csrf
                                        <input type="hidden" name="hdSalesId" id="hdSalesId" value="">
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Prefix</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Length</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Live</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Example</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Sales Order</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="txtSoPrefix"
                                                            id="txtSrPrefix" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="number" min="0" step=".01"
                                                            class="form-control" name="txtSoLength" id="txtSrLength"
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="number" oninput="validity.valid||(value='');"
                                                            class="form-control" name="txtSoLive" id="txtSrLive"
                                                            value="" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>11</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Sales Return</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="txtSrPrefix"
                                                            id="txtSrPrefix" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="number" min="0" step=".01"
                                                            class="form-control" value="3">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="number" oninput="validity.valid||(value='');"
                                                            class="form-control" value="1" disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>SR002</span> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Sales Invoice</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="SI">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="5">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="8"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>SI00008</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Delivery</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="SD">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="3"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>4</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Delivery Return</strong> </strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="DR">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="2"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>3</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn btn-success me-1 submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-messages" role="tabpanel">
                                    <form>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Prefix</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Length</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Live</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Example</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Purchase Order</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="PO">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="2"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>PO3</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>GRN</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="GRN">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="2"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>2</span> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Purchase Return</strong> </strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="PR">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="1"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>2</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Purchase Invoice</strong> </strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="PI">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>1</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn btn-success me-1 submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="navs-pills-justified-logistic" role="tabpanel">
                                    <form>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label></label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Prefix</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Length</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Live</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <strong>Example</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Credit Note</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="CN">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>CN1</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Debit Note</strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="DN">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>1</span> </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <strong>Receipt</strong> </strong>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="RE">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="5">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" value="0"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <span>RE00001</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3">
                                            <button type="submit" class="btn btn-success me-1 submit">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </div> --}}
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection
