@extends('layouts.app')
@section('title', 'Patient')
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
                  <h4 class="mb-md-0">Patients</h4>
                </div>
                <div class="col-sm-7 text-center text-sm-end">
                  <div class="btn_alignbox justify-content-md-end">
                    <div class="input-group search-box search-box-card">
                      <div class="input-group-text" id="">
                        <span class="material-symbols-outlined">search</span>
                      </div>
                      <input type="text" class="form-control global-search" name="searchterm" id="searchterm" @if(isset($_GET['searchterm']) && $_GET['searchterm'] !='') value="{{$_GET['searchterm']}}" @endif placeholder="Search Patients">
                    </div>
                    @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor')
                      <a onclick="createPatient('patient')" class="btn btn-primary btn-align"><span class="material-symbols-outlined">add </span>Add Patient</a>
                    @endif
                    <a class="btn filter-btn" href="#" id="filterbtn" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined">filter_list</span>Filters</a>
                      <ul class="dropdown-menu dropdown-menu-end dropDown-align" id="filterdropdown">
                        <form id="search" method="GET" autocomplete="off">
                          <div class="p-3">
                            <small class="primary fw-medium mb-0">Filter By</small>
                            <hr class="my-2"/>
                            <div class="form-check mb-2">
                              <input class="form-check-input" type="checkbox" id="prioritypatient" name="prioritypatient" value="1" onclick="submitFilter();" @if(isset($_GET['prioritypatient']) && $_GET['prioritypatient'] == '1') checked @endif>
                              <label class="form-check-label gray" for="prioritypatient">Priority Patients</label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" id="rpmpatient" name="rpmpatient" value="1" onclick="submitFilter();" @if(isset($_GET['rpmpatient']) && $_GET['rpmpatient'] == '1') checked @endif>
                              <label class="form-check-label gray" for="rpmpatient">RPM Patients</label>
                            </div>
                          </div>
                        </form>
                      </ul>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="tab_box">
                          <a href="{{url('patients/list/pending')}}" class="btn btn-tab @if($status == 'pending') active @endif">Pending ({{$pendingcount}})</a>

                        <a href="{{url('patients/list/active')}}" class="btn btn-tab @if($status == 'active') active @endif">Active ({{$activecount}})</a>
                        <a href="{{url('patients/list/inactive')}}" class="btn btn-tab @if($status == 'inactive') active @endif">Inactive ({{$inactiveCount}})</a>
                    </div>
                  </div>   
                  <div class="col-lg-12 mb-3 mt-4">
                    <div class="table-responsive">
                      <table class="table table-hover table-white text-start w-100">
                        <thead>
                          <tr>
                            <th style="width: 30%">Patient</th>
                            <!-- jomy -->
                            <th style="width: 15%">Phone Number/Email</th>
                            @if($status == 'pending')
                            <th style="width:10%">Invitation Status</th>
                            @endif
                            <th style="width: 15%">Address</th>
                            @if($status != 'pending')
                            <th style="width: 10%">Previous Appointment</th>
                            @endif
                            <th style="width: 15%">RPM Devices</th>
                            @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor')
                            <th style="width: 5%" class="text-end">Actions</th>
                            @endif
                          </tr>
                        </thead>
                        <tbody>
                          @if(!empty($patientList['data']))
                          @foreach($patientList['data'] as $pl)
                            <tr>
                              <td style="width: 30%">
                                <div class="user_inner">
                                  <?php
                                    $corefunctions = new \App\customclasses\Corefunctions;
                                    if($pl['user_id'] !='' &&  isset($pl['user']) ){
                                      if(isset($pl['user']['profile_image']) && ($pl['user']['profile_image'] !='') ){
                    
                                        $pl['logo_path'] = $corefunctions->resizeImageAWS($pl['user']['id'],$pl['user']['profile_image'],$pl['user']['first_name'],180,180,'1') ;
                                      }  
                                        $name = $pl['user']['first_name']
                                        . (isset($pl['user']['middle_name']) && !empty($pl['user']['middle_name']) ? ' ' . $pl['user']['middle_name'] : '')
                                        . ' ' . $pl['user']['last_name'];
                                        $email= $pl['user']['email'];
                                    }else{
                                        if($pl['logo_path'] !=''){
                                          $pl['logo_path'] = $corefunctions -> resizeImageAWS($pl['id'],$pl['logo_path'],$pl['first_name'],180,180,'2');
                                        } 
                                        $name = $pl['first_name']
                                        . (isset($pl['middle_name']) && !empty($pl['middle_name']) ? ' ' . $pl['middle_name'] : '')
                                        . ' ' . $pl['last_name'];
                                        $email= $pl['email'];
                                    }
                                    
                                  ?>
                                    <img @if($pl['logo_path'] !='') src="<?php echo $pl['logo_path'] ?>" @else src="{{asset('images/default_img.png')}}" @endif>
                                    <div class="user_info">
                                      <a  @if($pl['deleted_at'] == '') href="{{ url('patient/'.$pl['patients_uuid'].'/details') }}" @endif>
                                        <h6 class="primary fw-medium m-0">{{$name}}</h6>
                                        <div class="d-flex align-items-center flex-wrap gap-1">
                                          <p class="m-0">{{$pl['age']}} | {{ $pl['gender'] == '1' ? 'Male' : ($pl['gender'] == '2' ? 'Female' : 'Other') }}</p>
                                          @if($pl['is_priority_patient'] == '1') <span class="material-symbols-outlined priority-tag"   data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="Priority Patient">award_star</span> @endif
                                        </div>
                                        @if($status == 'inactive' && isset($pl['account_deleted']) && $pl['account_deleted'] == '1')<p><span class="badge bg-danger text-dark">Deleted</span></p>@endif
                                      </a>
                                    </div>
                                </div>
                              </td>
                              <!-- jomy start-->
                              <td style="width: 15%">
                                <p><?php $cleanPhoneNumber = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $pl['phone']); ?><?php echo $cleanPhoneNumber ?></p>
                                <p><?php $cleanEmail = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $email); ?>{{$cleanEmail}}</p>
                              </td>
                              
                              <!-- jomy end-->
                              @if($status == 'pending')
                              @if($pl['status'] == 1)
                                <td style="width: 10%"><span class="accepted-tag">Accepted</span></td>
                              @elseif($pl['status'] == 0)
                                <td style="width: 10%"><span class="rejected-tag">Declined</span></td>
                              @else
                                <td style="width: 10%"><span class="pending-tag">Pending</span></td>
                              @endif
                              @endif       
                              <td style="width: 15%"><?php echo nl2br($pl['formattedAddress']) ?></td>
                              @if($status != 'pending')
                              <td style="width: 10%">@if(isset($pl['last_appointment'])){{$pl['last_appointment']}} @else -- @endif</td>
                              @endif
                              @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor')
                              <td style="width: 15%">
                                <div class="d-flex align-items-center flex-nowrap gap-2">
                                  @php
                                    $devices = [];
                                    if (!empty($pl['rpm_orders'])) {
                                      foreach ($pl['rpm_orders'] as $orders) {
                                        if (!empty($orders['devices'])) {
                                          $devices = array_merge($devices, $orders['devices']);
                                        }
                                      }
                                    }
                                    $totalDevices = count($devices);
                                  @endphp

                                  @if ($totalDevices > 0)
                                    @foreach ($devices as $index => $device)
                                      @if ($index < 3)
                                        <div class="rpm-box">
                                          <img src="{{ $device['device_image'] }}" alt="device">
                                        </div>
                                      @endif
                                    @endforeach

                                    @if ($totalDevices > 3)
                                      <div class="rpm-box more-devices-box"> 
                                        <a onclick="showDevices('{{ $pl['patients_uuid'] }}')"><span>+{{ $totalDevices - 3 }}</span></a>
                                      </div>
                                    @endif
                                  @else
                                    --
                                  @endif
                                </div>
                              </td>
                              <td style="width: 5%" class="text-end">
                                @if($pl['account_deleted'] == '0')
                                <div class="d-flex align-items-center justify-content-end">
                                  <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                      @if($pl['deleted_at'] == '')
                                        <li><a onclick="editPatients('{{$pl['patients_uuid']}}')" class="dropdown-item fw-medium" ><i class="fa-solid fa-pen me-2"></i><span>Edit</span></a></li>
                                        <!-- <li><a onclick="referPatient('{{$pl['patients_uuid']}}')" class="dropdown-item fw-medium"  ><i class="fa-regular fa-rectangle-list me-2"></i></i>Refer Patient</a></li> -->
                                      @endif
                                      @if($pl['status'] == '1' && $pl['deleted_at'] == '' )
                                        @if($pl['is_priority_patient'] == '0')
                                        <li><a href="javascript:void(0);" onclick="setAsPriority('{{$pl['patients_uuid']}}','setaspriority');" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">award_star</i><span>Set As Priority</span></a></li>
                                        @else
                                        <li><a href="javascript:void(0);" onclick="setAsPriority('{{$pl['patients_uuid']}}','unsetaspriority');" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">award_star</i><span>Remove Priority</span></a></li>
                                        @endif
                                      @endif
                                      @if($pl['deleted_at'] != '' && $pl['account_deleted'] == '0')
                                        <li><a onclick="removePatient('{{$pl['patients_uuid']}}','activate')" class="dropdown-item fw-medium"><i class="fa-solid fa-user-check me-2"></i><span>Activate</span></a></li>
                                      @endif
                                      @if($pl['deleted_at'] == '')
                                        @if($pl['status'] == '-1' || $pl['status'] == '0')
                                          <li><a onclick="resendInvitation('{{$pl['patients_uuid']}}')"  class="dropdown-item fw-medium">
                                          <i class="fa-solid fa-paper-plane  me-2"></i><span>Resend Invitation</span>
                                          </a></li>
                                        @endif

                                        <li><a onclick="removePatient('{{$pl['patients_uuid']}}','deactivate')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i><span>Deactivate</span></a></li>
                                      @endif
                                    </ul>
                                  </div>
                                @endif
                              </td>
                              @endif
                            </tr>
                          @endforeach
                          @else       
                            <tr class="text-center">
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
                          @endif
                        </tbody>
                      </table>
                    </div>  
                  </div>
                  <div class="col-12">
                    <div class="row">
                      @if(!empty($patientList['data']))
                        <div class="col-lg-6" >
                          <form method="GET" action="{{ url('patients/list/'.$status) }}">
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
                        {{ $patientData->appends(request()->query())->links('pagination::bootstrap-5') }}
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



{{-- Add Plans --}}

<div class="modal login-modal fade" id="rpmDevices" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
          <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body">   
          <div class="text-start mb-3">           
              <h4 class="fw-bold mb-0 primary">Devices</h4>
          </div>
          <div class="row g-3" id="appenddevices"> 
            
          </div>
      </div>
    </div>
  </div>
</div>          


<!-- Import Data Modal -->
<div class="modal login-modal fade" id="import_Patient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body" id="import_patient_modal"></div>
    </div>
  </div>
</div>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<style>
  .colorpicker {
    z-index: 9999 !important;
  }
  .icon-add {
    vertical-align: middle; /* Ensures vertical alignment of the icon */
    font-size: 20px; /* Adjust size as needed */
    margin-right: 5px; /* Adds a little space between the icon and text */
  }

</style>

<script type="text/javascript">
  $('#searchterm').keypress(function (e) {
    if (e.which == 13) { // Enter key
      let value = $(this).val();
      let params = new URLSearchParams(window.location.search);
      params.set('searchterm', value);
      window.location.search = params.toString();
    }
  });
  $(document).ready(function() {
    <?php if ((isset($_GET['searchterm']) && $_GET['searchterm'] != '')) { ?>
      $("#patientfilter").show();
      $("#patientfilter").addClass('show')
    <?php }else{ ?>
      $("#patientfilter").hide();
      $("#patientfilter").removeClass('show')
    <?php } ?>
    <?php /* if ((isset($_GET['prioritypatient']) && $_GET['prioritypatient'] == '1') || (isset($_GET['rpmpatient']) && $_GET['rpmpatient'] == '1')) { ?>
      $("#filterbtn").attr("aria-expanded", "true");
      $("#filterbtn").addClass('show');
      $("#filterdropdown").addClass('show');
      $("#filterdropdown").addClass('custom-open-menu');
    <?php }else{ ?>
      $("#filterbtn").attr("aria-expanded", "false");
      $("#filterbtn").removeClass('show');
      $("#filterdropdown").removeClass('show');
      $("#filterdropdown").removeClass('custom-open-menu');
    <?php } */ ?>
  });
  function showDevices(key){
    $("#rpmDevices").modal('show');
    showPreloader('appenddevices')
    $.ajax({
      url: '{{ url("/patients/fetchdevices") }}',
      type: "post",
      data: {
        'key': key,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#appenddevices").html(data.view);
        }
      },
      error: function(xhr) {  
        handleError(xhr);
      },
    });
  }
  function clearFilter() {
    window.location.href = "{{url('/patients')}}";
  }
  function setAsPriority(key,type){
    var msg = (type == 'setaspriority') ? 'Are you sure you want to mark this patient as priority patient?' : 'Are you sure you want to remove this patient from priority?'
    swal({
      text: msg,
      icon: "warning",
      buttons: {
        cancel: "Cancel",
        confirm: {
          text: "OK",
          value: true,
          closeModal: false
        }
      },
      dangerMode: true
    }).then((Confirm) => {
      if (Confirm) {
        $.ajax({
          url: '{{ url("/patients/markaspriority") }}',
          type: "post",
          data: {
            'key' :key,
            'type' : type,
            '_token': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(data) {
            console.log('1')
            if (data.success == 1) {
              swal(data.message, {
                title: "Success!",
                text: data.message,
                icon: "success",
                buttons: false,
                timer: 2000 // Closes after 2 seconds
              }).then(() => {
                window.location.reload();
              });
            }else{
              swal("error!", data.errormsg, "error");
            }
          },
          error: function(xhr) {
            handleError(xhr);
          },
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
              url: '{{ url("/patients/resend") }}',
              type: "post",
              data: {
                'key' :key,
                '_token': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                console.log('1')
                if (data.success == 1) {

                  swal(data.message, {
                      title: "Success!",
                      text: data.message,
                      icon: "success",
                      buttons: false,
                      timer: 2000 // Closes after 2 seconds
                  }).then(() => {
                      window.location.reload();
                  });

                  // swal("Success!", data.message, "success");
                
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

function importPatient() {
    $("#addPatientModal").modal('hide');
    $("#import_Patient").modal('show');
    showPreloader('import_patient_modal')
    $.ajax({
      url: '{{ url("/patients/import") }}',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#import_patient_modal").html(data.view);
        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      },
    });
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
$('#search').keypress(function(event) {
    if (event.which === 13) { // Enter key code is 13
        event.preventDefault(); // Prevent the default form submit
        $("#search").submit();
    }
});

  function referPatient(key){
    $("#referpatientModal").modal('show');
     $.ajax({
       url: '{{ url("/patients/refer") }}',
       type: "post",
       data: {
          'key' : key,
         '_token': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data) {
         if (data.success == 1) {
          $("#referpatient").html(data.view);
         } else {
          swal("error!", data.message, "error");
         
         }
       },
       error: function(xhr) {
               
        handleError(xhr);
        },
     });

  }
  function removeImage(){

    $("#patientimage").attr("src","{{asset('images/default_img.png')}}");
    $("#isremove").val('1');
    $("#removelogo").hide();
    $("#upload-img").show();

  }

  function editPatients(key) {
    $("#editpatientModal").modal('show');
     $.ajax({
       url: '{{ url("/patients/edit") }}',
       type: "post",
       data: {
          'key' : key,
         '_token': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data) {
         if (data.success == 1) {
          $("#editpatient").html(data.view);   
          // Initialize floating labels for inputs within the modal
          $('#editpatientModal').find('input, textarea').each(function() {
            toggleLabel(this);
            initializeAutocomplete();
          });
         } else {
          swal("error!", data.errormsg, "error");
          $("#editpatientModal").modal('hide');
         }
       },
       error: function(xhr) {
               
        handleError(xhr);
        }
     });
   
 }
  

 function removePatient(key, status) {
    swal({
      text: "Are you sure you want to " + status + " this patient?",
       
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                closeModal: false
            }
        },
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            // AJAX call if user confirms
            $.ajax({
                type: "POST",
                url: "{{ URL::to('/patients/delete') }}",
                data: {
                    'key': key,
                    'status': status,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json'
            }).then(response => {
                if (response.success == 1) {

                  swal(response.message, {
                      title: "Success!",
                      text: response.message,
                      icon: "success",
                      buttons: false,
                      timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                      window.location.reload();
                    });

                  
                } else {
                    swal("Warning!", response.errormsg, "warning");
                }
            }).catch(xhr => {
              handleError(xhr);
            });
        }
    });
}
function submitFilter() {
  let searchForm = document.getElementById('search');

  searchForm.submit();
}




    </script>

 
              <!-- refer a patient  -->
              <div class="modal login-modal fade" id="referpatientModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-bg p-0 position-relative">
                        <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                
                    </div>
                    <div class="modal-body text-center position-relative" id="referpatient">
                   
                    
                      
                      
                      
                      </div>
                  </div>
                </div>
              </div>


              <!-- Import Data Modal -->
            <div class="modal login-modal fade" id="import_preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xxl">
                <div class="modal-content">
                  <div class="modal-header modal-bg p-0 position-relative">
                    <!-- <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
                  </div>
                  <div class="modal-body" id="import_preview_modal"></div>
                </div>
              </div>
            </div>


@stop
