@extends('frontend.master_website')
@section('title', 'Landing Page')
@section('content')



<section class="banner-container home-bg mb-5 lp-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="content_box">
                    <h1 class="mt-3">Be Among the First to Revolutionize Your Practice</h1>
                    <p class="pe-lg-5">Join the BlackBag Early Adopter Program</p>
                </div>
            </div>
            <div class="col-lg-6 p-0">
                <div class="image-container">
                    <img src="{{ asset('frontend/images/lp-banner.webp')}}" class="img-fluid" alt="Banner Doctor">
                </div>
            </div>
        </div>
    </div>
</section>



<section class="mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="feature-card">
                    <div class="d-flex align-items-center mb-3">
                        <div>
                            <div class="feature-subtitle"><h5>Experience the future of concierge medicine with BlackBag, the AI-powered platform designed to streamline your practice management. As an early adopter, you'll gain exclusive access to:</h5>
                            </div>
                        </div>
                    </div>
                    <div class="g-gra-border"></div>
                    <div class="row mt-4">
                        <div class="col-12 ">
                            <p class="align-items-top d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Automated Note-Taking: Real-time transcriptions and smart summaries to save you time.</p>
                            <p class="align-items-top d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Effortless Scheduling: 24/7 appointment management to reduce wait times.</p>
                            <p class="align-items-top d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Secure Telehealth Integration: Provide virtual consultations with confidence.</p>
                            <p class="align-items-top d-flex"><span class="material-symbols-outlined check-icon">check_circle</span>Personalized Patient Engagement: Enhance patient satisfaction with tailored communication tools.</p>
                        </div>
                        <!--<div class="col-12 pt-3">
                                <div class="price-box">
                                <div class="">
                                    <h5 class="fw-bold text-center">Unlock the power of AI-driven practice management - before everyone else.</h5>
                                </div>
                                </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-12 mx-auto mb-4">
                <div class="card contact-card mt-lg-0 mt-3 pb-1">
                    <div class="card-body">
                        <div class="mb-2  mx-auto">
                            <h4 class="pb-2">Get Started Now</h4>
                        </div>
                        <form class="cus-contact" id="contact_form" method="post" action="" autocomplete="off">
                        @csrf
                            <div id="timeoutmsg" class="row justify-content-center mb30 msgdiv" style="display: none;">
                                <div class="col-12 col-md-12 col-lg-12 p0-xs">
                                    <div class="alertmsg skew alert alert-success tc text-center"><i class="far fa-smile font40 mb10"></i><p>  <strong>Success!</strong> Your message has been sent successfully.</p></div>
                                    <div class="overlay"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6"> 
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">First Name</label>
                                        <i class="fa-solid fa-circle-user"></i>
                                        <input type="text" name="name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-6"> 
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">Last Name</label>
                                        <i class="fa-solid fa-circle-user"></i>
                                        <input type="text" name="last_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">Clinic Name</label>
                                         <i class="fa-solid fa-hospital"></i>
                                        <input type="text" name="clinic_name" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div class="form-group form-outline mb-4">
                                        <label class="float-label">Email</label>
                                        <i class="fa-solid fa-envelope"></i>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div class="form-group form-outline phoneregcls mb-4">
                                        <div class="country_code phone">
                                            <input type="hidden" id="countryCode" name="countrycode" value='+1'>
                                        </div>
                                        <i class="material-symbols-outlined me-2">call</i> 
                                        <input type="text" class="form-control phone-number" id="phone_number" name="phone_number" placeholder="Phone Number">
                                    </div>
                                </div>
   
                                <div class="btn_box justify-content-sm-end justify-content-center">
                                    <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">
                                    <button class="btn btn-primary cus-btn" id="btndisable" type="button" onclick="submitEnquiry();">Join BlackBag Now</button>
                                </div>
                                <input type="hidden" name="formtype" class="form-control" value="landingpage">
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


<script>
        let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
function submitEnquiry() {
      
      
    if ($("#contact_form").valid()) {
        $("#btndisable").prop('disabled', true);
        $("#btndisable").text("Submitting...");
       // Optionally change button text
           $.ajax({
            type: "POST",
            url: '{{ url("/contact-us-store") }}',
            data:{
                'formdata' :  $('#contact_form').serialize(),
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType : 'json',
            success: function(data) {
                $('#contact_form')[0].reset();
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
                $('input, textarea').each(function () {
                            toggleLabel(this);
                        });
                //$('.error:visible').first().focus();
            }, 500);
                  setTimeout(function(){ jQuery("#timeoutmsg").hide();  }, 7000);
                
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


        var form = $('#contact_form');
        form.validate({
            rules: {
                name: {
                    required: true,
                    normalizer: function(value) {
                        return $.trim(value); // Trim whitespace before validation
                    }
                },last_name: {
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
                name: "Please enter a valid first name",
                last_name: "Please enter a valid last name",
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



@stop
