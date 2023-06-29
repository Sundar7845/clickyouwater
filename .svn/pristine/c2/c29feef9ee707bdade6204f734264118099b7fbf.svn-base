$(document).ready(function () {
    Orderlist();
});

function Orderlist() {
    var customer_id = $('#hduserid').val();
    $('#tblRecentOrders').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: "/ordersData/" + customer_id,
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "created_at",
                render: function (data, type, row) {
                    // Parse the date string into a Date object
                    var date = new Date(data);

                    // Format the date using the moment.js library
                    return moment(date).format("DD-MM-YYYY");
                },
            },
            { data: "order_no" },
            { data: "hub_name" },
            { data: "total_qty" },
            { data: "total_return_qty" },
            {
                data: null,
                render: function (data, type, row) {
                    let html = `<span class="rupee-symbol">&#8377;${data.grand_total}</span>`
                    return html;
                }
            },
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
                data: null,
                render: function (data, type, row) {
                    let html = "";
                    html = `<span class="badge bg-label-${data.status_color_css}">${data.status}</span>`;
                    return html;
                }
            },
            {
                data: "order_no", orderable: false,
                render: function (data, type, row) {
                    return `<a href="/orderdetail/${row.id}" class="btn btn-xs btn-primary">View</a>`;
                }
            },
        ],
    });
}