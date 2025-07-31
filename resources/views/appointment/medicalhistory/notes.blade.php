
                                       @if( Session::get('user.userType') != 'patient' )
                                       <div class="text-end mb-3">
                                            <button type="button" class="btn btn-primary btn-sm btn-align" onclick="addNotes()"  title="Notes"><span class="material-symbols-outlined">add </span>Add Notes</button>
                                        </div>
                                        @endif
                                        <div class="outer-wrapper box-cnt-inner">
                                            
                                            <div class="accordion accordion-flush" id="accordionFlushExample1">
        
                                                <!-- Accordion Item 1 -->
                                                <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                                @if(!empty($medicalNoteDetails['data']))
                                                @foreach ($medicalNoteDetails['data'] as $index => $mnds)
                                                @php
                                                    $collapseId = "flush-collapse-".$mnds['id'];
                                                    $headingId = "flush-heading-".$mnds['id'];
                                                @endphp

                                                <div class="accordion-item">

                                                <h2 class="accordion-header position-relative" id="{{$headingId}}">
                                                    <button 
                                                        class="accordion-button collapsed fw-bold d-flex justify-content-between align-items-center listsoapnotecls_{{$mnds['medical_note_uuid']}}" 
                                                        type="button" data-bs-toggle="collapse" data-bs-target="#{{$collapseId}}" 
                                                        aria-expanded="false" aria-controls="{{$collapseId}}" 
                                                        onclick="openSoapNotes('{{$mnds['medical_note_uuid']}}','list')">

                                                        <!-- Your existing inner accordion layout -->
                                                        <div class="row align-items-center collapse-header w-100">
                                                            <div class="col-12 col-lg-10">
                                                                <div class="row align-items-center g-3">
                                                                    <div class="col-12 col-xl-5 col-xxl-6">
                                                                        <div class="align_middle justify-content-start flex-sm-row flex-column align-items-sm-center align-items-baseline">                                                                                                                    
                                                                            <h5 class="fwt-bold mb-0">
                                                                                {{ $corefunctions->timezoneChange($mnds['created_at'],"M d, Y") }} |
                                                                                {{ $corefunctions->timezoneChange($mnds['created_at'],'h:i A') }}
                                                                            </h5>
                                                                            @if(isset($mnds['is_soap_note']) && $mnds['is_soap_note'] == '1')
                                                                                <span class="badge bg-info primary">SOAP</span>
                                                                            @elseif(isset($mnds['video_scribe']) && $mnds['video_scribe'] == '1')
                                                                                <span class="ms-2 text-linear">BlackBag Scribe</span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-xl-7 col-xxl-6"> 
                                                                    @if(isset($userDetails[$mnds['created_by']]) && !empty($userDetails[$mnds['created_by']])  && $mnds['video_scribe'] != '1' )
                                                                        <div class="user_inner">
                                                                            <?php
                                                                                $profileimage = isset($userDetails[$mnds['created_by']]['user']) 
                                                                                    ? $corefunctions->resizeImageAWS($userDetails[$mnds['created_by']]['user']['id'], $userDetails[$mnds['created_by']]['user']['profile_image'], $userDetails[$mnds['created_by']]['user']['first_name'], 180, 180, '1') 
                                                                                    : $this->Corefunctions->resizeImageAWS($userDetails[$mnds['created_by']]['id'],$userDetails[$mnds['created_by']]['logo_path'],$userDetails[$mnds['created_by']]['name'],180,180,'2');
                                                                            ?>
                                                                            <img src="{{ $profileimage }}" alt="User">
                                                                            <p class="mb-0">{{ $corefunctions->showClinicanNameUser($userDetails[$mnds['created_by']], '0') }}</p>
                                                                        </div>
                                                                    @endif
                                                                    </div>
                                                                   
                                                                </div>
                                                            </div>
                                                            
                                                        </div>

                                                        <span class="material-symbols-outlined arrow-btn">keyboard_arrow_down</span>
                                                    </button>

                                                    <!-- Position the dropdown OUTSIDE the button but visually aligned using position-absolute -->
                                                    @if(isset($mnds['created_by']) && $mnds['created_by'] == Session::get('user.userID') && isset($mnds['video_scribe']) && ($mnds['video_scribe'] != '1') && $notesLocked == '0')
                                                        <div class="btn_alignbox accordion-action">
                                                            <a class="btn btn-opt opt-action" onclick="event.stopPropagation();" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <span class="material-symbols-outlined">more_vert</span>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end" onclick="event.stopPropagation();">
                                                                <li>
                                                                    <a href="javascript:void(0);" onclick="editNotes('{{ $mnds['medical_note_uuid'] }}','notes')" class="dropdown-item">
                                                                        <i class="fa-solid fa-pen me-2"></i><span>Edit</span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="javascript:void(0);" onclick="deleteSoapNotes('{{ $mnds['medical_note_uuid'] }}','notes')" class="dropdown-item">
                                                                        <i class="fa-solid fa-trash-can me-2"></i><span>Delete</span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </h2>



                                                    <!-- <h2 class="accordion-header" id="{{$headingId}}">
                                                        <button 
                                                        class="accordion-button collapsed fw-bold d-flex justify-content-between align-items-center  listsoapnotecls_{{$mnds['medical_note_uuid']}} " 
                                                        type="button" data-bs-toggle="collapse" data-bs-target="#{{$collapseId}}" aria-expanded="false" aria-controls="{{$collapseId}}"  onclick="openSoapNotes('{{$mnds['medical_note_uuid']}}','list')" >
                                                            <div class="row align-items-center collapse-header w-100">
                                                                <div class="col-12 col-lg-9">
                                                                    <div class="d-flex flex-row align-items-center gap-2">
                                                                        <h5 class="fw-medium mb-0"><?php echo $corefunctions->timezoneChange($mnds['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($mnds['created_at'],'h:i A') ?></h5>
                                                                        
                                                                        @if(isset($mnds['is_soap_note']) && $mnds['is_soap_note'] == '1' )
                                                                        <span class="badge bg-info primary">SOAP</span>
                                                                        @if(isset($userDetails[$mnds['created_by']]) && !empty($userDetails[$mnds['created_by']]))
                                                                        <div class="user_inner">
                                                                            <?php
                                                                         $profileimage = isset($userDetails[$mnds['created_by']]['user']) ? $corefunctions->resizeImageAWS($userDetails[$mnds['created_by']]['user']['id'], $userDetails[$mnds['created_by']]['user']['profile_image'], $userDetails[$mnds['created_by']]['user']['first_name'], 180, 180, '1') :  $this->Corefunctions->resizeImageAWS($userDetails[$mnds['created_by']]['id'],$userDetails[$mnds['created_by']]['logo_path'],$userDetails[$mnds['created_by']]['name'],180,180,'2');

                                                                            ?>
                                                                            <img src="{{$profileimage}}" alt="User">
                                                                            <p class="mb-0">{{ $corefunctions -> showClinicanNameUser($userDetails[$mnds['created_by']],'0')}}</p>
                                                                        </div>
                                                                        @endif
                                                                        @elseif(isset($mnds['video_scribe']) && $mnds['video_scribe'] == '1')
                                                                        <span class="ms-2 text-linear">BlackBag Scribe</span>
                                                                        @else
                                                                        @endif

                                                                        
                                                                    </div>
                                                                    
                                                                </div>


                                                                @if(isset($mnds['created_by']) && $mnds['created_by'] == Session::get('user.userID') && isset($mnds['is_soap_note']) && ($mnds['is_soap_note'] == '1') )
                                                                <div class="col-12 col-lg-3">
                                                                    <div class="btn_alignbox justify-content-end pe-3 mt-lg-0 mt-3">
                                                                        
                                                                        <a class="btn btn-opt opt-action" onclick="event.stopPropagation();" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <span class="material-symbols-outlined">more_vert</span>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end" onclick="event.stopPropagation();">
                                                                            <li>
                                                                                <a href="javascript:void(0);" onclick="editNotes('{{$mnds['medical_note_uuid']}}','notes')" class="dropdown-item">
                                                                                    <i class="fa-solid fa-pen me-2"></i><span>Edit</span>
                                                                                </a>
                                                                            </li>
                                                                            <li>
                                                                                <a href="javascript:void(0);" onclick="deleteSoapNotes('{{$mnds['medical_note_uuid']}}','notes')" class="dropdown-item">
                                                                                    <i class="fa-solid fa-trash-can me-2"></i><span>Delete</span>
                                                                                </a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                @endif


                                                            </div>                                               
                                                            <span class="material-symbols-outlined arrow-btn" > keyboard_arrow_down</span>
                                                        </button>
                                                    </h2> -->
                                                    <div id="{{$collapseId}}"  class="accordion-collapse collapse" aria-labelledby="{{$headingId}}" data-bs-parent="#accordionFlushExample1">
                                                        <div class="accordion-body" id="listappendsoapnotes_{{$mnds['medical_note_uuid']}}">
                                                            <!-- The patient, a 55-year-old male, reports experiencing fatigue and occasional dizziness over the past two weeks... -->
                                                        </div>
                                                    </div>
                                                </div>
                                            
                                                @endforeach
                                                @else
                                                <div class="no-data-box"> 
                                                    <p class="mb-0 align_middle"><span class="material-symbols-outlined primary">info</span>No records found!</p>
                                                </div>
                                                
                                                @endif
                                                <div class="col-12 mt-3">
                                                    <div class="row justify-content-end">
                                                        @if(!empty($medicalNotesArray))
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
                                                        <div class="col-md-6">
                                                            <div id="pagination-note">
                                                                {{ $medicalNotesArray->links('pagination::bootstrap-5') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                               

                                               
                                            </div>
                                        </div>


