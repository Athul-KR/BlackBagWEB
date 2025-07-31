@extends('layouts.app')
@section('title', 'Users')
@section('content')
<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row">
                <div class="col-md-3 text-center text-md-start">
                  <h4 class="mb-md-0">Users</h4>
                </div>
                <?php
                   $corefunctions = new \App\customclasses\Corefunctions;
                   $isPermission = $corefunctions->checkPermission() ;
                ?> 
                <div class="col-md-9 text-center text-md-end mb-xl-0 mb-md-3">
                  <div class="btn_alignbox justify-content-md-end flex-wrap">
                    <a onclick="addUser()" href="javascript:void(0)" class="btn btn-primary btn-align">
                      <span class="material-symbols-outlined">add</span>Add User
                    </a>
                    <a class="btn filter-btn"  onclick="getFilter()" ><span class="material-symbols-outlined">filter_list</span>Filters</a>
                  </div>
                  <div id="patientfilter" class="collapse-filter">
                    <form id="search" method="GET">
                     
                        <div class="align_middle w-100 flex-md-row flex-column my-3">
                          <div class="form-group form-floating w-100">
                            <i class="fa-solid fa-user-tag"></i>
                            <select name="userType" id="userType" class="form-select" onchange="submitFilter();">
                              <option value="">Select User Type</option>

                              <option value="admin" @if(isset($_GET['userType']) && $_GET['userType'] == 'admin') selected @endif>Admin</option>
                              <option value="clinician" @if(isset($_GET['userType']) && $_GET['userType'] == 'clinician') selected @endif>Provider</option>
                              <option value="nurse" @if(isset($_GET['userType']) && $_GET['userType'] == 'nurse') selected @endif>Medical Assistant / Scribe</option>
                            </select>
                            <label class="select-label">User Type</label>
                          </div>
                    
                          <div class="form-group form-outline w-100">
                            {{-- <label for="input" class="float-label">Search by user</label> --}}
                            <i class="material-symbols-outlined">search</i>
                            <input type="text" class="form-control" placeholder="Search by user" name="searchterm" @if(isset($_GET['searchterm']) && $_GET['searchterm'] !='') value="{{$_GET['searchterm']}}" @endif>
                          </div>
                  
                          <div class="btn_alignbox">
                            <button type="button" class="btn btn-outline-primary" onclick="clearFilter();">Clear All</button>
                          </div>
                        </div>
                    
                    </form>
                  </div>
                </div>
                <?php $appendUrl = (isset($_GET['userType']) && $_GET['userType'] !='') ? '?userType='.$_GET['userType'] : ''; ?>
                <div class="col-12">
                  <div class="tab_box">
                    <a href="{{url('users/list/pending'.$appendUrl)}}" class="btn btn-tab @if($status == 'pending') active @endif">Pending ({{$pendingcount}})</a>
                    <a href="{{url('users/list/active'.$appendUrl)}}" class="btn btn-tab @if($status == 'active') active @endif">Active ({{$activecount}})</a>
                    <a href="{{url('users/list/inactive'.$appendUrl)}}" class="btn btn-tab @if($status == 'inactive') active @endif">Inactive ({{$innactiveCount}})</a>
                  </div>
              </div>
                <div class="col-lg-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                      <thead>
                        <tr>
                          <th style="width:25%">Name</th>
                          <th style="width:15%">Phone Number</th>
                          <th style="width:10%">User Type</th>
                          @if($status == 'pending')
                          <th style="width:10%">Invitation Status</th>
                          @endif
                          @if($status == 'active' && session()->get('user.userType') == 'clinics')
                          <th style="width:10%">ePrescribe</th>
                          @endif
                          <th style="width:15%">Created By</th>
                          <th style="width:15%">Updated By</th>
                          @if(session()->get('user.userType') != 'nurse')
                          <th class="text-end" style="width:5%">Actions</th>
                          @else
                          <th class="text-end" style="width:5%"></th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                      
                        @if($clinicUserData['data'])
                          @foreach($clinicUserData['data'] as $cus)
                            <?php 
                              /** check need to show enable add on btn with user details */
                              $isShow  = $corefunctions->checkuserData($cus['user_id']);
      
                              if($cus['user_type_id'] == '1' || $cus['user_type_id'] == '2'){
                                $url = url('user/'.$cus['clinic_user_uuid'].'/details');
                                  if($cus['status'] == '1'){
                                    $image = ($cus['profile_image'] !='') ? $corefunctions -> resizeImageAWS($cus['user_id'],$cus['profile_image'],$cus['first_name'],180,180,'1') : $corefunctions->resizeImageAWS($cus['id'],$cus['logo_path'],$cus['first_name'],180,180,'1') ;
                                    
                                    $name = $corefunctions -> showClinicanNameUser($cus,'1');
                                  }else{
                                      $image = $corefunctions -> resizeImageAWS($cus['id'],$cus['logo_path'],$cus['name'],180,180,'1');
                                      $name = $corefunctions -> showClinicanNameUser($cus,'0');
                                  }
                              }else{
                                $url = url('user/'.$cus['clinic_user_uuid'].'/details');
                                   if($cus['status'] == '1'){
                                    $image = $corefunctions -> resizeImageAWS($cus['user_id'],$cus['profile_image'],$cus['first_name'],180,180,'1');
                                    $name = $cus['first_name'].' '.$cus['last_name'];
                                 }else{
                                      $image = $corefunctions -> resizeImageAWS($cus['id'],$cus['logo_path'],$cus['name'],180,180,'1');
                                      $name = $cus['first_name'].' '.$cus['last_name'];
                                }
                              }
                            ?>
                            <tr>
                              <td style="width:25%">
                              
                              
                                <a class="primary"  @if($cus['deleted_at'] == '') href="{{ $url }}" @endif>
                                <div class="user_inner">
                                  <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                                  <div class="user_info">
                                    <h6 class="primary fw-medium m-0">{{ $name }}</h6>
                                     @if($status != 'pending')
                                    @if(isset($cus['specialty_id']) && $cus['specialty_id'] != '')<p class="m-0"> {{ $specialtyList[$cus['specialty_id']]['specialty_name'] }} </p>@endif
                                      @endif
                                      
                                        @if(isset($cus['user_type_id']) && $cus['user_type_id'] == '3')
                                      <p class="m-0"> {{ $cus['department'] }}</p>
                                      @endif
                                      
                                    @if($status == 'inactive' && isset($cus['account_deleted']) && $cus['account_deleted'] == '1')<p><span class="badge bg-danger text-dark">Deleted</span></p>@endif
                                  </div>
                                 
                                </div>
                                <a>
                              </td>
                              <td style="width:15%"><a class="primary"  @if($cus['deleted_at'] == '') href="{{ $url }}" @endif> <?php $cleanPhoneNumber = preg_replace('/_\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', '', $cus['phone']); ?> {{ $cleanPhoneNumber }} <a></td>
                              <td style="width:10%"><a class="primary"  @if($cus['deleted_at'] == '') href="{{ $url }}" @endif>@if(isset($userType[$cus['user_type_id']])){{ $userType[$cus['user_type_id']]['user_type']}}  @else Patient @endif<a></td>
                              @if($status == 'pending')
                                @if($cus['status'] == 1)
                                  <td style="width:10%"><span class="accepted-tag">Accepted</span></td>
                                @elseif($cus['status'] == 0)
                                  <td style="width:10%"><span class="rejected-tag">Declined</span></td>
                                @else
                                  <td style="width:10%"><span class="pending-tag">Pending</span></td>
                                @endif
                              @endif
                              @if($status == 'active' && session()->get('user.userType') == 'clinics')
                                @if(isset($cus['is_licensed_practitioner']) && $cus['is_licensed_practitioner'] == '1')
                                  
                                  <?php 
                               
                                   $isUsUser      = $corefunctions->checkIsUserUserForePrescribe($clinicDetails,$cus);
                                   ?>
                                  <td class="enable-list" style="width:10%">
                                    @if($cus['eprescribe_enabled'] == '1')
                                      <img src="{{ asset('images/verified.png') }}"> Enabled
                                    @else
                                      
                                 
                                      <a class="primary @if( $isUsUser == 0) enablebtnfadeout @endif" id="enableAddOnBtn_{{ $cus['clinic_user_uuid'] }}" href="javascript:void(0);"
                                         @if( $isUsUser == 1)
                                         onclick="enableUsers('{{ $cus['clinic_user_uuid'] }}');"
                                         @else
                                         onclick="disableePrescribe();"
                                        @if($isShow == '1')
                                            onclick="enableUsers('{{ $cus['clinic_user_uuid'] }}');"
                                        @else
                                            onclick="enableAddOn('{{ $cus['clinic_user_uuid'] }}');"
                                        @endif @endif>
                                          
                                        Enable Add-On
                                      </a>
                                    @endif
                                  </td>
                                @else
                                  <td>--</td>
                                @endif
                              @endif
                              <td style="width:15%">@if(isset($cus['created_by']) && isset($usersList[$cus['created_by']]) && $cus['created_by'] != '')  <?php if($usersList[$cus['created_by']]['user_type_id'] != '3'){ echo $corefunctions -> showClinicanName($usersList[$cus['created_by']],'1');  }else{ echo $usersList[$cus['created_by']]['user']['first_name'];  } ?><br>
                                  <?php echo $corefunctions->timezoneChange($cus['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($cus['created_at'],'h:i A') ?>
                                @else -- @endif
                              </td>
                              <td style="width:15%">@if(isset($cus['updated_by']) && isset($usersList[$cus['updated_by']]) && $cus['updated_by'] != '') <?php if($usersList[$cus['updated_by']]['user_type_id'] != '3'){ echo $corefunctions -> showClinicanName($usersList[$cus['updated_by']],'1');  }elseif (isset($usersList[$cus['updated_by']]['user']['first_name'])){ echo $usersList[$cus['updated_by']]['user']['first_name'];  }else{ } ?><br>
                                  <?php echo $corefunctions->timezoneChange($cus['updated_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($cus['updated_at'],'h:i A') ?>
                                @else -- @endif
                              </td>
                              <td class="text-end" style="width:5%">
                              @if((session()->get('user.userType') == 'clinics' || (session()->get('user.userType') == 'doctor') && $cus['user_type_id'] == '3') &&  ($cus['account_deleted'] == '0'))
                              
                                <div class="d-flex align-items-center justify-content-end">
                                  <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                   @if($cus['deleted_at'] == '')
                                    <li>
                                      <a onclick="editUser('{{$cus['clinic_user_uuid']}}')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-pen me-2"></i>Edit
                                      </a>
                                    </li>
                                    @if($cus['status'] == '-1' || $cus['status'] == '0')
                                    <li>
                                      <a onclick="resendInvitation('{{$cus['clinic_user_uuid']}}')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-paper-plane  me-2"></i>Resend Invitation
                                      </a>
                                    </li>
                                    @endif
                                    @endif
                                    
                                    @if($cus['deleted_at'] != '' && $cus['account_deleted'] == '0')
                                    <li>
                                      <a onclick="deactivateUser('{{$cus['clinic_user_uuid']}}','activate')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-user-check me-2"></i>Activate
                                      </a>
                                    </li>
                                    @endif
                                    @if($cus['deleted_at'] == '')
                                    @if( Session::get('user.clinicuser_uuid') != $cus['clinic_user_uuid'] )
                                    <li>
                                      <a onclick="deactivateUser('{{$cus['clinic_user_uuid']}}','deactivate')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-trash-can me-2"></i>Deactivate
                                      </a>
                                    </li>
                                    @endif
                                    @endif

                                    <!-- @if( Session::get('user.clinicuser_uuid') != $cus['clinic_user_uuid'] && $cus['is_clinic_admin'] == '0')
                                    <li>
                                      <a onclick="markAsAdmin('{{$cus['clinic_user_uuid']}}','{{$cus['is_clinic_admin']}}')" class="dropdown-item fw-medium"><i class="fa-solid fa-user-check me-2"></i>Mark As Admin</a>
                                    </li>
                                    @endif -->
                                  <!-- <li>
                                    <button class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-target="#staticBackdrop" type="button">
                                      <i class="fa-solid fa-plus me-2"></i>
                                      Enable Add-On
                                    </button>
                                  </li> -->
                                  </ul>
                                </div>
                               
                                @endif
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
                        {{ $clinicUserList->links('pagination::bootstrap-5') }}
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

<!-- User Type -->
<div class="modal login-modal fade" id="userTypemodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-md">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
          <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body p-4">
        <div class="text-center">
          <h4 class="fw-bold mb-0">Choose Your User Type</h4>
          <small>Select your user type to get started</small>
        </div>
        <div class="user_Type mt-4">
          <div class="radio-input">
            <input value="value-1" name="value-radio" id="value-1" type="radio" />
            <label for="value-1" onclick="importUsers('clinic')">
              <div class="userTypeInner">
                <img src="{{ asset('images/clinic.png')}}" class="img-fluid">
                <div class="userTypeInfo">
                  <h6 class="primary fw-medium mb-1">Admin</h6>
                  <small>Efficiently manage your clinic operations</small>
                </div>
              </div>
            </label>
            <input value="value-2" name="value-radio" id="value-2" type="radio" />
            <label for="value-2"  >
              <div class="userTypeInner" onclick="importUsers('doctor')">
                <img src="{{asset('images/patient.png')}}" class="img-fluid">
                <div class="userTypeInfo">
                  <h6 class="primary fw-medium mb-1">Clinician</h6>
                  <small>Connect with clinicians and get expert advice</small>
                </div>
              </div>
            </label>
            <input value="value-2" name="value-radio" id="value-2" type="radio" />
            <label for="value-2"  >
              <div class="userTypeInner" onclick="importUsers('nurse')">
                <img src="{{asset('images/patient.png')}}" class="img-fluid">
                <div class="userTypeInfo">
                  <h6 class="primary fw-medium mb-1">Nurse</h6>
                  <small>Connect with nurse and get expert advice</small>
                </div>
              </div>
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!----User Type --->

<!-- Add User Modal -->
<div class="modal login-modal fade" id="adduser_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
      </div>

      <div class="modal-body text-center" id="addUser"></div>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal login-modal fade" id="editUser_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editUser"></div>
    </div>
  </div>
</div>

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

<div class="modal login-modal payment-success fade" id="addCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center amount_body">
                    <h4 class="text-center fwt-bold mb-1">Add New Card</h4>
                    <p class="gray fw-light">Please enter card details</p>
                </div>
                <form method="POST" action="" id="addcardsform" autocomplete="off">
                @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group form-outline mb-4">
                                <i class="material-symbols-outlined">id_card</i>
                                <label for="input" class="float-label">Cardholder Name</label>
                                <input type="name" class="form-control" id="name_on_card" name="name_on_card">
                            </div>
                        </div>
                        <div class="col-12">
                            <div id="add-card-element">

                            </div>
                        </div>
                        <div class="btn_alignbox mt-5">
                            <button type="submit" id="submitbtn" class="btn btn-primary w-100">Add Card</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script src="https://js.stripe.com/v3/"></script>  
<script>
  var stripe = Stripe('{{ env("STRIPE_KEY") }}');
  // Create an instance of Elements.
  var elements = stripe.elements();
  var style = {
      hidePostalCode: true,
      base: {
          color: '#32325d',
          lineHeight: '18px',
          fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
          fontSmoothing: 'antialiased',
          fontSize: '16px',
          '::placeholder': {
              color: '#aab7c4'
          }
      },
      invalid: {
          color: '#fa755a',
          iconColor: '#fa755a'
      }
  };

  var elements = stripe.elements();
  var cardElement = elements.create('card', {hidePostalCode: true,style: style});
  cardElement.mount('#add-card-element');
  cardElement.addEventListener('change', function(event) {
      var displayError = document.getElementById('add-card-errors');
      if (event.error) {
          displayError.textContent = event.error.message;
      } else {
          displayError.textContent = '';
      }
  });
  var cardholderName = document.getElementById('name_on_card');
  var clientSecret = '<?php echo $clientSecret;?>'
  var form = document.getElementById("addcardsform");
  form.addEventListener("submit", function(event) {
    event.preventDefault();
    $.ajax({
      type: "POST",
      url: "{{ URL::to('/getclinicstripeclientsecret')}}",
      data: 
      {"_token": "{{ csrf_token() }}"},
      dataType : 'json',
      success: function(data) {
        if(data.success==1){
          var clientSecret = data.clientSecret;
          stripe.confirmCardSetup(
            clientSecret,
            {
              payment_method: {
                card: cardElement
              },
            }
          ).then(function(result) {
            console.log(result);
            if (result.error) {
              var errorElement = document.getElementById('new-card-errors');
              errorElement.textContent = result.error.message;
              $("#add-card-errors").show();
              $("#cardvalid").val('');
            } else {
              $("#cardvalid").val('1');
              stripeTokenHandler(result.setupIntent.payment_method,result.setupIntent.id);
            }
          });
        }
        }
    });
  });
  function stripeTokenHandler(token,setupIntentID) {
      var form = document.getElementById('addcardsform');
      var hiddenInput = document.createElement('input');
      hiddenInput.setAttribute('type', 'hidden');
      hiddenInput.setAttribute('name', 'stripeToken');
      hiddenInput.setAttribute('value', token);
      form.appendChild(hiddenInput);
      var hiddenInput1 = document.createElement('input');
      hiddenInput1.setAttribute('type', 'hidden');
      hiddenInput1.setAttribute('name', 'setupintentid');
      hiddenInput1.setAttribute('id', 'setupintentid');
      hiddenInput1.setAttribute('value', setupIntentID);
      form.appendChild(hiddenInput1);
      if($("#addcardsform").valid()){
          submitCard();
      }
  }


  

  $(document).ready(function() {
    $('#successSubscription').on('hidden.bs.modal', function () {
      window.location.reload();
    });

    <?php if ((isset($_GET['userType']) && $_GET['userType'] != '') || (isset($_GET['searchterm']) && $_GET['searchterm'] != '')) { ?>
      $("#patientfilter").show();
      $("#patientfilter").addClass('show')
    <?php }else{ ?>
      $("#patientfilter").hide();
      $("#patientfilter").removeClass('show')
    <?php } ?>
  });
  
    function submitCard(){
      if($('#addcardsform').valid()){
        $("#submitcardbtn").addClass('disabled');
        $("#submitcardbtn").prop('disabled',true);
        $.ajax({
          url: '{{ url("/addcard") }}',
          type: "post",
          data: {
            'formdata': $("#addcardsform").serialize(),
            '_token': $('input[name=_token]').val()
          },
          success: function(data) {
            if (data.success == 1) {
              swal(data.message, {
                icon: "success",
                text: data.message,
                buttons: false,
                timer: 2000
              }).then(() => {
                $("#addCard").modal('hide');
                enableAddOn();
                setTimeout(function(){
                  var radio = $("#selected_card_" + data.key);
                  var checkbox = $(".select-user");
                  if (checkbox.is(':checked')) {
                    selectUser(checkbox[0]);
                  }
                  $(".selectedcardcls").prop("checked", false);
                  if (radio.length > 0) {
                    radio.prop("checked", true).trigger("change");
                    console.log("Radio checked successfully");
                    $("#cardadded").val('1');
                  } else {
                    console.error("Radio button not found");
                  }
                }, 1000);
              });
            } else {
              swal(data.errormsg, {
                icon: "error",
                text: data.errormsg,
                button: "OK",
              });
              $("#submitcardbtn").removeClass('disabled');
              $("#submitcardbtn").prop('disabled',false);
              $("#addCard").modal('hide');
            }
          },
          error: function(xhr) {
            handleError(xhr);
          }
      });
    }
  }
  function submitFilter(){
    $("#search").submit();
  }
  function clearFilter() {
    window.location.href = "{{url('/users')}}";
  }
 
  function addUser() {
    $("#adduser_modal").modal('show');
    showPreloader('addUser')
    $.ajax({
      url: '{{ url("/users/create") }}',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#addUser").html(data.view);
        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      },
    });
  }

  function submitUser() {
    if ($("#usersform").valid()) {
      $("#submituser").addClass('disabled');
      $("#submituser").text("Submitting..."); // Optionally change button text
      $.ajax({
        url: '{{ url("/users/store") }}',
        type: "post",
        data: {
          'formdata': $("#usersform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
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
            //   setTimeout(function(){ window.location.reload(); },1000);
            
          } else {
            swal("error!", data.message, "error");
            $("#submituser").removeClass('disabled');
            $("#submituser").text("Submit");
          }
        },
        error: function(xhr) {
               
          handleError(xhr);
        },
      });
    }
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
          url: '{{ url("/users/resend") }}',
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
              // setTimeout(function(){ window.location.reload(); },1000);
            }else{
              swal("error!", data.message, "error");
            
            }
          },
          error: function(xhr) {
               
            handleError(xhr);
          }
        });
      }
    });
  }
  function editUser(key) {
    $("#editUser_modal").modal('show');
    showPreloader('edituser')
    $.ajax({
      url: '{{ url("/users/edit") }}',
      type: "post",
      data: {
        'key' : key ,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#editUser").html(data.view);
        }
      },
      error: function(xhr) {
          
        handleError(xhr);
      }
    });
  }
  function markAsAdmin(key, status) {
    var msg = (status == '0') ? 'Are you sure you want to mark this user as admin' : 'Are you sure you want to remove this user from admin'; 
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
          url: "{{ URL::to('/users/markasadmin') }}",
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
            swal("Error!", response.message, "error");
          }
        }).catch(xhr => {
          handleError(xhr);
        });
      }
  });
}
function deactivateUser(key, status) {
  swal({
    text: "Are you sure you want to " + status + " this user?",
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
        url: "{{ URL::to('/users/delete') }}",
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
            swal("Error!", response.message, "error");
        }
      }).catch(xhr => {
        handleError(xhr);
      });
    }
  });
}
function importUser() {
  $("#userTypemodal").modal('show');
}
function importUsers(userType){
  $("#userTypemodal").modal('hide');
  $("#import_data").modal('show');
  showPreloader('import_data_modal')
  $.ajax({
    url: '{{ url("/users/import") }}',
    type: "post",
    data: {
      'userType': userType,
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
function getFilter() {                  
  if ($("#patientfilter").hasClass("show")) {
    $("#patientfilter").removeClass('show')
    $("#patientfilter").hide();
  }else{
    
    $("#patientfilter").show();
    $("#patientfilter").addClass('show')
  }
}

function enableUsers(key) {
        $("#editUser_dotsepot").modal('show');
        showPreloader('edituser')
        $.ajax({
        url: '{{ url("onboarding/users/edit") }}',
        type: "post",
        data: {
          'key' : key ,
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if (data.success == 1) {
              $("#editUse_dotsepot").html(data.view);
              $('input:visible, textarea:visible').each(function () {
                toggleLabel(this);
              });
            }
        },
        error: function(xhr) {
            
            handleError(xhr);
        }
        });
}
   function disableePrescribe(){
        var errormsg = "ePrescirption can only be enabled for US based clinicians/admins";
         swal(errormsg, {
                icon: "error",
                text: errormsg,
                button: "OK",
              });
    }
</script>

@stop
