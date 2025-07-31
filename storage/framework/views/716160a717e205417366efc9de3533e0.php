<?php $__env->startSection('title', 'Profile'); ?>
<?php $__env->startSection('content'); ?>


<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">


            <div class="col-xl-8 col-12  mb-3">
                <div class="web-card user-card h-100 mb-3 p-0 overflow-hidden">
                    <!-- <img src="<?php echo e($clinic['banner_img']); ?>" alt=""> -->
                    <img class="banner-img" src="<?php echo e($clinic['banner_img'] ?? asset('images/default banner.png')); ?>"
                        alt="">
                    <div class="profileData view_profile py-0">
                        <div class="row align-items-center h-100">
                            <div class="col-12 mb-2">
                                <div class="text-lg-start text-center">
                                    <img src="<?php echo e($clinic['logo'] ?? asset('images/default_img.png')); ?>" class="user-img "
                                        alt="">
                                </div>
                            </div>
                            <div class="col-xl-4 col-5">
                                <div class="user_details text-start">
                                    <h5 class="fw-medium dark mb-0 mt-2"><?php echo e($clinic->name ?? "N/A"); ?></h5>
                                    <p><?php echo e($clinic->email ?? "N/A"); ?></p>
                                </div>
                            </div>
                            <div class="col-7 col-xl-8 mx-auto">
                                <div class="d-flex justify-content-center justify-content-xl-end">
                                    <div class="btn_alignbox">
                                        <?php if(!empty($clinic->website_link)): ?>
                                            <a href="<?php echo e($clinic->website_link ? (Str::startsWith($clinic->website_link, ['http://', 'https://']) ? $clinic->website_link : 'http://' . $clinic->website_link) : '#'); ?>"
                                                target="_blank"
                                                class="btn btn-outline d-flex align-items-center gap-1"><span
                                                    class="material-symbols-outlined">language</span>
                                                <p class="mb-0"><?php echo e($clinic->website_link ?? " "); ?></p>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(session()->get('user.userType') == 'clinics'): ?>
                                        <a class="btn opt-btn" data-bs-toggle="modal" data-bs-dismiss="modal"
                                            data-bs-target="#editProfileInfo">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="col-xl-4 col-12 mb-3">
                <div class="web-card user-card h-100 mb-3">
                    <div class="detailsList cardList">
                        <h5 class="fw-medium">Contact</h5>
                        <hr>

                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Phone Number</h6>
                            <p>
                                <?php echo e($clinicCountryCode->country_code ?? "N/A"); ?> <?php echo e(' '); ?>  <?php echo e($clinic->phone_number ?? "N/A"); ?>

                            </p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Address</h6>
                            <p>
                                <?php $corefunctions = new \App\customclasses\Corefunctions;
                                $address = $corefunctions->formatAddress($clinic); ?>
                                <?php echo $address; ?>

                            </p>
                        </div>
                        <!-- <div class="d-flex align-items-center justify-content-end gap-1">
                            <span class="material-symbols-outlined text-decoration-none">distance</span><a href=""
                                class="fw-medium primary text-decoration-underline" data-bs-toggle="modal"
                                data-bs-dismiss="modal" data-bs-target="#directionModal">Get Directions</a>
                        </div> -->
                    </div>
                </div>
            </div>


            <div class="col-12 mb-xl-5 mb-3 order-1 order-xl-0">
                <div class="web-card h-100">
                    <div class="col-12">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-about-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-about" type="button" role="tab" aria-controls="pills-about"
                                    onclick="tabContent('about')" aria-selected="true">About</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-gallery-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-gallery" type="button" role="tab"
                                    aria-controls="pills-gallery" onclick="tabContent('gallery')"
                                    aria-selected="false">Gallery</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-userinfo-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-userinfo" type="button" role="tab"
                                    aria-controls="pills-userinfo" onclick="tabContent('user_info')"
                                    aria-selected="false">User Details</button>
                            </li>
                            <!-- <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-reviews-tab" data-bs-toggle="pill"
                                    data-bs-target="#pills-reviews" type="button" role="tab"
                                    aria-controls="pills-reviews" aria-selected="false">Reviews</button>
                            </li> -->
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
                                            <img src="<?php echo e(asset('images/patient1.png')); ?>">
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
                                            <img src="<?php echo e(asset('images/patient7.png')); ?>">
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
                                                <img src="<?php echo e(asset('images/healthcrestpro.png')); ?>">
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


<div class="modal login-modal fade" id="editProfileInfo" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close" class="close-modal"><span
                        class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="text-center fw-medium mb-0">Edit Profile</h4>
                    <small>Update your profile information</small>
                </div>

                <form id="edit_profile_form" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="clinic_uuid" value="<?php echo e($clinic->clinic_uuid); ?>">

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <label >Logo</label>
                            <div id="logodiv" class="dropzone-wrapper mb-3"  style="<?php echo e($clinic['logo'] != asset('images/default_img.png') ? 'display:none' : ''); ?>" >
                                <a href="<?php echo e(url('crop/clinic_logo')); ?>" id="upload-img"
                                    class="aupload  gray fw-medium d-flex justify-content-end" data-toggle="modal"><span
                                        class="material-symbols-outlined"> add </span>Add Clinic Logo</a>
                            </div>
                            <div class="files-container profile-files-container mb-3">

                                <div class="fileBody profliefileBody" id="cliniclogoimage"
                                    style="<?php echo e($clinic['logo'] == asset('images/default_img.png') ? 'display:none' : ''); ?>">
                                    <div class="file_info">
                                        <img src="<?php echo e($clinic['logo']); ?>" id="clinicimage" name="clinicimage">
                                        <?php
                                            $filePath = $clinic['logo']; // Replace this with your variable
                                            $fileInfo = pathinfo($filePath);
                                        ?>

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
                        <div class="col-md-6">
                            <label >Banner</label>
                            <div class="dropzone-wrapper mb-3" id="bannerdiv" style="<?php echo e($clinic['banner_img'] != asset('images/default banner.png') ? 'display:none' : ''); ?>" >
                                <a href="<?php echo e(url('crop/clinic_banner')); ?>" id="clinic_banner_img"
                                    class=" aupload gray fw-medium d-flex justify-content-end"><span
                                        class="material-symbols-outlined"> add </span>Add Clinic Banner</a>
                            </div>
                            <div class="files-container profile-files-container mb-3">
                                <div class="fileBody" id="clinicbannerimage"
                                    style="<?php echo e($clinic['banner_img'] == asset('images/default banner.png') ? 'display:none' : ''); ?>">
                                    <div class="file_info">
                                        <img src="<?php echo e($clinic['banner_img']); ?>" id="clinic_banner" name="clinic_banner">
                                        <?php
                                            $filePath = $clinic['banner_img']; // Replace this with your variable
                                            $fileInfo = pathinfo($filePath);
                                        ?>

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



                        <div class="col-md-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Clinic's Name</label>
                                <i class="material-symbols-outlined">home_health</i>
                                <input type="text" name="name" value="<?php echo e($clinic->name); ?>" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Email</label>
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" value="<?php echo e($clinic->email); ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Phone</label>

                                <div class="country_code phone">
                                    <input type="hidden" id="countryCode" name="countrycode"
                                        value="<?php echo e($clinicCountryCode->country_code ?? '+1'); ?>">
                                    <input type="hidden" name="countryCodeShort" class="form-control"
                                        id="countryCodeShorts" value="<?php echo e($clinicCountryCode->short_code ?? 'us'); ?>">
                                </div>

                                <input id="phone" data-url="<?php echo e(route('clinic.checkPhoneExist')); ?>" name="phone"
                                    type="text"
                                    value="<?php echo e(optional($clinicCountryCode)->country_code . $clinic->phone_number ?? ''); ?>"
                                    data-uuid="" class="form-control" placeholder="Phone Number">
                            </div>

                        </div>


                        <div class="col-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Website</label>
                                <i class="material-symbols-outlined">language</i>
                                <input type="text" name="website_link" value="<?php echo e($clinic->website_link ?? ""); ?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Address</label>
                                <i class="material-symbols-outlined">home</i>
                                <input type="text" name="address" value="<?php echo e($clinic->address ?? " "); ?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">City</label>
                                <i class="material-symbols-outlined">location_city</i>
                                <input type="text" name="city" value="<?php echo e($clinic->city); ?>" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-outline select-outline mb-4">
                                <label for="input" class="float-label">State</label>
                                <i class="material-symbols-outlined">map</i>
                                <select name="state_id" id="state_id" class="form-select">
                                    <option value="">State</option>
                                    <?php if(!empty($states)): ?>
                                        <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($state['id']); ?>" <?php echo e($clinic['state_id'] == $state['id'] ? 'selected' : ''); ?>><?php echo e($state['state_prefix']); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>



                        <div class="col-md-4">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">ZIP</label>
                                <i class="material-symbols-outlined">home_pin</i>
                                <input type="text" name="zip_code" class="form-control" value="<?php echo e($clinic['zip_code']); ?>">
                            </div>
                        </div>
                        <div class="btn_alignbox justify-content-end mt-4">
                            <a class="btn btn-outline-primary close-modal" data-bs-dismiss="modal"
                                aria-label="Close">Close</a>
                            <button type="button" onclick="updateProfile()" class="btn btn-primary" id="update_btn">Save
                                Changes</button>
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

                <form id="edit_user_profile_form" method="post">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="clinic_uuid" value="<?php echo e($clinic->clinic_uuid); ?>">

                    <div class="row mt-4">

                        <div class="col-md-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">User Name</label>
                                <i class="material-symbols-outlined">home_health</i>
                                <input type="text" name="name" value="<?php echo e($clinic->clinicUsers->name); ?>"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Email</label>
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" value="<?php echo e($clinic->clinicUsers->email); ?>"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Phone</label>

                                <div class="country_code phone">

                                    <input type="hidden" id="countryCodeEdit" name="countrycode_edit"
                                        value="<?php echo e($countryCode->country_code ?? '+1'); ?>">

                                    <input type="hidden" id="countryCodeShortEdit" name="countryCodeShort"
                                        value="<?php echo e($countryCode->short_code ?? 'us'); ?>">
                                </div>

                                <input id="phone_number" data-url="<?php echo e(route('clinic.checkPhoneExist')); ?>"
                                    name="phone_number" type="text"
                                    value="<?php echo e(optional($countryCode)->country_code . (optional($clinic->clinicUsers)->phone_number ?? '')); ?>"
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
                <form method="post" id="doc_form">
                    <div class="dropzone-wrapper mb-4 dropzone custom-dropzone" id="patientDocs"></div>
                    <div id="img_div">
                        <div class="file_info" id="appenddocsmodal"></div>
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
            <form method="post" id="save_about_form" action="<?php echo e(route('frontend.noteUpdate')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <textarea name="notes" id="notes"
                        class="form-control  tinymce-editor tinymce_notes"><?php echo e($clinic['about']); ?></textarea>
                    <input type="hidden" id="has_notes" name="has_notes">
                    <div class="btn_alignbox justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                        <button type="button" onclick="saveAbout()" class="btn btn-primary">Update</button>
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


<script>
    var loader = "<?php echo e(asset('images/loader.gif')); ?>";
</script>
<script>

    $(document).ready(function () {
        tabContent('about');
        initiateEditorwithSomeMainPlugin('notes');
    });


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
                xhr.open('POST', '<?php echo e(URL::to("/editorupload")); ?>');
                var token = '<?php echo e(csrf_token()); ?>';
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
        var uuid = '<?php echo e($clinic->clinic_uuid); ?>';
        var email = '<?php echo e($clinic->email); ?>';
        var urlmail = "<?php echo e(route('clinic.checkMailExist')); ?>";
        var urlphone = "<?php echo e(route('clinic.checkPhoneExist')); ?>";



        //Validation
        form.validate({

            rules: {
                name: "required",
                address: "required",
                city: "required",
                state_id: "required",
                zip_code: {
                    required: true,
                    digits: true,
                    maxlength: 5,
                    minlength: 4,
                },
                email: {
                    required: true,
                    email: true,
                    regex: true,
                    remote: {
                        url: urlmail,
                        data: {
                            _token: $("input[name=_token]").val(),
                            clinic_uuid: uuid,
                        },
                        type: "post",
                    },
                },
                phone: {
                    required: true,
                    digits: true,
                    remote: {
                        url: urlphone,
                        data: {
                            _token: $("input[name=_token]").val(),
                            clinic_uuid: uuid,
                        },
                        type: "post",
                    },
                    maxlength: 10,
                    minlength: 10
                },
                website_link: {

                    webLink: true,
                },


            },
            messages: {
                name: "Please enter clinic name",
                email: {
                    required: "Please enter your email address",
                    email: "Please enter a valid email address",
                    regex: "Please enter a valid email address",
                    remote: "Email already exist",
                },
                phone: {
                    required: "Please enter phone number",
                    digits: "Please enter a valid phone number",
                    remote: "This phone number is already in use",
                    maxlength: "Maximum digits allowed is 10",
                    minlength: "Minimum digits allowed is 10",
                },
                zip_code: {
                    required: "Please enter zip code",
                    digits: "Please enter a valid zip code",
                    maxlength: "Please enter a valid zip code",
                    minlength: "Please enter a valid zip code",
                },

                address: "Please enter address",
                city: "Please enter city",
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


    function updateProfile() {


        var form = $('#edit_profile_form');
        var url = "<?php echo e(route('clinic.updateProfile')); ?>";
        var formData = $('#edit_profile_form').serialize();


        if (form.valid()) {
            var submitButton = $("#update_btn");
            submitButton.prop("disabled", true);
            submitButton.text("Submitting...");
        }

        if (form.valid()) {

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    'formData': $('#edit_profile_form').serialize(),
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    swal(
                        "Success!",
                        response.message,
                        response.status,
                    ).then((e) => {
                        event.preventDefault();
                        // Refresh the page when the appointment clicks OK or closes the alert
                        console.log(response);
                        window.location.href = response.redirect;

                    });
                },
                error: function (xhr, status, error) {
                    if (xhr.status === 0) {
                        // Request was cancelled
                        console.log("Request was cancelled");
                    } else {
                        swal(
                            "Error!",
                            "Error updating clinic",
                            "error"
                        );
                    }
                },
            });



        }

    }

    // var urlmail = "{ url('/frontend/checkEmailExist') }}";
    // var urlphone = "{route('clinic.checkPhoneExist', ['type' => 'userUpdate'])}}";
    var clinicID = '<?php echo e($clinic->id); ?>';
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
                        url: "<?php echo e(url('/frontend/checkEmailExist')); ?>",
                        data: {
                        'type': 'clinicUser',
                        'uuid': "<?php echo e($clinic->clinicUsers->clinic_user_uuid); ?>",
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
                digits: true,
                remote: {
                            url: "<?php echo e(url('/frontend/checkPhoneExist')); ?>",

                            data: { 
                                'type': 'clinicUser',
                                'uuid': "<?php echo e($clinic->clinicUsers->clinic_user_uuid); ?>",
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
                        },
                maxlength: 10,
                minlength: 10
            }


        },
        messages: {
            name: "Please enter clinic name",
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                regex: "Please enter a valid email address",
                remote: "Email already exist",
            },
            phone_number: {
                required: "Please enter phone number",
                digits: "Please enter a valid phone number",
                remote: "This phone number is already in use",
                maxlength: "Maximum digits allowed is 10",
                minlength: "Minimum digits allowed is 10",
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
        var url = "<?php echo e(route('clinic.updateUserProfile')); ?>";

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
                    if (response.status == 'success') {
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
                error: function (xhr, status, error) {
                    if (xhr.status === 0) {
                        // Request was cancelled
                        console.log("Request was cancelled");
                    } else {
                        swal(
                            "Error!",
                            "Error updating clinic",
                            "error"
                        );
                    }
                },
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

    // initialise plugin
    telInput.intlTelInput({
        autoPlaceholder: "polite",
        initialCountry: "us",
        formatOnDisplay: false, // Enable auto-formatting on display
        autoHideDialCode: true,
        defaultCountry: "auto",
        ipinfoToken: "yolo",
        preferredCountries: ['us'],
        nationalMode: false,
        numberType: "MOBILE",
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


    // Similar setup for WhatsApp input
    userInput.intlTelInput({
        autoPlaceholder: "polite",
        initialCountry: "us",
        formatOnDisplay: false,
        autoHideDialCode: true,
        defaultCountry: "auto",
        preferredCountries: ['us', 'in'],
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





    function tabContent(type) {
        var url = "<?php echo e(route('clinic.tabContent')); ?>";
        $("#pills-tabContent").html('<div class="d-flex justify-content-center py-5"><img src="' + '<?php echo e(asset('images/loader.gif')); ?>' + '" width="250px"></div>');
        $.ajax({
            url: url,
            type: "post",
            data: {
                'type': type,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    $('#pills-tabContent').html(data.view);

                }
            },
            error: function (xhr, status, error) {
                if (xhr.status === 0) {
                    // Request was cancelled
                    console.log("Request was cancelled");
                } else {
                    swal("Error!", "Something went wrong", "error");
                    console.log(error);

                }
            },
        });
    }


    function createBusinessHours() {
        var url = "<?php echo e(route('clinic.businessHoursCreate')); ?>";
        $("#business_hours_modal").html('<div class="d-flex justify-content-center py-5"><img src="' + '<?php echo e(asset('images/loader.gif')); ?>' + '" width="250px"></div>');

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
            error: function (xhr, status, error) {
                if (xhr.status === 0) {
                    // Request was cancelled
                    console.log("Request was cancelled");
                } else {
                    swal("Error!", "Something went wrong", "error");
                    console.log(error);

                }
            },
        });

    }


    function saveAbout() {

        var url = "<?php echo e(route('clinic.saveAbout')); ?>";

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
                swal(
                    "Success!",
                    response.message,
                    'success',
                ).then(() => {

                    // Refresh the page when the appointment clicks OK or closes the alert
                    console.log(response);
                    window.location.reload();

                });
            },
            error: function (xhr, status, error) {
                if (xhr.status === 0) {
                    // Request was cancelled
                    console.log("Request was cancelled");
                } else {
                    swal(
                        "Error!",
                        "Something went wrong",
                        "error"
                    );
                }
            },
        });

    }

    Dropzone.autoDiscover = false;
    // Dropzone Configurations
    var dropzone = new Dropzone('#patientDocs', {
        url: "<?php echo e(url('/clinic/upload-document')); ?>",
        addRemoveLinks: true,
        dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span>Upload Gallery Images', // Add class for styling
        headers: {
            'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
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
            var filecount = 1;
            this.on('success', function (file, response) {
                console.log(response);

                if (response.success == 1) {

                    this.removeFile(file);
                    file.filecnt = filecount;

                    var appnd = '<div class="fileBody" id="doc_' + filecount + '"><div class="file_info"><img src="' + response.tempdocpath + '"><span>' + response.docname + '</span>' +
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

        var url = "<?php echo e(route('clinic.storeGalleryImage')); ?>";
        var docLength = $('#doc_form').find('.fileBody').length;

        // if (docLength > 0) {

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
            }
        });
        // } else {
        //     $('#save_doc_btn').prop('disabled', true);
        // }
    }


    function removeGalleryImage(uuid, event) {
        event.preventDefault();
        var url = "<?php echo e(route('clinic.removeGalleryImage')); ?>";

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
                            }).then((willDelete) => {
                                // window.location.href = "url('medical-history')}}";
                                tabContent('gallery');
                            })
                        }
                    }
                });
            }
        });

    }

    document.getElementById('appointmentDoc').addEventListener('hidden.bs.modal', function () {
        
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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/clinics/view-profile.blade.php ENDPATH**/ ?>