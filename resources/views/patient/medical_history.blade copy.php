<div class="col-12 my-3">
    <div class="tab_box">
        <a>Medical History</a>
    
    </div>
</div>
<div class="col-lg-12 my-3">
    <div class="table-responsive">
        <table class="table table-hover table-white text-start w-100">
            <thead>
                <tr>
                    <!-- <th>Patient Name</th> -->
                    <th>Consulting Doctor</th>
                    <th>Date & Time</th>
                    <th>Booked On</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($appointmentRecords))
                @foreach($appointmentRecords as $aps)
                <tr>

                    <!-- <td> <h6 class="primary fw-medium m-0">@if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['name']) ) {{$patientDetails[$aps['patient_id']]['name']}} @else -- @endif </h6>
                    <p class="m-0">@if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['email']) ) {{$patientDetails[$aps['patient_id']]['email']}} @else -- @endif</p>
                    </td> -->

                    <td>
                        <div class="user_inner">
                             <!-- <?php
                             $logo_path = '';
                                $corefunctions = new \App\customclasses\Corefunctions;
                                if(isset($doctorDetails[$aps['consultant_id']]) && isset($doctorDetails[$aps['consultant_id']]['logo_path']) ){
                                  $logo_path = ( $doctorDetails[$aps['consultant_id']]['logo_path'] != '' ) ? $corefunctions->getAWSFilePath($doctorDetails[$aps['consultant_id']]['logo_path']) : '';
                                }
                              ?>
                            <img @if($logo_path !='') src="{{$logo_path}}" @else src="{{asset('images/default_img.png')}}" @endif> -->
                            <div class="user_info">
                                <a href="{{ url('nurse/'.$doctorDetails[$aps['consultant_id']]['clinic_user_uuid'].'/details') }}">
                                    <h6 class="primary fw-medium m-0">@if(isset($doctorDetails[$aps['consultant_id']]) && isset($doctorDetails[$aps['consultant_id']]['name']) ) {{$doctorDetails[$aps['consultant_id']]['name']}} @else -- @endif </h6>
                                    <p class="m-0">@if(isset($doctorDetails[$aps['consultant_id']]) && isset($doctorDetails[$aps['consultant_id']]['email']) ) {{$doctorDetails[$aps['consultant_id']]['email']}} @else -- @endif</p>
                                </a>

                            </div>
                        </div>
                    </td>

                    <td><?php echo  date('M d Y', strtotime($aps['appointment_date'])) ?>, <?php echo date('h:iA', strtotime($aps['appointment_time'])) ?> </td>
                    <td><?php echo date('M d Y, h:iA', strtotime($aps['created_at'])); ?></td>
                    <td class="text-end">
                        <div class="d-flex align-items-center justify-content-end btn_alignbox">
                            <a class="btn opt-btn border-0" href=""><img src="{{asset('images/vediocam.png')}}"></a>
                            <a class="btn opt-btn border-0"  onclick="notes('{{ $aps['appointment_uuid']}}')"><img src="{{asset('images/file_alt.png')}}"></a>
                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span></a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                @if ($status === 'cancelled' && $aps['deleted_at'] !== null)
                                    <li><a onclick="cancelAppointment('{{ $aps['appointment_uuid'] }}','{{$type}}','{{$status}}','activate')"  class="dropdown-item fw-medium"><i class="fa-solid fa-check primary me-2"></i>Activate</a></li>
                                @else
                                <li><a onclick="editAppointment('{{ $aps['appointment_uuid']}}','{{$status}}','{{$type}}','patient')" id="edit-appointment" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li><a onclick="cancelAppointment('{{ $aps['appointment_uuid'] }}','{{$type}}','{{$status}}','cancel')" id="cancel-appointment" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel</a></li>
                                @endif
                                
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
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
        @if(!empty($appointmentRecords))
        <div class="col-lg-6">
            <form method="GET" action="">
                <div class="sort-sec">
                    <p class="me-2 mb-0">Displaying per page :</p>
                    <select class="form-select" aria-label="Default select example" id="pagelimit" name="limit" onchange="getAppointments('{{$type}}','{{$status}}','{{$patientKey}}');">
                        <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                        <option value="9" {{ $limit == 9 ? 'selected' : '' }}>9</option>
                        <option value="8" {{ $limit == 8 ? 'selected' : '' }}>8</option>
                    </select>
                </div>
                <form>
        </div>
        @endif
        <div class="col-lg-6">
            <div id="pagination-links">
                {!! $appointmentRecordList->links() !!}
            </div>


        </div>
    </div>
</div>




<script>

function cancelAppointment(key, type, status, apptype) {
    
    swal({
        text: "Are you sure you want to " + apptype + " this appointment?",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancel",
                visible: true,
                className: "btn-secondary",
            },
            confirm: {
                text: "OK",
                className: "btn-danger",
            }
        },
        dangerMode: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                type: "POST",
                url: "{{ URL::to('appointments/cancel') }}",
                data: {
                    'key': key,
                    'apptype': apptype,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == 1) {
                        swal("Success!",data.message, "success");
                        var patientKey = '{{$patientKey}}';
                        getAppointments(type, status, patientKey); 
                    } else if (data.success == 2) {
                        swal("Error", data.message, "error");
                    } else {
                        swal("Error", data.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred: " + error, "error");
                }
            });
        } else {
            swal("Cancelled", "Your response has not been recorded.", "error");
        }
    });
}


  </script>