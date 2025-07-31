//Edit Nurse
$(document).on("click", "#edit-nurse", function () {
    var url = this.getAttribute("data-nurseurl");

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
