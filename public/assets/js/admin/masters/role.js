$(document).ready(function () {
    $("#tblRole").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "role/data", "fnRowCallback": serialNoCount,
        columns: [{ data: "id", orderable: false }, { data: "role_name" }, { data: "action", orderable: false }],
    });
});

function doEdit(id) {
    $("#hdRoleId").val(id);
    $("#txtRoleName").focus();
    getRoleById(id);
}

function getRoleById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "role/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtRoleName").val(data.role.role_name);
            $("#pageloader").fadeOut();
        },
    });
}
