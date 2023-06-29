var type = "";
var urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("type")) {
    type = urlParams.get("type");
}

//DataTable
$(document).ready(function () {
    //document view
    if ($('#document_view').attr('href') === '') {
        $("#document_view").parent().hide();
    } else {
        $("#document_view").parent().show();
    }

    $("#tblLogisticDrivers").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: {
            url: "/logisticdriverinfo/data/" + type,
            data: function (logisticdriverinfo) {
                logisticdriverinfo.type = type;
            }
        },
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "logistic_partner_name" },
            { data: "reg_no" },
            { data: "driver_name" },
            {
                data: "license_no",
                render: function (data, type, row) {
                    var html = "";
                    if (row.license_doc_path) {
                        var html = `<a href='${row.license_doc_path}' target='_blank'><i class="text-danger ti ti-file me-1"></i></a>`;
                    }
                    return `${row.license_no}` + " " + "<br>" + html + "</br>";
                }, orderable: false
            },
            { data: "formatted_license_expiry" },
            { data: "mobile_no" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                                        <input onclick="doStatus(${row.id});" id="chkLogisticDriver${row.id}" type="checkbox" class="switch-input" name="chkLogisticDriver" ${data == 1 ? "checked" : ""} />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>`;
                },
            },
            { data: "action", orderable: false }
        ],
    });

    $('#ddlHub').select2({
        placeholder: "Select hub"
    });

    $('#ddlLogisticPartner').on('change', function () {
        getVehicleByLogisticId();
        loadHubs();
    });
    getVehicleByLogisticId($('#ddlLogisticPartner').val());
    loadHubs($('#ddlLogisticPartner').val());
});

//Check user mobile number if already exists
$('#txtMobileNo').on('focusout', function (e) {
    var mobileNumber = $(this).val();
    checkMobileNumberExists(mobileNumber, 18, $("#hdLogisticDriverId").val(), function (result) {
        if (result == true) {
            $('#txtMobileNo').val("");
            $('#txtMobileNo').focus();
        }
    });
});


//document view show
function documentView() {
    $("#document_view").parent().show();
}

//Load Vehicles By Logistic ID
function getVehicleByLogisticId() {
    var logistic_id = $('#ddlLogisticPartner').val();
    $.ajax({
        url: "getLogisticVehicleById/" + logistic_id,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            driver_id: $("#hdLogisticDriverId").val()
        },
        success: function (response) {
            $('#ddlLogisticVehicle').html('<option value="">Select Vehicle</option>');
            $.each(response.logisticVehicle, function (index, vehicle) {
                $("#ddlLogisticVehicle").append('<option value="' + vehicle.id + '">' + vehicle.reg_no + '</option>');
            });
        }

    });
}

//Load Hub By Logistic ID
function loadHubs() {
    var logistic_id = $('#ddlLogisticPartner').val();
    $.ajax({
        url: "getHubsByLogisticId/" + logistic_id,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            driver_id: $("#hdLogisticDriverId").val()
        },
        success: function (response) {
            $("#ddlHub").select2({
                placeholder: "Select Hub",
            });
            $('#ddlHub').html('<option value=""></option>');
            $.each(response.hubs, function (index, hub) {
                $("#ddlHub").append('<option value="' + hub.id + '">' + hub.hub_name + '</option>');
            });
        }
    });
}

//Edit Data
function doEdit(id) {
    $("#hdLogisticDriverId").val(id);
    $("#ddlLogisticPartner").focus();
    $('#logisticDriverInfoTitle').text("Update Logistic Driver Info");
    // $('#hdPassword').val(id);
    $("#btnSave").text("Update");
    $("#fileLicense").removeAttr('required');
    getLogisticDriverInfoById(id);
}

//Change Active Status
function doStatus(id) {
    var status = $("#chkLogisticDriver" + id).is(":checked");
    confirmStatusChange(
        id,
        "logisticdriverinfo/",
        "tblLogisticDrivers",
        status == true ? 1 : 0,
        "chkLogisticDriver"
    );
}

//Delete Data
function showDelete(id) {
    confirmDelete(id, "delete/logisticdriverinfo/", "tblLogisticDrivers");
}

//Get Logistic Vehicle Info on Edit
function getLogisticDriverInfoById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getlogisticdriverinfo/" + id,
        dataType: "json",
        success: function (data) {
            console.log(data);
            $("#ddlLogisticPartner").val(data.logisticDriverInfo.logistic_partner_id).trigger("change");
            $("#txtDriverName").val(data.logisticDriverInfo.driver_name);
            $("#txtLicenseNo").val(data.logisticDriverInfo.license_no);
            $("#dtLicenseExpiry").val(data.logisticDriverInfo.license_expiry);
            $("#txtMobileNo").val(data.logisticDriverInfo.mobile_no);
            var path = data.logisticDriverInfo.license_doc_path;
            $("#document_view").attr("href", path);
            $("#hdFileLicense").val(data.logisticDriverInfo.license_doc_path);
            setTimeout(function () {
                $("#ddlLogisticVehicle").val(data.logisticDriverInfo.logistic_vehicle_id).trigger("change");
            }, 1500);

            setTimeout(function () {
                var hubIds = data.logisticDriverInfo.hub_id.split(",");
                console.log(hubIds);
                $("#ddlHub").val(hubIds).trigger("change");
            }, 2000);
            $("#pageloader").fadeOut();
        },
    });
    documentView();
}

//Cancel
function cancel() {
    $('#logisticDriverInfoTitle').text("Logistic Driver Info");
    $("#hdLogisticDriverId").val("");
    $("#ddlLogisticPartner").focus();
    $("#ddlLogisticPartner").val("").trigger("change");
    $("#ddlLogisticVehicle").val("").trigger("change");
    $("#ddlHub").val(0).trigger("change");
    $("#txtDriverName").val("");
    $("#txtLicenseNo").val("");
    $("#dtLicenseExpiry").val("");
    $("#txtMobileNo").val("");
    // $("#txtPassword").val("");
    // $("#txtConfirmPassword").val("");
    $("#fileLicense").val("");
    $("input[type='file']").val("");
    $("#btnSave").text("Save");
    $("#document_view").parent().hide();
}

// jQuery Validation
$(function () {

    $("form[name='logisticDriverInfo']").validate({

        rules: {
            ddlLogisticPartner: "required",
            ddlLogisticVehicle: "required",
            ddlHub: "required",
            txtDriverName: "required",
            txtLicenseNo: "required",
            dtLicenseExpiry: "required",
            txtMobileNo: "required",
            // txtPassword: {
            //     required: function () {
            //         return $.trim($('#txtPassword').val()) === '';
            //     }
            // },
            // txtConfirmPassword: {
            //     required: true,
            //     equalTo: "#txtPassword"
            // },
        },
        messages: {
            // txtConfirmPassword: "Password and confirm password is doesn't match",
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents(".form-group"));
            } else {
                if (element.siblings(".error").html() == undefined) {
                    error.appendTo(element.parent().next(".error"));
                } else {
                    error.appendTo(element.siblings(".error"));
                }
            }
        },
    });
});