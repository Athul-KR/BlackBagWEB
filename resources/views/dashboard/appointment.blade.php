


                <div class="row">
                  <div class="col-sm-9 text-center text-sm-start">
                    <h4 class="mb-md-0">Appointments</h4>
                  </div>
                  @if(!empty($appointmentDetails))
                  <div class="col-sm-3 text-center text-sm-end">
                    <a @if(session()->get('user.userType') == 'patient') href="{{url('myappointments')}}" @else href="{{url('appointments')}}" @endif class="link primary fw-medium text-decoration-underline">See All</a>
                  </div>
                  @endif
                  <div class="col-12 mb-3 mt-4">
                    @if(!empty($appointmentDetails))
                    @foreach($appointmentDetails as $aps)
                      <div class="contributors-sec d-flex justify-content-between mb-3">
                        <div class="user_inner">

                          <?php
                            $logo_path = '';
                            $corefunctions = new \App\customclasses\Corefunctions;
                            if(session()->get('user.userType') == 'patient'){
                              if(isset($doctorDetails[$aps['consultant_id']]['user']['profile_image']) && ($doctorDetails[$aps['consultant_id']]['user']['profile_image'] !='') ){
                                $logo_path = $corefunctions->resizeImageAWS($doctorDetails[$aps['consultant_id']]['user']['id'],$doctorDetails[$aps['consultant_id']]['user']['profile_image'],$doctorDetails[$aps['consultant_id']]['user']['first_name'],180,180,'1');
                              }
                            }else{
                              if(isset($patientDetails[$aps['patient_id']]['user']['profile_image']) && ($patientDetails[$aps['patient_id']]['user']['profile_image'] !='') ){
                                $logo_path = $corefunctions->resizeImageAWS($patientDetails[$aps['patient_id']]['user']['id'],$patientDetails[$aps['patient_id']]['user']['profile_image'],$patientDetails[$aps['patient_id']]['user']['first_name'],180,180,'1');
                              }
                              $age = $corefunctions->calculateAge($patientDetails[$aps['patient_id']]['dob']);
                            }
                          ?>
                          <img @if($logo_path !='') src="{{$logo_path}}" @else src="{{asset('images/default_img.png')}}" @endif>
                          <div class="user_info">
                            <a @if(session()->get('user.userType') == 'patient') href="{{ route('appointmentDetails', [$aps['appointment_uuid']]) }}" @else href="{{ route('appointment.view', [$aps['appointment_uuid']]) }}" @endif>
                              @if(session()->get('user.userType') == 'patient')
                                <h6 class="primary fw-medium m-0">@if(isset($aps['consultant_clinic_user']) && !empty($aps['consultant_clinic_user'])) {{ $corefunctions -> showClinicanName($aps['consultant_clinic_user'],'1'); }} @endif</h6>
                              @else
                                <h6 class="primary fw-medium m-0">@if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['user']['first_name']) ) {{$patientDetails[$aps['patient_id']]['user']['first_name']}} @else -- @endif</h6>
                                <p class="m-0">@if(isset($patientDetails[$aps['patient_id']]) && isset($age) ) {{$age}} | {{ $patientDetails[$aps['patient_id']]['gender'] == '1' ? 'Male' : ( $patientDetails[$aps['patient_id']]['gender'] == '2' ? 'Female' : 'Other') }} @else -- @endif</p>
                              @endif
                            </a>
                          </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <p class="m-0"><?php echo $corefunctions->timezoneChange($aps['appointment_time'],'h:i A') ?></p>
                            @if(session()->get('user.userType') == 'patient')
                            <a class="btn border-0" href="{{ url('appointment/details/'.$aps['appointment_uuid']) }}" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy"><i class="fa-solid fa-chevron-right"></i></a>
                            @else
                            <a class="btn border-0" @if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['patients_uuid']) ) href="{{ url('patient/'.$patientDetails[$aps['patient_id']]['patients_uuid'].'/details') }}" @endif data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy"><i class="fa-solid fa-chevron-right"></i></a>
                            @endif
                        </div>
                      </div>
                    @endforeach
                    @else
                    <div class="text-center no-records-body">
                        <img src="{{asset('images/nodata.png')}}"
                            class=" h-auto">
                        <p>No appointments yet</p>
                    </div>

                    @endif


                  </div>
                  @if(session()->get('user.userType') != 'patient')
                  <div class="col-12">
                    <a class=" btn btn-primary px-5 mb-2 py-2 w-100 btn-align" onclick='createAppointment("{{$selectedDate}}")'><span class="material-symbols-outlined">add</span>Add New Appointment</a>
                  </div>
                  @endif
                </div>

             

