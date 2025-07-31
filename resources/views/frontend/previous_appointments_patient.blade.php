<?php  $corefunctions = new \App\customclasses\Corefunctions; ?>   
<div class="outer-wrapper box-cnt-inner">
   
        @if($previousAppointments->isNotEmpty())
        @foreach($previousAppointments as $pak => $pav)
           
        <div class="collapse-header w-100 patientprevappcls">
            <div class="row align-items-center">
                <div class="col-12 col-lg-4">
                    <div class="collaspe-info">
                        <small class="fwt-medium">Appointment Date & Time</small>
                        <p class="fwt-bold dark mb-0"><?php echo $corefunctions->timezoneChange($pav['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($pav['appointment_time'],"h:i A") ?></p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="collaspe-info">
                        <small class="fwt-medium">Type</small>
                        <p class="fwt-bold dark mb-0">{{$appointmentTypes[$pav['appointment_type_id']]['appointment_name']}}</p>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="collaspe-info">
                        <small class="fwt-medium">Clinician</small>
                        <div class="user_inner d-flex flex-row align-items-center gap-3">
                                <?php $image = $corefunctions->resizeImageAWS($pav['consultantClinicUser']['user_id'], $pav['consultantClinicUser']['logo_path'], $pav['consultantClinicUser']['name'], 180, 180, '1'); ?>
                                <img  @if($pav['consultantClinicUser']['logo_path'] != '') src="{{ $image }}" 
                                        @else 
                                            src="{{ asset('images/default_img.png') }}" 
                                        @endif 
                                           >
                            <div>
                                <p class="fwt-bold dark mb-0">{{ $corefunctions->showClinicanName($pav['consultantClinicUser'], '1') }}</p>
                                <small class="fwt-medium">{{ $pav['consultantClinicUser']['email'] }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
                  
        @endforeach
        @else
            <div class="text-center w-100"> 
                <p>No previous appointments found!</p>
            </div>
        @endif

</div>