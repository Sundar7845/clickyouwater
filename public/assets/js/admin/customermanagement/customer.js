$(document).ready(function () {
    customerList();
});

$("#ddlcustomerType,#ddlstatus,#ddlState,#ddlCity").change(function () {
    customerList();
    BindHub();
});

$("#ddlHub").change(function () {
    customerList();
});

function customerList() {
    var customer_type_id =
        $("#ddlcustomerType option:selected").val() == undefined
            ? 0
            : $("#ddlcustomerType option:selected").val();
    var status_id =
        $("#ddlstatus option:selected").val() == undefined
            ? 0
            : $("#ddlstatus option:selected").val();
    var state_id =
        $("#ddlState option:selected").val() == undefined
            ? 0
            : $("#ddlState option:selected").val();
    var district_id =
        $("#ddlCity option:selected").val() == undefined
            ? 0
            : $("#ddlCity option:selected").val();
    // var area_id = 
    //     $("#ddlArea option:selected").val() == undefined
    //     ? 0
    //     : $("#ddlArea option:selected").val();
    var hub_id =
        $("#ddlHub option:selected").val() == undefined
            ? 0
            : $("#ddlHub option:selected").val();

    //Get type from url to the dataTable
    var type = "";
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has("type")) {
        type = urlParams.get("type");
    }

    $('#tblcustomer').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/customersData/" + type,
            data: function (customer) {
                customer.customer_type_id = customer_type_id;
                customer.status_id = status_id;
                customer.state_id = state_id;
                customer.district_id = district_id;
                customer.type = type;
                customer.hub_id = hub_id;
            }
        },
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: null,
                render: function (data, type, row) {
                    if (data) {
                        let html = `<h>${data.customer_name}</h>`;
                        if (data.email) {
                            html += `<div class="text-muted p-1">
                            <small class="bg-light p-1">${data.email}</small>
                            </div>`;
                        }
                        return html;
                    } else {
                        return "";
                    }
                }
            },
            { data: "customer_type" },
            { data: "mobile" },
            { data: "formatted_reg_date" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                                        <input onclick="doStatus(${row.id});" id="chkCustomer${row.id}" type="checkbox" class="switch-input" name="chkCustomer" ${data == 1 ? "checked" : ""} />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>`;
                },
            },
            // {
            //     data: "company",
            //     render: function (data, type, row) {
            //         return `<a href="/depostihistory/${row.id}" class="btn btn-xs btn-warning">View</a>`;
            //     }
            // },
            {
                data: "company",
                render: function (data, type, row) {
                    return `<a href="/customerssummary/${row.id}" class="btn btn-xs btn-primary">View</a>`;
                }
            }
        ],
    });
}

function doStatus(id) {
    var status = $("#chkCustomer" + id).is(":checked");
    confirmStatusChange(
        id,
        "customer/",
        "tblcustomer",
        status == true ? 1 : 0,
        "chkCustomer"
    );
}
