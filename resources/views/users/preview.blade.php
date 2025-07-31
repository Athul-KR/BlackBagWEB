<div class="web-card h-100 mb-3 overflow-hidden">

    <div class="table-responsive">
      <table class="table table-white text-start w-100">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone Number</th>
            @if($userType == 'nurse')
            <th>Department</th>
            @else
            <th>Designation</th>
            @endif
            <th>Specialty</th>
            <th>Status</th>  
            <th class="text-end"></th>                   
          </tr>
        </thead>
        <tbody>
          @if($excelDetails)
            @foreach($excelDetails as $index =>  $doct)
              <tr id="rmv_doc_{{$doct['import_doc_uuid']}}" class="rmv_doc_{{$doct['import_doc_uuid']}} remvdoccls" >  
                <td>{{ $doct['name'] }}</td>
                <td >{{ $doct['email'] }}</td>
                <td>@if(isset($countryCodedetails[$doct['country_code']])) {{ $countryCodedetails[$doct['country_code']]['country_code'] }} @endif{{ $doct['phone_number'] }}</td>
                @if($userType == 'nurse')
                <td>{{ $doct['department'] }}</td>
                @else
                <td>@if(isset($designationDeatils[$doct['designation_id']]) && (!empty($designationDeatils[$doct['designation_id']])) ) {{$designationDeatils[$doct['designation_id']]['name']}} @else -- @endif</td>
                @endif
               
                <td>@if(isset($specialtyDetails[$doct['specialty_id']]) && (!empty($specialtyDetails[$doct['specialty_id']])) ) {{$specialtyDetails[$doct['specialty_id']]['specialty_name']}} @else -- @endif</td>
                @if(isset($doct['error']) && $doct['error'] !='')
                  <td class="error-info">Invalid</td> 
                @else
                  <td class="success-info ">Success</td> 
                @endif
                <td class="text-end"><a class="danger" href="javascript:void(0);"   onclick="removeDocument('{{$doct['import_doc_uuid']}}')"><span class="material-symbols-outlined">delete</span></a></td>          
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
          <tr>
            <td colspan="8" class="text-center">
              <div class="text-center no-records-body" @if(empty($excelDetails)) style="display:block;" @else style="display:none;" @endif>
                  <img src="{{asset('images/nodata.png')}}"
                      class=" h-auto">
                  <p>No records found</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="btn_alignbox justify-content-end mt-4">
      <a class="btn btn-primary" id="submit-btn" onclick="importUsers()" @if(empty($excelDetails)) style="display:none;" @else style="display:block;" @endif>Continue</a>
    </div>
 
</div>
      


