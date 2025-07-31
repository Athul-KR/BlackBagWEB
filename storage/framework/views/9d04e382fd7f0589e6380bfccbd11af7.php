<h4 class="text-center fw-medium mb-0">Enter Clinic Details</h4>
<small class="gray">Provide your clinic's information to proceed.</small>

<form method="POST" id="registerform">
  <?php echo csrf_field(); ?>

  <div class="row mt-4">


    <div class="col-12">
      <div class="form-group form-outline mb-4">
        <label for="clinic_name" class="float-label">Clinic Name</label>
        <i class="material-symbols-outlined">home_health</i>
        <input type="text" name="clinic_name" class="form-control" id="clinic_name">
      </div>
    </div>

    <div class="col-md-6 col-12">
      <div class="form-group form-outline mb-4">
        <label for="input" class="float-label">Email</label>
        <i class="fa-solid fa-envelope"></i>
        <input type="email" class="form-control" name="email" id="email">
      </div>
    </div>
    <div class="col-md-6 col-12">

      <div class="form-group form-outline phoneregcls mb-4">
        <div class="country_code phone">
          <input type="hidden" id="cliniccountryCode1" name="clinic_countrycode" value='+1'>
          <input type="hidden" name="clinic_countryCodeShort" id="clinic_countryCodeShorts" value="us">

        </div>
        <i class="material-symbols-outlined me-2">call</i>
        <input type="text" name="phone_number" class="form-control phone-numberregister" id="clinic_phone_number"
          placeholder="Enter clinic phone number" required>

      </div>
    </div>

    <div class="col-md-6 col-12">
      <div class="form-group form-outline mb-4">
          <label for="address" class="float-label">Address</label>
          <i class="material-symbols-outlined">home</i>
          <input type="text" name="address" class="form-control" id="address">
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-group form-outline select-outline mb-4">
        <i class="material-symbols-outlined">public</i>
        <select name="country_id" id="country_id" data-tabid="basic" onchange="stateUS()" class="form-select">
          <option value="">Country</option>

          <?php if(!empty($countryDetails)): ?>
          <?php $__currentLoopData = $countryDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cds => $cd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <option value="<?php echo e($cd['id']); ?>" <?php echo e($cd['id'] == 185 ? 'selected' : ''); ?>><?php echo e($cd['country_name']); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        </select>
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-group form-outline mb-4">
        <label for="city" class="float-label">City</label>
        <i class="material-symbols-outlined">location_city</i>
        <input type="text" name="city" class="form-control" id="city">
      </div>
    </div>
      <div class="col-md-4" id="state">
        <div class="form-group form-outline select-outline mb-4">
          <i class="material-symbols-outlined">map</i>
          
          <select name="state_id" id="state_id" data-tabid="basic" class="form-select">
            <option value="">State</option>
            <?php if(!empty($stateDetails)): ?>
            <?php $__currentLoopData = $stateDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($sds['id']); ?>"><?php echo e($sds['state_prefix']); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          </select>
        </div>
      </div>

      <div class="col-md-4" style="display: none;" id="stateOther">
        <div class="form-group form-outline mb-4">
          <label for="input" class="float-label">State</label>
          <i class="material-symbols-outlined">map</i>
          <input type="text" name="state" class="form-control" id="state">
        </div>
      </div>
    
      <div class="col-md-4">
        <div class="form-group form-outline mb-4">
          <label for="input" class="float-label">ZIP</label>
          <i class="material-symbols-outlined">home_pin</i>
          <input type="text" name="zip" class="form-control" id="zip">
        </div>
      </div>
    
    <div class="col-md-6 col-12">
      <div class="form-group form-outline mb-4">
        <label for="first_name" class="float-label">User Name</label>
        <i class="material-symbols-outlined">home_health</i>
        <input type="text" name="first_name" class="form-control" id="first_name">
      </div>
    </div>
    <div class="col-md-6 col-12">
      <div class="form-group form-outline phoneregcls mb-4">
        <div class="country_code phone">
          <input type="hidden" id="user_countryCode" name="user_countryCode" value='+1'>
          <input type="hidden" name="user_countryCodeShort" class="form-control" id="user_countryCodeShorts" value="us">

        </div>
        <i class="material-symbols-outlined me-2">call</i>
        <input type="text" name="user_phone" class="form-control phone-numberregistuser" id="user_phone"
          placeholder="Enter user phone number">

      </div>
    </div>
    <div class="col-12">
      <div class="btn_alignbox mt-3">
        <a onclick="submitClinic()" class="btn btn-primary w-100" id="save_clinic">Next</a>

        <!-- <a onclick="submitClinic()" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Next</a> -->
      </div>
    </div>
  </div>

</form>


<script>

  $(document).ready(function () {

    $("#registerform").validate({
      ignore: [],
      rules: {
        first_name: 'required',

        user_phone: {
          required: true,
          maxlength: 13,
          number: true,
          remote: {
                      url: "<?php echo e(url('/frontend/checkPhoneExist')); ?>",

                      data: { 
                          'type': 'clinicUser',
                          'uuid': "",
                          '_token': $('input[name=_token]').val(),
                          'clinic_id': function () {
                              return ""; 
                              }, 
                          'country_code': function () {
                              return $("#user_countryCodeShorts").val(); 
                              }, 
                          'email': function () {
                              return $("#email").val(); 
                              },  
                              'phone_number': function () {
                            return $("#user_phone").val(); 
                            },            
                          },

                      type: "post",
                    },
        },
        clinic_name: 'required',
        email: {
          required: true,
          format: true,
          email: true,

          remote: {
                    url: "<?php echo e(url('/frontend/checkEmailExist')); ?>",
                    data: {
                    'type': 'clinicUser',
                    'uuid': "",
                    '_token': $('input[name=_token]').val(),
                    'clinic_id': function () {
                            return ''; 
                            }, 
                    'phone_number': function () {
                            return $("#user_phone").val(); 
                            }, 
                        'country_code': function () {
                        return $("#user_countryCodeShorts").val(); 
                        }, 
                    },
                    type: "post",
                },
        },
        address: 'required',
        phone_number: {
          required: true,
          number: true,
          maxlength: 13,
          // remote: {
          //   url: "{ url('/validatephone') }}",
          //   data: {
          //     'type': 'clinic',
          //     '_token': $('input[name=_token]').val()
          //   },
          //   type: "post",
          // },

        },
        city: 'required',
        country_id: 'required',
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

        // zip : 'required',
        zip: {
          required: true,
          //  digits: true,
          zipmaxlength: {
            depends: function (element) {
              return (($("#country_id").val() != '236') && $("#country").val() != '235');
            }
          },
          regex: {
            depends: function (element) {
              return ($("#country_id").val() == '236');
            }
          },
          zipRegex: {
            depends: function (element) {
              return ($("#country_id").val() == '235');
            }
          },

        },

      },

      messages: {
        clinic_name: "Please enter clinic name.",
        country_id: "Please select country.",

        email: {
          required: 'Please enter your email.',
          email: 'Please enter valid email.',
          remote: "Email id already exists in the system."
        },
        phone_number: {
          required: 'Please enter your phone number.',
          number: 'Please enter valid phone number.',
          maxlength: 'Please enter valid phone number.',
          remote: "Phone number  exists in the system."

        },
        user_phone: {
          required: 'Please enter your phone number.',
          number: 'Please enter valid phone number.',
          maxlength: 'Please enter valid phone number.',
          remote: "Phone number  exists in the system."
        },
        address: "Please enter address.",
        city: "Please enter city.",
        state: "Please enter state.",
        state_id: 'Please enter state',
        // zip : "Please enter zip." ,
        first_name: "Please enter name.",

        zip: {
          required: 'Please enter zip',
          zipmaxlength: 'Please enter a valid zip.',
          digits: 'Please enter a valid zip.',
          regex: 'Please enter a valid zip.',
          zipRegex: 'Please enter a valid zip.',
        },

      },
      errorPlacement: function (error, element) {
        if (element.hasClass("phone-numberregister")) {
          // Remove previous error label to prevent duplication
          // Insert error message after the correct element
          error.insertAfter(".phone-numberregister");

          error.addClass("phone-numberregister");
        } else {
          if (element.hasClass("phone-numberregistuser")) {
            error.insertAfter(".phone-numberregistuser");
          } else {
            error.insertAfter(element); // Place error messages after the input fields

          }
        }

      },

    });
    $.validator.addMethod(
      "format",
      function (value, element) {
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(value);
      },
      "Please enter a valid email address."
    );
    $.validator.addMethod("regex", function (value, element) {
      return /^[0-9]{5}$/.test(value);
    }, "Please enter a valid ZIP code.");
    $.validator.addMethod("zipRegex", function (value, element) {
      return /^[a-zA-Z0-9]{5,7}$/.test(value);
    }, "Please enter a valid ZIP code.");

    $.validator.addMethod("zipmaxlength", function (value, element) {
      return /^\d{1,6}$/.test(value);
    }, "Please enter a valid ZIP code.");


  });
  function stateUS() {
    if ($("#country_id").val() == 185) {

      $("#state").show();
      $("#stateOther").hide();
      $("#state").val('');
    } else {

      $("#state").hide();
      $("#state_id").val('');
      $("#stateOther").show();
    }


  }

  // floating label start

  $(document).ready(function () {
    // Function to toggle the 'active' class
    function toggleLabel(input) {
      $(input).parent().find('.float-label').toggleClass('active', $.trim(input.value) !== '');
    }

    // Check prefilled inputs and textareas on page load
    $('input, textarea').each(function () {
      toggleLabel(this);
    });

    // On focus, input, and focusout events for all input and textarea elements
    $('input, textarea').on('focus input focusout', function () {
      toggleLabel(this);
    });

    $('input,textarea').on('input change', function () {
      toggleLabel(this);
    });
  });


  // floating label end


  $(document).ready(function () {


    // Initialize for user phone input
    var userTelInput = $("#user_phone"),
      userCountryCodeInput = $("#user_countryCode"),
      usercountryCodeShort = $("#user_countryCodeShorts"),
      userErrorMsg = $("#user_phone-error"),  // Updated target for user phone error message
      userValidMsg = $("#user_valid-msg");    // Assuming you have a unique valid message for user phone

    initializeIntlTelInput(userTelInput, userCountryCodeInput, userErrorMsg, userValidMsg, usercountryCodeShort);

    // Initialize for clinic phone input
    var clinicTelInput = $("#clinic_phone_number"),
      clinicCountryCodeInput = $("#cliniccountryCode1"),
      cliniccountryCodeShort = $("#clinic_countryCodeShorts"),
      clinicErrorMsg = $("#clinic_phone_number-error"),  // Updated target for clinic phone error message
      clinicValidMsg = $("#clinic_valid-msg");
    initializeIntlTelInput(clinicTelInput, clinicCountryCodeInput, clinicErrorMsg, clinicValidMsg, cliniccountryCodeShort);







  });

  function initializeIntlTelInput(telInput, countryCodeInput, errorMsg, validMsg, countryCodeShort) {
    // Initialize intlTelInput
    telInput.intlTelInput({
      initialCountry: "us",
      formatOnDisplay: true,
      autoHideDialCode: true,
      preferredCountries: ['us', 'in'],
      nationalMode: false,
      separateDialCode: true,
      geoIpLookup: function (callback) {
        $.get("http://ipinfo.io", function () { }, "jsonp").always(function (resp) {
          var countryCode = (resp && resp.country) ? resp.country : "";
          callback(countryCode);
        });
      },
      utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"
    });

    // Reset error/valid messages
    function reset() {
      telInput.removeClass("error");
      errorMsg.addClass("hide");
      validMsg.addClass("hide");
    }

    // Handle country change event 
    telInput.on("countrychange", function (e, countryData) {
      var countryShortCode = countryData.iso2;
      countryCodeShort.val(countryShortCode);
      countryCodeInput.val(countryData.dialCode);
    });
    // Handle clinic change even

    // Handle blur event
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

    // Handle keyup/change event
    telInput.on("keyup change", reset);
  }

</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/auth/register.blade.php ENDPATH**/ ?>