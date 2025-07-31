<div class="tab-pane" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
    <?php
        $corefunctions = new \App\customclasses\Corefunctions;
    ?>
    <div class="col-12 my-3">
        <div class="tab_box">

            <button onclick="online('offline','upcoming')" class="btn btn-tab {{ $type == 'offline' && $status == 'upcoming' ? 'active' : '' }}">Upcoming</button>
            <button onclick="online('offline','expired')" class="btn btn-tab {{ $type == 'offline' && $status == 'expired' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['type'=>'offline','status'=>'expired'])}}">Expired</button>
            <button onclick="online('offline','cancelled')" class="btn btn-tab {{ $type == 'offline' && $status == 'cancelled' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['type'=>'offline','status'=>'cancelled'])}}">Cancelled</button>
            <button onclick="online('offline','all')" class="btn btn-tab {{ $type == 'offline' && $status == 'all' ? 'active' : '' }}">All</button>
            <input type="hidden" id="online_status" value="{{$status}}">
            <input type="hidden" id="online_type" value="{{$type}}">
        </div>
    </div>
    <div class="col-lg-12 my-3">
        <div class="table-responsive">
            <table class="table table-hover table-white text-start w-100">
                <thead>
                    <tr>

                        <th>Patient</th>
                        <th>Clinican</th>
                        <th>Appointment Date & Time</th>
                        <th>Booked On</th>
<!--                        <th>Status</th>-->
                        @if ($status=='all')
                        <th>Tags</th>
                        @endif


                        <th class="text-end">Actions</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointmentsOffline as $appointment)
                    <tr>
                        
                        <?php  
                        /* jomy */ 
                        $logo = $corefunctions -> resizeImageAWS($appointment->patient->id,$appointment->patient->logo_path,$appointment->patient->name,180,180,'2');
                        $age = $corefunctions -> calculateAge($appointment->patient->dob);
                        ?>
                        <td>
                            <div class="user_inner">
                                <img alt="Blackbag" @if($logo !='') src="{{asset($logo)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                <div class="user_info">
                              
                                        <h6 class="primary fw-medium m-0">{{ $appointment->patient->name ?? 'N/A' }}</h6>
                                        <p class="m-0">{{$age}} | {{ $appointment->patient->gender == '1' ? 'Male' : ($appointment->patient->gender == '2' ? 'Female' : 'Other') }}</p>
                                  

                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="user_inner">
                                <?php     
                                   /* jomy */ 
                                    $image = $corefunctions -> resizeImageAWS($appointment->consultant->id,$appointment->consultant->logo_path,$appointment->consultant->name,180,180,'1');
                                    
                                ?>
                                <img alt="Blackbag" @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif>

                                <div class="user_info">
                                    <h6 class="primary fw-medium m-0">{{ $corefunctions -> showClinicanName($appointment->consultant); }}</h6>
                                    <p class="m-0">{{ $appointment->consultant->email ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $corefunctions->timezoneChangeAppointment($appointment->appointment_date,$appointment->appointment_time,"M d, Y | h:i A") ?></td>
                        <td><?php echo $corefunctions->timezoneChange($appointment->created_at,"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment->created_at,'h:i A') ?></td>
                        @if ($status=='all')
                        <td>
                            @if ($appointment->appointment_date > now()->toDateString() && $appointment->deleted_at == null ||
                            ($appointment->appointment_date == now()->toDateString() && $appointment->appointment_time > now()->format('H:i')) && $appointment->deleted_at == null)
                            <div class="pending-icon">
                                <span></span>Upcoming
                            </div>
                            @elseif($appointment->deleted_at !==null)
                            <div class="decline-icon">
                                <span></span>Cancelled
                            </div>
                            @else
                            <div class="decline-icon">
                                <span></span>Expired
                            </div>
                            @endif
                        </td>
                        @endif

                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                 @if(isset($fullpermission) && $fullpermission == '1')
                                <a class="btn opt-btn border-0 opt-view" onclick="notes('{{$appointment->appointment_uuid}}')" data-bs-toggle="modal" data-bs-target="#appointmentNotes" data-bs-dismiss="modal" data-bs-target="#appointmentNotes" data-bs-toggle="tooltip" title="Notes"><span class="material-symbols-outlined">description</span></a>
                                <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">

                                    @if ($status === 'upcoming' || $status === 'expired' || ($status === 'all' && $appointment->deleted_at === null))
                                        <li>
                                            <a id="view-appointment"  href="{{ route('appointment.view', [$appointment->appointment_uuid]) }}" class="dropdown-item fw-medium">
                                                <i class="fa-solid fa-eye me-2"></i>
                                                View
                                            </a>
                                        </li>
                                         @if(session()->get('user.isClinicAdmin') == '1')
                                            <li>
                                                <a id="edit-appointment" onclick="editAppointment('{{ route('appointment.edit', [$appointment->appointment_uuid,'type'=>$type,'status'=>$status]) }}')" data-appointurl="{{ route('appointment.edit', [$appointment->appointment_uuid]) }}" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editAppointment" class="dropdown-item fw-medium">
                                                    <i class="fa-solid fa-pen me-2"></i>
                                                    Edit
                                                </a>
                                            </li>
                                        @endif
                                    @endif

                                    @if (session()->get('user.userType') == 'doctor' && ($status === 'upcoming' || $status === 'expired' || $status === 'all') && $appointment->deleted_at == null)
                                    <li>
                                        <a data-appointmenturl="{{ route('appointment.delete', [$appointment->appointment_uuid,'type'=>$type,'status'=>$status]) }}" class="delete-appt dropdown-item fw-medium">
                                            <i class="fa-solid fa-trash-can me-2"></i>Cancel
                                        </a>
                                    </li>
                                    @endif

                                    @if (session()->get('user.userType') == 'doctor' && ($status === 'cancelled' || ($status === 'all' && $appointment->deleted_at !== null)))
                                    <li>
                                        <a data-appointmenturl="{{ route('appointment.activate', [$appointment->appointment_uuid,'type'=>$type,'status'=>$status]) }}" class="activate-appt dropdown-item fw-medium">
                                            <i class="fa-solid fa-check primary me-2"></i>Activate Appointment
                                        </a>
                                    </li>
                                    @endif

                                </ul>
                                @endif
                            </div>
                        </td>

                    </tr>

                    @endforeach

                    @if ($appointmentsOffline->isEmpty())
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
            @if ($appointmentsOffline->isNotEmpty())
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
                {{ $appointmentsOffline->links('pagination::bootstrap-5') }}

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



<script src="https://js.stripe.com/v3/"></script>  

<script src="{{asset('js/appointmentDeleteActivate.js')}}"></script>
<script>
    //Note
    function notes(uuid) {
        var uuid = uuid;

        var url = "{{route('appointment.note')}}";

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
                    if (response.note !== '') {
                        $("#appointmentNotesData").html(response.note.replace(/\n/g, '<br>'));

                    } else {
                        $("#appointmentNotesData").text("No notes found!");

                    }
                }
            },
            error: function(xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
            },
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
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
            },
        });
        // });

    }
</script>