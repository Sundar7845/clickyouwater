$(function () {
    $('#ddlOfferType').change(function () {
        var offerTypeId = $('#ddlOfferType').val();
        if (offerTypeId == 2) {
            $('#StateList').show();
        } else {
            $('#StateList').hide();
        }
    });
});

var type = "";
var urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("type")) {
    type = urlParams.get("type");
}

if (type === 'today' || type === 'thismonth' || type === 'all') {
    $('#hdDivOffer').hide();
}


//Remove Validation For Image in Edit
var urlPath = window.location.pathname;
var segments = urlPath.split("/");
var edit_offer_id = segments[segments.length - 1];
if (!isNaN(edit_offer_id)) {
    $("#OfferImage").removeAttr("required");
}

$(document).ready(function () {

    //state field hide & show
    if ($('#ddlOfferType').val() == 2) {
        $('#stateName').show();
    } else {
        $('#stateName').hide();
    }

    //image tag hide
    if ($('#previewImage1').attr('src') === '') {
        $('#previewImage1').hide();
    }
    $("#OfferImage").on("change", function () {
        $('#previewImage1').show();
    });

    $('#tbloffers').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: {
            url: "/offers/data/" + type,
            data: function (offersData) {
                offersData.type = type;
            },
        },
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "offer_image_path",
                render: function (data) {
                    return '<img src="' + data + '" class="avatar" width="50" height="50"/>';
                }
            },
            { data: "offer_type_name" },
            { data: "offer_name" },
            { data: "validity" },
            { data: "formatted_start_date" },
            { data: "formatted_end_date" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                <input onclick="doStatus(${row.id});" id="chkOffer${row.id}" type="checkbox" class="switch-input"
                name="chkOffer" '  ${(data == 1 ? "checked" : "")} ' />
                <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                </span>
                </label>`;
                }
            },
            { data: "action", orderable: false }
        ],
    });
});

function doStatus(id) {
    var status = $("#chkOffer" + id).is(":checked");
    confirmStatusChange(id, "offers/", "tbloffers", (status == true ? 1 : 0), "chkOffer");
}

function cancel() {
    $("#hdOfferId").val("");
    $("#ddlOfferType").val("").trigger('change');
    $("#txtOfferName").val("");
    $("#txtStartDate").val("");
    $("#txtEndDate").val("");
    $("#txtOfferPoints").val("");
    $("#OfferImage").val("");
    $(".upload__img-wrap").html("");
    $("#btnSave").text("Save");
    $("#ddlOfferType").focus();
}

function showDelete(id) {
    confirmDelete(id, "delete/offers/", "tbloffers");
}

// jquery Validation
$(function () {
    $("form[name='offers']").validate({
        rules: {
            ddlOfferType: "required",
            ddlState: "required",
            txtOfferName: "required",
            txtValidityDays: "required",
            txtStartDate: "required",
            txtEndDate: "required",
            txtOffertotalPoints: "required",
            txtOfferCode: {
                required: function () {
                    return $.trim($('#tbodyOfferCodes').text()) === '';
                }
            },
            txtCodeType: {
                required: function () {
                    return $.trim($('#tbodyOfferCodes').text()) === '';
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
    });
});

var RowIndex = 1;

function validateOfferCodes() {

    if ($("#txtOfferCode").val() == "") {
        Swal.fire({
            title: "Enter Offer Code!",
            text: "Please enter offer code.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#txtOfferCode").focus();
        return false;
    }

    if ($("#txtCodeType").val() == "") {
        Swal.fire({
            title: "Enter Code Type!",
            text: "Please enter offer code type.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#txtCodeType").focus();
        return false;
    }
    return true;
}

function addOfferCodes() {

    if (validateOfferCodes()) {
        var editRowIndex = $("#hdEditOffercodesRowId").val();
        var offercodesdata = "";
        var OFC = $("#txtOfferCode").val();
        var OCT = $("#txtCodeType").val();

        if (($("tr[OFC=\"" + OFC + "\"]" + "[OCT=\"" + OCT + "\"]").length == 0)) {
            if (editRowIndex == 0) {
                offercodesdata += "<tr id='troffercodes" + RowIndex + "' OFC=" + OFC + " OCT=" + OCT + ">";
                offercodesdata += "<td><input type='hidden' class ='offercode' id='taboffercode_" + RowIndex + "' name='tabOfferCodes[]' value=" + OFC + "><span id='spnOfferCodes'>" + OFC + "</span></td>";
                offercodesdata += "<td><input type='hidden' class ='offercode' id='tabcodetype_" + RowIndex + "' name='tabOfferCodeTypes[]' value=" + OCT + "><span id='spnOfferCodeType'>" + OCT + "</span></td>";
                offercodesdata += "<td><a><i class='text-primary ti ti-pencil me-1' onclick = 'doEditOfferCodes(" + RowIndex + ");'></i></a><a><i class='text-danger ti ti-trash me-1' onclick ='removeRow(" + RowIndex + ");'></i></a></td>";
                offercodesdata += "</tr>";
                RowIndex++;
                $("#tbodyOfferCodes").append(offercodesdata);
            }
            else if (editRowIndex > 0) {
                $("#troffercodes" + editRowIndex + " td:eq(0) #taboffercode_" + editRowIndex).val(OFC);
                $("#troffercodes" + editRowIndex + " td:eq(0) #spnOfferCodes").text(OFC);
                $("#troffercodes" + editRowIndex + " td:eq(1) #tabcodetype_" + editRowIndex).val(OCT);
                $("#troffercodes" + editRowIndex + " td:eq(1) #spnOfferCodeType").text(OCT);
                showAddImage();
                $("#hdEditOffercodesRowId").val(0);
            }
            formClear();
        } else {
            alert('Item Alredy exist');
        }
    }
}

function formClear() {
    $("#txtOfferCode").val("");
    $("#txtCodeType").val("");
}

function doEditOfferCodes(SID) {
    $("#hdEditOffercodesRowId").val(SID);
    $("#txtOfferCode").val($("#troffercodes" + SID + " td:eq(0)").text());
    $("#txtCodeType").val($("#troffercodes" + SID + " td:eq(1)").text());
    showEditImage();
}

function showEditImage() {
    $("#btnUpdate").css("display", "block");
    $("#btnAdd").css("display", "none");
}

function showAddImage() {
    $("#btnUpdate").css("display", "none");
    $("#btnAdd").css("display", "block");
}

function removeRow(SID) {
    $("#troffercodes" + SID).remove();
}

//Image Preview
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

function validate(event) {
    event.preventDefault(); // prevent the default form submission behavior
    if ($.trim($('#tbodyOfferCodes').text()) === '') {
        Swal.fire({
            title: "Add Offer Code Details!",
            text: "Please add offer code details.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        return false;
    }
    return true;
}

//offer codes validation
function myFunction() {
    if ($.trim($('#tbodyOfferCodes').text()) === '') {
        Swal.fire({
            title: "Add Offer Code Details!",
            text: "Please add offer code details.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#txtOfferCode").focus();
        return false;
    }
    return true;
}

// Add an event listener to the button
$('#btnsave').on('click', myFunction);

function cancel() {
    $("#hdOfferImg").val("");
    $("#ddlOfferType").val("").trigger('change');
    $("#ddlState").val("").trigger('change');
    $("#txtOfferName").val("");
    $("#txtStartDate").val("");
    $("#txtEndDate").val("");
    $("#txtOffertotalPoints").val("");
    $("#txtOfferclaimPoints").val("");
    $('#previewImage1').attr('src', '');
    $("#OfferImage").val("");
    $("#ddlOfferType").focus();
}
