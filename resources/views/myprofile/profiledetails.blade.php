<?php $corefunctions = new \App\customclasses\Corefunctions; ?>

<div class="tab-pane show active" id="pills-clinicprofile" role="tabpanel" aria-labelledby="pills-clinicprofile-tab">
    <div class="row g-3"> 
        <div class="col-12 col-lg-12"> 
            <div class="border rounded-4 p-4 h-100">
                <div class="row align-items-center profiledetails">
                    <div class="col-12 col-lg-12">
                        <div class="d-flex justify-content-between align-items-center flex-wrap profiledetails">
                            <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                                <div class="text-lg-start text-center image-body">
                                    <img @if($doctorDetails['logo_path'] !='') src="{{asset($doctorDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif   class="user-img" alt="">
                                </div>
                                <div class="user_details text-xl-start text-center pe-xl-4">
                                    <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                        <h5 class="fw-medium dark text-wrap mb-0">{{$corefunctions -> showClinicanName($doctorDetails,1)}}</h5>
                                        <small class="md-label mb-0">@if(isset($doctorDetails['doctor_specialty']['specialty_name'])) {{$doctorDetails['doctor_specialty']['specialty_name']}} @else -- @endif</small>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_alignbox">
                                <a id="docemailButton" class="btn opt-btn align_middle profiledetails"><span class="material-symbols-outlined"> mail </span></a>
                                <a class="btn opt-btn align_middle profiledetails" onclick="editDoctorForm('{{$doctorDetails['clinic_user_uuid']}}')"> <span class="material-symbols-outlined">edit</span>  </a>
                            </div>
                        </div>
                    </div>
                    <div class="gray-border my-4"></div>
                    <div class="col-12 col-lg-4">
                        <div class="text-start mb-lg-0 mb-4"> 
                            <label class="md-label mb-1">Email</label>
                            <h6 class="fw-medium mb-0">{{$doctorDetails['email'] ?? "--"}}</h6>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="text-start mb-lg-0 mb-4"> 
                            <label class="md-label mb-1">Phone Number</label>
                            <h6 class="fw-medium mb-0">@if(!empty($doctorDetails)){{$doctorDetails['country_code']}} @endif <?php echo $corefunctions->formatPhone($doctorDetails['phone_number']) ?></h6>
                        </div>
                    </div>
                    @if($doctorDetails['user_type_id'] != '3')
                    <div class="col-12 col-lg-4">
                        <div class="text-start mb-lg-0 mb-4"> 
                            <label class="md-label mb-1">NPI</label>
                            <h6 class="fw-medium mb-0">{{$doctorDetails['npi_number'] ?? "--"}}</h6>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="row align-items-center editprofile" id="editprofile" style="display: none;" >
                    <form method="POST" id="edituserform" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="create-profile mb-4">
                                <div class="profile-img position-relative"> 
                                    <img id="doctorimage" @if($doctorDetails['logo_path'] !='')  src="{{asset($doctorDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                                    <a  href="{{ url('crop/doctor')}}" id="upload-img" class="aupload"  @if($doctorDetails['logo_path'] !='') style="display:none;" @endif><img id="userimg"src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                                    <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" @if($doctorDetails['logo_path'] !='') style="" @else style="display:none;" @endif onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>
                                </div>
                                <input type="hidden" id="tempimage" name="tempimage" value="">
                                <input type="hidden" name="isremove" id="isremove" value="0">
                            </div>
                            <div class="col-12 col-lg-6"> 
                                <div class="form-group form-outline mb-4">
                                    <label for="input" class="float-label">First Name</label>
                                    <i class="fa-solid fa-circle-user"></i>
                                    <input type="text" class="form-control" id="username" name ="username" value="{{$doctorDetails['user']['first_name']}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6"> 
                                <div class="form-group form-outline mb-4">
                                    <label for="last_name" class="float-label">Last Name</label>
                                    <i class="fa-solid fa-circle-user"></i>
                                    <input type="text" class="form-control" id="last_name" name ="last_name" value="{{$doctorDetails['user']['last_name']}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6"> 
                                <div class="form-group form-outline mb-4">
                                    <label for="input" class="float-label">Email</label>
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" class="form-control" id="email" name="email" value="{{$doctorDetails['email']}}">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6"> 
                                <div class="form-group form-outline mb-4">
                                    <!-- <label for="input" class="float-label">Phone Number</label> -->
                                    <div class="country_code phone">
                                        <input type="hidden" class="autofillcountry" id="countryCodes" name="countrycode" value={{ isset($doctorDetails['short_code'])  ? $doctorDetails['short_code'] : 'US' }} >
                                    </div>
                                    <i class="material-symbols-outlined me-2">call</i> 
                                    <input type="text" class="form-control phone-number" id="phone_number_edit" name="phone_number" placeholder="Phone Number"  value="<?php echo isset($doctorDetails['country_code'])  ? $doctorDetails['country_code'] . $doctorDetails['phone_number'] : $doctorDetails['phone_number'] ?>"   >
                                </div>
                            </div>

                            <input type="hidden" name="user_type_id" id="user_type_id" value="{{$doctorDetails['user_type_id']}}" >

                            <div class="col-12 " @if($doctorDetails['user_type_id'] == '1') style="display:block;" @else style="display:none;" @endif> 
                                <div class="form-check d-flex align-items-center gap-3 mb-4">
                                    <input class="form-check-input mt-0" name="is_licensed_practitioner" type="checkbox" id="is_licensed_practitioner" @if( $doctorDetails['is_licensed_practitioner'] == '1') checked @endif>
                                    <label class="form-check-label mt-0" for="is_licensed_practitioner" style="font-size: 1rem; color: #222;">
                                        Are you a licensed medical practitioner?
                                    </label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 npicls licensedcls" @if($doctorDetails['is_licensed_practitioner'] == '1' )  style="display:block;" @else style="display:none;" @endif>
                                <div class="form-group form-outline mb-4">
                                    <label for="input" class="float-label">NPI</label>
                                    <i class="material-symbols-outlined">diagnosis</i>
                                    <input type="text" class="form-control" id="npi_number" value="{{$doctorDetails['npi_number']}}" name="npi_number" maxlength="10">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 licensedcls" @if(($doctorDetails['user_type_id'] == '1' || $doctorDetails['user_type_id'] == '2' ) && ($doctorDetails['is_licensed_practitioner'] == '1' )) style="display:block;" @else style="display:none;" @endif> 
                                <div class="form-group form-floating mb-4">
                                    <i class="material-symbols-outlined">id_card</i>
                                    <select name="designation" id="designation" class="form-select">
                                        <option value="">Select a designation</option>
                                        @if(!empty($designation))
                                        @foreach($designation as $dgn)
                                            <option value="{{$dgn['id']}}" @if($doctorDetails['designation_id'] == $dgn['id']) selected @endif>{{$dgn['name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label class="select-label">Designation</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 cmncls licensedcls" @if(($doctorDetails['user_type_id'] == '1' || $doctorDetails['user_type_id'] == '2' ) && ($doctorDetails['is_licensed_practitioner'] == '1' )) style="display:block;" @else style="display:none;" @endif>
                                <div class="form-group form-floating mb-4">
                                    <i class="material-symbols-outlined">workspace_premium</i>
                                    <select name="speciality" id="speciality" class="form-select">
                                        <option value="">Select a Specialty</option>
                                        @foreach ($specialties as $specialty)
                                        <option value="{{$specialty['id']}}" {{$doctorDetails['specialty_id'] == $specialty['id'] ? 'selected': ''}} >{{$specialty['specialty_name']}}</option>
                                        @endforeach
                                    </select>
                                    <label class="select-label">Specialty</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 licensedcls" @if($doctorDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
                                <div class="form-group form-outline mb-4">
                                    <label for="dob" class="float-label">Date of Birth</label>
                                    <i class="material-symbols-outlined">date_range</i>
                                    <input type="text" name="dob" id="dobedit" class="form-control" value="@if( isset( $doctorDetails['user']['dob']) && $doctorDetails['user']['dob'] != '') {{date('m/d/Y', strtotime($doctorDetails['user']['dob']))}} @endif">
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 licensedcls" @if($doctorDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
                                <div class="form-group form-outline mb-4 useraddresserr">
                                    <label for="aduser_addressdress" class="float-label">Address</label>
                                    <i class="material-symbols-outlined">home</i>
                                    <input type="text" class="form-control useraddress" id="address" name="address" @if( isset( $doctorDetails['user']['address'])) value="{{$doctorDetails['user']['address']}}" @endif>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 licensedcls" @if($doctorDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
                                <div class="form-group form-outline mb-4">
                                    <label for="user_fax" class="float-label">Fax</label>
                                    <i class="material-symbols-outlined">fax</i>
                                    <input type="text" class="form-control" id="fax" name="fax" @if( isset( $doctorDetails['user']['fax']) ) value="{{$doctorDetails['user']['fax']}}" @endif>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 licensedcls" @if($doctorDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
                                <div class="form-group form-outline mb-4">
                                    <label for="city" class="float-label">City</label>
                                    <i class="material-symbols-outlined">location_city</i>
                                    <input type="text" class="form-control" id="city" name="city" @if( isset( $doctorDetails['user']['city']) )  value="{{$doctorDetails['user']['city']}}"  @endif>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 licensedcls statelist" id="states" @if(isset($doctorDetails['country_code']) && ($doctorDetails['country_code'] == '+1' || $doctorDetails['country_code'] == '1') && $doctorDetails['is_licensed_practitioner'] == 1 ) style="display:block;" @else style="display:none;" @endif>
                                <div class="form-group form-floating mb-4">
                                    <i class="material-symbols-outlined">map</i>
                                    <select name="state_id" id="state_id" class="form-select">
                                        <option value="">Select State</option>
                                        @if(!empty($stateDetails))
                                        @foreach($stateDetails as $sds)
                                        <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}" @if( $doctorDetails['user']['state_id'] == $sds['id'] ) selected @endif>{{ $sds['state_name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label class="select-label">State</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 statesel" id="user_stateOther" style="display: none;">
                                <div class="form-group form-outline mb-4">
                                    <label for="state" class="float-label">State</label>
                                    <i class="material-symbols-outlined">map</i>
                                    <input type="text" name="state" class="form-control" id="state" @if( isset( $doctorDetails['user']['state']) ) value="{{$doctorDetails['user']['state']}}" @endif>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 licensedcls" @if($doctorDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
                                <div class="form-group form-outline mb-4">
                                    <label for="user_zip_zipcode" class="float-label">Zip</label>
                                    <i class="material-symbols-outlined">home_pin</i>
                                    <input type="text" class="form-control" id="zip" name="zip" @if( isset( $doctorDetails['user']['zip_code']) ) value="{{$doctorDetails['user']['zip_code']}}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="btn_alignbox justify-content-end mt-3">
                            <a href="javascript:void(0)" class="btn btn-outline-primary" onclick="cancelUser()">Close</a>
                            <a href="javascript:void(0)" id="updatedoctr" onclick="updateUser('{{$doctorDetails['clinic_user_uuid']}}')" class="btn btn-primary">Submit</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script>

$('#dobedit').datetimepicker({
      format: 'MM/DD/YYYY',
            useCurrent: false, 
            // todayHighlight: true,
            // autoclose: true,
            viewDate   : moment('01/01/2015', 'MM/DD/YYYY'),                                 
    });
      function doctorImage(imagekey, imagePath) {
        console.log(imagePath);
        $("#tempimage").val(imagekey);
        $("#doctorimage").attr("src", imagePath);
        $("#doctorimage").show();
        $("#upload-img").hide();
        $("#removelogo").show();
    }

    function removeImage(){
        $("#doctorimage").attr("src","{{asset('images/default_img.png')}}");
        $("#isremove").val('1');
        $("#removelogo").hide();
        $("#upload-img").show();
    }
    $(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });
   $('#is_licensed_practitioner').change(function() {
        if ($(this).is(':checked')) {
            $('.licensedcls').show();
            $(".dtrcls").show();
            $(".cmncls").show();
        } else {
            $('.licensedcls').hide();
            var userType = $("#user_type_id").val();
            if(userType == '1' || userType == '2'){
                $(".dtrcls").hide();
                $(".cmncls").hide();
            }
            
        }
      

    });
  function editDoctorForm(){
    $(".profiledetails").hide();
    $(".editprofile").show();
    $('#edituserform')[0].reset();
    $('#edituserform').validate().resetForm();

    tellinputPhoneEdit();
  
  }
  function cancelUser(){
    $(".profiledetails").show();
    $(".editprofile").hide();
    $("#phone_number_edit").intlTelInput("destroy");
    $('#phone_number_edit').unmask();
  }
    function updateUser(key) {
        if ($("#edituserform").valid()) {
            $("#updatedoctr").addClass('disabled');
            $("#updatedoctr").text("Submitting..."); 
            $.ajax({
                url: '{{ url("/users/updateprofile") }}',
                type: "post",
                data: {
                    'key' : key,
                'formdata': $("#edituserform").serialize(),
                '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                if (data.success == 1) {
                    // window.location.reload();
                    swal({
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
                        title: "Error!",
                        text: data.message,
                        icon: "error",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                        window.location.reload();
                    });
                    
                }
                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
        }
    }
    function tellinputPhoneEdit(){
        var telInput = $("#phone_number_edit"),
        countryCodeInput = $("#countryCodes"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");
        // initialise plugin
        let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
        telInput.intlTelInput({
            autoPlaceholder: "polite",
            initialCountry: "us",
            formatOnDisplay: false, // Enable auto-formatting on display
            autoHideDialCode: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",
            onlyCountries: onlyCountries,
            nationalMode: true,
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
            updateAutocompleteCountry()
            if(countryData.dialCode == 1 ){
                $("#statelist").show();
                $("#statesel").hide();
            }else{
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

        telInput.on("keyup change", reset);


        $('#phone_number_edit').mask('(ZZZ) ZZZ-ZZZZ', {
        
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: false
            }
        }
    });
      
  
        
    }
    $(document).ready(function() {
       
        initializeAutocomplete();
        // tellinputPhoneEdit();
        
    
        $("#edituserform").validate({
            rules: {
              username: {
                    required: true,
                },
                user_type_id: {
                    required: true,
                },
                email: {
                    required: true,
                    customemail: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                            'type' : 'other',
                            "id":"{{$doctorDetails['user_id']}}",
                            'country_code': function () {
                                return $("#countryCodes").val(); // Get the updated value
                            },
                            'phone_number': function () {
                                return $("#phone_number_edit").val(); // Get the updated value
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
                department: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                designation: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                speciality: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                // qualification: {
                //     required: function(element) {
                //         return $(element).is(":visible");
                //     },
                // },
                phone_number: {
                    required: true,
                    NumberValids: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                            "id":"{{$doctorDetails['user_id']}}",
                            'type': 'other', // Replace with actual type if necessary
                            'country_code' : function () {
                              return $("#countryCode").val(); // Get the updated value
                            },  
                            'email': function () {
                                return $("#email").val(); // Get the updated value
                            },
                            '_token': $('input[name="_token"]').val() // CSRF token
                        
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

                npi_number: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                    number: true
                },

                address: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },

                city: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                state_id: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                state: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                zip: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                dob: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                    dobRange: {
                        depends: function (element) {
                            return $(element).is(":visible");
                    
                        }
                    },
                },
                fax: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                    faxPattern: function(element) {
                        return $(element).is(":visible");
                    },
                    
                },
              

                
            },
            messages: {

                fax: {
                    required: 'Please enter fax.',
                    faxPattern :'Please enter a valid fax number',
                },
                dob: {
                    required: 'Please enter date of birth.',
                    dobRange: 'Invalid birth year. Please choose a year from 1900 to 2015.',
                },
                address: "Please enter address.",
                city: "Please enter city.",
                state: "Please enter state.",
                state_id: 'Please enter state',
                zip: "Please enter zip.",
                npi_number: {
                    required: "Please enter NPI number.",
                    number: "Please enter a valid NPI number."
                },
                phone_number: {
                    required: 'Please enter phone number.',
                    NumberValids: 'Please enter a valid number.',
                    remote: "Phone number already exists in the system." 
                },
                username: {
                    required: 'Please enter name.',
                },
                email: {
                    required: 'Please enter email.',
                    customemail: "Please enter a valid email",
                    remote: "Email id already exists in the system."
                },
                department: {
                    required: 'Please enter department.',
                },
                designation: {
                    required: 'Please select designation.',
                },
                speciality: {
                    required: 'Please enter speciality.',
                },
                qualification: {
                    required: 'Please enter qualification.',
                },user_type_id: {
                    required: 'Please select user type.',
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
        $.validator.addMethod(
        'dobRange',
        function (value, element) {
            if (this.optional(element)) return true;          // allow empty
            const date = moment(value, 'MM/DD/YYYY', true);   // strict parse
            return date.isValid() &&
                    date.isSameOrAfter('1900-01-01') &&
                    date.isSameOrBefore('2015-12-31');
        },
        'Date of Birth must be between 01/01/1900 and 12/31/2015'
    );

    $.validator.addMethod("faxPattern",function (value, element) {
                return this.optional(element) || /^\+?[0-9\s\-\(\)]{6,20}$/.test(value);
            },
            "Please enter a valid fax number."
        );

        jQuery.validator.addMethod("customemail", function(value, element) {
            // Regex explanation below
            const regex = /^[a-zA-Z0-9][a-zA-Z0-9._%+-]*@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return this.optional(element) || regex.test(value);
        }, "Please enter a valid email address.");
       
        jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
            return this.optional(element) || phone_number.length < 14 &&
                phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
        });
    });

      $('#docemailButton').click(function() {
            
            const recipientEmail = '{{$doctorDetails['email']}}';
            const recipientName = '{{$doctorDetails['first_name']}} {{$doctorDetails['last_name']}}';
            const subject = 'Your Subject Here';
            const body = 'Your message here...';
            const mailtoLink = `mailto:${recipientName} <${recipientEmail}>?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;

            window.location.href = mailtoLink;
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
