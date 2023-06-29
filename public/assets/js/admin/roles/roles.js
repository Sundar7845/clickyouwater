//DataTable
var treeData = [];
var selKeys;
var MenuList = "";
$(document).ready(function () {
	$("#tblRole").DataTable({
		processing: true,
		serverSide: true,
		order: [[0, "ASC"]],
		ajax: "permission/data", "fnRowCallback": serialNoCount,
		columns: [
			{ data: "id", orderable: false },
			{ data: "role_name" },
			{ data: "action", orderable: false },
		],
	});

	//Load MenuList
	Loadmenu();
	$("#divMenuList").dynatree({
		autoCollapse: true,
		checkbox: true,
		selectMode: 3,
		children: treeData,
		debugLevel: 0,
		onSelect: function (select, node) {
			selKeys = $.map(node.tree.getSelectedNodes(), function (node) {
				return node.data.key;
			});
			var partsel = new Array();
			$(".dynatree-partsel:not(.dynatree-selected)").each(function () {
				var node = $.ui.dynatree.getNode(this);
				partsel.push(node.data.key);
			});
			selKeys = selKeys.concat(partsel);
		}
	});
});

// jquery Validation
$(function () {
	$("form[name='rolePermission']").validate({
		rules: {
			ddlRole: "required",
		},
		messages: {
			required: "This field is required",
		},
		submitHandler: function (form) {
			postMenus();
			form.submit();
		},
		errorPlacement: function (error, element) {
			if (element.is(":radio")) {
				error.appendTo(element.parents(".form-group"));
			} else {
				// This is the default behavior
				// error.insertAfter(element);
				if (element.siblings(".error").html() == undefined) {
					error.appendTo(element.parent().next(".error"));
				} else {
					error.appendTo(element.siblings(".error"));
				}
			}
		},
	});
});

//Load Permission ID To Database
function postMenus() {
	var LST = [];

	var tree = $("#divMenuList").dynatree("getTree");

	$.each(selKeys, function (idx, val) {
		LST.push(val);
	});
	$("#permission_id").val(LST);
}

//Load Menus
function Loadmenu() {
	$("#pageloader").fadeIn();
	jQuery.ajax({
		type: "GET",
		url: "/get-menus",
		async: false,
		data: {
			"type": 'menus'
		},
		dataType: 'json',
		success: function (data) {
			console.log(data);
			MenuList = data.menus;
			bindMenu();
			$("#pageloader").fadeOut();
		}
	});
}

//Binding Menus
function bindMenu() {
	$.each(MenuList, function (idx, val) {
		if (this.is_mainmenu == "1") {
			if (this.id == "1") {
				treeData.push({ "title": this.menu_name, "key": $.trim(this.id), select: true, unselectable: true });
			}
			else {
				if ($.trim(val.parent_id) == 0 && $.trim(val.is_module) == 0) {
					treeData.push({ "title": this.group_name + "-" + this.menu_name, "key": $.trim(this.id), "children": [] });
				}
				else {
					treeData.push({ "title": this.menu_name, "key": $.trim(this.id), "children": [] });
				}
			}
		}
		else {
			$.each(treeData, function () {
				if (this.key == $.trim(val.parent_id)) {
					this.children.push({ "title": val.menu_name, "key": $.trim(val.id) });
				}
			});
		}

	});

}

//Edit Permission Data
function doEdit(id, UGID) {
	$("#hdPermission_id").val(id);
	$("#ddlRole").focus();
	$("#btnSave").text("Update");
	$("#roleTitle").text("Update Roles & Menu Permission");
	getPermissionById(id);
	GetRollmenu(id);
}

//Bind DynaTree Menus on Edit
function GetRollmenu(id) {
	$("#pageloader").fadeIn();
	var RID = $("#ddlRole option:selected").val();
	$("#divMenuList").dynatree("getRoot").visit(function (node) {
		node.select(false);
	});
	jQuery.ajax({
		type: "GET",
		url: "getpermission/" + id,
		async: false,
		data: {
			"id": RID
		},
		dataType: 'json',
		success: function (data) {

			var MList = "";
			var menuID = data.permission.menu_id;
			var MList = menuID.split(",");

			$("#divMenuList").dynatree("getRoot").visit(function (node) {
				node.select(false);
			});

			$.each(MList, function (idx, val) {
				$("#divMenuList").dynatree("getRoot").visit(function (node) {
					if (node.data.key == $.trim(val)) {
						node.select(true);
					}
				});
			});
			$("#pageloader").fadeOut();
		}
	});
}

//Delete Permission Data
function showDelete(id) {
	confirmDelete(id, "delete/permission/", "tblRole");
}

//Get Permission By ID
function getPermissionById(id) {
	$.ajax({
		type: "GET",
		url: "getpermission/" + id,
		dataType: "json",
		success: function (data) {
			$.each(data.role, function (key, val) {
				var newOption = '<option value="' + val.id + '">' + val.role_name + '</option>';
				$("#ddlRole").append(newOption);
				$("#ddlRole").val(val.id).trigger("change");
				$("#hdRole_id").val(val.id);
			});
		},
	});
	$("#ddlRole").attr('disabled', 'disabled');
}

//Cancel
function cancel() {
	$("#ddlRole").val("").trigger("change");
	$("#divMenuList").dynatree("getRoot").visit(function (node) {
		node.select(false);
	});
	$("#hdPermission_id").val("");
	$("#hdRole_id").val("");
	$("#roleTitle").text("Roles & Menu Permission");
	$("#ddlRole").removeAttr('disabled');
	$("#ddlRole").focus();
	$("#btnSave").text("Save");
}