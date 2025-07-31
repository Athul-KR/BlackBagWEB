@extends('frontend.master')
@section('title', 'My Appointments')
@section('content')
<?php
    $corefunctions = new \App\customclasses\Corefunctions;
?>
<section class="details_wrapper">
    <div class="container">
        @include('appointment.appenddetails_patient')
    </div>
</section>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="https://js.stripe.com/v3/"></script>
<script>
      $(document).ready(function() {
        getAppointmentMedicalHistory('previousappointments_patient');
    });
    function toggleVideoCallDetails(id) {
        var detailsDiv = $("#details_" + id);

        // Construct dynamic ID
        var dynamicId = "arrow_btn_rot" + id;

        // Remove 'active' class and reset IDs from all buttons
        $(".arrow_btn").removeClass("active");

        if (detailsDiv.is(":visible")) {
            detailsDiv.slideUp(300);
        } else {
            // Add 'active' class to the current button
            $("#" + dynamicId).addClass("active");
            $(".appointment-details").slideUp(300);
            detailsDiv.slideDown(300);
            if (!detailsDiv.data('loaded')) {
                $.ajax({
                    url: '{{ url("/appointments/fetchvideocalldetails") }}',
                    type: "post",
                    data: {
                        'id': id,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            $("#appendvideocalldetails_" + id).html(data.view);
                            detailsDiv.data('loaded', true);
                        }
                    },
                    error: function(xhr) {
               
                        handleError(xhr);
                    }
                });
            }
        }
    }

    function getAppointmentMedicalHistory(type,page=1) {
        var patientId = '{{$appointment['patient_id']}}';
        var key = '{{$appointment['appointment_uuid']}}';
        var viewType = 'appoinntment';
        showPreloader("pills-"+type);
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/medicalhistory") }}',
            data: {
                "type": type,
                "key" : key,
                "view" :viewType,
                "page":page,
                'patientId': patientId,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    $("#previousappopatient").html(response.view); 
                    
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }
    


</script>
@endsection()