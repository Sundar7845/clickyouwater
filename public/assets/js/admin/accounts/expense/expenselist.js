var FromDate;
var ToDate;
var date = new Date();
var startdate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
var enddate =
    date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();

$(document).ready(function () {
    //expense datatable
    expenseList();

    //employee datatable
    employeeExpenseList();

    FromDate = moment();
    ToDate = moment();

    $("#btnDate").daterangepicker({
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
    dtExpense.draw();
    dtEmpExpense.draw();

    $("#btnDate span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY")
    );
}

//filter
$("#ddlFilterExpensegroup,#ddlExpenseCompany,#ddlExpenseEmployee").change(
    function () {
        expenseList();
        employeeExpenseList();
    }
);

//Cancel Data
function showCancel(id) {
    confirmCancel(id, "update/expensecancel/", "tblExpense");
}

//EMP Cancel Data
function showEmpCancel(id) {
    confirmCancel(id, "update/expensecancel/", "tblEmployeeExpense");
}

//expense list
function expenseList() {
    var expensegroup_id =
        $("#ddlFilterExpensegroup option:selected").val() == undefined ?
            0 :
            $("#ddlFilterExpensegroup option:selected").val();
    var ledger_id =
        $("#ddlExpenseCompany option:selected").val() == undefined ?
            0 :
            $("#ddlExpenseCompany option:selected").val();

    dtExpense = $("#tblExpense").DataTable({
        processing: true,
        serverSide: true,
        order: [
            [0, "ASC"]
        ],
        bDestroy: true,
        ajax: {
            url: "expense/data",
            data: function (data) {
                data.expensegroup_id = expensegroup_id;
                data.ledger_id = ledger_id;
                data.startdate = startdate;
                data.enddate = enddate;
            },
        },
        createdRow: function (row, data, dataIndex) {
            var cancelled = data.is_cancelled == "1" ? "1" : "0";
            $(row).find("td:eq(5)").attr("cancelled", cancelled);
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "expense_date",
                render: function (data, type, row) {
                    // Parse the date string into a Date object
                    var date = new Date(data);

                    // Format the date using the moment.js library
                    return moment(date).format("DD-MM-YYYY");
                },
            },
            { data: "ledger_name" },
            { data: "expensegroup_name" },
            { data: "notes" },
            { data: "amount" },
            { data: "amount_paid" },
            { data: "action", orderable: false },
        ],
        footerCallback: function (tfoot, data, start, end, display) {
            var api = this.api();

            // Calculate the total amount
            var totalAmount = api
                .column(5, { page: "current" })
                .data()
                .reduce(function (a, b, index) {
                    var cancelled = api
                        .row(index)
                        .nodes()
                        .to$()
                        .find("td:eq(5)")
                        .attr("cancelled");
                    if (cancelled !== "1") {
                        return parseFloat(a) + parseFloat(b);
                    } else {
                        return parseFloat(a);
                    }
                }, 0);

            // Calculate the total amount paid
            var totalAmountPaid = api
                .column(6, { page: "current" })
                .data()
                .reduce(function (c, d) {
                    return parseFloat(c) + parseFloat(d);
                }, 0);

            // Update the table footer
            $(tfoot).find("#total_amount").html(totalAmount.toFixed(2));
            $(tfoot).find("#total_paid").html(totalAmountPaid.toFixed(2));
        },
    });
}


function employeeExpenseList() {
    var expensegroup_id =
        $("#ddlFilterExpensegroup option:selected").val() == undefined ?
            0 :
            $("#ddlFilterExpensegroup option:selected").val();
    var employee_user_id =
        $("#ddlExpenseEmployee option:selected").val() == undefined ?
            0 :
            $("#ddlExpenseEmployee option:selected").val();

    dtEmpExpense = $("#tblEmployeeExpense").DataTable({
        processing: true,
        serverSide: true,
        order: [
            [0, "ASC"]
        ],
        bDestroy: true,
        ajax: {
            url: "expense/employeedata",
            data: function (data) {
                data.expensegroup_id = expensegroup_id;
                data.employee_user_id = employee_user_id;
                data.startdate = startdate;
                data.enddate = enddate;
            },
        },
        createdRow: function (row, data, dataIndex) {
            var cancelled = data.is_cancelled == "1" ? "1" : "0";
            $(row).find("td:eq(6)").attr("cancelled", cancelled);
        },
        fnRowCallback: serialNoCount,
        columns: [
            { data: "id" },
            {
                data: "expense_date",
                render: function (data, type, row) {
                    // Parse the date string into a Date object
                    var date = new Date(data);

                    // Format the date using the moment.js library
                    return moment(date).format("DD-MM-YYYY");
                },
            },
            { data: "display_name" },
            { data: "expensegroup_name" },
            { data: "notes" },
            {
                data: "expense_proof_path",
                render: function (data, type, row) {
                    if (data != null) {
                        return `<a href="${data}"
                class="badge bg-label-warning" target="_blank">View</a>`;
                    }
                    else {
                        return `<span class="badge bg-label-warning" target="_blank">NA</span>`;
                    }
                },
            },
            { data: "amount" },
            { data: "amount_paid" },
            { data: "action" },
        ],
        footerCallback: function (tfoot, data, start, end, display) {
            var api = this.api();

            // Calculate the total amount
            var totalAmount = api
                .column(6, { page: "current" })
                .data()
                .reduce(function (a, b, index) {
                    var cancelled = api
                        .row(index)
                        .nodes()
                        .to$()
                        .find("td:eq(6)")
                        .attr("cancelled");
                    if (cancelled !== "1") {
                        return parseFloat(a) + parseFloat(b);
                    } else {
                        return parseFloat(a);
                    }
                }, 0);

            // Calculate the total amount paid
            var totalAmountPaid = api
                .column(7, { page: "current" })
                .data()
                .reduce(function (c, d) {
                    return parseFloat(c) + parseFloat(d);
                }, 0);

            // Update the table footer
            $(tfoot).find("#emp_total_amount").html(totalAmount.toFixed(2));
            $(tfoot).find("#emp_total_paid").html(totalAmountPaid.toFixed(2));
        },
    });
}