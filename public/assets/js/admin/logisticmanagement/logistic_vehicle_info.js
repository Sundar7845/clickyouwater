//DataTable
$(document).ready(function () {
    $("#tblLogisticVehicles").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "/logisticvehicleinfo/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "logistic_partner_name" },
            { data: "fuel_type" },
            { data: "brand_name" },
            { data: "vehicle_type" },
            { data: "reg_no" },
            { data: "weight" },
            { data: "capacity" },
            { data: "action", orderable: false }
        ],
    });
    getVehicleBrandByFuelType();
});

function getVehicleBrandByFuelType() {
    $('#ddlFuelType').on('change', function () {
        var fuelTypeId = $(this).val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "get-vehicle-brands-by-fuel-type/" + fuelTypeId,
            type: 'POST',
            data: {
                fuel_type_id: fuelTypeId
            },
            success: function (response) {
                $("#ddlVehicleBrand").select2({
                    placeholder: "Select Vehicle Brand",
                });
                    $.each(response.vehicleBrands, function (index, value) {
                        $("#ddlVehicleBrand").append(
                            '<option value="' +
                            value.id +
                                '">' +
                                value.brand_name +
                                "</option>"
                        );
                    });
            }
        });
    });
}

//Edit Data
function doEdit(id) {
    $("#hdLogisticVehicleId").val(id);
    $("#ddlLogisticPartner").focus();
    $('#logisticVehicleInfoTitle').text("Update Logistic Vehicle Info");
    $("#btnSave").text("Update");
    getLogisticVehicleInfoById(id);
}

//Delete Data
function showDelete(id) {
    confirmDelete(id, "delete/logisticvehicleinfo/", "tblLogisticVehicles");
}

//Get Logistic Vehicle Info
function getLogisticVehicleInfoById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getlogisticvehicleinfo/" + id,
        dataType: "json",
        success: function (data) {
            $("#ddlLogisticPartner").val(data.logisticVehicleInfo.logistic_partner_id).trigger("change");
            $("#ddlFuelType").val(data.logisticVehicleInfo.fuel_type_id).trigger("change");
            $("#ddlVehicleBrand").val(data.logisticVehicleInfo.vehicle_brand_id).trigger("change");
            $("#ddlVehicleType").val(data.logisticVehicleInfo.vehicle_type_id).trigger("change");
            $("#txtRegNo").val(data.logisticVehicleInfo.reg_no);
            $("#txtWeight").val(data.logisticVehicleInfo.weight);
            $("#txtCapacity").val(data.logisticVehicleInfo.capacity);
            $("#pageloader").fadeOut();
        },
    });
}

//Cancel
function cancel() {
    $("#hdLogisticVehicleId").val("");
    $("#ddlLogisticPartner").focus();
    $("#ddlLogisticPartner").val("").trigger("change");
    $("#ddlFuelType").val("").trigger("change");
    $("#ddlVehicleBrand").val("").trigger("change");
    $("#ddlVehicleType").val("").trigger("change");
    $("#txtRegNo").val("");
    $("#txtWeight").val("");
    $("#txtCapacity").val("");
    $('#logisticVehicleInfoTitle').text("Logistic Vehicle Info");
    $("#btnSave").text("Save");
}

// jQuery Validation
$(function () {

    $("form[name='logisticVehicleInfo']").validate({

        rules: {
            ddlLogisticPartner: "required",
            ddlFuelType: "required",
            ddlVehicleBrand: "required",
            ddlVehicleType: "required",
            txtRegNo: "required"
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
