<h4 class="text-center fw-bold mb-0 ">Add New Patient</h4>
<small class="gray">Please enter the patient’s details</small>


<form id="patientform" method="POST">
  <?php echo csrf_field(); ?>

  <div class="create-profile">
    <div class="profile-img position-relative">
      <img id="patientimage" src="<?php echo e(asset('images/default_img.png')); ?>" class="img-fluid">
      <a href="<?php echo e(url('crop/patient')); ?>" id="upload-img" class="aupload"><img id="patientimg"
          src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid" data-toggle="modal"></a>
      <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" style="display:none;"
        onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

    </div>



    <input type="hidden" id="tempimage" name="tempimage" value="">
    <input type="hidden" name="isremove" id="isremove" value="0">
  </div>

  <div class="row">
  <div class="col-lg-6 col-12">
      <div class="form-group form-outline select-outline mb-4">
        <i class="material-symbols-outlined">id_card</i>
        <select name="clinic" id="clinic" class="form-select">
          <option value="">Select a clinic</option>
          <?php $__currentLoopData = $clinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $clinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($clinic->id); ?>"><?php echo e($clinic->name); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
      </div>
     
    </div>

    <div class="col-lg-6">
      <div class="form-group form-outline mb-4">
        <label for="input" class="float-label">Name</label>
        <i class="fa-solid fa-circle-user"></i>
        <input type="text" name="name" class="form-control" id="exampleFormControlInput1">
      </div>
    </div>

    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="email" class="float-label">Email</label>
        <i class="fa-solid fa-envelope"></i>
        <input type="email" name="email" id="email" class="form-control">
      </div>
    </div>

    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="dob" class="float-label">Date of Birth</label>
        <i class="material-symbols-outlined">date_range</i>
        <input type="text" name="dob" id="dob" class="form-control">
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline select-outline mb-4">
        <i class="material-symbols-outlined">id_card</i>
        <select name="gender" id="gender" class="form-select">
          <option value="">Select Gender</option>
          <option value="1">Male</option>
          <option value="2">Female</option>
          <option value="3">Other</option>

        </select>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline phoneregcls mb-4">
        <div class="country_code phone">
          <input type="hidden" id="clinicID" value="">
          <input type="hidden" id="countryCodes" name="countrycode" value='+1'>
          <input type="hidden"  name="countryCodeShort" class="form-control" id="countryCodeShorts" value="us">
          <input type="hidden" name="countryId" class="form-control" id="countryId">
        </div>
        <!-- <label for="phone" class="float-label">Phone Number</label> -->
        <i class="material-symbols-outlined me-2">call</i>
        <input type="text" data-clinic="" placeholder="Phone Number" name="phone_number" class="form-control phone-number" id="phone">
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline phoneregcls mb-4">
        <div class="country_code phone">
          <input type="hidden" id="whatsappcountryCode" name="whatsappcountryCode" value='+1'>
          <input type="hidden" id="whatsappcountryCodeShorts" name="whatsappcountryCodeShorts" value='us'>
        </div>
        <!-- <label for="whatsapp" id="whatapplabel" class="float-label">Whatsapp</label> -->
        <i class="fa-brands fa-whatsapp me-2"></i>
        <input type="text" name="whatsapp_num" placeholder="Whatsapp Number" class="form-control" id="whatsapp">
      </div>
    </div>

    <div class="col-lg-4 col-12">
      <div class="form-group form-outline mb-4">
        <label for="address" class="float-label">Address</label>
        <i class="material-symbols-outlined">home</i>
        <input type="text" name="address" id="address" class="form-control">
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="city" class="float-label">City</label>
        <i class="material-symbols-outlined">location_city</i>
        <input type="text" name="city" class="form-control" id="city">
      </div>
    </div>
    <div id="statesel" class="col-lg-4" style="display:none;">
      <div class="form-group form-outline mb-4">
        <label for="state" class="float-label">State</label>
        <i class="material-symbols-outlined">map</i>
        <input type="text" name="state" class="form-control" id="state">
      </div>
    </div>

    <div id="statelist" class="col-lg-4" style="display:block;">
      <div class="form-group form-outline select-outline mb-4">
        <i class="material-symbols-outlined">id_card</i>
        <select name="state_id" id="state_id" class="form-select">
          <option value=''>Select a state</option>
          <?php if(!empty($state)): ?>

        <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($sts['id']); ?>"><?php echo e($sts['state_prefix']); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
        </select>
      </div>
    </div>


    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="zip" class="float-label">Zip</label>
        <i class="material-symbols-outlined">home_pin</i>
        <input type="text" name="zip" class="form-control" id="zip">
      </div>
    </div>

   

    <div class="col-12">
      <div class="btn_alignbox justify-content-end">
        <a data-bs-dismiss="modal" onclick="$('#registerPatient').hide()" class="btn btn-outline-primary">Close</a>
        <a onclick="submitPatient()" id="submitpatient" class="btn btn-primary">Submit</a>
      </div>

    </div>
  </div>

</form>

<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>">
<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>
<script>
  $(document).ready(function () {


    var telInput = $("#phone"),
      countryCodeInput = $("#countryCodes"),
      countryCodeShort = $("#countryCodeShorts"),
      errorMsg = $("#error-msg"),
      validMsg = $("#valid-msg"),
      whatsappInput = $("#whatsapp"),
      whatsappCountryCodeInput = $("#whatsappcountryCode")
    whatsappCodeShort = $("#whatsappcountryCodeShorts");

    // Initialise plugin for phone number
    telInput.intlTelInput({
      autoPlaceholder: "polite",
      initialCountry: "us",
      formatOnDisplay: true,
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

    // Handle country change event
    telInput.on("countrychange", function (e, countryData) {

      var countryShortCode = countryData.iso2;
      countryCodeShort.val(countryShortCode);
      countryCodeInput.val(countryData.dialCode);
      if ($('#countryCodes').val() == 1) {
        $("#statelist").show();
        $("#statesel").hide();
      } else {
        $("#statelist").hide();
        $("#statesel").show();
      }
      // If checkbox is checked, update WhatsApp country code too
      if ($("#iswhatsapp").is(':checked')) {
        whatsappCountryCodeInput.val(countryData.dialCode);
      }
    });

    // Reset error messages
    var reset = function () {
      telInput.removeClass("error");
      errorMsg.addClass("hide");
      validMsg.addClass("hide");
    };

    // Validate phone number
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

    // Similar setup for User input
    whatsappInput.intlTelInput({
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

    whatsappInput.on("countrychange", function (e, countryData) {
      var countryShortCode = countryData.iso2;
      whatsappCodeShort.val(countryShortCode);
      whatsappCountryCodeInput.val(countryData.dialCode);
    });

    $('#iswhatsapp').change(function () {
      if ($(this).is(':checked')) {
        var fullPhoneNumber = $('#phone').val();

        whatsappInput.val(fullPhoneNumber); // Set WhatsApp number
        var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
        whatsappInput.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
      } else {
        whatsappInput.val(''); // Clear WhatsApp input if unchecked
        whatsappCountryCodeInput.val('+1'); // Reset WhatsApp country code (optional default)
        whatsappInput.intlTelInput("setCountry", "us"); // Reset to a default country if needed
      }
    });



    $("#patientform").validate({
      rules: {
        name: {
          required: true,
        },
        email: {
          required: true,
          // customemail: true,
          remote: {
            url: "<?php echo e(url('/frontend/checkEmailExist')); ?>",
            data: {
              'type': 'clinicUser',
              'uuid': '',
              '_token': $('input[name=_token]').val(),
              'clinic_id': function () {
                    return $("#clinic").val(); 
                    }, 
              'phone_number': function () {
                    return $("#phone").val(); 
                    }, 
                'country_code': function () {
                return $("#countryCodeShorts").val(); 
                }, 
            },
            type: "post",
          },
        },
        gender: {
          required: true,
        },
        clinic: {
          required: true,
        },
        dob: {
          required: true,
        },
        phone_number: {
          required: true,
          number: true,
          maxlength: 13,
          minlength: 10,
          remote: {
            url: "<?php echo e(url('/frontend/checkPhoneExist')); ?>",
            data: { 
          
                  'type': 'clinicUser',
                  'uuid': '',
                  'clinic_id': function () {
                    return $("#clinic").val(); // Get the updated value
                    }, 
                  'country_code': function () {
                    return $("#countryCodeShorts").val(); // Get the updated value
                    }, 
                  'email': function () {
                    return $("#email").val(); // Get the updated value
                    }, 
            
                },
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
           
        },
      },
        whatsapp_num: {
          number: true,
          maxlength: 13,
          minlength: 10,
        },
        address: {
          required: true,
        },
        city: {
          required: true,
        },
        state: {
          required: {
            depends: function (element) {
              console.log($("#countryCodes").val())
              return (($("#countryCodes").val() != '+1'));

            }
          },
        },

        state_id: {
          required: {
            depends: function (element) {
              // Trim and check the country code value
              const countryCode = $.trim($("#countryCodes").val());
              console.log("Country Code:", countryCode); // Log for verification
              return (countryCode === '1' || countryCode === '+1');
            }
          }
        },
        zip: {
          required: true,
          number: true,
          maxlength: 5,
          minlength: 4,
        },
        // note: {
        //     required: true,
        // },

      },
      messages: {
        name: {
          required: 'Please enter your name.',
        },
        email: {
          required: 'Please enter your email.',
          customemail: "Please enter a valid email",
          remote: "Email already in use"
        },
        gender: {
          required: 'Please select your gender',
        },
        clinic: {
          required: 'Please select a clinic',
        },
        dob: {
          required: 'Please enter your date of birth',
        },
        phone_number: {
          required: 'Please enter your phone number',
          number: 'Please enter valid phone number',
          remote: "Phone number already exists",
          maxlength: "Please enter valid phone number",
          minlength: "Please enter valid phone number"
        },
        whatsapp_num: {

          number: 'Please enter valid phone number',
          maxlength: "Please enter valid phone number",
          minlength: "Please enter valid phone number"
        },
        address: {
          required: 'Please enter your address',
        },
        city: {
          required: 'Please enter your city',
        },
        state: {
          required: 'Please enter your state',
        },
        state_id: {
          required: 'Please select your state',
        },
        zip: {
          required: 'Please enter your zip code',
          number: 'Please enter valid zip code',
          maxlength: "Please enter valid zip",
          minlength: "Please enter valid zip"
        },
      },
      errorPlacement: function (error, element) {
        if (element.hasClass("phone-number")) {
          // Remove previous error label to prevent duplication
          $("#phonenumber-error").remove();
          // Insert error message after the correct element
          error.insertAfter(".phone-number");
        } else {
          error.insertAfter(element);
        }
      },
      success: function (label) {
        // If the field is valid, remove the error label
        label.remove();
      }
    });

    // $(document).on('change', '#clinic', function() {
    //       var phoneNumber = $('#phone').val();
    //       var clinicID=$('#clinic').val();
    //       $('#clinicID').val(clinicID);
    //       $('#patientform').validate().element("#email"); 
    //       $('#patientform').validate().element("#phone");

    // });


    // Function to manually trigger remote validation of phone number
    // function checkPhoneNumberExists(phoneNumber) {
    //     return $.ajax({
    //         url: "{ url('/frontend/checkPhoneExist') }}",
    //         type: "POST",
    //         data: {
    //           'type': 'patient',
    //             'clinic_id': $('#clinic').val(),  
    //             'phone_number': $('#phone').val(),  
    //             'country_shortCode': $('#countryCodeShorts').val(),
    //             '_token': $('input[name=_token]').val(),
    //         },
    //     });
    // }
    // // Function to manually trigger remote validation of phone number
    // function checkPhoneNumberExists(phoneNumber) {
    //     return $.ajax({
    //         url: "{ url('/frontend/checkPhoneExist') }}",
    //         type: "POST",
    //         data: {
    //           'type': 'patient',
    //             'clinic_id': $('#clinic').val(),  
    //             'phone_number': $('#phone').val(),  
    //             'country_shortCode': $('#countryCodeShorts').val(),
    //             '_token': $('input[name=_token]').val(),
    //         },
    //     });
    // }


    // $(document).on('change', '#clinic', function() {
    //   var phoneNumber = $('#phone').val();
    //   var clinicID=$('#clinic').val();
    //   $('#clinicID').val(clinicID);

    //   $('#phone').data('clinic',clinicID);

    //     if (phoneNumber.length >= 10) { // Check if the phone number has enough digits
    //         checkPhoneNumberExists(phoneNumber).done(function(response) {
    //           console.log(response);
              
    //             if (response=='false') {
    //                 // If the phone number already exists, show an error message
    //                 $('#phone').valid();
                 
    //             }else{
    //               $('#phone').valid(true);
    //             }
    //         }).fail(function(xhr, status, error) {
    //             console.log('Error checking phone number:', error);
    //         });
    //     }
    // });

    $('#dob').datetimepicker({
      format: 'MM/DD/YYYY',
      useCurrent: false,
      maxDate: new Date(), // This will allow only past dates and block future dates
     
    });


    $("#dob").on("change", function () {
      $('#dob').valid();
    });

  });



  //Image upload section
  function removeImage() {

    $("#patientimage").attr("src", "<?php echo e(asset('images/default_img.png')); ?>");
    $("#isremove").val('1');
    $("#removelogo").hide();
    $("#upload-img").show();

  }

  $(".aupload").colorbox({
    iframe: true,
    width: "650px",
    height: "650px"
  });

  function patientImage(imagekey, imagePath) {
    $("#tempimage").val(imagekey);
    $("#patientimage").attr("src", imagePath);
    $("#patientimage").show();
    $("#upload-img").hide();
    $("#removelogo").show();
  }

  //Image upload end


  function submitPatient() {

    if ($("#patientform").valid()) {
      $("#submitpatient").addClass('disabled');
      $("#submitpatient").text("Submitting...");
      $.ajax({
        url: '<?php echo e(url("frontend/patient/store")); ?>',
        type: "post",
        data: {
          'formdata': $("#patientform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (data) {
          if (data.success == 1) {
            $('#registerPatient').modal('hide');

            swal({
              title: "Success!",
              text: data.message,
              icon: "success",
              button: "OK",
              dangerMode: false,
            }).then((willClose) => {
              if (willClose) {

                window.location.reload();
              }
            });
          } else {
            swal("Error!", data.message, "error");

          }
        }
      });
    }
  }
</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/patient-create.blade.php ENDPATH**/ ?>