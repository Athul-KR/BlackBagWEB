<?php $__env->startSection('title', 'Find Doctors & Clinics'); ?>
<?php $__env->startSection('content'); ?>


<section class="banner-container">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="content_box">
                    <p>Join Our Global Network of Leading Clinics</p>
                    <h1>Partner With Us To Provide World-Class Care</h1>

                </div>
            </div>
            <div class="col-lg-5">
                <div class="content_box">
                    <p>Join a global network of clinics dedicated to enhancing patient care through cutting-edge
                        telemedicine technology. Expand your clinic’s reach, streamline operations, and connect with a
                        broader community of healthcare providers. </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="service_counter">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <img src="<?php echo e(asset('frontend/images/care_group.png')); ?>" class="img-fluid">
            </div>
            <div class="col-12">
                <div class="row text-center mt-5" id="counter-section">
                    <div class="col-md-4 col-12">
                        <div class="counter_box">
                            <h2 id="counter-section-clinic"><span class="count-digit" id="counter-clinic">0</span><span
                                    class="plus-sign">+</span></h2>
                            <p>Clinics Worldwide</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="counter_box">
                            <h2 id="counter-section"><span class="count-digit" id="counter">0</span><span
                                    class="plus-sign">+</span></h2>
                            <p>Trusted Patients</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-12">
                        <div class="support_box">
                            <h2>24/7</h2>
                            <p>Support</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="btn_alignbox mt-4">
                            <a onclick="registerUser()" class=" btn btn-primary" data-bs-toggle="modal"
                                data-bs-dismiss="modal">Join Us</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12">
                <div class="content_box mb-4">
                    <p>Why Join Us</p>
                    <h3>Why Partner with Us?</h3>
                    <p>Unlock new opportunities for growth, efficiency, and patient care</p>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="image-container">
                    <img src="<?php echo e(asset('frontend/images/patner_us.png')); ?>" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <ul class="flex-column joinus_list ps-lg-5">
                    <li>
                        <img src="<?php echo e(asset('frontend/images/reach.png')); ?>" class="img-fluid">
                        <div>
                            <h4 class="primary fwt-bold">Increase Patient Reach</h4>
                            <p>Expand your clinic's reach to a wider audience through our telemedicine platform.</p>
                        </div>
                    </li>
                    <li>
                        <img src=" <?php echo e(asset('frontend/images/strem_operations.png')); ?>" class="img-fluid">
                        <div>
                            <h4 class="primary fwt-bold">Streamlined Operations</h4>
                            <p>Manage appointments, patient records, and billing efficiently with our tools.</p>
                        </div>
                    </li>
                    <li>
                        <img src="<?php echo e(asset('frontend/images/technolgy.png')); ?>" class="img-fluid">
                        <div>
                            <h4 class="primary fwt-bold">Seamless Technology Integration</h4>
                            <p>Easy-to-use platform that integrates with your clinic’s existing systems.</p>
                        </div>
                    </li>
                    <li>
                        <img src="<?php echo e(asset('frontend/images/workflow.png')); ?>" class="img-fluid">
                        <div>
                            <h4 class="primary fwt-bold">Optimize Clinic’s Workflow</h4>
                            <p class="m-0">Streamline your clinic’s workflow with our intuitive scheduling system.</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</section>



<section>
    <div class="container">
        <div class="row align-items-center mb-4 parallax-scroll">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <p>Effortless Patient Connections</p>
                    <h3 class="pe-3">Reach Patients Anytime, Anywhere</h3>
                    <p class="my-3">BlackBag simplifies patient engagement, allowing clinics to connect with patients
                        through secure video calls and messaging. Provide seamless consultations, follow-ups, and
                        medical advice remotely, ensuring high-quality care without boundaries.</p>
                    <a onclick="registerUser()" class=" btn btn-primary" data-bs-toggle="modal"
                        data-bs-dismiss="modal">Join Now</a>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="<?php echo e(asset('frontend/images/reachanytime.png')); ?> " class="img-fluid">
                </div>
            </div>
        </div>
        <div class="row align-items-center mb-4 parallax-scroll">
            <div class="col-lg-6 col-12">
                <div class="image-container pe-lg-4">
                    <img src="<?php echo e(asset('frontend/images/sheduleappointment.png')); ?>" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="content_box mx-lg-5">
                    <p>Streamline Appointment Scheduling"</p>
                    <h3 class="pe-3">Manage your clinic’s schedule with ease</h3>
                    <p class="my-3">Efficiently manage doctor appointments with our user-friendly system. Schedule,
                        reschedule, and track patient consultations effortlessly, keeping your clinic organized while
                        ensuring no appointment is missed or delayed.</p>
                    <a onclick="registerUser()" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-dismiss="modal">Join Now</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="info_wrapper doctor-info position-relative overflow-hidden">
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="content_box">
                        <p>Protect Patient Data with Confidence</p>
                        <h3>Security and Privacy At The Core</h3>
                        <p class="my-3">Blackbag ensures that all patient information is stored and shared securely,
                            adhering to the highest standards of data protection. With encrypted communication and
                            privacy controls, both clinics and patients can trust that their sensitive health data
                            remains confidential.</p>
                        <a onclick="registerUser()" class="btn btn-outline-primary" data-bs-toggle="modal"
                            data-bs-dismiss="modal">Get Started</a>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="image-container position-absolute bottom-0 end-0">
                        <img src="<?php echo e(asset('frontend/images/pro_doc.png')); ?>" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<!-- Clinic Sign  Up Modal -->

<div class="modal login-modal fade" id="registerUser" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a onclick="$('#registerPatient').hide()" data-bs-dismiss="modal" aria-label="Close"><span
                        class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center" id="registerClinicForm">



            </div>
        </div>
    </div>
</div>



<!-- Clinics Details -->


<!-- <div class="modal login-modal fade" id="joinUs_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-center fw-medium mb-0 ">Enter Clinic Details</h4>
                <small class="gray">Provide your clinic's information to proceed.</small>

                <form>
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="form-group form-outline mb-3">
                                <label for="input">Clinic Name</label>
                                <i class="material-symbols-outlined">home_health</i>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group form-outline mb-3">
                                <label for="input">Email</label>
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="phonenum_group">
                                <div class="country_code">
                                    <select name="sort_filter" id="sort_filter" data-tabid="basic" class="form-select">
                                        <option value="all">+91</option>
                                        <option value="all">+211</option>
                                        <option value="all">+72</option>
                                    </select>
                                </div>
                                <div class="form-group form-outline mb-4 flex-grow-1">
                                    <label for="input" class="">Phone Number</label>
                                    <i class="material-symbols-outlined">call</i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">Address</label>
                                <i class="material-symbols-outlined">home</i>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">City</label>
                                <i class="material-symbols-outlined">location_city</i>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">State</label>
                                <i class="material-symbols-outlined">map</i>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">ZIP</label>
                                <i class="material-symbols-outlined">home_pin</i>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="btn_alignbox">
                                <a href="" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Next</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> -->

<!-- Clinics End -->




<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/for-clinics.blade.php ENDPATH**/ ?>