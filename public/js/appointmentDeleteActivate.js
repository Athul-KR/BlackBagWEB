// Deactivate Nurse
$(document).on("click", ".delete-appt", function () {
    var url = this.getAttribute("data-appointmenturl");

    swal("Are you sure you want to cancel this appointment?", {
        title: "Cancel!",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    console.log(response);
                    swal({
                        title: "Cancelled!",
                        text: "The appointment has been cancelled successfully" ,
                        icon: "success",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                        console.log(response);
                        window.location.href = response.redirect;
                    });

                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
            // Cancel the request if the appointment navigates away
            $(window).on("unload", function () {
                xhr.abort();
            });
        }
    });
});

// Activate appointment
$(document).on("click", ".activate-appt", function () {
    var url = this.getAttribute("data-appointmenturl");

    swal("Are you sure you want to activate this appointment?", {
        title: "Activate!",
        icon: "warning",
        buttons: true,
    }).then((willactivate) => {
        if (willactivate) {
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    if (response.success == "error") {
                        swal("Error!", response.message, "error");
                    } else {
                        swal("Activated!", 'The appointment has been activated successfully', "success").then(() => {
                            window.location.href = response.redirect;
                        });
                    }
                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
            // Cancel the request if the appointment navigates away
            $(window).on("unload", function () {
                xhr.abort();
            });
        }
    });
});
