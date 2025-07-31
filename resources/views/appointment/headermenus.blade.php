<div class="col-12">
    <div class="row align-items-center mb-3">
        <div class="col-12 col-lg-10"> 
            <ul class="nav nav-pills border-bottom-0" id="pills-tab" role="tablist">
                @if(isset($type) && $type == 'patient')
                <li class="nav-item" role="presentation">
                    <button class="nav-link appointments align_middle active tabclass" id="pills-home-tab"  data-bs-target="#pills-home" onclick="getPatientAppointments('appointments','open','{{$patientDetails['patients_uuid']}}')"  role="tab" aria-controls="pills-home" aria-selected="true"><span class="material-symbols-outlined">list_alt_check</span>Appointments</button>
                </li>       
                @endif           
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-vitals-tab" data-bs-toggle="pill" data-bs-target="#pills-vitals" type="button" role="tab" onclick="getAppointmentMedicalHistory('vitals')" aria-controls="pills-vitals" aria-selected="true">
                        <span class="material-symbols-outlined">ecg_heart</span> Vitals
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-labs-tab" data-bs-toggle="pill" data-bs-target="#pills-labs" onclick="getAppointmentMedicalHistory('labs')" type="button" role="tab" aria-controls="pills-labs" aria-selected="false">
                        <span class="material-symbols-outlined">experiment</span> Labs
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-imaging-tab" data-bs-toggle="pill" data-bs-target="#pills-imaging" onclick="getAppointmentMedicalHistory('imaging')" type="button" role="tab" aria-controls="pills-imaging" aria-selected="false">
                        <span class="material-symbols-outlined">lab_profile</span> Imaging
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-medications-tab" data-bs-toggle="pill" data-bs-target="#pills-medications" onclick="getAppointmentMedicalHistory('medications')" type="button" role="tab" aria-controls="pills-medications" aria-selected="false">
                        <span class="material-symbols-outlined">pill</span> Medications
                    </button>
                </li>
                @if(isset($type) && $type == 'patient')
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-devices-tab" data-bs-toggle="pill" data-bs-target="#pills-devices" onclick="getAppointmentMedicalHistory('devices')" type="button" role="tab" aria-controls="pills-devices" aria-selected="false">
                        <span class="material-symbols-outlined">ecg</span> Devices
                    </button>
                </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-notes-tab" data-bs-toggle="pill" data-bs-target="#pills-notes" onclick="getAppointmentMedicalHistory('notes')" type="button" role="tab" aria-controls="pills-notes" aria-selected="false">
                        <span class="material-symbols-outlined">draft</span> Notes
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-history-tab" data-bs-toggle="pill" data-bs-target="#pills-history" onclick="getAppointmentMedicalHistory('history')" type="button" role="tab" aria-controls="pills-history" aria-selected="false">
                        <span class="material-symbols-outlined">history</span> History
                    </button>
                </li>
                @if(isset($type) && $type == 'appointment')
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle tabclass" id="pills-previousappointments-tab" data-bs-toggle="pill" data-bs-target="#pills-previousappointments" onclick="getAppointmentMedicalHistory('previousappointments')" type="button" role="tab" aria-controls="pills-previousappointments" aria-selected="false">
                        <span class="material-symbols-outlined">assignment</span> Previous Appointments
                    </button>
                </li>
                @elseif(isset($type) && ($type != 'videocall' && $type != 'appointment'))
                <li class="nav-item" role="presentation">
                    <button class="nav-link align_middle filecabinet tabclass" id="pills-filecabinet-tab" data-bs-toggle="pill" data-bs-target="#pills-filecabinet" onclick="getPatientAppointments('filecabinet','open','{{$patientDetails['patients_uuid']}}')" role="tab" aria-controls="pills-filecabinet" aria-selected="false"><span class="material-symbols-outlined">folder</span>File Cabinet</button>
                </li>
                @endif
            </ul>
        </div>
        @if(isset($type) && $type != 'videocall')
            @include('appointment.ordermenus', ['patientId' => $patientId,'key' => $key])
        @endif
    </div>
                       
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade tabcls show active" id="appointmentspatients" role="tabpanel" aria-labelledby="pills-home-tab">  

        </div>

        <div class="tab-pane fade tabcls" id="pills-vitals" role="tabpanel" aria-labelledby="pills-vitals-tab">
            
        </div> 

        <div class="tab-pane fade tabcls" id="pills-labs" role="tabpanel" aria-labelledby="pills-labs-tab">
            
        </div>

        <div class="tab-pane fade tabcls" id="pills-imaging" role="tabpanel" aria-labelledby="pills-imaging-tab">
            
        </div>

        <div class="tab-pane fade tabcls" id="pills-medications" role="tabpanel" aria-labelledby="pills-medications-tab">
            
        </div>
        <div class="tab-pane fade tabcls" id="pills-devices" role="tabpanel" aria-labelledby="pills-devices-tab">

        </div>
        <div class="tab-pane fade tabcls" id="pills-notes" role="tabpanel" aria-labelledby="pills-notes-tab">
        
        </div>

        <div class="tab-pane fade tabcls" id="pills-history" role="tabpanel" aria-labelledby="pills-historys-tab">
            
        </div>

        <div class="tab-pane fade tabcls" id="pills-previousappointments" role="tabpanel" aria-labelledby="pills-previousappointments-tab">
            
        </div>

        <div class="tab-pane fade tabcls" id="filecabinetpatients" role="tabpanel" aria-labelledby="pills-filecabinet-tab">
                                       
        </div>
        <input type="hidden" name="key" id="key" >
    </div>
</div>
@include('appointment.tabdetails', ['patientId' => $patientId,'key' => $key,'viewType'=>'appoinment'])