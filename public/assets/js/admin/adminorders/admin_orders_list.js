//Init DataTable
$(document).ready(function () {
    AdminOrderListData();
});

//Load Stock Outward List Data
$("#ddlHubName").change(function () {
    AdminOrderListData();
});

//Load DataTable
function AdminOrderListData() {
    var hub_id =
        $("#ddlHubName option:selected").val() == undefined
            ? 0
            : $("#ddlHubName option:selected").val();

    $("#tblAdminOrdersList").DataTable({
        processing: true,
        serverSide: true,
        order: [[1, "asc"]],
        bDestroy: true,
        ajax: {
            url: "/adminoderdata/",
            data: function (adminoderdata) {
                adminoderdata.hub_id = hub_id;
            }
        },
        columns: [
            {
                data: "created_at",
                render: function (data, type, row, meta) {
                    var formattedDate = moment(row.created_at).format("DD-MM-YYYY");
                    return formattedDate;
                },
            },
            { data: "order_no" },
            { data: "hub_name" },
            { data: "product_name" },
            { data: "qty" }
        ],
        rowGroup: {
            dataSrc: "hub_name",
        },
    });
}