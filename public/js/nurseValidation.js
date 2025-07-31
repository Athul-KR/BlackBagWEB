//Validations
$(document).ready(function () {
    var form = $("#nurse-create-form");
    var url = $("#email").data("url");
    var phoneUrl = $("#phone").data("url");
    var uuid = $("#email").data("uuid");
    console.log(phoneUrl);

    $(form).validate({
        rules: {
            name: "required",
            email: {
                    required: true,
                    email: true,
                    // customemail: true,
                    remote: {
                        url: "{{ url('/validateemail') }}",
                        data: {
                            'type' : 'other',
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                },
             phone: {
                    required: true,
                    maxlength: 13,
                    number: true,
                    remote: {
                        url: "{{ url('/validatephone') }}",
                        data: {
                            'type' : 'other',
                            'countryCode' : function () {
              return $("#countryCode").val(); // Get the updated value
            },
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                },
            department: "required",
            qualification: "required",
            specialties: "required",
        },
        messages: {
            name: "Please enter name.",
            email: {
                required: "Please enter email address.",
                email: "Please enter a valid email address.",
                regex: "Please enter a valid email address.",
                remote: "Email already exist.",
            },
            phone: {
                        required: 'Please enter phone number.',
                        minlength: 'Please enter a valid number.',
                        maxlength: 'Please enter a valid number.',
                        number: 'Please enter a valid number.',
                        remote: "Phone number already exists in the system." 
                    },
            department: "Please enter department.",
            qualification: "Please enter qualification.",
            specialties: "Please enter specialty.",
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            // Disable the submit button to prevent multiple clicks
            var submitButton = $(form).find("#btndisable");
            submitButton.prop("disabled", true);
            submitButton.text("Submitting..."); // Optionally change button text

            // Submit the form
            form.submit(); // Use native form submission
        },
    });

    // Custom email regex validation method
    $.validator.addMethod(
        "regex",
        function (value, element) {
            // Adjust the regex as needed for your requirements
            var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailRegex.test(value);
        },
        "Please enter a valid email format."
    );

    $(document).on("click", ".close-modal", function () {
        $("#nurse-create-form").empty();
    });
});
