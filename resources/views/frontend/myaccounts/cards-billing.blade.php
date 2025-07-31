<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
<div class="row g-3">

    <div class="col-12 col-lg-7">
        <div class="border rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                <h5 class="fw-bold mb-0">Card Information</h5>
                <a onclick="addCard()" id="addcard" class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined primary fw-middle">add</span>
                    <p class="text-decoration-underline fw-bold primary mb-0">Add Card</p>
                </a>
            </div>
            <div class="cards-section">
                @include('frontend.cards')
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-5">
        <div class="border rounded-4 p-4 h-100">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

                <h5 class="fw-bold mb-0">Billing Address</h5>


                @if(empty($addresses))
                <a onclick="addBilling()" id="addbilling" class="d-flex align-items-center gap-2">
                    <span class="material-symbols-outlined primary fw-middle">add</span>
                    <p class="text-decoration-underline fw-bold primary mb-0">Add Billing Info</p>
                </a>
                @endif
                @if(!empty($addresses))
                @foreach ($addresses as $adds )
                <a onclick="editAddress('{{$adds['user_billing_uuid']}}')" href="javascript:void(0);" class="edit-btn primary"><i class="fa-regular fa-pen-to-square"></i></a>

                @endforeach
                @endif
            </div>

            @if(!empty($addresses))
            <div class="">
                @foreach ($addresses as $adds )
                <div class="d-flex gap-3">
                    <span class="material-symbols-outlined gray">apartment</span>
                    <div>
                        <h6><?php echo $adds['company_name']; ?></h6>
                        <p class="mb-1"><?php echo $adds['address']; ?></p>
                        <p class="mb-1">{{$adds['city']}}, {{$adds['country_id']==185? $adds['state']:$adds['state_name']  }} {{$adds['postal_code']}}</p>
                        <p class="mb-1">@if(isset($countries[$adds['country_id']]) && !empty($countries[$adds['country_id']]['country_name']) ){{$countries[$adds['country_id']]['country_name']}} @endif</p>
                        <p class="mb-1"><?php echo $adds['country_code']; ?> <?php echo $adds['phone_number']; ?></p>
                    </div>
                </div>

                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
</div>



<script>
    function stateUS() {
        if ($("#country_id").val() == 185) {
            $("#statelist").show();
            $("#statesel").hide();
            $("#state").val('');
        } else {
            $("#statelist").hide();
            $("#billingstate_id").val('');
            $("#statesel").show();
        }
        updateAutocompleteCountryBilling()
    }


    $(document).ready(function() {
        stateUS();

        var telInput = $("#phone"),
            countryCodeInput = $("#countryCode"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");
        let onlyCountries = '{!! json_encode($corefunctions->getCountry()) !!}';

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

        // Handle country change event
        telInput.on("countrychange", function(e, countryData) {


            countryCodeInput.val(countryData.iso2);
            updateAutocompleteCountry()
            if (countryData.dialCode == 1) {
                $("#statelist").show();
                $("#statesel").hide();
            } else {
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

        $("#addaddressform").validate({
            ignore: [],
            rules: {
                company_name: {
                    required: true,
                    noWhitespace: true,
                },
                address: {
                    required: true,
                    noWhitespace: true,
                },
                phone_number: {
                    required: true,
                    NumberValids: true,
                },
                city: {
                    required: true,
                    noWhitespace: true,
                },
                country_id: 'required',
                state: {
                    required: {
                        depends: function(element) {
                            return (($("#country_id").val() != '185'));
                        },
                    },
                    noWhitespace: true,
                },
                state_id: {
                    required: {
                        depends: function(element) {
                            return (($("#country_id").val() == '185'));
                        }
                    },
                    noWhitespace: true,
                },
                zip: {
                    noWhitespace: true,
                    required: true,
                    zipmaxlength: {
                        depends: function(element) {
                            return (($("#country_id").val() != '236') && $("#country").val() != '235');
                        }
                    },
                    regex: {
                        depends: function(element) {
                            return ($("#country_id").val() == '236');
                        }
                    },
                    zipRegex: {
                        depends: function(element) {
                            return ($("#country_id").val() == '235');
                        }
                    },
                },
            },

            messages: {
                company_name: {
                    required: "Please enter company name.",
                    noWhitespace: "Please enter valid company name.",
                },
                country_id: "Please select country.",
                phone_number: {
                    required: 'Please enter phone number.',
                    NumberValids: 'Please enter valid phone number.',
                    remote: "Phone number exists in the system."
                },
                address: "Please enter address.",
                city: {
                    required: "Please enter city.",
                    noWhitespace: "Please enter valid city.",
                },
                state: {
                    required: "Please enter state.",
                    noWhitespace: "Please enter valid state.",
                },
                state_id: {
                    required: "Please enter state.",
                    noWhitespace: "Please enter valid state.",
                },
                // state_id: 'Please enter state',
                zip: {
                    required: 'Please enter zip',
                    zipmaxlength: 'Please enter a valid zip.',
                    digits: 'Please enter a valid zip.',
                    regex: 'Please enter a valid zip.',
                    zipRegex: 'Please enter a valid zip.',
                    noWhitespace: "Please enter valid zip.",
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-numberregister")) {
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
        jQuery.validator.addMethod("NumberValids", function(phone_number, element) {
            phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
            return this.optional(element) || phone_number.length < 14 &&
                phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
        });
        $.validator.addMethod(
            "format",
            function(value, element) {
                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailRegex.test(value);
            },
            "Please enter a valid email address."
        );
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

    function addBilling() {
        // alert("ddd")
        const $form = $('#addaddressform');

        // Reset native fields
        $form[0].reset();

        // Clear text inputs, textareas, selects manually (for dynamic cases)
        $form.find('input, textarea, select').val('').trigger('change');

        $("#addbilling_modal").modal('show');
        $('#addaddressform')[0].reset();
        $('label.error').remove();
        initializeAutocompleteBilling();
    }

    function initializeAutocompleteBilling() {
        let autocompletecliic;
        let addressInput = document.getElementById('billingaddress');
        if (addressInput) {
            addressInput.setAttribute("placeholder", ""); // Ensures no placeholder
        }

        // console.log("Initializing Google Places Autocomplete...");
        if (typeof google === "undefined" || !google.maps || !google.maps.places) {
            console.error("Google Maps API failed to load. Please check your API key.");
            // alert("Error: Google Maps API failed to load. Check the console.");
            return;
        }

        let input = document.getElementById('billingaddress');
        if (!input) {
            console.log("Address input field NOT found!");
            return;
        }
        var countrynew = $('#country_id').val();
        let defaultCountry = (countrynew == '185') ? 'US' : 'IN';
        let countryElement = document.getElementById("country_id");
        // let defaultCountry = countryElement ? countryElement.dataset.shortcode : 'US'

        console.log('def' + defaultCountry)
        autocompletecliic = new google.maps.places.Autocomplete(input, {
            types: ['geocode', 'establishment'],
            componentRestrictions: {
                country: defaultCountry
            } // Set initial country
        });

        console.log("Google Places Autocomplete initialized successfully.");

        autocompletecliic.addListener('place_changed', function() {
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

            safeSetValue('billingaddress', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
            safeSetValue('billingcity', addressComponents.city || '');
            safeSetValue('billingzip', addressComponents.zip || '');
            safeSetValue('billingstate', addressComponents.state || '');




            // Select the state in the dropdown
            let stateDropdown = document.getElementById('billingstate_id');

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
            $("#billingaddress, #billingcity, #billingzip, #billingstate_id").each(function() {
                $(this).valid();
            });
        });
    }

    function updateAutocompleteCountryBilling() {
        let selectedCountry = document.querySelector('.autofillcountrysel')?.value || 'US';
        console.log('new' + selectedCountry)
        if (autocomplete) {
            autocomplete.setComponentRestrictions({
                country: selectedCountry
            });
        } else {
            initializeAutocompleteBilling(); // Reinitialize if needed
        }
        $("#billingaddress, #billingcity, #billingzip, #billingstate_id").each(function() {
            $(this).val(''); // Clear the input field
            toggleLabel(this);
        });

    }

    function editAddress(key) {
        $("#addsubscriptionaddress").modal('show');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('addnewaddress')}}",
            data: {
                "key": key,
                "type": "edit",
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
                if (data.success == 1) {
                    $("#addnewaddress").html(data.view);
                    $('input, textarea').each(function() {
                        toggleLabel(this);
                    });
                    initializeIntlTelInput();
                    initializeAutocomplete();
                }
            }
        });
    }
    $('#phone').mask('(ZZZ) ZZZ-ZZZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: false
            }
        }
    })

    function submitAddress() {
        if ($("#addaddressform").valid()) {
            $("#submitaddress").prop("disabled", true);
            $.ajax({
                type: "POST",
                url: "{{ URL::to('myaccounts/saveaddress')}}",
                data: {
                    'formdata': $('#addaddressform').serialize(),
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == 1) {
                        $("#addbilling_modal").modal('hide');
                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            changeTab('cards-billing')
                        });
                    } else {
                        swal(data.message, {
                            icon: "error",
                            text: data.message,
                            button: "OK",
                        });
                    }
                }
            });
        }
    }

    var stripe = Stripe('{{ env("STRIPE_KEY") }}');
    // Create an instance of Elements.
    var elements = stripe.elements();
    var style = {
        hidePostalCode: true,
        base: {
            color: '#32325d',
            lineHeight: '18px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var elements = stripe.elements();
    var cardElement = elements.create('card', {
        hidePostalCode: true,
        style: style
    });
    cardElement.mount('#add-card-element');
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('add-card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    var cardholderName = document.getElementById('name_on_card');
    var clientSecret = '<?php echo $clientSecret; ?>'
    var form = document.getElementById("addcardsform");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/getstripeclientsecret')}}",
            data: {
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
                if (data.success == 1) {
                    var clientSecret = data.clientSecret;
                    stripe.confirmCardSetup(
                        clientSecret, {
                            payment_method: {
                                card: cardElement
                            },
                        }
                    ).then(function(result) {
                        console.log(result);
                        if (result.error) {
                            if (result.error.code === 'expired_card') {
                                console.error(' Card has expired:', result.error.message);
                                swal('Warning', 'Your card has expired. Please use a valid card.', 'warning');

                            } else {
                                console.error(' Payment error:', result.error.message);
                                swal('Warning', result.error.message, 'warning');

                            }
                            var errorElement = document.getElementById('new-card-errors');
                            errorElement.textContent = result.error.message;
                            $("#add-card-errors").show();
                            $("#cardvalid").val('');

                        } else {
                            $("#cardvalid").val('1');
                            stripeTokenHandler(result.setupIntent.payment_method, result.setupIntent.id);
                        }
                    });
                }

            }
        });
    });

    // Submit the form with the token ID.
    function stripeTokenHandler(token, setupIntentID) {
        var form = document.getElementById('addcardsform');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token);
        form.appendChild(hiddenInput);
        var hiddenInput1 = document.createElement('input');
        hiddenInput1.setAttribute('type', 'hidden');
        hiddenInput1.setAttribute('name', 'setupintentid');
        hiddenInput1.setAttribute('id', 'setupintentid');
        hiddenInput1.setAttribute('value', setupIntentID);
        form.appendChild(hiddenInput1);

        if ($("#addcardsform").valid()) {
            submitCard();
        }
    }
    $(document).ready(function() {
        $('#addcardsform').validate({
            ignore: [],
            rules: {
                name_on_card: {
                    required: true,
                    letterswithspaces: true,
                    noWhitespace: true,
                },
                card_number: {
                    required: true,
                },
                expiry_month: {
                    required: true,
                },
                expiry_year: {
                    required: true,
                },
                ccv: {
                    required: true,
                    minlength: 3,
                    number: true
                },
            },
            messages: {
                name_on_card: {
                    required: "Please enter your name",
                    letterswithspaces: "Please enter valid name.",
                    noWhitespace: "Please enter valid name."
                },
                card_number: {
                    required: "Please enter card number",
                    minlength: "Please enter valid card number",
                    number: "Please enter valid card number",
                },
                expiry_month: {
                    required: "Please select a month",
                    max: "Please enter valid month ",
                    min: "Please enter valid monthr ",
                    number: "Please enter valid month",
                },
                ccv: {
                    required: "Please enter cvv",
                    minlength: "Please enter valid cvv ",
                    number: "Please enter valid cvv",
                },
                expiry_year: {
                    required: "Please select a year",
                    min: "Please enter valid year",
                    number: "Please enter valid year",
                }
            },
        });

        jQuery.validator.addMethod("noWhitespace", function(value, element) {
            return $.trim(value).length > 0;
        }, "This field is required.");

        $.validator.addMethod("letterswithspaces", function(value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/i.test(value);
        }, "Please enter only letters and spaces");
    });

    function addCard() {
        $("#settingsModal").modal('hide');
        $("#addcard_modal").modal('show');
        $('#addcardsform')[0].reset();
    }

    function submitCard() {
        if ($('#addcardsform').valid()) {
            $("#submitbtn").addClass('disabled');
            $("#submitbtn").prop('disabled', true);
            $.ajax({
                url: '{{ url("/addcard") }}',
                type: "post",
                data: {
                    'formdata': $("#addcardsform").serialize(),
                    'type': 'patient',
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#addcard_modal").modal('hide');

                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            changeTab('cards-billing');
                        });
                    } else {
                        swal(data.errormsg, {
                            icon: "error",
                            text: data.errormsg,
                            button: "OK",
                        });
                        $("#submitbtn").removeClass('disabled');
                        $("#submitbtn").prop('disabled', false);
                        $("#addcard_modal").modal('hide');
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }
    }


    function markAsDefault(key) {
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/markasdefault')}}",
            data: {
                'key': key,
                'type': 'patient',
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
                if (data.success == 1) {
                    changeTab('cards-billing');
                } else {
                    swal(data.message, '', 'error');
                    window.location.reload();
                }
            }
        });
    }

    function removeCard(key) {
        swal({
            title: '',
            text: 'Are you sure you want to remove this card?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/removecard')}}",
                    data: {
                        'key': key,
                        'type': 'patient',
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == 1) {
                            swal("Success!", data.message, "success").then(() => {
                                changeTab('cards-billing');
                            });
                        } else {
                            swal("Error!", data.message, "error");
                        }
                    }
                });
            }
        });
    }
</script>

<div class="modal login-modal payment-success fade" id="addbilling_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center amount_body mb-3">
                    <h4 class="text-center fwt-bold mb-1">Billing Details</h4>
                    <small class="gray">Please enter billing details</small>
                </div>
                <form class="sign" method="POST" id="addaddressform" action="">
                    @csrf
                    <div class="">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group form-outline mb-4">
                                    <i class="material-symbols-outlined">business_center</i>
                                    <label for="company_name" class="float-label">Billing Name/Company Name</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="" @if(!empty($addressdata)) valaddress.bladeue="{{$addressdata['company_name']}}" @endif>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group form-outline phoneregcls mb-4">
                                    <div class="country_code phone">
                                        <input type="hidden" id="countryCode" name="countrycode" value='US' class="autofillcountry">
                                    </div>
                                    <i class="material-symbols-outlined me-2">call</i>
                                    <input type="text" placeholder="Phone Number" name="phone_number" class="form-control phone-number" id="phone">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group form-floating mb-4">
                                    <i class="material-symbols-outlined">public</i>
                                    <select name="country_id" id="country_id" data-tabid="basic" onchange="stateUS()" class="form-select autofillcountrysel">
                                        <option value="">Select Country</option>
                                        @if(!empty($countries))
                                        @foreach($countries as $cds => $cd)
                                        <option value="{{ $cd['id']}}" data-shortcode="{{$cd['short_code']}}" {{$cd['id'] == 185 ? 'selected' : ''}}>{{ $cd['country_name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label class="select-label">Country</label>
                                </div>
                            </div>
                            <div class="col-lg-12 col-12">
                                <div class="form-group form-outline textarea-align mb-4">
                                    <label for="billingaddress" class="float-label">Address</label>
                                    <i class="material-symbols-outlined">home</i>
                                    <textarea name="address" id="billingaddress" class="form-control" rows="1"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group form-outline mb-4">
                                    <label for="billingcity" class="float-label">City</label>
                                    <i class="material-symbols-outlined">location_city</i>
                                    <input type="text" name="city" class="form-control" id="billingcity">
                                </div>
                            </div>
                            <div class="col-lg-4" id="statelist">
                                <div class="form-group form-floating mb-4">
                                    <i class="material-symbols-outlined">map</i>
                                    {{-- <label for="input" class="">State</label> --}}
                                    <select name="state_id" id="billingstate_id" data-tabid="basic" class="form-select">
                                        <option value="">Select State</option>
                                        @if(!empty($states))
                                        @foreach($states as $sds)
                                        <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}">{{ $sds['state_name']}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <label class="select-label">State</label>
                                </div>
                            </div>
                            <div class="col-lg-4" style="display: none;" id="statesel">
                                <div class="form-group form-outline mb-4">
                                    <label for="billingstate" class="float-label">State</label>
                                    <i class="material-symbols-outlined">map</i>
                                    <input type="text" name="state" class="form-control" id="billingstate">
                                </div>
                            </div>



                            <div class="col-lg-4">
                                <div class="form-group form-outline mb-4">
                                    <label for="billingzip" class="float-label">ZIP</label>
                                    <i class="material-symbols-outlined">home_pin</i>
                                    <input type="text" name="zip" class="form-control" id="billingzip">
                                </div>
                            </div>
                            <div class="btn_alignbox mt-3">
                                <button type="button" onclick="submitAddress()" id="submitaddress" class="btn btn-primary invite-btn">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal login-modal payment-success fade" id="addsubscriptionaddress" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="addnewaddress">

        </div>
    </div>
</div>


<div class="modal login-modal payment-success fade" id="addcard_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center amount_body mb-3">
                    <h4 class="text-center fwt-bold mb-1">Add New Card</h4>
                    <p class="gray fw-light">Please enter card details</p>
                </div>
                <form method="POST" action="" id="addcardsform" autocomplete="off">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group form-outline mb-4">
                                <i class="material-symbols-outlined">id_card</i>
                                <label for="input" class="float-label">Cardholder Name</label>
                                <input type="name" class="form-control" id="name_on_card" name="name_on_card">
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="add-card-element">

                            </div>
                        </div>
                        <div class="btn_alignbox mt-3">
                            <button type="submit" id="submitbtn" class="btn btn-primary w-100">Add Card</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>