@extends('layouts.main_master')
@section('content')
@section('title')
    Payments | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Payments
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form id="frmPayment" action="{{ url('/payments/create') }}" method="POST"
                        onsubmit="return validateForm();">
                        @csrf
                        <input type="hidden" id="hiddenPaymentDet" name="hiddenPaymentDet">
                        <div class="row mb-4">
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon11">Payment No</span>
                                    <input type="text" class="form-control" name="txtPaymentCode" id="txtPaymentCode"
                                        readonly value="{{ $payment_auto_code }}" />
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon11">Payment Date</span>
                                    <input type="date" class="form-control" id="ddlPaymentDate" name="ddlPaymentDate"
                                        readonly aria-label="Username" aria-describedby="basic-addon11" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-text">Payment For<span class="text-danger">*</span></label>
                                        <select name="ddlPaymentFor" id="ddlPaymentFor" class="select2 form-select">
                                            <option value="0">Select Payment Type</option>
                                            @foreach ($paymentType as $item)
                                                <option value="{{ $item->id }}">{{ $item->payment_type }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="spanPaymentFor"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3" id="divVendor">
                                        <label class="form-label" for="basic-default-text">Ledger Name<span class="text-danger">*</span></label>
                                        <select id="ddlLedgerName" name="ddlLedgerName" class="select2 form-select"
                                            title="Please select Ledger" data-live-search="true">
                                            <option value="" disabled selected>Select Ledger Name</option>
                                        </select>
                                        <span class="text-danger" id="spanLedgerName"></span>
                                        Closing Balance <i class="fa fa-fw fa-inr"></i>
                                        <span id="vendorClosingbalance" class="text-danger"
                                            style="font-size: 22px;">0.00</span>
                                    </div>
                                    <div class="mb-3" id="divEmployee" style="display: none;">
                                        <label class="form-label">Employee Name</label>
                                        <select class="form-select js-select-search-ddl select2" name="ddlEmployeeName"
                                            id="ddlEmployeeName">

                                        </select>
                                        <span class="text-danger" id="spanEmployeeName"></span>
                                        Pending Balance <i class="fa fa-fw fa-inr"></i>
                                        <span id="employeeClosingBalance" class="text text-danger"
                                            style="font-size: 22px;">0.00</span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-text">Company Ledger<span class="text-danger">*</span></label>
                                        <select id="ddlCompanyLedger" name="ddlCompanyLedger"
                                            class="select2 form-select" control="ddl"
                                            title="Please select Company ledger">
                                            <option value="0">Select</option>
                                            @foreach ($companyLedger as $item)
                                                <option value="{{ $item->id }}">{{ $item->ledger_name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="spanCompanyLedgerName"></span>
                                        Closing Balance <i class="fa fa-fw fa-inr"></i>
                                        <span id="companyClosingBalance" class="text text-danger"
                                            style="font-size: 22px;">0.00</span>
                                        <input type="hidden" name="hdCompanyClosingBalance"
                                            id="hdCompanyClosingBalance">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-text">Amount<span class="text-danger">*</span></label>
                                        <input type="text" id="txtAmount" name="txtAmount" class="form-control"
                                            placeholder="Enter Amount" required
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                        <span class="text-danger" id="spanAmt"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-text">Remarks<span class="text-danger">*</span></label>
                                        <input type="text" name="txtRemarks" id="txtRemarks" class="form-control"
                                            placeholder="Enter Remarks" required />
                                        <span class="text-danger" id="spanRemarks"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="basic-default-text">Payment Mode<span class="text-danger">*</span></label>
                                        <select id="ddlPaymentMode" name="ddlPaymentMode" class="select2 form-select"
                                            control="ddl" required>
                                            <option value="">Select Payment Type</option>
                                            @foreach ($paymentMode as $item)
                                                <option value="{{ $item->id }}">{{ $item->payment_mode }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="ddlPaymentMode"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 CHQ" style="display: none;">
                                    <div class="mb-3">
                                        <label for="exampleInputtext1" id="lblTransNo"> Cheque No<span class="text-danger">*</span></label>
                                        <input id="txtChequeNo" name="txtChequeNo" type="text"
                                            class="form-control" />
                                        <span class="text-danger" id="spanChequeNo"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 CHQ" style="display: none;">
                                    <div class="mb-3">
                                        <label for="exampleInputtext1" id="lblTransDt"> Cheque Date<span class="text-danger">*</span></label>
                                        <input id="txtTransDate" name="txtTransDate" format="DD/MM/YYYY"
                                            type="date" class="form-control" />
                                        <span class="text-danger" id="spanDDDate"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 CHQ" style="display: none;">
                                    <div class="mb-3">
                                        <label for="exampleInputtext1" id="lblBranchName"> Branch Name<span class="text-danger">*</span></label>
                                        <input id="txtBranchName" name="txtBranchName" type="text"
                                            class="form-control" placeholder="Enter Branch Name" />
                                        <span class="text-danger" id="spanBranchName"></span>
                                    </div>
                                </div>
                                <div class="col-md-12 CHQ" style="display: none;">
                                    <div class="mb-3">
                                        <label> Bank Name</label>
                                        <div class="mb-3">
                                            <select name="ddlBankName" id="ddlBankName" style="width:100%"
                                                class="select2 form-select">
                                                <option value="0">Select Bank</option>
                                                @foreach ($bankName as $item)
                                                    <option value="{{ $item->id }}">{{ $item->bank_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger" id="spanBankName"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 d-flex justify-content-end">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <button type="button" class="btn btn-danger"
                                        onclick="clearInput()">Cancel</button>
                                    <a href="{{ route('paymentslist') }}" class="btn btn-primary">Go to List</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-header">
                                <h5 class="box-title text-light-blue">Pending Expense</h5>
                            </div>
                            <div class="card-datatable table-responsive pt-0">
                                <table class="table table-bordered mb-3" id="tblPaymentID">
                                    <thead class="text-center" style="background-color: #ecf0f5;">
                                        <tr>
                                            <th style="width: 30px;">
                                                <div><input type="checkbox" class="form-check-input"
                                                        id="tableHeadCheck" checked></div>
                                            </th>
                                            <th class="text-dark fw-bolder">S.No </th>
                                            <th class="text-dark fw-bolder">Expense No </th>
                                            <th class="text-dark fw-bolder">Expense Date </th>
                                            <th class="text-dark fw-bolder">Description </th>
                                            <th class="text-dark fw-bolder">Paid Amount </th>
                                            <th class="text-dark fw-bolder">Bal. Amount </th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbodyRow">
                                        <tr id="trNoRecord" val="1">
                                            <td colspan="8" class="text-muted text-center">No Records Added</td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">Total</th>
                                            <td class="text-end fw-bold" id="tdtotalAmt" name="tdtotalAmt">0.00</td>
                                            <td class="text-end fw-bold" id="tdBillAmt" name="tdBillAmt">0.00</td>
                                            <td class="text-end fw-bold" id="tdtotAmt" name="tdtotAmt">0.00</td>
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
<script src="{{ asset('assets/js/admin/accounts/payments/payment.js') }}"></script>
@endsection
