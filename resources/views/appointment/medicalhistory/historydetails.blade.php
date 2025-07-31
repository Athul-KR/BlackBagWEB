   
    @if(!empty($medicathistoryDetails))
    @foreach($medicathistoryDetails as $hsk => $hsv)
    <?php $sourceType = isset($hsv['source_type_id']) && $hsv['source_type_id'] == 1 ? 'Intake Form' : (isset($hsv['source_type_id']) && $hsv['source_type_id'] == 2 ? 'Patient' : 'Clinic');  ?>
    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
    <div class="row align-row mb-3 border-bottom pb-3">

    <div class="col-12 col-md-3">
            <div class="collaspe-info">
                
                
                    @if($formType == 'medical_conditions')
                    <small class="fw-light">{{$title}}</small>
                    <p class="fw-medium"> @if(isset($hsv['condition_id']) && $hsv['condition_id'] != 0) {{$conditionDetails[$hsv['condition_id']]['condition']}} @else -- @endif  </p>
                    
                    @elseif($formType == 'allergies')
                    <small class="fw-light">What Are You Allergic To?</small>
                    <p class="fw-medium"> @if(isset($hsv['allergy']) && $hsv['allergy'] != '') {{$hsv['allergy']}} @else -- @endif  </p>

                    <small class="fw-light">Reaction / Side Effect</small>
                    <p class="fw-medium"> @if(isset($hsv['reaction']) && $hsv['reaction'] != '') {{$hsv['reaction']}} @else -- @endif</p>
                   
                    @elseif($formType == 'immunizations')
                    <small class="fw-light">{{$title}}</small>
                    <p class="fw-medium"> @if(isset($hsv['immunizationtype_id']) && $hsv['immunizationtype_id'] != '' && isset($immunizationTypes[$hsv['immunizationtype_id']])) {{$immunizationTypes[$hsv['immunizationtype_id']]['immunization_type']}} @else -- @endif </p>
                    @else
                    <small class="fw-light">Relation</small>
                    
                    <p class="fw-medium">  @if(isset($hsv['relation_id']) && $hsv['relation_id'] != 0) {{$relationDetails[$hsv['relation_id']]['relation']}} @else -- @endif</p>
                    <small class="fw-light">Condition(s)</small>
                    <p class="fw-medium">  @if(isset($hsv['conditions']) && $hsv['conditions'] != '') {{$hsv['conditions']}} @else -- @endif</p>
                    @endif
               
                <!-- <p class="fw-medium">Neurological Conditions</p> -->
            </div>
        
        </div>
        <div class="col-12 col-md-2">
            <div class="collaspe-info">
                <small class="fw-light">Report Date</small>                                                              
                <p class="fw-medium"><?php echo $corefunctions->timezoneChange($hsv['created_at'], "M d, Y") ?> </p>                                                              
            </div>
        </div> 
        <div class="col-12 col-md-2">
            <div class="collaspe-info">
                <small class="fw-light">Report Time </small>                                                          
                <p class="fw-medium"><?php echo $corefunctions->timezoneChange($hsv['created_at'], "h:i A") ?></p>  
                
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="collaspe-info">
                <small class="fw-light">Source Type</small>                                 
                <p class="fw-medium">{{$sourceType}}</p>  
                                                
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="collaspe-info">
                <small class="fw-light">Last updated</small>                                 
                <p class="fw-medium">
                @if(isset($hsv['updated_by']) && $hsv['updated_by'] != '' && isset($userDetails[$hsv['updated_by']])) {{$userDetails[$hsv['updated_by']]['first_name']}} {{$userDetails[$hsv['updated_by']]['last_name']}} 
                @elseif(isset($hsv['created_by']) && $hsv['created_by'] != '' && isset($userDetails[$hsv['created_by']])) {{$userDetails[$hsv['created_by']]['first_name']}} {{$userDetails[$hsv['created_by']]['last_name']}} @else -- @endif</p>  
                <small class="fw-light">@if(isset($hsv['updated_at']) && $hsv['updated_at'] != '')
                                    <?php echo $corefunctions->timezoneChange($hsv['updated_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv['updated_at'], "h:i A") ?>
                                    @else <?php echo $corefunctions->timezoneChange($hsv['created_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv['created_at'], "h:i A") ?> @endif</small>             
            </div>
        </div>
        <div class="col-12 col-md-1"> 
            @if(isset($hsv['created_by']) && $hsv['created_by'] == Session::get('user.userID') )
                <div class="btn_alignbox justify-content-end">
                    <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">more_vert</span>
                    </a>
                    @if($formType == 'medical_conditions')
                        <?php $key =$hsv['patient_condition_uuid'] ; ?>
                    @elseif($formType == 'allergies')
                        <?php $key =$hsv['allergies_uuid'] ; ?>
                    @elseif($formType == 'immunizations')
                        <?php $key =$hsv['immunization_uuid'] ; ?>
                    @else
                        <?php $key =$hsv['patient_condition_uuid'] ; ?>
                    @endif
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a onclick="editVitalSection('{{$key}}','{{$formType}}','{{$formType}}')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                        <li><a onclick="deleteVitalSection('{{$key}}','{{$formType}}','history')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                    </ul>
                </div>
            @endif
        </div>
        </div>

          


        @endforeach
        @else
        <div class="no-data-box"> 
            <p class="mb-0 align_middle"><span class="material-symbols-outlined primary">info</span>No records found!</p>
        </div>
        @endif
        
   