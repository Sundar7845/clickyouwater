$(document).ready(function () {

    //Third Party input field 
    if ($("#chkIsThirdParty").is(":checked")) {
        $(".ThirdParty").show();
    } else {
        $(".ThirdParty").hide();
    }

    //calculate Total turn over
    $('#txtAnnualTurnOver, #txtThirdPartyTurnover').on('input', function () {
        var value1 = $('#txtAnnualTurnOver').val(); // get value of input1
        var value2 = $('#txtThirdPartyTurnover').val(); // get value of input2
        var sum = Number(value1) + Number(value2); // add values together
        $('#txtTotalTurnover').val(sum); // set value of input3 to the sum
    });
});

//Check user mobile number if already exists
$("#txtMobile").on("focusout", function (e) {
    var mobileNumber = $(this).val();
    
    checkMobileNumberExists(mobileNumber, 3, $("#hdMFId").val(), function (result) {
        if (result == true) {
            $("#txtMobile").val("");
            $("#txtMobile").focus();
        }
    });
});
//Third Party Tie-Up 
$('#chkIsThirdParty').on('change', function () {
    if ($(this).is(':checked')) {
        $(this).val('1');
    } else {
        $(this).val('0');
        $("#txtThirdpartyBrands").val("");
        $("#txtThirdpartyBrandName").val("");
        $("#txtThirdPartyTurnover").val("");
        $("#txtTotalTurnover").val("");
    }
});

//Third Party Tie-up
$("#chkIsThirdParty").click(function () {
    if ($("#chkIsThirdParty").is(":checked")) {
        $(".ThirdParty").show();
    } else {
        $(".ThirdParty").hide();
    }
});

//Validation
$(function () {
    $("form[name='manufacture_edit']").validate({
        rules: {
            txtManufacturerName: "required",
            txtMobile: "required",
            txtOffEmail: "required",
            txtLatitude: "required",
            txtLongtitude: "required",
            txtGeoLocation: "required",
            txtCreditPeriod: "required",
            txtSettlementPeriod: "required",
            yearOfExp: "required",
            txtNoOfBrands: "required",
            txtAnnualTurnOver: "required",
            txtSecurityDeposit: "required",
            ddlState: "required",
            ddlCity: "required",
            ddlArea: "required",
            txtAddress: "required",
            txtPincode: "required",
            comm_pincode: "required",
            txtProprietorName: "required",
            txtProprietorMobile: "required",
            txtProprietorEmail: "required",
            txtContactPersonName: "required",
            txtContactPersonMobile: "required",
            txtContactPersonEmail: "required",
            txtThirdpartyBrands: {
                required: {
                    depends: function () {
                        return $('#chkIsThirdParty').is(':checked');
                    }
                }
            },
            txtThirdpartyBrandName: {
                required: {
                    depends: function () {
                        return $('#chkIsThirdParty').is(':checked');
                    }
                }
            },
            txtThirdPartyTurnover: {
                required: {
                    depends: function () {
                        return $('#chkIsThirdParty').is(':checked');
                    }
                }
            },
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

//Validation
$(function () {
    $("form[name='manufacture']").validate({
        rules: {
            txtManufacturerName: "required",
            txtMobile: "required",
            txtOffEmail: "required",
            txtLatitude: "required",
            txtLongtitude: "required",
            txtGeoLocation: "required",
            txtCreditPeriod: "required",
            txtSettlementPeriod: "required",
            yearOfExp: "required",
            txtNoOfBrands: "required",
            txtAnnualTurnOver: "required",
            txtSecurityDeposit: "required",
            ddlState: "required",
            ddlCity: "required",
            ddlArea: "required",
            txtAddress: "required",
            txtPincode: "required",
            comm_pincode: "required",
            txtProprietorName: "required",
            txtProprietorMobile: "required",
            txtProprietorEmail: "required",
            txtContactPersonName: "required",
            txtContactPersonMobile: "required",
            txtContactPersonEmail: "required",
            txtThirdpartyBrands: {
                required: {
                    depends: function () {
                        return $('#chkIsThirdParty').is(':checked');
                    }
                }
            },
            txtThirdpartyBrandName: {
                required: {
                    depends: function () {
                        return $('#chkIsThirdParty').is(':checked');
                    }
                }
            },
            txtThirdPartyTurnover: {
                required: {
                    depends: function () {
                        return $('#chkIsThirdParty').is(':checked');
                    }
                }
            },
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
    $("#txtManufacturerName").val("");
    $("#txtMobile").val("");
    $("#txtOffEmail").val("");
    $("#txtCreditPeriod").val("");
    $("#txtSettlementPeriod").val("");
    $("#yearOfExp").val("");
    $("#txtNoOfBrands").val("");
    $("#txtAnnualTurnOver").val("");
    $("#txtSecurityDeposit").val("");
    // $("#password").val("");
    // $("#password_confirmation").val("");
    $("input[type^='checkbox']").prop("checked", false);
    $("#txtThirdpartyBrands").val("");
    $("#txtThirdpartyBrandName").val("");
    $("#txtThirdPartyTurnover").val("");
    $("#txtTotalTurnover").val("");
    $("#txtLongtitude").val("");
    $("#txtLatitude").val("");
    $("#txtGeoLocation").val("");
    $("#ddlState").val("").trigger("change");
    $("#ddlCity").val("").trigger("change");
    $("#ddlArea").val("").trigger("change");
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
    $("#txtManufacturerName").focus();
}
