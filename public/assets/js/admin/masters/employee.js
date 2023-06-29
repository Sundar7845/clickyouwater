$(document).ready(function () {
    $("#tblEmployee").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "employees/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "employee_code" },
            { data: "employee_name" },
            { data: "personal_mobile" },
            { data: "email1" },
            // { data: "department_name" },
            { data: "designation_name" },
            {
                data: "designation_name",
                render: function (data, type, row) {
                    if (row.document_path) {
                        return `<a href="employeedocument/${row.id}"
                        class="badge bg-label-warning">View</a>`;
                    } else {
                        return `<span 
                    class="badge bg-label-danger">NA</span>`;
                    }
                },
            },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                        <input onclick="doStatus(${row.id});" id="chkEmployee${row.id
                        }" type="checkbox" class="switch-input"
                        name="chkEmployee" '  ${data == 1 ? "checked" : ""} ' />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                    </label>`;
                },
            },
            { data: "action", orderable: false },
        ],
    });
    // BindAssetName();
});

//Check user mobile number if already exists
$("#txtPerMobile").on("focusout", function (e) {
    var mobileNumber = $(this).val();
    checkMobileNumberExists(mobileNumber, $("#ddlRoleName").val(), $("#hdEmployeeId").val(), function (result) {
        if (result == true) {
            $("#txtPerMobile").val("");
            $("#txtPerMobile").focus();
        }
    });
});


function doStatus(id) {
    var status = $("#chkEmployee" + id).is(":checked");
    confirmStatusChange(
        id,
        "employee/",
        "tblEmployee",
        status == true ? 1 : 0,
        "chkEmployee"
    );
}

function showDelete(id) {
    confirmDelete(id, "delete/employee/", "tblEmployee");
}

$(document).ready(function () {
    $(".mobilenumber").on("input", function () {
        $(this).val(
            $(this)
                .val()
                .replace(/[^0-9]/g, "")
        );

        var mobileNumber = $(this).val();
        if (mobileNumber.length != 10 || isNaN(mobileNumber)) {
            $(this).css("border-color", "red");
        } else {
            $(this).css("border-color", "green");
        }
    });
    $(".acc_no").on("input", function () {
        $(this).val(
            $(this)
                .val()
                .replace(/[^0-9]/g, "")
        );

        var mobileNumber = $(this).val();
        if (isNaN(mobileNumber)) {
            $(this).css("border-color", "red");
        } else {
            $(this).css("border-color", "green");
        }
    });
});
const inputFiles = document.querySelectorAll('input[type="file"]');
const previewImages = document.querySelectorAll('img[id^="previewImage"]');

inputFiles.forEach(function (inputFile, index) {
    inputFile.addEventListener("change", function () {
        const file = this.files[0];
        const reader = new FileReader();

        reader.addEventListener("load", function () {
            previewImages[index].setAttribute("src", this.result);
        });

        if (file) {
            reader.readAsDataURL(file);
        }
    });
});

$(function () {
    $("form[name='employee']").validate({
        rules: {
            txtEmployeeName: "required",
            txtEmployeeCode: "required",
            txtFatherSpouseName: "required",
            rdGender: "required",
            rdMarital: "required",
            dtdob: "required",
            txtNationality: "required",
            // txtNationalityStatus: "required",
            fileProfileImg: "required",
            txtPermAddress: "required",
            ddlPermArea: "required",
            ddlPermCity: "required",
            ddlPermState: "required",
            txtPermPincode: "required",
            txtCommAddress: "required",
            ddlCommArea: "required",
            ddlCommCity: "required",
            ddlCommState: "required",
            txtCommPincode: "required",
            txtMobile1: "required",
            txtMobile2: "required",
            // txtPrevCompanyName: "required",
            // txtPrevCompanyRef: "required",
            email1: "required",
            // email2: "required",
            // numPrevCompanyExp: {
            //     required: true,
            //     phone_regex: true,
            //     minlength: 2,
            // },
            // prev_company_name: "required",
            // prev_company_ref_by: "   ",
            txtAccountName: "required",
            txtAccountNumber: "required",
            txtBankName: "required",
            txtBranchName: "required",
            txtBranchIfsc: "required",
            ddlDepartment: "required",
            ddlDesignation: "required",
            txtPackage: "required",
            // ddlReportingTo: {
            //     required: true,
            //     // phone_regex: true,
            // },
            ddlRoleName: {
                required: true,
            },
            dtDateOfJoin: "required",
            // CompanyMailId: "required",
            // txtCompanyMobile: "required",
            // ddlOriginalsVerified: {
            //     required: true,
            //     // phone_regex: true,
            // },
            // ddlOriginalReceived: {
            //     required: true,
            //     // phone_regex: true,
            // },
            // txtOriginalGiven: {
            //     required: true,
            //     // phone_regex: true,
            // },
        },
        messages: {
            numPrevCompanyExp: "Please enter Integers",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
            },
            city: "Please enter your city",
            gender: "This field is required",
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

function setPermanentAddress() {
    if ($("#chkSameAddress").is(":checked")) {
        setTimeout(function () {
            $("#ddlPermState").val($("#ddlCommState").val()).trigger("change");
        }, 1500);
        setTimeout(function () {
            $("#ddlPermCity").val($("#ddlCommCity").val()).trigger("change");
        }, 2500);
        setTimeout(function () {
            $("#ddlPermArea").val($("#ddlCommArea").val()).trigger("change");
        }, 3500);
        $("#txtPermAddress").val($("#txtCommAddress").val());
        $("#txtPermPincode").val($("#txtCommPincode").val());
    } else {
        $("#ddlPermState").val("").trigger("change");
        $("#ddlPermCity").val("").trigger("change");
        $("#ddlPermArea").val("").trigger("change");
        $("#txtPermAddress").val("");
        $("#txtPermPincode").val("");
    }
}

$("#chkSameAddress").click(function () {
    setPermanentAddress();
});

function cancel() {
    var baseUrl = window.location.origin;
    $("#txtEmployeeName").focus();
    $("#hdEmployeeId").val("");
    $("#txtEmployeeName").val("");
    $("#txtFatherSpouseName").val("");
    $('input[name="rdGender"]').prop("checked", false);
    $('input[name="rdMarital"]').prop("checked", false);
    $("#dtdob").val("");
    $("#txtNationality").val("");
    $("#txtNationalityStatus").val("");
    $("#txtPerMobile").val("");
    // $("#txtOfficialMobile").val("");
    $("#email1").val("");
    // $("#email2").val("");
    $("#fileProfileImg").val("");
    $("#previewImage1").attr(
        "src",
        baseUrl + "/assets/img/avatars/14.png"
    );
    $("#ddlCommState").val("").trigger("change");
    $("#ddlCommCity").val("").trigger("change");
    $("#ddlCommArea").val("").trigger("change");
    $("#txtCommAddress").val("");
    $("#txtCommPincode").val("");
    $("#chkSameAddress").val("");
    $("#ddlPermState").val("").trigger("change");
    $("#ddlPermCity").val("").trigger("change");
    $("#ddlPermArea").val("").trigger("change");
    $("#txtPermAddress").val("");
    $("#txtPermPincode").val("");
    $("#txtMobile1").val("");
    $("#txtRelation1").val("");
    $("#txtMobile2").val("");
    $("#txtRelation2").val("");
    $("#numPrevCompanyExp").val("");
    $("#txtPrevCompanyName").val("");
    $("#txtPrevCompanyRef").val("");
    $("#txtAccountName").val("");
    $("#txtAccountNumber").val("");
    $("#txtBankName").val("");
    $("#txtBranchName").val("");
    $("#txtBranchIfsc").val("");
    // $("#inputFile2").val("");
    // $("#inputFile3").val("");
    // $("#inputFile4").val("");
    // $("#txtEmployeeCode").val("");
    $("#ddlDepartment").val("").trigger("change");
    $("#ddlDesignation").val("").trigger("change");
    $("#ddlReportingTo").val("").trigger("change");
    $("#ddlRoleName").val("").trigger("change");
    $("#txtPackage").val("");
    $("#dtDateOfJoin").val("");
    $("#CompanyMailId").val("");
    $("#txtCompanyMobile").val("");
    $("#txtOriginalGiven").val("").trigger("change");
    $("#ddlOriginalReceived").val("").trigger("change");
    $("#ddlOriginalsVerified").val("").trigger("change");
    $("#ddlVehicle").val("").trigger("change");
    $("#ddlVehicleType").val("").trigger("change");
    $("#ddlVehicleBrand").val("").trigger("change");
    $("#ddlAssetType").val("").trigger("change");
    $("#ddlAsset").val("").trigger("change");
    $("#ddlIssuedBy").val("").trigger("change");
    $("#ddlAuthorisedBy").val("").trigger("change");
    $("input[type='file']").val("");
    $(".valid").val("");
    $("#tbodyOfficeAssets").empty();
    $("#btnSave").text("save");
}

///Office Asset
var RowIndex = 1;

function validateOfficeAsset() {
    var ddlAssetType = $("#ddlAssetType").val();
    var ddlAsset = $("#ddlAsset").val();
    var ddlIssuedBy = $("#ddlIssuedBy").val();
    var ddlAuthorisedBy = $("#ddlAuthorisedBy").val();

    if (ddlAssetType == "") {
        Swal.fire({
            title: "Select Asset Type!",
            text: "Please select asset type.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlAssetType").focus();
        return false;
    }

    if (ddlAsset == "") {
        Swal.fire({
            title: "Select Asset Name!",
            text: "Please select asset name.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlAsset").focus();
        return false;
    }

    if (ddlIssuedBy == "") {
        Swal.fire({
            title: "Select Asset Issued By!",
            text: "Please select issued by.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlIssuedBy").focus();
        return false;
    }

    if (ddlAuthorisedBy == "") {
        Swal.fire({
            title: "Select Asset Authorised By!",
            text: "Please select asset authorised by.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlAuthorisedBy").focus();
        return false;
    }

    return true;
}

function addOfficeAsset() {
    if (validateOfficeAsset()) {
        var editRowIndex = $("#hdEditOfficeAssetRowId").val();
        var officeassetdata = "";
        var ATV = $("#ddlAssetType option:selected").val();
        var ATT = $("#ddlAssetType option:selected").text();
        var ASV = $("#ddlAsset option:selected").val();
        var AST = $("#ddlAsset option:selected").text();
        var ISB = $("#ddlIssuedBy option:selected").val();
        var IST = $("#ddlIssuedBy option:selected").text();
        var AUB = $("#ddlAuthorisedBy option:selected").val();
        var AUT = $("#ddlAuthorisedBy option:selected").text();

        if (
            // $(editRowIndex == 0 && `tr[ASV='${ASV}'][ATV='${ATV}']` || editRowIndex != 0 && `tr[ASV='${ASV}'][ATV='${ATV}']`).length === 0
            $(`tr[ASV='${ASV}'][ATV='${ATV}']`).length === 0 && editRowIndex == 0
        ) {
            // if (editRowIndex == 0) {
            officeassetdata += `<tr id='trasset${RowIndex}' ATV='${ATV}' ATT='${ATT}' ASV='${ASV}' AST='${AST}' ISB='${ISB}' AUB='${AUB}'>`;
            officeassetdata += `<td><input type='hidden' class='officeassets' id='tabassettypename_${RowIndex}' name='tabAssetTypeName[]' value='${ATV}'><span id='spnAssetType'>${ATT}</span></td>`;
            officeassetdata += `<td><input type='hidden' class='officeassets' id='tabassetname_${RowIndex}' name='tabAssetName[]' value='${ASV}'><span id='spnAssetName'>${AST}</span></td>`;
            officeassetdata += `<td><input type='hidden' class='officeassets' id='tabissuedby_${RowIndex}' name='tabIssuedBy[]' value='${ISB === "" ? "NULL" : ISB}'><span id='spnIssuedBy'>${IST === "Select" ? "" : IST}</span></td>`;
            officeassetdata += `<td><input type='hidden' class='officeassets' id='tabauthorisedby_${RowIndex}' name='tabAuthorisedBy[]' value='${AUB === "" ? "NULL" : AUB}'><span id='spnAuthorisedBy'>${AUT === "Select" ? "" : AUT}</span></td>`;
            officeassetdata += `<td><a><i class='text-primary ti ti-pencil me-1' onclick='doEdit(${RowIndex});'></i></a><a><i class='text-danger ti ti-trash me-1' onclick='removeRow(${RowIndex});'></i></a></td>`;
            officeassetdata += "</tr>";
            RowIndex++;
            $("#tbodyOfficeAssets").append(officeassetdata);
            formClear();
        } else if (editRowIndex > 0) {
            var trElement = $(`#trasset${editRowIndex}`);
            trElement.attr('ATV', ATV);
            trElement.attr('ATT', ATT);
            trElement.attr('ASV', ASV);
            trElement.attr('AST', AST);
            trElement.attr('ISB', ISB);
            trElement.attr('AUB', AUB);

            trElement.find(`td:eq(0) #tabassettypename_${editRowIndex}`).val(ATV);
            trElement.find(`td:eq(0) #spnAssetType`).text(ATT);
            trElement.find(`td:eq(1) #tabassetname_${editRowIndex}`).val(ASV);
            trElement.find(`td:eq(1) #spnAssetName`).text(AST);
            trElement.find(`td:eq(2) #tabissuedby_${editRowIndex}`).val(ISB);
            trElement.find(`td:eq(2) #spnIssuedBy`).text(IST);
            trElement.find(`td:eq(3) #tabauthorisedby_${editRowIndex}`).val(AUB);
            trElement.find(`td:eq(3) #spnAuthorisedBy`).text(AUT);
            showAddImage();
            $("#hdEditOfficeAssetRowId").val(0);
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
            $("#ddlAssetType").focus();
            return false;
        }
    }
}


function doEdit(SID) {
    $("#hdEditOfficeAssetRowId").val(SID);
    $("#ddlAssetType").val($("#trasset" + SID).attr("ATV")).trigger("change");
    setTimeout(function () {
        $("#ddlAsset").val($("#trasset" + SID).attr("ASV")).trigger("change");
    }, 2000);
    $("#ddlIssuedBy").val($("#trasset" + SID).attr("ISB")).trigger("change");
    $("#ddlAuthorisedBy").val($("#trasset" + SID).attr("AUB")).trigger("change");
    showEditImage();
}

function showAddImage() {
    $("#btnUpdateOfficeAsset").css("display", "none");
    $("#btnAddOfficeAsset").css("display", "block");
}

function showEditImage() {
    $("#btnUpdateOfficeAsset").css("display", "block");
    $("#btnAddOfficeAsset").css("display", "none");
}

function removeRow(SID) {
    $("#trasset" + SID).remove();
}

function formClear() {
    $("#ddlAssetType").val("").trigger("change");
    $("#ddlAsset").val("").trigger("change");
    $("#ddlIssuedBy").val("").trigger("change");
    $("#ddlAuthorisedBy").val("").trigger("change");
}

// function BindAssetName() {
$("#ddlAssetType").on("change", function () {
    $("#pageloader").fadeIn();
    var Asset_type_id = this.value;
    $("#ddlAsset").html("");
    $.ajax({
        url: "/get/assetname",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            Asset_type_id: Asset_type_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            console.log(result);
            $("#ddlAsset").html('<option value="">Select Asset Name</option>');
            $.each(result, function (key, value) {
                $("#ddlAsset").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.asset_name +
                    "</option>"
                );
            });
            $("#pageloader").fadeOut();
        },
    });
});
// }
