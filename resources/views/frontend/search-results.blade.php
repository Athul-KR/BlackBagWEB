@extends('frontend.master')
@section('title', 'Medical History')
@section('content')

<section class="banner-container mb-0">
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between flex-sm-row flex-column">
                    <div class="content_box">
                        <h3>Find Your Specialist</h3>
                        <p>Choose a clinic or doctor that meets your requirements and book an appointment</p>
                    </div>
                    <div class="sort-sec mb-sm-0 mb-4">
                        <select class="form-select" aria-label="Default select example">
                            <option selected="">Relevance</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row justify-content-center">
                    <div class="col-lg-2">
                        <div class="form-group form-outline form-textarea mb-4">
                            <label for="input">Location</label>
                            <i class="material-symbols-outlined">location_on</i>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="form-group form-outline form-textarea mb-4">
                            <label for="input">All</label>
                            <i class="material-symbols-outlined">medication</i>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group form-outline form-textarea mb-4">
                            <label for="input">Search clinicians or specialities</label>
                            <i class="material-symbols-outlined">search</i>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <hr>
            </div>
            <div class="col-12">
                <div class="row mt-4">
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="filter_box">
                                    <p class="mb-1">Filter By:</p>
                                    <h5 class="fwt-bold">Appointment Fees</h5>
                                    <form class="checkbox-form mt-3">
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>
                                                < $100</label>
                                        </div>
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>$100 -$200</label>
                                        </div>
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>$200 -$300</label>
                                        </div>
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>$300 -$400</label>
                                        </div>
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>> $400 </label>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="filter_box">
                                    <h5 class="fwt-bold">Availability</h5>
                                    <form class="checkbox-form mt-3">
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>Available Today</label>
                                        </div>
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>Available Tomorrow</label>
                                        </div>
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>Available This Week</label>
                                        </div>
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>Available This Month</label>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="filter_box">
                                    <h5 class="fwt-bold">Patient Ratings</h5>
                                    <form class="checkbox-form mt-3">
                                        <div>
                                            <input id="01" type="radio" name="r" value="1" checked="">
                                            <label>5 Star</label>
                                        </div>
                                        <div>
                                            <input id="02" type="radio" name="r" value="2" checked="">
                                            <label>4 Star</label>
                                        </div>
                                        <div>
                                            <input id="03" type="radio" name="r" value="3" checked="">
                                            <label>3 Star</label>
                                        </div>
                                        <div>
                                            <input id="04" type="radio" name="r" value="4" checked="">
                                            <label>2 Star</label>
                                        </div>
                                        <div>
                                            <input id="05" type="radio" name="r" value="5" checked="">
                                            <label>1 Star</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9">
                        <div class="search_list">
                            <ul class="ps-lg-5 p-0 flex-column">
                                <li>
                                    <div class="row align-items-center w-100">
                                        <div class="col-lg-9">
                                            <div class="search_profile">
                                                <div class="image-inner">
                                                    <img class="profile_img" src="{{ asset('frontend/images/search1.png')}}" alt="profile Image">
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
                                            <div class="d-flex flex-column justify-content-center gap-3 mt-lg-0 mt-3">
                                                <div class="btn_alignbox justify-content-lg-end justify-content-center">
                                                    <a href="{{route('frontend.viewProfile')}}" class="btn btn-outline-primary">View Profile</a>
                                                </div>
                                                <div class="rating-body justify-content-lg-end justify-content-center">
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
                                <li>
                                    <div class="row align-items-center w-100">
                                        <div class="col-lg-9">
                                            <div class="search_profile">
                                                <div class="image-inner">
                                                    <img class="profile_img" src="{{ asset('frontend/images/search2.png')}}" alt="profile image">
                                                </div>
                                                <div class="profile_info">
                                                    <h5 class="primary fwt-bold mb-0">HealthCrest Health Clinic</h5>
                                                    <p class="mb-0">healthcrest@gmail.com</p>
                                                    <p><span class="material-symbols-outlined">location_on</span>2055 Niagara Falls Blvd, Amherst NY 14228</p>
                                                    <div class="badges-inner">
                                                        <ul>
                                                            <li>Primary Care</li>
                                                            <li>Emergency Care</li>
                                                            <li>Laboratory Services</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="d-flex flex-column justify-content-center gap-3 mt-lg-0 mt-3">
                                                <div class="btn_alignbox justify-content-lg-end justify-content-center">
                                                    <a href="{{route('frontend.clinicProfile')}}" class="btn btn-outline-primary">View Profile</a>
                                                </div>
                                                <div class="rating-body justify-content-lg-end justify-content-center">
                                                    <span>4.1</span>
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
                                <li>
                                    <div class="row align-items-center w-100">
                                        <div class="col-lg-9">
                                            <div class="search_profile">
                                                <div class="image-inner">
                                                    <img class="profile_img" src="{{ asset('frontend/images/nature_Care.png')}} " alt="profile image">
                                                </div>
                                                <div class="profile_info">
                                                    <h5 class="primary fwt-bold mb-0">NatureCare Ayurvedic Hospital</h5>
                                                    <p class="mb-0">naturecare@gmail.com</p>
                                                    <p><span class="material-symbols-outlined">location_on</span>3018 East Ave, Central Square NY 13036</p>
                                                    <div class="badges-inner">
                                                        <ul>
                                                            <li>Ayurvedic Medicine</li>
                                                            <li>Acute Care</li>
                                                            <!-- <li>Chronic Disease Management</li> -->
                                                            <li>Massage</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="d-flex flex-column justify-content-center gap-3 mt-lg-0 mt-3">
                                                <div class="btn_alignbox justify-content-lg-end justify-content-center">
                                                    <a href="#" class="btn btn-outline-primary">View Profile</a>
                                                </div>
                                                <div class="rating-body justify-content-lg-end justify-content-center">
                                                    <span>4.3</span>
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
                                <li>
                                    <div class="row align-items-center w-100">
                                        <div class="col-lg-9">
                                            <div class="search_profile">
                                                <div class="image-inner">
                                                    <img class="profile_img" src="{{ asset('frontend/images/search4.png')}} " alt="Profile Image">
                                                </div>
                                                <div class="profile_info">
                                                    <h5 class="primary fwt-bold mb-0">Evergreen Health Center</h5>
                                                    <p class="mb-0">evergreenhealth@gmail.com</p>
                                                    <p><span class="material-symbols-outlined">location_on</span>337 Russell St, Hadley MA 1035</p>
                                                    <div class="badges-inner">
                                                        <ul>
                                                            <li>Annual Physical Exams</li>
                                                            <li>Emergency Care</li>
                                                            <li>Chronic Disease Management</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="d-flex flex-column justify-content-center gap-3 mt-lg-0 mt-3">
                                                <div class="btn_alignbox justify-content-lg-end justify-content-center">
                                                    <a class="btn btn-outline-primary">View Profile</a>
                                                </div>
                                                <div class="rating-body justify-content-lg-end justify-content-center">
                                                    <span>4.5</span>
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
                </div>
            </div>
        </div>
    </div>

</section>

@endsection()