//Validate Admin Order List Data
function validateAdminOrderList() {
    var HubName = $("#ddlHubName").val();
    var ProductName = $("#ddlProducts").val();
    var ProductQty = $("#txtProductQty").val();

    if (HubName == "") {
        Swal.fire({
            title: "Select Hub Name!",
            text: "You have to select Hub Name.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlHubName").focus();
        return false;
    }

    if (ProductName == "") {
        Swal.fire({
            title: "Select Product Name!",
            text: "You have to select Product Name.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlProducts").focus();
        return false;
    }

    if (ProductQty == "") {
        Swal.fire({
            title: "Enter Product Quantity!",
            text: "You have to enter Product qty.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#txtProductQty").focus();
        return false;
    }

    return true;
}


//validate Admin Order List
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


//List Table Validation
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

//Admin Order List
var RowIndex = 1;
function placeAdminOrder() {
    if (validateAdminOrderList()) {
        var editRowIndex = $("#hdAdminOrderId").val();
        var AdminOrderData = "";

        var PDTN = $("#ddlProducts option:selected").val();
        var PDTT = $("#ddlProducts option:selected").text();

        var PDTQTTY = $("#txtProductQty").val();

        if ($(`tr[PDTN='${PDTN}'][PDTQTTY='${PDTQTTY}']`).length === 0 && editRowIndex == 0) {
            AdminOrderData += `<tr id='trAdminOrder${RowIndex}' PDTN='${PDTN}' PDTT='${PDTT}' PDTQTTY='${PDTQTTY}'>`;
            AdminOrderData += `<td><input type='hidden' class='adminOrderClass' id='tabProductName${RowIndex}' name='tabProductName[]' value='${PDTN}'><span id='spnProductName'>${PDTT}</span></td>`;
            AdminOrderData += `<td><input type='hidden' class='adminOrderClass' id='tabProductQty${RowIndex}' name='tabProductQty[]' value='${PDTQTTY}'><span id='spnProductQty'>${PDTQTTY}</span></td>`;
            AdminOrderData += `<td><a><i class='text-primary ti ti-pencil me-1' onclick='doEdit(${RowIndex});'></i></a><a><i class='text-danger ti ti-trash me-1' onclick='removeRow(${RowIndex});'></i></a></td>`;
            AdminOrderData += "</tr>";
            RowIndex++;
            $("#tbodyPlaceAdminOrders").append(AdminOrderData);
            formClear();
        } else if (editRowIndex > 0) {
            var trElement = $(`#trAdminOrder${editRowIndex}`);
            trElement.attr('PDTN', PDTN);
            trElement.attr('PDTT', PDTT);
            trElement.attr('PDTQTTY', PDTQTTY);

            trElement.find(`td:eq(0) #tabProductName${editRowIndex}`).val(PDTN);
            trElement.find(`td:eq(0) #spnProductName`).text(PDTT);
            trElement.find(`td:eq(1) #tabProductQty${editRowIndex}`).val(PDTQTTY);
            trElement.find(`td:eq(1) #spnProductQty`).text(PDTQTTY);
            $("#hdAdminOrderId").val(0);
            formClear();
        } else {
            Swal.fire({
                title: "Prodcut Already Exits!",
                text: "This product is already present in the list!",
                icon: "error",
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false,
            });
            $("#ddlProducts").focus();
            return false;
        }
    }
}

//Edit List Data
function doEdit(SID) {
    $("#hdAdminOrderId").val(SID);
    $("#ddlProducts").val($("#trAdminOrder" + SID).attr("PDTN")).trigger("change");
    $("#txtProductQty").val($("#trAdminOrder" + SID).attr("PDTQTTY"));
}

//Clear  List
function formClear() {
    $("#ddlProducts").val("").trigger("change");
    $("#txtProductQty").val("");
}

//Delete List Data
function removeRow(SID) {
    $("#trAdminOrder" + SID).remove();
}

//Cancel Adding List
function doCancel() {
    $("#ddlHubName").val("").trigger("change");
    $("#tbodyPlaceAdminOrders").empty();
    formClear();
}

//jQuery Form Validation
$(function () {
    $("form[name='adminPlaceOrder']").validate({
        rules: {
            ddlHubName: "required",
            ddlProducts: "required",
            txtProductQty: "required",
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