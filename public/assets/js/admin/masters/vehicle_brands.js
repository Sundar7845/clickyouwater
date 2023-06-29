//DataTable
$(document).ready(function () {
    $("#tblVehicleBrands").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "vehiclebrands/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "fuel_type" },
            { data: "brand_name" },
            { data: "action", orderable: false },
        ],
    });
});

//Edit Data
function doEdit(id) {
    $("#hdVehicleBrandId").val(id);
    $("#ddlFuelType").focus();
    $("#vehicleBrandsTitle").text("Update Vehicle Brands");
    $("#btnSave").text("Update");
    getVehicleBrandById(id);
}

//Delete Data
function showDelete(id) {
    confirmDelete(id, "delete/vehiclebrands/", "tblVehicleBrands");
}

//Get Vehicle Brand
function getVehicleBrandById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getvehiclebrands/" + id,
        dataType: "json",
        success: function (data) {
            $("#ddlFuelType")
                .val(data.vehiclebrands.fuel_type_id)
                .trigger("change");
            $("#txtBrandName").val(data.vehiclebrands.brand_name);
            $("#pageloader").fadeOut();
        },
    });
}

//Cancel
function cancel() {
    $("#hdVehicleBrandId").val("");
    $("#ddlFuelType").focus();
    $("#ddlFuelType").val("").trigger("change");
    $("#txtBrandName").val("");
    $("#vehicleBrandsTitle").text("Vehicle Brands");
    $("#btnSave").text("Save");
}

// jquery Validation
$(function () {
    $("form[name='vehiclebrands']").validate({
        rules: {
            ddlFuelType: "required",
            txtBrandName: "required",
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
