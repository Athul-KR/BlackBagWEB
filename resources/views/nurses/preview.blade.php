

                          
            <div class="web-card h-100 mb-3 overflow-hidden">
              
                    <div class="row align-items-end h-100">
                        
                              
                    
                    <div class="table-responsive">
                    <table class="table table-white text-start w-100">
                      <thead>
                          <tr>
                          <th style="width:10%">Name</th>
                          <th style="width:10%">Email</th>
                          <th style="width:15%">Department</th>
                          <th style="width:10%">Specialty</th>
                          <th style="width:10%">Qualification</th>
                          <th style="width:10%">Country Code</th>
                          <th style="width:10%">Phone</th>
                          <th style="width:25%">Status</th>
                          <th class="text-end"></th>  
                              
                          </tr>
                      </thead>
                      <tbody>
                        
                          @if($excelDetails)
                          @foreach($excelDetails as $index =>  $doct)
                        
                            <tr id="rmv_doc_{{$doct['import_doc_uuid']}}" class="rmv_doc_{{$doct['import_doc_uuid']}}">  
                            
                              <td>{{ $doct['name'] }}</td>
                              <td >{{ $doct['email'] }}</td>
                              <td style="width:15%">{{ $doct['department'] }}</td>
                              <td style="width:10%">@if(isset($specialtyDetails[$doct['specialty_id']]) && (!empty($specialtyDetails[$doct['specialty_id']])) ) {{$specialtyDetails[$doct['specialty_id']]['specialty_name']}} @else -- @endif</td>
                              <td style="width:10%">{{ $doct['qualification'] }}</td>
                              <td>@if(isset($countryCodeDetails[$doct['country_code']])) {{ $countryCodeDetails[$doct['country_code']]['country_code'] }} @endif</td>
                              <td>{{ $doct['phone_number'] }}</td>
                              @if(isset($doct['error']) && $doct['error'] !='')
                                <td class="error-info">  Error </td> 
                              @else
                                <td class="success-info ">  Success </td> 
                              @endif
                              <td class="text-end"><a class="danger" href="javascript:void(0);" id="removedoc"  onclick="removeDocument('{{$doct['import_doc_uuid']}}')"><span class="material-symbols-outlined">delete</span></a></td>
                                
                            </tr>
                            @if(isset($doct['is_exists']) && $doct['is_exists'] =='1')
                            <tr>
                                <td colspan="8" class="table-note p-0">
                                  <p> Some of the fields seem to be different from already existing data </p> <a onclick="viewDetails('{{$doct['import_doc_uuid']}}')" href="javascript:void(0);">View</a>
                                </td>
                            </tr>
                            @endif
                            @if(isset($doct['error']) && $doct['error'] !='')
                            <tr class="rmv_doc_{{$doct['import_doc_uuid']}}">
                              <td colspan="8" class="table-note p-0">
                                 <p> <?php echo $doct['error'] ?></p> <input type="hidden" class="is_error" name="is_error" value="1">
                              </td>
                            </tr>
                            @endif   
                          @endforeach
                          @endif

                        
                        </tbody>
                      </table>
                    </div>

                    <div class="btn_alignbox justify-content-end mt-4">
                      @if(!empty($excelDetails))
                        <a class="btn btn-primary" id="submit-btn" onclick="importDoctors()">Continue</a>
                      @endif
                    </div>

                    </div>
              
            </div>
      


