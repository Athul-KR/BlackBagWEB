<div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <div class="col-12 my-3">
        <div class="tab_box">
            <!-- <a href="" class="btn btn-tab active">Reception Room</a> -->
             <button onclick="online('online','receptionroom')" class="btn btn-tab {{ $type == 'online' && $status == 'receptionroom' ? 'active' : '' }}">Reception Room</button>
            <button onclick="online('online','upcoming')" class="btn btn-tab {{ $type == 'online' && $status == 'upcoming' ? 'active' : '' }}">Upcoming</button>
            <button onclick="online('online','expired')" class="btn btn-tab {{ $type == 'online' && $status == 'expired' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['type'=>'online','status'=>'expired'])}}">Expired</button>
            <button onclick="online('online','cancelled')" class="btn btn-tab {{ $type == 'online' && $status == 'cancelled' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['type'=>'online','status'=>'cancelled'])}}">Cancelled</button>
            <button onclick="online('online','all')" class="btn btn-tab {{ $type == 'online' && $status == 'all' ? 'active' : '' }}">All</button>
            <input type="hidden" id="online_status" value="{{$status}}">
            <input type="hidden" id="online_type" value="{{$type}}">
        </div>
    </div>
    <div class=" col-lg-12 my-3">
        <div class="table-responsive">
            <table class="table table-hover table-white text-start w-100">
                <thead>
                    <tr>
                        <!-- <th>Room ID</th> -->
                        <th>Patient</th>
                        <th>Appointment Date & Time</th>
                        <th>Booked On</th>

                        @if ($status=='all')
                        <th>Tags</th>
                        @endif

                        <th class="text-end">Actions</th>


                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointmentsOnline as $appointment)

                    <tr>
                        <!-- <td>DOC-12122</td> -->
                        <td>
                             <div class="user_inner">
                                <!-- <img src="{{asset('images/johon_doe.png')}}"> -->
                                <div class="user_info">
                                    <a href="#">
                                        <h6 class="primary fw-medium m-0">{{$appointment->patient->name ?? 'N/A' }}</h6>
                                        <p class="m-0">{{$appointment->patient->email ?? 'N/A' }}</p>
                                    </a>
                                </div>
                            </div>
                        </td>

                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        <td><?php echo $corefunctions->timezoneChangeAppointment($appointment->appointment_date,$appointment->appointment_time,"M d, Y | h:i A") ?></td>
                        <td>{{\Carbon\Carbon::parse($appointment->created_at)->setTimezone($userTimeZone)->format('M d Y')}}{{' | '}}{{\Carbon\Carbon::parse($appointment->created_at)->setTimezone($userTimeZone)->format('h:i A')}}</td>

                        @if ($status=='all')

                        <td>
                            @if ($appointment->appointment_date > now($userTimeZone)->toDateString() && $appointment->deleted_at == null ||
                            ($appointment->appointment_date == now($userTimeZone)->toDateString() && $appointment->appointment_time > now($userTimeZone)->format('H:i')) && $appointment->deleted_at == null)
                            <div class="pending-icon">
                                <span></span>Upcoming
                            </div>
                            @elseif($appointment->deleted_at !== null)
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
                            @if (session('user.userID')== $appointment->created_by)
                            <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                <a class="btn opt-btn border-0" data-bs-toggle="tooltip" title="Start Video Call"><img src="{{ asset('images/vediocam.png')}}"></a>
                                <a class="btn opt-btn border-0" onclick="notes('{{$appointment->appointment_uuid}}')" data-bs-toggle="modal" data-bs-target="#appointmentNotes" data-bs-dismiss="modal" data-bs-toggle="tooltip" title="Note"><img src="{{asset('images/file_alt.png')}}"></a>
                                <a class="btn opt-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span></a>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    @if ($status === 'upcoming' || $status === 'receptionroom' || $status === 'expired' || ($status === 'all' && $appointment->deleted_at === null))
                                    <li class="appt-li">
                                        <a id="edit-appointment" data-appointmenturl="{{route('appointment.edit',[$appointment->appointment_uuid])}}?type={{ $type }}&status={{ $status }}&user_type={{ 'nurse' }}" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editAppointment" class="dropdown-item fw-medium">
                                            <i class="fa-solid fa-pen me-2"></i>
                                            Edit
                                        </a>
                                    </li>
                                    @endif

                                    @if ($status === 'upcoming' || $status === 'receptionroom' || $status === 'expired' || $status === 'all' && $appointment->deleted_at == null)
                                    <li>
                                        <a data-appointmenturl="{{route('appointment.delete',[$appointment->appointment_uuid,'type'=>$type,'status'=>$status,'user_type'=>'nurse','key'=>$nurse->clinic_user_uuid])}}" class="delete-appt dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel
                                        </a>
                                    </li>
                                    @endif


                                    @if ($status === 'cancelled' || ($status === 'all' && $appointment->deleted_at !== null))
                                    <li>
                                        <a data-appointmenturl="{{ route('appointment.activate',[$appointment->appointment_uuid,'type'=>$type,'status'=>$status,'user_type'=>'nurse','key'=>$nurse->clinic_user_uuid]) }}" class="activate-appt dropdown-item fw-medium">
                                            <i class="fa-solid fa-check primary me-2"></i>Activate
                                        </a>
                                    </li>
                                    @endif

                                </ul>
                            </div>
                             @endif
                        </td>
                       

                    </tr>
                    @endforeach


                    @if ($appointmentsOnline->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">
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
    </div>
    <div class="col-12">
        <div class="row">
            <!-- @if ($appointmentsOnline->isNotEmpty())
            <div class="col-md-6">

                <form method="GET" action="{{ route('nurse.view',[$nurse]) }}">
                    <div class="sort-sec">
                        <p class="me-2 mb-0">Displaying per page :</p>
                        <select name="perPage" id="perPage" class="form-select d-inline-block" aria-label="Default select example" onchange="this.form.submit()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        </select>
                    </div>
                </form>

            </div>
            @endif -->
            <div class="col-lg-6">
                {{ $appointmentsOnline->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>


<!-- Notes Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="fw-bold mb-4" id="appointmentNotesLabel">Appointment Notes</h4>
                </div>
                <p id="appointmentNotesData">

                </p>
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            
        </div>
    </div>
</div>


<script src="{{asset('js/appointmentDeleteActivate.js')}}"></script>
<script>
    function notes(uuid) {
        var uuid = uuid;

        var url = "{{route('appointment.note')}}";

        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');

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
                    if (response.note && response.note.trim() !== '') {
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


    //Edit Appointment
    $('.appt-li').on("click", "#edit-appointment", function() {
        var url = this.getAttribute("data-appointmenturl");
        console.log(url);

        $('#appointment_edit_modal').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');

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
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        });
    });
</script>