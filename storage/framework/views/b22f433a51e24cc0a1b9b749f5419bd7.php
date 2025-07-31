 
 <h4 class="text-center fw-medium mb-0 ">Edit  Doctor</h4>
  <!-- <small class="gray">Please enter the doctor's details</small> -->
    <div class="import_section add_img">
        <!-- <a onclick="importDoctor()" href="javascript:void(0)" class="btn btn-outline-primary d-flex align-items-center" ><span class="material-symbols-outlined me-1">add</span>Import Data</a> -->
    </div>

    <form method="POST" id="editdoctorform" >
    <?php echo csrf_field(); ?>
    <div class="row">

        <div class="create-profile">
            <div class="profile-img position-relative"> 
                <img id="doctorimage" <?php if($doctorDetails['logo_path'] !=''): ?>  src="<?php echo e(asset($doctorDetails['logo_path'])); ?>" <?php else: ?> src="<?php echo e(asset('images/default_img.png')); ?>" <?php endif; ?> class="img-fluid">
                <a  href="<?php echo e(url('crop/doctor')); ?>" id="upload-img" class="aupload"  <?php if($doctorDetails['logo_path'] !=''): ?> style="display:none;" <?php endif; ?>><img id="doctorimg"src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" <?php if($doctorDetails['logo_path'] !=''): ?> style="" <?php else: ?> style="display:none;" <?php endif; ?> onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

            </div>
            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>


        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="doctorname" name ="doctorname" value="<?php echo e($doctorDetails['name']); ?>">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo e($doctorDetails['email']); ?>">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCodes" name="countrycode" value=<?php echo e(isset($doctorDetails['short_code'])  ? $doctorDetails['short_code'] : 'us'); ?> >
                </div>
                <i class="material-symbols-outlined me-2">call</i> 
                <input type="text" class="form-control" id="phone_number_edit" name="phone_number" placeholder="Phone Number" value="<?php echo isset($doctorDetails['country_code'])  ? '+'.$doctorDetails['country_code'] . $doctorDetails['phone_number'] : $doctorDetails['phone_number'] ?>" >
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">id_card</i>
                <select name="designation" id="designation"  class="form-select">
                    <option disabled selected>Select a designation</option>
                    <?php if(!empty($designation)): ?>
                      <?php $__currentLoopData = $designation; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dgn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($dgn['id']); ?>" <?php if($doctorDetails['designation_id'] == $dgn['id']): ?> selected <?php endif; ?>><?php echo e($dgn['name']); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Qualification</label>
                <i class="material-symbols-outlined">school</i>
                <input type="text" class="form-control" id="qualification" name="qualification" value="<?php echo e($doctorDetails['qualification']); ?>">
            </div>
        </div>
        
         <div class="col-12 col-lg-6">
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="speciality" id="speciality" class="form-select">
                    <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($specialty->id); ?>" <?php echo e($doctorDetails['specialty_id'] == $specialty->id ? 'selected': ''); ?> ><?php echo e($specialty->specialty_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>


        
    </div>


  </form>
  
    <div class="btn_alignbox justify-content-end mt-2">
        <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Close</a>
        <a href="javascript:void(0)" id="updatedoctr" onclick="updateDoctor('<?php echo e($doctorDetails['clinic_user_uuid']); ?>')" class="btn btn-primary" >Submit</a>
    </div>


  <script type="text/javascript">
function doctorImage(imagekey, imagePath) {
    console.log(imagePath);
    $("#tempimage").val(imagekey);
    $("#doctorimage").attr("src", imagePath);
    $("#doctorimage").show();
    $("#upload-img").hide();
    $("#removelogo").show();
  }

    function removeImage(){

        $("#doctorimage").attr("src","<?php echo e(asset('images/default_img.png')); ?>");
        $("#isremove").val('1');
        $("#removelogo").hide();
        $("#upload-img").show();

    }
    $(".aupload").colorbox({
          iframe: true,
          width: "650px",
          height: "650px"
      });

function updateDoctor(key) {
    if ($("#editdoctorform").valid()) {
      $("#updatedoctr").addClass('disabled');
      $("#updatedoctr").text("Submitting..."); 
      $.ajax({
        url: '<?php echo e(url("/doctors/update")); ?>',
        type: "post",
        data: {
            'key' : key,
          'formdata': $("#editdoctorform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
            swal("success!",data.message, "success");
           
            window.location.reload();
          } else {
            swal("error!",data.message, "error");
          
          }
        }
      });
    }
  }
   $(document).ready(function() {
    var telInput = $("#phone_number_edit"),
                countryCodeInput = $("#countryCodes"),
                errorMsg = $("#error-msg"),
                validMsg = $("#valid-msg");

            // initialise plugin
            telInput.intlTelInput({
                autoPlaceholder: "polite",
                initialCountry: "us",
                formatOnDisplay: false, // Enable auto-formatting on display
                autoHideDialCode: true,
                defaultCountry: "auto",
                ipinfoToken: "yolo",
                preferredCountries: ['us', 'in'],
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
                countryCodeInput.val(countryData.iso2);
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



$("#editdoctorform").validate({
            rules: {
              doctorname: {
                    required: true,
                },
                email: {
                    required: true,
                    // customemail: true,
                    remote: {
                        url: "<?php echo e(url('/validateemail')); ?>",
                        data: {
                            'type' : 'other',
                            "id":"<?php echo e($doctorDetails['id']); ?>",
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
                            "id":"<?php echo e($doctorDetails['id']); ?>",
                            'type': 'other', // Replace with actual type if necessary
                            'countryCode' : function () {
                              return $("#countryCode").val(); // Get the updated value
                            },
                            '_token': $('input[name="_token"]').val() // CSRF token
                        
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
                    // customemail: "Please enter a valid email",
                    remote: "Email id already exists in the system."
                },
                designation: {
                    required: 'Please select your designation.',
                },
                speciality: {
                    required: 'Please enter your speciality.',
                },
                qualification: {
                    required: 'Please enter your qualification.',
                }
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

<script>
    
                    // Function to toggle the 'active' class


      function toggleLabel(input) {
        const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
        $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
      }
      // function toggleLabel(input) {
      //         $(input).parent().find('.float-label').toggleClass('active', $.trim(input.value) !== '');
      //       }


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
      // floating label end

  </script>
<?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/doctors/edit.blade.php ENDPATH**/ ?>