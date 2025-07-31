<div class="modal-header modal-bg p-0 position-relative">
    <a href="#" onclick="online('open')" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
  </div>
<div class="modal-body">
    <div class="text-center">
        <img alt="Blackbag" src="{{ asset('images/cardsucess.png') }}">
        <h2 lass="primary">Payment Successful!</h2>
        <small class="mb-0 px-md-5">Your payment has been successfully processed. Below are the details of your appointment.</small>
        <hr>
    </div>
    <?php
        $corefunctions = new \App\customclasses\Corefunctions;
    ?>
    <div class="payment-info">
        @if ($overtime==1)
            <div class="payment-content">
                <small class="mb-0">Your appointment with <span class="primary fwt-bold">{{ $corefunctions -> showClinicanName($appointment->consultant); }}</span> is scheduled for <span class="primary fwt-bold"> <?php echo $corefunctions->timezoneChange($appointment->appointment_date,"M d, Y") ?></span> at <span class="primary fwt-bold"> <?php echo $corefunctions->timezoneChange($appointment->appointment_time,'h:i A') ?> </span>. You will be able to join the video call when the appointment time arrives.</small>
            </div>
        @elseif ($startAppoinment == 1)
             <div class="payment-content">
                <small class="mb-0">Your appointment with <span class="primary fwt-bold"> {{ $corefunctions -> showClinicanName($appointment->consultant); }}</span> is starting soon. Click Join to connect. </small>
                <div class="text-start">
                <a class="btn btn-primary mt-3" target="_blank" href="javascript:void(0);" onclick="joinSession('{{ $appointment->appointment_uuid }}')">Join Session</a>
                </div>
            </div>
        @else
            <div class="payment-content">
                <h5 class="fwt-bold">The appointment has passed. Please contact support for rescheduling.</h5>
            </div>
            
        @endif
    </div>
</div>
