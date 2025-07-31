@if(!empty($appointmentDetails))
    @foreach($appointmentDetails as $aps)
        <tr>
            <td style="width:30%">
                <a href="{{ route('appointment.view', [$aps['appointment_uuid']]) }}">
                    <div class="user_inner">
                        <?php
                            $logo_path = '';
                            $corefunctions = new \App\customclasses\Corefunctions;
                            if(isset($patientDetails[$aps['patient_id']]['user']['profile_image']) && ($patientDetails[$aps['patient_id']]['user']['profile_image'] !='') ){
                                $logo_path = $corefunctions->resizeImageAWS($patientDetails[$aps['patient_id']]['user']['id'],$patientDetails[$aps['patient_id']]['user']['profile_image'],$patientDetails[$aps['patient_id']]['user']['first_name'],180,180,'1');
                            }
                        ?>
                        <img @if($logo_path !='') src="{{$logo_path}}" @else src="{{asset('images/default_img.png')}}" @endif>
                        <div class="user_info">
                            <h6 class="primary fw-medium m-0">@if(isset($patientDetails[$aps['patient_id']]['user']['first_name'])) {{$patientDetails[$aps['patient_id']]['user']['first_name']}} @else -- @endif</h6>
                            <p class="m-0">@if(isset($patientDetails[$aps['patient_id']]['age'])) {{$patientDetails[$aps['patient_id']]['age']}} | {{ $patientDetails[$aps['patient_id']]['gender'] == '1' ? 'Male' : ($patientDetails[$aps['patient_id']]['gender'] == '2' ? 'Female' : 'Other') }} @else -- @endif</p>
                            @if(isset($aps['reception_waiting']) && $aps['reception_waiting'] == '1')<p><span class="badge bg-warning text-dark">Waiting in Reception</span></p>@endif
                        </div>
                    </div>
                </a>
            </td>
            <td style="width:20%">@if(isset($patientDetails[$aps['patient_id']]['user']['email'])) {{$patientDetails[$aps['patient_id']]['user']['email']}} @else -- @endif</td>
            <td style="width:25%"><?php echo $corefunctions->timezoneChangeAppointment($aps['appointment_date'],$aps['appointment_time'],"M d, Y | h:i A") ?> </td>
            <td style="width:15%">@if($aps['appointment_type_id'] == '1') Online @else In-person @endif </td>
            <td class="text-end" style="width:10%">
                <div class="d-flex align-items-center justify-content-end btn_alignbox">
                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">more_vert</span>
                    </a>
                    @if(isset($fullpermission) && $fullpermission == '1')
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a id="view-appointment" href="{{ route('appointment.view', [$aps['appointment_uuid']]) }}" class="dropdown-item fw-medium"><i class="fa-solid fa-eye me-2"></i><span>View</span></a></li>
                            <li><a onclick="editAppointment('{{ $aps['appointment_uuid']}}','upcoming','online','dashboard')" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i><span>Edit</span></a></li>
                            @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor' )
                                <li><a onclick="showCancellationModal('{{ $aps['appointment_uuid'] }}')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i><span>Cancel</span></a></li>
                            @endif
                        </ul>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr class="text-center">
        <td colspan="8">
            <div class="flex justify-center">
                <div class="text-center no-records-body">
                    <img src="{{asset('images/nodata.png')}}" class="h-auto">
                    <p>No appointments yet</p>
                </div>
            </div>
        </td>
    </tr>
@endif