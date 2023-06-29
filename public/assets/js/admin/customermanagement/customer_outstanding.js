//Init Customer Outstanding DataTable
$(document).ready(function () {
    CustomerOutstandingList();
});

//Apply Filters
$("#ddlState,#ddlCity,#ddlHub").change(function () {
    CustomerOutstandingList();
    BindHub();
});

//Load DataTable
function CustomerOutstandingList() {
    var state_id =
        $("#ddlState option:selected").val() == undefined
            ? 0
            : $("#ddlState option:selected").val();
    var district_id =
        $("#ddlCity option:selected").val() == undefined
            ? 0
            : $("#ddlCity option:selected").val();
    var hub_id =
        $("#ddlHub option:selected").val() == undefined
            ? 0
            : $("#ddlHub option:selected").val();

    $('#tblCustomerOutstanding').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        order: [[0, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "/outstandingData/",
            data: function (outstandingData) {
                outstandingData.state_id = state_id;
                outstandingData.district_id = district_id;
                outstandingData.hub_id = hub_id;
            },
        },
        "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: null,
                render: function (data, type, row) {
                    return data.customer_name + "<br><span class='badge bg-light text-muted'>" + data.mobile + "</span>";
                }
            },
            {
                data: null,
                render: function (data, type, row) {
                    return data.building_no + ", " + data.street + ", " + data.area;
                }
            },
            { data: "product_name" },
            { data: "extra_qty" },
            { data: "outstanding_amount" },
            { data: "action" },
        ],
    });
}

//Setteled Function
function doSettled(id, product_id, extra_qty, outstanding_amount, customer_address_id) {
    Swal.fire({
        title: "Are you sure to settle this outstanding amount?",
        text: "You can able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, settle it!",
        customClass: {
            confirmButton: "btn btn-success me-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function () {
        var tblId = 'tblCustomerOutstanding';
        $.ajax({
            url: "/settledOutstanding",
            method: "GET",
            data: {
                user_id: id,
                product_id: product_id,
                extra_qty: extra_qty,
                outstanding_amount: outstanding_amount,
                customer_address_id: customer_address_id,
            },
            dataType: "json",
            success: function (response) {
                if (response.status == "error") {
                    Swal.fire({
                        title: "Couldn't Settle the Outstanding Amount!",
                        text: "The Outstanding amount cant be Settled.",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                        buttonsStyling: false,
                    }).then(function () {
                        refreshDatatable(tblId);
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Outstanding Amount Settled!",
                        text: "The outstanding amount settled succesfully.",
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    }).then(function () {
                        refreshDatatable(tblId);
                    });
                }
            },
        });
    });
}

//Collected Function
function doCollected(id, product_id, extra_qty, outstanding_amount, customer_address_id) {
    Swal.fire({
        title: "Are you sure to collect this outstanding amount?",
        text: "You can able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, Collect it!",
        customClass: {
            confirmButton: "btn btn-success me-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function () {
        var tblId = 'tblCustomerOutstanding';
        $.ajax({
            url: "/collectedOutstanding",
            method: "GET",
            data: {
                user_id: id,
                product_id: product_id,
                extra_qty: extra_qty,
                outstanding_amount: outstanding_amount,
                customer_address_id: customer_address_id,
            },
            dataType: "json",
            success: function (response) {
                if (response.status == "error") {
                    Swal.fire({
                        title: "Couldn't Collect Outstanding Amount!",
                        text: "The outstanding amount cant be collected.",
                        icon: "error",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                        buttonsStyling: false,
                    }).then(function () {
                        refreshDatatable(tblId);
                    });
                } else {
                    Swal.fire({
                        icon: "success",
                        title: "Outstanding Amount Collected!",
                        text: "The outstanding amount collected succesfully.",
                        customClass: {
                            confirmButton: "btn btn-success",
                        },
                    }).then(function () {
                        refreshDatatable(tblId);
                    });
                }
            },
        });
    });
}