<div class="tab-pane show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
    <div class="row my-3">
        <div class="col-md-9"> 
            <div class="tab_box">
                <!-- <a href="" class="btn btn-tab active">Reception Room</a> -->
                <!-- <button onclick="online('online','receptionroom')" class="btn btn-tab {{ $type == 'online' && $status == 'receptionroom' ? 'active' : '' }}">Reception Room</button>-->
                <button onclick="online('online','upcoming')" class="btn btn-tab {{ $type == 'online' && $status == 'upcoming' ? 'active' : '' }}">Upcoming</button>
                <button onclick="online('online','expired')" class="btn btn-tab {{ $type == 'online' && $status == 'expired' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['type'=>'online','status'=>'expired'])}}">Expired</button>
                <button onclick="online('online','cancelled')" class="btn btn-tab {{ $type == 'online' && $status == 'cancelled' ? 'active' : '' }}" data-url="{{route('appointment.appointmentList',['type'=>'online','status'=>'cancelled'])}}">Cancelled</button>
                <button onclick="online('online','all')" class="btn btn-tab {{ $type == 'online' && $status == 'all' ? 'active' : '' }}">All</button>
                <input type="hidden" id="online_status" value="{{$status}}">
                <input type="hidden" id="online_type" value="{{$type}}">
            </div>
        </div>
        <div class="col-md-3"> 
            <div id="filterlist" style="display: block;">
                <div id="fliteritems"  class="collapse-filter mt-2 justify-content-end text-start @if( (isset($_GET['designation']) ) || (isset($_GET['status']))  ) show @endif">
                    <label class="filter-label mt-md-0 mt-3" for="input">Clinic</label>
                    <select name="clinic" id="clinic" class="form-select" onchange="online('online','{{$status}}')">
                        <option value="all">Select</option>
                        @if(!empty($clinicDetails))
                        @foreach($clinicDetails as $cd)
                      
                            <option value="{{$cd['clinic_uuid']}}" @if(isset($clinickey) && ($clinickey!='') && ($clinickey == $cd['clinic_uuid'])) selected @endif>{{$cd['name']}}</option>
                          
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 my-3">
        <div class="table-responsive">
            <table class="table table-hover table-white text-start w-100">
                <thead>
                    <tr>
                        <!-- <th>Room ID</th> -->
                        
                        <!-- <th>Age</th> -->
                        <th>Clinican</th>
                        <th>Appointment Date & Time</th>
                        <th>Clinic</th>
                        <th>Status</th>

                        @if ($status=='all')
                        <th>Status</th>
                        @endif


                        <th class="text-end">Actions</th>


                    </tr>
                </thead>
                <tbody>

                    @foreach ($appointmentsOnline as $appointment)

                    <tr>
                       
                        <td>
                            <div class="user_inner">
                                <?php
                                    $corefunctions = new \App\customclasses\Corefunctions;
                                    
                                      $logo_path= $corefunctions -> resizeImageAWS($appointment->consultant->user->id,$appointment->consultant->user->profile_image,$appointment->consultant->user->first_name,180,180,'1');
                                  ?>
                                <div class="user_info">
                                    <a id="view-appointment"  href="{{ route('appointmentDetails', [$appointment->appointment_uuid]) }}">
                                       
                                        <h6 class="primary fw-medium m-0">{{ $corefunctions -> showClinicanName($appointment->consultant); }}</h6>
                                        <small class="m-0">{{ $appointment->consultant->email ?? 'N/A' }}</small>
                                    </a>
                                </div>
                            </div>
                        </td>
                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        <td><?php echo $corefunctions->timezoneChange($appointment->appointment_date,"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointment->appointment_time,'h:i A') ?></td>
                        <td>@if(isset($clinicDetails[$appointment->clinic_id]) && isset($clinicDetails[$appointment->clinic_id]['name']) ) {{$clinicDetails[$appointment->clinic_id]['name']}} @endif</td>


                        <td>  @if ($appointment->is_paid == '1' ) <span class="paid">Paid</span> @else <span class="unpaid">Unpaid</span> @endif</td>
                        <?php $expired = 0; ?>
                        @if ($status=='all')
                        <td>
                            @if ($appointment->appointment_date > now($userTimeZone)->toDateString() && $appointment->deleted_at == null ||
                            ($appointment->appointment_date == now($userTimeZone)->toDateString() && $appointment->appointment_time > now()->format('H:i')) && $appointment->deleted_at == null)
                            <div class="pending-icon">
                                <span></span>Upcoming
                            </div>
                            @elseif($appointment->deleted_at !== null)
                            <div class="decline-icon">
                                <span></span>Cancelled
                            </div>
                            @else
                            <?php $expired = 1; ?>
                            <div class="decline-icon">
                                <span></span>Expired
                            </div>
                            @endif
                        </td>
                       
                        @endif
                      
                        <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                
                                @if ($status === 'upcoming' || $status === 'receptionroom' || ($status === 'all' && $appointment->deleted_at === null))
                                @if($expired==0)
                                    @if(($appointment->is_paid != '1' ) )
                                      <button onclick="joinMeet('{{$appointment->appointment_uuid}}');" id="submitbtn"  class="btn btn-primary">Pay Now</button>
                                    @else  

                                    <a class="opt-btn opt-view border-0" target ="_blank" href="{{url('meet/'.$appointment->appointment_uuid)}}" data-bs-toggle="tooltip" title="Start Video Call"><span class="material-symbols-outlined">videocam</span></a>
                                    @endif
                                @endif
                                @endif

                                
                                @if ($appointment->deleted_at === null)
                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item fw-medium" href="{{url('appointment/details/'.$appointment->appointment_uuid)}}" data-bs-toggle="tooltip" title="View"> <i class="fa-solid fa-eye me-2"></i>View</a></li>                                      
                                </ul>
                                @endif
                            </div>
                        </td>





                    </tr>

                    @endforeach

                    @if ($appointmentsOnline->isEmpty())
                    <tr>
                        <td colspan="{{$status=='all'? '6':'6'}}" class="text-center">
                            <div class="flex justify-center">
                                <div class="text-center no-records-body">
                                    <img src="{{asset('images/nodata.png')}}"
                                        class=" h-auto" alt="No appointments">
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
        <div class="row pagination-container">

@php

/*


  @if ($appointmentsOnline->isNotEmpty())
            <div class="col-md-6">

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

 */



@endphp

            <div class="col-lg-6"> 

            </div>

          
            <div class="col-lg-6"  id="pagination-links">
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
                <div class="text-center mb-4">
                    <h4 class="fwt-bold mb-0" id="appointmentNotesLabel">Appointment Notes</h4>
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


<script src="https://js.stripe.com/v3/"></script>  
<script src="{{asset('js/appointmentDeleteActivate.js')}}"></script>
<script>
    function notes(uuid) {
        var uuid = uuid;

        var url = "{{route('frontend.getNote')}}";

        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"  alt="Loader"></div>');

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


    //Edit Appointment
    function editAppointment(url) {

        // $(document).on("click", "edit-appointment", function() {

        console.log(url);

        $('#appointment_edit_modal').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"  alt="Loader"></div>');

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