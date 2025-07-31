<div class="text-center mb-4 px-xl-5 px-3">
    <h4 class="text-center fw-bold mb-1">Appointment Summary</h4>
    <p class="gray fw-light mb-0">Confirm your appointment details</p>
</div>
<div class="row g-4"> 
    <div class="col-12 col-xl-6"> 
        <div class="border rounded-4 p-3 h-100">
            <div class="user_inner user_inner_xl">
                <?php     
                    $corefunctions = new \App\customclasses\Corefunctions;
                    $image = $corefunctions -> resizeImageAWS($clinicUser['user_id'],$clinicUser['user']['profile_image'],$clinicUser['first_name'],180,180,'1');
                ?>
                <img src="{{$image}}" class="img-fluid">
                <div class="user_info">
                    <h5 class="fw-bold m-0 primary">{{ $corefunctions -> showClinicanName($clinicUser,'1'); }}</h5>
                    <p class="m-0">{{$clinicUser['speciality']}}</p>
                </div>
            </div>
            <div class="gray-border my-3"></div>
            <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                <div class="text-xl-start text-center image-body">
                    <img src="{{$clinicUser['clinic_logo']}}" class="user-img" alt="">
                </div>
                <div class="user_details text-xl-start text-center pe-xl-4">
                    <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                        <h6 class="fw-bold primary text-wrap mb-0">{{$clinicUser['name']}}</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-xl-6"> 
        <div class="border rounded-4 p-3 h-100">
            <div class="text-start"> 
                <small class="gray fw-medium">Appointment Date & Time</small>
                <h5 class="mb-0 fw-bold">{{ date('d M, Y',strtotime($input['appointmentdate'])) }} {{ date('h:i A',strtotime($input['appointment_time'])) }}</h5>
            </div>
            <div class="gray-border my-3"></div>
            <div class="text-start"> 
                <small class="gray fw-medium">Appointment Fee</small>
                <h5 class="mb-0 fw-bold">$<?php echo $corefunctions->formatAmount($amount); ?></h5>
            </div>
        </div>
    </div>
</div>  
<input type="hidden" name="formdata" id="formdata" value="{{$formdata}}">
<div class="btn_alignbox justify-content-end mt-4">
    <button type="button" class="btn btn-outline-primary" onclick="bookAppointment();">Edit Booking</button>
    <button type="button" class="btn btn-primary" onclick="confirmBooking();">Confirm Booking</button>
</div>           