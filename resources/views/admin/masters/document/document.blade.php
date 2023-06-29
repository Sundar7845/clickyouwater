@extends('layouts.main_master')
@section('content')
@section('title')
    Document Type | Click Your Order | Dashboard
@endsection
<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4" id="documentTypeTitle">
        Document Type
    </h4>

    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('addDocumenttype') }}" name="documenttype" method="post">
                        @csrf
                        <input type="hidden" name="hdDocumentTypeNameId" id="hdDocumentTypeNameId" value="">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="txtDocumenttypeName">Document Type Name<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="txtDocumenttypeName"
                                        id="txtDocumenttypeName" placeholder="Document Type Name"
                                        title="Enter Document Type Name" value="{{ old('txtDocumenttypeName') }}" required>
                                </div>
                                @if ($errors->has('txtDocumenttypeName'))
                                    <div class="text-danger">{{ $errors->first('txtDocumenttypeName') }}</div>
                                @endif
                                <span class="error"></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-4 mb-3">
                                <button type="submit" id="btnSave" class="btn btn-success">Save</button>
                                <button type="button" onclick="cancel()" class="btn btn-danger">Cancel</button>
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
                <h5 class="card-title m-0 me-2">Document Type List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="tblDocumentType" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>DOCUMENT TYPE NAME</th>
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
<script src="{{ asset('assets/js/admin/masters/document.js') }}"></script>
@endsection
