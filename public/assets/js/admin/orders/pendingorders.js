var FromDate;
var ToDate;
var date = new Date();
var startdate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var enddate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var dtpendingorder;


//Get type from url to the dataTable
var type = "";
var urlParams = new URLSearchParams(window.location.search);
if (urlParams.has("type")) {
    type = urlParams.get("type");
}

$(document).ready(function() {
    pendingOrderlist();

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
});


function getDate(start, end) {
    startdate = start.format("YYYY-MM-DD");
    enddate = end.format("YYYY-MM-DD");
    if (dtpendingorder) {
        dtpendingorder.draw();
    }

    $("#btnDate span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
}


$("#ddlState,#ddlCity").change(function () {
    pendingOrderlist();
    BindHub();
});

$("#ddlHub").change(function () {
    pendingOrderlist();
});

function pendingOrderlist(){

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

  dtpendingorder =  $('#pendingorders').DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/pendingorder/data/",
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


