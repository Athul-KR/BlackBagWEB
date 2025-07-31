<div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <div class="col-12 my-3">
        <div class="tab_box">

            <button onclick="online('offline','upcoming')" class="btn btn-tab <?php echo e($type == 'offline' && $status == 'upcoming' ? 'active' : ''); ?>">Upcoming</button>
            <button onclick="online('offline','expired')" class="btn btn-tab <?php echo e($type == 'offline' && $status == 'expired' ? 'active' : ''); ?>" data-url="<?php echo e(route('appointment.appointmentList',['type'=>'offline','status'=>'expired'])); ?>">Expired</button>
            <button onclick="online('offline','cancelled')" class="btn btn-tab <?php echo e($type == 'offline' && $status == 'cancelled' ? 'active' : ''); ?>" data-url="<?php echo e(route('appointment.appointmentList',['type'=>'offline','status'=>'cancelled'])); ?>">Cancelled</button>
            <button onclick="online('offline','all')" class="btn btn-tab <?php echo e($type == 'offline' && $status == 'all' ? 'active' : ''); ?>">All</button>
            <input type="hidden" id="online_status" value="<?php echo e($status); ?>">
            <input type="hidden" id="online_type" value="<?php echo e($type); ?>">
        </div>
    </div>
    <div class="col-lg-12 my-3">
        <div class="table-responsive">
            <table class="table table-hover table-white text-start w-100">
                <thead>
                    <tr>

                        <th>Patient</th>
                        <th>Consutling Doctor</th>
                        <th>Appointment Date & Time</th>
                        <th>Booked On</th>

                        <?php if($status=='all'): ?>
                        <th>Tags</th>
                        <?php endif; ?>


                        <th class="text-end">Actions</th>

                    </tr>
                </thead>
                <tbody>

                    <?php $__currentLoopData = $appointmentsOffline; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>

                        <td>
                            <div class="user_inner">
                                <!-- <img src="<?php echo e(asset('images/patient3.png')); ?>"> -->
                                <div class="user_info">
                                    <a>
                                        <h6 class="primary fw-medium m-0"><?php echo e($appointment->patient->name ?? 'N/A'); ?></h6>
                                        <p class="m-0"><?php echo e($appointment->patient->email ?? 'N/A'); ?></p>
                                    </a>

                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="user_inner">
                                <!-- <img src="<?php echo e(asset('images/nurse5.png')); ?>"> -->
                                <div class="user_info">
                                    <a href="#">
                                        <h6 class="primary fw-medium m-0"><?php echo e($appointment->consultant->name ?? 'N/A'); ?></h6>
                                        <p class="m-0"><?php echo e($appointment->consultant->email ?? 'N/A'); ?></p>
                                    </a>
                                </div>
                            </div>
                        </td>

                        <td><?php echo e(\Carbon\Carbon::parse($appointment->appointment_date)->format('m/d/Y')); ?><?php echo e(', '); ?><?php echo e(\Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($appointment->created_at)->format('m/d/Y')); ?><?php echo e(', '); ?><?php echo e(\Carbon\Carbon::parse($appointment->created_at)->format('h:i A')); ?></td>

                        <?php if($status=='all'): ?>
                        <td>
                            <?php if($appointment->appointment_date > now()->toDateString() && $appointment->deleted_at == null ||
                            ($appointment->appointment_date == now()->toDateString() && $appointment->appointment_time > now()->format('H:i')) && $appointment->deleted_at == null): ?>
                            <div class="pending-icon">
                                <span></span>Upcoming
                            </div>
                            <?php elseif($appointment->deleted_at !==null): ?>
                            <div class="decline-icon">
                                <span></span>Cancelled
                            </div>
                            <?php else: ?>
                            <div class="decline-icon">
                                <span></span>Expired
                            </div>
                            <?php endif; ?>
                        </td>
                        <?php endif; ?>

                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                <a class="btn opt-btn border-0" href="" data-bs-toggle="tooltip" title="Start Video Call"><img src="<?php echo e(asset('images/vediocam.png')); ?>"></a>
                                <a class="btn opt-btn border-0" onclick="notes('<?php echo e($appointment->appointment_uuid); ?>')" data-bs-toggle="modal" data-bs-target="#appointmentNotes" data-bs-dismiss="modal" data-bs-target="#appointmentNotes" data-bs-toggle="tooltip" title="Notes"><img src="<?php echo e(asset('images/file_alt.png')); ?>"></a>
                                <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">

                                    <?php if($status === 'upcoming' || $status === 'expired' || ($status === 'all' && $appointment->deleted_at === null)): ?>
                                    <li>
                                        <a id="edit-appointment" onclick="editAppointment('<?php echo e(route('appointment.edit', [$appointment->appointment_uuid,'type'=>$type,'status'=>$status])); ?>')" data-appointurl="<?php echo e(route('appointment.edit', [$appointment->appointment_uuid])); ?>" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editAppointment" class="dropdown-item fw-medium">
                                            <i class="fa-solid fa-pen me-2"></i>
                                            Edit Details
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                    <?php if($status === 'upcoming' || $status === 'expired' || $status === 'all' && $appointment->deleted_at == null): ?>
                                    <li>
                                        <a data-appointmenturl="<?php echo e(route('appointment.delete', [$appointment->appointment_uuid,'type'=>$type,'status'=>$status])); ?>" class="delete-appt dropdown-item fw-medium">
                                            <i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                    <?php if($status === 'cancelled' || ($status === 'all' && $appointment->deleted_at !== null)): ?>
                                    <li>
                                        <a data-appointmenturl="<?php echo e(route('appointment.activate', [$appointment->appointment_uuid,'type'=>$type,'status'=>$status])); ?>" class="activate-appt dropdown-item fw-medium">
                                            <i class="fa-solid fa-check primary me-2"></i>Activate Appointment
                                        </a>
                                    </li>
                                    <?php endif; ?>

                                </ul>
                            </div>
                        </td>

                    </tr>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php if($appointmentsOffline->isEmpty()): ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="flex justify-center">
                                <div class="text-center no-records-body">
                                    <img src="<?php echo e(asset('images/nodata.png')); ?>"
                                        class=" h-auto">
                                    <p>No Appointments Yet</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <?php if($appointmentsOffline->isNotEmpty()): ?>
            <div class="col-md-6">
                <div class="sort-sec">
                    <p class="me-2 mb-0">Displaying per page :</p>
                    <select name="perPage" id="perPage" class="form-select d-inline-block" aria-label="Default select example" onchange="perPage()">
                        <option value="10" <?php echo e($perPage == 10 ? 'selected' : ''); ?>>10</option>
                        <option value="15" <?php echo e($perPage == 15 ? 'selected' : ''); ?>>15</option>
                        <option value="20" <?php echo e($perPage == 20 ? 'selected' : ''); ?>>20</option>
                    </select>
                </div>
            </div>
            <?php endif; ?>
            <div class="col-md-6">
                <?php echo e($appointmentsOffline->links('pagination::bootstrap-5')); ?>


            </div>
        </div>
    </div>
</div>

<!-- Notes Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <h5 class="modal-title" id="appointmentNotesLabel">Appointment Notes</h5>
            </div>
            <div class="modal-body">
                <p id="appointmentNotesData">

                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<script src="<?php echo e(asset('js/appointmentDeleteActivate.js')); ?>"></script>
<script>
    //Note
    function notes(uuid) {
        var uuid = uuid;

        var url = "<?php echo e(route('appointment.note')); ?>";

        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'uuid': uuid,
            },

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    if (response.note !== '') {
                        $("#appointmentNotesData").text(response.note);

                    } else {
                        $("#appointmentNotesData").text("No notes found!");

                    }
                }
            },
            error: function(xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
            },
        });

    }





    function editAppointment(url) {

        // $(document).on("click", "edit-appointment", function() {

        console.log(url);

        $('#appointment_edit_modal').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

        $.ajax({
            type: "GET",
            url: url,

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    $("#appointment_edit_modal").html(response.view);
                }
            },
            error: function(xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
            },
        });
        // });

    }
</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/appointment/offline-appointments.blade.php ENDPATH**/ ?>