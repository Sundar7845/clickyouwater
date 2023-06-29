$(document).ready(function () {
    ImgUpload();
    companyLogo();
});

function doMaintenanceMode(id) {
    var status = $("#chkmaintenance" + id).is(":checked");
    confirmMaintenanceModeChange(
        id,
        "maintenancemode/",
        1,
        status == true ? 1 : 0,
        "chkmaintenance"
    );
}

function confirmMaintenanceModeChange(id, url, tblId, status, chkswitch) {
    Swal.fire({
        title:
            status == 1
                ? "Are you sure want to Activate the Maintenance Mode?"
                : "Are you sure want to DeActivate the Maintenance Mode?",
        text: "You won't be able to revert this!",
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

// jquery Validation
$(function () {
    $("form[name='admin_setting_razorpay']").validate({
        rules: {
            txtrazorpayid: "required",
            txtrazorpaykey: "required",
        },
        messages: {
            required: "This field is required",
        },
    });
});


function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $("#company_logo").each(function () {
        $(this).on("change", function (e) {
            imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
            var maxLength = $(this).attr("data-max_length");

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {
                if (!f.type.match("image.*")) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false;
                } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html =
                                "<div class='upload__img-box'><div style='background-image: url(" +
                                e.target.result +
                                ")' data-number='" +
                                $(".upload__img-close").length +
                                "' data-file='" +
                                f.name +
                                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.html(html);
                            iterator++;
                        };
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    $("body").on("click", ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
    });
}

function companyLogo() {
    var imgWrap = "";
    var imgArray = [];

    $("#app_logo").each(function () {
        $(this).on("change", function (e) {
            imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
            var maxLength = $(this).attr("data-max_length");

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {
                if (!f.type.match("image.*")) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false;
                } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html =
                                "<div class='upload__img-box'><div style='background-image: url(" +
                                e.target.result +
                                ")' data-number='" +
                                $(".upload__img-close").length +
                                "' data-file='" +
                                f.name +
                                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.html(html);
                            iterator++;
                        };
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    $("body").on("click", ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
    });
}
