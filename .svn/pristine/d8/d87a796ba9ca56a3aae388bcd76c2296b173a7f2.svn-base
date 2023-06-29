@extends('layouts.main_master')
@section('content')
@section('title')
    Dashboard | Purchase Return List
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-1 mb-4">
        Purchase Return List
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Report Type</label>
                                <select id="ddlRtype" class="select2 form-select " control="ddl"
                                    data-live-search="true">
                                    <option value="1">Summary</option>
                                    <option value="2">Detail View </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>&nbsp; </label>
                            <div class="form-group" id="divsearchsummary">
                                <input type="text" class="form-control" id="txtSearch" maxlength="50"
                                    placeholder="Search by Suppplier Name" autocomplete="off" />
                            </div>
                            <div class="form-group" id="divsearch" style="display: none;">
                                <div>
                                    <input type="text" class="form-control" id="txtProductSearch" autocomplete="off"
                                        placeholder="Search by Item/ Suppplier Name" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>&nbsp; </label>
                            <div class="form-group">
                                <a href="{{ route('purchasereturn') }}"><button type="button" id="btnNew"
                                        class="btn btn-primary"> Add New</button></a>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label>&nbsp; </label>
                            <div class="text-sm-right">
                                <button type="button" id="btnexport"
                                    class="btn btn-success btn-rounded waves-effect waves-light mb-3">
                                    <i></i>Export </button>
                            </div>
                        </div>
                        <div class="col-md-4 mt-4">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-flat btn-primary" id="btnDate"
                                style="height: 36px;">
                                <i class="fa fa-calendar"></i><span id="spnDate"
                                    style="padding-left: 5px;">Today</span>
                                <i class="fa fa-caret-down"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <h5>Purchase Return Details</h5>
                            <div class="card-datatable table-responsive pt-0">
                                <table id="purchasereturn" class="table"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>S.No </th>
                                            <th>PR.No</th>
                                            <th>PR.Date</th>
                                            <th>Suppplier Name</th>
                                            <th>Tax Amt</th>
                                            <th>BIll Amt</th>
                                            <th>Paid Amt</th>
                                            <th>Balance Amt</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyList">
                                        <tr>
                                            <td>1</td>
                                            <td>PR005</td>
                                            <td>01/02/23</td>
                                            <td>Rajesh</td>
                                            <td>2698</td>
                                            <td>25000</td>
                                            <td>5000</td>
                                            <td>20000</td>
                                            <td>
                                                <a><i class="text-primary ti ti-pencil me-1"></i></a>
                                                <a><i class="text-danger ti ti-trash me-1"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="4" style="text-align: left;">TOTAL </th>
                                            <th>2698</th>
                                            <th>25000</th>
                                            <th>5000</th>
                                            <th>20000</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
</div>
<!-- / Content -->
@endsection
@section('footer')
<script src="{{ asset('assets/js/admin/purchasemanagement/purchasereturn.js') }}"></script>
@endsection