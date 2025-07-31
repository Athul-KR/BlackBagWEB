<h4 class="text-center fw-medium mb-0 ">Add New User</h4>
<small class="gray">Please enter the user details</small>
<div class="import_section add_img">
</div>
<form method="POST" id="usersform" autocomplete="off">
    @csrf
    <div class="row g-4">

        <div class="create-profile">
            <div class="profile-img position-relative">
                <img id="doctorimage" src="{{asset('images/default_img.png')}}" class="img-fluid">
                <a href="{{ url('crop/doctor')}}" id="upload-img" class="aupload"><img id="doctorimg"
                        src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" style="display:none;"
                    onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>
            </div>
            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline">
                <label for="username" class="float-label">First Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="username" name="username">
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="form-group form-outline">
                <label for="last_name" class="float-label">Last Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="last_name" name="last_name">
            </div>
        </div>
        <div class="col-12">
            <div class="form-group form-outline">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control" id="email" name="email">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCode" name="countrycode" value='US' class="autofillcountry">
                </div>
                <i class="material-symbols-outlined me-2">call</i>
                <input type="text" class="form-control phone-number" id="phone_number" name="phone_number"
                    placeholder="Phone Number">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-floating">
                <i class="material-symbols-outlined">manage_accounts</i>
                <select name="user_type_id" id="user_type_id" class="form-select" onchange="triggerFields();">
                    @if(session()->get('user.userType') == 'clinics')
                    <option value="">Select a user type</option>
                    @if(!empty($userType))
                   @foreach($userType as $types)
                        <option value="{{$types['id']}}">{{$types['user_type']}}</option>
                    @endforeach
                    @endif
                    <!-- <option value="2">Clinician</option>
                    <option value="3">Nurse</option> -->
                    @else
                    <option value="3" selected>Medical Assistant / Scribe</option>
                    @endif
                </select>
                <label class="select-label">User type</label>
            </div>
        </div>

        <!-- <div class="col-12 dtrcls" style="display:none;"> 
            <div class="form-check d-flex align-items-center gap-2">
                <input class="form-check-input" name="is_licensed_practitioner" type="checkbox" id="is_licensed_practitioner">
                <label class="form-check-label mb-0" for="is_licensed_practitioner" style="font-size: 1rem; color: #222;">
                    Is this user a licensed medical practitioner?
                </label>
            </div>
        </div>
        <div class="col-12 col-lg-6 npicls licensedcls"  style="display:none;">
            <div class="form-group form-outline">
                <label for="input" class="float-label">NPI</label>
                <i class="material-symbols-outlined">diagnosis</i>
                <input type="text" class="form-control" id="npi_number" value="" name="npi_number" maxlength="10">
            </div>
        </div>

        <div class="col-12 col-lg-6  licensedcls" style="display:none;">
            <div class="form-group form-floating">
                <i class="material-symbols-outlined">id_card</i>
                <select name="designation" id="designation" class="form-select">
                    <option value="">Select a designation</option>
                    @if(!empty($designation))
                        @foreach($designation as $dgn)
                            <option value="{{$dgn['id']}}">{{$dgn['name']}}</option>
                        @endforeach
                    @endif
                </select>
                <label class="select-label">Designation</label>
            </div>
        </div> -->
      
        <div class="col-12 nursecls" style="display:none;">
            <div class="form-group form-outline">
                <label for="input" class="float-label">Department</label>
                <i class="material-symbols-outlined">id_card</i>
                <input name="department" class="form-control">
            </div>
        </div>
      
        <!-- <div class="col-12 col-lg-6 cmncls licensedcls" style="display:none;">
            <div class="form-group form-floating">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="speciality" id="speciality" class="form-select">
                    <option value="">Select a Specialty</option>
                    @foreach ($specialities as $speciality)
                        <option value="{{$speciality['id']}}">{{$speciality['specialty_name']}}</option>
                    @endforeach
                </select>
                <label class="select-label">Specialty</label>
            </div>
        </div> -->
        
        <!-- <div class="col-12 col-lg-6 licensedcls" style="display:none;">
            <div class="form-group form-outline">
                <label for="dob" class="float-label">Date of Birth</label>
                <i class="material-symbols-outlined">date_range</i>
                <input type="text" name="dob" id="dob" class="form-control">
            </div>
        </div>

        <div class="col-12 licensedcls" style="display:none;">
            <div class="form-group form-outline useraddresserr">
                <label for="aduser_addressdress" class="float-label">Address</label>
                <i class="material-symbols-outlined">home</i>
                <input type="text" class="form-control useraddress" id="address" name="address" >
            </div>
        </div>
        <div class="col-12 col-lg-4 licensedcls" style="display:none;">
            <div class="form-group form-outline">
                <label for="city" class="float-label">City</label>
                <i class="material-symbols-outlined">location_city</i>
                <input type="text" class="form-control" id="city" name="city">
            </div>
        </div>
        <div class="col-12 col-lg-4 licensedcls statelist" style="display:none;" id="user_states">
            <div class="form-group form-floating">
            <i class="material-symbols-outlined">map</i>
            <select name="state_id" id="state_id" class="form-select">
                <option value="">Select State</option>
                @if(!empty($stateDetails))
                @foreach($stateDetails as $sds)
                <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}" >{{ $sds['state_name']}}</option>
                @endforeach
                @endif
            </select>
            <label class="select-label">State</label>
            </div>
        </div>

        <div class="col-12 col-lg-4 statesel"  id="user_stateOther" style="display: none;" >
            <div class="form-group form-outline">
            <label for="state" class="float-label">State</label>
            <i class="material-symbols-outlined">map</i>
            <input type="text" name="state" class="form-control" id="state">
            </div>
        </div>

        <div class="col-12 col-lg-4 licensedcls mt-4" style="display:none;">
            <div class="form-group form-outline">
                <label for="user_zip_zipcode" class="float-label">Zip</label>
                <i class="material-symbols-outlined">home_pin</i>
                <input type="text" class="form-control" id="zip" name="zip" >
            </div>
        </div>

        <div class="col-12 col-lg-4 licensedcls mt-4" style="display:none;">
            <div class="form-group form-outline">
                <label for="user_fax" class="float-label">Fax</label>
                <i class="material-symbols-outlined">fax</i>
                <input type="text" class="form-control" id="fax" name="fax" >
            </div>
        </div> -->

    </div>
    <div class="btn_alignbox justify-content-end mt-5">
        <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal"
            data-bs-target="#loader">Close</a>
        <a href="javascript:void(0)" id="submituser" onclick="submitUser()" class="btn btn-primary">Submit</a>
    </div>
</form>
@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>

<script>
       $('#dob').datetimepicker({
        format: 'MM/DD/YYYY',
        useCurrent: false, 
        viewDate   : moment('01/01/2015', 'MM/DD/YYYY'), 
       
        
    });
        

    $('#is_licensed_practitioner').change(function() {
        if ($(this).is(':checked')) {
            $('.licensedcls').show();
           
        } else {
            $('.licensedcls').hide();
          
        }
      

    });


    document.addEventListener("DOMContentLoaded", function () {
    const select = document.querySelector(".did-floating-select");
    const label = document.querySelector(".did-floating-label");

    function updateLabel() {
        if (select.value) {
            select.setAttribute("value", select.value); // Update attribute
            label.classList.add("active");
        } else {
            label.classList.remove("active");
        }
    }

    select.addEventListener("change", updateLabel);
    updateLabel(); // Call on page load
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        initializeAutocomplete();
        // triggerFields();
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

    function doctorImage(imagekey, imagePath) {
        $("#tempimage").val(imagekey);
        $("#doctorimage").attr("src", imagePath);
        $("#doctorimage").show();
        $("#upload-img").hide();
        $("#removelogo").show();
    }

    function removeImage() {
        $("#doctorimage").attr("src", "{{asset('images/default_img.png')}}");
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
            let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
        // initialise plugin
        telInput.intlTelInput({
            autoPlaceholder: "polite",
            initialCountry: "us",
            formatOnDisplay: true, // Enable auto-formatting on display
            autoHideDialCode: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",
            onlyCountries: onlyCountries,
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

            updateAutocompleteCountry()
            if(countryData.dialCode == 1 ){
                $("#statelist").show();
                $("#statesel").hide();
            }else{
                $("#statelist").hide();
                $("#statesel").show();
            }
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

        $('#phone_number').mask('(ZZZ) ZZZ-ZZZZ', {
            translation: {
                'Z': {
                    pattern: /[0-9]/,
                    optional: false
                }
            }
        });

        $("#usersform").validate({
            rules: {
                username: {
                    required: true,
                    noWhitespace: true,
                    notOnlySpecialChar: true,
                    notOnlyNumbers: true,
                },
                last_name: {
                    required: true,
                    noWhitespace: true,
                    notOnlySpecialChar: true,
                    notOnlyNumbers: true,
                },
                
                email: {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                             'type': 'email',
                             'field_type': 'email', 
                            'country_code': function () {
                                return $("#countryCode").val(); // Get the updated value
                            },
                            'phone_number': function () {
                                return $("#phone_number").val(); // Get the updated value
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
                phone_number: {
                    required: true,
                    NumberValids: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        type: "post",
                        data: {
                            'type': 'phone',
                            'field_type': 'phone', 
                            'email': function () {
                                return $("#email").val(); // Get the updated value
                            },
                            'country_code': function () {
                                return $("#countryCode").val(); // Get the updated value
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
            
                user_type_id: {
                    required: true,
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

              
                address: "Please enter address.",
                city: "Please enter city.",
                state: "Please enter state.",
                state_id: 'Please enter state',
                zip: "Please enter zip.",

                fax: {
                    required: 'Please enter fax.',
                    faxPattern :'Please enter a valid fax number',
                },
                dob: {
                    required: 'Please enter date 0f birth.',
                    dobRange: 'Invalid birth year. Please choose a year from 1900 to 2015.',
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
                    remote: "Phone number already exists in the system.",
                    // remotephone  : "Email is already linked with a different phone number.",
                },
                username: {
                    required: 'Please enter name.',
                    noWhitespace: 'Please valid enter name.',
                    notOnlySpecialChar:'Please enter valid first name.',
                    notOnlyNumbers :'Please enter valid last name.',
                },
                last_name: {
                    required: 'Please enter last name.',
                    noWhitespace: 'Please valid enter name.',
                    notOnlySpecialChar:'Please enter valid first name.',
                    notOnlyNumbers :'Please enter valid last name.',
                
                },
                email: {
                    required: 'Please enter email.',
                    email: "Please enter a valid email",
                    remote: "Email id already exists in the system."
                },
                department: {
                    required: 'Please enter department.',
                },
                designation: {
                    required: 'Please select a designation.',
                },
                speciality: {
                    required: 'Please enter speciality.',
                },
              
                user_type_id: {
                    required: 'Please select user type.',
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

        jQuery.validator.addMethod("notOnlyNumbers", function(value, element) {
            return this.optional(element) || /[a-zA-Z]/.test(value); 
            // Must contain at least one alphabet
        }, "Numbers only are not allowed.");
        // Custom method to ensure the value is not only special characters
        jQuery.validator.addMethod("notOnlySpecialChar", function(value, element) {
            // Allow if value contains at least one alphabet or number
            return this.optional(element) || /[a-zA-Z0-9]/.test(value);
        }, "Special characters only are not allowed.");
        
        jQuery.validator.addMethod("noWhitespace", function(value, element) {
                return $.trim(value).length > 0;
              }, "This field is required.");
        $.validator.addMethod("zipmaxlength", function (value, element) {
            return /^\d{1,6}$/.test(value);
        }, "Please enter a valid ZIP code.");

        jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
            return this.optional(element) || phone_number.length < 14 &&
                phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
        });
    });


</script>


    