$(document).ready(function () {
    ImgUpload();
    $("#tblCategory").DataTable({
        processing: true,
        serverSide: true,
        order: [[0, "ASC"]],
        ajax: "category/data", "fnRowCallback": serialNoCount,
        columns: [
            { data: "id", orderable: false },
            {
                data: "category_image",
                render: function (data) {
                    return (
                        '<img src="' +
                        data +
                        '" class="avatar" width="50" height="50"/>'
                    );
                },
            },
            { data: "category_name" },
            { data: "category_desc" },
            {
                data: "is_active",
                render: function (data, type, row) {
                    return `<label class="switch">
                <input onclick="doStatus(${row.id});" id="chkCategory${row.id
                        }" type="checkbox" class="switch-input"
                name="chkCategory" '  ${data == 1 ? "checked" : ""} ' />
                <span class="switch-toggle-slider">
                    <span class="switch-on"></span>
                    <span class="switch-off"></span>
                </span>
                </label>`;
                },
            },
            { data: "action", orderable: false },
        ],
    });
});


$('#chkWaterCan').on('change', function() {
    if ($(this).is(':checked')) {
      $(this).val('1');
    } else {
      $(this).val('0');
    }
  });


function doStatus(id) {
    var status = $("#chkCategory" + id).is(":checked");
    confirmStatusChange(
        id,
        "category/",
        "tblCategory",
        status == true ? 1 : 0,
        "chkCategory"
    );
}

function doEdit(id) {
    $("#hdCategoryId").val(id);
    $("#txtCategoryName").focus();
    $("#categoryTittle").text("Update Category");
    $("#btnSave").text("Update");
    getCategoryById(id);
    
}

function getCategoryById(id) {
    $("#pageloader").fadeIn();
    $.ajax({
        type: "GET",
        url: "getcategory/" + id,
        dataType: "json",
        success: function (data) {
            $("#txtCategoryName").val(data.category.category_name);
            $("#txtCategoryDescription").val(data.category.category_desc);
            var img =
                "<div class='upload__img-box'><div id='show_img'  style='background-image: url(" +
                data.category.category_image +
                ")' data-number='" +
                $(".upload__img-close").length +
                "' data-file='" +
                data.category.category_name +
                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
            $(".upload__img-wrap").html(img);
            $("#hdOldImg").val(data.category.category_image);
            if (data.category.category_image) {
                $("#CategoryImage").removeAttr("required");
            }
          $("#chkWaterCan").val(data.category.is_watercan);
           if($("#chkWaterCan").val() == 1){
            $("#chkWaterCan").prop("checked", true);
           }
            ImgUpload();
            $("#pageloader").fadeOut();
        },
    });
}

function cancel() {
    $("#categoryTittle").text("Category");
    $("#hdCategoryId").val("");
    $("#txtCategoryName").val("");
    $("#txtCategoryDescription").val("");
    $(".upload__img-wrap").html("");
    $("#btnSave").text("Save");
    $("#txtCategoryName").focus();
    $("#chkWaterCan").prop("checked", false);
}

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $("#CategoryImage").each(function () {
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

function showDelete(id) {
    confirmDelete(id, "delete/category/", "tblCategory");
}

// jquery Validation
$(function () {
    $("form[name='category']").validate({
        rules: {
            txtCategoryName: "required",
            txtCategoryDescription: "required",
        },
    });
});