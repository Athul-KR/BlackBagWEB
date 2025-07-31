<style>
    /* Fix Google Autocomplete dropdown inside modal */
    .pac-container {
        z-index: 9999 !important;
    }
</style>
<div class="row g-4">
    <div class="col-lg-6">
        <div class="subscription-box">
            <h4>Clinic Subscription</h4>
            <?php $corefunctions = new \App\customclasses\Corefunctions; ?>

            <div class="row align-items-center my-4">
                <div class="col-12 col-lg-6"> 
                    <div class="amount m-0 align-items-center">
                        <h1 class="display-5 fw-bold mb-0">@if($monthlychecked == '1') $<?php echo $corefunctions->formatAmount($clinicSubscription['monthly_amount']); ?> 
                            @else $<?php echo $corefunctions->formatAmount($clinicSubscription['annual_amount']); ?> @endif
                        </h1>
                        <div>
                            <p class="mb-0">@if($monthlychecked == '1') Monthly @else Yearly @endif</p>
                            <p>Subscription Fee</p>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6"> 
                    <div class="user_inner justify-content-end">
                        <img src="{{$clinic['clinic_logo']}}">
                        <div class="user_info">
                            <h5 class="white fw-bold m-0">{{$clinic['name']}}</h5> 
                        </div>
                    </div>
                </div>
            </div>



            <div class="feature-box plan-highlighted">
                <div class="d-flex gap-3">
                    <img @if(!empty($clinicSubscription['id'] == '1')) src="{{asset('images/plan_icons/Diamond.png')}}" @else src="{{asset('images/plan_icons/'.$planIcons[$clinicSubscription['plan_icon_id']]['icon_path'])}}" @endif class="escribe-icon">
                    <div>
                        <h5 class="premium fw-bold mb-0">{{$clinicSubscription['plan_name']}}</h5>
                        <small>
                            <?php echo nl2br($clinicSubscription['description']) ?>
                        </small>
                    </div>
                </div>
                @if($clinic['appointment_type_id'] != '2')
                    <div class="fees-container"> 
                        <div class="d-flex align-items-center gap-3"> 
                            @if(isset($clinicSubscription['has_per_appointment_fee']) && $clinicSubscription['has_per_appointment_fee'] == '1')
                            <h2 class="mb-0">$<?php echo $corefunctions->formatAmount($clinicSubscription['virtual_fee']); ?></h2>
                            @else
                            <h2 class="mb-0">$<?php echo $corefunctions->formatAmount($clinic['virtual_fee']); ?></h2>
                            @endif
                            <div> 
                                <p class="mb-0">Virtual</p>
                                <p class="mb-0">Appointment Fee</p>
                            </div>
                        </div>
                    </div>
                @endif
                @if($clinic['appointment_type_id'] != '1')
                    <div class="fees-container border-bottom-0"> 
                        <div class="d-flex align-items-center gap-3"> 
                            @if(isset($clinicSubscription['has_per_appointment_fee']) && $clinicSubscription['has_per_appointment_fee'] == '1')
                                <h2 class="mb-0">$<?php echo $corefunctions->formatAmount($clinicSubscription['inperson_fee']); ?></h2>
                            @else
                                <h2 class="mb-0">$<?php echo $corefunctions->formatAmount($clinic['inperson_fee']); ?></h2>
                            @endif
                            <div> 
                                <p class="mb-0">In-Person</p>
                                <p class="mb-0">Appointment Fee</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="amount-list mb-4">
                <div class="d-sm-flex justify-content-between align-items-center gap-2 text-end">
                <div class="d-flex align-items-center gap-2"> 
                    <h4 class="fw-medium m-0">Total Due Today</h4>
                    <small class="white" @if($is_prorated == '0') style="display:none;" @endif>(Pro-rated Amount)</small>
                </div>
                    <h3 class="fw-bold m-0">$<?php echo number_format($proratedAmount,2); ?></h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="form-container">
            <form method="POST" id="subscriptionpaymentform" autocomplete="off">
            @csrf
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap"> 
                        <h4 class="fw-bold mb-0">Payment Method</h4>
                        <a onclick="addCard()" class="btn btn-outline-primary align_middle"><span class="material-symbols-outlined">add</span>Add Card</a>
                    </div>
                    <div class="selectedcardclserror">
                        @if(!empty($userCards))
                            @include('frontend.cards')
                        @else
                            <div class="d-flex justify-content-center">
                                <div class="text-center no-records-body">
                                    <img src="{{asset('images/nodata.png')}}"
                                        class="">
                                    <p>No Cards Added Yet</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <input type="hidden" id="cardadded" name="cardadded" @if(empty(!$userCards)) value="1" @endif>
                    <input type="hidden" id="amount" name="amount" value="{{$proratedAmount}}">
                    <input type="hidden" id="clinicid" name="clinicid" value="{{$clinic['id']}}">
                    <input type="hidden" id="key" name="key" value="{{$clinicSubscription['clinic_subscription_uuid']}}">
                    <input type="hidden" id="monthlychecked" name="monthlychecked" value="{{$monthlychecked}}">
                    <input type="hidden" id="pagetype" name="pagetype" value="{{$pageType}}">
                </div>

                <h6 class="sub-h fw-bold my-3">Billing Address</h6>

                <div class="row mt-2 mb-4">
                    <div class="col-md-12 mb-3">
                        <div class="form-group form-outline no-iconinput">
                            <label for="billingaddress" class="float-label">Address</label>
                            <textarea name="address" id="billingaddress" class="form-control" rows="1">@if(!empty($addressdata)) {{trim($addressdata['billing_address'])}} @endif</textarea>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group form-outline no-iconinput">
                            <label for="billingcity" class="float-label">City</label>
                            <input type="text" class="form-control" id="billingcity" name="city" @if(!empty($addressdata)) value="{{$addressdata['billing_city']}}" @endif>
                        </div>
                    </div>
                
                    <div class="col-md-6 mb-4">
                        <div class="form-group form-floating no-iconinput">
                            <select name="country_id" id="billingcountry_id" data-tabid="basic" onchange="stateUSBilling()" class="form-select autofillcountry">
                                <option value="">Select Country</option>
                                @if(!empty($countries))
                                    @foreach($countries as $cds => $cd)
                                        <option value="{{ $cd['id']}}" data-shortcode="{{$cd['short_code']}}" @if(!empty($addressdata) && ($cd['id'] == $addressdata['billing_country_id']) || $cd['id'] == 185)  selected @endif>{{ $cd['country_name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="billingcountry_id" class="select-label">Country</label>
                        </div>
                    </div>
                            
                    <div class="col-md-6 mb-4" id="billingstates">
                        <div class="form-group form-floating no-iconinput">
                            <select name="state_id" id="billingstate_id" data-tabid="basic" class="form-select">
                                <option value="">Select State</option>
                                @if(!empty($states))
                                @foreach($states as $sds)
                                <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}" @if(isset($addressdata['billing_state_id']) && $addressdata['billing_state_id'] !='' && $addressdata['billing_state_id'] == $sds['id']) selected @endif>{{ $sds['state_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                            <label for="billingstate_id" class="select-label">State</label>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4" style="display: none;" id="billingstateOther">
                        <div class="form-group form-outline mb-4">
                            <label for="billingstate" class="float-label">State</label>
                            <i class="material-symbols-outlined">map</i>
                            <input type="text" name="state" class="form-control" id="billingstate"  @if(!empty($addressdata)) value="{{$addressdata['billing_state_other']}}" @endif>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group form-outline no-iconinput">
                            <label for="billingzip" class="float-label">ZIP</label>
                            <input type="text" class="form-control" id="billingzip" name="zip" @if(!empty($addressdata)) value="{{$addressdata['billing_zip']}}" @endif>
                        </div>
                    </div>
                    <!-- <div class="col-12"> 
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="sameAsProfileCheckbox">
                            <label class="form-check-label gray" for="sameAsProfileCheckbox">
                                Same as profile
                            </label>
                        </div>
                    </div> -->
                </div>
                <small class="text-muted d-block mb-4">
                    <span class="text-danger">*</span> By confirming your subscription, you agree to an annual commitment and authorize BlackBag to charge you monthly in accordance with our terms. You may cancel anytime, and your subscription will remain active until the end of the billing period.
                </small>
                <button type="button" class="btn btn-primary w-100" id="subsrptnbtn" onclick="confirmSubscriptionPayment();">
                    Confirm Payment
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
        const isFocused = $input.is(':focus');

        // Ensure .float-label is correctly selected relative to the input
        $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
    }
    function addCard(){
        $("#upgradePlans").modal('hide');
        $("#add_card_modal").modal('show');
        initializeAddCard();
    }
    function initializeAddCard(){
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
        var cardElement = elements.create('card', {hidePostalCode: true,style: style});
        cardElement.mount('#add_card_element');
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('add-card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        var cardholderName = document.getElementById('name_on_card');
        var clientSecret = '<?php echo $clientSecret;?>'
        var form = document.getElementById("addcardsform");
        form.addEventListener("submit", function(event) {
            $("#submitbtn").text('Processing');
            $("#submitbtn").addClass('disabled');
            $("#submitbtn").prop('disabled',true);
            event.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ URL::to('/getstripeclientsecret')}}",
                data: 
                {"_token": "{{ csrf_token() }}"},
                dataType : 'json',
                success: function(data) {
                    if(data.success==1){
                        var clientSecret = data.clientSecret;
                        stripe.confirmCardSetup(
                            clientSecret,
                            {
                            payment_method: {
                                card: cardElement
                            },
                            }
                        ).then(function(result) {
                            console.log(result);
                            if (result.error) {
                                var errorElement = document.getElementById('new-card-errors');
                                errorElement.textContent = result.error.message;
                                $("#add-card-errors").show();
                                $("#cardvalid").val('');
                            } else {
                                $("#cardvalid").val('1');
                                stripeTokenHandler(result.setupIntent.payment_method,result.setupIntent.id);
                            }
                        });
                    }
                }
            });
        });
    }
    function stripeTokenHandler(token,setupIntentID) {
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
        if($("#addcardsform").valid()){
            submitCard();
        }
    }
    $(document).ready(function() {
        stateUSBilling();
        $('#addcardsform').validate({
            ignore: [],
            rules: {
                name_on_card: {
                    required: true,
                    letterswithspaces: true
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
                    letterswithspaces: "Please enter valid name."
                },
                card_number: {
                    required: "Please enter card number",
                    minlength:"Please enter valid card number",
                    number:"Please enter valid card number",
                },
                expiry_month: {
                    required: "Please select a month",
                    max: "Please enter valid month ",
                    min:"Please enter valid monthr ",
                    number:"Please enter valid month",
                },
                ccv: {
                    required: "Please enter cvv",
                    minlength:"Please enter valid cvv ",
                    number:"Please enter valid cvv",
                },
                expiry_year: {
                    required: "Please select a year",
                    min:"Please enter valid year",
                    number:"Please enter valid year",
                }
            },
        });

        $.validator.addMethod("letterswithspaces", function(value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/i.test(value);
        }, "Please enter only letters and spaces");

        $("#subscriptionpaymentform").validate({
            ignore: [],
            rules: {
                cardadded: 'required',
                selected_card: 'required',
                address: 'required',
                city: 'required',
                country_id: 'required',
                state: {
                    required: {
                        depends: function (element) {
                            return (($("#billingcountry_id").val() != '185'));
                        },
                    },
                },
                state_id: {
                    required: {
                        depends: function (element) {
                        return (($("#billingcountry_id").val() == '185'));
                        }
                    },
                },
                zip: {
                    required: true,
                    zipmaxlength: {
                        depends: function (element) {
                        return (($("#billingcountry_id").val() != '236') && $("#country").val() != '235');
                        }
                    },
                    regex: {
                        depends: function (element) {
                        return ($("#billingcountry_id").val() == '236');
                        }
                    },
                    zipRegex: {
                        depends: function (element) {
                        return ($("#billingcountry_id").val() == '235');
                        }
                    },
                },
            },

            messages: {
                cardadded: 'Please add atleast one card',
                selected_card: {
                    required: "Please select a card",
                },
                country_id: "Please select country.",
                address: "Please enter address.",
                city: "Please enter city.",
                state: "Please enter state.",
                state_id: 'Please enter state',
                zip: {
                    required: 'Please enter zip',
                    zipmaxlength: 'Please enter a valid zip.',
                    digits: 'Please enter a valid zip.',
                    regex: 'Please enter a valid zip.',
                    zipRegex: 'Please enter a valid zip.',
                },
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("selectedusercls")) {
                    error.insertAfter(".selecteduserclserror");
                }else if (element.hasClass("selectedcardcls")) {
                    error.insertAfter(".selectedcardclserror");
                }else {
                    error.insertAfter(element);
                }
            },
        });
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
    function submitCard(){
        if($('#addcardsform').valid()){
            var clinicId = $("#clinicid").val();
            var subscriptionkey = $("#key").val();
            $.ajax({
                url: '{{ url("/addcard") }}',
                type: "post",
                data: {
                    'type':'patient',
                    'formdata': $("#addcardsform").serialize(),
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            // showPreloader('subscriptions');
                            $("#add_card_modal").modal('hide');
                            showPaymentModal(clinicId,subscriptionkey);
                            setTimeout(function(){
                                var radio = $("#selected_card_" + data.key);
                                $(".selectedcardcls").prop("checked", false);
                                if (radio.length) {
                                    radio.prop("checked", true).trigger("change");
                                    console.log("Radio checked successfully");
                                } else {
                                    console.error("Radio button not found");
                                }
                            }, 1000);
                        });
                    } else {
                        swal(data.errormsg, {
                            icon: "error",
                            text: data.errormsg,
                            button: "OK",
                        });
                        $("#submitbtn").removeClass('disabled');
                        $("#submitbtn").prop('disabled',false);
                        $("#submitbtn").text('Add Card');
                        $("#add_card_modal").modal('hide');
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }else{
            $("#submitbtn").removeClass('disabled');
            $("#submitbtn").prop('disabled',false);
            $("#submitbtn").text('Add Card');
        }
    }
    function stateUSBilling() {
        if ($("#billingcountry_id").val() == 185) {
            $("#billingstates").show();
            $("#billingstateOther").hide();
            $("#billingstate").val('');
        } else {
            $("#billingstates").hide();
            $("#billingstate_id").val('');
            $("#billingstateOther").show();
        }
        $("#upgradePlans").on('shown.bs.modal', function () {
            initializeAutocompleteBilling();
        });
    }
    var autocompletebillingsub;
    function updateAutocompleteCountryBilling() {
        let countryElement = document.getElementById("billingcountry_id");
        if (!countryElement) {
            console.error("Country select element not found.");
            return;
        }
        // Get the selected option's dataset shortcode
        let selectedOption = countryElement.options[countryElement.selectedIndex];
        let selectedCountry = selectedOption ? selectedOption.dataset.shortcode : 'US';
        // Validate the country code
        if (!selectedCountry || selectedCountry.length !== 2) {
            console.warn('Invalid country code, defaulting to US');
            selectedCountry = 'US';
        }
        console.log('Selected Country Code:', selectedCountry);
        var countrynew = $('#billingcountry_id').val(); 
        if (autocompletebillingsub) {
            autocompletebillingsub.setComponentRestrictions({ country: selectedCountry });
        }

        $("#billingaddress, #billingcity, #billingzip, #billingstate_id,#billingstate").each(function () {
            $(this).val('');
            toggleLabel(this);
        });
    }
    function initializeAutocompleteBilling() {
        // First check if Google API is loaded
        if (typeof google === "undefined" || !google.maps || !google.maps.places) {
            console.error("Google Maps API is not loaded yet. Please check your API key and connection.");
            return;
        }

        // Get the billing address input element
        const billingInput = document.getElementById('billingaddress');
        
        // Check if the element exists
        if (!billingInput) {
            console.error("Billing address input element not found with ID 'billingaddress'");
            return;
        }

        // Clear any placeholder
        billingInput.setAttribute("placeholder", "");

        // Get the country value
        const countrynew = $('#billingcountry_id').val();
        const defaultCountry = (countrynew == '185') ? 'US' : 'IN';

        try {
            if (window.autocompletebillingsub) {
                google.maps.event.clearInstanceListeners(window.autocompletebillingsub);
                window.autocompletebillingsub = null;
            }
            // Initialize the autocomplete with error handling
            window.autocompletebillingsub = new google.maps.places.Autocomplete(billingInput, {
                types: ['geocode', 'establishment'],
                componentRestrictions: { country: defaultCountry }
            });

            if (!autocompletebillingsub) {
                console.error("Failed to initialize Google Places Autocomplete");
                return;
            }

            console.log("Google Places Autocomplete initialized successfully");

            // Add the place_changed listener
            autocompletebillingsub.addListener('place_changed', function() {
                const place = window.autocompletebillingsub.getPlace();
                console.log(place);
                if (!place || !place.address_components) {
                    console.error("Invalid place selected - no address components found");
                    return;
                }

                // Rest of your existing place_changed handler code
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

                    if (place.types.includes("establishment")) {
                        if (!addressComponents.street_number.includes(place.name)) {
                            addressComponents.street_number += (addressComponents.street_number ? ", " : "") + place.name;
                        }
                    }

                    if (types.includes("street_number")) {
                        if (!addressComponents.street_number.includes(component.long_name)) {
                            addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                        }
                    }

                    if (types.includes("route")) {
                        if (!addressComponents.street_number.includes(component.long_name)) {
                            addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                        }
                    }

                    if (types.includes("locality")) addressComponents.city = component.long_name;
                    if (types.includes("administrative_area_level_1")) addressComponents.state = component.short_name;
                    if (types.includes("postal_code")) addressComponents.zip = component.long_name;
                });

                // Safe function to prevent errors
                function safeSetValue(id, value) {
                    const element = document.getElementById(id);
                    if (element) {
                        element.value = value;
                        const label = element.closest(".form-group")?.querySelector(".float-label");
                        if (label && value.trim() !== "") {
                            label.classList.add("active");
                        }
                    }
                }

                // Set the values safely
                safeSetValue('billingaddress', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
                safeSetValue('billingcity', addressComponents.city || '');
                safeSetValue('billingzip', addressComponents.zip || '');
                safeSetValue('billingstate', addressComponents.state || '');

                  // Select the state in the dropdown
                let stateDropdown = document.getElementById('billingstate_id');
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

                // Validate the fields
                $("#billingaddress, #billingcity, #billingzip, #billingstate_id").each(function() {
                    $(this).valid();
                });
            });

        } catch (error) {
            console.error("Error initializing Google Places Autocomplete:", error);
        }
    }
    function confirmSubscriptionPayment(){
        var pagetype = $("#pagetype").val();
        if($("#subscriptionpaymentform").valid()){
            $("#subsrptnbtn").addClass('disabled');
            $("#subsrptnbtn").prop('disabled',true);
            let msg = 'Are you sure you want to proceed with the payment?';
            swal({
                text: msg,
                icon: "warning",
                buttons: {
                    cancel: "Cancel",
                    confirm: {
                    text: "OK",
                    value: true,
                    closeModal: false // Keeps the modal open until AJAX is done
                    }
                },
                dangerMode: true
            }).then((willConfirm) => {
                if (willConfirm) {
                    $.ajax({
                        url: '{{ url("/myaccounts/subscriptionpayment/submit") }}',
                        type: "post",
                        data: {
                            'formdata': $("#subscriptionpaymentform").serialize(),
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success == 1) {
                                $("#upgradePlans").modal('hide');
                                swal.close();
                                $("#successSubscription").modal('show');
                                $("#successmsg").text(data.message);
                                $('#successSubscription').on('hidden.bs.modal', function () {
                                    if(pagetype == 'accounts'){
                                        changeTab('subscriptions');
                                    }else{
                                        window.location.href = "{{url('onboarding/getstarted')}}";
                                    }
                                });
                            }else{
                                swal(data.errormsg, {
                                    icon: "error",
                                    text: data.errormsg,
                                    button: "OK",
                                });
                            }
                        },
                        error: function(xhr) {
                            handleError(xhr);
                        },
                    });
                }else{
                    $("#subsrptnbtn").removeClass('disabled');
                    $("#subsrptnbtn").prop('disabled',false);
                }
            });
        }
    }

$(document).ready(function() {
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

</script>