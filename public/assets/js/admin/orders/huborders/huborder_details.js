$(document).ready(function () {
    //datatable
    hubOrdersList();
});

//datatable
function hubOrdersList() {
    var hub_id = $("#hdHubId").val();
    dtHubs = $("#tblHubAllOrders").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/huborderdetail",
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

$(function () {
    $("form[name='assignDeliveryPerson']").validate({
        rules: {
            ddlDeliveryPerson: "required",
        },
        messages: {
            required: "This field is required",
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
        submitHandler: function (form) {
            form.submit();
        },
    });
});

function assignOrder(orderId) {
    $("#hdOrderId").val(orderId);
}
