$(document).ready(function () {
    $("#tblUsers").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "userpermission/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            { data: "user_name" },
            { data: "role_name" },
            { data: "display_name" },
            { data: "email" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                        <input onclick="doStatus(${row.id});" id="chkUserPermission${row.id}" type="checkbox" class="switch-input"
                        name="chkUserPermission" '  ${(data == 1 ? "checked" : "")} ' />
                        <span class="switch-toggle-slider">
                            <span class="switch-on"></span>
                            <span class="switch-off"></span>
                        </span>
                    </label>`;
                }
            },
            { data: "action", orderable: false },
        ],
    });
});


$("#ddlRoleName").on("change", function () {
    $('#tbodyMenuList').empty();
    var id = $('#ddlRoleName').val();
    LoadMenus(id);
});
//Append Menus
function LoadMenus(id) {
    $("#pageloader").fadeIn();
    jQuery.ajax({
        type: "GET",
        url: "listmenus/" + id,
        async: false,
        dataType: 'json',
    }).done(function (menuData) {
        $('#tbodyMenuList tr').empty();
        var List = "";
        $.each(menuData.menu, function (idx, val) {
            List += "<tr id='trstu' >";
            List += "<td>" + (idx + 1) + "</td>";

            List += "<td>" + val.menu_name + "<input type='hidden' name='menuId[]' value=" + val.id + " ></td>";

            List += "<td><label class='switch switch-primary'><input type='checkbox'  name='checkEdit[" + val.id + "][]' id='checkEdit" + val.id + "' value='1' class='switch-input'><span class='switch-toggle-slider'><span class='switch-on'><i class='ti ti-check'></i></span><span class='switch-off'><i class='ti ti-x'></i></span></span></td>";

            List += "<td><label class='switch switch-primary'><input type='checkbox' name='checkDelete[" + val.id + "][]' id='checkDelete" + val.id + "' value='1' class='switch-input'><span class='switch-toggle-slider'><span class='switch-on'><i class='ti ti-check'></i></span><span class='switch-off'><i class='ti ti-x'></i></span></span></td>";

            List += "<td><label class='switch switch-primary'><input type='checkbox' name='checkPrint[" + val.id + "][]' id='checkPrint" + val.id + "' value='1' class='switch-input'><span class='switch-toggle-slider'><span class='switch-on'><i class='ti ti-check'></i></span><span class='switch-off'><i class='ti ti-x'></i></span></span></td>";

            List += "<td><label class='switch switch-primary'><input type='checkbox' name='checkView[" + val.id + "][]' id='checkView" + val.id + "' value='1' class='switch-input'><span class='switch-toggle-slider'><span class='switch-on'><i class='ti ti-check'></i></span><span class='switch-off'><i class='ti ti-x'></i></span></span></td>";

            List += "<td><label class='switch switch-primary'><input type='checkbox' name='checkApproval[" + val.id + "][]' id='checkApproval" + val.id + "' value='1' class='switch-input'><span class='switch-toggle-slider'><span class='switch-on'><i class='ti ti-check'></i></span><span class='switch-off'><i class='ti ti-x'></i></span></span></td>";

            List += "</td>";
            List += "</tr>";
        });
        $("#tbodyMenuList").html(List);
    })
    $("#pageloader").fadeOut();
}

//Edit Permission Data
function doEdit(id) {
    $("#hdRolePermissionId").val(id);
    $("#ddlRoleName").focus();
    $("#btnSave").text("Update");
    $("#rolePermissionTitle").text("Update Users");
    getUserPermissionById(id);
}

//Delete Permission Data
function showDelete(id) {
    confirmDelete(id, "delete/userpermission/", "tblUsers");
}

//Get Permission By ID
function getUserPermissionById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getuserpermission/" + id,
        dataType: "json",
        success: function (data) {
            setTimeout(function () {
                $("#ddlRoleName").val(data.userPermission.role_id).trigger("change");
            }, 1500);
            $("#txtUserName").val(data.userPermission.user_name);
            $("#txtDisplayName").val(data.userPermission.display_name);
            $("#txtUserEmail").val(data.userPermission.email);

            $.each(data.userMenuPermission, function (idx, val) {

                var count = val.menu_id;

                setTimeout(function () {
                    if (val.is_approval == 1) {
                        $("#checkApproval" + count).attr("checked", true);
                    }
                    if (val.is_delete == 1) {
                        $("#checkDelete" + count).attr("checked", true);
                    }
                    if (val.is_edit == 1) {
                        $("#checkEdit" + count).attr("checked", true);
                    }
                    if (val.is_print == 1) {
                        $("#checkPrint" + count).attr("checked", true);
                    }
                    if (val.is_view == 1) {
                        $("#checkView" + count).attr("checked", true);
                    }
                    $("#pageloader").fadeOut();
                }, 3000);
            });
        },
    });
}

//Update Status
function doStatus(id) {
    var status = $("#chkUserPermission" + id).is(":checked");
    confirmStatusChange(id, "userpermission/", "tblUsers", (status == true ? 1 : 0), "chkUserPermission");
}

//Cancel
function Cancel() {
    $("#rolePermissionTitle").text("Users");
    $("#ddlRoleName").focus();
    $("#ddlRoleName").val(0).trigger("change");
    $("#hdRolePermissionId").val("");
    $("#txtUserName").val("");
    $("#txtDisplayName").val("");
    $("#txtUserEmail").val("");
    $("#btnSave").text("Save");
}
