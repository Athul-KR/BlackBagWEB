@extends('frontend.master')
@section('content')
<section class="login-container mb-0">
    <div class="container-fluid">
        <div class="row p-xl-5 p-md-4 py-md-0 py-5">
            <div class="col-3 col-lg-4">
                <div class="sideTabWrapper">
                    <div class="image-container mb-5">
                        <img src="{{ asset('frontend/images/logo.png')}}" class="logo-main h-auto" alt="Logo">
                    </div>
                    <ul class="nav nav-tabs intake-wrapper-tab" id="customTabs">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active highlighted" id="healthmetrics-tab" type="button" disabled>
                                <div class="tab-icon">
                                    <span class="material-symbols-outlined"> monitor_heart</span>
                                </div>
                                <div class="intaketab-text text-start">
                                    <h5 class="primary fwt-bold">Health Metrics</h5>
                                    <small>Share your key health metrics for better personalized care.</small>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="medication-tab" type="button" disabled>
                                <div class="tab-icon">
                                    <span class="material-symbols-outlined">pill</span>
                                </div>
                                <div class="intaketab-text text-start">
                                    <h5 class="primary fwt-bold">Medication Details</h5>
                                    <small>Provide details on your medications, vaccines, medical conditions and allergies.</small>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="medicalhistory-tab" type="button" disabled>
                                <div class="tab-icon">
                                    <span class="material-symbols-outlined">clinical_notes</span>
                                </div>
                                <div class="intaketab-text text-start">
                                    <h5 class="primary fwt-bold">Medical History</h5>
                                    <small>Share information on your families medical history.</small>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="success-tab" type="button" disabled>
                                <div class="tab-icon">
                                    <span class="material-symbols-outlined">award_star</span>
                                </div>
                                <div class="intaketab-text text-start">
                                    <h5 class="primary fwt-bold">Welcome to BlackBag</h5>
                                    <small>Your account is now up and running.</small>
                                </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-9 col-lg-8">
                <div class="tab-content h-100" id="customTabsContent">

                    @include('frontend.intake.healthmetrics')


                </div>
            </div>
        </div>
    </div>


</section>


<script>
    $(document).ready(function() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            getNextIntakeForm(hash);
        } else {
            getNextIntakeForm('healthmetrics');
        }

        if (document.getElementById('other_medications_yes').checked) {
            document.getElementById('medication_reason_section').style.display = 'block';
        }
    });


    function validateForms() {
        $("#intakeform").validate({
            rules: {
                "blood_pressure[systolic]": {
                    number: true,
                    min: 1,
                },
                "blood_pressure[diastolic]": {
                    number: true,
                    min: 1,
                },
                "blood_pressure[pulse]": {
                    number: true,
                    min: 1,
                },
                "glucose[glucose]": {
                    number: true,
                    min: 1,
                },
                "glucose[hba1c]": {
                    number: true,
                    min: 1,
                },
                "cholesterol[cholesterol]": {
                    number: true,
                    min: 1,
                },
                "cholesterol[hdl]": {
                    number: true,
                    min: 1,
                },
                "cholesterol[ldl]": {
                    number: true,
                    min: 1,
                },
                "cholesterol[triglycerides]": {
                    number: true,
                    min: 1,
                },
                "weight[weight]": {
                    number: true,
                    min: 1,
                },
                "height[height]": {
                    number: true,
                    min: 1,
                },
                "saturation[saturation]": {
                    number: true,
                    max: 100,
                    min: 50,
                },
                "body_temperature[temperature]": {
                    number: true,
                    min: 1
                },
            },
            messages: {
                "blood_pressure[systolic]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "blood_pressure[diastolic]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "blood_pressure[pulse]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "cholesterol[cholesterol]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "cholesterol[hdl]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "cholesterol[ldl]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "cholesterol[triglycerides]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "glucose[glucose]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "glucose[hba1c]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "weight[weight]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "height[height]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0',
                },
                "saturation[saturation]": {
                    number: 'Please enter a numeric value.',
                    max: "Please enter a valid value.",
                    min: "Please enter a valid value.",
                },
                "body_temperature[temperature]": {
                    number: 'Please enter a numeric value.',
                    min: 'Please enter a value greater than 0'
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-number")) {

                } else {
                    error.insertAfter(element);
                }
            },
            success: function(label) {
                label.remove();
            }
        });
    }
    $.validator.addMethod("noSpecialChars", function(value, element) {
        return this.optional(element) || /^[0-9]+(\.[0-9]+)?$/.test(value);
    }, "Special characters are not allowed");

    $.validator.addMethod("temperatureRange", function(value, element) {
        var unit = $('select[name="body_temperature[unit]"]').val();
        var temp = parseFloat(value);

        if (unit === 'c') {
            return temp >= 30 && temp <= 45;
        } else if (unit === 'f') {
            return temp >= 86 && temp <= 113;
        }
        return false;
    }, "Please enter a valid temperature (30°C - 45°C or 86°F - 113°F).");

    function validateHistoryForms() {
        var isValid = true;

        $(".relation-append .row").each(function() {
            var relationSelect = $(this).find(".relation-select").val();
            var conditionInput = $(this).find(".condition").val();
            var hasSelectedCondition = $(this).find(".selected-condition").length > 0;

            if (relationSelect && !hasSelectedCondition) {
                isValid = false;
                var errorLabel = $('<label class="error conditioncls">Please select condition.</label>');
                $(this).find(".condition").after(errorLabel);
            } else if (!relationSelect && hasSelectedCondition) {
                isValid = false;
                var errorLabel = $('<label class="error relationcls">Please select relation.</label>');
                $(this).find(".relation-select").after(errorLabel);
            } else {
                // Remove any previous validation messages
                $(this).find(".relation-select").find('.text-danger').remove();
                $(this).find(".condition").find('.text-danger').remove();
            }
        });
        if (!isValid) {
            event.preventDefault(); // Prevent form submission if validation fails
        }

        // Remove validation error on input change
        $(".relation-select, .condition").on("change keyup", function() {
            $(this).find(".relation-select").find('.text-danger').remove();
            $(this).find(".condition").find('.text-danger').remove();
        });
        return isValid;
    }

    function validateMedicationForms() {
        $("#medicationform").validate({
            // rules: {
            //     "has_medication": {
            //         required: true,
            //     },
            //     "bp_medication": {
            //         required: function() {
            //             return $("#bp_medication").is(":visible");
            //         }
            //     },
            //     "diabetes_medication": {
            //         required: function() {
            //             return $("#diabetes_medication").is(":visible");
            //         }
            //     },
            //     "cholesterol_medication": {
            //         required: function() {
            //             return $("#cholesterol_medication").is(":visible");
            //         }
            //     },
            //     "has_condition": {
            //         required: true,
            //     },
            //     "cardiovascular_condition": {
            //         required: function() {
            //             return $("#cardiovascular_condition").is(":visible");
            //         }
            //     },
            //     "respiratory_condition": {
            //         required: function() {
            //             return $("#respiratory_condition").is(":visible");
            //         }
            //     },
            //     "neurological_condition": {
            //         required: function() {
            //             return $("#neurological_condition").is(":visible");
            //         }
            //     },
            //     "has_immunization": {
            //         required: true,
            //     },
            //     "has_allergy": {
            //         required: true,
            //     },
            //     "is_allergic_to_food": {
            //         required: function() {
            //             return $("#is_allergic_to_food").is(":visible");
            //         }
            //     },
            //     "is_allergic_to_drug": {
            //         required: function() {
            //             return $("#is_allergic_to_drug").is(":visible");
            //         }
            //     },
            // },
            // messages: {
            //     "has_medication": {
            //         required: 'Please select atleast one option',
            //     },
            //     "bp_medication": {
            //         required: 'Please select atleast one option',
            //     },
            //     "diabetes_medication": {
            //         required: 'Please select atleast one option',
            //     },
            //     "cholesterol_medication": {
            //         required: 'Please select atleast one option',
            //     },
            //     "has_condition": {
            //         required: 'Please select atleast one option',
            //     },
            //     "cardiovascular_condition": {
            //         required: 'Please select atleast one option',
            //     },
            //     "respiratory_condition": {
            //         required: 'Please select atleast one option',
            //     },
            //     "neurological_condition": {
            //         required: 'Please select atleast one option',
            //     },
            //     "has_immunization": {
            //         required: 'Please select atleast one option',
            //     },
            //     "has_allergy": {
            //         required: 'Please select atleast one option',
            //     },
            //     "is_allergic_to_food": {
            //         required: 'Please select atleast one option',
            //     },
            //     "is_allergic_to_drug": {
            //         required: 'Please select atleast one option',
            //     },
            // },
            // errorPlacement: function(error, element) {
            //     error.insertAfter(element);
            // },
        });
    }

    function submitIntakeForm(formtype) {
        validateForms();
        if ($("#intakeform").valid()) {
            $("#healthmetricsbutton").prop("disabled", true);
            let formdata = $("#intakeform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getNextIntakeForm(formtype);
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

    function getNextIntakeForm(formtype, $isskip = '0') {
        // showPreloader('customTabsContent');
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        $.ajax({
            type: "POST",
            url: '{{ url("/intakeform/getforms") }}',
            data: {
                "formtype": formtype,
                "isskip": $isskip,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if (response.success == 1) {
                    $("#customTabsContent").html(response.view);
                    $('.nav-link').removeClass('highlighted');
                    $('.nav-link').removeClass('active');

                    var tabs = document.querySelectorAll('#customTabs .nav-link');

                    // Loop through the tabs and add the 'highlighted' class up to the 'medicalhistory-tab'
                    for (var i = 0; i < tabs.length; i++) {
                        // Check if the current tab's ID is 'medicalhistory-tab'
                        tabs[i].classList.add('highlighted');
                        tabs[i].classList.add('active');
                        if (tabs[i].id === formtype + '-tab') {
                            break; // Stop adding 'highlighted' class after this tab
                        }
                        // Add the 'highlighted' class to the current tab

                    }


                    //$("#"+formtype+"-tab").addClass('highlighted');
                    //$("#"+formtype+"-tab").addClass('active');
                    if (formtype == 'success') {
                        $('.nav-link').addClass('highlighted');
                        $('.nav-link').addClass('active');
                    }
                    window.location.hash = formtype;
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        })
    }
    const tabs = document.querySelectorAll('.nav-link');
    tabs.forEach((tab, index) => {
        tab.addEventListener('click', () => {
            tabs.forEach((t, i) => {
                if (i <= index) {
                    t.classList.add('highlighted');
                } else {
                    t.classList.remove('highlighted');
                }
            });
        });
    });

    document.querySelectorAll('.form-check-input[data-target]').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const target = document.querySelector(this.dataset.target);
            if (this.checked) {
                target.style.display = 'block';
            } else {
                target.style.display = 'none';
            }
        });
    });

    function submitMedicationForm(formtype) {
        validateMedicationForms();
        if ($("#medicationform").valid()) {
            $("#medicationbutton").prop("disabled", true);
            let formdata = $("#medicationform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/medication/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getNextIntakeForm(formtype);
                    } else {

                    }
                },
                error: function(xhr) {

                    handleError(xhr);
                },
            });
        }

    }

    function submitHistoryForm(formtype) {
        var isValid = validateHistoryForms();
        if (isValid) {
            $("#historybutton").prop("disabled", true);
            let formdata = $("#historyform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/medicationhistoryintake/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getNextIntakeForm(formtype);
                    } else {

                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            });
        }
    }
</script>
@endsection()