$(document).ready(function () {
    //datatable
    manufactureOrdersList();
});

//datatable
function manufactureOrdersList() {
    var hub_id = $("#hdHubId").val();
    $("#tblManufactureAllOrders").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/manufacturerorderdetails",
            data: function (data) {
                data.hub_id = hub_id;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "order_no" },
            {
                data: "transaction_date",
                render: function (data, type, row) {
                    // Parse the date string into a Date object
                    var date = new Date(data);

                    // Format the date using the moment.js library
                    return moment(date).format("DD-MM-YYYY hh:mm A");
                },
            },
            { data: "customer_name" },
            { data: "hub_name" },
            { data: "total_qty" },
            { data: function (row) { return '₹' + row.grand_total; } },
            {
                data: "payment_through",
                render: function (data, type, row) {
                    if(row.payment_through == 'Razorpay'){
                        return `<a class="badge bg-label-success">${row.payment_through}</a>`;
                    }else{
                        return `<a class="badge bg-label-warning">${row.payment_through}</a>`;
                    }
                    
                },
            },
            {
                data: "order_status",
                render: function (data, type, row) {
                    // var list =
                    //     "<div class='text-muted p-1'><small class='bg-light p-1'>" +
                    //     row.status +
                    //     "</small></div>";
                    return `<a class="badge bg-label-${row.status_color_css}">${row.status}</a>`;
                },
            },
            { data: "action", orderable: false },
        ],
    });
}
