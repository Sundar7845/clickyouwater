$(document).ready(function () {
    //placeholder for select2
    placeholderForSelect2();
});
//Check user mobile  if already exists
$("#txtMobile").on("focusout", function (e) {
    var mobileNumber = $(this).val();
    checkMobileNumberExists(mobileNumber, 5, $("#hdLogisticId").val(), function (result) {
        if (result == true) {
            $("#txtMobile").val("");
            $("#txtMobile").focus();
        }
    });
});

$("#ddlManufacturerName").on("change", function () {
    var manufacturer_id = $('#ddlManufacturerName').val();
    $("#ddlHubName").html("");
    $.ajax({
        url: "/get/hubs",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            manufacturer_id: manufacturer_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#ddlHubName").select2({
                placeholder: "Select Hub",
            });
            $.each(result, function (key, value) {
                $("#ddlHubName").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.hub_name +
                    "</option>"
                );
            });
        },
    });
});
// }

function placeholderForSelect2() {
    $("#ddlHubName").select2({
        placeholder: "Select Hub",
    });
}

//Validation
$(function () {
    $("form[name='logistic']").validate({
        rules: {
            txtLogisticId: "required",
            txtLogisticName: "required",
            "ddlManufacturerName[]": {
                required: true,
            },
            "ddlHubName[]": {
                required: true,
            },
            txtYearsOfExperience: "required",
            txtMobile: "required",
            txtEmail: "required",
            txtPincode1: "required",
            txtCreditPeriod: "required",
            txtSettlementPeriod: "required",
            // password: "required",
            // password_confirmation: {
            //     required: true,
            //     equalTo: "#password"
            // },
            ddlState: "required",
            ddlCity: "required",
            ddlArea: "required",
            txtAddress: "required",
            txtPincode: "required",
            txtProprietorName: "required",
            txtProprietorMobile: "required",
            txtProprietorEmail: "required",
            txtContactPersonEmail1: "required",
            txtContactPersonMobile: "required",
            txtContactPersonEmail2: "required",
            ddlfueltype: "required",
            ddlvehicletype: "required",
            ddlvehiclebrand: "required",
            txtregno: "required",
            txtdriverName: "required",
            txtlicenseNo: "required",
            licenseImg: "required",
            dtlicenseExpiry: "required",
        },
        messages: {
            required: "This field is required",
            // password_confirmation: "Password and confirm password is doesn't match",
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents(".form-group"));
            } else {
                // This is the default behavior
                // error.insertAfter(element);
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

//Validation
$(function () {
    $("form[name='logistic_edit']").validate({
        rules: {
            txtLogisticId: "required",
            txtLogisticName: "required",
            "ddlManufacturerName[]": {
                required: true,
            },
            "ddlHubName[]": {
                required: true,
            },
            txtYearsOfExperience: "required",
            txtMobile: "required",
            txtEmail: "required",
            txtPincode1: "required",
            txtCreditPeriod: "required",
            txtSettlementPeriod: "required",
            ddlState: "required",
            ddlCity: "required",
            ddlArea: "required",
            txtAddress: "required",
            txtPincode: "required",
            txtProprietorName: "required",
            txtProprietorMobile: "required",
            txtProprietorEmail: "required",
            txtContactPersonEmail1: "required",
            txtContactPersonMobile: "required",
            txtContactPersonEmail2: "required",
            ddlfueltype: "required",
            ddlvehicletype: "required",
            ddlvehiclebrand: "required",
            txtregno: "required",
            txtdriverName: "required",
            txtlicenseNo: "required",
            licenseImg: "required",
            dtlicenseExpiry: "required",
        },
        messages: {
            required: "This field is required",
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio")) {
                error.appendTo(element.parents(".form-group"));
            } else {
                // This is the default behavior
                // error.insertAfter(element);
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
    $("#txtLogisticName").val("");
    $("#ddlManufacturerName").val("").trigger("change");
    $("#ddlHubName").val("").trigger("change");
    $("#txtYearsOfExperience").val("");
    $("#txtMobile").val("");
    $("#txtEmail").val("");
    $("#txtCreditPeriod").val("");
    $("#txtSettlementPeriod").val("");
    $("#ddlState").val(0).trigger("change");
    $("#ddlCity").val(0).trigger("change");
    $("#ddlArea").val(0);
    $("#txtAddress").val("");
    $("#txtPincode").val("");
    $("#txtProprietorName").val("");
    $("#txtProprietorMobile").val("");
    $("#txtProprietorEmail").val("");
    $("#txtContactPersonName").val("");
    $("#txtContactPersonMobile").val("");
    $("#txtContactPersonEmail").val("");
    $("input[type='file']").val("");
    $(".valid").val("");
    $("#txtLogisticName").focus();
}

//var RowIndex = 1;

// function validateVehicleInfo() {
//     var ddlfueltype = document.forms["logistic"]["ddlfueltype"];
//     var ddlvehicletype = document.forms["logistic"]["ddlvehicletype"];
//     var ddlvehiclebrand = document.forms["logistic"]["ddlvehiclebrand"];
//     var txtregno = document.forms["logistic"]["txtregno"];

//     if (ddlfueltype.value == "") {
//         alert('Select Fuel Type');
//         ddlfueltype.focus();
//         return false;
//     }

//     if (ddlvehicletype.value == "") {
//         alert('Select Vehicle Type');
//         ddlvehicletype.focus();
//         return false;
//     }

//     if (ddlvehiclebrand.value == "") {
//         alert('Select Vehicle Brand');
//         ddlvehiclebrand.focus();
//         return false;
//     }

//     if (txtregno.value == "") {
//         alert('Select Register Number');
//         txtregno.focus();
//         return false;
//     }
//     return true;
// }

// function addVehicleInfo() {

//     //Validate vehicle info
//     if (validateVehicleInfo()) {

//         var editRowIndex = $("#hdEditVehicleInfoRowId").val();
//         var vehicleinfodata = "";
//         var FUL = $("#ddlfueltype option:selected").val();
//         var FUT = $("#ddlfueltype option:selected").text();
//         var VHL = $("#ddlvehicletype option:selected").val();
//         var VHT = $("#ddlvehicletype option:selected").text();
//         var VHB = $("#ddlvehiclebrand option:selected").val();
//         var VBT = $("#ddlvehiclebrand option:selected").text();
//         var RNO = $("#txtregno").val();

//         if (($("tr[FUL=" + FUL + "]" + "[VHL=" + VHL + "]" + "[VHB=" + VHB + "]" + "[RNO=" + RNO + "]").length == 0)) {
//         if (editRowIndex == 0) {
//             vehicleinfodata += "<tr id='trvehicle" + RowIndex + "' FUL=" + FUL + " VHL=" + VHL + " VHB=" + VHB + " RNO=" + RNO + " >";
//             vehicleinfodata += "<td><input type='hidden' name='tabFuel[]' value=" + FUL + ">" + FUT + "</td>";
//             vehicleinfodata += "<td><input type='hidden' name='tabVehicleType[]' value=" + VHL + ">" + VHT + "</td>";
//             vehicleinfodata += "<td><input type='hidden' name='tabVehicleBrand[]' value=" + VHB + ">" + VBT + "</td>";
//             vehicleinfodata += "<td><input type='hidden' name='tabRegNo[]' value=" + RNO + ">" + RNO + "</td>";
//             vehicleinfodata += "<td><a><i class='text-primary ti ti-pencil me-1' onclick = 'doEditVehicle(" + RowIndex + ");'></i></a><a><i class='text-danger ti ti-trash me-1' onclick ='removeRowVehicle(" + RowIndex + ");'></i></a></td>";
//             vehicleinfodata += "</tr>";
//             RowIndex++;
//             $("#tbodyVehicleType").append(vehicleinfodata);
//         }
//         else if (editRowIndex > 0) {
//             $("#trvehicle" + editRowIndex + " td:eq(0)").text(FUT);
//             $("#trvehicle" + editRowIndex + " td:eq(1)").text(VHT);
//             $("#trvehicle" + editRowIndex + " td:eq(2)").text(VBT);
//             $("#trvehicle" + editRowIndex + " td:eq(3)").text(RNO);
//             showAddImageVehicle();
//             $("#hdEditVehicleInfoRowId").val(0);
//         }
//         formClearVehicle();
//         // showEditImage();
//     }else{
//         alert('Item Alredy exist');
//     }
//     }
// }

// function doEditVehicle(SID) {
//     $("#hdEditVehicleInfoRowId").val(SID);
//     $("#ddlfueltype").val($("#trvehicle" + SID).attr("FUL")).trigger("change");
//     $("#ddlvehicletype").val($("#trvehicle" + SID).attr("VHL")).trigger("change");
//     $("#ddlvehiclebrand").val($("#trvehicle" + SID).attr("VHB")).trigger("change");
//     $("#txtregno").val($("#trvehicle" + SID + " td:eq(3)").text());
//     showEditImageVehicle();
// }

// function showAddImageVehicle() {
//     $("#btnUpdate").css("display", "none");
//     $("#btnAdd").css("display", "block");
// }
// function showEditImageVehicle() {
//     $("#btnUpdate").css("display", "block");
//     $("#btnAdd").css("display", "none");
// }

// function removeRowVehicle(SID) {
//     $("#trvehicle" + SID).remove();
// }

//for vehicle
// function formClearVehicle() {
//     $("#ddlfueltype").val("");
//     $("#ddlvehicletype").val("");
//     $("#ddlvehiclebrand").val("").trigger('change');
//     $("#txtregno").val("");
// }
///Driver Info
// var RowIndex = 1;

// function validateDriverInfo() {
//     var txtdriverName = document.forms["logistic"]["txtdriverName"];
//     var txtlicenseNo = document.forms["logistic"]["txtlicenseNo"];
//     var licenseImg = document.forms["logistic"]["licenseImg"];
//     var dtlicenseExpiry = document.forms["logistic"]["dtlicenseExpiry"];

//     if (txtdriverName.value == "") {
//         alert('Enter Driver Name');
//         txtdriverName.focus();
//         return false;
//     }

//     if (txtlicenseNo.value == "") {
//         alert('Enter License Number');
//         txtlicenseNo.focus();
//         return false;
//     }

//     if (licenseImg.value == "") {
//         alert('Upload License Image');
//         licenseImg.focus();
//         return false;
//     }

//     if (dtlicenseExpiry.value == "") {
//         alert('Enter License Expiry Date');
//         dtlicenseExpiry.focus();
//         return false;
//     }
//     return true;
// }
// function addDriverInfo() {

//     //Validate vehicle info
//     if (validateDriverInfo()) {

//         var editRowIndex = $("#hdEditDriverInfoRowId").val();
//         var driverinfodata = "";
//         var DRN = $("#txtdriverName").val();
//         var LIN = $("#txtlicenseNo").val();
//         var LIM = $("#licenseImg").val();
//         var LDE = $("#dtlicenseExpiry").val();

//         if (($("tr[DRN=" + DRN + "]" + "[LIN=" + LIN + "]" + "[LIM=" + LIM + "]" + "[LDE=" + LDE + "]").length == 0)) {
//         if (editRowIndex == 0)
//         {
//             driverinfodata += "<tr id='trdriver" + RowIndex + "' DRN=" + DRN + " LIN=" + LIN + " LIM=" + LIM + " LDE=" + LDE + " >";
//             driverinfodata += "<td><input type='hidden' name='tabDriverName[]' value=" + DRN + ">" + DRN + "</td>";
//             driverinfodata += "<td><input type='hidden' name='tabLicenseNo[]' value=" + LIN + ">" + LIN + "</td>";
//             driverinfodata += "<td><img src=" + LIM + " class='avatar' width='50' height='50'/></td>";
//             driverinfodata += "<td><input type='hidden' name='tabLicenseEpry[]' value=" + LDE + ">" + LDE + "</td>";
//             driverinfodata += "<td><a><i class='text-primary ti ti-pencil me-1' onclick = 'doEdit(" + RowIndex + ");'></i></a><a><i class='text-danger ti ti-trash me-1' onclick ='removeRow(" + RowIndex + ");'></i></a></td>";
//             driverinfodata += "</tr>";
//             RowIndex++;
//             $("#tbodyDriverInfo").append(driverinfodata);
//         }
//         else if (editRowIndex > 0) {
//             $("#trdriver" + editRowIndex + " td:eq(0)").text(DRN);
//             $("#trdriver" + editRowIndex + " td:eq(1)").text(LIN);
//             $("#trdriver" + editRowIndex + " td:eq(2)").text(LIM);
//             $("#trdriver" + editRowIndex + " td:eq(3)").text(LDE);
//             showAddImage();
//             $("#hdEditDriverInfoRowId").val(0);
//         }
//         formClear();
//     }else{
//         alert('Item Alredy exist');
//     }
//     }
// }

// function doEdit(SID)
// {
//     $("#hdEditDriverInfoRowId").val(SID);
//     $("#txtdriverName").val($("#trdriver" + SID).attr("DRN"));
//     $("#txtlicenseNo").val($("#trdriver" + SID).attr("LIN"));
//     $("#licenseImg").val($("#trdriver" + SID).attr("VHB"));
//     $("#dtlicenseExpiry").val($("#trdriver" + SID + " td:eq(3)").text());
//     showEditImage();
// }

// function showAddImage() {
//     $("#btnUpdateDriver").css("display", "none");
//     $("#btnAddDriver").css("display", "block");
// }

// function showEditImage() {
//     $("#btnUpdateDriver").css("display", "block");
//     $("#btnAddDriver").css("display", "none");
// }

// function removeRow(SID) {
//     $("#trdriver" + SID).remove();
// }

// //for vehicle
// function formClear() {alert('check');
//     $("#txtdriverName").val("");
//     $("#txtlicenseNo").val("");
//     $("#licenseImg").val("");
//     $("#dtlicenseExpiry").val("");
// }
