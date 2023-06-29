$(document).ready(function () {
    $('#tblExpenseGroupList').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        ajax: "expensegroup/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "expensegroup_name" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                        <input onclick="doStatus(${row.id});" id="chkExpensegroup${row.id}" type="checkbox" class="switch-input"
                        name="chkExpensegroup" '  ${(data == 1 ? "checked" : "")} ' />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                    </label>`;
                }
            },
            { data: "action", orderable: false }
        ],
    });
});

function doStatus(id) {
    var status = $("#chkExpensegroup" + id).is(":checked");
    confirmStatusChange(id, "expensegroup/", "tblExpenseGroupList", (status == true ? 1 : 0), "chkExpensegroup");
}

function doEdit(id) {
    $("#hdExpensegroupId").val(id);
    $("#expenseGroupTitle").text("Update Expense Group");
    $("#txtExpense").focus();
    $("#btnSave").text("Update");
    getExpensegroupById(id);
}

function getExpensegroupById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getexpensegroup/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtExpense").val(data.expensegroup.expensegroup_name);
            $("#pageloader").fadeOut();
        },
    });
}

function showDelete(id) {
    confirmDelete(id, "delete/expensegroup/", "tblExpenseGroupList");
}

function cancel() {
    $("#hdExpensegroupId").val("");
    $("#expenseGroupTitle").text("Expense Group");
    $("#txtExpense").val("").focus();
    $("#btnSave").text("Save");
}

//jquery Validation
$(function () {

    $("form[name='expenseGroup']").validate({
        rules: {
            txtExpense: "required",
        },
    });
});


