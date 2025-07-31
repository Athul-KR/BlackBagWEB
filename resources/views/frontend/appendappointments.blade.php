<div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <?php
        $corefunctions = new \App\customclasses\Corefunctions;
    ?>
    <div class="col-12 my-3">
        <div class="tab_box">
            <button onclick="online('open')" class="btn btn-tab {{ $status == 'open' ? 'active' : '' }}">Open ({{$openCount}})</span></button>
            <button onclick="online('reception')" class="btn btn-tab {{ $status == 'reception' ? 'active' : '' }}">Reception Room ({{$receptionCount}})</button>
            <button onclick="online('completed')" class="btn btn-tab {{ $status == 'completed' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['status'=>'completed'])}}">Completed ({{$completedCount}})</button>
            <button onclick="online('cancelled')" class="btn btn-tab {{ $status == 'cancelled' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['status'=>'cancelled'])}}">Cancelled ({{$cancelledCount}})</button>
            <input type="hidden" id="online_status" value="{{$status}}">
        </div>
    </div>
    <div class="col-lg-12 my-3">
        <div class="table-responsive">
            <table class="table table-hover table-white text-start w-100">
                <thead>
                    <tr>
                        <th>Clinican</th>
                        <th>Appointment Date & Time</th>
                        <th>Appointment Type</th>
                        <th>Clinic</th>
                        <!-- <th>Status</th> -->
                        @if($status != 'cancelled')
                        <th class="text-end">Actions</th>
                        @endif
                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointments as $appointment)
                    <tr>
                        
                        <td>
                            <div class="user_inner">
                                <?php     
                                    $image = $corefunctions -> resizeImageAWS($appointment->consultant->id,$appointment->consultant->logo_path,$appointment->consultant->name,180,180,'1');   
                                ?>
                                <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif alt="Default Image">
                                <div class="user_info">
                                    <a id="view-appointment" @if( $appointment->deleted_at =='')  href="{{ route('appointmentDetails', [$appointment->appointment_uuid]) }}" @endif>
                                        <h6 class="primary fw-medium m-0">{{ $corefunctions -> showClinicanName($appointment->consultantClinicUser,'1'); }}</h6>
                                        <small class="m-0">{{ explode('_', $appointment->consultant->email ?? 'N/A')[0] }}</small>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        <td><?php echo $corefunctions->timezoneChange($appointment->appointment_date,"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment->appointment_time,'h:i A') ?></td>
                        <td>@if($appointment->appointment_type_id == '1') Online @else In-person @endif</td>
                        <td>@if(isset($clinicDetails[$appointment->clinic_id]) && isset($clinicDetails[$appointment->clinic_id]['name']) ) {{$clinicDetails[$appointment->clinic_id]['name']}} @endif</td>
                        <!-- <td>@if ($appointment->appointment_type_id == '1' ) @if ($appointment->is_paid == '1' ) <span class="paid">Paid</span> @else <span class="unpaid">Unpaid</span> @endif @endif</td> -->
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                
                                @if (($status === 'open'|| $status === 'reception') && $appointment->appointment_type_id == '1')
                                    <?php /* @if(($appointment->is_paid != '1' && $appointment->appointment_fee > '0') )
                                      <button onclick="joinMeet('{{$appointment->appointment_uuid}}');" id="submitbtn"  class="btn btn-primary">Pay Now</button>
                                    @else */ ?> 

                                    <a class="opt-btn opt-view border-0" target ="_blank" href="{{url('meet/'.$appointment->appointment_uuid)}}" data-bs-toggle="tooltip" title="Start Video Call"><span class="material-symbols-outlined">videocam</span></a>
                                    <?php /* @endif */ ?> 
                                @endif

                                
                                @if ($appointment->deleted_at === null)
                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item fw-medium" href="{{url('appointment/details/'.$appointment->appointment_uuid)}}" data-bs-toggle="tooltip" title="View"> <i class="fa-solid fa-eye me-2"></i>View</a></li>      
                                    @if ($status === 'open')
                                    <li><a class="dropdown-item fw-medium" onclick="cancelAppointment('{{$appointment->appointment_uuid}}')" data-bs-toggle="tooltip" title="Cancel"> <i class="fa-solid fa-xmark me-2"></i>Cancel</a></li>         
                                    @endif                                                             
                                </ul>
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
                                    <img src="{{asset('images/nodata.png')}}"
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
        <div class="col-md-12 mt-3"  id="pagination-links">
            {{ $appointments->links('pagination::bootstrap-5') }}
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



<script src="https://js.stripe.com/v3/"></script>  

<script src="{{asset('js/appointmentDeleteActivate.js')}}"></script>
<script>
    //Note
    function notes(uuid) {
        var uuid = uuid;

        var url = "{{route('appointment.note')}}";

        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }} alt="Loader" width="250px"></div>');

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
                    if (response.note !== '') {
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

    function cancelAppointment(key){
        var msg = 'Are you sure you want to cancel this appointment?'; 
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
                    url: "{{ URL::to('/cancelappointment') }}",
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
    function completeAppointment(key) {
        var msg = 'Are you sure you want to mark this appointment as completed?'; 
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
                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            window.location.reload();
                        });

                        // swal("Success!", response.message, "success").then(() => {
                        //     window.location.reload();
                        // });
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }).catch(xhr => {
                    handleError(xhr);
                });
            }
        });
    }

    function editAppointment(url) {

        // $(document).on("click", "edit-appointment", function() {

        console.log(url);

        $('#appointment_edit_modal').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px" alt="Loader"></div>');

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