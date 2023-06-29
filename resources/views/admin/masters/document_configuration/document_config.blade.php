@extends('layouts.main_master')
@section('content')
@section('title')
    Document Configuration | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="documentTitle">
        Document Configuration
    </h4>

    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form name="document_config" action="{{ route('adddocumentconfig') }}" method="post">
                        @csrf
                        <input type="hidden" id="hdDocumentConfigId" name="hdDocumentConfigId" value="">
                        <input type="hidden" id="hdDocumentTypeId" name="hdDocumentTypeId" value="">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-3">
                                    <label class="form-label" for="ddlDocumentType">Document Type Name<span
                                            class="text-danger">*</span>
                                    </label>
                                    <select class="select2 form-select" id="ddlDocumentType" name="ddlDocumentType"
                                        required title="Select Document Type Name">
                                        <option value="">Select Document Type</option>
                                        @foreach ($documenttype as $item)
                                            <option value="{{ $item->id }}"
                                                {{ old('ddlDocumentType') == $item->id ? 'selected' : '' }}>
                                                {{ $item->documenttype_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('ddlDocumentType'))
                                        <div class="text-danger">{{ $errors->first('ddlDocumentType') }}</div>
                                    @endif
                                    <span class="error"></span>
                                </div>
                                <div class="mt-4 mb-3">
                                    <button class="btn btn-success" id="btnSave" type="submit">Save</button>
                                    <button class="btn btn-danger" type="button" onclick="cancel()">Cancel</button>
                                </div>
                            </div>
                            <div class="col-md-7 mb-4 mb-md-0">
                                <div class="card-datatable table-responsive pt-0">
                                    <table class="table">
                                        <thead class="border-bottom">
                                            <tr>
                                                <th>Applicable To</th>
                                                <th>Mandatory</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($documentModule as $item)
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="form-check-input"
                                                                id="chkModuleName{{ $item->id }}"
                                                                name="chkModuleName[]"
                                                                title="Please Choose Any Document Module"
                                                                value="{{ $item->id }}" required>
                                                            {{ $item->module_name }}
                                                            @if ($errors->has('chkModuleName'))
                                                                <div class="text-danger">
                                                                    {{ $errors->first('chkModuleName') }}</div>
                                                            @endif
                                                            <span class="error"></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="col-sm-6">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="chkMandatory{{ $item->id }}"
                                                                    name="chkMandatory[{{ $item->id }}]"
                                                                    value="1">
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                <h5 class="card-title m-0 me-2">Document List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table class="table" id="tblDocumentConfig">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Document Name</th>
                            <th>Status</th>
                            <th>Action</th>
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
<script src="{{ asset('assets/js/admin/masters/documentconfig.js') }}"></script>
@endsection