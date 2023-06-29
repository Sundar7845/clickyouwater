$(document).ready(function () {
    logisticsProductStockList();
});

$("#ddlCategory,#ddlLogistics").change(function () {
    logisticsProductStockList();
});

//Products Stock Report
function logisticsProductStockList() {
    var category_id =
        $("#ddlCategory option:selected").val() == "" ? 0 : $("#ddlCategory option:selected").val();
    var logistics_id =
        $("#ddlLogistics option:selected").val() == "" ? 0 : $("#ddlLogistics option:selected").val();

    $("#tblLogisticsStockList").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/logisticproductstockreport",
            data: function (data) {
                data.category_id = category_id;
                data.logistics_id = logistics_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_name" },
            { data: "filled_qty" },
            { data: "empty_qty" },
            { data: "damaged_qty" },
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            filled_total = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            empty_total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            damaged_total = api
                .column(5)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Total over this page
            // pageTotal = api
            //     .column(3, { page: 'current' })
            //     .data()
            //     .reduce(function (a, b) {
            //         return intVal(a) + intVal(b);
            //     }, 0);
                // console.log(damaged_total);
            // Update footer
            $(api.column(3).footer()).html(filled_total);
            $(api.column(4).footer()).html(empty_total);
            $(api.column(5).footer()).html(damaged_total);
        },
    });
}
