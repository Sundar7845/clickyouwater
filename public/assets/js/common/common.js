var baseUrl = document
    .querySelector('meta[name="base-url"]')
    .getAttribute("content");
$(document).ready(function () {
    $("#ddlState").on("change", function () {
        BindCity();
    });

    $("#ddlCity").on("change", function () {
        BindArea();
    });

    //Set autofocus to select2 search field
    $(document).on("select2:open", () => {
        document.querySelector(".select2-search__field").focus();
    });
});

function BindCity() {
    $("#pageloader").fadeIn();
    var state_id = $("#ddlState").val();
    $("#ddlCity").html("");
    $.ajax({
        url: "/get/cities",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            state_id: state_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#ddlCity").html('<option value="">Select District</option>');
            $.each(result, function (key, value) {
                $("#ddlCity").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.city_name +
                    "</option>"
                );
            });
            $("#pageloader").fadeOut();
        },
    });
}

//Bind Area
function BindArea() {
    $("#pageloader").fadeIn();
    var city_id = $("#ddlCity").val();
    $("#ddlArea").html("");
    $.ajax({
        url: "/getareabycity",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            city_id: city_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#ddlArea").html('<option value="">Select Area</option>');
            $.each(result, function (key, value) {
                $("#ddlArea").append(
                    '<option value="' +
                    value.id +
                    '">' +
                    value.area_name +
                    "</option>"
                );
            });
            $("#pageloader").fadeOut();
        },
    });
}

//Bind Hub
function BindHub() {
    $("#pageloader").fadeIn();
    var state_id =
        $("#ddlState option:selected").val() == undefined
            ? 0
            : $("#ddlState option:selected").val();
    var city_id =
        $("#ddlCity option:selected").val() == undefined
            ? 0
            : $("#ddlCity option:selected").val();
    $("#ddlHub").html("");
    $.ajax({
        url: "/gethubbycity",
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
            city_id: city_id,
            state_id: state_id,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (result) {
            $("#ddlHub").html('<option value="">Select Hub</option>');
            $.each(result, function (key, value) {
                $.each(value, function (keyone, arrvalue) {
                    $("#ddlHub").append(
                        '<option value="' +
                        arrvalue.id +
                        '">' +
                        arrvalue.hub_name +
                        "</option>"
                    );
                });
            });
            $("#pageloader").fadeOut();
        },
    });
}

function confirmDelete(id, url, tblId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        customClass: {
            confirmButton: "btn btn-success me-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            doDelete(id, url, tblId);
        }
    });
}

function doDelete(id, url, tblId) {
    $.ajax({
        type: "GET",
        url: url + id,
        dataType: "json",
        success: function (data) {
            if (data.responseData.alert == "error") {
                Swal.fire({
                    title: "You won't be able to delete this!",
                    text: "This is referred in some other instance!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                    buttonsStyling: false,
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
            refreshDatatable(tblId);
        },
    });
}

function confirmStatusChange(id, url, tblId, status, chkswitch) {
    Swal.fire({
        title:
            status == 1
                ? "Are you sure want to Activate the status?"
                : "Are you sure want to DeActivate the status?",
        text: "You can able to revert this!",
        icon: status == 1 ? "warning" : "error",
        showCancelButton: true,
        confirmButtonText:
            status == 1 ? "Yes, Activate it!" : "Yes, DeActivate it!",
        customClass: {
            confirmButton: "btn btn-success me-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            statusUpdate(id, url, status);
            Swal.fire({
                icon: "success",
                title: status == 0 ? "DeActivated!" : "Activated!",
                text:
                    status == 0
                        ? "Your file has been deactivated."
                        : "Your file has been activated.",
                customClass: {
                    confirmButton: "btn btn-success",
                },
            });
        } else {
            $("#" + chkswitch + id).prop("checked", status == 1 ? false : true);
        }
        refreshDatatable(tblId);
    });
}

function statusUpdate(id, url, status) {
    $.ajax({
        type: "POST",
        url: url + id + "/" + status,
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function (data) {
            if (data.returnActivation.alert === "returnActivation") {
                Swal.fire({
                    title: "Hub Activation Failed!",
                    text: "There is no active Logistic Partner or a Delivery Person under this hub.",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },

                })
            }
            return true;
        },
    });
}

function refreshDatatable(tblId) {
    $("#" + tblId)
        .DataTable()
        .ajax.reload();
}

$(document).ready(function () {
    $(".mobilenumber").on("input", function () {
        $(this).val(
            $(this)
                .val()
                .replace(/[^0-9]/g, "")
        );

        var mobileNumber = $(this).val();
        if (mobileNumber.length != 10 || isNaN(mobileNumber)) {
            $(this).css("border-color", "red");
        } else {
            $(this).css("border-color", "green");
        }
    });
    $(".acc_no").on("input", function () {
        $(this).val(
            $(this)
                .val()
                .replace(/[^0-9]/g, "")
        );

        var mobileNumber = $(this).val();
        if (isNaN(mobileNumber)) {
            $(this).css("border-color", "red");
        } else {
            $(this).css("border-color", "green");
        }
    });
});
var emailInputs = document.querySelectorAll('input[type="email"]');

// Loop through each email input and add an event listener for validation
emailInputs.forEach(function (input) {
    input.addEventListener("blur", function () {
        // Get the value of the input field
        var email = this.value;

        // Define a regular expression for email validation
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        // Test the email value against the regular expression
        if (!emailRegex.test(email)) {
            // Display an error message if the email is invalid
            this.setCustomValidity("Please enter a valid email address.");
        } else {
            // Clear the error message if the email is valid
            this.setCustomValidity("");
        }
    });
});

//Number Validate
$(".numvalidate").keypress(function (e) {
    var charCode = e.which ? e.which : e.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
});

//cancel update
function confirmCancel(id, url, tblId) {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "error",
        showCancelButton: true,
        confirmButtonText: "Yes, cancel it!",
        customClass: {
            confirmButton: "btn btn-success me-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            doCancel(id, url, tblId);
        }
    });
}

function doCancel(id, url, tblId) {
    $.ajax({
        type: "GET",
        url: url + id,
        dataType: "json",
        success: function (data) {
            console.log(data);
            if (data.responseData.alert == "error") {
                Swal.fire({
                    title: "Expense Entry is being referenced with another instance!",
                    text: "This is referred in some other instance!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                    buttonsStyling: false,
                });
            } else {
                Swal.fire({
                    icon: "success",
                    title: "Canceled!",
                    text: "Your file has been cancelled.",
                    customClass: {
                        confirmButton: "btn btn-success",
                    },
                });
            }
            refreshDatatable(tblId);
        },
    });
}

function verificationUpdate(id, url, status) {
    $.ajax({
        type: "POST",
        url: url + id + "/" + status,
        data: {
            status: status,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        dataType: "json",
        success: function () {
            return true;
        },
    });
}

//document verification
function confirmVerification(id, url, status, chkswitch) {
    Swal.fire({
        title:
            status == 1
                ? "Are you sure want to verify the document?"
                : "Are you sure want to not verify the status?",
        text: "You won't be able to revert this!",
        icon: status == 1 ? "warning" : "error",
        showCancelButton: true,
        confirmButtonText:
            status == 1 ? "Yes, verify it!" : "Yes, not verify it!",
        customClass: {
            confirmButton: "btn btn-success me-3",
            cancelButton: "btn btn-danger",
        },
        buttonsStyling: false,
    }).then(function (result) {
        if (result.value) {
            verificationUpdate(id, url, status);
            Swal.fire({
                icon: "success",
                title: status == 1 ? "Verified!" : "Not verified!",
                text:
                    status == 1
                        ? "Your file has been verified."
                        : "Your file has been not verified.",
                customClass: {
                    confirmButton: "btn btn-success",
                },
            });
        } else {
            $("#" + chkswitch + id).prop("checked", status == 1 ? false : true);
            location.reload();
        }
    });
}

//Check User Mobile Number If Already Exists
function checkMobileNumberExists(mobileNumber, roleId, refId, callback) {
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/check-mobile-number",
        method: "POST",
        data: {
            mobile_number: mobileNumber,
            role_id: roleId,
            ref_id: refId,
            _token: $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.status == "error") {
                Swal.fire({
                    title: "Mobile number already exists!",
                    text: "You won't be able to use this mobile number!",
                    icon: "error",
                    customClass: {
                        confirmButton: "btn btn-primary",
                    },
                    buttonsStyling: false,
                });
                callback(true);
            } else {
                callback(false);
            }
        },
    });
}

function serialNoCount(nRow, aData, iDisplayIndex) {
    var api = this.api();
    var currentPage = api.page.info().page;
    var index = currentPage * api.page.info().length + (iDisplayIndex + 1);

    $("td:first", nRow).html(index);

    return nRow;
}
