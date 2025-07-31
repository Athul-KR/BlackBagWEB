
                <?php
                   $corefunctions = new \App\customclasses\Corefunctions;
                ?> 
                <div class="col-12 text-center text-md-end mb-xl-0 mb-md-3">
                  <div class="btn_alignbox justify-content-md-end flex-wrap">
                    <a class="btn filter-btn"  onclick="getFilter()" ><span class="material-symbols-outlined">filter_list</span>Filters</a>
                  </div>
                  <div id="patientfilter" class="collapse-filter">
                    <form id="search" method="GET">
                     
                        <div class="align_middle w-100 flex-md-row flex-column my-3">
                          <div class="form-group form-floating w-100">
                            <i class="fa-solid fa-user-tag"></i>
                            <select name="userType" id="userType" class="form-select" onchange="submitFilter();">
                              <option value="">Select User Type</option>
                              <option value="admin" @if(isset($userType) && $userType == 'admin') selected @endif>Admin</option>
                              <option value="clinician" @if(isset($userType) && $userType == 'clinician') selected @endif>Clinician</option>
                            
                            </select>
                            <label class="select-label">User Type</label>
                          </div>
                    
                          <div class="form-group form-outline w-100">
                            {{-- <label for="input" class="float-label">Search by user</label> --}}
                            <i class="material-symbols-outlined">search</i>
                            <input type="text" class="form-control" id="searchterm-tearm" placeholder="Search by user" name="searchterm" @if(isset($searchterm) && $searchterm !='') value="{{$searchterm}}" @endif>
                          </div>
                  
                          <div class="btn_alignbox">
                           
                            <button type="button" class="btn btn-outline-primary" onclick="clearFilter();">Clear All</button>
                          </div>
                        </div>
                    
                    </form>
                  </div>
                </div>

              
              

                <div class="col-lg-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                      <thead>
                        <tr>
                          <th style="width:25%">Clinician</th>
                          <th style="width:10%">Email</th>
                          <th style="width:15%">Phone Number</th>
                          <th style="width:10%">NPI Number</th>
                          <th style="width:15%">Working Hours</th>
                          <th class="text-end" style="width:5%">Actions</th>
                       
                        </tr>
                      </thead>
                      <tbody>
                      
                        @if($clinicUserData['data'])
                          @foreach($clinicUserData['data'] as $cus)
                          
                            <?php 
                              if($cus['user_type_id'] == '1' || $cus['user_type_id'] == '2'){
                                $url = url('user/'.$cus['clinic_user_uuid'].'/details');
                                  if($cus['status'] == '1'){
                                    $image = $corefunctions -> resizeImageAWS($cus['user_id'],$cus['profile_image'],$cus['first_name'],180,180,'1');
                                    $name = $corefunctions -> showClinicanName($cus,'1');
                                  }else{
                                      $image = $corefunctions -> resizeImageAWS($cus['id'],$cus['logo_path'],$cus['name'],180,180,'1');
                                      $name = $corefunctions -> showClinicanName($cus,'0');
                                  }
                              }else{
                                $url = url('user/'.$cus['clinic_user_uuid'].'/details');
                                   if($cus['status'] == '1'){
                                    $image = $corefunctions -> resizeImageAWS($cus['user_id'],$cus['profile_image'],$cus['first_name'],180,180,'1');
                                    $name = $cus['first_name'];
                                 }else{
                                      $image = $corefunctions -> resizeImageAWS($cus['id'],$cus['logo_path'],$cus['name'],180,180,'1');
                                     $name = $cus['name'];
                                }
                              }
                            ?>
                            <tr>
                              <td style="width:25%">
                              
                                <a class="primary"  @if($cus['deleted_at'] == '') onclick="tabContent('workinghours_details','{{$cus['clinic_user_uuid']}}')" @endif>
                                <div class="user_inner">
                                  <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                  <div class="user_info">
                                    <h6 class="primary fw-medium m-0">{{ $name }}</h6>
                                    <p class="m-0">@if(isset($cus['specialty_id']) && $cus['specialty_id'] != '') {{ $specialtyList[$cus['specialty_id']]['specialty_name'] }} @else -- @endif</p>
                                    @if($status == 'inactive' && isset($cus['account_deleted']) && $cus['account_deleted'] == '1')<p><span class="badge bg-danger text-dark">Deleted</span></p>@endif
                                  </div>
                                 
                                </div>
                                <a>
                              </td>
                              <td style="width:10%"><a class="primary"  @if($cus['deleted_at'] == '') href="{{ $url }}" @endif> {{$cus['email']}}<a></td>
                              <td style="width:15%"><a class="primary"  @if($cus['deleted_at'] == '') href="{{ $url }}" @endif> <?php $cleanPhoneNumber = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $cus['phone']); ?> {{ $cleanPhoneNumber }} <a></td>
                              <td style="width:10%">{{$cus['npi_number']}}</td>

                           
                              
                              <td style="width:15%">@if($cus['consultation_time_id'] !='') <img src="{{asset('images/verified.png')}}"> Added @else Not Added @endif </td>
                             
                            
                              
                              <td style="width:5%">
                                <div class="d-flex align-items-center justify-content-end">
                                  <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                   @if($cus['deleted_at'] == '')
                                    <li>
                                      <a onclick="tabContent('workinghours_details','{{$cus['clinic_user_uuid']}}')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-pen me-2"></i>Edit
                                      </a>
                                    </li>
                                    @endif

                                  
                                  </ul>
                                </div>
                               
                             
                              </td>
                            </tr>
                         
                          @endforeach
                        @else
                        <tr class="text-center">
                            <td colspan="8">
                                <div class="flex justify-center">
                                    <div class="text-center no-records-body">
                                        <img src="{{asset('images/nodata.png')}}"
                                            class=" h-auto">
                                        <p>No records found</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endif
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="col-12">
                  <div class="row">

                  @if(!empty($clinicUserData['data']))
                    <div class="col-lg-6">
                    <form method="GET" action="{{url('users/list/'.$status)}}" >
                      <div class="sort-sec">
                        <p class="me-2 mb-0">Displaying per page :</p>
                        <select class="form-select" aria-label="Default select example" name="limit" onchange="tabContent('workinghours')">
                          <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                          <option value="15" {{ $limit == 15 ? 'selected' : '' }}>15</option>
                          <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                         
                        </select>
                      </div>
                    </form>
                    </div>
                    @endif
                    <div class="col-lg-6">
                      <div id="pagination-links">
                        {{ $clinicUserList->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                    
                  </div>
                </div>



<script>
 
 $("#searchterm-tearm").bind("keypress", function(e) {
      // $('input, textarea').each(function () {
      //        toggleLabel(this);
      //   });
        if (e.keyCode == 13)
        {
            e.preventDefault();
            submitFilter();
        }
    });

  $(document).ready(function() {
   
    <?php if ((isset($_GET['userType']) && $_GET['userType'] != '') || (isset($_GET['searchterm']) && $_GET['searchterm'] != '')) { ?>
      $("#patientfilter").show();
      $("#patientfilter").addClass('show')
    <?php }else{ ?>
      $("#patientfilter").hide();
      $("#patientfilter").removeClass('show')
    <?php } ?>
  });
  

  function submitFilter(){
    var userType = $("#userType").val();
    var search = $("#searchterm-tearm").val();
    tabContent('workinghours','','',userType,search)

  }
  function clearFilter() {
    tabContent('workinghours');
  }


function getFilter() {                  
  if ($("#patientfilter").hasClass("show")) {
    $("#patientfilter").removeClass('show')
    $("#patientfilter").hide();
  }else{
    
    $("#patientfilter").show();
    $("#patientfilter").addClass('show')
  }
}

</script>

