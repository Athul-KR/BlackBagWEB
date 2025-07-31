@extends('layouts.app')
@section('title', 'Profile')
@section('content')

<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">


            <!-- <div class="col-12  mb-3 d-none">
                <div class="web-card user-card clinic-profile h-100 mb-3 overflow-hidden">
                    <img src="{{$clinic['banner_img']}}" alt="">
                    <img class="banner-img" src="{{$clinic['banner_img'] ?? asset('images/default banner.png')}}"
                        alt="">
                    <div class="profileData view_profile p-0">
                        <div class="row h-100">
                            <div class="col-12 col-md-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{$clinic['logo'] ?? asset('images/default_clinic.png')}}" class="user-img" alt="">
                                    <h5 class="fw-medium dark ms-4">{{$clinic->name ?? "N/A"}}</h5>
                                </div>
                            </div>
                            <div class="col-lg-2 col-12">
                                <div class="d-block mb-4">
                                    <p class="d-flex align-items-center mb-0"><span class="material-symbols-outlined me-2">mail</span> {{$clinic->email ?? "N/A"}}</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-block mb-4">
                                    <p class="d-flex align-items-center mb-0"><span class="material-symbols-outlined me-2">call</span>{{$clinicCountryCode['country_code'] ?? "N/A"}} {{' '}}  {{$clinic->phone_number ?? "N/A"}}</p>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex">
                                    <span class="material-symbols-outlined me-2">pin_drop</span>
                                    <p class="mb-0">
                                        <?php $corefunctions = new \App\customclasses\Corefunctions;
                                        $address = $corefunctions->formatAddress($clinic); ?>
                                        <?php echo nl2br($address); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="col-lg-3 col-12 mx-auto">
                                <div class="d-flex justify-content-center justify-content-lg-end">
                                    <div class="btn_alignbox">
                                        @if (!empty($clinic->website_link))
                                            <a href="{{ $clinic->website_link ? (Str::startsWith($clinic->website_link, ['http://', 'https://']) ? $clinic->website_link : 'http://' . $clinic->website_link) : '#' }}"
                                                target="_blank"
                                                class="btn btn-outline d-flex align-items-center gap-1" style="min-width:0px !important;"><span
                                                    class="material-symbols-outlined">language</span>
                                                
                                            </a>
                                        @endif
                                        @if(session()->get('user.isClinicAdmin') == '1')
                                        <a class="btn opt-btn" data-bs-toggle="modal" data-bs-dismiss="modal"
                                            data-bs-target="#editProfileInfo">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- <div class="col-12 mb-2">
            <div class="web-card user-card h-auto p-0 details-innercard clinic-profile">
                {{-- <img class="banner-img" src="{{asset('images/patient_bg.png')}}" alt="banner img"> --}}
                <div class="profileData view_profile">
                    <div class="row align-items-end h-100">
                        <div class="col-12">
                            <div class="row align-items-center">
                                <div class="col-lg-4 col-12"> 
                                    <div class="d-flex flex-xl-row flex-column align-items-center"> 
                                        <div class="text-lg-start text-center pe-3">
                                            <img src="{{$clinic['logo'] ?? asset('images/default_clinic.png')}}" class="user-img" alt="">
                                        </div>
                                        <div class="user_details text-xl-start text-center pe-xl-4">
                                            <div class="innercard-info justify-content-center justify-content-xl-start mb-1">
                                                <h5 class="fw-medium dark text-wrap">{{$clinic->name ?? "N/A"}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12 border-left border-right">
                                    <div class="user_details text-start">
                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">mail</i>
                                            <small>{{$clinic->email ?? "N/A"}}</small>
                                        </div>
                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">call</i>
                                            <?php 
                                            $cleanPhoneNumber = preg_replace('/[^0-9]/', '', $clinic->phone_number); // Remove all non-numeric characters
                                            if (strlen($cleanPhoneNumber) == 10) {
                                                $formattedNumber = '(' . substr($cleanPhoneNumber, 0, 3) . ') ' . 
                                                  substr($cleanPhoneNumber, 3, 3) . '-' . 
                                                  substr($cleanPhoneNumber, 6);
                                            } else {
                                                $formattedNumber = $cleanPhoneNumber;
                                            }
                                            ?>
                                            <small>{{$clinicCountryCode['country_code'] ?? "N/A"}} {{' '}}  {{$formattedNumber ?? "N/A"}}</small>
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="col-lg-3 col-12">
                                    <div class="user_details text-start">
                                        <div class="innercard-info align-items-start">
                                            <i class="material-symbols-outlined">home</i>
                                            <div class="d-flex flex-column text-start gap-0">
                                                <small class="mb-1">
                                                <?php $corefunctions = new \App\customclasses\Corefunctions;
                                        $address = $corefunctions->formatAddress($clinic); ?>
                                        <?php echo nl2br($address); ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-2 col-12"> 
                                        <div class="btn_alignbox justify-content-center justify-content-xl-end w-100 mt-xl-0 mt-3">
                                        @if (!empty($clinic->website_link))
                                            <a href="{{ $clinic->website_link ? (Str::startsWith($clinic->website_link, ['http://', 'https://']) ? $clinic->website_link : 'http://' . $clinic->website_link) : '#' }}"
                                                target="_blank"
                                                class="btn btn-outline opt-btn d-flex align-items-center gap-1" style="min-width:0px !important;"><span
                                                    class="material-symbols-outlined">language</span>
                                                
                                            </a>
                                        @endif
                                        @if(session()->get('user.isClinicAdmin') == '1')
                                        <a class="btn opt-btn" data-bs-toggle="modal" data-bs-dismiss="modal"
                                            data-bs-target="#editProfileInfo">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        @endif
                                        </div>
                                    
                                </div>

                            </div>

                        </div>                                                      
                    </div>
                </div>
            </div>
            </div> -->

          
            <!-- Contact Section -->
            <!-- <div class="col-xl-3 col-12 mb-3 d-none">
                <div class="web-card user-card h-100 mb-3">
                    <div class="detailsList cardList">
                        <h5 class="fw-medium">Contact</h5>
                        <hr>

                        <div class="d-block mb-4">
                            <h6 class="fw-medium">Phone Number</h6>
                            <p class="text-start">
                                {{$clinicCountryCode['country_code'] ?? "N/A"}} {{' '}}  {{$clinic->phone_number ?? "N/A"}}
                            </p>
                        </div>
                        <div class="d-block">
                            <h6 class="fw-medium">Address</h6>
                            <p class="text-start">
                                <?php $corefunctions = new \App\customclasses\Corefunctions;
                                $address = $corefunctions->formatAddress($clinic); ?>
                                <?php echo nl2br($address); ?>
                            </p>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-1">
                            <span class="material-symbols-outlined text-decoration-none">distance</span><a href=""
                                class="fw-medium primary text-decoration-underline" data-bs-toggle="modal"
                                data-bs-dismiss="modal" data-bs-target="#directionModal">Get Directions</a>
                        </div>
                    </div>
                </div>
            </div> -->

            <div class="col-12 mb-xl-5 mb-3 order-1 order-xl-0">
                <div class="web-card manage-web-card h-100">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle active" onclick="tabContent('clinicprofile')" id="pills-clinicprofile-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-clinicprofile" type="button" role="tab" aria-controls="pills-clinicprofile"
                                    aria-selected="true"><span class="material-symbols-outlined">home_health</span>Clinic Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle" id="pills-workinghours-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-workinghours" type="button" role="tab" aria-controls="pills-workinghours"
                                    onclick="tabContent('workinghours')" aria-selected="false"><span class="material-symbols-outlined">alarm</span>Working Hours</button>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle" id="pills-gallery-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-gallery" type="button" role="tab"
                                    aria-controls="pills-gallery" onclick="tabContent('gallery')"
                                    aria-selected="false"><span class="material-symbols-outlined">image</span>Gallery</button>
                            </li> --}}
                            
                            <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle" id="pills-userinfo-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-userinfo" type="button" role="tab"
                                    aria-controls="pills-userinfo" onclick="tabContent('stripe_info')"
                                    aria-selected="false"><span class="material-symbols-outlined">credit_score </span>Payment Portal</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle" onclick="tabContent('patientsubscription')" id="pills-patientsubscription-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-patientsubscription" type="button" role="tab" aria-controls="pills-patientsubscription"
                                    aria-selected="false"><span class="material-symbols-outlined">card_membership</span>Patient Subscription Plans</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle" onclick="tabContent('addons')" id="pills-addon-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-clinicprofile" type="button" role="tab" aria-controls="pills-addon"
                                    aria-selected="false"><span class="material-symbols-outlined">extension</span>Addons</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle" id="pills-billings-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-billings" type="button" role="tab"
                                    aria-controls="pills-billings" onclick="tabContent('billings')"
                                    aria-selected="false"><span class="material-symbols-outlined">receipt_long</span>Cards & Billing</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link align_middle" id="pills-settings-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-settings" type="button" role="tab"
                                    aria-controls="pills-settings" onclick="tabContent('settings')"
                                    aria-selected="false"><span class="material-symbols-outlined">settings</span>Settings</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">



                            <!-- <div class="tab-pane fade" id="pills-reviews" role="tabpanel"
                                aria-labelledby="pills-reviews-tab">
                                <div class="d-flex justify-content-between align-items-center border-bottom-light pb-3">
                                    <h5 class="fw-medium">User Rating & Reviews</h5>
                                    <div class="btn_alignbox">
                                        <div class="form-group filter_Box">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                            <select name="sort_filter" id="sort_filter" data-tabid="basic"
                                                class="form-select">
                                                <option value="all">Most Relevant</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="comment_box">
                                    <div class="d-flex justify-content-between">
                                        <div class="user_inner">
                                            <img src="{{asset('images/patient1.png')}}">
                                            <div class="user_info">
                                                <h6 class="primary fw-medium m-0">John Doe</h6>
                                                <p class="m-0">2 Weeks Ago</p>
                                            </div>
                                        </div>
                                        <div class="btn_alignbox">
                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span></a>
                                        </div>
                                    </div>
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
                                    <p class="m-0">I had a great experience. The doctor was incredibly attentive and
                                        took the time to explain everything clearly. He made me feel comfortable and
                                        well cared for. I highly recommend him to anyone looking for quality healthcare.
                                    </p>
                                    <div class="reply_inner">
                                        <a href="" class="primary text-decoration-underline">Reply</a>
                                        <div class="form-group form-outline form-textarea my-2">
                                            <label for="input" class="float-label">Write your reply to this
                                                comment</label>
                                            <textarea class="form-control" rows="4" cols="4"></textarea>
                                        </div>
                                        <a href="" class="primary text-decoration-underline">Cancel</a>
                                    </div>
                                </div>

                                <div class="comment_box">
                                    <div class="d-flex justify-content-between">
                                        <div class="user_inner">
                                            <img src="{{asset('images/patient7.png')}}">
                                            <div class="user_info">
                                                <h6 class="primary fw-medium m-0">Joseph Miller</h6>
                                                <p class="m-0">1 month Ago</p>
                                            </div>
                                        </div>
                                        <div class="btn_alignbox">
                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span></a>
                                        </div>
                                    </div>
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
                                    <p class="m-0">My visit to doctor Jack was smooth and hassle-free. He was friendly
                                        and the wait time was minimal. The doctor listened to my concerns and provided a
                                        thorough examination. I left feeling confident in the care I received. I’ll
                                        definitely return for any future medical needs.</p>
                                    <div class="reply_inner">
                                        <a href="" class="primary text-decoration-underline">Reply</a>
                                        <div class="my-2 ps-3">
                                            <div class="user_inner">
                                                <img src="{{asset('images/healthcrestpro.png')}}">
                                                <div class="user_info">
                                                    <h6 class="primary fw-medium m-0">HealthCrest</h6>
                                                    <p class="m-0">2 Weeks Ago</p>
                                                </div>
                                            </div>
                                            <p class="m-0">Thank you for your kind words! We’re delighted to hear that
                                                your visit to Healthcrest was smooth and that our team made you feel
                                                welcome and well cared for. Our goal is to provide each patient with
                                                attentive, high-quality care, and we’re glad that your experience
                                                reflects that. </p>
                                        </div>

                                    </div>
                                </div>
                            </div> -->

                       

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





<!------ Edit Clinic Profile Modal ------>


<div class="modal login-modal fade" id="editProfileInfo" data-bs-backdrop="static" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="" data-bs-dismiss="modal" aria-label="Close" class="close-modal"><span
                        class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="text-center fw-medium mb-0">Edit Clinic Profile</h4>
                    <small>Update your profile information</small>
                </div>

                <form id="edit_profile_form" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="clinic_uuid" value="{{$clinic->clinic_uuid}}">

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="row justify-content-center"> 
                                <div class="col-xl-3 col-lg-4 col-6">
                                    <label >Logo</label>
                                    <div id="logodiv" class="dropzone-wrapper mb-3"  style="{{ $clinic['logo'] != asset('images/default_clinic.png') ? 'display:none' : '' }}" >
                                        <a href="{{ url('crop/clinic_logo')}}" id="upload-img"
                                            class="aupload  gray fw-medium d-flex justify-content-end" data-toggle="modal"><span
                                                class="material-symbols-outlined"> add </span>Add Clinic Logo</a>
                                    </div>
                                    <div class="files-container profile-files-container profileLogo mb-3">
        
                                        <div class="fileBody profliefileBody" id="cliniclogoimage"
                                            style="{{ $clinic['logo'] == asset('images/default_clinic.png') ? 'display:none' : '' }}">
                                            <div class="file_info">
                                                <img src="{{$clinic['logo']}}" id="clinicimage" name="clinicimage">
                                                @php
                                                    $filePath = $clinic['logo']; // Replace this with your variable
                                                    $fileInfo = pathinfo($filePath);
                                                @endphp
        
                                                <!-- <span></span> -->
                                            </div>
                                            <a class="close-btn" href="javascript:void(0);" id="removelogo"
                                                onclick="removeLogo()" data-bs-dismiss=" modal" aria-label="Close"><span
                                                    class="material-symbols-outlined">close</span>
                                            </a>
                                        </div>
                                    </div>
                                    <input type="hidden" id="tempimage" name="tempimage" value="">
                                    <input type="hidden" name="isremove" id="isremove" value="0">
    
                                </div>
                                
                                <div class="col-xl-5 col-lg-6 col-12 d-none">
                                    <label >Banner</label>
                                    <div class="dropzone-wrapper mb-3" id="bannerdiv" style="{{ $clinic['banner_img'] != asset('images/default banner.png') ? 'display:none' : '' }}" >
                                        <a href="{{ url('crop/clinic_banner')}}" id="clinic_banner_img"
                                            class=" aupload gray fw-medium d-flex justify-content-end"><span
                                                class="material-symbols-outlined"> add </span>Add Clinic Banner</a>
                                    </div>
                                    <div class="files-container profile-files-container bannerImage clinic-banner mb-3">
                                        <div class="fileBody" id="clinicbannerimage"
                                            style="{{ $clinic['banner_img'] == asset('images/default banner.png') ? 'display:none' : '' }}">
                                            <div class="file_info">
                                                <img src="{{$clinic['banner_img']}}" id="clinic_banner" name="clinic_banner">
                                                @php
                                                    $filePath = $clinic['banner_img']; // Replace this with your variable
                                                    $fileInfo = pathinfo($filePath);
                                                @endphp

                                                <!-- <span></span> -->
                                            </div>
                                            <a class="close-btn" href="javascript:void(0);" id="remove_banner"
                                                onclick="removeBanner()" data-bs-dismiss=" modal" aria-label="Close"><span
                                                    class="material-symbols-outlined">close</span>
                                            </a>
                                        </div>
                                    </div>
                                    <input type="hidden" id="tempimage_banner" name="tempimage_banner" value="">
                                    <input type="hidden" name="isremove_banner" id="isremove_banner" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Clinic's Name</label>
                                <i class="material-symbols-outlined">home_health</i>
                                <input type="text" name="name" value="{{$clinic->name}}" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Email</label>
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" value="{{$clinic->email}}" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Phone</label>

                                <div class="country_code phone">
                                    <input type="hidden" id="countryCode" name="countrycode"
                                        value="{{$clinicCountryCode['country_code'] ?? '+1'}}">
                                    <input type="hidden" name="clinic_countryCodeShort" class="form-control autofillcountry"
                                        id="countryCodeShorts" value="{{$clinicCountryCode['short_code'] ?? 'us'}}">
                                </div>
                             
                                <?php $formatephone =  $corefunctions->formatPhone($clinic['phone_number']) ; ?>
                                <input id="phone" data-url="{{route('clinic.checkPhoneExist')}}" name="phone"
                                    type="text"
                                    value="{{ ($clinicCountryCode['country_code'] ?? '') . $formatephone }}"
                                    data-uuid="" class="form-control" placeholder="Phone Number" >
                            </div>

                        </div>
                        <div class="col-md-6"> 
                        <div class="form-group form-floating mb-4">
                            <i class="material-symbols-outlined">public</i>
                                            <select name="timezone_id" id="timezone_id" class="form-select">
                                                @if(!empty($timezoneDetails))
                                               
                                                    @foreach($timezoneDetails as $time)
                                                        <option value="{{$time['id']}}" @if($time['id'] == $clinic->timezone_id) selected @endif>{{$time['timezone']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label class="select-label">Timezone</label>
                                        </div>
                                    </div>


                        <div class="col-md-6">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Website</label>
                                <i class="material-symbols-outlined">language</i>
                                <input type="text" name="website_link" value="{{$clinic->website_link ?? ""}}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group form-outline textarea-align mb-4">
                                <label for="address" class="float-label">Address</label>
                                <i class="material-symbols-outlined">home</i>
                                <input type="text" name="address" id="address" value="{{$clinic->address ?? " "}}" class="form-control descriptionfield">
                            </div>
                        </div>
                      
                        <div class="col-lg-3 col-12">
                        <div class="form-group form-floating mb-4">
                            <i class="material-symbols-outlined">public</i>
                            <select name="country_id" id="country_id" onchange="stateUS()" class="form-select">
                            <!-- <option value="">Select Country</option> -->
                            @if(!empty($countryDetails))
                            @foreach($countryDetails as $cds => $cd)
                            @if($cd['id'] == 185)
                                <option value="{{ $cd['id']}}" @if($clinic->country_id == $cd['id'] ) selected @endif >{{ $cd['country_name']}}</option>
                                @endif
                            @endforeach
                            @endif
                            </select>
                            <label class="select-label">Country</label>
                        </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group form-outline mb-4">
                                <label for="city" class="float-label">City</label>
                                <i class="material-symbols-outlined">location_city</i>
                                <input type="text" name="city" value="{{$clinic->city}}" id="city" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-3" id="states" @if($clinic->country_id != 185 ) style="display: none;" @endif>
                            <div class="form-group form-floating mb-4">
                                <i class="material-symbols-outlined">map</i>
                                <select name="state_id" id="state_id" class="form-select">
                                    <option value="">State</option>
                                    @if(!empty($states))
                                        @foreach($states as $state)
                                            <option value="{{ $state['id']}}" {{$clinic['state_id'] == $state['id'] ? 'selected' : ''}}>{{ $state['state_name']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label class="select-label">State</label>
                            </div>
                        </div>
                        <div class="col-lg-3"  id="stateOther" @if($clinic->country_id == 185 ) style="display: none;" @endif>
                            <div class="form-group form-outline mb-4">
                            <label for="input" class="float-label">State</label>
                            <i class="material-symbols-outlined">map</i>
                            <input type="text" name="state" class="form-control" id="state" value="{{$clinic->state ?? ""}}">
                            </div>
                        </div>



                        <div class="col-md-3">
                            <div class="form-group form-outline mb-4">
                                <label for="zip" class="float-label">ZIP</label>
                                <i class="material-symbols-outlined">home_pin</i>
                                <input type="text" id="zip" name="zip_code" class="form-control" value="{{$clinic['zip_code']}}">
                            </div>
                        </div>
                        <div class="btn_alignbox justify-content-end mt-4">
                            <button type="button" class="btn btn-outline-primary close-modal" tabindex="0" data-bs-dismiss="modal" aria-label="Close">Close</button>
                            <button type="button" onclick="updateProfile()" class="btn btn-primary" tabindex="0" id="update_btn">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!------ Edit Clinic Profile Modal  End------>




<!------ Edit User Profile Modal ------>


<div class="modal login-modal fade" id="editUserInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close" class="close-modal"><span
                        class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="text-center fw-medium mb-0">Edit User Profile</h4>
                    <small>Update your profile information</small>
                </div>

                <form id="edit_user_profile_form" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="clinic_uuid" value="{{$clinic->clinic_uuid}}">

                    <div class="row mt-4">

                        <div class="col-md-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">User Name</label>
                                <i class="material-symbols-outlined">home_health</i>
                                <input type="text" name="name" value="{{$clinicUser->name}}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Email</label>
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" value="{{$clinicUser->email}}"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Phone</label>

                                <div class="country_code phone">

                                    <input type="hidden" id="countryCodeEdit" name="countrycode_edit"
                                        value="{{$countryCode['country_code'] ?? '+1' }}">

                                    <input type="hidden" id="countryCodeShortEdit" name="countryCodeShort"
                                        value="{{$countryCode['short_code'] ?? 'us' }}">
                                </div>

                                <input id="phone_number" data-url="{{route('clinic.checkPhoneExist')}}"
                                    name="phone_number" type="text"
                                    value="{{ ($countryCode['country_code'] ?? '') . ($clinicUser->phone_number ?? '') }}"
                                    data-uuid="" class="form-control" placeholder="Phone Number">
                            </div>

                        </div>

                        <div class="btn_alignbox justify-content-end mt-4">
                            <a class="btn btn-outline-primary close-modal" data-bs-dismiss="modal"
                                aria-label="Close">Close</a>
                            <button type="button" onclick="updateUserProfile()" class="btn btn-primary" id="update_btn">
                                Save Changes
                            </button>
                        </div>

                    </div>

                </form>


            </div>
        </div>
    </div>
</div>
<!------ Edit User Modal  End------>




<!------ Edit Slot Modal ------>

<div class="modal login-modal fade" id="editSlotModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h4 class="fw-medium mb-0">Edit Open Hours</h4>
                    <small>Update your Clinics Availability</small>
                </div>

                <div class="row mt-3" id="business_hours_modal">

                    <!-- Modal Content -->

                </div>

            </div>


        </div>
    </div>
</div>
</div>
<!------ Edit Slot Modal End------>



<!-- Dropzone -->
<div class="modal fade" id="appointmentDoc" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="fw-bold mb-4" id="appointmentNotesLabel">Upload Gallery Images</h4>
                </div>
                <form method="post" id="doc_form" autocomplete="off">
                    <div class="dropzone-wrapper mb-4 dropzone custom-dropzone" id="patientDocs"></div>
                    <div id="img_div">
                        <div class="files-container" id="appenddocsmodal"></div>
                    </div>
                    <ul class="upload-note">
                        <li><small>Maximum upload size is 3MB</small></li>
                        <li><small>Accepted files : jpg/jpeg/png</small></li>
                    </ul>
                </form>
                <div class="btn_alignbox justify-content-end mt-4">
                    <a class="btn btn-outline-primary" data-bs-dismiss="modal" aria-label="Close">Close</a>
                    <button type="button" id="save_doc_btn" onclick="saveDocs()" class="btn btn-primary">Save</button>
                </div>
            </div>
            
        </div>

    </div>
</div>



<!-- About Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="text-center fw-medium mb-0 w-100" id="appointmentNotesLabel">About</h4>
            </div>
            <form method="post" id="save_about_form" action="{{route('frontend.noteUpdate')}}" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <textarea name="notes" id="notes"
                        class="form-control  tinymce-editor tinymce_notes">{{$clinic['about']}}</textarea>
                    <input type="hidden" id="has_notes" name="has_notes">
                    <div class="btn_alignbox justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="saveAbout()" id="saveAboutButton" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- About Modal End-->



<!------ Direction Modal ------>


<div class="modal login-modal fade" id="directionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span
                        class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-center fw-medium mb-3">Location</h4>
                <div class="map_body">
                    <iframe src="https://www.google.com/maps/embed?" width="630" height="450" frameborder="0"
                        style="border:0;outline: none;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!------ Direction Modal End------>

@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp
<script>
    var loader = "{{ asset('images/loader.gif') }}";
</script>
<script src="https://js.stripe.com/v3/"></script> 
<script>
    jQuery.browser = {};
	(function() {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();
      $('.opt-btn').on('click', function() {
        initializeAutocomplete();
        });

    $(document).ready(function() {
        $('.otp-input-field').on('keyup input', function(e) {
            var key = e.which || e.keyCode;
            var $currentField = $(this);
            var $nextField = $currentField.next('.otp-input-field');
            var $prevField = $currentField.prev('.otp-input-field');

            // Move to the next field on valid input (0-9 from both main row and keypad)
            if ($currentField.val().length === 1 && ((key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                if ($nextField.length) {
                    $nextField.focus();  // Move to the next input field
                }
            }

            // Move to the previous field on backspace
            if (key === 8 && $prevField.length && $currentField.val().length === 0) {
                $prevField.focus();  // Move to the previous input field
            }


            // Prevent non-numeric input (for both main number row 0-9 and numeric keypad)
            if ((key < 48 || key > 57) && (key < 96 || key > 105)) {
                e.preventDefault();
            }

            // Check if all fields are filled
            if ($('.otp-input-field').filter(function () { return this.value.length === 0; }).length === 0) {
                // Combine the OTP fields' values into the hidden input
                let otp = $('.otp-input-field').map(function () {
                    return this.value;
                }).get().join('');
                $('#otp_value').val(otp);

                // Automatically call verifyOtp if all fields are filled
                verifyOtp();
            }
        });
    });
    function stateUS() {
        if ($("#country_id").val() == 185) {
            $("#states").show();
            $("#stateOther").hide();
            $("#state").val('');
        } else {
            $("#states").hide();
            $("#state_id").val('');
            $("#stateOther").show();
        }
    }
    $(document).ready(function () {
        stateUS()
       
        var tab = "<?php echo isset($_GET['tab']) ? $_GET['tab'] : ''; ?>";
        const hash = window.location.hash;
        if(tab == 'payment' || hash == '#paymenttab'){
            $("#pills-userinfo-tab").trigger('click');
        }else if((tab == 'addons')){
            $("#pills-addon-tab").trigger('click');
        }else{
            tabContent('clinicprofile');
        }
    
        initiateEditorwithSomeMainPlugin('notes');
    });
    jQuery.browser = {};
	(function() {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();

  
    ///Tinymce start
    function initiateEditorwithSomeMainPlugin(editorID) {
        //tinymce.remove('.tinymce_' + editorID);
        tinymce.init({
            selector: '.tinymce_' + editorID,
            height: 250,
            menubar: false,
            plugins: 'image code',
            paste_as_text: true,
            entity_encoding: "raw",
            relative_urls: false,
            remove_script_host: false,
            // verify_html:false,

            images_upload_handler: function (blobInfo, success, failure) {
                // var input = document.createElement('input');
                // input.setAttribute('type', 'file');
                // input.setAttribute('accept', 'image/*');
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ URL::to("/editorupload")}}');
                var token = '{{ csrf_token() }}';
                xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.onload = function () {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
                //alert(formData);
            },
            plugins: [

                'advlist', 'autolink', 'lists',

                'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
                'insertdatetime', 'media', 'table', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic | alignleft aligncenter ' +

                'alignright alignjustify ',

            setup: function (ed) {
                ed.on('init', function (args) {
                    $('#pretxt_' + editorID).hide();
                    $('.editordiv_' + editorID).show();
                });
                ed.on('change', function (e) {
                    calculateEditorCount(editorID);

                    $("#" + editorID).val(ed.getContent());
                });
                ed.on('keyup', function (e) {
                    calculateEditorCount(editorID);

                    $("#" + editorID).val(ed.getContent());
                    console.log(ed.getContent());
                });
            }
        });
    }


    function calculateEditorCount(editorid) {

        var editorwordcount = getStats(editorid).words;

        editorwordcount = editorwordcount - 1;
        //alert(editorwordcount);
        $("#has_" + editorid).val('');

        if (editorwordcount > 0) {

            $("#has_" + editorid).val(1);
            $("#has_" + editorid).valid();
        }

        //$("#hascontent").valid();
    }

    function getStats(id) {

        var body = tinymce.get(id).getBody(),
            text = tinymce.trim(body.innerText || body.textContent);

        return {
            chars: text.length,
            words: text.split(/[\w\u2019\'-]+/).length
        };
    }

    //Tinymce end

    //Image Upload
    function clinicLogoImage(imagekey, imagePath, imgName) {

        $("#tempimage").val(imagekey);
        $("#clinicimage").attr("src", imagePath);
        $("#clinic_logo_name").text(imgName);
        $("#cliniclogoimage").show();
        $("#removelogo").show();
        $("#logodiv").hide();
        
    }


    function clinicBannerImage(imagekey, imagePath, imgName) {

        $("#tempimage_banner").val(imagekey);
        $("#clinic_banner").attr("src", imagePath);
        $("#clinic_banner_name").text(imgName);
        $("#clinicbannerimage").show();
        $("#removelogo").show();
        $("#bannerdiv").hide();
        

    }

    function removeLogo() {
        swal({
            title: '',
            text: 'Are you sure you want to remove this image?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            }).then((willDelete) => {


            if (willDelete) {
                event.preventDefault();
                $("#isremove").val('1');
                $("#tempimage").val('');
                $("#cliniclogoimage").hide();
                $("#logodiv").show();
                } else {
                }

            // $("#upload-img").show();

        });
    }

    function removeBanner() {

        swal({
            title: '',
            text: 'Are you sure you want to remove this image?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            }).then((willDelete) => {


            if (willDelete) {
            event.preventDefault();
            $("#isremove_banner").val('1');
            $("#clinicbannerimage").hide();
            $("#bannerdiv").show();
            } else {
            }
            // $("#upload-img").show();

        });


    }
    $(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });



    $().ready(function () {
        var form = $('#edit_profile_form');
        var uuid = '{{$clinic->clinic_uuid}}';
        var email = '{{$clinic->email}}';
        var urlmail = "{{route('clinic.checkMailExist')}}";
        var urlphone = "{{route('clinic.checkPhoneExist')}}";



        //Validation
        form.validate({

            rules: {
                name : {
                                  required: true,
                                  maxlength: 150
                              },
                address: "required",
                city: "required",
                // state_id: "required",
                zip_code: {
                    required: true,
                    digits: true,
                    maxlength: 6,
                    minlength: 4,
                },
                email: {
                    required: true,
                    email: true,
                    //regex: true,
                    // remote: {
                    //     url: urlmail,
                    //     data: {
                    //         _token: $("input[name=_token]").val(),
                    //         clinic_uuid: uuid,
                    //     },
                    //     type: "post",
                    // },
                },
                phone: {
                    required: true,
                    // digits: true,
                    // remote: {
                    //     url: urlphone,
                    //     data: {
                    //         _token: $("input[name=_token]").val(),
                    //         clinic_uuid: uuid,
                    //         formtype: 'userUpdate',
                    //     },
                    //     type: "post",
                    // },
                    maxlength: 15,
                    minlength: 10,
                    NumberValids: true,
                },

                

                website_link: {

                    webLink: true,
                },
                state: {
                required: {
                        depends: function (element) {
                        return (($("#country_id").val() != '185'));
                        // return (($("#country").val() =='236') );
                        }
                    },
                },

                state_id: {
                    required: {
                        depends: function (element) {
                        return (($("#country_id").val() == '185'));
                        // return (($("#country").val() =='236') );
                        }
                    },
                    },

            },
            messages: {
               name :{
                                  required : "Please enter clinic name.",
                                  maxlength : 'Please enter valid clinic name.'
                              },
                email: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address",
                    //regex: "Please enter a valid email address",
                    remote: "Email already exist",
                },
                phone: {
                    required: "Please enter phone number",
                    // digits: "Please enter a valid phone number",
                    remote: "This phone number is already in use",
                    maxlength: "Please enter a valid phone number",
                    minlength: "Please enter a valid phone number",
                    NumberValids: 'Please enter a valid phone number.',
                },
                zip_code: {
                    required: "Please enter zip code",
                    digits: "Please enter a valid zip code",
                    maxlength: "Please enter a valid zip code",
                    minlength: "Please enter a valid zip code",
                },

                address: "Please enter address",
                city: "Please enter city",
                state: "Please enter state.",
                state_id: "Please select state",
            },
            submitHandler: function (form) {
                // Disable the submit button to prevent multiple clicks
                var submitButton = $("#update_btn");
                submitButton.prop("disabled", true);
                submitButton.text("Submitting..."); //change button text
                $('#edit_profile_form').submit(); // Use native form submission
                // Submit the form
                if (form.valid()) {
                    // alert("hh");
                    form.submit(); // Use native form submission
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "phone") {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }


        });
        jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
        return this.optional(element) || phone_number.length < 14 &&
            phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
      });
        // Custom email regex validation method
        $.validator.addMethod(
            "regex",
            function (value, element) {
                // Adjust the regex as needed for your requirements
                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailRegex.test(value);
            },
            "Please enter a valid email format."
        );
        $.validator.addMethod(
            "webLink",
            function (value, element) {
                var urlRegex = /^(https?:\/\/)?(www\.)?([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}([\/\w .-]*)*\/?$/i;
                return this.optional(element) || urlRegex.test(value);
            },
            "Please enter a valid URL."
        );



        $(document).on("click", ".close-modal", function () {
            // $("#edit_profile_form")[0].reset(); // Resets form inputs
            $("#edit_profile_form").validate().resetForm(); // Resets validation state
        });




    })
    
    //Document Ready End
    function stripeAction(stripeData){

        if(stripeData['is_connected'] == 0){


            window.location.href = stripeData['url'];
            
        }else{

            disconnectStripe();
        }


    }

    function updateProfile() {


        var form = $('#edit_profile_form');
        var url = "{{route('clinic.updateProfile')}}";
        var formData = $('#edit_profile_form').serialize();

        var selectedTimezone = $('#timezone_id').val(); // adjust ID if different
        var originalTimezone = '{{$clinic->timezone_id}}';

        if (selectedTimezone !== originalTimezone) {
            // Show confirmation before continuing
            swal({
                title: "",
                text: "Changing the timezone will not automatically adjust the clinicians' working hours, so they may need to review and update their working hours manually if needed.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((confirmed) => {
                if (confirmed) {
                    proceedWithUpdate();
                }
            });
        }else{
            proceedWithUpdate();
        }

    }
    function proceedWithUpdate(){
        var form = $('#edit_profile_form');
        var url = "{{route('clinic.updateProfile')}}";
        var formData = $('#edit_profile_form').serialize();

        if (form.valid()) {
            var submitButton = $("#update_btn");
            submitButton.prop("disabled", true);
            submitButton.text("Submitting...");
        }

        if (form.valid()) {
            var type ='working-hours';
            // getOnboardingDetails(type,'registerform','profile');
            $.ajax({
                type: "POST",
                url: '{{ url("/clinic/settings/") }}/' + type,
                data: {
                   "nextstep": type,
                    'formType' : 'clinic',
                    'formdata': $('#edit_profile_form').serialize(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    
                    console.log(response);
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        buttons: false,  // Optional: Hide the button (no user interaction needed)
                        timer: 2000      // Automatically close after 4 seconds (4000ms)
                    }).then(() => {
                        window.location.reload();
                    });
                    
                   
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });


            

        }
    }
    // var urlmail = "{ url('/frontend/checkEmailExist') }}";
    // var urlphone = "{route('clinic.checkPhoneExist', ['type' => 'userUpdate'])}}";
    var clinicID = '{{$clinic->id}}';
    var form=$("#edit_user_profile_form");

    //Validation
    $('#edit_user_profile_form').validate({

        rules: {
            name: "required",

            email: {
                required: true,
                email: true,
                regex: true,
                remote: {
                        url: "{{ url('/frontend/checkEmailExist') }}",
                        data: {
                        'type': 'clinicUser',
                        'uuid': "{{$clinicUser->clinic_user_uuid}}",
                        '_token': $('input[name=_token]').val(),
                        'clinic_id': function () {
                                return clinicID; 
                                }, 
                        'phone_number': function () {
                                return $("#phone_number").val(); 
                                }, 
                            'country_code': function () {
                            return $("#countryCodeShortEdit").val(); 
                            }, 
                        },
                        type: "post",
                    },
            },
            phone_number: {
                required: true,
               // digits: true,
                remote: {
                            url: "{{ url('/validateuserphone') }}",

                            data: { 
                                "id":"{{$clinicUser->user_id}}",
                                'type': 'clinicUser',
                                '_token': $('input[name=_token]').val(),
                                'clinic_id': function () {
                                    return clinicID; 
                                    }, 
                                'country_code': function () {
                                    return $("#countryCodeShortEdit").val(); 
                                    }, 
                                'email': function () {
                                    return $("#email").val(); 
                                    },             
                                },

                            type: "post",
                            dataFilter: function (response) {
                            // Parse the server's response
                            const res = JSON.parse(response);
                            if (res.valid) {
                                return true; // Validation passed
                            } else {
                                // Dynamically return the error message
                                return "\"" + res.message + "\"";
                            }
                        }

                        },
                maxlength: 13,
                minlength: 10
            }
      

        },
        messages: {
            name: "Please enter clinic name",
            email: {
                required: "Please enter email address",
                email: "Please enter a valid email address",
                regex: "Please enter a valid email address",
                remote: "Email already exist",
            },
            phone_number: {
                required: "Please enter phone number",
                digits: "Please enter a valid phone number",
                remote: "This phone number is already in use",
                maxlength: "Please enter a valid phone number",
                minlength: "Please enter a valid phone number",
            },

        },
        // submitHandler: function (form) {
        //     // Disable the submit button to prevent multiple clicks
        //     var submitButton = $("#update_btn");
        //     submitButton.prop("disabled", true);
        //     submitButton.text("Submitting..."); //change button text
        //     alert("u");
        //     // Submit the form
        //     if (form.valid()) {
        //         // alert("hh");
        //         form.submit(); // Use native form submission
        //     }
        // },
        errorPlacement: function (error, element) {
            if (element.attr("name") == "phone_number") {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }

    });
    // Custom email regex validation method
    $.validator.addMethod(
        "regex",
        function (value, element) {
            // Adjust the regex as needed for your requirements
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailRegex.test(value);
        },
        "Please enter a valid email format."
    );





    //User profile update
    function updateUserProfile() {


        var form = $('#edit_user_profile_form');
        var url = "{{route('clinic.updateUserProfile')}}";

        if ($('#edit_user_profile_form').valid()) {

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    'formData': $('#edit_user_profile_form').serialize(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    if (response.status == 'success') {
                        $('.usernamecls').html(response.username);
                        $('.useremailcls').html(response.email);
                        console.log(response.username)
                        swal(
                            "Success!",
                            response.message,
                            response.status,
                        ).then((e) => {
                            event.preventDefault();
                            // Refresh the page when the appointment clicks OK or closes the alert
                            console.log(response);
                            $('#editUserInfo').modal('hide');
                            tabContent('user_info');
                          
                        });
                    } else {
                        swal(
                            "Error!",
                            response.message,
                            response.status,
                        );
                    }
                },
                error: function(xhr) {
                    
                    handleError(xhr);
                }
            });



        }

    }




    //Country Code
    var telInput = $("#phone"),
        countryCodeInput = $("#countryCode"),
        countryCodeShort = $("#countryCodeShorts"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg"),

        userInput = $("#phone_number"),
        userCountryCodeInput = $('#countryCodeEdit'),
        userCodeShort = $('#countryCodeShortEdit');
        // let onlyCountriesx = {!! json_encode($corefunctions->getCountry()) !!};
        let onlyCountriesx = ['us'];
    // initialise plugin
    telInput.intlTelInput({
        autoPlaceholder: "polite",
            initialCountry: "us",
            formatOnDisplay: true,
            autoHideDialCode: true,
            defaultCountry: "auto",
            onlyCountries: onlyCountriesx,
            nationalMode: false,
            separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Ensure latest version
    });

    var reset = function () {
        telInput.removeClass("error");
        errorMsg.addClass("hide");
        validMsg.addClass("hide");
    };

    telInput.on("countrychange", function (e, countryData) {

        var countryShortCode = countryData.iso2;
        countryCodeShort.val(countryShortCode);
        updateAutocompleteCountry()
        countryCodeInput.val(countryData.dialCode);
    });

    telInput.blur(function () {
        reset();
        if ($.trim(telInput.val())) {
            if (telInput.intlTelInput("isValidNumber")) {
                validMsg.removeClass("hide");
            } else {
                telInput.addClass("error");
                errorMsg.removeClass("hide");
            }
        }
    });

    telInput.on("keyup change", reset);
    let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};

    // Similar setup for WhatsApp input
    userInput.intlTelInput({
        autoPlaceholder: "polite",
        initialCountry: "us",
        formatOnDisplay: false,
        autoHideDialCode: true,
        defaultCountry: "auto",
        onlyCountries: onlyCountries,
        nationalMode: false,
        separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    userInput.on("countrychange", function (e, countryData) {
        var countryShortCode = countryData.iso2;
        userCodeShort.val(countryShortCode);
        userCountryCodeInput.val(countryData.dialCode);
    });





    function tabContent(type,key='',page=1,userType='',search='') {
        history.pushState("", document.title, window.location.pathname + window.location.search);
        var url = "{{route('clinic.tabContent')}}";
        $("#pills-tabContent").html('<div class="d-flex justify-content-center py-5"><img src="' + '{{ asset('images/loader.gif') }}' + '" width="250px"></div>');
        $.ajax({
            url: url,
            type: "post",
            data: {
                'type': type,
                'key' : key ,
                "page":page,
                "userType":userType,
                "searchterm":search,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    $('#pills-tabContent').html(data.view);
                    if(type == 'workinghours'){
                     
                        // Attach click event to pagination links
                        $("#pagination-links a").on("click", function(e) {
                            e.preventDefault();
                            const newPage = $(this).attr("href").split("page=")[1];
                            tabContent(type, key,newPage);
                        });
                    }
                 
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            }
        });
    }


    function createBusinessHours() {
        var url = "{{route('clinic.businessHoursCreate')}}";
        $("#business_hours_modal").html('<div class="d-flex justify-content-center py-5"><img src="' + '{{ asset('images/loader.gif') }}' + '" width="250px"></div>');

        $.ajax({
            url: url,
            type: "post",
            data: {
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    $('#business_hours_modal').html(data.view);
                   
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            }
        });

    }


    function saveAbout() {

        var url = "{{route('clinic.saveAbout')}}";
        $("#saveAboutButton").prop("disabled", true);
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'formData': $('#save_about_form').serialize(),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);
                swal({
                    title: "Success!",
                    text: response.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000 // Closes after 2 seconds
                }).then(() => {
                    console.log(response);
                    window.location.reload();
                });

               
            },
            error: function(xhr) {
               
                handleError(xhr);
            }
        });

    }

    Dropzone.autoDiscover = false;
     uploadedFileCount = 0;
    // Dropzone Configurations
    var dropzone = new Dropzone('#patientDocs', {
        url: "{{ url('/clinic/upload-document') }}",
        addRemoveLinks: true,
        maxFiles: 10,
        dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span>Upload Gallery Images', // Add class for styling
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        acceptedFiles: 'image/jpeg, image/jpg, image/png', // Restrict accepted file types
        init: function () {
            this.on("sending", function (file, xhr, formData) {
                // Extra data to be sent with the file
                formData.append("formdata", $('#doc_form').serialize());
            });
            this.on("removedfile", function (file) {
                $(".remv_" + file.filecnt).remove();
            });
            this.on("maxfilesexceeded", function(file) {
                this.removeFile(file); // Remove the extra file
                swal("You can only upload up to 10 files.");
            });

           
            this.on("error", function(file, message) {
                this.removeFile(file); // Remove the failed file
                swal("File upload failed: " + message);
            });
            
            var filecount = 1;
            this.on('success', function (file, response) {
                console.log(response);

                if (response.success == 1) {
                    if (uploadedFileCount >= 10) {
                        swal("You can only upload up to 10 files.");
                        this.removeFile(file);
                        return ;
                    }
                    this.removeFile(file);
                    file.filecnt = filecount;
                    uploadedFileCount++;
                    var appnd = '<div class="fileBody docuploadcls" id="doc_' + filecount + '"><div class="file_info"><img src="' + response.tempdocpath + '"><span>' + response.docname + '</span>' +
                        '</div><a onclick="removeImageDoc(' + filecount + ')"><span class="material-symbols-outlined">close</span></a></div>' +
                        '<input type="hidden" name="patient_docs[' + filecount + '][tempdocid]" value="' + response.tempdocid + '" >';

                    $("#appenddocsmodal").append(appnd);
                    filecount++
                    // $("#docuplad").val('1');
                    // $("#docuplad").valid();
                } else {
                    if (typeof response.error !== 'undefined' && response.error !== null && response.error == 1) {
                        swal(response.errormsg);
                        this.removeFile(file);
                    }
                }
            });
        },
    });

    function removeImageDoc(count) {

        swal("Are you sure you want to remove this document?", {
            title: "Remove!",
            icon: "warning",
            buttons: true,
        }).then((willDelete) => {
            $("#doc_" + count).remove();

        })

    }


    function saveDocs() {

        var url = "{{route('clinic.storeGalleryImage')}}";
        var docLength = $('#doc_form').find('.fileBody').length;

        if ($(".fileBody.docuploadcls").length === 0) {
            // Show an alert or validation message
            swal("Warning!","Please upload at least one image before submitting.", "warning");
            return false; // Stop form submission
        }

        $.ajax({
            url: url,
            type: "post",
            data: {
                'formdata': $("#doc_form").serialize(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    $('#appointmentDoc').modal('hide');
                    $("#doc_form")[0].reset();
                    tabContent('gallery');
                } else {

                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            }
        });
        // } else {
        //     $('#save_doc_btn').prop('disabled', true);
        // }
    }


    function removeGalleryImage(uuid, event) {
        event.preventDefault();
        var url = "{{route('clinic.removeGalleryImage')}}";

        swal("Are you sure you want to remove this image?", {
            title: "Remove!",
            icon: "warning",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        'uuid': uuid,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            swal("Image deleted successfully!", {
                                title: "Success!",
                                icon: "success",
                                buttons: false,
                            }).then((willDelete) => {
                                // window.location.href = "url('medical-history')}}";
                                tabContent('gallery');
                            })

                            

                        }
                    },
                    error: function(xhr) {
                        
                        handleError(xhr);
                    }
                });
            }
        });

    }

    document.getElementById('appointmentDoc').addEventListener('hidden.bs.modal', function () {
        uploadedFileCount = 0;
        // Clear the content of the dropzone and appended files
        document.getElementById('appenddocsmodal').innerHTML = ''; // Clear appended file info
    });

    // Function to toggle the 'active' class

    function toggleLabel(input) {
          const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
          $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
        }

        $(document).ready(function() {

          // Initialize label state for each input
          $('input').each(function() {
            toggleLabel(this);
          });

          // Handle label toggle on focus, blur, and input change
          $(document).on('focus blur input change', 'input, textarea', function() {
            toggleLabel(this);
          });

          // Handle the datetime picker widget appearance by re-checking label state
          $(document).on('click', '.bootstrap-datetimepicker-widget', function() {
            const input = $(this).closest('.time').find('input');
            toggleLabel(input[0]);
          });

          // Trigger label toggle when modal opens
          $(document).on('shown.bs.modal', function(event) {
            const modal = $(event.target);
            modal.find('input, textarea').each(function() {
              toggleLabel(this);
              // Force focus briefly to trigger label in case of any timing issues
              $(this).trigger('focus').trigger('blur');
            });
          });

          // Reset label state when modal closes
          $(document).on('hidden.bs.modal', function(event) {
            const modal = $(event.target);
            modal.find('input, textarea').each(function() {
              $(this).parent().find('.float-label').removeClass('active');
            });
          });
        });


</script>


<div class="modal login-modal payment-success fade" id="addCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center amount_body mb-3">
                    <h4 class="text-center fwt-bold mb-1">Add New Card</h4>
                    <p class="fw-light gray">Please enter card details</p>
                </div>
                <form method="POST" action="" id="addcardsform" autocomplete="off">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group form-outline mb-4">
                                <i class="material-symbols-outlined">id_card</i>
                                <label for="input" class="float-label">Cardholder Name</label>
                                <input type="name" class="form-control" id="name_on_card" name="name_on_card">
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="add-card-element">

                            </div>
                        </div>
                        <div class="btn_alignbox mt-5">
                            <button type="submit" id="submitcardbtn" class="btn btn-primary w-100">Add Card</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://js.stripe.com/v3/"></script>  
<script>
  var stripe = Stripe('{{ env("STRIPE_KEY") }}');
  // Create an instance of Elements.
  var elements = stripe.elements();
  var style = {
      hidePostalCode: true,
      base: {
          color: '#32325d',
          lineHeight: '18px',
          fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
          fontSmoothing: 'antialiased',
          fontSize: '16px',
          '::placeholder': {
              color: '#aab7c4'
          }
      },
      invalid: {
          color: '#fa755a',
          iconColor: '#fa755a'
      }
  };

  var elements = stripe.elements();
  var cardElement = elements.create('card', {hidePostalCode: true,style: style});
  cardElement.mount('#add-card-element');
  cardElement.addEventListener('change', function(event) {
      var displayError = document.getElementById('add-card-errors');
      if (event.error) {
          displayError.textContent = event.error.message;
      } else {
          displayError.textContent = '';
      }
  });
  var cardholderName = document.getElementById('name_on_card');
  var clientSecret = '<?php echo $clientSecret;?>'
  var form = document.getElementById("addcardsform");
  form.addEventListener("submit", function(event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/getclinicstripeclientsecret')}}",
      data: 
      {"_token": "{{ csrf_token() }}"},
      dataType : 'json',
      success: function(data) {
        if(data.success==1){
          var clientSecret = data.clientSecret;
          stripe.confirmCardSetup(
            clientSecret,
            {
              payment_method: {
                card: cardElement
              },
            }
          ).then(function(result) {
            console.log(result);
            if (result.error) {
              var errorElement = document.getElementById('new-card-errors');
              errorElement.textContent = result.error.message;
              $("#add-card-errors").show();
              $("#cardvalid").val('');
            } else {
              $("#cardvalid").val('1');
              stripeTokenHandler(result.setupIntent.payment_method,result.setupIntent.id);
            }
          });
        }
        }
    });
  });
  function stripeTokenHandler(token,setupIntentID) {
      var form = document.getElementById('addcardsform');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token);
      form.appendChild(hiddenInput);
      var hiddenInput1 = document.createElement('input');
      hiddenInput1.setAttribute('type', 'hidden');
      hiddenInput1.setAttribute('name', 'setupintentid');
      hiddenInput1.setAttribute('id', 'setupintentid');
      hiddenInput1.setAttribute('value', setupIntentID);
      form.appendChild(hiddenInput1);
      if($("#addcardsform").valid()){
          submitCard();
      }
  }
  function addCard(){
        $("#enableAddon").modal('hide');
        $("#addCard").modal('show');
    }
  </script>
@endsection