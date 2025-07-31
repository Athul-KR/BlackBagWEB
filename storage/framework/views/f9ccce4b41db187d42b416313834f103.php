<?php $__env->startSection('title', 'My Appointments'); ?>
<?php $__env->startSection('content'); ?>


<section class="details_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="row">
                        <div class="col-sm-5 text-center text-sm-start">
                            <h4 class="mb-md-0">Appointments</h4>
                        </div>
                        <div class="col-sm-7 text-center text-sm-end">
                            <div class="btn_alignbox justify-content-sm-end">

                            </div>
                        </div>

                        <div class="col-12">
                            <ul class="nav nav-pills mt-3 mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?php echo e($type == 'online' ? 'active' : ''); ?>" id="pills-home-tab"
                                        onclick="online('online','upcoming')"
                                        data-url="<?php echo e(route('frontend.myAppointments')); ?>" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">Online
                                        Appointments</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?php echo e($type == 'offline' ? 'active' : ''); ?>" id="pills-profile-tab"
                                        onclick="online('offline','upcoming')" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false">In-person
                                        Appointments</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <!-- Content here Online -->
                                <div id="online-content">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notes Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title mb-3" id="appointmentNotesLabel">Appointment Notes</h4>
                <p id="appointmentNotesData">

                </p>

                
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function () {
        var status = "<?php echo e(($status)); ?>";
        var type = "<?php echo e(($type)); ?>";
        console.log(status + type);

        if (status && type) {
            online(type, status);

        } else {
            online('online', 'upcoming');
        }


    });


    //Listing the appointments based on the  type online and offline
    function online(type, status, page = 1, perPage = 10) {

        var url = $('#pills-home-tab').attr('data-url');

        $('#online-content').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

        $.ajax({
            type: "post",
            url: url,
            data: {
                'type': type,
                'status': status,
                'page': page,
                'perPage': perPage,
                '_token': $('input[name=_token]').val()
            },
            success: function (response) {

                if (response.success == 1) {
                    // Handle the successful response
                    $("#online-content").html(response.html);
                } else {

                    swal(
                        "Error!",
                        respons.message,
                        "success",
                    ).then(() => {
                        console.log(response);
                        window.location.href(response.redirect);

                    });
                }


            },
            error: function (xhr, status, error) {
                // Handle any errors
                console.error('AJAX Error: ' + status + ': ' + error);
            },
        })
    }
</script>



<script>
    function notes(uuid) {
        var uuid = uuid;

        var url = "<?php echo e(route('appointment.note')); ?>";

        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'uuid': uuid,
                '_token': $('input[name=_token]').val()
            },

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function (response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    if (response.note && response.note.trim() !== '') {
                        $("#appointmentNotesData").text(response.note);

                    } else {
                        $("#appointmentNotesData").text("No notes found!");

                    }
                }
            },
            error: function (xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function (key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
            },
        });

    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/appointments.blade.php ENDPATH**/ ?>