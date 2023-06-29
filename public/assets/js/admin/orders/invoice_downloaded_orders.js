var FromDate;
var ToDate;
var date = new Date();
var startdate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var enddate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var dtCustomer;

//Get type from url to the dataTable
var type = "";
var urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("type")) {
    type = urlParams.get("type");
}

$(document).ready(function () {
    BindCity();
    FromDate = moment();
    ToDate = moment();

    var today = moment();
    var thisMonthStart = moment().startOf("month");
    var thisMonthEnd = moment().endOf("month");

    //Date for Orders
    if (type === "today") {
        FromDate = today;
        ToDate = today;
        $("#hdDivDate").hide();
    } else if (type === "thismonth") {
        FromDate = thisMonthStart;
        ToDate = thisMonthEnd;
        $("#hdDivDate").hide();
    } else {
        FromDate = today;
        ToDate = today;
    }

    //Date for Earnings
    if (type === "todayearnings") {
        FromDate = today;
        ToDate = today;
        $("#hdDivDate").hide();
    } else if (type === "thismonthearnings") {
        FromDate = thisMonthStart;
        ToDate = thisMonthEnd;
        $("#hdDivDate").hide();
    }

    $("#btnDate").daterangepicker(
        {
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [
                    moment().subtract("days", 1),
                    moment().subtract("days", 1),
                ],
                "Last 7 Days": [moment().subtract("days", 6), moment()],
                "Last 30 Days": [moment().subtract("days", 29), moment()],
                "This Month": [
                    moment().startOf("month"),
                    moment().endOf("month"),
                ],
                "Last Month": [
                    moment().subtract("month", 1).startOf("month"),
                    moment().subtract("month", 1).endOf("month"),
                ],
            },
            FromDate: moment(),
            ToDate: moment(),
        },
        getDate
    );

    getDate(FromDate, ToDate);
    //datatable
    invoiceDownloadedOrdersList();
});

function getDate(start, end) {
    startdate = start.format("YYYY-MM-DD");
    enddate = end.format("YYYY-MM-DD");
    if (dtCustomer) {
        dtCustomer.draw();
    }

    $("#btnDate span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
}

//filter
$("#ddlState,#ddlCity").change(function () {
    invoiceDownloadedOrdersList();
    BindHub();
});

$("#ddlHub").change(function () {
    invoiceDownloadedOrdersList();
});

//datatable
function invoiceDownloadedOrdersList() {
    var state_id =
        $("#ddlState option:selected").val() == undefined
            ? 0
            : $("#ddlState option:selected").val();
    var city_id =
        $("#ddlCity option:selected").val() == undefined
            ? 0
            : $("#ddlCity option:selected").val();
    var hub_id =
        $("#ddlHub option:selected").val() == undefined
            ? 0
            : $("#ddlHub option:selected").val();

    dtCustomer = $("#tblInvoicedownloadedorders").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/invoicedownloadedorders/data/" + type,
            data: function (customerorders) {
                customerorders.startdate = startdate;
                customerorders.enddate = enddate;
                customerorders.state_id = state_id;
                customerorders.city_id = city_id;
                customerorders.hub_id = hub_id;
                customerorders.type = type;
            },
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "order_no" },
            { data: "invoice_no" },
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
                data: "order_status",
                render: function (data, type, row) {
                    // var list =
                    //     "<div class='text-muted p-1'><small class='bg-light p-1'>" +
                    //     row.status +
                    //     "</small></div>";
                    return `<a class="badge bg-label-${row.status_color_css}">${row.status}</a>`;
                },
            },
            {
                data: "download",
                render: function (data, type, row) {
                    return `<a href='${row.invoice_path}' target='_blank'><i class="text-danger ti ti-file me-1"></i></a>`;
                },
                orderable: false,
            },
            { data: "action", orderable: false },
        ],
    });
}
