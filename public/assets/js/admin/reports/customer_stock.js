$(document).ready(function () {
    customerProductStockList();
});

$("#ddlCategory, #ddlCustomer").change(function () {
    customerProductStockList();
});

//Products Stock Report
function customerProductStockList() {
    var category_id =
        $("#ddlCategory option:selected").val() == "" ? 0 : $("#ddlCategory option:selected").val();
    var customer_id =
        $("#ddlCustomer option:selected").val() == "" ? 0 : $("#ddlCustomer option:selected").val();

    $("#tblCustomerStockList").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/customersproductstockreport",
            data: function (data) {
                data.category_id = category_id;
                data.customer_id = customer_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "category_name" },
            { data: "product_name" },
            { data: "empty_qty" },
            { data: "damaged_qty" },
            { data: "extra_qty" },
        ],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Remove the formatting to get integer data for summation
            var intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over all pages
            empty_total = api
                .column(3)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            damaged_total = api
                .column(4)
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            extra_total = api
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
            $(api.column(3).footer()).html(empty_total);
            $(api.column(4).footer()).html(damaged_total);
            $(api.column(5).footer()).html(extra_total);
        },
    });
}
