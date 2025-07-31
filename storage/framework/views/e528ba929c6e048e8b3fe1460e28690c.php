<h4 class="text-center fw-medium mb-0 ">Add New Doctor</h4>
<small class="gray">Please enter the doctor's details</small>
<div class="import_section add_img">
    <a onclick="importDoctor()" href="javascript:void(0)"
        class="btn btn-outline-primary d-flex align-items-center"><span
            class="material-symbols-outlined me-1">upload_2</span>Import Data</a>
</div>

<form method="POST" id="doctorform">
    <?php echo csrf_field(); ?>
    <div class="row">

        <div class="create-profile">
            <div class="profile-img position-relative">
                <img id="doctorimage" src="<?php echo e(asset('images/default_img.png')); ?>" class="img-fluid">
                <a href="<?php echo e(url('crop/doctor')); ?>" id="upload-img" class="aupload"><img id="doctorimg"
                        src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" style="display:none;"
                    onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

            </div>



            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="doctorname" name="doctorname">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCode" name="countrycode" value='US'>
                </div>
                <i class="material-symbols-outlined me-2">call</i>
                <input type="text" class="form-control phone-number" id="phone_number" name="phone_number"
                    placeholder="Phone Number">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">id_card</i>
                <select name="designation" id="designation" class="form-select">
                    <option disabled selected>Select a designation</option>
                    <?php if(!empty($designation)): ?>
                        <?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dgn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($dgn['id']); ?>"><?php echo e($dgn['name']); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Qualification</label>
                <i class="material-symbols-outlined">school</i>
                <input type="text" class="form-control" id="qualification" name="qualification">
            </div>
        </div>
        <!-- <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Specialty</label>
                <i class="material-symbols-outlined">workspace_premium</i>
                <input type="text" class="form-control" id="speciality" name="speciality">
              </div>
        </div> -->

        <div class="col-12 col-lg-6">
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="speciality" id="speciality" class="form-select">
                    <option value="">Select a Specialty</option>
                    <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($specialty->id); ?>"><?php echo e($specialty->specialty_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>


    </div>


</form>

<div class="btn_alignbox justify-content-end mt-2">
    <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal"
        data-bs-target="#loader">Close</a>
    <a href="javascript:void(0)" id="submitdoctr" onclick="submitDoctor()" class="btn btn-primary">Submit</a>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<script type="text/javascript">

    function doctorImage(imagekey, imagePath) {
        $("#tempimage").val(imagekey);
        $("#doctorimage").attr("src", imagePath);
        $("#doctorimage").show();
        $("#upload-img").hide();
        $("#removelogo").show();
    }

    function removeImage() {

        $("#doctorimage").attr("src", "<?php echo e(asset('images/default_img.png')); ?>");
        $("#isremove").val('1');
        $("#removelogo").hide();
        $("#upload-img").show();

    }
    $(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });

    $(document).ready(function () {
        var telInput = $("#phone_number"),
            countryCodeInput = $("#countryCode"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");

        // initialise plugin
        telInput.intlTelInput({
            autoPlaceholder: "polite",
            initialCountry: "us",
            formatOnDisplay: true, // Enable auto-formatting on display
            autoHideDialCode: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",
            preferredCountries: ['us', 'in'],
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
            countryCodeInput.val(countryData.iso2);
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



        $("#doctorform").validate({
            rules: {
                doctorname: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                    // customemail: true,
                    remote: {
                        url: "<?php echo e(url('/validateemail')); ?>",
                        data: {
                            'type': 'other',
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                },
                designation: {
                    required: true,
                },
                speciality: {
                    required: true,
                },
                qualification: {
                    required: true,
                },
                phone_number: {
                    required: true,
                    maxlength: 13,
                    number: true,
                    remote: {
                        url: "<?php echo e(url('/validatephone')); ?>",
                        data: {
                            'type': 'other',
                            'countryCode': function () {
                                return $("#countryCode").val(); // Get the updated value
                            },
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                },


            },
            messages: {
                phone_number: {
                    required: 'Please enter your phone number.',
                    minlength: 'Please enter a valid number.',
                    maxlength: 'Please enter a valid number.',
                    number: 'Please enter a valid number.',
                    remote: "Phone number already exists in the system."
                },
                doctorname: {
                    required: 'Please enter your name.',
                },
                email: {
                    required: 'Please enter your email.',
                    email: "Please enter a valid email",
                    remote: "Email id already exists in the system."
                },
                designation: {
                    required: 'Please select your designation.',
                },
                speciality: {
                    required: 'Please select your speciality.',
                },
                qualification: {
                    required: 'Please enter your qualification.',
                }
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("phone-number")) {
                    // Remove previous error label to prevent duplication
                    $("#phonenumber-error").remove();
                    // Insert error message after the correct element
                    error.insertAfter(".separate-dial-code");
                } else {
                    error.insertAfter(element);
                }
            },
            success: function (label) {
                // If the field is valid, remove the error label
                label.remove();
            }
        });
    });
</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/doctors/create.blade.php ENDPATH**/ ?>