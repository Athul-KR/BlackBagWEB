@extends('layouts.app')
@section('title', 'Doctors')
@section('content')

<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row">
                <div class="col-sm-5 text-center text-sm-start">
                  <h4 class="mb-md-0">Doctors</h4>
                </div>
                <?php
                   $corefunctions = new \App\customclasses\Corefunctions;
                  $isPermission = $corefunctions->checkPermission() ;
                                
                 ?> 
                <div class="col-sm-7 text-center text-sm-end">
                  <div class="btn_alignbox justify-content-sm-end">
         
                   @if($isPermission == 1)
                    <a onclick="addDoctor()" href="javascript:void(0)" class="btn btn-primary btn-align">
                      <span class="material-symbols-outlined">add</span>Add Doctor
                    </a>
                    @endif
                    <a class="btn filter-btn" onclick="getFilter()" href="javascript:void(0)" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="material-symbols-outlined">filter_list</span>Filters
                    </a>
                    
                  </div>
               
                    <div id="filterlist" @if( (isset($_GET['designation']) ) || (isset($_GET['status']))  ) style="display: block;" @else style="display: none;" @endif>
                      <form id="search" method="GET">
                        <div id="fliteritems"  class="row collapse-filter mt-2 justify-content-end text-start @if( (isset($_GET['designation']) ) || (isset($_GET['status']))  ) show @endif">
                          <div class="col-xl-3 col-6"> 
                            <label for="input">Designation</label>
                            <select name="designation" id="designation" class="form-select" onchange="filterBy()">
                              <option value="all">Select</option>
                              @if(!empty($designations))
                                @foreach($designations as $dgn)
                                @if(isset($dgn))
                                  <option value="{{$dgn['designation_uuid']}}" @if(  (isset($_GET['designation']))  && ( $_GET['designation'] == $dgn['designation_uuid'] ) ) selected @endif>{{$dgn['name']}}</option>
                                 @endif
                                  @endforeach
                              @endif
                            </select>
                          </div>
                          <div class="col-xl-3 col-6"> 
                            <label for="input">Status</label>
                            <select name="status" id="status" class="form-select" onchange="filterBy()">
                              <option value="all">Select</option>
                              <option value="online" @if( (isset($_GET['status']) ) && $_GET['status']==  'online' ) selected @endif>Available</option>
                              <option value="offline" @if( (isset($_GET['status']) ) && $_GET['status']==  'offline' ) selected @endif >Not Available</option>
                            </select>
                          </div>
                        </div>
                      </form>
                    </div>

                  
                </div>
                <div class="col-12">
                  <div class="tab_box">
                  
                      <a href="{{url('doctors/list/pending')}}{{$filterParams}}" class="btn btn-tab @if($status == 'pending') active @endif">Pending ({{$pendingCount}})</a>
                      <a href="{{url('doctors/list/active')}}{{$filterParams}}" class="btn btn-tab @if($status == 'active') active @endif">Active ({{$activecount}})</a>
                      <a href="{{url('doctors/list/inactive')}}{{$filterParams}}" class="btn btn-tab @if($status == 'inactive') active @endif">Inactive ({{$innactiveCount}})</a>
                  </div>
              </div>
                <div class="col-lg-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                      <thead>
                        <tr>
                          <th style="width:20%">Doctor</th>
                          <th style="width:15%">Phone Number</th>
                          <th style="width:10%">Designation</th>
                          <th style="width:20%">Specialties</th>
                          <th style="width:20%">Qualifications</th>
                          @if($status != 'inactive')
                          <th style="width:10%">Status</th>
                          @endif
                          @if($isPermission == 1)
                          <th class="text-end" style="width:5%">Actions</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                      
                        @if($doctorData['data'])
                          @foreach($doctorData['data'] as $doct)
                      
                            <tr>
                              <td style="width:20%">
                              <?php
                                if($doct['logo_path'] !=''){
                                  $doct['logo_path'] = ( $doct['logo_path'] != '' ) ? $corefunctions->getAWSFilePath($doct['logo_path']) : '';
                                }
                              ?>
                              
                                <a class="primary"  @if($doct['deleted_at'] == '') href="{{ url('doctor/'.$doct['clinic_user_uuid'].'/details') }}" @endif>
                                <div class="user_inner">
                                  <img @if($doct['logo_path'] !='') src="{{($doct['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif >
                                  <div class="user_info">
                                    <h6 class="primary fw-medium m-0">{{ $doct['name'] }}</h6>
                                    <p class="m-0">{{ $doct['email'] }}</p>
                                  </div>
                                 
                                </div>
                                <a>
                              </td>
                              <td style="width:15%"><a class="primary"  @if($doct['deleted_at'] == '') href="{{ url('doctors/'.$doct['clinic_user_uuid'].'/details') }}" @endif> @if(isset($countryCode[$doct['country_code']]['country_code'])) {{$countryCode[$doct['country_code']]['country_code']}} @else  @endif {{ $doct['phone_number'] }} <a></td>

                              <td style="width:10%">
                              <a class="primary" @if($doct['deleted_at'] == '') href="{{ url('doctor/'.$doct['clinic_user_uuid'].'/details') }}" @endif >
                                @if(isset($designations[$doct['designation_id']]['name']))
                                  {{$designations[$doct['designation_id']]['name']}}
                                @endif
                                <a>
                              </td>



                              <td style="width:10%"><a class="primary"  @if($doct['deleted_at'] == '') href="{{ url('doctor/'.$doct['clinic_user_uuid'].'/details') }}" @endif> {{ optional($doct['doctor_specialty'])['specialty_name'] ?? 'No Specialty' }} <a></td>
                              <td style="width:20%"><a class="primary" @if($doct['deleted_at'] == '') href="{{ url('doctor/'.$doct['clinic_user_uuid'].'/details') }}" @endif> {{ $doct['qualification'] }}<a></td>
                              @if($status != 'inactive')
                              <td style="width:10%">
                                @if($doct['login_status'] == '1')
                                  <div class="avilable-icon">
                                    <span></span> Available
                                  </div>
                                @else
                                
                                @if($doct['status'] == '-1')
                                <div class="pending-icon">
                                    <span></span>Pending
                                  </div>
                                @elseif($doct['status'] == '0')
                                <div class="decline-icon">
                                    <span></span> Decline 
                                  </div>
                                @else
                                  <div class="notavilable-icon">
                                    <span></span>Not Available
                                  </div>
                                  @endif
                                  @endif
                                
                              </td>@endif
                              @if($isPermission == 1)
                              <td class="text-end" style="width:5%">
                                <div class="d-flex align-items-center justify-content-end">
                                  <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                   @if($doct['deleted_at'] == '')
                                    <li>
                                      <a onclick="editDoctor('{{$doct['clinic_user_uuid']}}')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-pen me-2"></i>Edit
                                      </a>
                                    </li>
                                    @if($doct['status'] == '-1' || $doct['status'] == '0')
                                    <li>
                                      <a onclick="resendInvitation('{{$doct['clinic_user_uuid']}}')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-paper-plane  me-2"></i>Resend Invitation
                                      </a>
                                    </li>
                                    @endif
                                    @endif
                                    
                                    @if($doct['deleted_at'] != '')
                                    <li>
                                      <a onclick="deactivateDoctor('{{$doct['clinic_user_uuid']}}','activate')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-user-check me-2"></i>Activate Doctor
                                      </a>
                                    </li>
                                    @else
                                    @if( Session::get('user.clinicuser_uuid') != $doct['clinic_user_uuid'] )
                                    <li>
                                      <a onclick="deactivateDoctor('{{$doct['clinic_user_uuid']}}','deactivate')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-trash-can me-2"></i>Delete Doctor
                                      </a>
                                    </li>
                                    @endif
                                    @endif

                                    @if( Session::get('user.clinicuser_uuid') != $doct['clinic_user_uuid'] )
                                    <li>
                                      <a onclick="markAsAdmin('{{$doct['clinic_user_uuid']}}','{{$doct['is_clinic_admin']}}')" class="dropdown-item fw-medium">
                                        
                                            @if($doct['is_clinic_admin'] == '0')<i class="fa-solid fa-user-check me-2"></i>Mark As Admin @else Remove @endif
                                      </a>
                                    </li>
                                    @endif



                                  </ul>
                                </div>
                              </td>
                              @endif
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

                  @if(!empty($doctorData['data']))
                    <div class="col-lg-6">
                    <form method="GET" action="{{url('doctors/list/'.$status)}}" >
                      <div class="sort-sec">
                        <p class="me-2 mb-0">Displaying per page :</p>
                        <select class="form-select" aria-label="Default select example" name="limit" onchange="this.form.submit()">
                          <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                          <option value="15" {{ $limit == 15 ? 'selected' : '' }}>15</option>
                          <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                         
                        </select>
                      </div>
                    </form>
                    </div>
                    @endif
                    <div class="col-lg-6">
                        {{ $doctorList->links('pagination::bootstrap-5') }}
                    </div>

                    
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Import Data Modal -->
<div class="modal login-modal fade" id="import_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body" id="import_data_modal"></div>
    </div>
  </div>
</div>


<!-- Import Data Modal -->
<div class="modal login-modal fade" id="import_preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body" id="import_preview_modal"></div>
    </div>
  </div>
</div>

<!-- Add Doctor Modal -->
<div class="modal login-modal fade" id="addDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="addDoctor"></div>
    </div>
  </div>
</div>


<!-- edit Doctor Modal -->
<div class="modal login-modal fade" id="editDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editDoctor"></div>
    </div>
  </div>
</div>

<script>
  function markAsAdmin(key, status) {
    var msg = (status == '0') ? 'Are you sure you want to mark this doctor as admin' : 'Are you sure you want to remove this doctor from admin'; 
    swal({
      text: msg,
        // text: status !,
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                value: true,
                closeModal: false // Keeps the modal open until AJAX is done
            }
        },
        dangerMode: true
    }).then((willConfirm) => {
        if (willConfirm) {
            // AJAX call only runs if confirmed
            $.ajax({
                type: "POST",
                url: "{{ URL::to('/doctors/markasadmin') }}",
                data: {
                    'key': key,
                    'status': status,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json'
            }).then(response => {
                if (response.success == 1) {
                    swal("Success!", response.message, "success").then(() => {
                        window.location.reload();
                    });
                } else {
                    swal("Error!", response.message, "error");
                }
            }).catch(xhr => {
              handleError(xhr);
            });
        }
    });
}
function deactivateDoctor(key, status) {
    swal({
      text: "Are you sure you want to " + status + " this doctor?",
        // text: status !,
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                value: true,
                closeModal: false // Keeps the modal open until AJAX is done
            }
        },
        dangerMode: true
    }).then((willConfirm) => {
        if (willConfirm) {
            // AJAX call only runs if confirmed
            $.ajax({
                type: "POST",
                url: "{{ URL::to('/doctors/delete') }}",
                data: {
                    'key': key,
                    'status': status,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json'
            }).then(response => {
                if (response.success == 1) {
                  swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                      window.location.reload();
                    });
                  
                } else {
                    swal("Error!", response.message, "error");
                }
            }).catch(xhr => {
              handleError(xhr);
            });
        }
    });
}

  function resendInvitation(key) {
    swal({
      text: "Are you sure you want to resend the invitation?",
        // text: "This action cannot be undone!",
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                value: true,
                closeModal: false // Keeps the modal open until AJAX is done
            }
        },
        dangerMode: true
    }).then((Confirm) => {
        if (Confirm) {

            $.ajax({
              url: '{{ url("/doctors/resend") }}',
              type: "post",
              data: {
                'key' :key,
                '_token': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                console.log('1')
                if (data.success == 1) {

                  swal("Success!", data.message, "success");
                  setTimeout(function(){ window.location.reload(); },1000);
                }else{
                  swal("error!", data.message, "error");
                
                }
              },
              error: function(xhr) {
               
                handleError(xhr);
              },
            });
      }
    });
  }

  function editDoctor(key) {
    $("#editDoctor_modal").modal('show');
    showPreloader('editDoctor')
    $.ajax({
      url: '{{ url("/doctors/edit") }}',
      type: "post",
      data: {
        'key' : key ,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#editDoctor").html(data.view);
        }
      },
      error: function(xhr) {
          
        handleError(xhr);
      }
    });
  }
  function addDoctor() {
    $("#addDoctor_modal").modal('show');
    $.ajax({
      url: '{{ url("/doctors/create") }}',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#addDoctor").html(data.view);
        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      }
    });
  }

  function filterBy() {
    $("#search").submit();
  }

  function getFilter() {
   
    if ($("#fliteritems").hasClass("show")) {
      $("#fliteritems").removeClass('show')
      $("#filterlist").hide();
    }else{
      
      $("#filterlist").show();
      $("#fliteritems").addClass('show')
    }
  }

  function submitDoctor() {
    if ($("#doctorform").valid()) {
      $("#submitdoctr").addClass('disabled');
      $("#submitdoctr").text("Submitting..."); // Optionally change button text
      $.ajax({
        url: '{{ url("/doctors/store") }}',
        type: "post",
        data: {
          'formdata': $("#doctorform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
            swal("Success!", data.message, "success");
          setTimeout(function(){ window.location.reload(); },1000);
            
          } else {
            swal("error!", data.message, "error");
            
          }
        },
        error: function(xhr) {
               
          handleError(xhr);
        }
      });
    }
  }

  function importDoctor() {
    $("#addDoctor_modal").modal('hide');
    $("#import_data").modal('show');
    showPreloader('import_data_modal')
    $.ajax({
      url: '{{ url("/doctors/import") }}',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#import_data_modal").html(data.view);
        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      }
    });
  }
</script>

@stop
