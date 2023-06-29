$(document).ready(function () {
    logisticProductStockList();
    logisticEmptyCanStockList();
    logisticFilledCanStockList();
});

$("#ddlCategory,#ddlDriver").change(function () {
    logisticProductStockList();
});

//Products Stock Report
function logisticProductStockList() {
    var category_id = $("#ddlCategory option:selected").val() == undefined ? 0 : $("#ddlCategory option:selected").val();
    var driver_id = $("#ddlDriver option:selected").val() == undefined ? 0 : $("#ddlDriver option:selected").val();

    $("#tblLogisticProductStockList").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/logisticproductstockdata",
            data: function (data) {
                data.category_id = category_id;
                data.driver_id = driver_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_name" },
            { data: "order_qty" },
            { data: "filled_qty" },
            { data: "empty_qty" },
            { data: "damaged_qty" },
            {
                data: "product_id",
                render: function (data, type, row) {
                    return `<a href="#" class="btn btn-xs btn-primary" onclick="viewLogisticStocks(${row.product_id});">View</a>`;
                }
            }
        ],
    });
}

function viewLogisticStocks(product_id) {
    var driver_id = $("#ddlDriver option:selected").val() == "" ? 0 : $("#ddlDriver option:selected").val();
    window.location.href = "/logisticstocks/?product_id=" + product_id + "&driver_id=" + driver_id + "";
}

//Product Wise Stock Report - Empty Cans
function logisticEmptyCanStockList() {
    var product_id = $("#hdProductId").val();
    var driver_id = $("#hdDriverId").val();
    $("#tblLogisticEmptyCans").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/logisticemptycanstocklist",
            data: function (data) {
                data.product_id = product_id;
                data.driver_id = driver_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "created_at",
                render: function (data, type, row, meta) {
                    var formattedDate = moment(row.created_at).format("DD-MM-YYYY");
                    return formattedDate;
                },
            },
            { data: "inward_from_hub_empty_qty" },
            { data: "outward_to_manufacture_qty" },
        ],
    });
}

//Product Wise Stock Report - Filled Cans
function logisticFilledCanStockList() {
    var product_id = $("#hdProductId").val();
    var driver_id = $("#hdDriverId").val();
    $("#tblLogisticFilledCans").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/logisticfilledcanstocklist",
            data: function (data) {
                data.product_id = product_id;
                data.driver_id = driver_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "created_at",
                render: function (data, type, row, meta) {
                    var formattedDate = moment(row.created_at).format("DD-MM-YYYY");
                    return formattedDate;
                },
            },
            { data: "outward_return_damaged_qty" },
            { data: "inward_from_manufacture_qty" },
            { data: "inward_return_manufacture_qty" },
            { data: "outward_to_hub_qty" },
            { data: "outward_return_filled_qty" },
        ],
    });
}