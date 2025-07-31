<?php $__env->startSection('title', 'Nurse List'); ?>
<?php $__env->startSection('content'); ?>


<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12 mb-3">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="<?php echo e(route('doctor.list')); ?>" class="primary">Doctors</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Doctor Details</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-8 col-12  mb-3">
                <div class="web-card h-100 mb-3 p-0 overflow-hidden">
                    <div class="profileData nurseData">
                        <div class="row align-items-end h-100 p-3">
                            <div class="col-lg-5 col-xl-3">
                                <div class="user_details text-center">
                                    <img src="<?php echo e(asset('images/nurse3.png')); ?>" class="img-fluid">
                                    <h5 class="fw-medium dark"><?php echo e($doctorDetails['name']); ?></h5>
                                    <p><?php echo e($doctorDetails['qualification']); ?></p>
                                </div>
                            </div>
                            <div class="col-lg-7 col-xl-9">
                                <div class="d-flex justify-content-center justify-content-lg-end">

                                    <div class="btn_alignbox">
                                        <a class="btn btn-outline">Email</a>

                                        <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                            <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Delete</a></li>
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
                            <p><?php echo e($doctorDetails['specialty']); ?></p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Designation</h6>


                            <p><?php echo e($designation); ?></p>


                        </div>
                        <!-- <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Phone Number</h6>
                            <p>(310) 926-7131</p>
                        </div> -->
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Status</h6>
                            <?php if($doctorDetails['status'] == 1): ?>
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
            <div class="col-xl-8 col-12 mb-xl-5 mb-3 order-1 order-xl-0">
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
                                        <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Online Appointments</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">In-person Appointments</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <div class="col-12 my-3">
                                            <div class="tab_box">
                                                <a href="" class="btn btn-tab active">Reception Room</a>
                                                <a href="" class="btn btn-tab">Upcoming</a>
                                                <a href="" class="btn btn-tab">Expired</a>
                                                <a href="" class="btn btn-tab">All</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 my-3">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-white text-start w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Room ID</th>
                                                            <th>Attending Nurse</th>
                                                            <th>Appointment Date & Time</th>
                                                            <th>Booked On</th>
                                                            <th class="text-end">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                     <?php if(!empty($appointmentDetails['data'])): ?>
                                                     <?php $__currentLoopData = $appointmentDetails['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>
                                                            <td>DOC-12122</td>
                                                            <td>
                                                                <div class="user_inner">
                                                                    <img src="<?php echo e(asset('images/patient3.png')); ?>">
                                                                    <div class="user_info">
                                                                        <a href="patientdetails.html">
                                                                            <h6 class="primary fw-medium m-0">Rudy Macane</h6>
                                                                            <p class="m-0">rudymc@gmail.com</p>
                                                                        </a>

                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>Jun 13 2024, 10:30 AM</td>
                                                            <td>Jun 07 2024, 03:34 AM</td>
                                                            <td class="text-end">
                                                                <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                                                    <a class="btn opt-btn border-0" href=""><img src="<?php echo e(asset('images/vediocam.png')); ?>"></a>
                                                                    <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="<?php echo e(asset('images/file_alt.png')); ?>"></a>
                                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span class="material-symbols-outlined">more_vert</span></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                     <?php endif; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                             <?php if(!empty($appointmentDetails['data'])): ?>
                                                <div class="col-md-6">
                                                <form method="GET" action="">
                                                    <div class="sort-sec">
                                                        <p class="me-2 mb-0">Displaying per page :</p>
                                                        <select class="form-select" aria-label="Default select example" name="limit" onchange="this.form.submit()">
                                                            <option selected="">10</option>
                                                            <option value="1">9</option>
                                                            <option value="2">8</option>
                                                        </select>
                                                    </div>
                                                    <form>
                                                </div>
                                                <?php endif; ?>
                                                <div class="col-md-6">
                                                        <?php echo e($appointmentData->links()); ?>

                                                
                                                   
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="col-12 my-3">
                                            <div class="tab_box">

                                                <a href="" class="btn btn-tab active">Upcoming</a>
                                                <a href="" class="btn btn-tab">Expired</a>
                                                <a href="" class="btn btn-tab">All</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 my-3">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-white text-start w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Patient</th>
                                                            <th>Age</th>
                                                            <th>Appointment Date & Time</th>
                                                            <th>Booked On</th>
                                                            <th class="text-end">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>



                                                            <td>
                                                                <div class="user_inner">
                                                                    <img src="<?php echo e(asset('images/johon_doe.png')); ?>">
                                                                    <div class="user_info">
                                                                        <a href="patientdetails.html">
                                                                            <h6 class="primary fw-medium m-0">John Doe</h6>
                                                                            <p class="m-0">johndoe@gmail.com</p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>32</td>
                                                            <td>Jun 13 2024, 10:30 AM</td>
                                                            <td>Jun 07 2024, 03:34 AM</td>
                                                            <td class="text-end">
                                                                <div class="d-flex align-items-center justify-content-end btn_alignbox">

                                                                    <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="<?php echo e(asset('images/file_alt.png')); ?>"></a>
                                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span class="material-symbols-outlined">more_vert</span></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>


                                                            <td>
                                                                <div class="user_inner">
                                                                    <img src="<?php echo e(asset('images/patient2.png')); ?>">
                                                                    <div class="user_info">
                                                                        <a href="patientdetails.html">
                                                                            <h6 class="primary fw-medium m-0">Justin Taylor</h6>
                                                                            <p class="m-0">justintay@gmail.com</p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>41</td>
                                                            <td>Jun 13 2024, 11:30 PM</td>
                                                            <td>Jun 05 2024, 11:12 PM</td>
                                                            <td class="text-end">
                                                                <div class="d-flex align-items-center justify-content-end btn_alignbox">

                                                                    <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="<?php echo e(asset('images/file_alt.png')); ?>"></a>
                                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span class="material-symbols-outlined">more_vert</span></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="sort-sec">
                                                        <p class="me-2 mb-0">Displaying per page :</p>
                                                        <select class="form-select" aria-label="Default select example">
                                                            <option selected="">10</option>
                                                            <option value="1">9</option>
                                                            <option value="2">8</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination">
                                                            <li class="page-item">
                                                                <a class="page-link" href="#" aria-label="Previous">
                                                                    <i class="fa-solid fa-angle-left"></i>
                                                                    Previous
                                                                </a>
                                                            </li>
                                                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                            <li class="page-item">
                                                                <a class="page-link" href="#" aria-label="Next">
                                                                    Next
                                                                    <i class="fa-solid fa-angle-right"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
        </div>
    </div>
    </div>
</section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/doctors/details.blade.php ENDPATH**/ ?>