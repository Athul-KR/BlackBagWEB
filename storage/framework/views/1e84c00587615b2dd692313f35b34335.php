<?php $__env->startSection('title', 'Medical History'); ?>
<?php $__env->startSection('content'); ?>


<section class="details_wrapper">

    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <nav class="mb-0" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="#" class="primary">Patient Records</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Patient Details</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row h-100">
            <div class="col-xl-8 col-12 mb-3">
                <div class="web-card h-100">
                    <div class="profileData d-flex flex-md-row flex-column justify-content-between align-items-md-end align-items-md-start h-100">
                        <div class="user_details text-start">
                            <img src="<?php echo e(asset('frontend/images/drclark.png')); ?>" class="img-fluid">
                            <h5 class="fwt-bold dark">Dr Jack Clark</h5>
                            <p>jackclark@gmail.com</p>
                        </div>
                        <div class="d-flex align-items-end justify-content-start justify-content-xl-end">
                            <div class="btn_alignbox flex-sm-row flex-column align-items-sm-end align-items-start">
                                <a class="btn btn-outline d-flex align-items-center gap-1"><span class="material-symbols-outlined">ecg_heart </span>General Practitioner (GP)</a>
                                <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#bookAppointment">Book Appointment</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="detailsList cardList">
                        <h5 class="fwt-bold">Details</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="fwt-bold">Specialities</h6>
                            <p>Lifestyle Medicine, Preventive Care </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fwt-bold">Qualifications</h6>
                            <p>MD,DO, MBBS</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fwt-bold">Phone Number</h6>
                            <p>(310) 926-7131(310) 926-7131</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fwt-bold">Address</h6>
                            <p>TC 20/916, Karamana, Trivandrum, Kerala, 691 738 </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-1">
                            <span class="material-symbols-outlined text-decoration-none">distance</span><a href="" class="fwt-bold primary text-decoration-underline" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#directionModal">Get Directions</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-xl-5 mb-3 order-1 order-xl-0">
                <div class="web-card h-100">
                    <div class="col-12">
                        <ul class="nav nav-pills flex-row w-100 mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="true">Abouts</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-gallery-tab" data-bs-toggle="pill" data-bs-target="#pills-gallery" type="button" role="tab" aria-controls="pills-gallery" aria-selected="false">Gallery</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="fwt-bold mb-0">About</h5>
                                        </div>
                                        <p>I am a dedicated and compassionate family physician with over 9 years of experience in providing comprehensive healthcare. My approach is patient-centered, focusing on both the physical and emotional well-being of those I treat. I believe in the power of informed decision-making and work closely with my patients to develop personalized treatment plans that align with their individual needs and lifestyles.</p>

                                    </div>
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5 class="fwt-bold">Treatment</h5>
                                                <ul class="list_items p-0 mb-0 mt-2">
                                                    <li><i class="fa-solid fa-check"></i>Hypertension Management</li>
                                                    <li><i class="fa-solid fa-check"></i>Diabetes Care</li>
                                                    <li><i class="fa-solid fa-check"></i>Respiratory Infections</li>
                                                    <li><i class="fa-solid fa-check"></i>Joint and Musculoskeletal Pain</li>
                                                    <li><i class="fa-solid fa-check"></i>Skin Conditions</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <h5 class="fwt-bold my-md-0 my-3">Services</h5>
                                                <ul class="list_items p-0 mb-0 mt-2">
                                                    <li><i class="fa-solid fa-check"></i>Annual Physical Exams</li>
                                                    <li><i class="fa-solid fa-check"></i>Emergency Care</li>
                                                    <li><i class="fa-solid fa-check"></i>Preventive Care and Screenings</li>
                                                    <li><i class="fa-solid fa-check"></i>Chronic Disease Management</li>
                                                    <li><i class="fa-solid fa-check"></i>Pediatric Care</li>
                                                    <li><i class="fa-solid fa-check"></i>Women’s Health Services</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fwt-bold mb-0">Gallery</h5>

                                </div>

                                <div class="gallery_wrapper">
                                    <div class="row">
                                        <div class="col-xxl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/gall1.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="<?php echo e(asset('frontend/images/gall1.png')); ?>">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/gall2.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="<?php echo e(asset('frontend/images/gall2.png')); ?>">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/gall3.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="<?php echo e(asset('frontend/images/gall3.png')); ?>">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xxl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/gall4.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="<?php echo e(asset('frontend/images/gall4.png')); ?>">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </div>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-reviews" role="tabpanel" aria-labelledby="pills-reviews-tab">
                                <div class="d-flex justify-content-between align-items-center border-bottom-light pb-3">
                                    <h5 class="fwt-bold mb-0">Reviews</h5>
                                    <div class="btn_alignbox">
                                        <div class="form-group filter_Box">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                            <select name="sort_filter" id="sort_filter" data-tabid="basic" class="form-select">
                                                <option value="all">Most Relevant</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-2 col-12">
                                        <div class="review_box">
                                            <p>Total Reviews</p>
                                            <h3>55</h3>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-12">
                                        <div class="review_box middle_Box">
                                            <p>Average Ratings</p>
                                            <div class="rating-body">
                                                <h3>3.2</h3>
                                                <div class="rating">
                                                    <input value="5" name="rating" id="star5" type="radio">
                                                    <label for="star5"></label>
                                                    <input value="4" name="rating" id="star4" type="radio">
                                                    <label for="star4"></label>
                                                    <input value="3" name="rating" id="star3" type="radio">
                                                    <label for="star3"></label>
                                                    <input value="2" name="rating" id="star2" type="radio">
                                                    <label for="star2"></label>
                                                    <input value="1" name="rating" id="star1" type="radio">
                                                    <label for="star1"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-12">
                                        <ul class="flex-column ps-lg-4 ps-0">
                                            <li>
                                                <div class="rating gap-1 align-items-center">
                                                    <input value="1" name="rating" id="star1" type="radio">
                                                    <label for="star1"></label>
                                                    <p class="m-0">5</p>
                                                </div>
                                                <div class="progress" style="width: 100%;">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100%"></div>
                                                </div>
                                                <p class="m-0">34</p>
                                            </li>
                                            <li>
                                                <div class="rating gap-1 align-items-center">
                                                    <input value="1" name="rating" id="star1" type="radio">
                                                    <label for="star1"></label>
                                                    <p class="m-0">4</p>
                                                </div>
                                                <div class="progress" style="width: 75%;">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100%"></div>
                                                </div>
                                                <p class="m-0">9</p>
                                            </li>
                                            <li>
                                                <div class="rating gap-1 align-items-center">
                                                    <input value="1" name="rating" id="star1" type="radio">
                                                    <label for="star1"></label>
                                                    <p class="m-0">3</p>
                                                </div>
                                                <div class="progress" style="width: 55%;">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100%"></div>
                                                </div>
                                                <p class="m-0">6</p>
                                            </li>
                                            <li>
                                                <div class="rating gap-1 align-items-center">
                                                    <input value="1" name="rating" id="star1" type="radio">
                                                    <label for="star1"></label>
                                                    <p class="m-0">2</p>
                                                </div>
                                                <div class="progress" style="width: 5%;">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100%"></div>
                                                </div>
                                                <p class="m-0">2</p>
                                            </li>
                                            <li>
                                                <div class="rating gap-1 align-items-center">
                                                    <input value="1" name="rating" id="star1" type="radio">
                                                    <label for="star1"></label>
                                                    <p class="m-0">1</p>
                                                </div>
                                                <div class="progress" style="width: 10%;">
                                                    <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100%"></div>
                                                </div>
                                                <p class="m-0">4</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-12 mt-4">
                                        <div class="row comments_wrapper"> 
                                            <div class="col-xl-10 col-md-9 col-12"> 
                                                <div class="d-flex gap-sm-3 gap-2">
                                                    <img class="pfl-img" src="<?php echo e(asset('frontend/images/john_doe.png')); ?>">
                                                    <div class="form-group form-outline form-textarea flex-grow-1 mx-2">

                                                        <textarea class="form-control" id="exampleFormControlInput1" rows="4" cols="4" placeholder="Write your reply to this comment"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-3 col-12 d-flex justify-content-end"> 
                                                <div class="d-flex flex-column gap-2 mt-md-0 mt-3">
                                                    <p class="m-0 gray fw-bold">Rate this doctor</p>
                                                    <div class="rating-body">
                                                        <div class="rating w-100">
                                                            <input value="5" name="rating" id="star5" type="radio">
                                                            <label for="star5"></label>
                                                            <input value="4" name="rating" id="star4" type="radio">
                                                            <label for="star4"></label>
                                                            <input value="3" name="rating" id="star3" type="radio">
                                                            <label for="star3"></label>
                                                            <input value="2" name="rating" id="star2" type="radio">
                                                            <label for="star2"></label>
                                                            <input value="1" name="rating" id="star1" type="radio">
                                                            <label for="star1"></label>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-secondary w-100">Submit</a>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>
                                </div>

                                <div class="comment_box">
                                    <div class="d-flex justify-content-between">
                                        <div class="user_inner">
                                            <img src="<?php echo e(asset('frontend/images/search1.png')); ?>">
                                            <div class="user_info">
                                                <h6 class="primary fwt-bold m-0">John Doe</h6>
                                                <p class="m-0">2 Weeks Ago</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="rating my-2">
                                        <input value="5" name="rating" id="star5" type="radio">
                                        <label for="star5"></label>
                                        <input value="4" name="rating" id="star4" type="radio">
                                        <label for="star4"></label>
                                        <input value="3" name="rating" id="star3" type="radio">
                                        <label for="star3"></label>
                                        <input value="2" name="rating" id="star2" type="radio">
                                        <label for="star2"></label>
                                        <input value="1" name="rating" id="star1" type="radio">
                                        <label for="star1"></label>
                                    </div>
                                    <p class="m-0">I had a great experience at HealthCrest. The doctors and nurses were incredibly attentive and took the time to explain everything clearly. The clinic was clean and well-organized, making me feel comfortable and well cared for. I highly recommend this clinic to anyone looking for quality healthcare.</p>

                                </div>

                                <div class="comment_box">
                                    <div class="d-flex justify-content-between">
                                        <div class="user_inner">
                                            <img src="<?php echo e(asset('frontend/images/john_doe.png')); ?> ">
                                            <div class="user_info">
                                                <h6 class="primary fwt-bold m-0">Joseph Miller</h6>
                                                <p class="m-0">1 month Ago</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="rating my-2">
                                        <input value="5" name="rating" id="star5" type="radio">
                                        <label for="star5"></label>
                                        <input value="4" name="rating" id="star4" type="radio">
                                        <label for="star4"></label>
                                        <input value="3" name="rating" id="star3" type="radio">
                                        <label for="star3"></label>
                                        <input value="2" name="rating" id="star2" type="radio">
                                        <label for="star2"></label>
                                        <input value="1" name="rating" id="star1" type="radio">
                                        <label for="star1"></label>
                                    </div>
                                    <p class="m-0">My visit to doctor Jack was smooth and hassle-free. He was friendly and the wait time was minimal. The doctor listened to my concerns and provided a thorough examination. I left feeling confident in the care I received. I’ll definitely return for any future medical needs.</p>
                                    <div class="reply_inner">
                                        <a href="#" class="primary text-decoration-underline">Reply</a>
                                        <div class="my-3 ps-3">
                                            <div class="user_inner">
                                                <img src="<?php echo e(asset('frontend/images/drclark.png')); ?>">
                                                <div class="user_info">
                                                    <h6 class="primary fwt-bold m-0">Joseph Miller</h6>
                                                    <p class="m-0">2 Weeks Ago</p>
                                                </div>
                                            </div>
                                            <p class="mb-0 mt-3">Thank you for your kind words!</p>
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
</section>






<!-- Book Appointment -->


<div class="modal login-modal fade" id="bookAppointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="text-center fwt-bold">Book Appointment</h4>
                    <p>Choose a time slot and confirm your booking</p>
                </div>
                <div class="AppointmentFees mt-4">
                    <h5 class="m-0 white">Appointment Fees</h5>
                    <h2 class="m-0 white">$100</h2>
                </div>
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-block w-100 text-center my-3">
                                <h6 class="mb-0 fwt-bold">Today</h6>
                                <small>6 slots available</small>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-block w-100 text-center my-3">
                                <h6 class="mb-0 fwt-bold">Tomorrow</h6>
                                <small>14 slots available</small>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev d-flex justify-content-start" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon material-symbols-outlined primary" aria-hidden="true">keyboard_arrow_left</span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next d-flex justify-content-end" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                        <span class="carousel-control-next-icon material-symbols-outlined primary" aria-hidden="true">keyboard_arrow_right</span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <div class="timeSlot_box">
                    <div class="timeSlot_Inner active">
                        <p class="m-0 fwt-bold">9.00AM</p>
                    </div>
                    <div class="timeSlot_Inner">
                        <p class="m-0 fwt-bold">9.30AM</p>
                    </div>
                    <div class="timeSlot_Inner">
                        <p class="m-0 fwt-bold">10.00AM</p>
                    </div>
                    <div class="timeSlot_Inner">
                        <p class="m-0 fwt-bold">10.30AM</p>
                    </div>
                    <div class="timeSlot_Inner">
                        <p class="m-0 fwt-bold">11.00AM</p>
                    </div>
                    <div class="timeSlot_Inner">
                        <p class="m-0 fwt-bold">11.30AM</p>
                    </div>
                </div>
                <div class="btn_alignbox mt-4">
                    <a class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#confirmBooking">Continue</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!------ Confirm Booking ------>


<div class="modal login-modal fade" id="confirmBooking" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-5 col-12">
                        <div class="br-l d-flex justify-content-between flex-column h-100 pe-4">
                            <div>
                                <h4 class="fwt-bold mt-2">Book Appointment</h4>
                                <div class="search_profile align-items-center mt-4">
                                    <div class="image-inner">
                                        <img class="profile_img" src="<?php echo e(asset('frontend/images/search1.png')); ?> ">
                                    </div>
                                    <div class="profile_info">
                                        <h5 class="primary fwt-bold mb-0">Dr Jack Clark</h5>
                                        <p class="mb-0">General Physician</p>
                                    </div>
                                </div>
                                <div class="d-flex flex-row gap-5 mt-4">
                                    <div class="">
                                        <p class="mb-1 fwt-medium">Date</p>
                                        <h6 class="mb-0 fwt-medium">28. 2024</h6>
                                    </div>
                                    <div class="">
                                        <p class="mb-1 fwt-medium">Time</p>
                                        <h6 class="mb-0 fwt-medium">9:30 Am</h6>
                                    </div>

                                </div>
                            </div>
                            <div class="btn_alignbox">
                                <a href="#" class="btn btn-outline-primary w-100">Edit Booking</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12">
                        <h4 class="fwt-bold mb-0 mt-2">Patient Details</h4>
                        <p class="fwt-light">Please verify the following information about you</p>
                        <form>
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group form-outline mb-3">
                                        <label for="input" class="">Appointment Time</label>
                                        <i class="fa-solid fa-circle-user"></i>
                                        <input type="email" class="form-control" id="exampleFormControlInput1">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group form-outline mb-3">
                                        <label for="input" class="">Phone Number</label>
                                        <i class="material-symbols-outlined">call</i>
                                        <input type="email" class="form-control" id="exampleFormControlInput1">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group form-outline mb-3">
                                        <label for="input" class="">Email</label>
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="email" class="form-control" id="exampleFormControlInput1">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group form-outline form-textarea mb-3">
                                        <label for="input" class="">Notes</label>
                                        <i class="fa-solid fa-file-lines"></i>
                                        <textarea class="form-control" id="exampleFormControlInput1" rows="4" cols="4"></textarea>
                                    </div>
                                </div>
                                <div class="btn_alignbox justify-content-end">
                                    <a href="" class="btn btn-outline-primary">Cancel</a>
                                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#feesModal">Confirm Booking</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!------ Appointment Fee Modal ------>


<div class="modal login-modal fade" id="feesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center amount_body">
                    <h4 class="text-center fwt-bold">Appointment Fee</h4>
                    <p class="mb-0 px-lg-5 mx-lg-5">You are required to pay an appointment fee to continue your appointment call </p>
                    <p class="mt-5 mb-0">Total Amount</p>
                    <h3 class="mb-3"><span class="gray">$</span>100.00</h3>
                </div>
                <form>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">Card Number</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">Cardholder Name</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">Valid Till</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group form-outline mb-3">
                                <label for="input" class="">CVV</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                        </div>
                        <div class="btn_alignbox mt-4">
                            <a href="" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Pay Now</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Loader -->

<div class="modal login-modal fade" id="loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="<?php echo e(asset('frontend/images/loader.gif')); ?> " class="img-fluid loader">
            </div>
        </div>
    </div>
</div>

<!----Loader end --->

<!-- Success Signin -->

<div class="modal login-modal fade" id="successSignin" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="<?php echo e(asset('frontend/images/sucess.png')); ?> " class="img-fluid p-3">
                <h4 class="text-center fw-bold mb-0">Booking Confirmed</h4>
                <small class="gray">You can now meet the doctor at the allotted time</small>
            </div>
        </div>
    </div>
</div>

<!---success end ---->




<!------ Direction Modal ------>


<div class="modal login-modal fade" id="directionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-center fwt-bold mb-3">Location</h4>
                <div class="map_body">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7892.346474463128!2d76.96177014419004!3d8.48253047773632!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05bafd81605ca1%3A0xa8e67b1ad8c943e1!2sKaramana%2C%20Thiruvananthapuram%2C%20Kerala!5e0!3m2!1sen!2sin!4v1726637191623!5m2!1sen!2sin" width="" height="450" frameborder="0" style="border:0;outline: none;width:100%;border-radius:8px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#loader').on('shown.bs.modal', function() {
            setTimeout(function() {
                $('#loader').modal('hide');
                $('#successSignin').modal('show');
            }, 2000);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/view-profile.blade.php ENDPATH**/ ?>