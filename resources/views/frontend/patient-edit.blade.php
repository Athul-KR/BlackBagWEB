<h5 class="text-center fwt-bold mb-0 ">Edit Patient</h5>
<?php
  $Corefunctions = new \App\customclasses\Corefunctions;
?>
<!-- <small class="gray">Please enter the patient's details</small> -->

<div class="import_section">
  <!-- <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a> -->
</div>
<form id="editform" method="POST" autocomplete="off">
  @csrf

  <div class="create-profile d-flex justify-content-center">
    <div class="profile-img position-relative">
      <img id="editpatientimage" @if($patientDetails['logo_path'] !='' ) src="{{$patientDetails['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid" alt="Default User Image">
      <a href="{{ url('crop/patient')}}" id="upload-imgedit" class="aupload" @if($patientDetails['logo_path'] !='' ) style="display:none;" @endif><img src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal" alt="User Image"></a>
      <a class="profile-remove-btn" href="javascript:void(0);" id="removelogoedit" @if($patientDetails['logo_path'] !='' ) style="" @else style="display:none;" @endif onclick="removeProfileImage()"><span class="material-symbols-outlined">delete</span></a>

    </div>
    <input type="hidden" id="tempimageedit" name="tempimage" value="">
    <input type="hidden" name="isremove" id="isremoveedit" value="0">
  </div>

  <div class="row">
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="input" class="float-label">First Name</label>
        <i class="fa-solid fa-circle-user"></i>
        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="@if(isset($patientDetails['user']['first_name']) ){{$patientDetails['user']['first_name']}}@else{{$patientDetails['first_name']}}@endif">
      </div>
    </div>

    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="input" class="float-label">Middle Name</label>
        <i class="fa-solid fa-circle-user"></i>
        <input type="text" name="middle_name" class="form-control" id="exampleFormControlInput1" @if(isset($patientDetails['middle_name']) && $patientDetails['middle_name'] != '') value="@if(isset($patientDetails['user']['middle_name']) ){{$patientDetails['user']['middle_name']}}@else{{$patientDetails['middle_name']}}@endif" @endif>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="input" class="float-label">Last Name</label>
        <i class="fa-solid fa-circle-user"></i>
        <input type="text" name="last_name" class="form-control" id="last_name" value="@if(isset($patientDetails['user']['last_name']) ){{$patientDetails['user']['last_name']}}@else{{$patientDetails['last_name']}}@endif">
      </div>
    </div>


    <div class="col-lg-6">
      <div class="form-group form-floating mb-4">
        <i class="material-symbols-outlined">id_card</i>
        <select name="gender" id="gender" class="form-select">
          <option disabled="" selected="">Select Gender</option>
          <option value="1" @if($patientDetails['gender']=='1' ) selected @endif>Male</option>
          <option value="2" @if($patientDetails['gender']=='2' ) selected @endif>Female</option>
          <option value="3" @if($patientDetails['gender']=='3' ) selected @endif>Other</option>

        </select>
        <label class="select-label">Gender</label>
      </div>


    </div>
    <div class="col-lg-6">
      <div class="form-group form-outline mb-4">
        <label for="email" class="float-label">Email</label>
        <i class="fa-solid fa-envelope"></i>
        <input type="email" name="email" id="email" class="form-control" value="{{$patientDetails['email']}}">
      </div>
    </div>


    <div class="col-12 col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="dob" class="float-label active">Date of Birth</label>
        <i class="material-symbols-outlined">date_range</i>
        <input type="text" name="dob" id="dobedit" class="form-control" placeholder="" value="@if( $patientDetails['dob'] != '') {{date('m/d/Y', strtotime($patientDetails['dob']))}} @endif">
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="form-group form-outline phoneregcls disabled-feild mb-3">
        <div class="country_code phone">

          <input type="hidden" id="clinicID" value="{{$patientDetails['clinic_id']?? ''}}">
          <input type="hidden" id="countryCodeedit" name="countrycode" value="{{ $countryCode['country_code'] ??  '+1' }}">
          <input type="hidden" name="countryCodeShort" class="form-control autofillcountry" id="countrycodeShort" value="{{ $countryCode['short_code'] ?? 'US'}}">

        </div>
        <!-- <label for="phone" class="float-label ">Phone Number</label> -->
        <i class="material-symbols-outlined me-2">call</i>
        <?php 
        $phoneNumber = (isset($patientDetails['user']['last_name']) ) ? $patientDetails['user']['phone_number'] : $patientDetails['phone_number'];
          $phonenumberValue = isset($countryCode['short_code']) && $countryCode['short_code'] == 'US' 
              ? $Corefunctions->formatPhone($phoneNumber) 
              : optional($countryCode)->country_code . $Corefunctions->formatPhone($phoneNumber); 
        ?>
        <input type="tel" name="phone_number" placeholder="Phone Number" class="form-control" id="phoneedit" value="<?php echo $phonenumberValue ?>" readonly>
      </div>
    </div>
    <div class="col-12 col-lg-4">
      <div class="form-group form-outline mb-2">
        <div class="country_code phone">
          <input type="hidden" id="whatsappeditcountryCode" name="whatscountrycode" value="{{ $whatsappCountryCode['country_code'] ??  '+1' }}">
          <input type="hidden" id="whatsappcountryCodeShorts" name="whatsappcountryCodeShorts" value="{{ $whatsappCountryCode['short_code'] ?? 'us'}}">
        </div>
        <!-- <label for="whatsapp" class="float-label ">Whatsapp</label> -->
        <i class="fa-brands fa-whatsapp me-2"></i>
        <?php 
          $whatsappValue = isset($whatsappCountryCode['short_code']) && $whatsappCountryCode['short_code'] == 'US' 
              ? $Corefunctions->formatPhone($patientDetails['whatsapp_number']) 
              : optional($whatsappCountryCode)->country_code . $Corefunctions->formatPhone($patientDetails['whatsapp_number']); 
        ?>
        <input type="tel" name="whatsapp_num" placeholder="Whatsapp Number" class="form-control" id="whatsappedit" value="<?php echo $whatsappValue ?>">
      </div>
      <div class="d-flex justify-content-start align-items-center mb-3">
        <input class="form-check-input btn-outline-checkbox m-0 me-2" name="iswhatsapp" id="iswhatsapp" type="checkbox" value="" @if($patientDetails['whatsapp_number'] == $patientDetails['phone_number'] ) checked @endif>
        <samll class="primary fw-medium">Same as phone number</samll>
      </div>
    </div>

    <div class="col-12">
      <div class="form-group form-outline mb-4">
        <label for="address" class="float-label">Address</label>
        <i class="material-symbols-outlined">home</i>
        <textarea name="address" id="address" class="form-control" rows="1">{{$patientDetails['address']}}</textarea>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="city" class="float-label">City</label>
        <i class="material-symbols-outlined">location_city</i>
        <input type="text" name="city" class="form-control" id="city" value="{{$patientDetails['city']}}">
      </div>
    </div>
    <div id="statesel" class="col-lg-4" @if(isset($patientDetails['country_code']) && ($patientDetails['country_code']=='185' ) ) style="display:none;" @else style="display:block;" @endif>
      <div class="form-group form-outline mb-4">
        <label for="state" class="float-label">State</label>
        <i class="material-symbols-outlined">map</i>
        <input type="text" name="state" class="form-control" id="state" value="{{$patientDetails['state']}}">
      </div>
    </div>

    <div id="statelist" class="col-lg-4" @if(isset($patientDetails['country_code']) && ($patientDetails['country_code']=='185') ) style="display:block;" @else style="display:none;" @endif>
      <div class="form-group form-floating mb-4">
        <i class="material-symbols-outlined">id_card</i>
        <select name="state_id" id="state_id" class="form-select">
          <option disabled="" selected="">State</option>
          @if(!empty($state))
          @foreach($state as $sts)
          <option value="{{$sts['id']}}" data-shortcode="{{$sts['state_name']}}" @if($patientDetails['state_id']==$sts['id']) selected @endif>{{$sts['state_name']}}</option>
          @endforeach
          @endif
        </select>
        <label class="select-label">Select a state</label>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="zip" class="float-label ">Zip</label>
        <i class="material-symbols-outlined">home_pin</i>
        <input type="text" name="zip" class="form-control" id="zip" value="{{$patientDetails['zip']}}">
      </div>
    </div>


    <div class="col-12">
      <div class="btn_alignbox justify-content-end">
        <a onclick="updatePatient('{{$patientDetails['patients_uuid']}}')" id="updatepatient" class="btn btn-primary">Update</a>
      </div>

    </div>
  </div>

</form>
<h5 class="text-start fwt-bold mb-2 ">Change Phone Number</h5>
<form method="post" id="change_phone_form" autocomplete="off">
    @csrf
    <div class="row">
        <div class="col-12">
            <p id="credslabel" class="top-error"></p>
            <div class="form-group form-outline phoneregcls mb-3">
                <div class="country_code phone">

                    <input type="hidden" id="countryCodeEdit" name="countrycode"
                        value="{{$countryCode['country_code'] ?? '+1' }}">

                    <input type="hidden" id="countryCodeShortEdit" name="countryCodeShort"
                        value="{{$countryCode['short_code'] ?? 'us' }}">
                </div>
                <!-- <label for="phone" class="float-label ">Phone Number</label> -->
                <i class="material-symbols-outlined me-2">call</i>
                <input type="tel" name="phonenumber" placeholder="Phone Number" class="form-control" id="phoneeditinput"
                    value="<?php echo $countryCode['country_code'] . $Corefunctions->formatPhone($patientDetails['phone_number']) ?>">
            </div>


        </div>
        <div class="col-12">
            <div class="btn_alignbox justify-content-end">
                <a onclick="changePhoneNumber()" class="btn btn-primary">Send
                    OTP
                </a>
            </div>
        </div>
    </div>
</form>
@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
   let onlyCountriesx = {!! json_encode($corefunctions->getCountry()) !!};
    jQuery.browser = {};
    (function() {
      jQuery.browser.msie = false;
      jQuery.browser.version = 0;
      if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
      }
    })();
    $(document).ready(function () {
      console.log('test')
        var telInput1 = $("#phoneeditinput"),
            countryCodeInput = $("#countryCodeEdit"),
            countryCodeShort = $("#countryCodeShortEdit"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");

        // initialise plugin
        telInput1.intlTelInput({
            autoPlaceholder: "polite",
            initialCountry: "us",
            formatOnDisplay: false, // Enable auto-formatting on display
            autoHideDialCode: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",
            onlyCountries: onlyCountriesx,
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
          telInput1.removeClass("error");
            errorMsg.addClass("hide");
            validMsg.addClass("hide");
        };

        telInput1.on("countrychange", function (e, countryData) {
            var countryShortCode = countryData.iso2;
            countryCodeInput.val(countryData.dialCode);
            countryCodeShort.val(countryShortCode);
            updateAutocompleteCountry();
        });

        telInput1.blur(function () {
            reset();
            if ($.trim(telInput1.val())) {
                if (telInput1.intlTelInput("isValidNumber")) {
                    validMsg.removeClass("hide");
                } else {
                  telInput1.addClass("error");
                    errorMsg.removeClass("hide");
                }
            }
        });
         // Set initial values based on pre-filled country code
        var initialCountryData = telInput1.intlTelInput("getSelectedCountryData");
        countryCodeInput.val(initialCountryData.dialCode); // Set dial code
        countryCodeShort.val(initialCountryData.iso2); // Set short code

        telInput1.on("keyup change", reset);

        $('#phoneedit, #whatsappedit, #phoneeditinput').mask('(ZZZ) ZZZ-ZZZZ', {
          translation: {
            'Z': {
              pattern: /[0-9]/,
              optional: false
            }
          }
        });

        //Validation
        $("#change_phone_form").validate({
          rules: {
            phonenumber: {
              required: true,  // Ensure the phone field is not empty
              NumberValids: true,  // Ensure the phone field is not empty

            }
          },
          messages: {
            phonenumber: {
              required: "Please enter phone number",
              NumberValids: "Please enter a valid number",
            }
          },

        });

    });



    //change phone number
    function changePhoneNumber() {

        if ($("#change_phone_form").valid()) {


            var url = "{{url('frontend/changePhoneNumber')}}";
            var phone = $('#phoneeditinput').val();
            var countryCode = $('#countryCodeEdit').val();
            $.ajax({
                url: url,
                type: "post",
                data: {
                    'formdata': $("#change_phone_form").serialize(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    console.log(data);

                    if (data.success == 1) {
                        // $("#settingsModal").hide();
                        $("#settingsModal").modal('hide');
                        $("#otpform_modal").modal('show');
                        // $("#otpform").show();
                        $('#otp1').focus();
                        $("#otpkey").val(data.key);
                        $("#phonenumbers").val(data.phonenumber);
                        $("#countrycode").val(data.countrycode);
                        $("#countryCodeShorts").val(data.countryCodeShort);
                        $("#countryCodeShorts1").val(data.countryCodeShort);
                        $("#countryId").val(data.countryId);
                        $('#otpPhone').text(data.countrycode + ' ' + data.phonenumber);
                        $("#type").val(data.type);

                        swal(
                            "Success!",
                            "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                            "success",
                        ).then(() => {
                            // $("#otpform").addClass('show');
                            console.log(data);

                        });


                        resendCountdown();
                    } else {
                        showOtpError(data.errormsg, 'login');
                        swal(
                            "Error!",
                            data.errormsg,
                            "error",
                        ).then(() => {
                            console.log(data);


                        });
                    }
                },
                error: function(xhr) {
               
                  handleError(xhr);
              }
            });
        }
        



    }


    //resend otp
    function resendOtp() {

        $.ajax({
            url: '{{ url("frontend/changePhoneNumber") }}',
            type: "post",
            data: {
                'formdata': $("#verifyotpform").serialize(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    $("#settingsModal").hide();
                    $("#otpform_modal").modal('show');
                    $('.otp-input-field').val('');
                    // $("#otpform").show();
                    $("#otpkey").val(data.key);
                    $("#phonenumbers").val(data.phonenumber);
                    $("#countrycode").val(data.countrycode);
                    swal(
                        "Success!",
                        "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                        "success",
                    ).then(() => {
                        console.log(data);

                    });
                    resendCountdown()
                } else {

                }
            },
            error: function(xhr) {
               
              handleError(xhr);
            }
        });

    }

    //Verify Otp
    function verifyOtp() {
        var otpValue = '';
        // Gather OTP value from individual fields
        $('.otp-input-field').each(function () {
            otpValue += $(this).val();
        });

        $('#otp_value').val(otpValue);

        // If the form passes validation
        if ($("#verifyotpform").valid()) {
            $.ajax({
                url: '{{ url("frontend/verifyotp?tokn=update") }}',
                type: "post",
                data: {
                    'formdata': $("#verifyotpform").serialize(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    
                    console.log(data.token);
                    if (data.token == 'delete') {
                        $("#otpform_modal").modal('hide');
                        window.location.href = "{{url('frontend.logout')}}";
                    }
                    if (data.token == 'update') {
                        $("#otpform_modal").modal('hide');
                        // $("#otpform").hide();
                        swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                          window.location.href = "{{url('/myaccounts')}}";
                        });

                      
                    } else {
                        $('.otp-input-field').val('');
                        // Optionally reset the hidden 'otp_value' field as well
                        $('#otp_value').val('');
                        // When OTP verification fails, show an error
                        showOtpError('Invalid OTP. Please try again.'); // Call the error display function
                    }
                },
                error: function(xhr) {
               
                  handleError(xhr);
              }
            });
        } else {
            // If form validation fails
            if ($('.error:visible').length > 0) {
                setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: ($('.error:visible').first().offset().top - 100)
                    }, 500);
                }, 500);
            }
        }
    }




    // Function to display OTP error message dynamically
    function showOtpError(message, type = '') {
      var otpField, errorElement;

      if (type == 'login') {
          otpField = $('#credslabel'); // The field where the OTP is entered

          // Check if an error label already exists
          if (otpField.find('label.error').length === 0) {
              errorElement = $('<label class="error"></label>').text(message); // Create a new error label
              otpField.html(errorElement); // Replace the content with the error
          } else {
              otpField.find('label.error').text(message); // Update the existing error message
          }
      } else {
          otpField = $('.otp-input'); // The field where the OTP is entered

          // Check if an error label already exists
          if (otpField.find('label.error').length === 0) {
              errorElement = $('<label class="error"></label>').text(message); // Create a new error label
              otpField.append(errorElement); // Insert error message after the OTP input field
          } else {
              otpField.find('label.error').text(message); // Update the existing error message
          }
      }

      // Scroll to the error message if needed
      // $('html, body').animate({
      //     scrollTop: (otpField.offset().top - 100)
      // }, 500);

      // Fade out the error message after 3 seconds
      setTimeout(function () {
          otpField.find('label.error').fadeOut(500, function () {
              $(this).remove(); // Remove the element from the DOM after fading out
          });
      }, 3000); // 3000 milliseconds = 3 seconds
    }

    
  function editnotes(type) {
    if (type == 'add') {
      $("#editnotes").show();
      $("#editremove").show();
      $("#edit").hide();
    } else {
      $("#editnotes").hide();
      $("#editremove").hide();
      $("#edit").show();
      $("#noteedit").val('');

    }

  }

  function removeProfileImage() {
    console.log('remove')
    $("#editpatientimage").attr("src", "{{asset('images/default_img.png')}}");
    $("#isremoveedit").val('1');
    $("#isremoveedit").hide();
    $("#upload-imgedit").show();
    $("#removelogoedit").hide();

  }

  function removeDocs(key) {

    swal({
      text: "Are you sure you want to remove this document?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonClass: "btn-danger",
      confirmButtonText: "OK",
      cancelButtonText: "Cancel",
      showLoaderOnConfirm: false,
      preConfirm: () => {
        $("#doc_" + key).remove();
        $("#patient_doc_exists" + key).val('');

      }
    });


  }

  function patientImage(imagekey, imagePath) {
    $("#tempimageedit").val(imagekey);
    $("#editpatientimage").attr("src", imagePath);
    $("#editpatientimage").show();
    $("#upload-imgedit").hide();
    $("#removelogoedit").show();
  }
  $(".aupload").colorbox({
    iframe: true,
    width: "650px",
    height: "650px"
  });


  $('#dobedit').datetimepicker({
    format: 'MM/DD/YYYY',
    useCurrent: false,
    maxDate: new Date(),  // Disables future dates
    ignoreReadonly: true,  // Prevents readonly input if necessary
    // todayHighlight: true,  // Optional to highlight today's date
    // autoclose: true,  // Optional to close picker after selecting
});




  $(document).ready(function() {

    $("#editform").validate({
      rules: {
        name: {
          required: true,
        },
        last_name: {
          required: true,
        },
        
        email: {
          required: true,
          remote: {
                    url: "{{ url('/validateuserphone') }}",
                    type: "post",
                    data: {
                        'type': 'patient',
                        'id':"{{$patientDetails['user_id']}}",
                        'phone_number': function () {
                            return $("#phoneedit").val(); // Get the updated value
                        },
                       
                        'country_code': function () {
                           
                            return $("#countrycodeShort").val(); // Get the updated value
                        },
                        '_token': $('input[name=_token]').val()
                    },
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
        },
        gender: {
          required: true,
        },
        dob: {
          required: true,
        },
        //  phone_number: {
        //         required: true,
            //     minlength: 10,
            //     maxlength: 13,
            //     number: true,
            //     remote: {
            //         url: "{{ url('/validateuserphone') }}",
            //         type: "post",
            //         data: {
            //             'type': 'patient',
            //             'id':"{{$patientDetails['user_id']}}",
            //             'email': function () {
            //                 return $("#email").val(); // Get the updated value
            //             },
                       
            //             'country_code': function () {
            //                 return $("#countrycodeShort").val(); // Get the updated value
            //             },
            //             '_token': $('input[name=_token]').val()
            //         },
            //         dataFilter: function (response) {
            //             // Parse the server's response
            //             const res = JSON.parse(response);
            //             if (res.valid) {
            //                 return true; // Validation passed
            //             } else {
            //                 // Dynamically return the error message
            //                 return "\"" + res.message + "\"";
            //             }
            //         }
            //     },
            // },
        whatsapp_num: {
          // required: true,
          NumberValids: true,
        },
        address: {
          required: true,
        },
        city: {
          required: true,
        },
        // state: {
        //     required: true,
        // },
        state: {
          required: {
            depends: function(element) {

              return (($("#countryCodeedit").val() != '+1'));

            }
          },
        },

        state_id: {
          required: {
            depends: function(element) {
              return (($("#countryCodeedit").val() == '+1'));

            }
          },
        },

        zip: {
          required: true,
          number: true,
        },
        // note: {
        //     required: true,
        // },

      },
      messages: {
        name: {
          required: 'Please enter first name.',
        },
        last_name: {
          required: 'Please enter last name.',
        },
        
        email: {
          required: 'Please enter email.',
          customemail: "Please enter a valid email",
          remote: "Email id already exists in the system."
        },
        gender: {
          required: 'Please select gender.',
        },
        dob: {
          required: 'Please enter date of birth.',
        },
        // phone_number: {
        //   required: 'Please enter phone number',
        //   number: 'Please enter valid phone number',
        //   remote: "Phone number already exists",
        //   maxlength: "Please enter valid phone number",
        //   minlength: "Please enter valid phone number"
        // },
        whatsapp_num: {
          required: 'Please enter phone number.',
          NumberValids: 'Please enter valid phone number.',
        },

        address: {
          required: 'Please enter address.',
        },
        city: {
          required: 'Please enter city.',
        },
        state: {
          required: 'Please enter state.',
        },
        state_id: {
          required: 'Please select state.',
        },

        zip: {
          required: 'Please enter zip code..',
          number: 'Please enter valid zip code.',
        },
      },
      errorPlacement: function(error, element) {
        if (element.hasClass("phone-number")) {

        } else {
          error.insertAfter(element);
        }
      },
      success: function(label) {
        // If the field is valid, remove the error label
        label.remove();
      }
    });
    jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
        return this.optional(element) || phone_number.length < 14 &&
            phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
    });
  });

  // $(document).on('change', '#clinic', function() {
  //     var phoneNumber = $('#phoneedit').val();
  //     var clinicID=$('#clinic').val();
  //     $('#clinicID').val(clinicID);
  //     $('#editform').validate().element("#email"); 
  //     $('#editform').validate().element("#phoneedit");

  // });

  var autocompleteedit ;
  function updateAutocompleteCountry() {
   
    let selectedCountry = document.querySelector('.autofillcountry')?.value || 'US';
    console.log('new'+selectedCountry)
    if (autocomplete) {
        autocomplete.setComponentRestrictions({ country: selectedCountry });
    } else {
        initializeAutocomplete(); // Reinitialize if needed
    }

}
    function initializeAutocompleteSettings() {

// console.log('init')
  let addressInput = document.getElementById('address');
  if (addressInput) {
      addressInput.setAttribute("placeholder", ""); // Ensures no placeholder
  }

  // console.log("Initializing Google Places Autocomplete...");
  if (typeof google === "undefined" || !google.maps || !google.maps.places) {
      console.error("Google Maps API failed to load. Please check your API key.");
      // alert("Error: Google Maps API failed to load. Check the console.");
      return;
  }

  let input = document.getElementById('address');
  if (!input) {
      console.log("Address input field NOT found!");
      return;
  }


  let countryDropdown = document.querySelector('.autofillcountry'); // Get country code
  let defaultCountry = countryDropdown ? countryDropdown.value : "US"; // Default to US

  autocomplete  = new google.maps.places.Autocomplete(input, {
      types: ['geocode', 'establishment'],
        componentRestrictions: { country: defaultCountry } // Restrict to US addresses
  });

  autocompleteedit  = new google.maps.places.Autocomplete(input, {
     types: ['geocode', 'establishment'],
      componentRestrictions: { country: defaultCountry } // Set initial country
  });

  console.log("Google Places Autocomplete initialized successfully.");

  autocompleteedit.addListener('place_changed', function () {
      console.log("Place changed event triggered.");
      
      var place = autocompleteedit.getPlace();
      if (!place || !place.address_components) {
          console.error("No address components found.");
          // alert("Invalid address selection. Please choose a valid address from the dropdown.");
          return;
      }

      var addressComponents = {
          street_number: "",
          street: "",
          city: "",
          state: "",
          zip: ""
      };
console.log(place);
      place.address_components.forEach(component => {
          const types = component.types;
          
            
    // Initialize addressComponents.street_number to an empty string if not already defined
    if (!addressComponents.street_number) {
                addressComponents.street_number = '';
            }

            // Check if the component type is "establishment"
            if (place.types.includes("establishment")) {
                // Append the establishment name if it's not already in street_number
                if (!addressComponents.street_number.includes(place.name)) {
                    addressComponents.street_number += (addressComponents.street_number ? ", " : "") + place.name;
                }
            }

            // Check if the component type is "street_number"
            if (types.includes("street_number")) {
                // Append street number only if it's not already in the addressComponents
                if (!addressComponents.street_number.includes(component.long_name)) {
                    addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                }
            }

            // Check if the component type is "route"
            if (types.includes("route")) {
                // Append the route only if it's not already in street_number
                if (!addressComponents.street_number.includes(component.long_name)) {
                    addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                }
            }

          if (types.includes("locality")) addressComponents.city = component.long_name;
          if (types.includes("administrative_area_level_1")) addressComponents.state = component.short_name;
          if (types.includes("postal_code")) addressComponents.zip = component.long_name;
      });

      console.log("Extracted Address Components:", addressComponents);

      // Safe function to prevent errors
      function safeSetValue(id, value) {
          let element = document.getElementById(id);
          if (element) {
              element.value = value;

               // Add "active" class if the field is prefilled
              let label = element.closest(".form-group").querySelector(".float-label");
              if (label && value.trim() !== "") {
                  label.classList.add("active");
              }

          }
      }

      safeSetValue('address', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
      safeSetValue('city', addressComponents.city || '');
      safeSetValue('zip', addressComponents.zip || '');
      safeSetValue('state', addressComponents.state || '');

     


      // Select the state in the dropdown
      let stateDropdown = document.getElementById('state_id');
      console.log(stateDropdown);
      if (stateDropdown) {
          for (let option of stateDropdown.options) {
            // console.log('op'+option.text)
            //   console.log('optt'+addressComponents.state)

              if (option.dataset.shortcode === addressComponents.state) {
                  option.selected = true;
                  break;
              }
          }
      }
      $("#address, #city, #zip, #state_id").each(function () {
        $(this).valid(); 
      });

    
  });

  let focusedIndex = -1;
    let suggestions = [];

    // Add event listeners for keyboard navigation
    addressInput.addEventListener('keydown', function(e) {
        const suggestionsList = document.getElementsByClassName('pac-container')[0];
        if (!suggestionsList) return;

        suggestions = suggestionsList.getElementsByClassName('pac-item');
        
        // Handle special keys
        switch(e.key) {
            case 'ArrowDown':
                // Only prevent default if suggestions are showing
                if (suggestions.length > 0) {
                    e.preventDefault();
                    focusedIndex = Math.min(focusedIndex + 1, suggestions.length - 1);
                    updateFocus();
                }
                break;

            case 'ArrowUp':
                // Only prevent default if suggestions are showing
                if (suggestions.length > 0) {
                    e.preventDefault();
                    focusedIndex = Math.max(focusedIndex - 1, -1);
                    updateFocus();
                }
                break;

            case 'Enter':
                // Only prevent default if a suggestion is focused
                if (focusedIndex > -1 && suggestions.length > 0) {
                    e.preventDefault();
                    suggestions[focusedIndex].click();
                    focusedIndex = -1;
                }
                break;

            case 'Escape':
                focusedIndex = -1;
                addressInput.blur();
                break;
        }
    });

    // Reset focus when the input changes
    addressInput.addEventListener('input', function() {
        focusedIndex = -1;
    });


}



  function updatePatient(key) {

    if ($("#editform").valid()) {
      $("#updatepatient").addClass('disabled');
      $.ajax({
        url: '{{ url("/frontend/update-patient") }}',
        type: "post",
        data: {
          'key': key,
          'formdata': $("#editform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
            swal(data.message, {
              title: "Success!",
              text: data.message,
              icon: "success",
              buttons: false,
              timer: 2000 // Closes after 2 seconds
            }).then(() => {
              window.location.reload();
            });

           
          } else {
            swal({
              icon: 'error',
              text: data.message,
            });
          }
        },
        error: function(xhr) {
               
          handleError(xhr);
        }
      });
    }
  }
  function phonenumberEdit(){
    
    var telInput = $("#phoneedit"),
        countryCodeInput = $("#countryCodeedit"),
        countryCodeShort = $("#countrycodeShort"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");

    // Get the stored country code from the hidden input
    var storedCountryCode = $("#countrycodeShort").val(); // This should be 'IN' for India
    
    // Initialize the phone input with the correct country
    telInput.intlTelInput({
        autoPlaceholder: "polite",
        initialCountry: storedCountryCode.toLowerCase(), // Convert to lowercase as required by the plugin
        formatOnDisplay: false,
        autoHideDialCode: true,
        onlyCountries: onlyCountriesx,
        nationalMode: false,
        numberType: "MOBILE",
        separateDialCode: true,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Set initial values based on stored data
    var initialCountryData = telInput.intlTelInput("getSelectedCountryData");
    countryCodeInput.val(initialCountryData.dialCode);
    countryCodeShort.val(initialCountryData.iso2.toUpperCase());

    // Update state fields visibility based on initial country
    if (initialCountryData.dialCode == "1") {
        $("#statelist").show();
        $("#statesel").hide();
    } else {
        $("#statelist").hide();
        $("#statesel").show();
    }

    var reset = function() {
        telInput.removeClass("error");
        errorMsg.addClass("hide");
        validMsg.addClass("hide");
    };

    telInput.on("countrychange", function(e, countryData) {
        countryCodeShort.val(countryData.iso2.toUpperCase());
        countryCodeInput.val(countryData.dialCode);
        updateAutocompleteCountry();
        
        if (countryData.dialCode == "1") {
            $("#statelist").show();
            $("#statesel").hide();
        } else {
            $("#statelist").hide();
            $("#statesel").show();
        }
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

    var whatsappInput = $("#whatsappedit"),
        whatsappCountryCodeInput = $("#whatsappeditcountryCode"),
        whatsappCodeShort = $("#whatsappcountryCodeShorts"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");

      // initialise plugin
      whatsappInput.intlTelInput({
      autoPlaceholder: "polite",
      initialCountry: "us",
      formatOnDisplay: false, // Enable auto-formatting on display
      autoHideDialCode: true,
      defaultCountry: "auto",
      ipinfoToken: "yolo",
      onlyCountries: onlyCountriesx,
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
      whatsappInput.removeClass("error");
      errorMsg.addClass("hide");
      validMsg.addClass("hide");
    };

    whatsappInput.on("countrychange", function(e, countryData) {
      var countryShortCode = countryData.iso2;
      whatsappCodeShort.val(countryShortCode);
      whatsappCountryCodeInput.val(countryData.dialCode);

    });

    whatsappInput.blur(function() {
      reset();
      if ($.trim(whatsappInput.val())) {
        if (whatsappInput.intlTelInput("isValidNumber")) {
          validMsg.removeClass("hide");
        } else {
          whatsappInput.addClass("error");
          errorMsg.removeClass("hide");
        }
      }
    });

    $('#iswhatsapp').change(function () {
      if ($(this).is(':checked')) {
        var fullPhoneNumber = $('#phoneedit').val();

        whatsappInput.val(fullPhoneNumber); // Set WhatsApp number
        var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
        whatsappInput.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
      } else {
        whatsappInput.val(''); // Clear WhatsApp input if unchecked
        whatsappCountryCodeInput.val('+1'); // Reset WhatsApp country code (optional default)
        whatsappInput.intlTelInput("setCountry", "us"); // Reset to a default country if needed
      }
    });
    $('#phone').on('keyup', function () {
      if ($(this).val != '' && $('#iswhatsapp').is(':checked')) {
        var fullPhoneNumber = $('#phoneedit').val();

        whatsappInput.val(fullPhoneNumber); // Set WhatsApp number
        var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
        whatsappInput.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
      } else {
        whatsappInput.val(''); // Clear WhatsApp input if unchecked
        whatsappCountryCodeInput.val('US'); // Reset WhatsApp country code (optional default)
        whatsappInput.intlTelInput("setCountry", "us"); // Reset to a default country if needed
      }
    });
  }
  $(document).ready(function() {
    phonenumberEdit()
   

  });
</script>

<style>
    /* Fix Google Autocomplete dropdown inside modal */
    .pac-container {
        z-index: 9999 !important;
    }
</style>