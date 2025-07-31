<h4 class="text-center fw-medium mb-0 ">Add New Patient</h4>
                            <small class="gray">Please enter the patient’s details</small>
                            
                            <!-- <div class="import_section">
                                <a onclick="importPatient()" class="btn btn-outline-primary d-flex align-items-center" ><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a>
                            </div> -->
                              <form id="patientform" method="POST" > 
                              @csrf

                               <div class="create-profile mt-5">
                                <!--<div class="profile-img position-relative"> 
                                  <img id="patientimage" src="{{asset('images/default_img.png')}}" class="img-fluid">
                                  <a  href="{{ url('crop/patient')}}" id="upload-img" class="aupload"><img id="patientimg"src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                                  <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" style="display:none;"  onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

                                </div>

                                

                                <input type="hidden" id="tempimage" name="tempimage" value="">
                                <input type="hidden" name="isremove" id="isremove" value="0"> -->
                              </div>

                                <div class="row mt-5"> 
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="input" class="float-label">First Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text"  name="name" class="form-control" id="exampleFormControlInput1">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="input" class="float-label">Middle Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text" name="middle_name" class="form-control" id="middle_name">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="input" class="float-label">Last Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text"  name="last_name" class="form-control" id="last_name">
                                    </div>
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group form-floating mb-4">
                                        <i class="material-symbols-outlined">id_card</i>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">Select Gender</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="3">Other</option>
                                        </select>
                                        <label class="select-label">Gender</label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group form-outline mb-4">
                                      <label for="email" class="float-label">Email</label>
                                      <i class="fa-solid fa-envelope"></i>
                                      <input type="email" name="email" id="email"class="form-control" >
                                    </div>
                                  </div>
                                  <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                  <div class="col-12">
                                    <div class="form-group form-outline form-dropdown mb-4">
                                        <label for="input" id="select_doctor_label">Tag A Clinician</label>
                                        <i class="material-symbols-outlined">stethoscope</i>
                                        <input id="doctor_input" type="hidden" name="doctor">
                                        <div class="dropdownBody">
                                            <div class="dropdown">
                                                <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                                </a>

                                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                                    <li class="dropdown-item">
                                                        <div class="form-outline input-group ps-1">
                                                          <div class="input-group-append">
                                                            <button class="btn border-0" type="button">
                                                              <i class="fas fa-search fa-sm"></i>
                                                            </button>
                                                          </div>
                                                          <input id="search_doctor" name="search_doctor" class="form-control border-0 small" type="text" placeholder="Search Clinician" aria-label="Search" aria-describedby="basic-addon2">
                                                          <span id="clear_search" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);cursor: pointer; z-index: 10; display: none;">
                                                            <i class="fas fa-times-circle text-muted"></i>
                                                          </span>
                                                        </div>
                                                    </li>

                                                    <div id="search_li_doctor">

                                                        @foreach ($doctors as $doctor)
                                                        <li id="{{$doctor['user_uuid']}}" class="dropdown-item  select_doctor_list" style="cursor:pointer">

                                                            <div class="dropview_body profileList">
                                                                <!-- <img src="{{asset('images/patient1.png')}}" class="img-fluid"> -->

                                                                <p class="select_doctor_item" data-id="{{$doctor['userID']}}">{{ $corefunctions -> showClinicanNameUser($doctor,'1');}}</p>

                                                            </div>

                                                        </li>
                                                        @endforeach

                                                        @if (empty($doctors))
                                                        <li class="dropdown-item">

                                                            <div class="dropview_body profileList justify-content-center">

                                                                <p>No clinicians found</p>

                                                            </div>

                                                        </li>
                                                        @endif

                                                    </div>


                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4 mb-md-2">
                                      <label for="dob" class="float-label">Date of Birth</label>
                                      <i class="material-symbols-outlined">date_range</i>
                                      <input type="text" name="dob" id="dob" class="form-control">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline phoneregcls mb-4 mb-md-2">
                                      <div class="country_code phone">
                                          <input type="hidden" id="countryCode" name="countrycode" value='US' class="autofillcountry">
                                      </div>
                                      <!-- <label for="phone" class="float-label">Phone Number</label> -->
                                      <i class="material-symbols-outlined me-2">call</i> 
                                      <input type="text" placeholder="Phone Number" name="phone_number" class="form-control phone-number" id="phone">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-2">
                                    <div class="country_code phone">
                                          <input type="hidden" id="whatsappcountryCode" name="whatsappcountryCode" value='US'>
                                      </div>
                                      <!-- <label for="whatsapp" id="whatapplabel" class="float-label">Whatsapp</label> -->
                                      <i class="fa-brands fa-whatsapp me-2"></i>
                                      <input type="text" name="whatsapp_num"  placeholder="Whatsapp Number" class="form-control whats whatsapp-phone-numbercls" id="whatsapp">
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="d-flex justify-content-end align-items-center mb-4">
                                      <input class="form-check-input btn-outline-checkbox m-0 me-2" name="iswhatsapp" id="iswhatsapp" type="checkbox" value="">
                                      <samll class="primary fw-medium">Same as phone number</samll>
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="form-group form-outline textarea-align mb-4">
                                      <label for="address" class="float-label">Address</label>
                                      <i class="material-symbols-outlined">home</i>
                                      <textarea name="address" id="address" class="form-control" rows="1"></textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="city" class="float-label">City</label>
                                      <i class="material-symbols-outlined">location_city</i>
                                      <input type="text" name="city" class="form-control" id="city">
                                    </div>
                                  </div>
                                  <div id="statesel" class="col-md-4" style="display:none;">
                                    <div class="form-group form-outline mb-4">
                                      <label for="state" class="float-label">State</label>
                                      <i class="material-symbols-outlined">map</i>
                                      <input type="text" name="state" class="form-control" id="state">
                                    </div>
                                  </div>

                                  <div id="statelist" class="col-md-4" style="display:block;" > 
                                      <div class="form-group form-floating mb-4">
                                          <i class="material-symbols-outlined">id_card</i>
                                          <select name ="state_id" id="state_id" class="form-select">
                                              <option value="">Select a state</option>
                                              @if(!empty($state))
                                                @foreach($state as $sts)
                                                  <option value="{{$sts['id']}}" data-shortcode="{{$sts['state_name']}}">{{$sts['state_name']}}</option>
                                                @endforeach
                                              @endif
                                          </select>
                                          <label class="select-label">State</label>
                                      </div>
                                  </div>


                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="zip" class="float-label">Zip</label>
                                      <i class="material-symbols-outlined">home_pin</i>
                                      <input type="text" name="zip" class="form-control" id="zip">
                                    </div>
                                  </div>

                                    <?php /* <div class="col-12">
                                      <div class="d-flex justify-content-end align-items-center mb-3">
                                        <a onclick="addnotes('add')" class="primary fw-medium btn_inline" id="add"><span class="material-symbols-outlined"> add </span>Add Notes</a>
                                        <a onclick="addnotes('rmv')" class="danger fw-medium btn_inline" style="display:none;" id="remove"><span class="material-symbols-outlined">delete</span>Remove Notes</a>
                                      </div>
                                      <div class="form-group form-outline form-textarea mb-4"  style="display:none;" id="addnotes">
                                        <label for="note" class="float-label">Notes</label>
                                        <i class="fa-solid fa-file-lines"></i>
                                        <textarea class="form-control" name="note" id="note" rows="4" cols="4"></textarea>
                                      </div>
                                    </div> */ ?>

                                    <!-- <div class="col-12">
                                      <div class="dropzone-wrapper mb-4 dropzone custom-dropzone" id="patientDocs"> -->
                                        <!-- <a href="" class="gray fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add patient files</a> -->
                                      <!-- </div>
                                      <div class="files-container mb-3" id="appenddocs" >
                                        
                                     

                                      </div>
                                    </div> -->
                                    
                                  <input type="hidden" name="createdfrom" id="createdfrom" value="{{$createdfrom}}">
                         
                                  <div class="col-12">
                                    <div class="btn_alignbox justify-content-end">
                                      <a href="" class="btn btn-outline-primary">Close</a>
                                      <a onclick="submitPatient('{{$type}}')" id="submitpatient" class="btn btn-primary">Submit</a>
                                    </div>
                                    
                                  </div>
                                </div>

                            </form>
                            <!--  -->
                           

  @php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp

<script>

  // Dropzone.autoDiscover = false;
  //   // Dropzone Configurations
  //   var dropzone = new Dropzone('#patientDocs', {
  //       url: '{{ url('/patients/uploaddocument') }}',
  //       addRemoveLinks: true,
  //       dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span> Add patient files', // Add class for styling
  //       headers: {
  //           'X-CSRF-TOKEN': "{{ csrf_token() }}"
  //       },
  //       init: function() {
  //        this.on("sending", function(file, xhr, formData) {
  //                 // Extra data to be sent with the file
  //                 formData.append("formdata", $('#createinquiry').serialize());
  //               });
  //           this.on("removedfile", function(file) {
  //               $(".remv_" + file.filecnt).remove();
  //           });
  //           var filecount = 1;
  //           this.on('success', function(file, response) {
  //               if( response.success == 1){
              
  //               this.removeFile(file);
  //               file.filecnt = filecount;
  //               if(response.ext == 'png'){
  //                 var imagePath = "{{ asset('images/png_icon.png') }}";
  //               }else if(response.ext == 'jpg'){
  //                 var imagePath = "{{ asset('images/jpg_icon.png') }}";
  //               }else if(response.ext == 'pdf'){
  //                 var imagePath = "{{ asset('images/pdf_img.png') }}";
  //               }else if(response.ext == 'xlsx'){
  //                 var imagePath = "{{ asset('images/excel_icon.png') }}";
  //               }else{
  //                 var imagePath = "{{ asset('images/doc_image.png') }}";
  //               }
  //               console.log(response.ext)
  //               var appnd = '<div class="fileBody" id="doc_'+filecount+ '"><div class="file_info"><img src="'+imagePath+ '"><span>'+ response.docname +'</span>' +
  //                           '</div><a onclick="removeImageDoc('+filecount+')"><span class="material-symbols-outlined">close</span></a></div>'+
  //                           '<input type="hidden" name="patient_docs[' + filecount +'][tempdocid]" value="' + response.tempdocid + '" >';

  //               $("#appenddocs").append(appnd);
  //               filecount++
  //               // $("#docuplad").val('1');
  //               // $("#docuplad").valid();
  //            }else{
  //               if (typeof response.error !== 'undefined' && response.error !== null && response.error == 1 ) {
  //                   swal(response.errormsg);
  //                    this.removeFile(file);
  //               }
  //           }
  //           });
  //       },
  //   });
    jQuery.browser = {};
    (function() {
      jQuery.browser.msie = false;
      jQuery.browser.version = 0;
      if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
      }
    })();
    function removeImageDoc(count){
      $("#doc_"+count).remove();
    }
   $(document).ready(function() {
    $(document).on('click', '.select_doctor_list', function() {
      var doctorItem = $(this).find('.select_doctor_item').text();
      var doctorId = $(this).find('.select_doctor_item').data('id');
      $('#select_doctor_label').text(doctorItem);
      $('#doctor_input').val(doctorId);
      $("#doctor_input").valid();
    })
    const $input = $('#search_doctor');
    const $clear = $('#clear_search');

    // Show/hide clear icon based on input
    $input.on('input', function () {
      $clear.toggle($(this).val().length > 0);
    });

    // Clear input when icon is clicked
    $clear.on('click', function () {
      $input.val('').trigger('input').focus();
    });

    var telInput = $("#phone"),
    countryCodeInput = $("#countryCode"),
    errorMsg = $("#error-msg"),
    validMsg = $("#valid-msg"),
    whatsappInput = $("#whatsapp"),
    whatsappCountryCodeInput = $("#whatsappcountryCode");
    let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
    // Initialise plugin for phone number
    telInput.intlTelInput({
        autoPlaceholder: "polite",
        initialCountry: "us",
        formatOnDisplay: true,
        autoHideDialCode: true,
        defaultCountry: "auto",
        onlyCountries: onlyCountries,
        nationalMode: false,
        separateDialCode: true,
        geoIpLookup: function(callback) {
            $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });
    $('#search_doctor').on('keyup', function() {
      var type = 'doctor';
      var searchData = $('#search_doctor').val();
      $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "{{url('/appointments/search')}}" + "/" + type,
        data: {
            'search': searchData
        },
        success: function(response) {
            console.log(response);
            // Replace the dropdown items with the new HTML
            $('#search_li_doctor').html(response.view);
        },
        error: function(xhr) {
            
            handleError(xhr);
        },
      })
    })

// Handle country change event
telInput.on("countrychange", function(e, countryData) {
 

    countryCodeInput.val(countryData.iso2);
    updateAutocompleteCountry()
    if(countryData.dialCode == 1 ){
      $("#statelist").show();
      $("#statesel").hide();
    }else{
      $("#statelist").hide();
      $("#statesel").show();
    }
    // If checkbox is checked, update WhatsApp country code too
    if ($("#iswhatsapp").is(':checked')) {
        whatsappCountryCodeInput.val(countryData.iso2);
    }
});

// Reset error messages
var reset = function() {
    telInput.removeClass("error");
    errorMsg.addClass("hide");
    validMsg.addClass("hide");
};

// Validate phone number
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

// Similar setup for WhatsApp input
whatsappInput.intlTelInput({
    autoPlaceholder: "polite",
    initialCountry: "us",
    formatOnDisplay: true,
    autoHideDialCode: true,
    onlyCountries: onlyCountries,
    nationalMode: false,
    separateDialCode: true,
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

whatsappInput.on("countrychange", function(e, countryData) {
    whatsappCountryCodeInput.val(countryData.iso2);
});

    $('#iswhatsapp').change(function() {
      if ($(this).is(':checked')) {
        var fullPhoneNumber = $('#phone').val();
        whatsappInput.val(fullPhoneNumber); // Set WhatsApp number
        var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
        whatsappInput.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
      } else {
        whatsappInput.val(''); // Clear WhatsApp input if unchecked
        whatsappCountryCodeInput.val('US'); // Reset WhatsApp country code (optional default)
        whatsappInput.intlTelInput("setCountry", "us"); // Reset to a default country if needed
      }
    });
    $('#phone').on('keyup', function () {
      if ($(this).val != '' && $('#iswhatsapp').is(':checked')) {
        var fullPhoneNumber = $('#phone').val();
        whatsappInput.val(fullPhoneNumber); // Set WhatsApp number
        var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
        whatsappInput.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
      } else {
        whatsappInput.val(''); // Clear WhatsApp input if unchecked
        whatsappCountryCodeInput.val('US'); // Reset WhatsApp country code (optional default)
        whatsappInput.intlTelInput("setCountry", "us"); // Reset to a default country if needed
      }
    });
    $('#phone, #whatsapp').mask('(ZZZ) ZZZ-ZZZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/,
          optional: false
        }
      }
    });



    $("#patientform").validate({
      ignore: [],
            rules: {
              name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
               
                email: {
                    required: true,
                    // customemail: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                             'type': 'patient',
                             'field_type' : 'patient_email',
                            'country_code': function () {
                                return $("#countryCode").val(); // Get the updated value
                            },
                            'phone_number': function () {
                                return $("#phone").val(); // Get the updated value
                            },
                            '_token': $('input[name=_token]').val()
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
                },
                doctor: "required",
                gender: {
                    required: true,
                },
                dob: {
                    required: true,
                },
                whatsapp_num:{
                    NumberValids: true,
                },
                phone_number: {
                    required: true,
                    NumberValids: true,
                    remote: {
                     
                    url: "{{ url('/validateuserphone') }}",
                    type: "post",
                    data: {
                        'type': 'patient',
                        'field_type' : 'patient_phone',
                        'email': function () {
                            return $("#email").val(); // Get the updated value
                        },
                        'country_code': function () {
                            console.log('country code sent:', $("#countryCode").val());
                            return $("#countryCode").val();
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
                address: {
                    required: true,
                },
                city: {
                    required: true,
                },
                state: {
                  required: {
                            depends: function(element) {
                              console.log($("#countryCode").val())
                                return (($("#countryCode").val() != 'US'));
                             
                            }
                    },
                },
             
                state_id: {
                    required: {
                        depends: function(element) {
                            // Trim and check the country code value
                            const countryCode = $.trim($("#countryCode").val());
                            console.log("Country Code:", countryCode);  // Log for verification
                            return (countryCode === 'US' );
                        }
                    }
                },
                zip: {
                    required: true,
                    number : true,
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
                doctor: "Please select a clinician.",
                gender: {
                    required: 'Please select gender.',
                },
                dob: {
                    required: 'Please enter date of birth.',
                },
                whatsapp_num: {
                    NumberValids: 'Please enter a valid phone number.',
                },
                phone_number: {
                    required: 'Please enter phone number.',
                    NumberValids: 'Please enter a valid phone number.',
                    remote: "Phone number already exists in the system."
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
                    required: 'Please enter zip code.',
                    number :  'Please enter valid zip code.',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-number")) {
                    // Remove previous error label to prevent duplication
                    $("#phonenumber-error").remove(); 
                    // Insert error message after the correct element
                    error.insertAfter(".phone-number");
                }else if (element.hasClass("whatsapp-phone-numbercls")) {
                  $("#whatsapp-error").remove(); 
                  error.insertAfter(".whatsapp-phone-numbercls");
                    // error.insertAfter(".separate-dial-code");
                } else {
                    error.insertAfter(element);
                }
            },
            success: function(label) {
                // If the field is valid, remove the error label
                label.remove();
            },
            onkeyup: function(element) { $(element).valid(); },
            onchange: function(element) { $(element).valid(); },
        });

        jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
          phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
          return this.optional(element) || phone_number.length < 14 &&
              phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
        });

        $('#dob').datetimepicker({
          format: 'MM/DD/YYYY',
            useCurrent: false, 
            // todayHighlight: true,
            // autoclose: true,
            maxDate: moment().endOf('day'),
            // onSelect : function() {
            //    $('#dob').valid();
            // }
           
        });
        

        $("#dob").on("change", function() {
          $('#dob').valid();
        });

      });

  function patientImage(imagekey, imagePath) {
    $("#tempimage").val(imagekey);
    $("#patientimage").attr("src", imagePath);
    $("#patientimage").show();
    $("#upload-img").hide();
    $("#removelogo").show();
  }


// Function to toggle the 'active' class

$(document).ready(function () {
        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');
    
            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }
    
        // Initialize all inputs on page load
        $('input, textarea').each(function () {
            toggleLabel(this);
        });
    
        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function () {
            toggleLabel(this);
        });
    
        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function (e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });
    });



  $("#phone").on("countrychange", function(e, countryData) {
    $('#phone').valid();
  });

  </script>