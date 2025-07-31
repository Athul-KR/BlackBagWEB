<?php $corefunctions = new \App\customclasses\Corefunctions; 
?>
<div class="tab-pane fade @if($viewtype == 'list') show active @endif" id="pills-transcription" role="tabpanel" aria-labelledby="pills-transcription-tab">
    <div class="table-container">
        <table class="table">
           
            <thead>
                <tr>
                    <th style="width:25%">Date & Time</th>
                    @if( $formType == 'blood_pressure' )
                    <th style="width:20%">Systolic (mmHg)</th>
                    <th style="width:10%">Diastolic (mmHg)</th>
                    <th style="width:10%">Pulse (mmHg)</th>
                    @else
                    @foreach($fields as $field)
                    <th style="width:15%">{{ ucfirst(str_replace('_', ' ', $field)) }}</th>
                    @endforeach
                    
                    @endif
                    <th style="width:15%" @if($formType == 'bmi') colspan="2" @endif>Source</th>
                    @if($formType != 'bmi')
                    <th style="width:5%"></th>
                    @endif
                </tr>
            </thead>
            <tbody id="appendlistloadmore_{{$formType}}">

            @if(!empty($medicalhistoryList))

                   
                   @foreach($medicalhistoryList as $mhd)
                
                   <tr>
                       <td data-label="Date & Time"><?php echo $corefunctions->timezoneChange($mhd['reportdate'], "m/d/Y") ?>, <?php echo $corefunctions->timezoneChange($mhd['reporttime'], "h:i A") ?></td>
                       @foreach($fields as $field)
                           <td data-label="{{ ucfirst(str_replace('_', ' ', $field)) }}">
                               {{ $mhd[$field] ?? '--' }}
                           </td>
                       @endforeach

                       <td data-label="Source">
                       @if(isset( $mhd['rpm_deviceid']) && $mhd['rpm_deviceid'] !='' && isset($mhd['device_image']))
                            <div class="user_inner device-info-box">
                                <img class="patient-rpm-img" src="{{$mhd['device_image']}}">
                                <div class="user_info">
                                    <h6 class="primary fw-medium m-0"> {{$mhd['device_name']}}</h6>
                                </div>
                            </div>
                       @else

                            @if(isset($sourceTypes[$mhd['source_type_id']])) {{$sourceTypes[$mhd['source_type_id']]['source_type']}} @endif

                       @endif
                       </td>
                      
                  
                       <td>
                       @if(isset($mhd['created_by']) && $mhd['created_by'] == Session::get('user.userID') && ($formType != 'bmi'))
                       <div class="btn_alignbox justify-content-end">
                            <a class="opt-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a onclick="editVitalSection('{{$mhd['key']}}','{{$formType}}','{{$formType}}')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li><a onclick="deleteVitalSection('{{$mhd['key']}}','{{$formType}}','{{$formType}}')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                            </ul>
                        </div>
                       @endif
                       </td>

                   </tr>
                   @endforeach
                  
                   <input type="hidden" value="" name="lastVitalID" id="lastVitalID" >
                   @else
                  
                   <tr >
                       <td colspan="6">
                       <p class="text-center">No records found!</p>
                       </td>
                   </tr>
                
                @endif


            </tbody>
        </table>
    </div>
    <!-- <div class="d-flex justify-content-center">
       
            <a class="fw-medium dark" id="isViewMore" onclick="medicalHistoryGraph('{{$formType}}','{{$viewtype}}', '',,1)"> View More </a>
    
    </div> -->
</div>


        <div class="col-12">
            <div class="row justify-content-end g-3">
                @if(!empty($medicalhistoryList) && !empty($medicalHistoryDetailsArray))
                <div class="col-lg-6">
                    <div class="sort-sec">
                        <p class="me-2 mb-0">Displaying per page :</p>
                        <select name="perPage" id="perPage" class="form-select d-inline-block" aria-label="Default select example" onchange="medicalHistoryGraph('{{$formType}}','{{$viewtype}}')">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        </select>
                    </div>
                </div>
                @endif
                @if(isset($medicalHistoryDetailsArray) && !empty($medicalHistoryDetailsArray))
                <div class="col-lg-6">
                    <div id="pagination-vitals">
                        {{ $medicalHistoryDetailsArray->links('pagination::bootstrap-5') }}
                    </div>
                </div>
                @endif
            </div>
        </div>
