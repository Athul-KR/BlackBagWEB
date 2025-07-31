<div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <?php
        $corefunctions = new \App\customclasses\Corefunctions;
    ?>
    <div class="col-12 my-3">
        <div class="tab_box">
            <button onclick="online('open')" class="btn btn-tab {{ $status == 'open' ? 'active' : '' }}">Open ({{$openCount}})</button>
            <button onclick="online('reception')" class="btn btn-tab {{ $status == 'reception' ? 'active' : '' }}">Reception Room ({{$receptionCount}})</button>
            <button onclick="online('completed')" class="btn btn-tab {{ $status == 'completed' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['status'=>'completed'])}}">Completed ({{$completedCount}})</button>
            <button onclick="online('notes_locked')" class="btn btn-tab {{ $status == 'notes_locked' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['status'=>'notes_locked'])}}">Notes Locked ({{$notesLockedCount}})</button>
            <button onclick="online('cancelled')" class="btn btn-tab position-relative {{ $status == 'cancelled' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['status'=>'cancelled'])}}">Cancelled ({{$cancelledCount}}) @if($patientCancelledCount > 0)<img src="{{ asset('images/cancelled-icon.png')}}" class="cancld-icon">@endif</button>
            <button onclick="online('no_show')" class="btn btn-tab {{ $status == 'no_show' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['status'=>'no_show'])}}">No Show ({{$noshowCount}})</button>
            <input type="hidden" id="online_status" value="{{$status}}">
        </div>
    </div>
    <div class="col-lg-12 my-3">
        <div class="table-responsive">
            <table class="table table-hover table-white text-start w-100">
                <thead>
                    <tr>
                        <th style="width: 25%">Patient</th>
                        <th style="width: 15%">Clinician</th>
                        <th style="width: 10%">Appointment Type</th>
                        <th style="width: 15%">Appointment Date & Time</th>
                        <th style="width: 15%">Booked On</th>
                        <!-- <th style="width: 10%">Status</th> -->
                        <th class="text-end" style="width: 20%">Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointments as $appointment)
                    
                    <tr>
                        
                        <?php  
                        
                       
                            $name = $appointment->patient->first_name ?? 'N/A';
                            $logo = !empty($appointment->patient->profile_image) 
                                ? $corefunctions->resizeImageAWS($appointment->patient->id, $appointment->patient->profile_image, $appointment->patient->first_name, 180, 180, '1') 
                                : asset('images/default_img.png');
                            $age = isset($appointment->patientUser->dob) ? $corefunctions -> calculateAge($appointment->patientUser->dob) : '';
                        ?>
                        <td style="width: 25%">
                        @if ($status != 'cancelled') <a href="{{ route('appointment.view', [$appointment->appointment_uuid]) }}"> @endif
                            <div class="user_inner">
                                <img alt="Blackbag" @if($logo !='') src="<?php echo $logo ?>" @else src="{{asset('images/default_img.png')}}" @endif>
                                <div class="user_info">
                                    <h6 class="primary fw-medium m-0">{{ $name ?? 'N/A' }}</h6>
                                    <p class="m-0">{{$age}} | @if( isset($appointment->patientUser->gender)) {{ $appointment->patientUser->gender == '1' ? 'Male' : ($appointment->patientUser->gender == '2' ? 'Female' : 'Other') }} @endif</p>
                                    @if($status == 'open' && isset($appointment->reception_waiting) && $appointment->reception_waiting == '1')<p><span class="badge bg-warning text-dark">Waiting in Reception</span></p>@endif
                                </div>
                            </div>
                        @if ($status != 'cancelled') </a> @endif
                        </td>

                        <td style="width: 15%">
                        <a href="{{ route('appointment.view', [$appointment->appointment_uuid]) }}">
                            <div class="user_inner">
                                <?php     
                                /* jomy */ 
                                    $image = $corefunctions -> resizeImageAWS($appointment->consultant->id,$appointment->consultant->profile_image,$appointment->consultant->first_name,180,180,'1');
                                    
                                ?>
                                <img alt="Blackbag" @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif>

                                <div class="user_info">
                                    <h6 class="primary fw-medium m-0">@if(isset($appointment->consultantClinicUser) && !empty($appointment->consultantClinicUser)){{ $corefunctions -> showClinicanName($appointment->consultantClinicUser,'1'); }} @endif</h6>
                                    <p class="m-0">{{ explode('_', $appointment->consultant->email ?? 'N/A')[0] }}</p>
                                </div>
                            </div>
                        </a>
                        </td>
                        <td style="width: 10%">@if($appointment->appointment_type_id == '1') Online @else In-person @endif</td>
                        <td style="width: 15%"><?php echo $corefunctions->timezoneChangeAppointment($appointment->appointment_date,$appointment->appointment_time,"M d, Y | h:i A") ?></td>
                        <td style="width: 15%"><?php echo $corefunctions->timezoneChange($appointment->created_at,"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment->created_at,'h:i A') ?></td>
                        <!-- <td style="width: 10%">@if ($appointment->appointment_type_id == '1' ) @if ($appointment->is_paid == '1' || $appointment->appointment_fee == '0') <span class="paid">Paid</span> @else <span class="unpaid">Unpaid</span> @endif @endif</td> -->
                        
                        <td class="text-end" style="width: 20%">
                            <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                @if (($status === 'open'|| $status === 'reception') && $appointment->appointment_type_id == '1')
                                    <a class="opt-view border-0" target ="_blank" href="{{url('meet/'.$appointment->appointment_uuid)}}" data-bs-toggle="tooltip" title="Start Video Call"><span class="material-symbols-outlined">videocam</span></a>
                                @endif
                                @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor')
                                    @if(isset($fullpermission) && $fullpermission == '1')
                                        @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && $status === 'cancelled' && $appointment->cancelled_by_type == 'p')
                                            <a class="btn btn-primary-sm" onclick="showCancellationModal('{{$appointment->appointment_uuid}}')">Take Action</a>
                                        @endif
                                        <a class="btn border-0 opt-view" onclick="notes('{{ $appointment->appointment_uuid }}')" data-bs-toggle="tooltip" title="Notes" data-bs-target="#appointmentNotes" data-bs-toggle="modal"><span class="material-symbols-outlined">description</span></a>
                                        @if ($status != 'cancelled')
                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                @if ($status != 'cancelled')
                                                    <li>
                                                        <a id="view-appointment"  href="{{ route('appointment.view', [$appointment->appointment_uuid]) }}" class="dropdown-item fw-medium"><i class="fa-solid fa-eye me-2"></i>
                                                            <span>View</span>
                                                        </a>
                                                    </li>
                                                    @if(session()->get('user.isClinicAdmin') == '1' && $status != 'completed')
                                                        <li>
                                                            <a id="edit-appointment" onclick="editAppointment('{{ route('appointment.edit', [$appointment->appointment_uuid,'status'=>$status]) }}')" data-appointurl="{{ route('appointment.edit', [$appointment->appointment_uuid]) }}" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editAppointment" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>
                                                                <span>Edit</span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endif
                                                @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && ($status == 'open' || $status == 'reception'))
                                                    <li>
                                                        <a onclick="completeAppointment('{{$appointment->appointment_uuid}}','{{$appointment->appointment_fee}}')" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">add_task</i>
                                                            <span>Mark As Completed</span>
                                                        </a>
                                                    </li>
                                                @endif
                                                @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && ($status == 'open'))
                                                    <li>
                                                        <a onclick="showMarkAsNoShowModal('{{$appointment->appointment_uuid}}')" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">unpublished</i>
                                                            <span>Mark As No Show</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && ($status == 'open' || $status == 'reception') )
                                                    <li>
                                                        <a onclick="rescheduleAppointment('{{$appointment->appointment_uuid}}','{{$appointment->appointment_fee}}')" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">event_repeat</i> 
                                                            <span>Reschedule</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && $status === 'open' && $appointment->deleted_at == null)
                                                    <li>
                                                        <a onclick="showCancellationModal('{{$appointment->appointment_uuid}}')" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">cancel</i>
                                                            <span>Cancel</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                <!-- @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && $status === 'cancelled')
                                                    <li>
                                                        <a data-appointmenturl="{{ route('appointment.activate', [$appointment->appointment_uuid,'status'=>$status]) }}" class="activate-appt dropdown-item fw-medium"><i class="fa-solid fa-check primary me-2"></i>
                                                            <span>Activate</span>
                                                        </a>
                                                    </li>
                                                @endif -->

                                                @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && $status === 'completed')
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="markNotesLocked('{{$appointment->appointment_uuid}}');" class="dropdown-item fw-medium"><i class="fa-solid fa-check primary me-2"></i>
                                                            <span>Mark as Notes Locked</span>
                                                        </a>
                                                    </li>
                                                @endif

                                                @if ((session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor') && $appointment->payment_response != '')
                                                    <li>
                                                        <a href="javascript:void(0);" onclick="showPaymentResponse('{{$appointment->appointment_uuid}}');" class="dropdown-item fw-medium"><i class="fa-solid fa-credit-card primary me-2"></i>
                                                            <span>Payment Info</span>
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>

                    @endforeach

                    @if ($appointments->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">
                            <div class="flex justify-center">
                                <div class="text-center no-records-body">
                                    <img alt="Blackbag" src="{{asset('images/nodata.png')}}"
                                        class=" h-auto">
                                    <p>No appointments yet</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            @if ($appointments->isNotEmpty())
            <div class="col-lg-6">
                <div class="sort-sec">
                    <p class="me-2 mb-0">Displaying per page :</p>
                    <select name="perPage" id="perPage" class="form-select d-inline-block" aria-label="Default select example" onchange="perPage()">
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                    </select>
                </div>
            </div>
            @endif
            <div class="col-lg-6">
                {{ $appointments->links('pagination::bootstrap-5') }}

            </div>
        </div>
    </div>
</div>

<!-- Notes Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="fw-bold mb-0" id="appointmentNotesLabel">Appointment Notes</h4>
            </div>
            <div class="modal-body">
                <p id="appointmentNotesData">

                </p>
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="paymentInfoModal" tabindex="-1" aria-labelledby="paymentInfoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="fw-bold mb-0" id="paymentInfoLabel">Payment Information</h4>
            </div>
            <div class="modal-body">
                <p id="paymentInfoData">

                </p>
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="markasnoshowmodal" tabindex="-1" aria-labelledby="markasnoshowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center p-4">

                <div class="swal-error-icon mb-2">
                   <span class="material-symbols-outlined">error</span>
                </div>

                <h4 class="mb-3 fw-bold">Are you sure you want to mark this appointment as no show?</h4>

                <form id="mark_as_no_show_form" method="post" autocomplete="off">

                    @csrf

                    <div class="form-check d-flex justify-content-center mb-4">
                        <input class="form-check-input me-2" type="checkbox" value="1" id="collectFeeCheckbox" checked name="collect_fee">
                        <p class="gray fw-light mb-0" for="collectFeeCheckbox">
                            Collect No Show Fee from patient.
                        </p>
                    </div>
                    <input type="hidden" name="appointmentkey" id="appointmentkey" />

                    <div class="btn_alignbox">
                        <button type="button" class="btn btn-outline-primary equal-width" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary equal-width" id="confirmNoShowBtn" onclick="markedAsNoShow();">Yes, I'm Sure</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="cancellationmodal" tabindex="-1" aria-labelledby="cancellationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-body text-center p-4">

                <div class="swal-error-icon mb-2">
                   <span class="material-symbols-outlined">error</span>
                </div>

                <h4 class="mb-3 fw-bold">Are you sure you want to mark this appointment as Cancelled?</h4>

                <form id="cancellation_form" method="post" autocomplete="off">
                    @csrf

                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-4">
                        <input class="form-check-input me-2" type="checkbox" value="1" checked id="collectCancellationFeeCheckbox" name="collect_cancellation_fee">
                        <p class="gray fw-light mb-0" for="collectCancellationFeeCheckbox">
                            Collect Cancellation Fee from patient.
                        </p>
                    </div>
                    <input type="hidden" name="appointmentuuid" id="appointmentuuid"/>

                    <!-- Buttons -->
                    <div class="btn_alignbox">
                        <button type="button" class="btn btn-outline-primary equal-width" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary equal-width" id="confirmCancelBtn" onclick="cancelAppointment();">Yes, I'm Sure</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>



<script src="https://js.stripe.com/v3/"></script>  

<script src="{{asset('js/appointmentDeleteActivate.js')}}?v=1"></script>
<script>
    //Note
    function startAppointment(key){
        var msg = 'Are you sure you want to start this appointment?'; 
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "OK",
                    value: true,
                    closeModal: false
                }
            },
            dangerMode: true
        }).then((willConfirm) => {
            if (willConfirm) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/appointments/startappointment') }}",
                    data: {
                        'key': key,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).then(response => {
                    if (response.success == 1) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }).catch(xhr => {
                    handleError(xhr);
                });
            }
        });
    }
    function showPaymentResponse(uuid){
        var uuid = uuid;
        var url = "{{route('appointment.paymentresponse')}}";
        $("#paymentInfoModal").modal('show');
        $('#paymentInfoData').html('<div class="d-flex justify-content-center py-5"><img alt="Blackbag" src="{{ asset("images/loader.gif") }}" width="250px"></div>');
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'uuid': uuid,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function(response) {
                // Populate form fields with the logger details
                if (response.status == 1) {
                    if (response.payment_response !== '') {
                        $("#paymentInfoData").html(response.payment_response.replace(/\n/g, '<br>'));
                    } else {
                        $("#paymentInfoData").text("No payment response found!");
                    }
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });

    }
    function notes(uuid) {
        var uuid = uuid;

        var url = "{{route('appointment.note')}}";
        $("#appointmentNotes").modal('show');
        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img alt="Blackbag" src="{{ asset("images/loader.gif") }}" width="250px"></div>');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'uuid': uuid,
            },

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    if (response.note != '' && response.note != null) {
                        $("#appointmentNotesData").html(response.note.replace(/\n/g, '<br>'));

                    } else {
                        $("#appointmentNotesData").text("No notes found!");

                    }
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        });

    }
    
    function rescheduleAppointment(key) {

        $('#rescheduleAppointmentModal').modal('show');

        $('#rescheduleAppointmentModalBody').html('<div class="d-flex justify-content-center py-5"><img alt="Blackbag" src="{{ asset("images/loader.gif") }}" width="250px"></div>');

        $.ajax({
            type: "POST",
            url: "{{ URL::to('/appointments/reschedule') }}",
            data: {
                'uuid': key,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    $("#rescheduleAppointmentModalBody").html(response.view);
                }else{
                    swal({
                            icon: 'error',
                            title: 'Error',
                            text: response.errormsg
                        });
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
           },
        });

      
    }


    function completeAppointment(key,amount) {
        let msg = 'Are you sure you want to mark this appointment as complete?';
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "OK",
                    value: true,
                    closeModal: false // Keeps the modal open until AJAX is done
                }
            },
            dangerMode: true
        }).then((willConfirm) => {
            if (willConfirm) {
                // AJAX call only runs if confirmed
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/appointments/markascompleted') }}",
                    data: {
                        'key': key,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).then(response => {
                    if (response.success == 1) {
                        swal.close();
                        let msg = (amount > 5) ? 'An amount of $'+amount+' debited from patient card.' : 'An amount of $5.00 debited from clinic card.';
                        $('#appointmentToastBody').text(msg);
                        let toastElement = new bootstrap.Toast(document.getElementById('appointmentToast'));
                        toastElement.show();
                        setTimeout(() => window.location.reload(), 2000);
                    } else {
                        swal("Error!", response.errormsg, "error");
                    }
                }).catch(xhr => {
                    handleError(xhr);
                });
            }
        });
    }

    function showMarkAsNoShowModal(key){
        $("#markasnoshowmodal").modal('show');
        $("#appointmentkey").val(key);
    }
    function showCancellationModal(key){
        $("#cancellationmodal").modal('show');
        $("#appointmentuuid").val(key);
    }
    function cancelAppointment(){
        $("#confirmCancelBtn").text('Submitting....');
        $("#confirmCancelBtn").prop('disabled',true);
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/appointments/cancelappointment') }}",
            data: {
                'formdata': $("#cancellation_form").serialize(),
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json'
        }).then(response => {
            if (response.success == 1) {
                $("#cancellationmodal").modal('hide');
                $('#appointmentToastBody').text(response.message);
                let toastElement = new bootstrap.Toast(document.getElementById('appointmentToast'));
                toastElement.show();
                setTimeout(() => window.location.reload(), 2000);
            } else {
                swal("Error!", response.errormsg, "error");
                $("#confirmCancelBtn").text("Yes, I'm Sure");
                $("#confirmCancelBtn").prop('disabled',false);
            }
        }).catch(xhr => {
            handleError(xhr);
        });
    }
    function markNotesLocked(key){
        var msg = 'Are you sure you want to mark this appointment notes as locked?You won’t be able to edit or delete them later.'; 
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "OK",
                    value: true,
                    closeModal: false
                }
            },
            dangerMode: true
        }).then((willConfirm) => {
            if (willConfirm) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('appointments/markasnoteslocked') }}",
                    data: {
                        'key': key,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).then(response => {
                    if (response.success == 1) {
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }).catch(xhr => {
                    handleError(xhr);
                });
            }
        });
    }
    function markedAsNoShow(){
        $("#confirmNoShowBtn").text('Submitting....');
        $("#confirmNoShowBtn").prop('disabled',true);
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/appointments/markasnoshow') }}",
            data: {
                'formdata': $("#mark_as_no_show_form").serialize(),
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json'
        }).then(response => {
            if (response.success == 1) {
                $("#markasnoshowmodal").modal('hide');
                $('#appointmentToastBody').text(response.message);
                let toastElement = new bootstrap.Toast(document.getElementById('appointmentToast'));
                toastElement.show();
                setTimeout(() => window.location.reload(), 2000);
            } else {
                swal("Error!", response.errormsg, "error");
                $("#confirmNoShowBtn").text("Yes, I'm Sure");
                $("#confirmNoShowBtn").prop('disabled',false);
            }
        }).catch(xhr => {
            handleError(xhr);
        });
    }

    function editAppointment(url) {

        // $(document).on("click", "edit-appointment", function() {

        console.log(url);

        $('#appointment_edit_modal').html('<div class="d-flex justify-content-center py-5"><img alt="Blackbag" src="{{ asset("images/loader.gif") }}" width="250px"></div>');

        $.ajax({
            type: "GET",
            url: url,

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    $("#appointment_edit_modal").html(response.view);
                }else{
                    swal({
                            icon: 'error',
                            title: 'Error',
                            text: response.errormsg
                        });
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
           },
        });
        // });

    }

    
</script>

<!-- Add Reschedule Appointment Modal -->
<div class="modal login-modal fade" id="rescheduleAppointmentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="rescheduleAppointmentModalBody">   
               
            </div>
        </div>
    </div>
</div>
