<div class="modal-header modal-bg p-0 position-relative">
    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<div class="modal-body">
    <div class="text-center amount_body mb-3">
        <h4 class="text-center fwt-bold mb-1">Billing Details</h4>
        <small class="gray">Please enter billing details</small>
    </div>
    <form class="sign" method="POST" id="editaddressform" action="">
        @csrf
        <div class="">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="form-group form-outline mb-4">
                        <i class="material-symbols-outlined">business_center</i>
                        <label for="company_name" class="float-label">Billing Name/Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" placeholder="" @if(!empty($addressdata)) value="{{$addressdata['billing_company_name']}}" @endif>
                    </div>
                </div>
                <?php
                $Corefunctions = new \App\customclasses\Corefunctions;
                ?>
                <?php /* <div class="col-12 col-md-6">
                    <div class="form-group form-outline phoneregcls mb-3">
                        <div class="country_code phone">
                            <input type="hidden" class="autofillcountry" id="countryCodeedit" name="countrycode" value={{ isset($countryCodedetails['short_code'])  ? $countryCodedetails['short_code'] : 'US' }}>
                        </div>
                        <!-- <label for="phone" class="float-label ">Phone Number</label> -->
                        <i class="material-symbols-outlined me-2">call</i>
                        <input type="tel" name="phone_number" placeholder="Phone Number" class="form-control phone-number" id="phoneedit" value="<?php echo isset($addressdata['billing_country_code'])  ? '+' . $addressdata['billing_country_code'] . $Corefunctions->formatPhone($addressdata['billing_phone']) : $Corefunctions->formatPhone($addressdata['billing_phone']) ?>">
                    </div>
                </div> */ ?>
                <div class="col-lg-12">
                    <div class="form-group form-floating mb-4">
                        <i class="material-symbols-outlined">public</i>
                        <select name="country_id" id="country_id1" data-tabid="basic" onchange="stateUS(this)" class="form-select autofillcountry">
                            <option value="">Select Country</option>
                            @if(!empty($countries))
                            @foreach($countries as $cds => $cd)
                            <option value="{{ $cd['id']}}" data-shortcode="{{$cd['short_code']}}" @if(!empty($addressdata) && ($cd['id']==$addressdata['billing_country_id']) ) selected @endif>{{ $cd['country_name']}}</option>
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
                        <textarea name="address" id="address" class="form-control" rows="1">@if(!empty($addressdata)){{trim($addressdata['billing_address'])}}@endif</textarea>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group form-outline mb-4">
                        <label for="city" class="float-label">City</label>
                        <i class="material-symbols-outlined">location_city</i>
                        <input type="text" name="city" class="form-control" id="city" @if(!empty($addressdata)) value="{{trim($addressdata['billing_city'])}}" @endif>
                    </div>
                </div>
                <div class="col-lg-4" id="statelist_div">
                    <div class="form-group form-floating mb-4">
                        <i class="material-symbols-outlined">map</i>
                        {{-- <label for="input" class="">State</label> --}}
                        <select name="state_id" id="state_id" data-tabid="basic" class="form-select">
                            <option value="">Select State</option>
                            @if(!empty($states))
                            @foreach($states as $sds)
                            <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}" @if(isset($addressdata['billing_state_id']) && $addressdata['billing_state_id'] !='' && $addressdata['billing_state_id']==$sds['id']) selected @endif>{{ $sds['state_name']}}</option>
                            @endforeach
                            @endif
                        </select>
                        <label class="select-label">State</label>
                    </div>
                </div>
                <div class="col-lg-4" style="display: none;" id="statesel_duv">
                    <div class="form-group form-outline mb-4">
                        <label for="input" class="float-label">State</label>
                        <i class="material-symbols-outlined">map</i>
                        <input type="text" name="state" class="form-control" id="state" @if(!empty($addressdata)) value="{{$addressdata['billing_state_other']}}" @endif>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-group form-outline mb-4">
                        <label for="input" class="float-label">ZIP</label>
                        <i class="material-symbols-outlined">home_pin</i>
                        <input type="text" name="zip" class="form-control" id="zip" @if(!empty($addressdata)) value="{{trim($addressdata['billing_zip'])}}" @endif>
                    </div>
                </div>
                <div class="btn_alignbox justify-content-end mt-3">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-primary">Cancel</button>
                    <button type="button" onclick="updateAddress('{{$addressdata['user_billing_uuid']}}')" id="submitaddress" class="btn btn-primary invite-btn">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
@php

$corefunctions = new \App\customclasses\Corefunctions;
@endphp
<script>
    $(document).ready(function() {
        // stateUS(selectElement);
        var selectedValue = $('#country_id1').val();
        var shortCode = $('#country_id1 option:selected').data('shortcode');
        console.log("selected Element " + selectedValue);

        toggleStateBox();
        initializeAutocomplete(selectedValue);


        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');

            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }

        // Initialize all inputs on page load
        $('input, textarea').each(function() {
            toggleLabel(this);
        });

        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function() {
            toggleLabel(this);
        });

        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function(e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });

        $("#editaddressform").validate({

            ignore: ":hidden, [style*='display: none']",
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
                country_id1: 'required',
                state: {
                    required: {
                        depends: function(element) {
                            return ($("#country_id1").val() != 185);
                        },
                    },
                    noWhitespace: true,
                },
                state_id: {
                    required: {
                        depends: function(element) {
                            return ($("#country_id1").val() == 185);
                        }
                    },
                    noWhitespace: true,
                },
                zip: {
                    required: true,
                    noWhitespace: true,
                    zipmaxlength: {
                        depends: function(element) {
                            return (($("#country_id1").val() != '236') && $("#country").val() != '235');
                        }
                    },
                    regex: {
                        depends: function(element) {
                            return ($("#country_id1").val() == '236');
                        }
                    },
                    zipRegex: {
                        depends: function(element) {
                            return ($("#country_id1").val() == '235');
                        }
                    },
                },
            },

            messages: {
                company_name: {
                    required: "Please enter company name.",
                    noWhitespace: "Please enter valid company name.",
                },
                country_id1: "Please select country.",
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
                    required: "Please select state1.",
                    noWhitespace: "Please enter valid state1.",
                },
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

    function toggleStateBox() {

        var selectedValue = $('#country_id1').val();

        if (selectedValue == 185) {

            // Other countries
            $('#statelist_div').show();
            $("#state").val('');
            $('#statesel_duv').hide();

        } else {

            // India selected
            $('#statelist_div').hide();
            $("#state_id").val('');
            $('#statesel_duv').show();
        }
    }


    function initializeIntlTelInput() {
        var telInput = $("#phoneedit"),
            countryCodeInput = $("#countryCodeedit"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");

        // initialise plugin
        telInput.intlTelInput({
            autoPlaceholder: "polite",
            initialCountry: "us",
            formatOnDisplay: false, // Enable auto-formatting on display
            autoHideDialCode: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",
            onlyCountries: ['us', 'in'],
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
            updateAutocompleteCountry(countryData.iso2)
            if (countryData.dialCode == 1) {
                $("#statelist_div").show();
                $("#statesel_duv").hide();
            } else {
                $("#statelist_div").hide();
                $("#statesel_duv").show();

            }
            console.log(countryData);


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
    }

    function stateUS(selectElement = null) {


        const selectedValue = selectElement.value;
        const country = selectedValue == 185 ? 'us' : 'in';
        console.log("Selected country ID:", country);

        if (selectedValue == 185) {
            $("#statelist_div").show();
            $("#statesel_duv").hide();
            $("#state").val('');

        } else {
            $("#statelist_div").hide();
            $("#statesel_duv").show();
            $("#state_id").val('');
        }
        updateAutocompleteCountry(country)
    }

    function updateAddress(key) {
        const countryId = $("#country_id1").val();
        console.log(countryId);

        if ($("#editaddressform").valid()) {
            $.ajax({
                type: "POST",
                url: "{{ URL::to('updateaddress')}}",
                data: {
                    'key': key,
                    'formdata': $('#editaddressform').serialize(),
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == 1) {
                        $("#addsubscriptionaddress").modal('hide');
                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            var usertype = "{{session()->get('user.userType')}}";
                            if (usertype == 'patient') {
                                changeTab('cards-billing');
                            } else {
                                tabContent('billings');
                            }

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
</script>