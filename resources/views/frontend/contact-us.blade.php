@extends('frontend.master_website')
@section('title', 'Contact Us')
@section('content')
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo env('RECAPTCHA_SITEKEY') ?>"></script>
<script>
    
    function executeRecaptcha() {
    grecaptcha.execute('<?php echo env('RECAPTCHA_SITEKEY') ?>', {action:'validate_captcha'})
                      .then(function(token) {
                // add token value to form
                document.getElementById('g-recaptcha-response').value = token;
            });
}

    
    
       $(document).ready(function () {
	    grecaptcha.ready(function() {
        // do request for recaptcha token
        // response is promise with passed token
            executeRecaptcha();
        });
        });
    
</script>

@if (session()->has('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Success!',
            text: "{{ session()->get('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    });
</script>
@endif

<style>


.floatselect-group{
    border: 1px solid var(--form-border-color) !important;
    padding: 6px 0px 6px 20px;
    border-radius: var(--border-radius);
    position: relative;
}

.control-label {
    font-size: 16px;
    font-weight: 400;
    opacity: 1;
    pointer-events: none;
    position: absolute;
    transform: translate3d(0, 22px, 0) scale(1);
    /* transform-origin: left top; */
    transition: 240ms;
    line-height: 29px;
    top: -14px;
    left: 5px;
    font-size: 0.75rem;
    padding: 0px 4px;
    background: var(--white);
}
.floatselect-group.focused .control-label{color: var(--light);}

.form-innerselect{
    border: none !important
}


.floatselect-group.focused .control-label {
    opacity: 1;
    transform: scale(0.75);

}

.form-innerselect::-webkit-input-placeholder {
    color: transparent;
    transition: 240ms;
}

.form-innerselect:focus::-webkit-input-placeholder {
    transition: none;
}


</style>

<section class="banner-container contact-bg">

    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-8 mx-auto">
                <div class="content_box text-center">
                    <h1>Contact Us</h1>
                    <p>Let’s us start something great together. Get in touch with our support team today.</p>
                </div>
            </div>
        </div>
    </div>

</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-12">
                <div class="content_box text-lg-start text-center mb-lg-0 mb-4">
                    <h3>Get in touch</h3>
                    <!-- <div class="my-4">
                        <h5 class="fwt-bold">Phone Number</h5>
                        <p class="mb-1">+1 (423) 565-0132</p>
                    </div> -->
                    <div class="my-4">
                        <h5 class="fwt-bold">Email</h5>
                        <p class="primary mb-1">support@myblackbag.com</p>
                    </div>
                    <!-- <div class="mt-4">
                        <h5 class="fwt-bold">Address</h5>
                        <p class="mb-0">1864 Green Gate Lane</br> Baltimore, MD 21202</p>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-8 col-12">
                <div class="card contact-card">
                    <div class="card-body" id="contactForm">
                        <form class="cus-contact m-0" id="contact_form_new" method="post" action="" autocomplete="off">
                            @csrf
                            <div id="timeoutmsg" class="row justify-content-center mb30 msgdiv" style="display: none;">
                                <div class="col-12 col-md-12 col-lg-12 p0-xs">
                                    <div class="alertmsg skew alert alert-success tc text-center"><i class="far fa-smile font40 mb10"></i><p>  <strong>Success!</strong> Your message has been sent successfully.</p></div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                            <div id="errormsg" class="row justify-content-center mb30 msgdiv" style="display: none;">
                                <div class="col-12 col-md-10 col-lg-7 p0-xs">
                                    <div class="alertmsg skew alert alert-danger tc"><i class="far fa-smile font40 mb10"></i><p id="errormsgcls">  <strong>Error!</strong> A problem has been occurred while submitting your data.</p></div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                            <div class="form-group form-outline mb-4 ">
                                <label class="float-label">Name</label>
                                <i class="fa-solid fa-circle-user"></i>
                                <input type="text" name="name" class="form-control">
                            </div>
                            <div class="form-group form-outline mb-4 ">
                                <label class="float-label">Email</label>
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" name="email" class="form-control">
                            </div>
                            <div class="form-group form-outline phoneregcls mb-4">
                                <!-- <label for="input" class="float-label">Phone Number</label> -->
                                <div class="country_code phone">
                                    <input type="hidden" id="countryCode" name="countrycode" value='+1'>
                                </div>
                                <i class="material-symbols-outlined me-2">call</i> 
                                <input type="text" class="form-control phone-number" id="phone_number" name="phone_number" placeholder="Phone Number">
                            </div>
                            <div class="form-group form-outline form-textarea mb-4">
                                <label class="float-label">Message</label>
                                <i class="fa-solid fa-message"></i>
                                <textarea name="message" class="form-control" rows="4" cols="4"></textarea>
                            </div>
                            <input type="hidden" name="formtype" class="form-control" value="contactus">
                            <div class="btn_box justify-content-sm-end justify-content-center">
                                <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                <button class="btn btn-primary cus-btn" id="btndisable" type="button" onclick="submitEnquiry();">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp


@if (session()->has('error'))
<!-- Error Modal -->
<div class="modal login-modal " id="successModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <img src="{{ asset('frontend/images/sucess.png')}}" class="img-fluid" alt="Success">
                <div class="text-center">
                    <h5 class="fw-bold">{{ session()->get('error') }}</h5>

                </div>

            </div>
        </div>
    </div>
</div>
@endif

<script>
        let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
      function submitEnquiry() {
          
          executeRecaptcha();
      
    if ($("#contact_form_new").valid()) {
        $("#btndisable").prop('disabled', true);
        $("#btndisable").text("Submitting...");
       // Optionally change button text
           $.ajax({
            type: "POST",
            url: '{{ url("/contact-us-store") }}',
            data:{
                'formdata' :  $('#contact_form_new').serialize(),
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'json',
            success: function(data) {
                $('#contact_form_new')[0].reset();
              if(data.success == 1){
                  $('form input, form textarea').each(function(){
                      $(this).siblings().not('error').not('.msgdiv').fadeIn('slow');
                  });
                  $("#btndisable").text("Submit");
                  $('#timeoutmsg').show();
                   $(".cus-btn").removeAttr("disabled");
                  setTimeout(function() {
                $('html, body').animate({
                    scrollTop: ($('#timeoutmsg').offset().top - 100)
                }, 500);
                //$('.error:visible').first().focus();
            }, 500);
                  setTimeout(function(){ jQuery("#timeoutmsg").hide();  }, 7000);
                  executeRecaptcha();
                  window.location.reload();
              }else{
                  $(".cus-btn").removeAttr("disabled");
                  $('#errormsg').html(data.error);
              }
            },
            error: function(xhr) {
               
                handleError(xhr);
            }
        });
            
    } else {
        if($('.error:visible').length>0){
            setTimeout(function() {
                // $('html, body').animate({
                //     scrollTop: ($('.error:visible').first().offset().top - 100)
                // }, 500);
                //$('.error:visible').first().focus();
            }, 500);
       } 
    }
      }
  $(document).ready(function() {
      
    setTimeout(function(){ jQuery("#timeoutmsg").hide();  }, 7000);
    var telInput = $("#phone_number"),
                countryCodeInput = $("#countryCode"),
                errorMsg = $("#error-msg"),
                validMsg = $("#valid-msg");

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
                countryCodeInput.val(countryData.dialCode);
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

console.log($("#contact_form_new").length); 
        var form = $('#contact_form_new');
        $('#contact_form_new').validate({
            rules: {
                name: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value); // Trim whitespace before validation
                    }
                },
                email: {
                    required: true,
                    email: true,
                    regex: true,
                },
                phone_number: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 13,
                },
                hiddenRecaptcha: {
                    required: function() {
                        return grecaptcha.getResponse() === '';
                    }
                },
                message: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value); // Trim whitespace before validation
                    }
                },
            },
            messages: {
                name: "Please enter a valid name",
                email: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address",
                    regex: "Please enter a valid email address",
                },
                phone_number: {
                    required: "Please enter phone number",
                    digits: "Please enter a valid phone number",
                    minlength: "Please enter a valid phone number",
                    maxlength: "Please enter a valid phone number",
                },
                message: "Please enter a message",
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
            submitHandler: function(form) { 
                var submitButton = $("#btndisable");
                submitButton.prop("disabled", true);
                submitButton.text("Submitting...");
                form.submit();
            },
            invalidHandler: function(event, validator) {
                event.preventDefault();
            }
        });
        // Custom email regex validation method
        $.validator.addMethod(
            "regex",
            function(value, element) {
                // Adjust the regex as needed for your requirements
                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                return emailRegex.test(value);
            },
            "Please enter a valid email format."
        );


    });


</script>

@endsection