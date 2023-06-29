//Validate Stock Lis Data
function validateStockOutwardList() {
    var ManufacturerName = $("#ddlManufacturerName").val();
    var ProductName = $("#ddlProducts").val();
    var ProductQty = $("#txtProductQty").val();

    if (ManufacturerName == "") {
        Swal.fire({
            title: "Select Manufacturer Name!",
            text: "You have to select Manufacturer Name.",
            icon: "error",
            customClass: {
                confirmButton: "btn btn-primary",
            },
            buttonsStyling: false,
        });
        $("#ddlManufacturerName").focus();
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

//Add Stock OutWard To List
var RowIndex = 1;
function addStockOutward() {
    if (validateStockOutwardList()) {
        var editRowIndex = $("#hdStockOutwardId").val();
        var StockOutwardData = "";

        var PDTN = $("#ddlProducts option:selected").val();
        var PDTT = $("#ddlProducts option:selected").text();

        var PDTQTTY = $("#txtProductQty").val();

        if ($(`tr[PDTN='${PDTN}'][PDTQTTY='${PDTQTTY}']`).length === 0 && editRowIndex == 0) {
            StockOutwardData += `<tr id='trStockOutward${RowIndex}' PDTN='${PDTN}' PDTT='${PDTT}' PDTQTTY='${PDTQTTY}'>`;
            StockOutwardData += `<td><input type='hidden' class='stockOutwardClass' id='tabProductName${RowIndex}' name='tabProductName[]' value='${PDTN}'><span id='spnProductName'>${PDTT}</span></td>`;
            StockOutwardData += `<td><input type='hidden' class='stockOutwardClass' id='tabProductQty${RowIndex}' name='tabProductQty[]' value='${PDTQTTY}'><span id='spnProductQty'>${PDTQTTY}</span></td>`;
            StockOutwardData += `<td><a><i class='text-primary ti ti-pencil me-1' onclick='doEdit(${RowIndex});'></i></a><a><i class='text-danger ti ti-trash me-1' onclick='removeRow(${RowIndex});'></i></a></td>`;
            StockOutwardData += "</tr>";
            RowIndex++;
            $("#tbodyStockOutward").append(StockOutwardData);
            formClear();
        } else if (editRowIndex > 0) {
            var trElement = $(`#trStockOutward${editRowIndex}`);
            trElement.attr('PDTN', PDTN);
            trElement.attr('PDTT', PDTT);
            trElement.attr('PDTQTTY', PDTQTTY);

            trElement.find(`td:eq(0) #tabProductName${editRowIndex}`).val(PDTN);
            trElement.find(`td:eq(0) #spnProductName`).text(PDTT);
            trElement.find(`td:eq(1) #tabProductQty${editRowIndex}`).val(PDTQTTY);
            trElement.find(`td:eq(1) #spnProductQty`).text(PDTQTTY);
            $("#hdStockOutwardId").val(0);
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
    $("#hdStockOutwardId").val(SID);
    $("#ddlProducts").val($("#trStockOutward" + SID).attr("PDTN")).trigger("change");
    $("#txtProductQty").val($("#trStockOutward" + SID).attr("PDTQTTY"));
}

//Clear  List
function formClear() {
    $("#ddlProducts").val("").trigger("change");
    $("#txtProductQty").val("");
}

//Delete List Data
function removeRow(SID) {
    $("#trStockOutward" + SID).remove();
}

//Cancel Adding List
function doCancel() {
    $("#ddlManufacturerName").val("").trigger("change");
    $("#tbodyStockOutward").empty();
    formClear();
}

// jquery Validation
$(function () {
    $("form[name='stockoutwardForm']").validate({
        rules: {
            ddlManufacturerName: "required",
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