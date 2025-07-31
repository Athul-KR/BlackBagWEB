<?php $__env->startSection('title', 'Nurse List'); ?>
<?php $__env->startSection('content'); ?>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="web-card h-100 mb-3">
                            <div class="row">
                                <div class="col-sm-5 text-center text-sm-start">
                                    <h4 class="mb-md-0">Nurses</h4>
                                </div>
                                <div class="col-sm-7 text-center text-sm-end">
                                    <div class="btn_alignbox justify-content-sm-end">
                                        <a href="#" id="nurse-create" class="btn btn-primary btn-align "
                                            data-bs-toggle="modal" data-nurse-create-url="<?php echo e(route('nurse.create')); ?>"
                                            data-bs-dismiss="modal" data-bs-target="#addNurse">
                                            <span class="material-symbols-outlined">add </span>
                                            Add Nurse
                                        </a>
                                        <div class="dropdown">
                                            <a class="btn filter-btn" href="#" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="material-symbols-outlined">filter_list</span>
                                                Filters
                                            </a>
                                            <ul class="dropdown-menu filter_menu" aria-labelledby="dropdownMenuButton1">
                                                <li class=""><a
                                                        class="dropdown-item" aria-current="true" id="filter-avlble"
                                                        href="<?php echo e(route('nurse.lists', ['status' => $status,'type'=>'available'])); ?>">Available</a>
                                                </li>
                                                <li class=""><a
                                                        class="dropdown-item" id="filter-notavlble"
                                                        href="<?php echo e(route('nurse.lists', ['status' => $status,'type'=>'not-available'])); ?>">Not
                                                        Available</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="tab_box">

                                        <a href="<?php echo e(route('nurse.lists', ['status' => 'pending','type'=>$type])); ?>"
                                            class="btn btn-tab <?php echo e($status == 'pending' ? 'active' : ''); ?>">
                                            Pending (<?php echo e($pendingCount); ?>)
                                        </a>

                                        <a href="<?php echo e(route('nurse.lists', ['status' => 'active','type'=>$type])); ?>"
                                            class="btn btn-tab <?php echo e($status == 'active' || $status == null ? 'active' : ''); ?>">
                                            Active (<?php echo e($activeCount); ?>)
                                        </a>

                                        <a href="<?php echo e(route('nurse.lists', ['status' => 'inactive','type'=>$type])); ?>"
                                            class="btn btn-tab <?php echo e($status == 'inactive' ? 'active' : ''); ?>">
                                            Inactive (<?php echo e($inactiveCount); ?>)
                                        </a>

                                    </div>
                                </div>



                                <div class="col-12 mb-3 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-white text-start w-100">
                                            <thead>
                                                <tr>
                                                    <th>Nurses</th>
                                                    <th>Specialty</th>
                                                    <th>Qualification</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
<!--                                                    <th>Created By</th>-->
                                                    <!-- <th>Created On</th> -->
                                                    <th class="text-end">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <?php $__empty_1 = true; $__currentLoopData = $nurses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nurse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>


                                                <?php

                                                $corefunctions = new \App\customclasses\Corefunctions;

                                                $nurse['logo_path'] = ($nurse['logo_path'] != '') ? $corefunctions->getAWSFilePath($nurse['logo_path']) : asset('/images/default_img.png');

                                                ?>


                                                <tr>

                                                    <td>

                                                        <div class="user_inner">
                                                            <!-- <img src="<?php echo e(asset('images/nurse1.png')); ?>"> -->
                                                            <img src="<?php echo e(asset($nurse['logo_path'])); ?>">

                                                            <div class="user_info">
                                                                <a <?php if($status !=='inactive' ): ?>
                                                                    href="<?php echo e(route('nurse.view', [$nurse->clinic_user_uuid,'type'=>'online'])); ?>">
                                                                    <?php endif; ?>
                                                                    <h6 class="primary fw-medium m-0">
                                                                        <?php echo e($nurse->name ?? 'N/A'); ?>

                                                                    </h6>
                                                                    <p class="m-0"><?php echo e($nurse->email ?? 'N/A'); ?></p>
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?php echo e(optional($nurse->doctorSpecialty)->specialty_name ?? 'N/A'); ?></td>
                                                    <td><?php echo e($nurse->qualification ?? 'N/A'); ?></td>
                                                    <td><?php echo e($nurse->department ?? 'N/A'); ?></td>
                                                    <td>
                                                        <?php if($nurse->status == -1): ?>
                                                        <div class="pending-icon">
                                                            <span></span>Pending
                                                        </div>
                                                        <?php elseif($nurse->status == 0): ?>
                                                        <div class="decline-icon">
                                                            <span></span>Declined
                                                        </div>
                                                        <?php else: ?>

                                                        <?php if($nurse->login_status == 1): ?>
                                                        <div class="avilable-icon">
                                                            <span></span>Available
                                                        </div>
                                                        <?php else: ?>
                                                        <div class="notavilable-icon">
                                                            <span></span>Not Available
                                                        </div>
                                                        <?php endif; ?>
                                                        <?php endif; ?>

                                                    </td>
<!--
                                                    <td><?php echo e($nurse->creator->first_name . ' ' . $nurse->creator->last_name ?? 'N/A'); ?>

                                                        <p>
                                                            <?php echo e($nurse->created_at ?? 'N/A'); ?>

                                                        </p>
                                                    </td>
-->
                                                    <!-- <td></td> -->

                                                    <!-- Gear Icon -->
                                                    <td class="text-end">
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <span class="material-symbols-outlined">more_vert</span>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">

                                                                <?php if($status == 'active' || $status == 'pending'): ?>

                                                                <li>
                                                                    <a href="#" id="edit-nurse"
                                                                        data-nurseurl="<?php echo e(route('nurse.edit', [$nurse->clinic_user_uuid, 'type' => $status])); ?>"
                                                                        data-bs-toggle="modal" data-bs-dismiss="modal"
                                                                        data-bs-target="#addNurse"
                                                                        class=" edit-nurse dropdown-item fw-medium ">
                                                                        <i class="fa-solid fa-pen me-2"></i>
                                                                        Edit Details
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" id="delete-nurse"
                                                                        data-nurseurl="<?php echo e(route('nurse.delete', [$nurse->clinic_user_uuid])); ?>"
                                                                        class="detete-nurse dropdown-item fw-medium">
                                                                        <i class=" fa-solid fa-trash-can me-2"></i>
                                                                        Delete Nurse
                                                                    </a>
                                                                </li>
                                                                <?php if($status == 'pending'): ?>
                                                                <li>
                                                                    <a href="#" id="resendInvite-nurse"
                                                                        data-nurseurl="<?php echo e(route('nurse.resendInvitation', [$nurse->clinic_user_uuid])); ?>"
                                                                        class="resendInvite-nurse dropdown-item fw-medium">
                                                                        <i class=" fa-solid fa-paper-plane  me-2"></i>
                                                                        Resend Invitation
                                                                    </a>
                                                                </li>
                                                                <?php endif; ?>

                                                                <?php else: ?>
                                                                <li>
                                                                    <a href="#" id="activate-nurse"
                                                                        data-nurseurl="<?php echo e(route('nurse.activate', [$nurse->clinic_user_uuid])); ?>"
                                                                        class="activate-nurse dropdown-item fw-medium">
                                                                        <i class="fa-solid fa-check primary me-2"></i>
                                                                        Activate Nurse
                                                                    </a>
                                                                </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    <!-- End Gear Icon -->

                                                </tr>

                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <!-- No Data Found -->
                                                <tr class="text-center">
                                                    <td colspan="8">
                                                        <div class="flex justify-center">
                                                            <div class="text-center no-records-body">
                                                                <img src="<?php echo e(asset('images/nodata.png')); ?>"
                                                                    class=" h-auto">
                                                                <p>No Nurses Yet</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- End of No Data Found -->
                                                <?php endif; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="col-12">
                                    <div class="row">
                                        <?php if($nurses->isNotEmpty()): ?>
                                        <div class="col-md-6">

                                            <form method="GET" action="<?php echo e(route('nurse.lists', [$status])); ?>">
                                                <div class="sort-sec">
                                                    <p class="me-2 mb-0">Displaying per page :</p>
                                                    <select name="perPage" id="perPage"
                                                        class="form-select d-inline-block"
                                                        aria-label="Default select example"
                                                        onchange="this.form.submit()">
                                                        <option value="10" <?php echo e($perPage == 10 ? 'selected' : ''); ?>>10
                                                        </option>
                                                        <option value="15" <?php echo e($perPage == 15 ? 'selected' : ''); ?>>15
                                                        </option>
                                                        <option value="20" <?php echo e($perPage == 20 ? 'selected' : ''); ?>>20
                                                        </option>
                                                    </select>
                                                </div>
                                            </form>

                                        </div>
                                        <?php endif; ?>
                                        <div class="col-md-6">
                                            <?php echo e($nurses->links('pagination::bootstrap-5')); ?>

                                        </div>
                                    </div>
                                </div>
                                <!-- Pagination End -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- Nurse Create and Edit Modal -->
<div class="modal login-modal fade" id="addNurse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">

            </div>
            <div id="add-nurse-modal" class="modal-body text-center">

                <!-- Appends Blade to this section -->

            </div>
        </div>
    </div>
</div>

<!-- Import Nurse Modal -->
<div class="modal login-modal fade" id="import_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
            </div>
            <div id="import-nurse-modal" class="modal-body">

                <!-- Appends Blade to this section -->

            </div>
        </div>
    </div>
</div>


<!-- Import Preview Modal -->
<div class="modal login-modal fade" id="import_preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
            </div>
            <div class="modal-body" id="import_preview_modal"></div>
        </div>
    </div>
</div>


<script>
    var loaderGifUrl = "<?php echo e(asset('images/loader.gif')); ?>";
</script>
<!-- Creating Nurse -->
<script src="<?php echo e(asset('js/nurseCreate.js')); ?>"></script>
<!-- Edit Nurse -->
<script src="<?php echo e(asset('js/nurseEdit.js')); ?>"></script>
<!-- Activate and Deactivate Nurse -->
<script src="<?php echo e(asset('js/nurseDeleteActivate.js')); ?>"></script>
<script>
    //Import Nurse
    $(document).on("click", "#nurse-import", function() {
        var url = $("#nurse-import").attr("data-nurse-import-url");

        $("#import-nurse-modal").html(
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

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    $("#import-nurse-modal").html(response.view);
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


        $('#import_preview').on('hidden.bs.modal', function() {
            $('#import_preview_modal').empty(); // Clear the modal content
        });
        $('#import_data').on('hidden.bs.modal', function() {
            $('#import-nurse-modal').empty(); // Clear the modal content
        });

    });

    $(document).ready(function() {

        var status = "<?php echo e(($status)); ?>";
        var type = "<?php echo e(($type)); ?>";
        console.log(status + type);

        if (status && type) {
            online(type, status);

        } else {
            online('online', 'upcoming');
        }

    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/nurses/listing.blade.php ENDPATH**/ ?>