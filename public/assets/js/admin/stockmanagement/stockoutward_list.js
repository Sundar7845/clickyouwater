//Init DataTable
$(document).ready(function () {
    LoadStockOutwardListData();
});

//Load Stock Outward List Data
$("#ddlManufacturerName").change(function () {
    LoadStockOutwardListData();
});

//Load DataTable
function LoadStockOutwardListData() {
    var manufacturer_id =
        $("#ddlManufacturerName option:selected").val() == undefined
            ? 0
            : $("#ddlManufacturerName option:selected").val();

    $("#tblStockOutwardList").DataTable({
        processing: true,
        serverSide: true,
        order: [[1, "asc"]],
        bDestroy: true,
        ajax: {
            url: "/stockoutwarddata/",
            data: function (stockOutwardData) {
                stockOutwardData.manufacturer_id = manufacturer_id;
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
            { data: "outward_no" },
            { data: "manufacturer_name" },
            { data: "product_name" },
            { data: "qty" }
        ],
        rowGroup: {
            dataSrc: "manufacturer_name",
        },

    });



}





