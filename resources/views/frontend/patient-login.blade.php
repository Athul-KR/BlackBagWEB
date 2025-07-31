<p id="credslabel" class="top-error"></p>
<h4 class="fw-bold">Welcome to BlackBlag</h4>
<small class="fwt-light">Please enter you details to sign in.</small>


<form method="POST" id="loginformuser" autocomplete="off">
    @csrf
    <!-- <a href="" class="btn btn-outline-gray d-flex align-items-center justify-content-center w-100 mb-3"><img src="{{ asset('frontend/images/google_icon.png')}}" class="img-fluid me-2" width="25"><small>Continue with Google</small></a>
                        <small class="gray">OR</small> -->

    <div class="col-md-12">
        <div class="form-group form-outline phoneregcls justify-content-start mt-3 mb-4">
            <div class="country_code phone">
                <input type="hidden" id="countryCode" name="countrycode" value='+1'>
                <input type="hidden" id="countryCodeShort" name="countryCodeShort" value='us'>
            </div>
            <i class="material-symbols-outlined me-2">call</i>
            <input type="tel" name="phonenumber" class="form-control phone-number" id="phonenumber"
                placeholder="Enter phone number" value="">

        </div>
    </div>

    <input type="hidden" name="invitationkey" id="invitationkey" class="form-control"
        value="@if(isset($_GET['invitationkey']) && $_GET['invitationkey'] != ''){{$_GET['invitationkey']}}@endif">
    <input type="hidden" name="type" id="type" class="form-control" value="patient">


    <div class="btn_alignbox flex-column mt-3">
        <a class="btn btn-primary w-100" onclick="submitLogin('patient')">Send
            OTP</a>
        <div class="btn_alignbox flex-column mt-3">
            <p class="m-0">Don’t have an account?</p>
            <a class="primary fwt-bold text-decoration-underline" onclick="createPatient()">
                Sign Up
            </a>
        </div>
    </div>

</form>
@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp
<script>



$(document).ready(function () {

    $(document).on('keydown', '#phonenumber', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault(); // Prevent form submission
            return false;
        }
    });



    var telInput = $("#phonenumber"),
        countryCodeInput = $("#countryCode"),
        countryCodeShort = $("#countryCodeShort"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");
        let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
    // initialise plugin
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
        var countryShortCode = countryData.iso2;
        // countryCodeInput.val("+" + countryData.dialCode);
        countryCodeInput.val(countryData.dialCode);
        countryCodeShort.val(countryShortCode);
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
});









     //validation
     function validateUser() {
            $("#loginformuser").validate({
                rules: {
                    phonenumber: {
                        required: true,
                        number: true,
                        maxlength: 13,
                        minlength: 10,
                        //cleanPhoneNumber: true,
                    }
                },
                messages: {
                    phonenumber: {
                        required: 'Please enter phone number.',
                        number: 'Please enter a valid number.',
                        minlength: 'Please enter a valid number.',
                        maxlength: 'Please enter a valid number.',
                        cleanPhoneNumber: 'Please enter a valid number.'
                    }
                },
                errorPlacement: function (error, element) {

                    error.insertAfter(element);

                },
                success: function (label) {
                    // If the field is valid, remove the error label
                    label.remove();
                }
            });
        }
        $.validator.addMethod("cleanPhoneNumber", function (value, element) {
            // Remove non-numeric characters (dots, dashes, spaces, etc.)
            var cleaned = value.replace(/[^0-9]/g, '');
            // Check if the cleaned value is exactly 10 digits
            return this.optional(element) || (cleaned.length === 10 && /^\d+$/.test(cleaned));
        }, "Please enter a valid phone number.");


</script>