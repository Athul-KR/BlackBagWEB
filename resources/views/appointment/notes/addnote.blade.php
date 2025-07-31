<div class="row">
                    <div class="col-xl-6 border-r order-1 order-xl-0">
                        <div class="d-flex justify-content-between mt-xl-0 mt-3 mb-4">
                            <h5 class="fw-medium">Appointment Summaries</h5>
                        </div>
                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        <div class="row">
                            <div class="outer-wrapper box-cnt-inner">
                                <div class="accordion accordion-flush" id="accordionFlushExample2">
                                    @if(!empty($medicalNoteList))
                                    @foreach($medicalNoteList  as $index => $mnd)
                                    @php
                                        $collapseId = "flush-collapse-add".$index;
                                        $headingId = "flush-heading-add".$index;
                                    @endphp
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="{{$headingId}}">
                                            <button onclick="openSoapNotes('{{$mnd['medical_note_uuid']}}')" class="accordion-button postion-relative collapsed soapnotecls_{{$mnd['medical_note_uuid']}}" type="button"  data-bs-toggle="collapse" data-bs-target="#{{$collapseId}}" aria-expanded="false" aria-controls="{{$collapseId}}">
                                                <div class="row align-items-center collapse-header w-100 g-3">

                                                  <div class="col-12 col-md-7"> 
                                                      <div class="align_middle justify-content-start flex-sm-row flex-column align-items-sm-center align-items-baseline">
                                                        <h5 class="fw-medium"><?php echo $corefunctions->timezoneChange($mnd['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($mnd['created_at'],'h:i A') ?> </h5>
                                                        @if(isset($mnd['is_soap_note']) && $mnd['is_soap_note'] == '1' )
                                                          <span class="badge bg-info primary">SOAP</span>
                                                          @elseif(isset($mnd['video_scribe']) && $mnd['video_scribe'] == '1')
                                                          <span class="ms-2 text-linear">BlackBag Scribe</span>
                                                        @endif
                                                      </div>
                                                  </div>
                                                  <div class="col-12 col-md-5"> 
                                                    @if(isset($userDetails[$mnd['created_by']]) && !empty($userDetails[$mnd['created_by']])  && $mnd['video_scribe'] != '1' )
                                                      <div class="user_inner">
                                                          <?php
                                                            $profileimage = isset($userDetails[$mnd['created_by']]['user']) 
                                                            ? $corefunctions->resizeImageAWS($userDetails[$mnd['created_by']]['user']['id'], $userDetails[$mnd['created_by']]['user']['profile_image'], $userDetails[$mnd['created_by']]['user']['first_name'], 180, 180, '1') 
                                                            : $this->Corefunctions->resizeImageAWS($userDetails[$mnd['created_by']]['id'],$userDetails[$mnd['created_by']]['logo_path'],$userDetails[$mnd['created_by']]['name'],180,180,'2');
                                                          ?>
                                                          <img src="{{ $profileimage }}" alt="User">
                                                          <p class="mb-0">{{ $corefunctions->showClinicanNameUser($userDetails[$mnd['created_by']], '0') }}</p>
                                                      </div>
                                                    @endif
                                                  </div>
                                                </div>  
                                                <span class="material-symbols-outlined arrow-btn position-absolute top-0 end-0"> keyboard_arrow_down</span>
                                            </button>
                                        </h2>
                                        <div id="{{$collapseId}}"  class="accordion-collapse collapse" aria-labelledby="{{$headingId}}" data-bs-parent="#accordionFlushExample2">
                                            <div class="accordion-body" id="appendsoapnotes_{{$mnd['medical_note_uuid']}}">

                                             
                                                  
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="no-data-box"> 
                                      <p class="mb-0 align_middle"><span class="material-symbols-outlined primary">info</span>No records found!</p>
                                  </div>
                                    @endif
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 order-0 order-xl-1">
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-medium">Add Practice Notes</h5>
                            <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                        </div>
                        <form method="POST" id="addnoteform" autocomplete="off">
                        @csrf
                        <div class="position-relative mb-3">
                            @if(isset($viewType) && $viewType != 'videocall')
                            <button class="material-symbols-outlined voice-mic border-0" id="recordButton" type="button">mic </button>
                            @endif
                           
                            <div class="form-group form-outline form-textarea mb-2">
                                <label for="input" class="float-label">Notes</label>
                                <i class="fa-solid fa-file-lines"></i>
                                
                                <textarea class="form-control" name="note" rows="16" cols="16" id="transcriptionBox">@if(isset($medicalNoteDetails) && !empty($medicalNoteDetails)){{ $medicalNoteDetails['summary'] }}@endif</textarea>
                                
                            </div>
                            <div class="btn_alignbox justify-content-end d-flex align-items-center gap-5">
                                <img src="{{asset('images/generating-via-ai.gif')}}" style="height:48px; vertical-align: middle;display:none; tex" alt="Loading" id="ailoading" />
                                <a onclick="getSummaryFromAI();" id="addbtnai" class="btn mt-2 btn-primary btn-align btn-sm">
                                    Create Soap Notes
                                </a>
                            </div>
                            
                        </div>
                        
                        <div class="error" id="errorMsg"></div>


                        <div class="outer-wrapper box-cnt-inner notes-collspe">
                          <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="heading-subjective">
                                <button class="accordion-button collapsed postion-relative" type="button" data-bs-toggle="collapse"
                                  data-bs-target="#collapse-subjective" aria-expanded="false" aria-controls="collapse-subjective">
                                  <div class="row align-items-center collapse-header w-100">
                                    <div class="col-12">
                                      <h5 class="fw-medium">Subjective</h5>
                                        <p class="mb-0" id="subjectivetext"></p>
                                    </div>
                                  </div>
                                  
                                  <span class="material-symbols-outlined arrow-btn position-absolute top-0 end-0">keyboard_arrow_down</span>
                                  
                                </button>
                              </h2>
                              <div id="collapse-subjective" class="accordion-collapse collapse" aria-labelledby="heading-subjective"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                  <div class="form-group form-outline form-textarea">
                                    <label for="subjective" class="float-label">Subjective</label>
                                    <i class="fa-solid fa-file-lines"></i>
                                    <textarea class="form-control" name="subjective" rows="4" id="subjective">@if(isset($medicalNoteDetails) && !empty($medicalNoteDetails)){{$medicalNoteDetails['subjective']}}@endif</textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="heading-objective">
                                <button class="accordion-button postion-relative collapsed" type="button" data-bs-toggle="collapse"
                                  data-bs-target="#collapse-objective" aria-expanded="false" aria-controls="collapse-objective">
                                  <div class="row align-items-center collapse-header w-100">
                                    <div class="col-12">
                                      <h5 class="fw-medium">Objective</h5>
                                         <p class="mb-0" id="objectivetext"></p>
                                    </div>
                                  </div>
                                  <span class="material-symbols-outlined arrow-btn position-absolute top-0 end-0">keyboard_arrow_down</span>
                                </button>
                              </h2>
                              <div id="collapse-objective" class="accordion-collapse collapse" aria-labelledby="heading-objective"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                  <div class="form-group form-outline form-textarea">
                                    <label for="objective" class="float-label">Objective</label>
                                    <i class="fa-solid fa-file-lines"></i>
                                    <textarea class="form-control" name="objective" rows="4" id="objective">@if(isset($medicalNoteDetails) && !empty($medicalNoteDetails)){{$medicalNoteDetails['objective']}}@endif</textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="heading-assessment">
                                <button class="accordion-button postion-relative collapsed" type="button" data-bs-toggle="collapse"
                                  data-bs-target="#collapse-assessment" aria-expanded="false" aria-controls="collapse-assessment">
                                  <div class="row align-items-center collapse-header w-100">
                                    <div class="col-12">
                                      <h5 class="fw-medium">Assessment</h5>
                                         <p class="mb-0" id="assessmenttext"></p>
                                    </div>
                                  </div>
                                  <span class="material-symbols-outlined arrow-btn position-absolute top-0 end-0">keyboard_arrow_down</span>
                                </button>
                              </h2>
                              <div id="collapse-assessment" class="accordion-collapse collapse" aria-labelledby="heading-assessment"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                  <div class="form-group form-outline form-textarea">
                                    <label for="assessment" class="float-label">Assessment</label>
                                    <i class="fa-solid fa-file-lines"></i>
                                    <textarea class="form-control" name="assessment" rows="4" id="assessment">@if(isset($medicalNoteDetails) && !empty($medicalNoteDetails)){{$medicalNoteDetails['assessment']}}@endif</textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="accordion-item">
                              <h2 class="accordion-header" id="heading-plan">
                                <button class="accordion-button postion-relative collapsed" type="button" data-bs-toggle="collapse"
                                  data-bs-target="#collapse-plan" aria-expanded="false" aria-controls="collapse-plan">
                                  <div class="row align-items-center collapse-header w-100">
                                    <div class="col-12">
                                      <h5 class="fw-medium">Plan</h5>
                                         <p class="mb-0" id="plantext"></p>
                                    </div>
                                  </div>
                                  <span class="material-symbols-outlined arrow-btn position-absolute top-0 end-0">keyboard_arrow_down</span>
                                </button>
                              </h2>
                              <div id="collapse-plan" class="accordion-collapse collapse" aria-labelledby="heading-plan"
                                data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body">
                                  <div class="form-group form-outline form-textarea">
                                    <label for="plan" class="float-label">Plan</label>
                                    <i class="fa-solid fa-file-lines"></i>
                                    <textarea class="form-control" name="plan" rows="4" id="plan">@if(isset($medicalNoteDetails) && !empty($medicalNoteDetails)){{ $medicalNoteDetails['plan'] }}@endif</textarea>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        

                        <input type="hidden" class="form-control"  id="is_soap_note" name="is_soap_note" @if(isset($medicalNoteDetails) && !empty($medicalNoteDetails)  && $medicalNoteDetails['is_soap_note'] == '1' )  value="1" @else value="0" @endif> 
                        <input type="hidden" class="form-control"  id="icd10_code_values" name="icd10_code_values"> 
                        <input type="hidden" class="form-control"  id="appointment_id" name="appointment_id" value="{{$appointment_id}}"> 
                        
                        <div class="d-flex flex-column gap-2">
                            <label for="input" class="mt-3" id="icd10codesid"  @if(isset($icd10Codes) && !empty($icd10Codes)) style="display:block;" @else style="display:none;" @endif>ICD-10 Codes</label>
                            <div id="icd10codes" class="d-flex flex-wrap gap-2">

                                    @if(isset($icd10Codes) && !empty($icd10Codes))
                                        @foreach($icd10Codes as $code)
                                        
                                            <span class="align_middle badge rounded-pill bg-dark px-3 py-2 icdcls_{{$code['icdcode']}}" data-bs-toggle="tooltip" title="{{$code['title']}}" data-bs-original-title="{{$code['title']}}">{{$code['icdcode']}}
                                              <a type="button" class="remove-condition" onclick="removeIcdCode('{{$code['icdcode']}}')">
                                                <span class="material-symbols-outlined danger">close</span>
                                                </a>
                                            </span>
                                            <input type="hidden" value="{{ $code['id'] }}" class="icdcls_{{$code['icdcode']}}" name="exisicdcode[{{$code['id']}}][icd]">  

                                        @endforeach
                                    @endif
                            </div>
                          
                        </div>
                        
                        <div class="form-check d-flex align-items-center gap-2 mt-4">
                            <input class="form-check-input mt-0" type="checkbox" id="allowPatient" name="allowPatient" @if(isset($medicalNoteDetails) && !empty($medicalNoteDetails) && $medicalNoteDetails['show_to_patient'] == '1') checked @endif>
                            <label class="form-check-label" for="allowPatient">
                                <p class="fw-medium primary mb-0">Allow patient to view this notes</p>
                            </label>
                        </div>

                        </form>
                        <div class="btn_alignbox mt-4 mb-lg-0 mb-4">
                            @if(isset($medicalNoteDetails) && !empty($medicalNoteDetails))
                              <button type="button" class="btn btn-primary w-100"  id="updatebtn" onclick="updateNotes('{{$medicalNoteDetails['medical_note_uuid']}}');" >Update Notes</button>
                            @else
                            <button type="button" class="btn btn-primary w-100"  id="addbtn" onclick="saveNotes();" >Save Notes</button>
                            @endif
                        </div>
                      
                    </div>
                </div>


<script type="module">
  import {
    TranscribeStreamingClient,
    StartMedicalStreamTranscriptionCommand
  } from "https://cdn.jsdelivr.net/npm/@aws-sdk/client-transcribe-streaming@3.651.1/+esm";

  let isRecording = false;
  let audioContext, source, processor, stream;
  let audioQueue = [];
  let isStreaming = false;
  let client;

  let transcription = '';
  const recordBtn = document.getElementById('recordButton');
  const transcriptionBox = document.getElementById('transcriptionBox');
  const errorMsg = document.getElementById('errorMsg');

  async function initAWS() {
    const accessKeyId = @json(env('AWS_ACCESS_KEY_PRIVATE_ID_SCRIBE'));
    const secretAccessKey = @json(env('AWS_SECRET_PRIVATE_ACCESS_KEY_SCRIBE'));
    const region = @json(env('AWS_DEFAULT_REGION'));

    client = new TranscribeStreamingClient({
      region,
      credentials: {
        accessKeyId,
        secretAccessKey
      }
    });
  }

  async function startRecording() {
    if (!client) {
      errorMsg.textContent = 'AWS client not initialized';
      return;
    }

    stream = await navigator.mediaDevices.getUserMedia({ audio: true });
    audioContext = new AudioContext({ sampleRate: 16000 });
    source = audioContext.createMediaStreamSource(stream);
    processor = audioContext.createScriptProcessor(1024, 1, 1);

    source.connect(processor);
    processor.connect(audioContext.destination);

    isStreaming = true;
    audioQueue = [];

    processor.onaudioprocess = async e => {
      const inputBuffer = e.inputBuffer;

      const newBuffer = await resampleTo16kHz(inputBuffer);
      const resampledData = newBuffer.getChannelData(0);

      const pcmData = new Int16Array(resampledData.length);
      for (let i = 0; i < resampledData.length; i++) {
        pcmData[i] = Math.max(-32768, Math.min(32767, resampledData[i] * 32767));
      }

      audioQueue.push(new Uint8Array(pcmData.buffer));
    };

    recordBtn.classList.add('audiostartcls');

    // Optional: separate sessions visually
   // transcriptionBox.textContent += '\n--- New Session ---\n';

    startTranscribeStream();
  }

  async function resampleTo16kHz(audioBuffer) {
    const offlineCtx = new OfflineAudioContext(1, 16000 * audioBuffer.duration, 16000);
    const source = offlineCtx.createBufferSource();
    source.buffer = audioBuffer;
    source.connect(offlineCtx.destination);
    source.start(0);
    return await offlineCtx.startRendering();
  }

 async function startTranscribeStream() {
  try {
    const command = new StartMedicalStreamTranscriptionCommand({
      LanguageCode: "en-US",
      MediaEncoding: "pcm",
      MediaSampleRateHertz: 16000,
      Specialty: "PRIMARYCARE",
      Type: "DICTATION",
      AudioStream: {
        async *[Symbol.asyncIterator]() {
          while (isStreaming) {
            if (audioQueue.length > 0) {
              const chunk = audioQueue.shift();
              yield { AudioEvent: { AudioChunk: chunk } };
            } else {
              await new Promise(resolve => setTimeout(resolve, 10));
            }
          }
        }
      }
    });

    const response = await client.send(command);

    if (response.TranscriptResultStream) {
      for await (const event of response.TranscriptResultStream) {
        if (!isStreaming) break;

        const transcript = event.TranscriptEvent?.Transcript;
        if (transcript?.Results?.length > 0) {
          const result = transcript.Results[0];
          const currentText = $('#transcriptionBox').val() || '';

          if (result.IsPartial) {
            const partial = result.Alternatives[0]?.Transcript;
            if (partial) {
              setTranscription(`${currentText} ${partial}`.trim());
            }
          } else {
            const final = result.Alternatives[0]?.Transcript;
            if (final) {
              const newText = `${currentText} ${final}`.trim();
              setTranscription(newText);
            }
          }
        }
      }
    }
  } catch (err) {
    errorMsg.textContent = 'AWS Transcribe error: ' + err.message;
    stopRecording();
  }
}


  const setTranscription = (text) => {
    if (text && text !== transcription) {
      transcription = text;
        $('#transcriptionBox').val(transcription);
        $('input, textarea').each(function () {
              if ($(this).val()) {
                $(this).siblings('label').addClass('active');
              }
            });
        // Focus and move cursor to end of textarea
    const $textarea = $('#transcriptionBox'); // Change selector as needed
    
    // Move cursor to end
    const el = $textarea[0];
    el.focus();
    const len = el.value.length;
    el.setSelectionRange(len, len);

    // Scroll to caret
    el.scrollTop = el.scrollHeight;
    }
  };

  function stopRecording() {
    isStreaming = false;
    recordBtn.classList.remove('audiostartcls');

    if (processor) {
      processor.disconnect();
      processor = null;
    }
    if (source) {
      source.disconnect();
      source = null;
    }
    if (audioContext) {
      audioContext.close();
      audioContext = null;
    }
    if (stream) {
      stream.getTracks().forEach(t => t.stop());
      stream = null;
    }
  }

  recordBtn.onclick = () => {
    if (!isRecording) {
      isRecording = true;
      initAWS().then(startRecording);
    } else {
      isRecording = false;
      stopRecording();
    }
  };
</script>
<script>
function removeIcdCode(icd){
  $('.icdcls_'+icd).remove();
}
function removeIcd10Code(icd) {
    

    // Remove the badge from the DOM
    $('.icdcls_' + icd.replace(/\./g, '\\.')).remove();

    // Get current comma-separated string and split into array
    let codeArray = $('#icd10_code_values').val().split(',');

    // Remove the ICD code from the array
    codeArray = codeArray.filter(code => code.trim() !== icd);

    // Update the hidden input with the new comma-separated string
    $('#icd10_code_values').val(codeArray.join(','));
}


function getSummaryFromAI(){
     if($("#addnoteform").valid()){
         $("#summaryGenerate").val('1');
         $('#ailoading').show();
         $("#addbtnai").addClass('disabled');
            $.ajax({
               url: '{{ url("/notes/getsummary") }}',
               type: "post",
               data: {
                  'notes' : $('#transcriptionBox').val(),
                 '_token': $('meta[name="csrf-token"]').attr('content')
               },
               success: function(data) {
                 if (data.success == 1) {
                     $('#icd10codes').html(data.icd10code);
                     $('#assessment').val(data.assessment).trigger('textarea');
                     $('#objective').val(data.objective).trigger('textarea');
                     $('#plan').val(data.plan).trigger('textarea');
                     $('#subjective').val(data.subjective).trigger('textarea');
                     $('#icd10_code_values').val(data.icd10CodeValues);
                     $('#is_soap_note').val('1');
                     let firstsubjectiveWords = data.subjective.split(/\s+/).slice(0, 10).join(' ');
                     let firstassessmentWords = data.assessment.split(/\s+/).slice(0, 10).join(' ');
                     let firstobjectiveWords = data.objective.split(/\s+/).slice(0, 10).join(' ');
                     let firstplanWords = data.plan.split(/\s+/).slice(0, 10).join(' ');
                     $('#subjectivetext').html(firstsubjectiveWords+'..');
                     $('#objectivetext').html(firstobjectiveWords+'..');
                     $('#assessmenttext').html(firstassessmentWords+'..');
                     $('#plantext').html(firstplanWords+'..');
                     $('[data-bs-toggle="tooltip"]').tooltip();
                     $('#ailoading').hide();
                     $('#icd10codesid').show();
                     $('input, textarea').each(function () {
                      if ($(this).val()) {
                        $(this).siblings('label').addClass('active');
                      }
                    });
                  
                   $("#addbtnai").removeClass('disabled');

                 } else {
                  swal("error!", data.errormsg, "error");
                 }
               },
               error: function(xhr) {

                handleError(xhr);
                }
             });
        }
}
     $(document).ready(function() {
          $("#addnoteform").validate({
                  ignore: [],
                  rules: {
                      note : {
                          required: true,
                          noWhitespace: true,
                          minlength: 1
                      },

                      },

                  messages: {
                      note :{
                          required : "Please enter a note",
                          noWhitespace: "Please enter a valid note",
                          minlength: "Please enter a valid note"
                      },

                  },
                  errorPlacement: function(error, element) {

                          error.insertAfter(element); // Place error messages after the input fields

                  }
              });
              jQuery.validator.addMethod("noWhitespace", function(value, element) {
                return $.trim(value).length > 0;
              }, "This field is required.");



          });




</script>