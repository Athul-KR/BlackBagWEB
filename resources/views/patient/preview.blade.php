

                          
            <div class="web-card h-100 mb-3 overflow-hidden">

                    <div class="row align-items-end h-100">
                        
                              
                    
                    <div class="table-responsive">
                    <table class="table table-white text-start w-100">
                      <thead>
                          <tr>
                             
                              <th>Name</th>
                              <th>Email</th>
                              <th>Gender</th>
                              <th>Date Of Birth</th>
                              <th>Address</th>
                              <th>Phone Number</th>
                              <th>Whatsapp Number</th>
                              <!-- <th>Note</th>   -->
                              <th></th>
                              <th class="text-end"></th>  
                              
                          </tr>
                      </thead>
                      <tbody>
                          
                          @if($excelDetails)
                          @foreach($excelDetails as $index =>  $pads)
                            <tr id="rmv_doc_{{$pads['import_doc_uuid']}}" class="rmv_doc_{{$pads['import_doc_uuid']}}">  
                            
                              <td>{{ $pads['name'] }}</td>
                              <td >{{ $pads['email'] }}</td>
                              <td>{{ $pads['gender'] }}</td>
                              <td>{{date('m/d/Y', strtotime($pads['dob']))}}</td>
                              <td>{{ $pads['address'] }} <p> {{ $pads['city'] }}, {{ $pads['state'] }} {{ $pads['zip'] }}</p></td>
                              <td>@if(isset($countryCodeDetails[$pads['country_code']])) {{ $countryCodeDetails[$pads['country_code']]['country_code'] }} @endif {{ $pads['phone_number'] }}</td>
                              <td>@if(isset($whatsappcountryCodedetails[$pads['whatsapp_country_code']])) {{ $whatsappcountryCodedetails[$pads['whatsapp_country_code']]['country_code'] }} @endif {{ $pads['whatsapp_number'] }}</td>
                              <!-- <td>@if(isset($pads['notes']) ) {{ $pads['notes'] }} @else -- @endif</td> -->
                               <input type="hidden" id="{{$pads['import_doc_uuid']}}_notesget" value ="<?php echo $pads['notes'] ?>" >
                              <!-- <td>@if(isset($pads['notes']) ) <a onclick="viewNotes('{{$pads['import_doc_uuid']}}')" class="note-link"><i class="fa-regular fa-comment-dots"></i></a> @else -- @endif </td> -->

                              @if(isset($pads['error']) && $pads['error'] !='')
                                <td class="error-info">  Error </td> 
                              @else
                                <td class="success-info is_success">  Success </td> 
                              @endif
                              <td class="text-end"><a class="danger" href="javascript:void(0);" id="removedoc"  onclick="removeDocument('{{$pads['import_doc_uuid']}}')"><span class="material-symbols-outlined">delete</span></a></td>
                                
                            </tr>
                            @if(isset($pads['is_exists']) && $pads['is_exists'] =='1')
                            <tr>
                                <td colspan="10" class="table-note p-0">
                                  <p> Some of the fields seem to be different from already existing data </p> <a onclick="viewDetails('{{$pads['import_doc_uuid']}}')" href="javascript:void(0);">View</a>
                                </td>
                            </tr>
                            @endif
                            @if(isset($pads['error']) && $pads['error'] !='')
                            <tr class="rmv_doc_{{$pads['import_doc_uuid']}}">
                              <td colspan="10" class="table-note p-0">
                                 <p> <?php echo $pads['error'] ?></p> <input type="hidden" class="is_error" name="is_error" value="1">
                              </td>
                            </tr>
                            @endif   
                          @endforeach
                          @endif
                         
                          <tr class="text-center" id="norecodrspreview" @if(!empty($excelDetails)) style="display: none;" @endif>
                                <td colspan="8">
                                    <div class="flex justify-center">
                                        <div class="text-center  no-records-body">
                                            <img src="{{asset('images/nodata.png')}}"
                                                class=" h-auto">
                                            <p>No records found</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                           
                        
                        </tbody>
                      </table>
                    </div>

                    <div class="btn_alignbox justify-content-end mt-4">
                      @if(!empty($excelDetails))
                        <a class="btn btn-primary" id="submit-btn" onclick="importPatient()" >Continue</a>
                      @endif
                    </div>

                    </div>
                
            </div>
      <div class="modal fade" id="patientNotes" tabindex="-1" aria-labelledby="patientNotesLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="text-center">
                <!-- <h4 class="fw-bold mb-0" id="patientNotesLabel"> Notes</h4> -->
              </div>
              <h5>Notes</h5>
              <p id="patientNotesModal">

              </p>
              <div class="btn_alignbox justify-content-end mt-4">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>

<script>
  function viewNotes(key){
    $("#patientNotes").modal('show');
    var notes = $("#"+key+"_notesget").val();
    $("#patientNotesModal").html(notes.replace(/\n/g, '<br>'));
  }

function importPatient() {
    var importKey = '{{$importKey}}' ;
    let iserrorRecords = $('.is_error').val();
    if(iserrorRecords !='1'){
      
      $("#submit-btn").addClass('disabled');
        $.ajax({
            url: '{{ url("/patients/import/store") }}',
            type: "post",
            data: {
              'importKey' : importKey,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                swal({
                  icon: 'success',
                  text: data.message,
                });
                window.location.href = "{{url('patients/list/pending')}}" ;
              } else {
                swal({
                  icon: 'error',
                  text: data.message,
                });
              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
      });
    }else{
      swal({
          icon: 'error',
          text: 'To proceed, please remove the row entries with invalid details',
        });
    }
   
  }
  function removeDocument(importKey) {
   
        $.ajax({
            url: '{{ url("/patients/import/delete") }}',
            type: "post",
            data: {
              'importKey' : importKey,
              '_token'    : $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                $('.rmv_doc_'+importKey).remove();
                if( $('.is_error').length == 0 && ($('.is_success').length  == 0)) {
                  $('.is_error').val(0);
                  $("#norecodrspreview").show();
                  $("#submit-btn").addClass('disabled');
                 
                }
                swal({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000 // Closes after 2 seconds
                }).then(() => {
                  if( $('.is_error').length == 0 && $('.is_success').length  == 0){
                    window.location.href = "{{url('/patients')}}";
                  }
                    // window.location.reload();
                });

                
              } else {
                swal({
                  icon: 'error',
                  text: data.message,
                });
              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
      });
  }




  </script>
