//Validations
// $(document).ready(function () {
var form = $("#appointment_create_form");

$(form).validate({
    ignore: [],
    rules: {
        patient: "required",
        appointment_date: {
            required: true,
            // futureDateTime: true,
        },
        appointment_time: "required",
        appointment_type_id: "required",
        appointment_fee: {
            required: true,
            digits: true,
        },
        doctor: "required",
        nurse: "required",
        note: {
            // required: true,
            maxlength: 700,
        },
    },
    messages: {
        patient: "Please select a patient.",
        appointment_date: {
            required: "Please select appointment date.",
        },
        appointment_time: "Please select appointment time.",
        appointment_type_id: "Please select an appointment type.",
        appointment_fee: {
            required: "Please enter appointment fees.",
            digits: "Please enter a valid number.",
        },
        doctor: "Please select a clinician.",
        nurse: "Please select a nurse.",
        note: {
            maxlength: "Minimum characters allowed is 700.",
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
        var submitButton = $(form).find("#appt_btn");
        submitButton.prop("disabled", true);
        submitButton.text("Submitting..."); // Optionally change button text

        // Submit the form
        if (form.valid()) {
            // alert("hh");
            form.submit(); // Use native form submission
        }
    },
    success: function (label) {
        // Remove the validation message when validation passes
        label.remove();
    },
});

// Custom method to check for future dates

$.validator.addMethod(
    "futureDateTime",
    function (value, element) {
        const appointmentDate = $("#appt-date").val();

        const appointmentTime = $("#appt-time").val();

        const selectedDateTime = new Date(
            `${appointmentDate}T${appointmentTime}`
        );
        const now = new Date();
        now.setSeconds(0, 0); // Set seconds and milliseconds to 0 for comparison

        return this.optional(element) || selectedDateTime > now;
    },
    "Please select a future date and time."
);

$(document).on("click", ".close-modal", function () {
    $("#nurse-create-form").empty();
});
// });
