//Create Nurse
$(document).on("click", "#nurse-create", function () {
    var url = $("#nurse-create").attr("data-nurse-create-url");

    $("#add-nurse-modal").html(
        '<div class="d-flex justify-content-center py-5"><img src="' +
            loaderGifUrl +
            '" width="250px"></div>'
    );

    $.ajax({
        type: "GET",
        url: url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },

        success: function (response) {
            // Populate form fields with the logger details

            if (response.status == 1) {
                $("#add-nurse-modal").html(response.view);
            }
        },
        error: function(xhr) {
               
            handleError(xhr);
        },
    });
});

//Clear validations on modal close
$("#addNurse").on("aria-hidden.modal", function () {
    $("#nurse-create-form")[0].reset(); // Reset form fields

    $("#nurse-create-form").validate().resetForm(); // Clear validation errors

    $(".error").removeClass("error"); // Remove validation error class
});
