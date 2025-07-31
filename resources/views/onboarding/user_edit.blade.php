 
<h4 class="text-center fw-bold mb-1">Edit User</h4>
<div class="text-start mb-3">
    <small class="mb-0"><span class="fw-bold">Note:</span> To enable ePrescribe, please complete the following details to proceed with your registration.</small>
</div>
<form method="POST" id="edituserform" autocomplete="off">
    @csrf
    <div class="row g-4">
       
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
                <input type="email" class="form-control" readonly id="email" name="email" value="{{$userDetails['email']}}">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" readonly id="countryCodes" name="countrycode" value={{ isset($userDetails['short_code'])  ? $userDetails['short_code'] : 'US' }} >
                </div>
                <i class="material-symbols-outlined me-2">call</i> 
                <input type="text" class="form-control" readonly id="phone_number_edit" name="phone_number" placeholder="Phone Number" value="<?php echo isset($userDetails['country_code'])  ? $userDetails['country_code'] . $userDetails['phone_number'] : $userDetails['phone_number'] ?>" >
            </div>
        </div>
       
        <div class="col-12 col-lg-6 npicls licensedcls">
            <div class="form-group form-outline">
                <label for="input" class="float-label">NPI</label>
                <i class="material-symbols-outlined">diagnosis</i>
                <input type="text" class="form-control" id="npi_number" value="{{$userDetails['npi_number']}}" name="npi_number" maxlength="10">
            </div>
        </div>
            
        <div class="col-12 col-lg-6 licensedcls">
            <div class="form-group form-outline">
                <label for="dob" class="float-label">Date of Birth</label>
                <i class="material-symbols-outlined">date_range</i>
                <input type="text" name="dob" id="dobedit" class="form-control" value="@if( isset( $userDetails['user']['dob']) && $userDetails['user']['dob'] != '') {{date('m/d/Y', strtotime($userDetails['user']['dob']))}} @endif">
            </div>
        </div>

        <div class="col-12 col-lg-6 licensedcls mt-4" >
            <div class="form-group form-outline">
                <label for="user_fax" class="float-label">Fax</label>
                <i class="material-symbols-outlined">fax</i>
                <input type="text" class="form-control" id="fax" name="fax"  @if( isset( $userDetails['user']['fax']) ) value="{{$userDetails['user']['fax']}}" @endif>
            </div>
        </div>

        <div class="col-12 licensedcls">
            <div class="form-group form-outline useraddresserr">
                <label for="aduser_addressdress" class="float-label">Address</label>
                <i class="material-symbols-outlined">home</i>
                <input type="text" class="form-control useraddress" id="user_address" name="user_address" @if( isset( $userDetails['user']['address'])) value="{{$userDetails['user']['address']}}" @endif>
            </div>
        </div>

      

        <div class="col-12 col-lg-4 licensedcls" >
            <div class="form-group form-outline">
                <label for="city" class="float-label">City</label>
                <i class="material-symbols-outlined">location_city</i>
                <input type="text" class="form-control" id="user_city" name="user_city" @if( isset( $userDetails['user']['city']) )  value="{{$userDetails['user']['city']}}"  @endif>
            </div>
        </div>
        <div class="col-12 col-lg-4 licensedcls statelist" @if(isset($userDetails['country_code']) && ($userDetails['country_code'] == '+1' || $userDetails['country_code'] == '1')  ) style="display:block;" @else style="display:none;" @endif id="user_states">
            <div class="form-group form-floating">
            <i class="material-symbols-outlined">map</i>
            <select name="user_state_id" id="user_state_id" class="form-select">
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

        <div class="col-12 col-lg-4 statesel" id="user_stateOther" @if(isset($userDetails['country_code']) && ($userDetails['country_code'] != '+1' || $userDetails['country_code'] != '1')  ) style="display:block;" @else style="display:none;" @endif>
            <div class="form-group form-outline">
            <label for="state" class="float-label">State</label>
            <i class="material-symbols-outlined">map</i>
            <input type="text" name="user_state" class="form-control" id="user_state" @if( isset( $userDetails['user']['state']) ) value="{{$userDetails['user']['state']}}" @endif >
            </div>
        </div>


        <div class="col-12 col-lg-4 licensedcls" >
            <div class="form-group form-outline">
                <label for="user_zip_zipcode" class="float-label">Zip</label>
                <i class="material-symbols-outlined">home_pin</i>
                <input type="text" class="form-control" id="user_zip" name="user_zip" @if( isset( $userDetails['user']['zip_code']) ) value="{{$userDetails['user']['zip_code']}}" @endif>
            </div>
        </div>

    </div>
    <div class="btn_alignbox justify-content-end mt-5">
        <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Close</a>
        <a href="javascript:void(0)" id="updatedoctr" onclick="updateDosepotUser('{{$userDetails['clinic_user_uuid']}}')" class="btn btn-primary">Submit</a>
    </div>
</form>
@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp

<script type="text/javascript">

    $('#dobedit').datetimepicker({
        format: 'MM/DD/YYYY',
                useCurrent: false, 
                viewDate   : moment('01/01/2015', 'MM/DD/YYYY'),                             
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

      
    });

    function updateDosepotUser(key) {
        if ($("#edituserform").valid()) {
            $("#updateuser").addClass('disabled');
            $("#updateuser").text("Submitting..."); 
            $.ajax({
                url: '{{ url("onboarding/users/update") }}',
                type: "post",
                data: {
                    'key' : key,
                    'formdata': $("#edituserform").serialize(),
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#editUser_dotsepot").modal('hide');
                        if (data.isShow == 0) {
                            $('#enableAddOnBtn').attr('onclick', null).on('click', enableAddOn); 
                            $('#enableAddOnBtn_'+key).attr('onclick', null).on('click', enableAddOn); 
                        }
                        enableAddOn(key);
                    } else {
                        swal({
                            title: "Error!",
                            text: data.message,
                            icon: "error",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            // window.location.reload();
                        });
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            });
        }
    }
    $(document).ready(function() {

        initializeAutocompleteUser(); 
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
                last_name: {
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


                user_address: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },

                user_city: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                user_state_id: {
                    required: function(element) {
                        return $(element).is(":visible");
                    },
                },
                user_zip: {
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
                user_address: "Please enter address.",
                user_city: "Please enter city.",
                user_state: "Please enter state.",
                user_state_id: 'Please enter state',
                user_zip: "Please enter zip.",
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
              
              username: {
                    required: 'Please enter first name.',
                },
                last_name: {
                    required: 'Please enter last name.',
                },
               
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

    

    var autocompleteUser ;
    function initializeAutocompleteUser() {
        let addressInput = document.getElementById('user_address');
        if (addressInput) {
            addressInput.setAttribute("placeholder", "");
        }

        if (typeof google === "undefined" || !google.maps || !google.maps.places) {
            console.error("Google Maps API failed to load. Please check your API key.");
            // Disable address input if Google Maps fails to load
            if (addressInput) {
                addressInput.disabled = true;
                addressInput.placeholder = "Address autocomplete is currently unavailable";
            }
            return;
        }

        let input = document.getElementById('user_address');
        if (!input) {
            console.log("Address input field NOT found!");
            return;
        }
        var countrynew = $('#countryCodes').val();
        let defaultCountry = $('#countryCodes').val();
       
        console.log(defaultCountry)
        autocompleteUser  = new google.maps.places.Autocomplete(input, {
            types: ['geocode', 'establishment'],
            componentRestrictions: { country: defaultCountry } // Set initial country
        });
        // Validate the country code
        if (!defaultCountry || defaultCountry.length !== 2) {
            console.warn('Invalid country code, defaulting to US');
            defaultCountry = 'US';
        }

        // autocompleteUser = new google.maps.places.Autocomplete(input, {
        //     types: ['geocode', 'establishment'],
        //     componentRestrictions: { country: defaultCountry }
        // });

        console.log("Google Places Autocomplete initialized successfully.");


        autocompleteUser.addListener('place_changed', function () {
            console.log("Place changed event triggered.");
            
            var place = autocompleteUser.getPlace();
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

            place.address_components.forEach(component => {
                const types = component.types;
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

            safeSetValue('user_address', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
            safeSetValue('user_city', addressComponents.city || '');
            safeSetValue('user_zip', addressComponents.zip || '');
            safeSetValue('user_state_id', addressComponents.state || '');

            // Select the state in the dropdown
            let stateDropdown = document.getElementById('user_state_id');
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
            $("#user_address, #user_city, #user_zip, #user_state_id").each(function () {
            $(this).valid(); 
            });
        });
    }



</script>

