$(document).ready(function () {
    //Load Manufacturer on Hub edit
    if ($("#hub_id").val() > 0) {
        setTimeout(function () {
            $("#ddlCity").trigger("change");
        }, 2000);
    }
    //Get Manufacturer
    $("#ddlCity").on("change", function () {
        getManufacturer();
    });

    //Show Load Manufacturer
    $("#dropzone").show();
});

//Check user mobile number if already exists
$("#txtMobile").on("focusout", function (e) {
    var mobileNumber = $(this).val();
    checkMobileNumberExists(mobileNumber, 4, $("#hub_id").val(), function (result) {
        if (result == true) {
            $("#txtMobile").val("");
            $("#txtMobile").focus();
        }
    });
});

function getManufacturer() {
    $.ajax({
        url: "/get/manufacturer",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            latitude: $("#txtlatitude").val(),
            longtitude: $("#txtlangtitute").val(),
            state_id: $("#ddlState").val(),
            city_id: $("#ddlCity").val(),
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            var manufacturerArray = [];

            $.each(result, function (key, value) {
                var obj = JSON.parse(value.distance);
                var manufacturer = {
                    id: value.manufacturer_id,
                    name: value.manufacturer_name,
                    address: value.address,
                    hubCount: value.hub_count,
                    distance_value: obj.distance.value,
                    distance: obj.distance.text,
                };
                manufacturerArray.push(manufacturer);
            });

            // Sort the array by distance
            manufacturerArray.sort(function (a, b) {
                return a.distance_value - b.distance_value;
            });

            // Generate HTML using the sorted array
            var list = "";
            $.each(manufacturerArray, function (index, value) {
                list += '<div class="col-md-4">';
                list +=
                    '<div class="form-check custom-option custom-option-icon">';
                list +=
                    '<label class="form-check-label custom-option-content" for="manufacture_' +
                    value.id +
                    '">';
                list += "<div>";
                list +=
                    '<input name="manufacturerId" class="form-check-input" type="radio" value="' +
                    value.id +
                    '" id="manufacture_' +
                    value.id +
                    '" mid="' +
                    value.id +
                    '" required>';
                list += "</div>";
                list += '<span class="custom-option-body">';
                list +=
                    '<span class="custom-option-title">' +
                    value.name +
                    "</span>";
                list += "<small>" + value.address + "</small>";
                list += "</span>";
                list +=
                    '<div class="d-flex align-items-center justify-content-between pt-1">';
                list +=
                    '<div class="badge bg-label-success">' +
                    "Total Hubs: " +
                    value.hubCount +
                    "</div>";
                list += '<div class="badge bg-label-primary"';
                list +=
                    'id="manufacturerDistance">' +
                    "Distance: " +
                    value.distance +
                    "</div>";
                list += "</div>";
                list += "</label>";
                list += "</div>";
                list += "</div>";
            });

            $(".loadManufacturer").show();
            $(".loadManufacturer").html(list);
            $(".dropzone").hide();

            if (
                $("#hdManufacturerId").val() != "" &&
                $("#hdManufacturerId").val() != undefined &&
                $("#hdManufacturerId").val() != 0
            ) {
                $("#manufacture_" + $("#hdManufacturerId").val()).prop(
                    "checked",
                    true
                );
            }
            if (
                $("#hdAreaId").val() !== "" &&
                $("#hdAreaId").val() !== undefined &&
                $("#hdAreaId").val() !== 0
            ) {
                $("#ddlArea").val($("#hdAreaId").val()).trigger("change");
            }
        },
    });
}

$('form').submit(function (e) {
    e.preventDefault();

    // Validate the field value
    var selectedManufacturer = $('input[name="manufacturerId"]:checked');
    if (selectedManufacturer.length === 0) {
        // Show the validation error message in a popup
        //   alert('Please select a manufacturer.');
        Swal.fire({
            title: "Please Choose Manufacturer",
            text: "You have to choose a manufacturer to create a hub",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        return;
    }

    // Field value is valid, continue with the form submission
    // ...
    // You can submit the form using: $(this).submit();
});


$("#ddlfueltype").on("change", function () {
    $("#pageloader").fadeIn();
    var fuel_type_id = this.value;
    $("#ddlvehiclebrand").html("");
    $.ajax({
        url: "/get/brands",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            fuel_type_id: fuel_type_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#ddlvehiclebrand").html(
                '<option value="0">Select Brand</option>'
            );
            $.each(result, function (key, value) {
                $("#ddlvehiclebrand").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.brand_name +
                    "</option>"
                );
            });
            $("#pageloader").fadeOut();
        },
    });
});

var RowIndex = 1;

function validateVehicleInfo() {
    var ddlfueltype = $("#ddlfueltype").val();
    var ddlvehicletype = $("#ddlvehicletype").val();
    var ddlvehiclebrand = $("#ddlvehiclebrand").val();
    var txtregno = $("#txtregno").val();

    if (ddlfueltype == "") {
        Swal.fire({
            title: "Select Fuel Type!",
            text: "Please select fuel type.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlfueltype").focus();
        return false;
    }

    if (ddlvehicletype == "") {
        Swal.fire({
            title: "Select Vehicle Type!",
            text: "Please select vehicle type.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlvehicletype").focus();
        return false;
    }

    if (ddlvehiclebrand == "" || ddlvehiclebrand == 0) {
        Swal.fire({
            title: "Select Vehicle Brand!",
            text: "Please select vehicle brand.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlvehiclebrand").focus();
        return false;
    }

    if (txtregno == "") {
        Swal.fire({
            title: "Enter Register Number!",
            text: "Please enter vehicle register number.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#txtregno").focus();
        return false;
    }
    return true;
}

function addVehicleInfo() {
    if (validateVehicleInfo()) {
        var editRowIndex = $("#hdEditVehicleInfoRowId").val();
        //RowIndex = (RowIndex + 1)
        var vehicleinfodata = "";
        var FUL = $("#ddlfueltype option:selected").val();
        var FUT = $("#ddlfueltype option:selected").text();
        var VHL = $("#ddlvehicletype option:selected").val();
        var VHT = $("#ddlvehicletype option:selected").text();
        var VHB = $("#ddlvehiclebrand option:selected").val();
        var VBT = $("#ddlvehiclebrand option:selected").text();
        var RNO = $("#txtregno").val();

        // const isRNOUnique = $("tr[RNO='" + RNO + "']").length === 0;
        if (($("tr[FUL=\"" + FUL + "\"]" + "[VHL=\"" + VHL + "\"]" + "[VHB=\"" + VHB + "\"]" + "[RNO=\"" + RNO + "\"]").length == 0) && editRowIndex == 0) {
            // if (isRNOUnique) {
            // if (editRowIndex == 0) {
            vehicleinfodata +=
                "<tr id='trvehicle" +
                RowIndex +
                "' FUL=" +
                FUL +
                " VHL=" +
                VHL +
                " VHB=" +
                VHB +
                " RNO=" +
                RNO +
                " >";
            vehicleinfodata +=
                "<td><input type='hidden'  class ='vehicleinfo' id='tabfueltype_" +
                RowIndex +
                "' name='tabFuel[]'  value=" +
                FUL +
                "><span id='spnFuelType'>" +
                FUT +
                "</span></td>";
            vehicleinfodata +=
                "<td><input type='hidden'  class = 'vehicleinfo' id='tabvehicletype_" +
                RowIndex +
                "' name='tabVehicleType[]'  value=" +
                VHL +
                "><span id='spnVehicleType'>" +
                VHT +
                "</span></td>";
            vehicleinfodata +=
                "<td><input type='hidden'  class = 'vehicleinfo' id='tabvehiclebrand_" +
                RowIndex +
                "' name='tabVehicleBrand[]'  value=" +
                VHB +
                "><span id='spnVehicleBrand'>" +
                VBT +
                "</span></td>";
            vehicleinfodata +=
                "<td><input type='hidden'  class = 'vehicleinfo' id='tabregno_" +
                RowIndex +
                "'  name='tabRegNo[]'  value=" +
                RNO +
                "><span id='spnRegNo'>" +
                RNO +
                "</span></td>";
            vehicleinfodata +=
                "<td><a><i class='text-primary ti ti-pencil me-1' onclick = 'doEdit(" +
                RowIndex +
                ");'></i></a><a><i class='text-danger ti ti-trash me-1' onclick ='removeRow(" +
                RowIndex +
                ");'></i></a></td>";
            vehicleinfodata += "</tr>";
            RowIndex++;
            $("#tbodyVehicleType").append(vehicleinfodata);
            formClear();
        } else if (editRowIndex > 0) {
            $(
                "#trvehicle" +
                editRowIndex +
                " td:eq(0) #tabfueltype_" +
                editRowIndex
            ).val(FUL);
            $("#trvehicle" + editRowIndex + " td:eq(0) #spnFuelType").text(
                FUT
            );
            $(
                "#trvehicle" +
                editRowIndex +
                " td:eq(1) #tabvehicletype_" +
                editRowIndex
            ).val(VHL);
            $(
                "#trvehicle" + editRowIndex + " td:eq(1) #spnVehicleType"
            ).text(VHT);
            $(
                "#trvehicle" +
                editRowIndex +
                " td:eq(2) #tabvehiclebrand_" +
                editRowIndex
            ).val(VHB);
            $(
                "#trvehicle" + editRowIndex + " td:eq(2) #spnVehicleBrand"
            ).text(VBT);
            $(
                "#trvehicle" +
                editRowIndex +
                " td:eq(3) #tabregno_" +
                editRowIndex
            ).val(RNO);
            $("#trvehicle" + editRowIndex + " td:eq(3) #spnRegNo").text(
                RNO
            );
            showAddImage();
            $("#hdEditVehicleInfoRowId").val(0);
            // }
            formClear();
        } else {
            Swal.fire({
                title: "Item Already Exits!",
                text: "This item is already present in the list!",
                icon: "error",
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false,
            });
            $("#ddlfueltype").focus();
            return false;
            // alert("This Register Number is Already Exits");
        }
    }
}

function doEdit(SID) {
    $("#hdEditVehicleInfoRowId").val(SID);
    $("#ddlfueltype")
        .val($("#trvehicle" + SID + " #tabfueltype_" + SID).val())
        .trigger("change");
    $("#ddlvehicletype")
        .val($("#trvehicle" + SID + " #tabvehicletype_" + SID).val())
        .trigger("change");
    setTimeout(function () {
        $("#ddlvehiclebrand")
            .val($("#trvehicle" + SID + " #tabvehiclebrand_" + SID).val())
            .trigger("change");
    }, 1500);
    $("#txtregno").val($("#trvehicle" + SID + " td:eq(3)").text());
    showEditImage();
}

function showAddImage() {
    $("#btnUpdate").css("display", "none");
    $("#btnAdd").css("display", "block");
}
function showEditImage() {
    $("#btnUpdate").css("display", "block");
    $("#btnAdd").css("display", "none");
}

function removeRow(SID) {
    $("#trvehicle" + SID).remove();
}

function formClear() {
    $("#ddlfueltype").val("").trigger("change");
    $("#ddlvehicletype").val("").trigger("change");
    $("#ddlvehiclebrand").val("").trigger("change");
    $("#txtregno").val("");
}

$(function () {
    $("form[name='hub']").validate({
        rules: {
            txthubId: "required",
            txthubName: "required",
            txtYrsofExp: "required",
            txtMobile: "required",
            txtofficialEmail: "required",
            manufacturerId: "required",
            txtlatitude: "required",
            txtlangtitute: "required",
            txtgeolocation: "required",
            txtRadius: "required",
            txtcreditPeriod: "required",
            txtsettlementPeriod: "required",
            txtsecurityDeposit: "required",
            // password: "required",
            // password_confirmation: {
            //     required: true,
            //     equalTo: "#password",
            // },
            // ProfileImage: "required"
            ddlState: "required",
            ddlCity: "required",
            ddlArea: "required",
            txtLandmark: "required",
            txtpinCode: "required",
            txtProprietorName: "required",
            txtProprietorMobile: "required",
            txtProprietorEmail: "required",
            txtContactPersonName: "required",
            txtContactPersonMobile: "required",
            txtContactPersonEmail: "required",
            ddlfueltype: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
            ddlvehicletype: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
            ddlvehiclebrand: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
            txtregno: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
        },
        messages: {
            required: "This field is required",
            // password_confirmation:
            //     "Password and confirm password is doesn't match",
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
        submitHandler: function (form) {
            form.submit();
        },
    });
});

$(function () {
    $("form[name='hub_edit']").validate({
        rules: {
            txthubId: "required",
            txthubName: "required",
            txtYrsofExp: "required",
            txtMobile: "required",
            txtofficialEmail: "required",
            manufacturerId: "required",
            txtlatitude: "required",
            txtlangtitute: "required",
            txtgeolocation: "required",
            txtRadius: "required",
            txtcreditPeriod: "required",
            txtsettlementPeriod: "required",
            txtsecurityDeposit: "required",
            ddlState: "required",
            ddlCity: "required",
            ddlArea: "required",
            txtLandmark: "required",
            txtpinCode: "required",
            txtProprietorName: "required",
            txtProprietorMobile: "required",
            txtProprietorEmail: "required",
            txtContactPersonName: "required",
            txtContactPersonMobile: "required",
            txtContactPersonEmail: "required",
            ddlfueltype: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
            ddlvehicletype: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
            ddlvehiclebrand: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
            txtregno: {
                required: function () {
                    return $.trim($("#tbodyVehicleType").text()) === "";
                },
            },
        },
        messages: {
            required: "This field is required",
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
        submitHandler: function (form) {
            form.submit();
        },
    });
});

function cancel() {
    $("#txthubName").val("");
    $("#txtYrsofExp").val("");
    $("#txtMobile").val("");
    $("#txtofficialEmail").val("");
    $("#txtcreditPeriod").val("");
    $("#txtsettlementPeriod").val("");
    $("#txtsecurityDeposit").val("");
    // $("#password").val("");
    // $("#password_confirmation").val("");
    $("#txtlatitude").val("");
    $("#txtlangtitute").val("");
    $("#txtgeolocation").val("");
    $("#txtcoordinates").val("");
    $("#ddlState").val("");
    $("#ddlCity").val("");
    $("#ddlArea").val("");
    $("#txtLandmark").val("");
    $("#txtpinCode").val("");
    $("#txtProprietorName").val("");
    $("#txtProprietorMobile").val("");
    $("#txtProprietorEmail").val("");
    $("#txtContactPersonName").val("");
    $("#txtContactPersonMobile").val("");
    $("#txtContactPersonEmail").val("");
    $("input[type='file']").val("");
    $(".valid").val("");
    $("#tbodyVehicleType").empty();
    $("#txthubName").focus();
}
