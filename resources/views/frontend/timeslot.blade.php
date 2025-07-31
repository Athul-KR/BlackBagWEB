<div class="text-center mb-4 px-xl-5 px-3">
    <h4 class="text-center fw-bold mb-1">Select Date & Time</h4>
    <p class="gray fw-light mb-0">Select appointment date and choose a time slot.</p>
</div>

<div class="border rounded-4 p-3 mb-4">
    <div class="row g-4 align-items-center"> 
        <div class="col-12 col-xl-5 border-r">
            <div class="user_inner user_inner_xl">
                <?php     
                    $corefunctions = new \App\customclasses\Corefunctions;
                    $image = $corefunctions -> resizeImageAWS($clinicUser['user_id'],$clinicUser['user']['profile_image'],$clinicUser['first_name'],180,180,'1');
                ?>
                <img src="{{$image}}" class="img-fluid">
                <div class="user_info">
                    <h5 class="primary fw-bold m-0">{{ $corefunctions -> showClinicanName($clinicUser,'1'); }}</h5>
                    <p class="m-0">{{$clinicUser['speciality']}}</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-7 ps-xl-4 ps-xl-5">
            <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                <div class="text-xl-start text-center image-body">
                    <img src="{{$clinicUser['clinic_logo']}}"  class="user-img" alt="">
                </div>
                <div class="user_details text-xl-start text-center pe-xl-4">
                    <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                        <h6 class="fw-bold primary text-wrap mb-0">{{$clinicUser['name']}}</h6>
                    </div>
                </div>
            </div>
        </div>
        
    </div> 
</div>

<form method="POST" action="" id="timeslotform">
    @csrf
    <div class="row g-4"> 
        <div class="col-12"> 
            <div class="form-group form-outline">
                <label class="float-label active-label active">Appointment Date</label>
                <i class="material-symbols-outlined">calendar_clock</i>
                <input type="text" name="appointmentdate" id="appt-date" class="form-control appointmentdatecls" @if(!empty($input) && isset($input['appointmentdate']) && $input['appointmentdate'] != '') value="{{date('m/d/Y',strtotime($input['appointmentdate']))}}" @else value="{{date('m/d/Y')}}" @endif onblur="fetchAvailableSlots();">
            </div>
        </div>

        <div class="col-12"> 
            <div class="gray-border my-3"></div>
        </div>
        <div id="append_timeslots">
            @include('frontend.appendtimeslots')
        </div>

    </div>
    <input type="hidden" name="clinicuseruuid" id="clinicuseruuid">
    <input type="hidden" name="appointment_time" id="selected-time">
    <div class="btn_alignbox justify-content-end mt-4">
        <button type="button" class="btn btn-outline-primary" onclick="bookAppointment();">Go Back</button>
        <button type="button" class="btn btn-primary" onclick="submitTimeSlot();" id="timeslotbtn">Continue</button>
    </div>
</form>  

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script>
    $(document).ready(function() {
        initializeDateTimePicker();   
        $("#timeslotform").validate({
            ignore: [],
            rules: {
                appointmentdate: {
                    required: true,
                },
                appointment_time: {
                    required: true
                }
            },
            messages: {
                appointmentdate: {
                    required: 'Please select appointment date',
                },
                appointment_time: 'Please select appointment time',
            }
        });
    });
    
    $(document).on('click', '.slot-btn', function () {
        $('.slot-btn').removeClass('active');
        $(this).addClass('active');
        let selectedTime = $(this).text().trim();
        $('#selected-time').val(selectedTime);
        $('#selected-time').valid();
    });
    function submitTimeSlot(){
        if($(".slot-btn").length > 0 && $("#timeslotform").valid()){
            $("#timeslotbtn").prop('disabled',false);
            $.ajax({
                type: "POST",
                url: '{{ url("/appointment/submit") }}',
                data: {
                    'formdata':  $("#timeslotform").serialize(),
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle the successful response
                    if(response.success == 1){
                        $("#doctor_appointment").modal('hide');
                        $("#appointment_summary").modal('show');
                        $("#append_summary").html(response.view);
                    }
                    $('input, textarea').each(function () {
                        toggleLabel(this);
                    });
                },
                error: function(xhr) {
                    if(xhr.status != 403){
                        handleError(xhr);
                    }
                },
                complete: function() {
                    // Reset the flag to allow the request to be sent again
                    isRequestProgress = false;
                    console.log('Request complete');
                }
            })
        }else{
            $("#timeslotbtn").prop('disabled',true);
        }
    }
</script>