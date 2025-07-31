// Deactivate Nurse
$(document).on("click", ".detete-nurse", function () {
    var url = this.getAttribute("data-nurseurl");
    
    swal("Are you sure you want to deactivate this nurse?", {
        title: "Deactivate!",
        icon: "warning",
        buttons: true,
    }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                   
                    swal(
                        "Deactivated!",
                        "The nurse has been deactivated successfully",
                        "success"
                    ).then(() => {
                        console.log(response);
                        
                        // Refresh the page when the nurse clicks OK or closes the alert
                      
                        window.location.href = response.redirect;
                       
                    });
                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
            // Cancel the request if the nurse navigates away
            $(window).on("unload", function () {
                xhr.abort();
            });
        }
    });
});

// Resend Invitation Nurse
$(document).on("click", ".resendInvite-nurse", function () {
    var url = this.getAttribute("data-nurseurl");

    swal({
        text: "Are you sure you want to resend invitation for this nurse?",
          // text: "This action cannot be undone!",
          icon: "warning",
          buttons: {
              cancel: "Cancel",
              confirm: {
                  text: "OK",
                  value: true,
                  closeModal: false // Keeps the modal open until AJAX is done
              }
          },
          dangerMode: true
    
    }).then((willresend) => {
        if (willresend) {
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    if (response.success == 1) {
                        swal("Success!", response.message, "success").then(
                            () => {
                                // Refresh the page when the nurse clicks OK or closes the alert
                                location.reload();
                            }
                        );
                    } else {
                        swal("Error!", response.message, "error");
                    }
                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
            // Cancel the request if the nurse navigates away
            $(window).on("unload", function () {
                xhr.abort();
            });
        }
    });
});

// Activate Nurse
$(document).on("click", ".activate-nurse", function () {
    var url = this.getAttribute("data-nurseurl");

    swal("Are you sure you want to activate this nurse?", {
        title: "Activate!",
        icon: "warning",
        buttons: true,
    }).then((willactivate) => {
        if (willactivate) {
            $.ajax({
                type: "GET",
                url: url,
                success: function (response) {
                    console.log(response);

                    swal(
                        "Activated!",
                        "The nurse has been activated successfully",
                        "success"
                    ).then(() => {
                        // Refresh the page when the nurse clicks OK or closes the alert
                        location.reload();
                    });
                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
            // Cancel the request if the nurse navigates away
            $(window).on("unload", function () {
                xhr.abort();
            });
        }
    });
});
