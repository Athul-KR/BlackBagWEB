

            <h4 class="text-center fw-medium mb-0 ">Enter Clinic Details</h4>
            <small class="gray">Provide your clinic's information to proceed.</small>
                      
            <form method="POST" id="registerform" autocomplete="off">
                @csrf

                    <div class="row mt-4">
                         
                        <div class="col-12">
                            <div class="form-group form-outline mb-4">
                                <label for="clinic_name" class="float-label">Clinic Name</label>
                                <i class="material-symbols-outlined">home_health</i>
                                <input type="text" name="clinic_name" class="form-control" id="clinic_name" value="">
                            </div>
                        </div>
                            
                        <div class="col-lg-6 col-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">Email</label>
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" class="form-control" name="email" id="email" value="">
                            </div>
                        </div>
                        <div class="col-lg-6 col-12">
                            <div class="form-group form-outline phoneregcls mb-4">
                                    <div class="country_code phone">
                                            <input type="hidden" id="cliniccountryCode" name="clinic_countrycode"  value='US'>
                                    </div>
                                        <i class="material-symbols-outlined me-2">call</i>
                                        <input type="text" name="phone_number" class="form-control phone-numberregister" id="clinic_phone_number" placeholder="Enter clinic phone number" required>
                             </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group form-floating mb-4">
                                <i class="material-symbols-outlined">public</i>
                                <select name="country_id" id="country_idclinic"  onchange="stateUS()" class="form-select autofillcountryclinic">
                                    <option value="">Select Country</option>
                                    @if(!empty($countryDetails))
                                    @foreach($countryDetails as $cds)
                                        @if(!empty($cds['id'] == 185))
                                            <option value="{{ $cds['id']}}" data-shortcode="{{$cds['short_code']}}" {{$cds['id']==185 ? 'selected': ''}} >{{ $cds['country_name']}}</option>
                                        @endif
                                    @endforeach
                                   @endif
                                </select>
                                <label class="select-label">Country</label>
                            </div>
                        </div>

                           
                        <div class="col-12">
                            <div class="form-group form-outline form-textarea mb-4">
                                <label for="addressclinic" class="float-label">Address</label>
                                <i class="material-symbols-outlined">home</i>
                                <textarea name="address" class="form-control" id="addressclinic" rows="1"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group form-outline mb-4">
                                <label for="cityclinic" class="float-label">City</label>
                                <i class="material-symbols-outlined">location_city</i>
                                <input type="text" name="city" class="form-control" id="cityclinic" value="">
                            </div>
                        </div>

                        <div class="col-lg-4 col-12" id="statesclinic" @if(!empty($clinicUserdetails) && $clinicUserdetails['country_id'] !='' && $clinicUserdetails['country_id'] == '236' ) style="display: block;" @else style="display: none;" @endif >
                            <div class="form-group form-floating mb-4">
                                <i class="material-symbols-outlined">map</i>
                                {{-- <label for="input" class="">State</label> --}}
                                <select name="state_id" id="state_idClinic" data-tabid="basic" class="form-select">
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
                        <div class="col-lg-4 col-12"  id="stateOtherclinic" @if(!empty($clinicUserdetails) && $clinicUserdetails['country_id'] !='' && $clinicUserdetails['country_id'] == '236' ) style="display: none;" @endif >
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">State</label>
                                <i class="material-symbols-outlined">map</i>
                                <input type="text" name="state" class="form-control" id="stateclinic" value="">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="form-group form-outline mb-4">
                                <label for="input" class="float-label">ZIP</label>
                                <i class="material-symbols-outlined">home_pin</i>
                                <input type="text" name="zip" class="form-control" id="zipclinic" value="">
                            </div>
                        </div>

                        <input type="hidden" name="first_name" class="form-control" id="first_name" value="@if(!empty($clinicUserdetails)) {{$clinicUserdetails['name']}} @endif">
                        <input type="hidden" name="user_countryCode" class="form-control" id="user_countryCode" value={{ isset($clinicUserdetails['country_code'])  ? $clinicUserdetails['country_code'] : '+1' }}>
                        <input type="hidden" name="user_phone" class="form-control" id="user_phone" value=@if(!empty($clinicUserdetails)){{$clinicUserdetails['phone_number']}}@endif>
                          
                        <div class="col-12">
                            <div class="btn_alignbox">
                                <a id="addbtn" onclick="addNewClinic()" class="btn btn-primary w-100" >Next</a>
                            </div> 
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

              $(document).ready(function() {
                stateUS();
                  $("#registerform").validate({
                          ignore: [],
                          rules: {
                              // first_name : 'required',
                            
                              // user_phone: {
                              //     required: true,
                              //      minlength: 10,
                              //     maxlength: 13,
                              //     number: true,
                               
                              // },
                              clinic_name : {
                                  required: true,
                                  maxlength: 150
                              },
                              email: {
                                  
                                  email: true,
                                  // remote: {
                                  //             url: "{{ url('frontend/checkPhoneExist') }}",
                                  //             data: {
                                  //             'type': 'clinic',
                                  //             'uuid': "",
                                  //             '_token': $('input[name=_token]').val(),
                                  //             'clinic_id': function () {
                                  //                     return ''; 
                                  //                     }, 
                                  //             'phone_number': function () {
                                  //                     return $("#user_phone").val(); 
                                  //                     }, 
                                  //                 'country_code': function () {
                                  //                 return $("#user_countryCodeShorts").val(); 
                                  //                 }, 
                                  //             },
                                  //             type: "post",
                                  //         },
                              } ,
                              address : 'required',
                              phone_number: {
                                  required: true,
                                  number: true,
                                  minlength: 10,
                                  maxlength: 13,
                                //   remote: {
                                //         url: "{ url('frontend/checkPhoneExist') }}",
                                //         data: {
                                //           'type': 'clinic',
                                //           '_token': $('input[name=_token]').val()
                                //         },
                                //         type: "post",
                                //     },

                              },
                              city : 'required',
                              country_id :'required',
                              state : {
                                  required: {
                                          depends: function(element) {
                                              return ( ($("#country_idclinic").val() !='185'));
                                              // return (($("#country").val() =='236') );
                                          }
                                  },
                              },
                              state_id : {
                                  required: {
                                          depends: function(element) {
                                              return ( ($("#country_idclinic").val() =='185'));
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
                                          return (($("#country_idclinic").val() !='236') && $("#country").val() !='235' );
                                      }
                                  },
                                      regex: {
                                      depends: function(element) {
                                          return ($("#country_idclinic").val()=='236' );
                                      }
                                  },
                                  zipRegex: {
                                      depends: function(element) {
                                          return ($("#country_idclinic").val() =='235');
                                      }
                                  },

                              },
                            
                              },

                          messages: {
                              clinic_name :{
                                  required : "Please enter clinic name.",
                                  maxlength : 'Please enter valid clinic name.'
                              },
                              country_id  :"Please select country." ,

                              email: {
                                  required : 'Please enter email.',
                                  email : 'Please enter valid email.',
                                    remote: "Email id already exists in the system."
                              },
                              phone_number: {
                                  required : 'Please enter phone number.',
                                  number : 'Please enter valid phone number.',
                                  minlength : 'Please enter valid phone number.',
                                  maxlength : 'Please enter valid phone number.',
                                   remote: "Phone number  exists in the system."
                                  
                              },
                              user_phone: {
                                  required : 'Please enter phone number.',
                                  number : 'Please enter valid phone number.',
                                  minlength : 'Please enter valid phone number.',
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
                        if ($("#country_idclinic").val() == 185) {
                          console.log($("#country_idclinic").val())
                            $("#statesclinic").show();
                            $("#stateOtherclinic").hide();
                            $("#stateclinic").val('');
                        } else {
                          console.log($("#country_idclinic").val())
                            $("#statesclinic").hide();
                            $("#state_idClinic").val('');
                            $("#stateOtherclinic").show();
                        }
                        updateAutocompleteCountryClinic();
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
    initializeIntlTelInput(clinicTelInput, clinicCountryCodeInput, clinicErrorMsg, clinicValidMsg,'clinic');
});

function initializeIntlTelInput(telInput, countryCodeInput, errorMsg, validMsg,type='') {
        // Initialize intlTelInput
        let onlyCountries;
        if (type === 'clinic') {
            // Only US allowed
            onlyCountries = ['us'];
        }else{
            onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
        }

        telInput.intlTelInput({
            initialCountry: "us",
            formatOnDisplay: false,
            autoHideDialCode: true,
            onlyCountries: onlyCountries,
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
            // countryCodeInput.val(countryData.dialCode);
            countryCodeInput.val(countryData.iso2);
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
                    url: '{{ url("store/clinic") }}',
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
                                    window.location.href = "{{url('/dashboard')}}";
                                }

                                // window.location.href = "{{ url('/dashboard') }}"; // Redirect to the dashboard
                            }, 2000); // 5 seconds (2 seconds + 3 seconds)
                            // 
                        } else {

                        }
                    },
                    error: function(xhr) {
                        
                      handleError(xhr);
                    }
                });

            } 
            // else {
            //     if ($('.error:visible').length > 0) {
            //         setTimeout(function() {
            //             $('html, body').animate({
            //                 scrollTop: ($('.error:visible').first().offset().top - 100)
            //             }, 500);
            //         }, 500);
            //     }
            // }

        }

        


</script>

<script>
      let autocompletecliic; // Store autocomplete globally
function updateAutocompleteCountryClinic() {
    let countryElement = document.getElementById("country_idclinic");

    if (!countryElement) {
        console.error("Country select element not found.");
        return;
    }

    let selectedCountry = countryElement.options[countryElement.selectedIndex]?.dataset.shortcode || 'US';

    console.log('Selected Country Code:', selectedCountry);

    if (autocompletecliic) {
        autocompletecliic.setComponentRestrictions({ country: [selectedCountry] }); // Ensure it's an array
    } else {
        initializeAutocompleteClinic(); // Reinitialize if needed
    }
    $("#addressclinic, #cityclinic, #zipclinic, #state_idclinic,#stateclinic").each(function () {
        $(this).val(''); // Clear the input field
        toggleLabel(this);
    });
}


function initializeAutocompleteClinic() {

    let addressInput = document.getElementById('addressclinic');
    if (addressInput) {
        addressInput.setAttribute("placeholder", ""); // Ensures no placeholder
    }

    // console.log("Initializing Google Places Autocomplete...");
    if (typeof google === "undefined" || !google.maps || !google.maps.places) {
        console.error("Google Maps API failed to load. Please check your API key.");
        // alert("Error: Google Maps API failed to load. Check the console.");
        return;
    }

    let input = document.getElementById('addressclinic');
    if (!input) {
        console.log("Address input field NOT found!");
        return;
    }

    let countryElement = document.getElementById("country_idclinic");
    let defaultCountry = countryElement ? countryElement.dataset.shortcode : 'US'
   
    console.log('def'+defaultCountry)
    autocompletecliic  = new google.maps.places.Autocomplete(input, {
        types: ['geocode', 'establishment'],
        componentRestrictions: { country: defaultCountry } // Set initial country
    });

    console.log("Google Places Autocomplete initialized successfully.");

    autocompletecliic.addListener('place_changed', function () {
        console.log("Place changed event triggered.");
        
        var place = autocompletecliic.getPlace();
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

        safeSetValue('addressclinic', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
        safeSetValue('cityclinic', addressComponents.city || '');
        safeSetValue('zipclinic', addressComponents.zip || '');
        safeSetValue('stateclinic', addressComponents.state || '');

       


        // Select the state in the dropdown
        let stateDropdown = document.getElementById('state_idClinic');
       
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
        $("#addressclinic, #cityclinic, #zipclinic, #state_idClinic").each(function () {
            $(this).valid(); 
        });
    });
}


    

</script>


