<h4 class="text-center fw-medium mb-0 ">Enter Clinic Details</h4>
                      <small class="gray">Provide your clinic's information to proceed.</small>
                      
                        <form method="POST" id="registerform" >
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
                                            <input type="hidden" id="cliniccountryCode" name="clinic_countrycode"  value='+1'>
                                        </div>
                                        <i class="material-symbols-outlined me-2">call</i>
                                        <input type="text" name="phone_number" class="form-control phone-numberregister" id="clinic_phone_number" placeholder="Enter clinic phone number" required>
                                </div>
                            </div>

                            <div class="col-12">
                              <div class="form-group form-outline select-outline mb-4">
                                <i class="material-symbols-outlined">public</i>
                                <select name="country_id" id="country_id"  onchange="stateUS()" class="form-select">
                                    <option value="">Country</option>
                                    <?php if(!empty($countryDetails)): ?>
                                    <?php $__currentLoopData = $countryDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($cds['id']); ?>" <?php if($clinicUserdetails['country_id'] !='' && $clinicUserdetails['country_id'] == $cds['id'] ): ?> selected <?php else: ?> <?php echo e($cds['id']==185 ? 'selected': ''); ?> <?php endif; ?>><?php echo e($cds['country_name']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   <?php endif; ?>
                                </select>
                              </div>
                            </div>

                           


                            <div class="col-12">
                              <div class="form-group form-outline mb-4">
                                <label for="address" class="float-label">Address</label>
                                <i class="material-symbols-outlined">home</i>
                                <input type="text" name="address" class="form-control" id="address" value="<?php echo e($clinicUserdetails['address']); ?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group form-outline mb-4">
                                <label for="city" class="float-label">City</label>
                                <i class="material-symbols-outlined">location_city</i>
                                <input type="text" name="city" class="form-control" id="city" value="<?php echo e($clinicUserdetails['city']); ?>">
                              </div>
                            </div>

                            <div class="col-md-4" id="state" <?php if($clinicUserdetails['country_id'] !='' && $clinicUserdetails['country_id'] == '236' ): ?> style="display: block;" <?php else: ?> style="display: none;" <?php endif; ?> >
                              <div class="form-group form-outline select-outline mb-4">
                                <i class="material-symbols-outlined">map</i>
                                
                                <select name="state_id" id="state_id" data-tabid="basic" class="form-select">
                                    <option value="">State</option>
                                    <?php if(!empty($stateDetails)): ?>
                                    <?php $__currentLoopData = $stateDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sds): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($sds['id']); ?>" <?php if($clinicUserdetails['state_id'] !='' && $clinicUserdetails['state_id'] == $sds['id'] ): ?> selected <?php endif; ?>><?php echo e($sds['state_prefix']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                   <?php endif; ?>
                                </select>
                              </div>
                            </div>

                            <div class="col-md-4"  id="stateOther" <?php if($clinicUserdetails['country_id'] !='' && $clinicUserdetails['country_id'] == '236' ): ?> style="display: none;" <?php endif; ?> >
                              <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">State</label>
                                <i class="material-symbols-outlined">map</i>
                                <input type="text" name="state" class="form-control" id="state" value="<?php echo e($clinicUserdetails['state']); ?>">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">ZIP</label>
                                <i class="material-symbols-outlined">home_pin</i>
                                <input type="text" name="zip" class="form-control" id="zip" value="<?php echo e($clinicUserdetails['zip_code']); ?>">
                              </div>
                            </div>

                            <input type="hidden" name="first_name" class="form-control" id="first_name" value="<?php if(!empty($clinicUserdetails)): ?> <?php echo e($clinicUserdetails['name']); ?> <?php endif; ?>">
                            <input type="hidden" name="user_countryCode" class="form-control" id="user_countryCode" value=<?php echo e(isset($clinicUserdetails['country_code'])  ? $clinicUserdetails['country_code'] : '+1'); ?>>
                            <input type="hidden" name="user_phone" class="form-control" id="user_phone" value=<?php echo e($clinicUserdetails['phone_number']); ?>>

                            
                          
                            <div class="col-12">
                              <div class="btn_alignbox">
                              <a id="addbtn" onclick="addNewClinic()" class="btn btn-primary w-100" >Next</a>

                              </div> 
                            </div>
                          </div>

                        </form> 


            <script>

              $(document).ready(function() {
                stateUS();
                  $("#registerform").validate({
                          ignore: [],
                          rules: {
                              first_name : 'required',
                            
                              user_phone: {
                                  required: true,
                                  maxlength: 13,
                                  number: true,
                               
                              },
                              clinic_name : 'required',
                              email: {
                                  required: true,
                                  email: true,
                                  remote: {
                                      url: "<?php echo e(url('/validateemail')); ?>",
                                      data: {
                                        'type' : 'register',
                                          '_token': $('input[name=_token]').val()
                                      },
                                      type: "post",
                                  },
                              } ,
                              address : 'required',
                              phone_number: {
                                  required: true,
                                  number: true,
                                  maxlength: 13,
                                  remote: {
                                        url: "<?php echo e(url('/validatephone')); ?>",
                                        data: {
                                          'type': 'clinic',
                                          '_token': $('input[name=_token]').val()
                                        },
                                        type: "post",
                                      },

                              },
                              city : 'required',
                              country_id :'required',
                              state : {
                                  required: {
                                          depends: function(element) {
                                              return ( ($("#country_id").val() !='236'));
                                              // return (($("#country").val() =='236') );
                                          }
                                  },
                              },
                              state_id : {
                                  required: {
                                          depends: function(element) {
                                              return ( ($("#country_id").val() =='236'));
                                              // return (($("#country").val() =='236') );
                                          }
                                  },
                              },

                              // zip : 'required',
                              zip:{
                                  required: true,
                              //  digits: true,
                              zipmaxlength: {
                                      depends: function(element) {
                                          return (($("#country_id").val() !='236') && $("#country").val() !='235' );
                                      }
                                  },
                                      regex: {
                                      depends: function(element) {
                                          return ($("#country_id").val()=='236' );
                                      }
                                  },
                                  zipRegex: {
                                      depends: function(element) {
                                          return ($("#country_id").val() =='235');
                                      }
                                  },

                              },
                            
                              },

                          messages: {
                              clinic_name : "Please enter clinic name." ,
                              country_id  :"Please select country." ,

                              email: {
                                  required : 'Please enter your email.',
                                  email : 'Please enter valid email.',
                                    remote: "Email id already exists in the system."
                              },
                              phone_number: {
                                  required : 'Please enter your phone number.',
                                  number : 'Please enter valid phone number.',
                                  maxlength : 'Please enter valid phone number.',
                                   remote: "Phone number  exists in the system."
                                  
                              },
                              user_phone: {
                                  required : 'Please enter your phone number.',
                                  number : 'Please enter valid phone number.',
                                  maxlength : 'Please enter valid phone number.',
                                //    remote: "Phone number  exists in the system."
                              },
                              address : "Please enter address." ,
                              city : "Please enter city." ,
                              state : "Please enter state." ,
                              state_id : 'Please enter state',
                              // zip : "Please enter zip." ,
                              first_name : "Please enter name." ,
                          
                              zip: {
                                  required: 'Please enter zip',
                                  zipmaxlength: 'Please enter a valid zip.',
                                  digits: 'Please enter a valid zip.',
                                  regex: 'Please enter a valid zip.',
                                  zipRegex: 'Please enter a valid zip.',
                              },
                              
                          },
                          errorPlacement: function(error, element) {
                              if (element.hasClass("phone-numberregister")) {
                                  // Remove previous error label to prevent duplication
                                  // Insert error message after the correct element
                                  error.insertAfter(".phone-numberregister");
                                 
                                  error.addClass("phone-numberregister");
                              }else{
                                if (element.hasClass("phone-numberregistuser")) {
                                  error.insertAfter(".phone-numberregistuser");
                                }else{
                                  error.insertAfter(element); // Place error messages after the input fields

                                }
                              }
                            
                          }
                      });
                      $.validator.addMethod("regex", function(value, element) {
                                return /^[0-9]{5}$/.test(value);
                          }, "Please enter a valid ZIP code.");
                          $.validator.addMethod("zipRegex", function(value, element) {
                                return /^[a-zA-Z0-9]{5,7}$/.test(value);
                          }, "Please enter a valid ZIP code.");

                          $.validator.addMethod("zipmaxlength", function(value, element) {
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

                     

                     
  $(document).ready(function () {
 

   // Initialize for user phone input
   var userTelInput = $("#user_phone"),
        userCountryCodeInput = $("#user_countryCode"),
        userErrorMsg = $("#user_phone-error"),  // Updated target for user phone error message
        userValidMsg = $("#user_valid-msg");    // Assuming you have a unique valid message for user phone

    // initializeIntlTelInput(userTelInput, userCountryCodeInput, userErrorMsg, userValidMsg);

    // Initialize for clinic phone input
    var clinicTelInput = $("#clinic_phone_number"),
        clinicCountryCodeInput = $("#cliniccountryCode"),
        clinicErrorMsg = $("#clinic_phone_number-error"),  // Updated target for clinic phone error message
        clinicValidMsg = $("#clinic_valid-msg"); 
    initializeIntlTelInput(clinicTelInput, clinicCountryCodeInput, clinicErrorMsg, clinicValidMsg);
});

function initializeIntlTelInput(telInput, countryCodeInput, errorMsg, validMsg) {
        // Initialize intlTelInput
        telInput.intlTelInput({
            initialCountry: "us",
            formatOnDisplay: false,
            autoHideDialCode: true,
            preferredCountries: ['us', 'in'],
            nationalMode: false,
            separateDialCode: true,
            geoIpLookup: function(callback) {
                $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
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
        telInput.on("countrychange", function(e, countryData) {
            countryCodeInput.val(countryData.dialCode);
        });

        // Handle blur event
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

        // Handle keyup/change event
        telInput.on("keyup change", reset);
    }

    function addNewClinic() {
      
            if ($("#registerform").valid()) {
                $("#addbtn").addClass('disabled');
                $("#addbtn").text("Submitting..."); 
                $.ajax({
                    url: '<?php echo e(url("store/clinic")); ?>',
                    type: "post",
                    data: {
                        'formdata': $("#registerform").serialize(),
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {
                          

                            // Redirect to the dashboard after an additional 3 seconds
                            setTimeout(function() {

                                if(data.stripe_connected == 0){
                                    window.location.href = data.stripeURL;
                                }else{
                                    $("#registerUser").modal('hide'); 
                                    window.location.href = "<?php echo e(url('/dashboard')); ?>";
                                }

                                // window.location.href = "<?php echo e(url('/dashboard')); ?>"; // Redirect to the dashboard
                            }, 2000); // 5 seconds (2 seconds + 3 seconds)
                            // 
                        } else {

                        }
                    }
                });

            } else {
                if ($('.error:visible').length > 0) {
                    setTimeout(function() {
                        $('html, body').animate({
                            scrollTop: ($('.error:visible').first().offset().top - 100)
                        }, 500);
                    }, 500);
                }
            }

        }

       


</script>
<?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/clinics/addclinic.blade.php ENDPATH**/ ?>