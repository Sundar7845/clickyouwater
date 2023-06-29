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
                    <form class="browser-default-validation">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Select Document<span
                                            class="text-danger">*</span></label>
                                    <select name="" id="ddloffer" class="select2 form-select ">
                                        <option value="">Select</option>
                                        <option value="1">GST Reg</option>
                                        <option value="2">FSSAI Cert</option>
                                        <option value="3">BIS (Buareu of Ind stand)</option>
                                        <option value="4">MOU</option>
                                        <option value="5">Agreement</option>
                                        <option value="6">Brand Tie-up</option>
                                        <option value="7">Proprietor / Director PAN</option>
                                        <option value="8">Proprietor / Director Aadhar</option>
                                        <option value="9">PWD</option>
                                        <option value="10">Pollution</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Upload Document<span
                                            class="text-danger">*</span></label>
                                    <input type="file" id="basic-default-email" class="form-control"
                                        placeholder="Enter End Date" required />
                                </div>
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
                <h5 class="card-title m-0 me-2">Manufacture Wise Documents List</h5>
            </div>
            <div class="card-datatable table-responsive pt-0">
                <table id="document" class="table">
                    <thead class="border-bottom">
                        <tr>
                            <th>S.No</th>
                            <th>Document Name</th>
                            <th>View</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>GST Reg</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-warning">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>FSSAI Cert</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-danger">Rejected</span>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>BIS (Buareu of Ind stand)</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-warning">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>MOU</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-danger">Rejected</span>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Agreement</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-warning">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Brand Tie-up</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-danger">Rejected</span>
                            </td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Proprietor / Director PAN</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-warning">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Proprietor / Director Aadhar</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-danger">Rejected</span>
                            </td>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>PWD</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-warning">Pending</span>
                            </td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Pollution</td>
                            <td>
                                <a href="{{asset('water.pdf')}}" target="_blank" class="badge bg-label-warning border-0">View</a>
                            </td>
                            <td>
                                <span class="badge bg-label-danger">Rejected</span>
                            </td>
                        </tr>
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
<script src="{{ asset('assets/js/manufacturer/document/document.js') }}"></script>
@endsection
