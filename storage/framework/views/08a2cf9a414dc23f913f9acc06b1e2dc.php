<h4 class="text-center fw-medium mb-0 ">Edit Nurse</h4>
<small class="gray">Please enter the nurse details</small>
<div class="import_section add_img">
    <!-- <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">add</span>Import Data</a> -->
</div>

<form id="nurse-create-form" method="post" action="<?php echo e(route('nurse.update',[$nurse->clinic_user_uuid,'type'=> $type])); ?>" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="row">

        <div class="create-profile">
            <div class="profile-img position-relative">

                <img id="nurseimage" src="<?php echo e(asset($nurse['logo_path'])); ?>" class="img-fluid">
                <a href="<?php echo e(url('crop/nurse')); ?>" id="upload-img" class="aupload" <?php if($nurse['logo_path'] !=asset("images/default_img.png") ): ?> style="display:none;" <?php endif; ?>><img id="doctorimg" src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" <?php if($nurse['logo_path'] !=asset("images/default_img.png") ): ?> style="" <?php else: ?> style="display:none;" <?php endif; ?> onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

            </div>
            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>


        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input name="name" value="<?php echo e($nurse->name); ?>" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input name="email" id="email" value="<?php echo e($nurse->email); ?>" data-url="<?php echo e(route('nurse.checkEmailExist')); ?>" data-uuid="<?php echo e($nurse->clinic_user_uuid); ?>" class="form-control">
            </div>

            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <span class=" text-danger error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <!-- 
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Phone</label>
                <i class="fa-solid fa-envelope"></i>
                <input name="phone" id="phone2" data-url="<?php echo e(route('nurse.checkPhoneExist')); ?>" type="text" value="<?php echo e($nurse->phone); ?>" class="form-control">
            </div>
        </div> -->

        <div class="col-12 col-lg-6">
            <div class="form-group form-outline phoneregcls mb-4">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCodes" name="countrycode" value=<?php echo e(isset($countryCode['short_code'])  ? $countryCode['short_code'] : 'US'); ?>>
                    <input type="hidden" id="countryCodeShort" name="countryCodeShort" value=<?php echo e(isset($countryCode['short_code'])  ? $countryCode['short_code'] : 'us'); ?>>
                </div>
                <i class="material-symbols-outlined me-2">call</i>
                <input type="text" class="form-control"  id="phone" name="phone_number" placeholder="Phone Number" value="<?php echo isset($countryCode['country_code'])  ? '+' . $countryCode['country_code'] . $nurse['phone_number'] : $nurse['phone_number'] ?>">
            </div>
        </div>

        <div class="col-12 col-lg-6">

            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Department</label>
                <i class="material-symbols-outlined">id_card</i>
                <input name="department" value="<?php echo e($nurse->department); ?>" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Qualification</label>
                <i class="material-symbols-outlined">school</i>
                <input name="qualification" value="<?php echo e($nurse->qualification); ?>" class="form-control">
            </div>
        </div>
         <div class="col-12 col-lg-6">
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="specialties" id="specialties" class="form-select">
                    <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($specialty->id); ?>" <?php echo e($nurse->specialty_id == $specialty->id ? 'selected': ''); ?> ><?php echo e($specialty->specialty_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>


    <div class="btn_alignbox justify-content-end mt-2">
        <a href="" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Close</a>
        <button id="btndisable" class="btn btn-primary">Update</button>
    </div>

</form>

<script>
    //Image Upload
    function nurseImage(imagekey, imagePath) {
        $("#tempimage").val(imagekey);
        $("#nurseimage").attr("src", imagePath);
        $("#nurseimage").show();
        $("#upload-img").hide();
        $("#removelogo").show();
    }

    function removeImage() {

        $("#nurseimage").attr("src", "<?php echo e(asset('images/default_img.png')); ?>");
        $("#isremove").val('1');
        $("#removelogo").hide();
        $("#upload-img").show();

    }

    $(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });

    $(document).ready(function() {

        var telInput = $("#phone"),
            countryCodeInput = $("#countryCodes"),
            countryCodeShort = $("#countryCodeShort"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");

        // Get the initial country code from the hidden input
        var initialCountryCode = $("#countryCodes").val();




        // initialise plugin
        telInput.intlTelInput({
            autoPlaceholder: "polite",
            // initialCountry: initialCountryCode.replace('+', ''), // Strip the '+' for the initialCountry
            initialCountry: "us",

            formatOnDisplay: false, // Enable auto-formatting on display
            autoHideDialCode: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",
            preferredCountries: ['us'],
            nationalMode: false,
            numberType: "MOBILE",
            separateDialCode: true,
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Ensure latest version
        });

        var reset = function() {
            telInput.removeClass("error");
            errorMsg.addClass("hide");
            validMsg.addClass("hide");
        };

        telInput.on("countrychange", function(e, countryData) {
            var countryShortCode = countryData.iso2;
                countryCodeInput.val(countryData.iso2);
                countryCodeShort.val(countryShortCode);
        });

        telInput.blur(function() {
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

    });
    $(document).ready(function() { 
$("#nurse-create-form").validate({
            rules: {
            name: "required",
            email: {
                    required: true,
                    email: true,
                    // customemail: true,
                    remote: {
                        url: "<?php echo e(url('/validateemail')); ?>",
                        data: {
                            'type' : 'other',
                            "id":"<?php echo e($nurse->id); ?>",
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                },
             phone_number: {
                    required: true,
                    maxlength: 13,
                    number: true,
                    remote: {
                        url: "<?php echo e(url('/validatephone')); ?>",
                        data: {
                            'type' : 'other',
                            "id":"<?php echo e($nurse->id); ?>",
                            'country_code' : function () {
                              return $("#countryCode").val(); // Get the updated value
                            },
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                },
            department: "required",
            qualification: "required",
            specialties: "required",
        },
        messages: {
            name: "Please enter name",
            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                regex: "Please enter a valid email address",
                remote: "Email already exist",
            },
            phone_number: {
                        required: 'Please enter your phone number.',
                        minlength: 'Please enter a valid number.',
                        maxlength: 'Please enter a valid number.',
                        number: 'Please enter a valid number.',
                        remote: "Phone number already exists in the system." 
                    },
            department: "Please enter department",
            qualification: "Please enter qualification",
            specialties: "Please enter specialty",
        },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-number")) {
                    // Remove previous error label to prevent duplication
                    $("#phonenumber-error").remove(); 
                    // Insert error message after the correct element
                    error.insertAfter(".separate-dial-code");
                } else {
                    error.insertAfter(element);
                }
            },
            success: function(label) {
                // If the field is valid, remove the error label
                label.remove();
            }
        });
      });
</script>

<script src="<?php echo e(asset('js/placeholderPosition.js')); ?>"></script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/nurses/edit.blade.php ENDPATH**/ ?>