<form method="post" id="change_phone_form" autocomplete="off">
    @csrf
    <div class="row">
        <div class="col-12">
            <p id="credslabel" class="top-error"></p>
            <div class="form-group form-outline phoneregcls mb-3">
                <div class="country_code phone">

                    <input type="hidden" id="countryCodeEdit" name="countrycode"
                        value="{{$countryCode->country_code ?? '+1' }}">

                    <input type="hidden" id="countryCodeShortEdit" name="countryCodeShort"
                        value="{{$countryCode->short_code ?? 'us' }}">
                </div>
                <!-- <label for="phone" class="float-label ">Phone Number</label> -->
                <i class="material-symbols-outlined me-2">call</i>
                <input type="tel" name="phonenumber" placeholder="Phone Number" class="form-control" id="phoneeditinput"
                    value="{{  $countryCode->country_code . $patient['phone_number'] ?? $patient['phone_number'] }}">
            </div>


        </div>
        <div class="col-12">
            <div class="btn_alignbox justify-content-end">
                <a onclick="changePhoneNumber()" class="btn btn-primary">Send
                    OTP
                </a>
            </div>
        </div>
    </div>
</form>

@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp



<script>
      let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
    $(document).ready(function () {
        var telInput = $("#phoneeditinput"),
            countryCodeInput = $("#countryCodeEdit"),
            countryCodeShort = $("#countryCodeShortEdit"),
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



        //Validation
        $("#change_phone_form").validate({
            rules: {
                phonenumber: {
                    required: true,  // Ensure the phone field is not empty
                    digits: true,  // Ensure the phone field is not empty
                    minlength: 10,
                    maxlength: 13,

                }
            },
            messages: {
                phonenumber: {
                    required: "Please enter phone number",
                    digits: "Please enter a valid number",
                    minlength: 'Please enter a valid number',
                    maxlength: 'Please enter a valid number',
                }
            },

        });


    });



//    //change phone number
//    function changePhoneNumber() {
//
//        if ($("#change_phone_form").valid()) {
//
//
//            var url = "{{url('frontend/changePhoneNumber')}}";
//            var phone = $('#phoneeditinput').val();
//            var countryCode = $('#countryCodeEdit').val();
//            $.ajax({
//                url: url,
//                type: "post",
//                data: {
//                    'formdata': $("#change_phone_form").serialize(),
//                    '_token': $('input[name=_token]').val()
//                },
//                success: function (data) {
//                    console.log(data);
//
//                    if (data.success == 1) {
//                        // $("#settingsModal").hide();
//                        $("#settingsModal").modal('hide');
//                        $("#otpform_modal").modal('show');
//                        // $("#otpform").show();
//                        $('#otp1').focus();
//                        $("#otpkey").val(data.key);
//                        $("#phonenumbers").val(data.phonenumber);
//                        $("#countrycode").val(data.countrycode);
//                        $("#countryCodeShorts").val(data.countryCodeShort);
//                        $("#countryCodeShorts1").val(data.countryCodeShort);
//                        $("#countryId").val(data.countryId);
//                        $('#otpPhone').text(data.countrycode + ' ' + data.phonenumber);
//                        $("#type").val(data.type);
//
//                        swal(
//                            "Success!",
//                            "An OTP has been sent to your registered phone number.(" + data.otp + ")",
//                            "success",
//                        ).then(() => {
//                            // $("#otpform").addClass('show');
//                            console.log(data);
//
//                        });
//
//
//                        resendCountdown();
//                    } else {
//                        showOtpError(data.errormsg, 'login');
//                        swal(
//                            "Error!",
//                            data.errormsg,
//                            "error",
//                        ).then(() => {
//                            console.log(data);
//
//
//                        });
//                    }
//                }
//            });
//        }
//
//
//
//    }
//
//
//    //resend otp
//    function resendOtp() {
//
//        $.ajax({
//            url: '{{ url("frontend/changePhoneNumber") }}',
//            type: "post",
//            data: {
//                'formdata': $("#verifyotpform").serialize(),
//                '_token': $('input[name=_token]').val()
//            },
//            success: function (data) {
//                if (data.success == 1) {
//                    $("#settingsModal").hide();
//                    $("#otpform_modal").modal('show');
//                    // $("#otpform").show();
//                    $("#otpkey").val(data.key);
//                    $("#phonenumbers").val(data.phonenumber);
//                    $("#countrycode").val(data.countrycode);
//                    swal(
//                        "Success!",
//                        "An OTP has been sent to your registered phone number.(" + data.otp + ")",
//                        "success",
//                    ).then(() => {
//                        console.log(data);
//
//                    });
//                    resendCountdown()
//                } else {
//
//                }
//            }
//        });
//
//    }
//
//    //Verify Otp
//    function verifyOtp() {
//        var otpValue = '';
//        // Gather OTP value from individual fields
//        $('.otp-input-field').each(function () {
//            otpValue += $(this).val();
//        });
//
//        $('#otp_value').val(otpValue);
//
//        // If the form passes validation
//        if ($("#verifyotpform").valid()) {
//            $.ajax({
//                url: '{{ url("frontend/verifyotp?tokn=update") }}',
//                type: "post",
//                data: {
//                    'formdata': $("#verifyotpform").serialize(),
//                    '_token': $('input[name=_token]').val()
//                },
//                success: function (data) {
//                    if (data.token == 'update') {
//                        $("#otpform_modal").modal('hide');
//                        // $("#otpform").hide();
//                        swal(
//                            "Success!",
//                            data.message,
//                            "success",
//                        ).then(() => {
//                            window.location.href = "{{url('/')}}";
//                            console.log(data);
//
//                        });
//                    } else {
//                        $('.otp-input-field').val('');
//                        // Optionally reset the hidden 'otp_value' field as well
//                        $('#otp_value').val('');
//                        // When OTP verification fails, show an error
//                        showOtpError('Invalid OTP. Please try again.'); // Call the error display function
//                    }
//                }
//            });
//        } else {
//            // If form validation fails
//            if ($('.error:visible').length > 0) {
//                setTimeout(function () {
//                    $('html, body').animate({
//                        scrollTop: ($('.error:visible').first().offset().top - 100)
//                    }, 500);
//                }, 500);
//            }
//        }
//    }




    // Function to display OTP error message dynamically
    function showOtpError(message, type = '') {
        var otpField, errorElement;

        if (type == 'login') {
            otpField = $('#credslabel'); // The field where the OTP is entered
            errorElement = $('<label class="error"></label>').text(message);
            otpField.html(errorElement);
        } else {
            otpField = $('.otp-input'); // The field where the OTP is entered
            errorElement = $('<label class="error"></label>').text(message); // Create the error label
            otpField.after(errorElement); // Insert error message after the OTP input field
        }



        // Scroll to the error message if needed
        $('html, body').animate({
            scrollTop: (otpField.offset().top - 100)
        }, 500);

        // Fade out the error message after 10 seconds
        setTimeout(function () {
            errorElement.fadeOut(500, function () {
                $(this).remove(); // Remove the element from the DOM after fading out
            });
        }, 3000); // 10000 milliseconds = 10 seconds

    }


</script>