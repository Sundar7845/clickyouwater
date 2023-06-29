@extends('layouts.main_master')
@section('content')
@section('title')
    Bank | Click Your Order | Dashboard
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="bankTittle">
        Bank
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('add.bank') }}" method="POST" name="bank" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="hdBankId" id="hdBankId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtBankName">Bank Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="txtBankName" id="txtBankName" placeholder="Bank Name"
                                        title="Enter Bank Name" maxlength="255" class="form-control" value="{{ old('txtBankName') }}"
                                        required>
                                </div>
                                @if ($errors->has('txtBankName'))
                                    <div class="text-danger" id="errors">{{ $errors->first('txtBankName') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="mt-4 mb-3">
                                    <button type="submit" class="btn btn-success" id="btnSave">Save</button>
                                    <button type="button" class="btn btn-danger" id="btnCancel"
                                        onclick="cancel();">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Browser Default -->
    </div>
    <!-- DataTable with Buttons -->
    <div class="col-lg-12 mb-4 mb-lg-0">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title m-0 me-2">Bank List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblBankList" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>BANK NAME</th>
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
<script src="{{ asset('assets/js/admin/masters/bank.js') }}"></script>
@endsection
