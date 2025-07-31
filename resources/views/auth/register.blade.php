<div class="text-start">
  <h4 class="fw-medium mb-0">Clinic Details</h4>
  <small class="gray">Please add your clinic's information.</small>
</div>

<form method="POST" id="registerform" autocomplete="off">
  @csrf
  <input type="hidden" class="form-control"  id="timezoneOffset" name="timezoneOffset" value="{{$timezoneOffset}}">
  <div class="row mt-3">


    <div class="col-12">
      <div class="form-group form-outline mb-4">
        <label for="clinic_name" class="float-label">Clinic Name</label>
        <i class="material-symbols-outlined">home_health</i>
        <input type="text" name="clinic_name" class="form-control" id="clinic_name">
      </div>
    </div>
    <!-- BB-308 updates  -->
    <!-- <div class="col-lg-6 col-12">
      <div class="form-group form-outline mb-4">
        <label for="input" class="float-label">Email</label>
        <i class="fa-solid fa-envelope"></i>
        <input type="email" class="form-control" id="clinicemail" name="email">
      </div>
    </div>
    <div class="col-lg-6 col-12">

      <div class="form-group form-outline phoneregcls mb-4">
        <div class="country_code phone">
          <input type="hidden" id="cliniccountryCode1" name="clinic_countrycode" value='+1'>
          <input type="hidden" name="clinic_countryCodeShort" id="clinic_countryCodeShorts" value="us">

        </div>
        <i class="material-symbols-outlined me-2">call</i>
        <input type="text"  class="form-control phone-numberregister" id="clinic_phone_number"
          placeholder="Enter clinic phone number" required>

      </div>
    </div>


    <div class="col-lg-12">
      <div class="form-group form-floating mb-4">
        <i class="material-symbols-outlined">public</i>
        <select name="country_id" id="country_id" data-tabid="basic" onchange="stateUS()" class="form-select autofillcountry">
          <option value="">Select Country</option>

          @if(!empty($countryDetails))
          @foreach($countryDetails as $cds => $cd)

        <option value="{{ $cd['id']}}" data-shortcode="{{$cd['short_code']}}" {{$cd['id'] == 185 ? 'selected' : ''}}>{{ $cd['country_name']}}</option>
        @endforeach
        @endif
        </select>
        <label class="select-label">Country</label>
      </div>
    </div>
    <div class="col-lg-12 col-12">
      <div class="form-group form-outline textarea-align mb-4">
          <label for="address" class="float-label">Address</label>
          <i class="material-symbols-outlined">home</i>
          <textarea name="address" id="address" class="form-control" rows="1"></textarea>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="city" class="float-label">City</label>
        <i class="material-symbols-outlined">location_city</i>
        <input type="text" name="city" class="form-control" id="city">
      </div>
    </div>
      <div class="col-lg-4" id="states">
        <div class="form-group form-floating mb-4">
          <i class="material-symbols-outlined">map</i>
          {{-- <label for="input" class="">State</label> --}}
          <select name="state_id" id="state_id" data-tabid="basic" class="form-select">
            <option value="">Select State</option>
            @if(!empty($stateDetails))
            @foreach($stateDetails as $sds)
              <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}">{{ $sds['state_name']}}</option>
            @endforeach
            @endif
          </select>
          <label class="select-label">State</label>
        </div>
      </div>

      <div class="col-lg-4" style="display: none;" id="stateOther">
        <div class="form-group form-outline mb-4">
          <label for="input" class="float-label">State</label>
          <i class="material-symbols-outlined">map</i>
          <input type="text" name="state" class="form-control" id="state">
        </div>
      </div>
    
      <div class="col-lg-4">
        <div class="form-group form-outline mb-4">
          <label for="input" class="float-label">ZIP</label>
          <i class="material-symbols-outlined">home_pin</i>
          <input type="text" name="zip" class="form-control" id="zip">
        </div>
      </div> -->

      <!-- <div class="col-12"> 
        <hr>
      </div> -->

      <div class="col-12">
        <div class="text-start mb-3">
            <h4 class="fw-medium mb-0">Primary Contact Details</h4>
            <small class="gray mb-0">You will be using this account to login to your clinic portal.</small>
        </div>
      </div>
    
    <div class="col-lg-6 col-12">
      <div class="form-group form-outline mb-4">
        <label for="first_name" class="float-label">First Name</label>
        <i class="material-symbols-outlined">home_health</i>
        <input type="text" name="first_name" class="form-control" id="first_name">
      </div>
    </div>
    <div class="col-lg-6 col-12">
      <div class="form-group form-outline mb-4">
        <label for="last_name" class="float-label">Last Name</label>
        <i class="material-symbols-outlined">home_health</i>
        <input type="text" name="last_name" class="form-control" id="last_name">
      </div>
    </div>

    
    <div class="col-lg-6 col-12">
      <div class="form-group form-outline mb-4">
        <label for="first_name" class="float-label">Email</label>
        <i class="fa-solid fa-envelope"></i>
        <input type="text" name="user_email" class="form-control" id="user_email">
      </div>
    </div>

    
    <div class="col-lg-6 col-12">
      <div class="form-group form-outline phoneregcls mb-4">
        <div class="country_code phone">
          <input type="hidden" id="user_countryCode" name="user_countryCode" value='+1'>
          <input type="hidden" name="user_countryCodeShort" class="form-control" id="user_countryCodeShorts" value="us">
        </div>
        <i class="material-symbols-outlined me-2">call</i>
        <input type="text" name="user_phone" class="form-control phone-numberregistuser" id="user_phone"
          placeholder="Enter phone number">
      </div>
    </div>

    <input type="hidden" name="isregister" id="isregister" class="form-control" value="1">
  <!-- BB-308 updates  -->
        <!-- <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Qualification</label>
                <i class="material-symbols-outlined">school</i>
                <input type="text" class="form-control" id="qualification" name="qualification">
            </div>
        </div>

        <div class="col-12 col-lg-6">
          <div class="form-group form-floating mb-4">
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
      </div>
     

        <div class="col-12 col-lg-6">
            <div class="form-group form-floating mb-4">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="speciality" id="speciality" class="form-select">
                  <option disabled="" selected="">Select a Specialty</option>
                    @foreach ($specialties as $specialty)
                        <option value="{{$specialty['id']}}">{{$specialty['specialty_name']}}</option>
                    @endforeach
                </select>
                <label class="select-label">Specialty</label>
            </div>
        </div> -->




    <div class="col-12">
      <div class="btn_alignbox mt-3">
        <a onclick="submitClinic()" class="btn btn-primary w-100" id="save_clinic">Submit</a>

       

        <!-- <a onclick="submitClinic()" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Next</a> -->
      </div>
    </div>
    <p class="m-0 mt-5">Already have a BlackBag account?</p>
        <div class="btn_inner">
            <a class="primary fw-medium text-decoration-underline" href="{{url('login')}}">Sign In</a>
        </div>
  </div>

</form>

@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp

<script>
  jQuery.browser = {};
	(function() {
		jQuery.browser.msie = false;
		jQuery.browser.version = 0;
		if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
			jQuery.browser.msie = true;
			jQuery.browser.version = RegExp.$1;
		}
	})();
  let autocomplete ;
  function updateAutocompleteCountry() {
    let countryElement = document.getElementById("country_id");

    if (!countryElement) {
        console.error("Country select element not found.");
        return;
    }

    let selectedCountry = countryElement.options[countryElement.selectedIndex]?.dataset.shortcode || 'US';

    console.log('Selected Country Code:', selectedCountry);

    if (autocomplete) {
      autocomplete.setComponentRestrictions({ country: [selectedCountry] }); // Ensure it's an array
    } else {
      initializeAutocomplete(); // Reinitialize if needed
    }
    $("#address, #city, #zip, #state_id,#state").each(function () {
        $(this).val('');
        toggleLabel(this);
    });
}

function initializeAutocomplete() {

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

    let countryElement = document.getElementById("country_id");
    let defaultCountry = countryElement  ? countryElement.dataset.shortcode : 'US' ;
    defaultCountry = (defaultCountry == undefined ) ? 'US' : defaultCountry;
  
    autocomplete  = new google.maps.places.Autocomplete(input, {
      types: ['geocode', 'establishment'],
        componentRestrictions: { country: defaultCountry } // Set initial country
    });

    console.log("Google Places Autocomplete initialized successfully.");

    autocomplete.addListener('place_changed', function () {
        console.log("Place changed event triggered.");
        
        var place = autocomplete.getPlace();
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
            if (!addressComponents.city && types.includes("sublocality_level_1")) {
                addressComponents.city = component.long_name;
            }
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
}


</script>


<script>
  $(document).ready(function () {
    $("#registerform").validate({
      ignore: [],
      rules: {
        first_name: {
          required: true,
          noWhitespace: true
        },
        last_name: {
          required: true,
          noWhitespace: true
        },
        email: {
          required: true,
          format: true,
          email: true,
          // remote: {
          //   url: "{{ url('/validateuserphone') }}",
          //   data: {
          //     'type': 'register',
          //     'email': function () {
          //         return $("#clinicemail").val();
          //      },
          //     'phone_number': function () {
          //         return $("#user_phone").val(); 
          //     }, 
          //     'country_code': function () {
          //         return $("#user_countryCodeShorts").val();
          //     },
          //     '_token': $('input[name=_token]').val()
          //   },
          //   type: "post",
          //   dataFilter: function (response) {
          //     const res = JSON.parse(response);
          //     if (res.valid) {
          //       return true;
          //     } else {
          //       return "\"" + res.message + "\"";
          //     }
          //   }
          // },
        },

        user_email: {
          required: true,
          format: true,
          email: true,
          emailFirstCharValid: true,
          remote: {
            url: "{{ url('/validateuserphoneregister') }}",
            data: {
              'type': 'register',
              'field_type': 'email', 
              'email': function () {
                  return $("#user_email").val();
               },
              'phone_number': function () {
                  return $("#user_phone").val(); 
              }, 
              'country_code': function () {
                  return $("#user_countryCodeShorts").val();
              },
              '_token': $('input[name=_token]').val()
            },
            type: "post",
            dataFilter: function (response) {
              const res = JSON.parse(response);
              if (res.valid) {
                return true;
              } else {
                return "\"" + res.message + "\"";
              }
            }
          },
        },

        

        user_phone: {
          required: true,
          NumberValids: true,
          remote: {
            url: "{{ url('/validateuserphoneregister') }}",
            data: {
              'type': 'register',
              'field_type': 'phone', 
              'user_email': function () {
                return $("#user_email").val();
              },
              'phone_number': function () {
                return $("#user_phone").val(); 
              }, 
              'country_code': function () {
                return $("#user_countryCodeShorts").val();
              },
              '_token': $('input[name=_token]').val()
            },
            type: "post",
              dataFilter: function (response) {
              const res = JSON.parse(response);
              if (res.valid) {
                return true;
              } else {
                return "\"" + res.message + "\"";
              }
            }
          },
        },
        clinic_name: 'required',
        address: 'required',
        phone_number: {
          required: true,
          NumberValids: true,
          // remote: {  BB-236
          //   url: "{{ url('frontend/checkPhoneExist') }}",
          //   data: {
          //     'type': 'clinic',
          //     '_token': $('input[name=_token]').val(),
          //     'phone_number': function () {
          //                   return $("#clinic_phone_number").val(); 
          //                   }, 
          //               'country_code': function () {
          //               return $("#clinic_countryCodeShorts").val(); 
          //               }, 
                        
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
          required: 'Please enter email.',
          email: 'Please enter valid email.',
          remote: "Email id already exists in the system."
        },
        user_email: {
          required: 'Please enter email.',
          email: 'Please enter valid email.',
          remote: "Email id already exists in the system.",
          emailFirstCharValid : "Please enter valid email."
        },
        
        phone_number: {
          required: 'Please enter phone number.',
          NumberValids: 'Please enter valid phone number.',
          remote: "Phone number exists in the system."

        },
        user_phone: {
          required: 'Please enter phone number.',
          NumberValids: 'Please enter valid phone number.',
          remote: "Phone number exists in the system."
        },
        first_name: {
          required: 'Please enter first name.',
          
          noWhitespace:'Please enter valid first name.',
        },
        last_name: {
          required: 'Please enter last name.',
        
          noWhitespace: 'Please enter valid last name.',
        },
        address: "Please enter address.",
        city: "Please enter city.",
        state: "Please enter state.",
        state_id: 'Please enter state',
        // zip : "Please enter zip." ,
        // first_name: "Please enter name.",

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
    jQuery.validator.addMethod("noWhitespace", function(value, element) {
      return $.trim(value).length > 0;
    }, "This field is required.");

    jQuery.validator.addMethod("emailFirstCharValid", function(value, element) {
      const username = value.split('@')[0];
      return /^[a-zA-Z0-9]/.test(username);
    }, "Please enter valid email.");

    jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
        return this.optional(element) || phone_number.length < 14 &&
            phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
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

      $("#states").show();
      $("#stateOther").hide();
      $("#state").val('');
    } else {

      $("#states").hide();
      $("#state_id").val('');
      $("#stateOther").show();
    }
    updateAutocompleteCountry();

  }



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
    let onlyCountriesx = {!! json_encode($corefunctions->getCountry()) !!};

    telInput.intlTelInput({
      initialCountry: "us",
      formatOnDisplay: true,
      autoHideDialCode: true,
      onlyCountries: onlyCountriesx,
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

    $('#clinic_phone_number, #user_phone').mask('(ZZZ) ZZZ-ZZZZ', {
      translation: {
        'Z': {
          pattern: /[0-9]/,
          optional: false
        }
      }
    });
  }



</script>



<style>
    /* Fix Google Autocomplete dropdown inside modal */
    .pac-container {
        z-index: 9999 !important;
    }
</style>