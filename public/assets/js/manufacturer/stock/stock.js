$(document).ready(function () {
    manufactureProductStockList();
    emptyCanStockList();
    filledCanStockList();
});

$("#ddlCategory").change(function () {
    manufactureProductStockList();
});

//Products Stock Report
function manufactureProductStockList() {
    var category_id =
        $("#ddlCategory option:selected").val() == undefined ? 0 : $("#ddlCategory option:selected").val();

    $("#tblProductStockList").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/manufacturerproductstockdata",
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
            {
                data: "product_id",
                render: function (data, type, row) {
                    return `<a href="/manufactuererstocks/?product_id=${row.product_id}" class="btn btn-xs btn-primary">View</a>`;
                }
            }
        ],
    });
}


//Product Wise Stock Report - Empty Cans
function emptyCanStockList() {
    var product_id = $("#hdProductId").val();
    $("#tblEmpty").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/emptycanstocklist",
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
            { data: "mf_inward_qty" },
            { data: "mf_inward_return_qty" },
            { data: "mf_logistic_inward_qty" },
            { data: "mf_damage_qty" },
            { data: "mf_filling_outward_qty" },
            { data: "mf_filling_outward_return_qty" },
        ],
    });
}

//Product Wise Stock Report - Filled Cans
function filledCanStockList() {
    var product_id = $("#hdProductId").val();
    $("#tblFilled").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/filledcanstocklist",
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
            { data: "mf_production_inward_qty" },
            { data: "mf_logistic_outward_qty" },
            { data: "mf_logistic_return_qty" },
        ],
    });
}