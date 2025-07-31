@extends('onboarding.onboarding')
@section('title', 'Business Details')
@section('content')    
<section class="mx-lg-5 px-lg-5">
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
          @include('onboarding.tabs')

            <div class="web-card mb-5"> 
                <div id="step-content">
                    <div class="step-section" data-step="3">
                      <div class="onboard-box"> 
                              <div class="d-flex justify-content-between"> 
                                  <div> 
                                      <h4 class="fw-bold">Payment Processing Setup</h4>
                                      <p class="text-muted">Choose how you'd like to process payments and manage payouts securely.</p>
                                  </div>
                                  <!-- <a href="" class="primary align_middle fw-medium"><span class="material-symbols-outlined">keyboard_backspace</span>Back</a> -->
                              </div>
                              <div class="border rounded-4 p-4 bg-white">
                                  <div class="row g-4">
                                      <div class="col-lg-4 col-12 text-center">
                                          <h5 class="fw-medium mb-0">Connect Your Bank Account</h5>
                                          <p class="gray mb-3">Enable Fast, Secure Payouts for Your Patient Payments.</p>
                                          <img src="{{asset('/images/stripe.png')}}" alt="Connect Bank" class="img-fluid onboard-innerImg">
                                      </div>
                                      <div class="col-lg-8 col-12">
                                          <div class="row g-4">
                                              <div class="col-12">
                                                  <h6 class="fw-medium">Why Connect Now?</h6>
                                                  <ul class="list-unstyled imp-point">
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Receive payouts from patient subscriptions directly to your bank account</li>
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Enable seamless and automated revenue flow</li>
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Ensure compliance with financial regulations</li>
                                                  </ul>
                                              </div>
                                              <div class="col-12">
                                                  <h6 class="fw-medium">What You’ll Need</h6>
                                                  <ul class="list-unstyled imp-point">
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>A valid government-issued ID</li>
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Your bank account number and routing code</li>
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Business details</li>
                                                  </ul>
                                              </div>
                                              <div class="col-12">
                                                  <h6 class="fw-medium">How It Works</h6>
                                                  <p class="gray">We use Stripe Connect, a secure and trusted payment platform, to manage payouts. You’ll be redirected to Stripe’s onboarding form where you can:</p>
                                                  <ul class="list-unstyled imp-point">
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Verify your identity</li>
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Enter your bank account details</li>
                                                      <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Complete tax information (if required)</li>
                                                  </ul>
                                              </div>
                                              <div class="col-12">
                                                  <p class="primary fw-light"><span class="primary fw-bold">Note:</span> Your data is securely processed by Stripe. BlackBag does not store or access your banking information.</p>
                                              </div>
                                              <div class="btn_alignbox justify-content-end">
                                                  <button  onclick="submitStipe('patient-subscriptions','1')"class="btn btn-outline-primary">I'll do this later</button>
                                                  <a href="{{$stripredirectURl}}" class="btn btn-primary" >Connect With Stripe</a>
                                              </div>
                                                

                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places" async defer></script>
<script>

 /*  final submit function with validation check */
        function submitStipe(type,islater='') {
          
                    getOnboardingDetails(type,'',islater) ;
               

        }

   


    // Function to toggle the 'active' class
function toggleLabel(input) {
    const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
    $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
}
   

 $(document).ready(function () {
    initializeAutocomplete();
    $('#is_licensed_practitioner').change(function() {
            if ($(this).is(':checked')) {
                $('.licensedcls').show();
            } else {
                $('.licensedcls').hide();
            }
        });
      // Initialize label state for each input
      $('input').each(function() {
          toggleLabel(this);
        });
    $("#registerform").validate({
      ignore: [],
      rules: {
        username: 'required',
         last_name: 'required',
        email: {
          required: true,
          format: true,
          email: true,
        },

    

        name: 'required',
        address: 'required',
        phone: {
          required: true,
          NumberValids: true,
         

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
        name: "Please enter clinic name.",
        country_id: "Please select country.",

        email: {
          required: 'Please enter email.',
          email: 'Please enter valid email.',
          remote: "Email id already exists in the system."
        },
        user_email: {
          required: 'Please enter email.',
          email: 'Please enter valid email.',
          remote: "Email id already exists in the system."
        },
        
        phone: {
          required: 'Please enter phone number.',
          NumberValids: 'Please enter valid phone number.',
          remote: "Phone number exists in the system."

        },
        user_phone: {
          required: 'Please enter phone number.',
          NumberValids: 'Please enter valid phone number.',
          remote: "Phone number exists in the system."
        },
        address: "Please enter address.",
        city: "Please enter city.",
        state: "Please enter state.",
        state_id: 'Please enter state',
        // zip : "Please enter zip." ,
        username: "Please enter name.",
        last_name :"Please enter last name.",
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
        }else if(element.hasClass("address")){
            error.insertAfter(".addresserr");
        }else if(element.hasClass("first_name")){
            error.insertAfter(".first_nameerr");
        }else if(element.hasClass("last_name")){
            error.insertAfter(".last_nameerr");
        }else if(element.hasClass("clinic_name")){
            error.insertAfter(".clinic_nameerr");
        } else {
          if (element.hasClass("phone-numberregistuser")) {
            error.insertAfter(".phone-numberregistuser");
          } else {
            error.insertAfter(element); // Place error messages after the input fields

          }
        }

      },

    });
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
        $(this).val(''); // Clear the input field
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






function clinicLogoImage(imagekey, imagePath, imgName) {

    $("#tempimage").val(imagekey);
    $("#clinicimage").attr("src", imagePath);
    $("#clinic_logo_name").text(imgName);
    $("#cliniclogoimage").show();
    $("#removelogo").show();
    $("#logodiv").hide();
    $(".logodiv").hide();

}
function removeLogo() {
    swal({
        title: '',
        text: 'Are you sure you want to remove this image?',
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        }).then((willDelete) => {


        if (willDelete) {
            event.preventDefault();
            $("#isremove").val('1');
            $("#cliniclogoimage").hide();
            $("#logodiv").show();
            $(".logodiv").show();
            } else {
            }

        // $("#upload-img").show();

    });
}


function doctorImage(imagekey, imagePath) {
    
    $("#usertempimage").val(imagekey);
    $("#doctorimage").attr("src", imagePath);
    $("#doctorimage").show();
    $("#user-upload-img").hide();
    $("#userremovelogo").show();
}
function removeImage(){
        $("#doctorimage").attr("src","{{asset('images/default_img.png')}}");
        $("#userisremove").val('1');
        $("#userremovelogo").hide();
        $("#user-upload-img").show();
    }


$(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });
        </script>


@stop