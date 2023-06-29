@extends('layouts.main_master') @section('content')
@section('title')
    @if ($type === 'all')
        All Orders
    @elseif ($type === 'today')
        Today's Orders
    @elseif ($type === 'thismonth')
        This Month's Orders
    @else
        Invoice Downloaded Orders
    @endif | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        @if ($type === 'all')
            All Orders
        @elseif ($type === 'today')
            Today's Orders
        @elseif ($type === 'thismonth')
            This Month's Orders
        @else
            Invoice Downloaded Orders
        @endif
    </h4>
    <div class="card">
        <div class="card-body">
            <form class="browser-default-validation">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="ddlState">State Name</label>
                            <select name="ddlState" id="ddlState" class="select2 form-select ">
                                <option value="">Select State</option>
                                @foreach ($state as $item)
                                    <option value="{{ $item->id }}">{{ $item->state_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="ddlState">District Name</label>
                            <select name="ddlCity" id="ddlCity" class="select2 form-select ">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-email">Hub Name</label>
                            <select name="ddlHub" id="ddlHub" class="select2 form-select ">
                                <option value="">Select</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Area Name</label>
                            <select name="" id="" class="select2 form-select ">
                                <option value="">SELECT Area</option>
                                <option value="1">saravanampatti</option>
                                <option value="2">hopes</option>
                                <option value="3">perur</option>
                            </select>
                        </div>
                    </div> --}}
                    <div class="col-md-3 mt-4" id="hdDivDate">
                        <button type="button" class="btn btn-flat btn-primary" id="btnDate" style="height: 36px;">
                            <i class="fa fa-calendar"></i>
                            <span id="spnDate" style="padding-left: 5px;">Today</span>
                            <i class="fa fa-caret-down" style="padding-left: 5px;"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-datatable table-responsive pt-0">
                <table id="tblInvoicedownloadedorders" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>ORDER.NO</th>
                            <th>INV.NO</th>
                            <th>INVOICE DATE</th>
                            <th>CUSTOMER NAME</th>
                            <th>QTY</th>
                            <th>AMOUNT</th>
                            <th>ORDER STATUS</th>
                            <th>DOWNLOAD</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--/ DataTable with Buttons -->
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/orders/invoice_downloaded_orders.js') }}"></script>
@endsection
