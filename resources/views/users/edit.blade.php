

<h4 class="text-center fw-medium mb-0 ">Edit User</h4>
<form method="POST" id="edituserform" autocomplete="off">
    @csrf
    <div class="row g-4">
        <div class="create-profile">
            <div class="profile-img position-relative"> 
                <img id="doctorimage" @if($userDetails['logo_path'] !='')  src="{{asset($userDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                <a  href="{{ url('crop/doctor')}}" id="upload-img" class="aupload"  @if($userDetails['logo_path'] !='') style="display:none;" @endif><img id="userimg"src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" @if($userDetails['logo_path'] !='') style="" @else style="display:none;" @endif onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>
            </div>
            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline">
                <label for="input" class="float-label">First Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="username" name ="username" value="{{$userDetails['user']['first_name']}}">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline">
                <label for="last_name" class="float-label">Last Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="last_name" name ="last_name" value="{{$userDetails['user']['last_name']}}">
            </div>
        </div>

        <div class="col-12"> 
            <div class="form-group form-outline">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control" id="email" name="email" value="{{$userDetails['email']}}">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline ">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCodes" name="countrycode" value={{ isset($userDetails['short_code'])  ? $userDetails['short_code'] : 'US' }} >
                </div>
                <i class="material-symbols-outlined me-2">call</i> 
                <input type="text" class="form-control phone-number" id="phone_number_edit" name="phone_number" placeholder="Phone Number" value="<?php echo isset($userDetails['country_code'])  ? $userDetails['country_code'] . $userDetails['phone_number'] : $userDetails['phone_number'] ?>" >
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-floating">
                <i class="material-symbols-outlined">manage_accounts</i>
                <select name="user_type_id" id="user_type_id" class="form-select" onchange="triggerFields();">
                    @if(session()->get('user.isClinicAdmin') == '1' || session()->get('user.userType') == 'doctor')
                    <option value="1" @if(isset($userDetails['user_type_id']) && $userDetails['user_type_id'] == '1') selected @endif>Admin</option>
                    @if($isAdmins > 0)
                    <option value="2" @if(isset($userDetails['user_type_id']) && $userDetails['user_type_id'] == '2') selected @endif>Provider</option>
                    <option value="3" @if(isset($userDetails['user_type_id']) && $userDetails['user_type_id'] == '3') selected @endif>Medical Assistant / Scribe </option>
                    @endif
                    @else
                    <option value="3" selected>Medical Assistant / Scribe </option>
                    @endif
                </select>
                <label class="select-label">Select a user type</label>
            </div>
        </div>

        <!-- <div class="col-12 col-lg-6" > 
            <div class="form-group form-floating">
                <input class="form-check-input" name="is_licensed_practitioner" type="checkbox" id="is_licensed_practitioner" >
                <small class="primary">Are you a licensed medical practitioner?</small>
            </div>
        </div> -->

        <!-- <div class="col-12 lincedcls" @if($userDetails['user_type_id'] == '1' ) style="display:block;" @else style="display:none;" @endif> 
            <div class="form-check d-flex align-items-center gap-3">
                <input class="form-check-input mt-0" name="is_licensed_practitioner" type="checkbox" id="is_licensed_practitioner" @if( $userDetails['is_licensed_practitioner'] ==1) checked @endif>
                <label class="form-check-label mt-0" for="is_licensed_practitioner" style="font-size: 1rem; color: #222;">
                    Is this user a licensed medical practitioner?
                </label>
            </div>
        </div>
          
        <div class="col-12 col-lg-6 npicls licensedcls" @if($userDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
            <div class="form-group form-outline">
                <label for="input" class="float-label">NPI</label>
                <i class="material-symbols-outlined">diagnosis</i>
                <input type="text" class="form-control" id="npi_number" value="{{$userDetails['npi_number']}}" name="npi_number" maxlength="10">
            </div>
        </div>
       
        <div class="col-12 col-lg-6 licensedcls" @if(($userDetails['user_type_id'] == '1' || $userDetails['user_type_id'] == '2' ) && ($userDetails['is_licensed_practitioner'] == '1' )) style="display:block;" @else style="display:none;" @endif> 
            <div class="form-group form-floating">
                <i class="material-symbols-outlined">id_card</i>
                <select name="designation" id="designation" class="form-select">
                    <option value="">Select a designation</option>
                    @if(!empty($designation))
                      @foreach($designation as $dgn)
                        <option value="{{$dgn['id']}}" @if($userDetails['designation_id'] == $dgn['id']) selected @endif>{{$dgn['name']}}</option>
                      @endforeach
                    @endif
                </select>
                <label class="select-label">Designation</label>
            </div>
        </div> -->
      

        <div class="col-12 nursecls" @if($userDetails['user_type_id'] == '3') style="display:block;" @else style="display:none;" @endif>
            <div class="form-group form-outline">
                <label for="input" class="float-label">Department</label>
                <i class="material-symbols-outlined">id_card</i>
                <input name="department" value="{{$userDetails['department']}}" class="form-control">
            </div>
        </div>
     
       
        <!-- <div class="col-12 col-lg-6 cmncls licensedcls" @if($userDetails['is_licensed_practitioner'] != 1 && $userDetails['user_type_id'] != '3')  style="display:none;" @endif>
            <div class="form-group form-floating">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="speciality" id="speciality" class="form-select">
                    <option value="">Select a Specialty</option>
                    @foreach ($specialties as $specialty)
                    <option value="{{$specialty['id']}}" {{$userDetails['specialty_id'] == $specialty['id'] ? 'selected': ''}} >{{$specialty['specialty_name']}}</option>
                    @endforeach
                </select>
                <label class="select-label">Specialty</label>
            </div>
        </div> -->


            
        <!-- <div class="col-12 col-lg-6 licensedcls" @if($userDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
            <div class="form-group form-outline">
                <label for="dob" class="float-label">Date of Birth</label>
                <i class="material-symbols-outlined">date_range</i>
                <input type="text" name="dob" id="dobedit" class="form-control" value="@if( isset( $userDetails['user']['dob']) && $userDetails['user']['dob'] != '') {{date('m/d/Y', strtotime($userDetails['user']['dob']))}} @endif">
            </div>
        </div>

        <div class="col-12 col-lg-6 licensedcls" @if($userDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
            <div class="form-group form-outline useraddresserr">
                <label for="aduser_addressdress" class="float-label">Address</label>
                <i class="material-symbols-outlined">home</i>
                <input type="text" class="form-control useraddress" id="address" name="address" @if( isset( $userDetails['user']['address'])) value="{{$userDetails['user']['address']}}" @endif>
            </div>
        </div>

        <div class="col-12 col-lg-6 licensedcls mt-4" @if($userDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
            <div class="form-group form-outline">
                <label for="user_fax" class="float-label">Fax</label>
                <i class="material-symbols-outlined">fax</i>
                <input type="text" class="form-control" id="fax" name="fax"  @if( isset( $userDetails['user']['fax']) ) value="{{$userDetails['user']['fax']}}" @endif>
            </div>
        </div>

        <div class="col-12 col-lg-4 licensedcls" @if($userDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
            <div class="form-group form-outline">
                <label for="city" class="float-label">City</label>
                <i class="material-symbols-outlined">location_city</i>
                <input type="text" class="form-control" id="city" name="city" @if( isset( $userDetails['user']['city']) )  value="{{$userDetails['user']['city']}}"  @endif>
            </div>
        </div>
        <div class="col-12 col-lg-4 licensedcls statelist" @if(isset($userDetails['country_code']) && ($userDetails['country_code'] == '+1' || $userDetails['country_code'] == '1') && $userDetails['is_licensed_practitioner'] == 1 ) style="display:block;" @else style="display:none;" @endif id="user_states">
            <div class="form-group form-floating">
            <i class="material-symbols-outlined">map</i>
            <select name="state_id" id="state_id" class="form-select">
                <option value="">Select State</option>
                @if(!empty($stateDetails))
                @foreach($stateDetails as $sds)
                <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}"  @if( $userDetails['user']['state_id'] == $sds['id'] ) selected @endif >{{ $sds['state_name']}}</option>
                @endforeach
                @endif
            </select>
            <label class="select-label">State</label>
            </div>
        </div>

        <div class="col-12 col-lg-4 statesel" id="user_stateOther" style="display: none;" >
            <div class="form-group form-outline">
            <label for="state" class="float-label">State</label>
            <i class="material-symbols-outlined">map</i>
            <input type="text" name="state" class="form-control" id="state" @if( isset( $userDetails['user']['state']) ) value="{{$userDetails['user']['state']}}" @endif >
            </div>
        </div>


        <div class="col-12 col-lg-4 licensedcls" @if($userDetails['is_licensed_practitioner'] != 1 )  style="display:none;" @endif>
            <div class="form-group form-outline">
                <label for="user_zip_zipcode" class="float-label">Zip</label>
                <i class="material-symbols-outlined">home_pin</i>
                <input type="text" class="form-control" id="zip" name="zip" @if( isset( $userDetails['user']['zip_code']) ) value="{{$userDetails['user']['zip_code']}}" @endif>
            </div>
        </div> -->

    </div>
    <div class="btn_alignbox justify-content-end mt-5">
        <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Close</a>
        <a href="javascript:void(0)" id="updatedoctr" onclick="updateUser('{{$userDetails['clinic_user_uuid']}}')" class="btn btn-primary">Submit</a>
    </div>
</form>
@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp

<script type="text/javascript">

    $('#is_licensed_practitioner').change(function() {
        if ($(this).is(':checked')) {
            $('.licensedcls').show();
            $(".dtrcls").show();
            $(".cmncls").show();
            $('input:visible, textarea:visible').each(function () {
                // toggleLabel(this);
            });
        } else {
            $('.licensedcls').hide();
            var userType = $("#user_type_id").val();
            if(userType == '1' || userType == '2'){
                $(".dtrcls").hide();
                $(".cmncls").hide();
                $("#speciality").val('');
                $("#designation").val('');
                $("#npi_number").val('');
              
            }  if(userType == '1' ){
                $(".lincedcls").show();
            }
            
        }
      

    });

    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== '';
        const isFocused = $input.is(':focus');

        $input.closest('.form-group').find('.float-label').toggleClass('active', hasValue || isFocused);
    }

    $(document).ready(function () {
        
        $('input:visible, textarea:visible').each(function () {
            toggleLabel(this);
        });


        $(document).on('focus blur input change', 'input:visible, textarea:visible', function () {
            toggleLabel(this);
        });

        
        $(document).on('dp.change', function (e) {
            const input = $(e.target).find('input:visible, textarea:visible');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });

        $(document).on('click', '#is_licensed_practitioner', function () {
            $('input:visible, textarea:visible').each(function () {
                toggleLabel(this);
            });
        });
    });



    function triggerFields(){
        var userType = $("#user_type_id").val();
        if(userType == '1' || userType == '2'){
            if ($('#is_licensed_practitioner').is(':checked')) {
                $('.licensedcls').show();
            
            } else {
                $('.licensedcls').hide();
            
            }
            if( userType == '2'){
                $(".dtrcls").hide();
                $('.licensedcls').show();
            }else{
                $(".dtrcls").show();
            }
            // $(".cmncls").hide();
            $(".nursecls").hide();
        }else{
            $('.licensedcls').hide();
            $(".nursecls").show();
            $(".cmncls").show();
            $(".dtrcls").hide();
        }
    }
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

    function updateUser(key) {
        if ($("#edituserform").valid()) {
            $("#updateuser").addClass('disabled');
            $("#updateuser").text("Submitting..."); 
            $.ajax({
                url: '{{ url("/users/update") }}',
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
                    });
                    $("#updateuser").removeClass('disabled');
                    $("#updateuser").text("Submit"); 
                    
                }
                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
        }
    }
    $(document).ready(function() {
        
        initializeAutocomplete(); 
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
                    
                    // customemail: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                            'type' : 'other',
                            'field_type': 'email', 
                            "id":"{{$userDetails['user_id']}}",
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
                            'field_type': 'phone', 
                            "id":"{{$userDetails['user_id']}}",
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
                    number: true,
                    remote: {
                        url: "{{ url('/validatenpinumber') }}",
                        data: {
                            'type': 'npi_number',
                            'email': function () {
                                return $("#email").val(); // Get the updated value
                            },
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                        
                    },
                    minlength: 10,
                    maxlength: 10,
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

                dob: {
                    required: 'Please enter date of birth.',
                    dobRange: 'Invalid birth year. Please choose a year from 1900 to 2015.',
                },
                address: "Please enter address.",
                city: "Please enter city.",
                state: "Please enter state.",
                state_id: 'Please enter state',
                zip: "Please enter zip.",
                fax: {
                    required: 'Please enter fax.',
                    faxPattern :'Please enter a valid fax number',
                },
                npi_number: {
                    number: "Please enter a valid NPI number.",
                     remote : "NPI number already exists in the system.",
                     minlength: "Please enter a valid NPI number.",
                     maxlength: "Please enter a valid NPI number."
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
                    // customemail: "Please enter a valid email",
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
        jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
            return this.optional(element) || phone_number.length < 14 &&
                phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
        });
    });
</script>

