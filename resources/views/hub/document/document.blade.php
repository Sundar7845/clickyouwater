@extends('layouts.main_master')
@section('content')
@section('title')
    Dashboard | Document
@endsection

<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">
        Upload Documents
    </h4>
    <div class="row mb-4">
        <!-- Browser Default -->
        <div class="col-md-12 mb-4 mb-md-0">
            <div class="card">
                <div class="card-body">
                    @if (Auth::user()->role_id == 4)
                        <form action="{{ route('hubdocumentscreate') }}" method="POST" enctype="multipart/form-data">
                        @elseif(Auth::user()->role_id == 5)
                            <form action="{{ route('logisticdocumentscreate') }}" method="POST"
                                enctype="multipart/form-data">
                            @else
                                <form action="{{ route('manufacturerdocumentscreate') }}" method="POST"
                                    enctype="multipart/form-data">
                    @endif
                    @csrf
                    <input type="hidden" name="hdId" id="hdId" value="{{ $id }}">
                    <div class="row">
                        <div class="col-md-12">
                            @if ($bindDocuments->count() > 0)
                                <div class="row">
                                    @foreach ($bindDocuments as $item)
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label"
                                                    for="doc_{{ $item->id }}">{{ $item->documentType->documenttype_name }}
                                                    Number
                                                    @if ($item->is_mandatory == 1)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <input type="text" id="doc_{{ $item->id }}"
                                                    name="doc_{{ $item->id }}" class="form-control"
                                                    placeholder="Enter {{ $item->documentType->documenttype_name }} Number"
                                                    value="{{ $item->document_number }}"
                                                    @if ($item->is_mandatory == 1 && $item->document_number == null) required @endif>
                                            </div>
                                        </div>
                                        <div class=" col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Upload File <sup>(PDF only)</sup>
                                                    @if ($item->is_mandatory == 1)
                                                        <span class="text-danger">*</span>
                                                    @endif
                                                </label>
                                                <input id="file_{{ $item->id }}" name="file_{{ $item->id }}"
                                                    type="file" class="form-control"
                                                    value="{{ old('file_' . $item->id) }}"
                                                    @if ($item->is_mandatory == 1 && $item->document_path == null) required @endif
                                                    accept="application/pdf" id="previewImage1" />
                                                <input type="hidden" name="hdDocumentImg_{{ $item->id }}"
                                                    id="hdDocumentImg_{{ $item->id }}"
                                                    value="{{ $item->document_path }}">
                                                <input type="hidden" name="hdDocumentTypeName"
                                                    value="{{ $item->documenttype_name }}">
                                                <input type="hidden" id="hddocumentNum_{{ $item->id }}"
                                                    name="hddocumentNum_{{ $item->id }}"
                                                    value="{{ $item->document_number }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if ($item->document_path)
                                                <div class="mb-3">
                                                    <label class="form-label">View Uploaded Document</label>
                                                    <div>
                                                        <a href="{{ asset($item->document_path) }}"
                                                            class="btn btn-primary" target="_blank"><i
                                                                class="ti ti-eye"></i>View</a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="col-md-4">
                            <div class="mt-4 mb-3">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="button" class="btn btn-danger">Cancel</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Browser Default -->
        </div>
        <!-- DataTable with Buttons -->
        <div class="col-lg-12 mb-4 mb-lg-0 mt-3">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title m-0 me-2">Documents List</h5>
                </div>
                <div class="card-datatable table-responsive pt-0">
                    <table class="table">
                        <thead class="border-bottom">
                            <tr>
                                <th>S.No</th>
                                <th>Document Name</th>
                                <th>View</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $serialNo = 1;
                            @endphp
                            @foreach ($bindDocuments as $item)
                                <tr>
                                    <td>{{ $serialNo }}</td>
                                    <td>{{ $item->documentType->documenttype_name }}</td>
                                    <td>
                                        @if ($item->document_path)
                                            <a href="{{ asset($item->document_path) }}" target="_blank"
                                                class="badge bg-label-warning border-0">Preview</a>
                                        @else
                                            <a class="badge bg-label-danger border-0">NA</a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->is_verified == 1)
                                            <a class="badge bg-label-success border-0">Verified</a>
                                        @else
                                            <a class="badge bg-label-danger border-0">Not Verified</a>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $serialNo++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ DataTable with Buttons -->
    </div>
    <!-- viewDocument Modal -->
    <div class="modal fade" id="viewDocument" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple">
            <div class="modal-content p-3 p-md-5">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <div class="text-center mb-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--/ viewDocument Modal -->
    <!-- / Content -->
@endsection
@section('footer')
    <script src="{{ asset('assets/js/hub/document/document.js') }}"></script>
@endsection
