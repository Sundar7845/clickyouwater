$(document).ready(function () {
    hubProductStockList();
    hubEmptyCanStockList();
    hubFilledCanStockList();
});

$("#ddlCategory").change(function () {
    hubProductStockList();
});

//Products Stock Report
function hubProductStockList() {
    var category_id =
        $("#ddlCategory option:selected").val() == undefined ? 0 : $("#ddlCategory option:selected").val();

    $("#tblHubProductStockList").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/hubproductstockdata",
            data: function (data) {
                data.category_id = category_id;
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
            { data: "lost_qty" },
            {
                data: "product_id",
                render: function (data, type, row) {
                    return `<a href="/hubstocks/?product_id=${row.product_id}" class="btn btn-xs btn-primary">View</a>`;
                }
            }
        ],
    });
}


//Product Wise Stock Report - Empty Cans
function hubEmptyCanStockList() {
    var product_id = $("#hdProductId").val();
    $("#tblHubEmptyCans").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/hubemptycanstocklist",
            data: function (data) {
                data.product_id = product_id;
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
            { data: "inward_from_delivery_qty" },
            { data: "outward_to_logistics_qty" },
        ],
    });
}

//Product Wise Stock Report - Filled Cans
function hubFilledCanStockList() {
    var product_id = $("#hdProductId").val();
    $("#tblHubFilledCans").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/hubfilledcanstocklist",
            data: function (data) {
                data.product_id = product_id;
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
            { data: "inward_from_logistics_qty" },
            { data: "inward_return_qty" },
            { data: "outward_to_delivery_qty" },
            { data: "outward_filled_return_qty" },
        ],
    });
}