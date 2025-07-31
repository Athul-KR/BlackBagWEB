@extends('frontend.master')
@section('title', 'Medical History')
@section('content')

<section class="details_wrapper">

    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <nav class="mb-0" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="patientrecords.html" class="primary">Find Doctors & Clinics</a></li>
                        <li class="breadcrumb-item active" aria-current="page">NatureCare Ayurvedic Hospital</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row h-100">
            <div class="col-xl-8 col-12 mb-3">
                <div class="web-card h-100">
                    <div class="profileData tourism_profile d-flex justify-content-between align-items-end h-100">
                        <div class="user_details text-start">
                            <img src="images/natureproimg.png" class="img-fluid">
                            <h5 class="fwt-bold dark">NatureCare Ayurvedic Hospital</h5>
                            <p>naturecare@gmail.com</p>
                        </div>
                        <div class="d-flex align-items-end justify-content-center justify-content-xl-end">
                            <div class="btn_alignbox">
                                <a class="btn btn-outline d-flex align-items-center gap-1"><span class="material-symbols-outlined">language</span>naturecare@gmail.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="detailsList cardList">
                        <h5 class="fwt-bold">Contact</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="fwt-bold">Phone Number</h6>
                            <p>(310) 926-7131</p>
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
                <div class="web-card">
                    <div class="col-12">
                        <ul class="nav nav-pills flex-row w-100 mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill" data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about" aria-selected="true">
                                    About
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-doctor-tab" data-bs-toggle="pill" data-bs-target="#pills-doctor" type="button" role="tab" aria-controls="pills-doctors" aria-selected="false">
                                    Doctors
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-gallery-tab" data-bs-toggle="pill" data-bs-target="#pills-gallery" type="button" role="tab" aria-controls="pills-gallery" aria-selected="false">
                                    Gallery
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill" data-bs-target="#pills-reviews" type="button" role="tab" aria-controls="pills-reviews" aria-selected="false">
                                    Reviews
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">

                            <div class="tab-pane fade show active" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="fwt-bold mb-0">About</h5>
                                        </div>
                                        <p>Welcome to NatureCare Ayurvedic Hospital, where your health and well-being are our top priorities. Established with a commitment to providing exceptional medical care, our clinic combines advanced technology with a compassionate approach to ensure every patient receives personalized treatment. Our team of experienced doctors, nurses, and healthcare professionals is dedicated to delivering comprehensive healthcare services across various specialties. Whether you're visiting us for a routine check-up, managing a chronic condition, or seeking expert advice, we strive to create a supportive and welcoming environment.</p>

                                    </div>
                                    <div class="col-12">
                                        <h5 class="fwt-bold">Package Includes</h5>
                                        <ul class="list_items p-0 flex-xl-row gap-xl-4 gap-3 mt-2 treatment_list">
                                            <li><img src="images/flight.png" class="img-fluid">Flight Tickets</li>
                                            <li><img src="images/car.png" class="img-fluid">Pickup &amp; Dropoff</li>
                                            <li><img src="images/rehabilitation.png" class="img-fluid">Rehab</li>
                                            <li><img src="images/checkup.png" class="img-fluid">Regular Checkups</li>
                                        </ul>
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
                                                <h5 class="fwt-bold">Services</h5>
                                                <ul class="list_items p-0 mb-0 mt-2">
                                                    <li><i class="fa-solid fa-check"></i>Annual Physical Exams</li>
                                                    <li><i class="fa-solid fa-check"></i>Emergency Care</li>
                                                    <li><i class="fa-solid fa-check"></i>Preventive Care and Screenings</li>
                                                    <li><i class="fa-solid fa-check"></i>Chronic Disease Management</li>
                                                    <li><i class="fa-solid fa-check"></i>Maternity and Prenatal Care</li>
                                                    <li><i class="fa-solid fa-check"></i>Pediatric Care</li>
                                                    <li><i class="fa-solid fa-check"></i>Women’s Health Services</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-doctor" role="tabpanel" aria-labelledby="pills-doctor-tab">
                                <h5 class="fwt-bold mb-0">Doctors</h5>
                                <div class="search_list">
                                    <ul class="p-0 border-0 flex-column">
                                        <li>
                                            <div class="row align-items-center w-100">
                                                <div class="col-lg-9">
                                                    <div class="search_profile">
                                                        <div class="image-inner">
                                                            <img class="profile_img" src="images/search1.png">
                                                        </div>
                                                        <div class="profile_info">
                                                            <h5 class="primary fwt-bold mb-0">Dr Edward Grey</h5>
                                                            <p class="mb-0">edwardgreay@gmail.com</p>
                                                            <p><span class="material-symbols-outlined">location_on</span>5360 Southwestern Blvd, Hamburg NY 14075</p>
                                                            <div class="badges-inner">
                                                                <ul>
                                                                    <li>Lifestyle Medicine</li>
                                                                    <li>Preventive Care</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <div class="btn_alignbox">
                                                            <a href="viewprofile.html" class="btn btn-outline-primary">View Profile</a>
                                                        </div>
                                                        <div class="rating-body mt-lg-3 mt-2">
                                                            <span>3.2</span>
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
                                            </div>
                                        </li>


                                    </ul>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fwt-bold mb-0">Gallery</h5>

                                </div>

                                <div class="gallery_wrapper">
                                    <div class="row">
                                        <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/torism1.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="images/torism1.png">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/tourism2.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="images/tourism2.png">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/tourism3.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="images/tourism3.png">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                                            <a href="images/tourism4.png" data-toggle="lightbox" data-gallery="example-gallery">
                                                <div class="item">
                                                    <img class="transition img-responsive" src="images/tourism4.png">
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
                                        <ul class="flex-column">
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
                                        <div class="comments_wrapper align-items-start">
                                            <img class="pfl-img" src="images/john_doe.png">
                                            <div class="form-group form-outline form-textarea flex-grow-1 mx-3">
                                                <label for="input" class="">Write your reply to this comment</label>
                                                <textarea class="form-control" id="exampleFormControlInput1" rows="4" cols="4"></textarea>
                                            </div>
                                            <div class="d-flex flex-column gap-2">
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

                                <div class="comment_box">
                                    <div class="d-flex justify-content-between">
                                        <div class="user_inner">
                                            <img src="images/john_doe.png">
                                            <div class="user_info">
                                                <h6 class="primary fwt-bold m-0">John Doe</h6>
                                                <p class="m-0">2 Weeks Ago</p>
                                            </div>
                                        </div>
                                        <div class="btn_alignbox">
                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span></a>
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
                                            <img src="images/search1.png">
                                            <div class="user_info">
                                                <h6 class="primary fwt-bold m-0">Joseph Miller</h6>
                                                <p class="m-0">1 month Ago</p>
                                            </div>
                                        </div>
                                        <div class="btn_alignbox">
                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span></a>
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
                                        <a href="" class="primary text-decoration-underline">Reply</a>
                                        <div class="my-3 ps-3">
                                            <div class="d-flex justify-content-between">
                                                <div class="user_inner">
                                                    <img src="images/drclark.png">
                                                    <div class="user_info">
                                                        <h6 class="primary fwt-bold m-0">Joseph Miller</h6>
                                                        <p class="m-0">2 Weeks Ago</p>
                                                    </div>
                                                </div>
                                                <div class="btn_alignbox">
                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="material-symbols-outlined">more_vert</span></a>
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



    <!-- settings modal -->


    <div class="modal login-modal fade" id="settingsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body text-center">
                    <div class="d-flex align-items-start">
                        <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Home</button>
                            <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Profile</button>
                            <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Messages</button>
                            <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</button>
                        </div>
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                            <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- settings end -->
</section>

@endsection()