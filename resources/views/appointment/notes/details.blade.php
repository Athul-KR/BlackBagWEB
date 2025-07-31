
                @if(!empty($medicalNoteDetails))

                <ul class="nav nav-pills gap-2 d-flex" id="{{$type}}pills-tab-{{$medicalNoteDetails['medical_note_uuid']}}" role="tablist">
                    @foreach($tabs as $index => $tab)
                        <li class="nav-item" role="presentation">
                            <button class="nav-link d-flex align-items-center gap-1 @if(!empty($tab['active'])) active @endif" id="{{$type}}pills-{{ $tab['id'] }}-tab-{{$medicalNoteDetails['medical_note_uuid']}}" data-bs-toggle="pill" data-bs-target="#{{$type}}pills-{{ $tab['id'] }}-{{$medicalNoteDetails['medical_note_uuid']}}" type="button" role="tab" aria-controls="{{$type}}pills-{{ $tab['id'] }}-{{$medicalNoteDetails['medical_note_uuid']}}" aria-selected="{{ !empty($tab['active']) ? 'true' : 'false' }}">
                                <span class="material-symbols-outlined">{{ $tab['icon'] }}</span> {{ $tab['label'] }}
                            </button>
                        </li>
                    @endforeach
                </ul>

                <div class="tab-content mt-3" id="{{$type}}pills-tabContent-{{$medicalNoteDetails['medical_note_uuid']}}">
                    @foreach($tabs as $tab)
                        <div 
                            class="tab-pane fade @if(!empty($tab['active'])) show active @endif" 
                            id="{{$type}}pills-{{ $tab['id'] }}-{{$medicalNoteDetails['medical_note_uuid']}}" 
                            role="tabpanel" 
                            aria-labelledby="{{$type}}pills-{{ $tab['id'] }}-tab-{{$medicalNoteDetails['medical_note_uuid']}}">

                            <p class="mt-3 mb-0">
                                @php
                                    $fieldMap = [
                                        'summary' => 'summary',
                                        'transcription-subjective' => 'subjective',
                                        'transcription-objective' => 'objective',
                                        'transcription-assessment' => 'assessment',
                                        'transcription-plan' => 'plan',
                                        'transcription-icd10' => 'icd10',
                                        'transcription' => 'transcription',
                                    ];
                                    $field = $fieldMap[$tab['id']] ?? null;
                                @endphp

                                @if($tab['label'] == 'ICD 10')
                                    @if(isset($icd10Codes) && !empty($icd10Codes))
                                        @foreach($icd10Codes as $code)
                                            <span class="badge rounded-pill bg-dark px-3 py-2" data-bs-toggle="tooltip" title="" data-bs-original-title="{{$code['title']}}">{{$code['icdcode']}}</span>
                                        @endforeach
                                    @else

                                    <div class="flex justify-center no-records">
                                        <div class="text-center  no-records-body">
                                            <img  src="{{asset('images/nodata.png')}}"
                                                class=" h-auto" alt="no records">
                                            <p class="fw-medium">No data available.</p>
                                        </div>
                                    </div>


                                    @endif
                                 @else
                                 @if ($field && trim($medicalNoteDetails[$field]) != '') <?php echo nl2br(e($medicalNoteDetails[$field])) ?>
                                    @else 

                                    <div class="flex justify-center no-records">
                                        <div class="text-center  no-records-body">
                                            <img src="{{asset('images/nodata.png')}}"
                                                class=" h-auto" alt="no records">
                                            <p class="fw-medium">No data available.</p>
                                        </div>
                                    </div>


                                    @endif

                                 @endif
                               
                            </p>
                        </div>
                    @endforeach
                </div>

                @endif

            


                    