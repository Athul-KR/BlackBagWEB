<?php $__env->startSection('title', 'Nurse List'); ?>
<?php $__env->startSection('content'); ?>


<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12 mb-3">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('nurse.list')); ?>" class="primary">Nurses</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nurse Details</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-8 col-12  mb-3">
                <div class="web-card h-100 mb-3 overflow-hidden">
                    <div class="profileData nurseData">
                        <div class="row align-items-end h-100 p-3">
                            <div class="col-lg-5 col-xl-3">
                                <div class="user_details text-start">
                                    <img src="<?php echo e(asset($nurse['logo_path'])); ?>" class="img-fluid">
                                    <h5 class="fw-medium dark"><?php echo e($nurse->name); ?></h5>
                                    <p><?php echo e($nurse->qualification); ?></p>
                                </div>
                            </div>
                            <div class="col-lg-7 col-xl-9">
                                <div class="d-flex justify-content-center justify-content-lg-end">

                                    <div class="btn_alignbox">
                                        <a href="<?php echo e('mailto:'. $nurse['email']); ?>" class="btn btn-outline d-flex align-items-center justify-content-center gap-2"><span class="material-symbols-outlined"> mail </span>Email</a>

                                        <a class="btn opt-btn"  data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end mt-1">
                                            <li>
                                                <a  id="edit-nurse" data-nurseurl="<?php echo e(route('nurse.edit',[$nurse->clinic_user_uuid,'type'=>'active'])); ?>" data-bs-toggle="modal"
                                                    data-bs-dismiss="modal" data-bs-target="#addNurse" class=" edit-nurse dropdown-item fw-medium ">
                                                    <i class="fa-solid fa-pen me-2"></i>
                                                    Edit Details
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" id="delete-nurse" data-nurseurl="<?php echo e(route('nurse.delete',[$nurse->clinic_user_uuid,'type'=>'active'])); ?>" class="detete-nurse dropdown-item fw-medium">
                                                    <i class=" fa-solid fa-trash-can me-2"></i>
                                                    Delete Nurse
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="detailsList cardList">
                        <h5 class="fw-medium">Details</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Specialities</h6>
                            <p><?php echo e(optional($nurse->doctorSpecialty)->specialty_name ?? 'N/A'); ?></p>

                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Designation</h6>


                            <p><?php echo e($nurse->department); ?></p>


                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Phone Number</h6>
                            <p><?php echo e($countryCode->country_code. '    '. $nurse->phone_number); ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Status</h6>
                            <?php if($nurse->status == 1): ?>
                            <div class="avilable-icon">
                                <span></span>Available
                            </div>
                            <?php else: ?>
                            <div class="notavilable-icon">
                                <span></span>Not Available
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-xl-5 mb-3 order-1 order-xl-0">
                <div class="web-card h-100">
                    <div class="row align-items-center">
                        <div class="col-sm-8 text-center text-sm-start">
                            <h4 class="mb-md-0">Appointment Records</h4>
                        </div>
                        <div class="col-sm-4 text-center text-sm-end">
                            <!-- <a href="" class="btn btn-primary">Create Appointment</a> -->
                        </div>


                        <div class="col-lg-12 my-3">
                            <div class="col-12">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php echo e(session()->get('type')=='online' || $type=='online' ? 'active': ''); ?>" id="pills-home-tab" onclick="online('online','upcoming')" data-url="<?php echo e(route('nurse.appointmentList',[$nurse->clinic_user_uuid])); ?>" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Online Appointments</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?php echo e(session()->get('type')=='offline' || $type=='offline' ? 'active': ''); ?>" id="pills-profile-tab" onclick="online('offline','upcoming')" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">In-person Appointments</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div id="table-online">




                                    </div>



                                    <div id="table-offline">



                                    </div>



                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <?php
            
           /* 
            <div class="col-xl-4 col-12 mb-xl-5 mb-3 order-0 order-xl-1">
                <div class="web-card h-100 ">
                    <div class="detailsList cardList">

                        <h5 class="fw-medium">Availability</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Sunday</h6>
                            <p>Not Available</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Monday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Tuesday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Wednesday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Thursday</h6>
                            <p>Not Available</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Friday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Saturday</h6>
                            <p>Not Available</p>
                        </div>
                    </div>
                </div>
            </div>
            */
            ?>


        </div>
    </div>
    <!-- </div> -->
</section>



<!-- Nurse Create and Edit Modal -->
<div class="modal login-modal fade" id="addNurse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <!-- <a href="#" class="close-modal" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
            </div>
            <div id="add-nurse-modal" class="modal-body text-center">

                <!-- Appends Blade to this section -->

            </div>
        </div>
    </div>
</div>


<!-- Appointment Edit Modal -->

<div class="modal login-modal fade" id="editAppointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-center fw-medium mb-0">Edit Appointment</h4>
                <small class="gray">Please enter patient details and create an appointment.</small>
                <div id="appointment_edit_modal">

                    <!-- Include the Modal Form here -->

                </div>
            </div>
        </div>
    </div>
</div>




<script>
    var loaderGifUrl = "<?php echo e(asset('images/loader.gif')); ?>";
</script>
<!-- Edit Nurse -->
<script src="<?php echo e(asset('js/nurseEdit.js')); ?>"></script>
<!-- Nurse Delete -->
<script src="<?php echo e(asset('js/nurseDeleteActivate.js')); ?>"></script>
<script>
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

    //Pagination through ajax - pass the url
    $(document).on('click', '.pagination a', function(e) {
        var type = $('#online_type').val();
        var status = $('#online_status').val();
        e.preventDefault();

        const pageUrl = $(this).attr('href');
        const urlObj = new URL(pageUrl); // Create a URL object
        var page = urlObj.searchParams.get('page');

        online(type, status, page);

    });


    //Function to show the appointments, online and offline in view page
    function online(type, status, page = 1) {

        var url = $('#pills-home-tab').attr('data-url');
        console.log(type);
        console.log(status);
        console.log(url);
        $('#table-offline').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');
        $.ajax({
            type: "get",
            url: url,
            data: {
                "type": type,
                'status': status,
                'page': page

            },
            success: function(response) {
                // Handle the successful response
                $("#table-offline").html(response.html);

            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.error('AJAX Error: ' + status + ': ' + error);
            },
        })
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/nurses/view.blade.php ENDPATH**/ ?>