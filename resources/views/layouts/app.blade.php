<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
  <meta name="keywords" content="HTML, CSS, JavaScript">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@if(isset($seo['title']) && !empty($seo['title'])){{$seo['title']}}@else BlackBag @endif</title>
  <meta name="keywords" content="{{ isset($seo['keywords'])&& $seo['keywords']!='' ? $seo['keywords'] : '' }}">
  <meta name="description" content="{{ isset($seo['description'])&& $seo['description']!='' ? $seo['description'] : '' }}">
  <meta property="og:type" content="website" />
  <meta property="og:title" content="@if(isset($seo['title'])){{ $seo['title'] }}@else@yield('title')@endif"/>
  <meta property="og:description" content="{{ isset($seo['og_description']) && $seo['og_description']!='' ? $seo['og_description'] : 'Manage your healthcare appointments seamlessly with the Black Bag
                                  dashboard. View upcoming patient details, appointment types, and schedules. Stay
                                  updated with notifications and easily access actions for efficient management' }}" />
  <meta property="og:image" content="{{asset('/images/og-blackbag.png')}}">

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- css -->
  <link rel="stylesheet" href="{{ asset('css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('css/tele-med.css')}}">
  <link rel="stylesheet" href="{{ asset('css/navbar.css')}}">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">


  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <!-- Include Moment.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<!-- Include Moment Timezone -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.43/moment-timezone-with-data.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
 

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script src="{{ asset('js/main.js') }}"></script>
  <script src="{{ asset('js/jquery.textarea-expander.js') }}"></script>


  <!-- Include Bootstrap DateTimePicker CDN -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script> -->


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/colorbox.css') }}">
  <script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
  <script src="{{ asset('/tinymce/tinymce.min.js')}}" defer></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.14/moment-timezone-with-data-2012-2022.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places" async defer></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

  <link rel="stylesheet" type="text/css" href="{{ asset('css/virtual-select.min.css') }}">
	<script type="text/javascript" src="{{ asset('js/virtual-select.min.js') }}"></script>

  <!-- Daterangepicker CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/daterangepicker/daterangepicker.css') }}" />
  <script type="text/javascript" src="{{ asset('js/daterangepicker/daterangepicker.min.js') }}"></script>



</head>

<body>
  <div class="wrapper-container">
    <div id="disconnectloader" class="disonnect-loader"> </div>
    <div id="navbar-wrapper" class="header-fixed">
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <div class="row align-items-center">
                @php

                            $corefunctions = new \App\customclasses\Corefunctions;

                            $clinicLogo = $corefunctions->getClinicLogo();
                            $userLogo = (session('user.userLogo') != '') ? session('user.userLogo') : asset('images/default_img.png');
                            $notificationCount = $corefunctions->getUnreadNotCount();
                            $appointmentCount = $corefunctions->getAppointmentCount();
                            @endphp
              <div class="col-xl-5 col-12 ps-xl-1">
                <div class="d-flex align-items-center justify-content-start flex-row gap-2 mb-3 mb-xl-0">
                  <img src="{{ $clinicLogo}}" class="logo me-2 cliniclogocls">
                  <small class="mb-0 fw-medium logo me-2 clinicname">{{Session::get('user.clinicName')}}</small>
                </div>

              </div>
              <div class="col-xl-7 col-12">
                <div class="d-flex justify-content-between justify-content-xl-end align-items-center nav-top">
                  <a href="javascript:void(0)" class="btn btn-primary res-menu d-md-none" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><span class="material-symbols-outlined"> menu </span></a>
                  <form style="display:block;" id="globalsearchadmin" method="GET" action="">
                 
                  <div class="input-group search-box">
                    <div class="input-group-text" id="basic-addon1"><span class="material-symbols-outlined">
                        search
                      </span>
                    </div>
                    <input type="text" class="form-control global-search" placeholder="Search for clinicians, patients, and more..." name="searchterm"
                      aria-label="Username" aria-describedby="basic-addon1" id="search-input-admin" value="@if(isset($searchValue)){{ trim($searchValue) }}@endif">
                      
                  </div>
                    </form>
                  <div class="right-sec">

                    <div class="notfctn-hd">
                      <div class="btn-group dropdown">
                        <button type="button " class="btn dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" onclick="getNotificationsList();">
                          <img src="{{ asset('images/notifications.png')}}" alt="">
                          <?php  $corefunctions = new \App\customclasses\Corefunctions; $notCount = $corefunctions->getUnreadNotCount(); ?>
                            
                          @if($notCount > 0 )<span class="btn-ntfcn"></span>@endif
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end ntfcn-dropdwn" id="notificationlist">
                         
                        </ul>

                      </div>
                    </div>
                  
                    <div class="profile-hd">
                      <div class="btn-group">
                        <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown"
                          aria-expanded="false">
                          <div class="d-flex align-items-center">
                            

                            <img class="pfl-img" src="{{$userLogo}}">
                            <div class="pftl-txt-hd pftl-txt">
                              <h6 class="mb-0 primary fw-medium usernamecls"> {{Session::get('user.firstName')}}
                              </h6>
                                <small class="fw-medium m-0">{{Session::get('user.clinicName')}}</small>
                                <small class="fw-medium m-0">{{Session::get('user.clinicCode')}}</small>
                            </div>
                          </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end profile-drpdown p-0 py-3">
                             @if((Session::has('user.hasWorkSpace')) && Session::get('user.hasWorkSpace') == 1)
                          <li class="mx-3">
                            <a class="dropdown-item p-0" onclick="changeClinic()">
                              <div class="d-flex align-items-center justify-content-start gap-2">
                               <?php /* <!-- <div class="workspace_text">
                                  <small>Current Organization</small> 
                                  <h6 class="fw-medium m-0">{{Session::get('user.clinicName')}}</h6>
                                </div> -->*/?>
                                <span class="material-symbols-outlined fl-icon primary">cached</span>
                                <p class="mb-0 gray">Switch Clinic</p>
                              
                              </div>
                            </a>
                          </li>
                            @endif

                            @if(session()->get('user.userType') == 'clinics')
                            <li class="mx-3">
                              <a href="{{route('clinic.profile')}}" class="dropdown-item danger-btn p-0" type="button">
                                <div class=" d-flex align-items-center justify-content-start gap-2">
                                  <span class="material-symbols-outlined primary">manage_accounts</span>
                                  <p class="mb-0 gray">Manage Clinic</p>
                                </div>
                              </a>
                            </li>
                           
<!--
                            <li class="mx-3">
                              <a onclick="addClinic()" class="dropdown-item danger-btn p-0" type="button">
                                <div class=" d-flex align-items-center justify-content-start gap-2">
                                  <span class="material-symbols-outlined primary">add_business</span>
                                  <p class="mb-0 gray">Add New Clinic</p>
                                </div>
                              </a>
                            </li>
-->
                            @endif
                            <li class="mx-3">
                              <a href="{{url('myprofile')}}" class="dropdown-item danger-btn p-0" type="button">
                                <div class=" d-flex align-items-center justify-content-start gap-2">
                                  <span class="material-symbols-outlined primary">account_box</span>
                                  <p class="mb-0 gray">My Profile</p>
                                </div>
                              </a>
                            </li>
                          <li class="mx-3">
                            <a class="dropdown-item danger-btn p-0" href="javascript:void(0);" onclick="appointmentExist()">
                              <div class=" d-flex align-items-center justify-content-start gap-2">
                                <span class="material-symbols-outlined primary">delete</span>
                                <p class="mb-0 gray">Delete Account</p>
                              </div>
                            </a>
                          </li>
                          <li class="mx-3">
                            <a class="dropdown-item danger-btn p-0 logoutBtn" href="{{url('/logout')}}">
                              <div class=" d-flex align-items-center justify-content-start gap-2">
                                <span class="material-symbols-outlined danger">logout</span>
                                <p class="mb-0 danger">Logout</p>
                              </div>
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </nav>
    </div>
    <div class="wrapper res-wrapper">

      <aside class="sidebar-wrapper" id="sidebar-wrapper">

        <div class="navbar-list">
          <ul class="sidebar-nav pb-1">
            {{-- <li class="d-md-none d-block">
              <img src="{{ asset('images/logo.png')}}" class="img-fluid side-logo">
            </li> --}}
            <li class="{{request()->routeIs('dashboard*') ? 'active' : ''}}">
              <div>
                <a href="{{route('dashboard')}}">
                  <span class="material-symbols-outlined">dashboard</span>
                  <p class="mb-0">Dashboard</p>
                </a>
              </div>
            </li>
            <li class="{{request()->routeIs('appointment*') ? 'active' : ''}}">
              <div>
                <a href="{{route('appointment.list')}}">
                  <span class="material-symbols-outlined">list_alt</span>
                  <p class="align_middle gap-2 mb-0">Appointments
                    @if($appointmentCount > 0)
                      <span class="badge notftn-count align_middle">
                        {{ $appointmentCount }}
                      </span>
                    @endif
                  </p>
                </a>
              </div>
            </li>
          
            @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor' || session()->get('user.userType') == 'nurse')
            <li class="{{request()->routeIs('patient*') ? 'active' : ''}}">
              <div>
                <a href="{{route('patient.list')}}">
                  <span class="material-symbols-outlined">clinical_notes</span>
                  <!--jomy -->
                  <p class="mb-0">Patients </p>
                </a>
              </div>
            </li>
            @endif
            <?php /* <!-- @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor')
            <li class="{{request()->routeIs('doctor*') ? 'active' : ''}}">
              <div>
                <a href="{{route('doctor.list')}}">
                  <span
                    class="material-symbols-outlined @if(isset($menucls) && $menucls == 'doctors') active @endif ">stethoscope</span>
                  <p class="mb-0">Doctors</p>
                </a>
              </div>
            </li>
            @endif
            @if(session()->get('user.userType') != 'patient')
            <li class="{{request()->routeIs('nurse*') ? 'active' : ''}}">
              <div>
                <a href="{{route('nurse.list')}}">
                  <span class=" material-symbols-outlined">person_3</span>
                  <p class="mb-0">Nurses</p>
                </a>
              </div>
            </li>
            @endif -->*/?>
            <li class="{{request()->routeIs('user*','doctor*','nurse*') ? 'active' : ''}}">
              <div>
                <a href="{{route('user.list')}}">
                  <span class="material-symbols-outlined @if(isset($menucls) && $menucls == 'users') active @endif ">person</span>
                  <p class="mb-0">Users</p>
                </a>
              </div>
            </li>
            
            @if(session()->get('user.userType') == 'clinics')
              <li class="{{ request()->is('reports*') ? 'active' : '' }}">
                <a href="{{ route('reports.listing') }}">
                  <span class="material-symbols-outlined @if(isset($menucls) && $menucls == 'revenue') active @endif">bar_chart</span>
                  <p class="mb-0">Revenue Reports</p>
                </a>
              </li>
            @endif
            
            <li class="{{request()->routeIs('notification*') ? 'active' : ''}}">
              <div>
                <a href="{{route('notification')}}">
                  <span class="material-symbols-outlined">notifications_active</span>
                  <p class="align_middle gap-2 mb-0">Notifications
                    @if($notificationCount > 0)
                      <span class="badge notftn-count align_middle">
                        {{ $notificationCount }}
                      </span>
                    @endif
                  </p>
                </a>
              </div>
            </li>

            <?php /* <li class="{{request()->routeIs('payouts*') ? 'active' : ''}}">
              <div>
                <a href="{{url('payouts')}}">
                  <span class="material-symbols-outlined">assured_workload</span>
                  <p class="mb-0">Payouts
                   
                  </p>
                </a>
              </div>
            </li> */ ?>
              

            <li class="{{request()->routeIs('support*') ? 'active' : ''}}">
              <div>
                <a href="{{url('support')}}">
                  <span class="material-symbols-outlined">headphones</span>
                  <p class="mb-0">Support</p>
                </a>
              </div>
            </li>

            @if(session()->get('user.userType') == 'patient' )
            <li class="{{request()->routeIs('payment*') ? 'active' : ''}}">
              <div>
                <a href="{{url('payment/myreceipts')}}">
                  <span class=" material-symbols-outlined">receipt</span>
                  <p class="mb-0">My Receipt</p>
                </a>
              </div>
            </li>
            @endif

          </ul>
          <ul class="sidebar-nav nav-toggle pt-0 pb-1">
            <li>
              <div>
                <a href="javascript:void(0)" class="sidebar-toggle">
                  <span class="material-symbols-outlined"> close_fullscreen </span>
                  <p class="mb-0">Toggle Menu</p>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </aside>

      @if (session()->has('success'))
      <!-- <div class="alert alert-success msg mt-2  mb-4 pt-2 pb-2">
      {{session()->get('success')}}
      </div> -->
      <script>
          
  
          
         document.addEventListener('DOMContentLoaded', function() {
          const successMessage = "{{ session()->get('success') }}";
        
        if (successMessage) {
            // Show the SweetAlert success message
            swal({
                title: "Success!",
                text: successMessage,
                icon: "success",
                buttons: false,  // Optional: Hide the button (no user interaction needed)
                timer: 4000      // Automatically close after 4 seconds (4000ms)
            }).then(() => {
                console.log("Success message closed");
            });
        }
        });
      </script>
      @endif

      @if (session()->has('error'))
      <div class="">
        {{-- {{session()->get('error')}} --}}

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            swal({
              title: 'Error!',
              text: "{{ session()->get('error') }}",
              icon: 'warning',
              confirmButtonText: 'OK'
            });
          });
        </script>
      </div>

      @endif

      @yield('content')



      <script>
          
      function handleError(xhr) {
        if (xhr.status === 419) {
        // Session expired logic
        const response = JSON.parse(xhr.responseText);
        if (response.message) {
            swal({
                icon: 'error',
                title: 'Session Expired',
                text: 'Your session has expired. Please log in again.',
                buttons: {
                    confirm: {
                        text: 'OK',
                        value: true,
                        visible: true,
                        className: 'btn-danger'
                    }
                }
            }).then(() => {
                var toURL = "{{ URL::to('/login')}}";
                // Redirect to the login page
                window.location.href = toURL;  // Explicit login redirect instead of reloading
            });
        }
    } 
}

          $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
        const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        function globalSearch(sendAJAX='0',isloadmore='0'){
       
            if( $("#globalsearchadmin").valid() || searchTerm !=''){
                
                if( (sendAJAX == 0) && ($("#last_searchid").val() == 0) && isloadmore == '1'){
                    return;
                }
                var lastSearchId = ( $("#last_searchid").length > 0 ) ? $("#last_searchid").val() : 0;

                var searchterm =$("#search-input-admin").val();
                if( $(".append_admin_global_search").length > 0 ){
                
                  globalSearchAjax(searchterm);

                }else{

                  var toURL = "{{ URL::to('/globalsearchlist')}}";
                  var searchterm = $('#search-input-admin').val();

                  if (searchterm.trim() !== "") {
                      toURL += "?search=" + encodeURIComponent(searchterm);
                  }
                        
                  window.location.href = toURL;

                }

            }
        }

        function globalSearchAjax(searchterm,sendAJAX='0',isloadmore='0'){
          if( $("#globalsearchadmin").valid() || searchterm !=''){
                
                if( (sendAJAX == 0) && ($("#last_searchid").val() == 0) && isloadmore == '1'){
                    return;
                }
                var lastSearchId = ( $("#last_searchid").length > 0 ) ? $("#last_searchid").val() : 0;
            }
          $.ajax({
                type: "POST",
                async:true,
                url: "{{ URL::to('globalsearch')}}",
                data: {
                    "searchterm": searchterm,
                    "isloadmore":isloadmore,
                    "lastSearchId":lastSearchId,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',

                success: function(data) {
                    if (data.success == 1) {
                      
                      if(data.lastSearchId == 0){
                            $('#send_ajax_search').val('0');
                            sendAJAX =0;
                      }

                      if(lastSearchId != 0 && isloadmore ==1 ){
                          
                          if(data.lastSearchId != 0){
                              $(".append_admin_global_search").append(data.view);
                          }
                          
                        }else{
                            $(".append_admin_global_search").html(data.view);
                        }  
                        var searchTerms = $("#search-input-admin").val();
                       $('#last_searchid').val(data.lastSearchId);
                    }
                },  error: function(xhr) {
               
                  handleError(xhr);
              }
            });
        }
        $("#search-input-admin").bind("keypress", function(e) {
                if (e.keyCode == 13)
                {
                    e.preventDefault();
                    globalSearch();
                }
            });
        function changeClinic() {
          $("#change_clinic_modal").modal('show');
          showPreloader('cliniclist');

          $.ajax({

            url: '{{ url("/workspace/change") }}',
            type: "post",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
              // checkSession(data);
              if (data.success == 1) {
                $("#cliniclist").html(data.view);
              }
            }, error: function(xhr, status, error) {
              handleError(xhr);
            }
          });
        }
        function selectPatient() {
          $.ajax({

            url: '{{ url("/workspace/select") }}',
            type: "post",
            data: {
              'type': 'patient',
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
              // checkSession(data);
              if (data.success == 1) {
                  changeClinicPayload();
                window.location.href=data.redirecturl;

              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
          });
        }

        function disconnectStripe() {
          swal({
              title: "",
              text: "Are you sure you want to disconnect Stripe?",
              icon: "warning",
              buttons: true,
              dangerMode: true,
          }).then((confirm) => {
            if (confirm) {
                event.preventDefault();

                // Show loader
                var loaderimgPath = "{{ asset('images/loader.gif') }}";
                $('#disconnectloader').html('<div class="modal-backdrop"><div class="modal-body text-center h-100"><img src="' + loaderimgPath + '" class="loaderImg"></div></div>');

                // Perform AJAX request
                $.ajax({
                    url: '{{ url("/disconnect/stripe") }}',
                    type: "post",
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Remove loader
                        $('#disconnectloader').empty();
                        console.log(data);
                        // Check if the operation was successful
                        if (data.success == 1) {
                            swal({
                                icon: 'success',
                                title: '',
                                text: data.message,
                                buttons: false,
                                timer: 2000 // Closes after 2 seconds
                            }).then(() => {
                              tabContent('stripe_info');
                            });
                        } else {
                            swal({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Something went wrong.'
                            });
                        }
                    },
                    error: function(xhr) {
                        
                      handleError(xhr);
                    }
                });
            }
        });
      }
        function selectTeam(clinicID) {

          $.ajax({

            url: '{{ url("/workspace/select") }}',
            type: "post",
            data: {
              'clinicID': clinicID,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
              // checkSession(data);
              if (data.success == 1) {
                  changeClinicPayload();
                
                  window.location.href=data.redirecturl;

              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
          });
        }

        function addClinic() {
          $.ajax({
            url: '{{ url("add/workspace") }}',
            type: "post",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                $("#registerUser").modal('show');
                $("#registerUserForm").html(data.view);
                  // Initialize all inputs on page load
                $('input, textarea').each(function () {
                    toggleLabel(this);
                });
                initializeAutocompleteClinic();
              } else {

              }
            }, 
            error: function(xhr) {
               
              handleError(xhr);
            },
          });

        }


        // Function to toggle the 'active' class

        function toggleLabel(input) {
          const hasValueOrFocus = $.trim(input.value) !== '';
         
          $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
        }

        $(document).ready(function() {
            
            $("#globalsearchadmin").validate({
            ignore: [],
            rules: {
                searchterm: {
                    required: true
                },
            },
            messages: {
                searchterm: {
                    required: "Please enter search value"
                },
            },errorPlacement: function(error, element) {
                  if( element.hasClass("global-search")) {
                    error.appendTo( element.parent('div') );
                  }else{
                      error.insertAfter(element); 
                  }
                }
            });
          // Initialize label state for each input
          $('input').each(function() {
            toggleLabel(this);
          });

          // Handle label toggle on focus, blur, and input change
          $(document).on('focus blur input change', 'input, textarea', function() {
            toggleLabel(this);
          });

          // Handle the datetime picker widget appearance by re-checking label state
          $(document).on('click', '.bootstrap-datetimepicker-widget', function() {
            const input = $(this).closest('.time').find('input');
            toggleLabel(input[0]);
          });

          // Trigger label toggle when modal opens
          $(document).on('shown.bs.modal', function(event) {
            const modal = $(event.target);
            modal.find('input, textarea').each(function() {
              toggleLabel(this);
              // Force focus briefly to trigger label in case of any timing issues
              $(this).trigger('focus').trigger('blur');
            });
          });

          // Reset label state when modal closes
          $(document).on('hidden.bs.modal', function(event) {
            const modal = $(event.target);
            modal.find('input, textarea').each(function() {
              $(this).parent().find('.float-label').removeClass('active');
            });
          });
        });



      </script>





      <!-- change clinic -->

      <div class="modal login-modal fade" id="change_clinic_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center position-relative" id="cliniclist">

            </div>
          </div>
        </div>
      </div>

      <!-- change clinic -->

      <div class="modal login-modal fade" id="videomeet_modal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content" id="videomeet">

          </div>
        </div>
      </div>


      


      <!-------------------------------- add clinic  --------------------------------->

      <div class="modal login-modal fade" id="registerUser" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a data-bs-dismiss="modal" aria-label="Close"><span
                  class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center" id="registerUserForm">



            </div>
          </div>
        </div>
      </div>

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




      <script>
        function showPreloader(parmID,className='') {
          var loaderimgPath = "{{ asset('images/loader.gif') }}";
          $('#' + parmID).html('<div class="text-center '+ className +'"><img src="' + loaderimgPath + '" class="loaderImg"></div>');
        }
      </script>

      <!-- Appointment section for darshboard and view pages -->

      <!-- Appointment Create Modal -->

      <div class="modal login-modal fade" id="addAppointment" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span
                  class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
              <div class="text-center">
                <h4 class="text-center fw-medium mb-0">Add New Appointment</h4>
                <small class="gray">Please enter patient details and create an appointment.</small>
              </div>
              <div id="appointment_create_modal">

                <!-- Include the Modal Form here -->

              </div>
            </div>
          </div>
        </div>
      </div>



      <!-- Appointment Edit Modal -->
      <div class="modal login-modal fade" id="editAppointment" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span
                  class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
              <div class="text-center">
                <h4 class="text-center fw-medium mb-0">Edit Appointment</h4>
                <small class="gray">Please enter patient details and create an appointment.</small>
              </div>
              <div id="appointment_edit_modal">

                <!-- Include the Modal Form here -->

              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Notes Modal-->

      <div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel"
        aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="text-center">
                <h4 class="fw-bold mb-0" id="appointmentNotesLabel">Appointment Notes</h4>
              </div>
              <p id="appointmentNotesData">

              </p>
              <div class="btn_alignbox justify-content-end mt-4">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Add New Patient -->

      <div class="modal login-modal fade" id="addPatientModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
          <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->

            </div>
            <div class="modal-body text-center position-relative" id="addPatientform">

            </div>
          </div>
        </div>
      </div>
        

  <!-- Success Payment -->
  
              <div class="modal login-modal fade" id="paymentsuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                  <div class="modal-content">
                      <div class="modal-header modal-bg p-0 position-relative">
                          <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                      </div>
                      <div class="modal-body text-center">
                        <img src="{{asset('images/success-img.png')}}" class="img-fluid p-3">
                        <h4 class="text-center fw-bold mb-0">Booking Confirmed</h4>
                        <small class="gray">You can now meet the doctor at the allotted time</small>
                      </div>
                    </div>
                  </div>
                </div>
  
          <!--- Payment end ---->
      <script>
          
          $(document).ready(function() {
            //showTrialInfo();
            $('.otp-input-field').on('keyup input', function(e) {
              var key = e.which || e.keyCode;
              var $currentField = $(this);
              var $nextField = $currentField.next('.otp-input-field');
              var $prevField = $currentField.prev('.otp-input-field');

              // Move to the next field on valid input (0-9 from both main row and keypad)
              if ($currentField.val().length === 1 && ((key >= 48 && key <= 57) || (key >= 96 && key <= 105))) {
                  if ($nextField.length) {
                      $nextField.focus();  // Move to the next input field
                  }
              }

              // Move to the previous field on backspace
              if (key === 8 && $prevField.length && $currentField.val().length === 0) {
                  $prevField.focus();  // Move to the previous input field
              }


              // Prevent non-numeric input (for both main number row 0-9 and numeric keypad)
              if ((key < 48 || key > 57) && (key < 96 || key > 105)) {
                  e.preventDefault();
              }

              // Check if all fields are filled
              if ($('.otp-input-field').filter(function () { return this.value.length === 0; }).length === 0) {
                  // Combine the OTP fields' values into the hidden input
                  let otp = $('.otp-input-field').map(function () {
                      return this.value;
                  }).get().join('');
                  $('#otp_value').val(otp);

                  // Automatically call verifyOtp if all fields are filled
                  verifyOtp();
              }
            });
        });
        function showTrialInfo(){
          $.ajax({
            type: "POST",
            url: "{{ URL::to('/gettrialinfo')}}",
            data: 
            {"_token": "{{ csrf_token() }}"},
            dataType : 'json',
            success: function(data) {  
              if(data.success==1){
                $(".trialdivappend").append(data.view);
                if( data.view != ''){
                  $(".subcriptiondiv").addClass("trial_msg_top");
                }
              }      
            }, error: function(xhr, status, error) {
              if (xhr.status == 419) {
                // Handle 419 error, e.g., show a message and redirect to the login page
                const response = JSON.parse(xhr.responseText);
                window.location.reload();
              }
            }
          });
        }
        function createPatient(type ='',createdfrom='') {

          $("#addAppointment").modal('hide');
          $("#addPatientModal").modal('show');

          showPreloader('addPatientform')
          $.ajax({
            url: '{{ url("/patients/create") }}',
            type: "post",
            data: {
              type : type ,
              createdfrom : createdfrom,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                $("#addPatientform").html(data.view);
                $('#patientform')[0].reset(); // Reset the form
                initializeAutocomplete();
               
                loadColorBox();
              }
            }, 
            error: function(xhr) {
               
              handleError(xhr);
            },
          });
        }
        function loadColorBox(){
            $(".aupload").colorbox({
                iframe: true,
                width: "650px",
                height: "650px"
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

        function submitPatient(type='') {

          if ($("#patientform").valid()) {
            $("#submitpatient").addClass('disabled');
            $("#submitpatient").text("Submitting...");
            $.ajax({
              url: '{{ url("/patients/store") }}',
              type: "post",
              data: {
                'formdata': $("#patientform").serialize(),
                '_token': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                if (data.success == 1) {
                  if(data.createdfrom == 'frommodal'){
                    $("#addPatientModal").modal('hide');
                    $("#addAppointment").modal('show');
                    $('#patient_input').val(data.patientid);
                    $('#select_patient_label').text(data.patientname);
                    $('#search_li').append('<li  class="dropdown-item  select_patient_list" style="cursor:pointer"><div class="dropview_body profileList profileList-patient"><p class="select_patient_item" data-id="' + data.patientid + '">' + data.patientname + '</p></div></li>')
                    $("#nopatients").hide();
                    $("#nopatients").css("display", "none");
                  }else{
                    swal(data.message, {
                      title: "Success!",
                      text: data.message,
                      icon: "success",
                      buttons: false,
                      timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                      
                    });
                    $('#patient_input').val(data.patientid);
                    $("#addPatientModal").modal('hide');
                    $("#nopatients").hide();
                    $("#nopatients").css("display", "none");
                    if(type == 'patient'){
                      window.location.reload();
                    }
                  }
                
                } else {
                  swal("Error!", data.message, "error");
                    $("#submitpatient").removeClass('disabled');
            $("#submitpatient").text("Submit");

                }
              },
              error: function(xhr) {
               
                handleError(xhr);
              },
            });
          }
        }

        function editAppointment(key, status, type, userType) {
        
          $("#editAppointment").modal('show');

          $('#appointment_edit_modal').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');
         
          $.ajax({
            type: "POST",
            url: '{{ url("/appointments/edit") }}',
            data: {
              'key': key,
              'status': status,
              'type': type,
              'userType': userType,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },

            success: function(response) {
              // Populate form fields with the logger details

              if (response.success == 1) {
              
                $("#appointment_edit_modal").html(response.view);
              }else{
                swal("Error", response.message, "error");
              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
          });
          // });

        }

        function notes(uuid) {

          $("#appointmentNotes").modal('show');
          var uuid = uuid;
          var url = "{{route('appointment.note')}}";
          $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');

          $.ajax({
            type: "POST",
            url: url,
            data: {
              'uuid': uuid,
            },
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
              // Populate form fields with the logger details
              if (response.status == 1) {
                if (response.note && response.note.trim() !== '') {
                  $("#appointmentNotesData").html(response.note.replace(/\n/g, '<br>'));
                } else {
                  $("#appointmentNotesData").text("No notes found!");
                }
              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
          });

        }

        //Create appointment Blade View function
        // $(document).on("click", "#appointment_create", function() {

        function createAppointment(date='') {
          console.log(date);
         
          $.ajax({
            type: "GET",
            url: '{{ url("/appointments/create") }}',
            data: {
              'selecteddate': date,
            },
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
              // Populate form fields with the details
              if (response.status == 1) {
                $('#addAppointment').modal('show');
                showPreloader('appointment_create_modal');

                $("#appointment_create_modal").html(response.view);
              }else {
                $('#addAppointment').modal('hide');
                swal({
                    title: "Warning!",
                    text: response.errormsg,
                    icon: "warning",
                    buttons: false,
                    timer: 3000 // Closes after 2 seconds
                }).then(() => {
                  window.location.href = "{{url('/profile?tab=payment')}}";
                 
                });
                
              }
            }, 
            error: function(xhr) {
               
              handleError(xhr);
            }
          });
        }
        // });
        function joinMeet(appoinment_uuid) {
          $('#videomeet_modal').modal('show');
          $('#videomeet').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');

          $.ajax({
            type: "POST",
            url: "{{url('appointments/joinvideo')}}",
            data: {
              'appoinment_uuid': appoinment_uuid,
            },

            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
              // Populate form fields with the logger details

              if (response.success == 1) {
               
                $("#videomeet").html(response.view);

              }else{
                $('#videomeet_modal').modal('hide');
                swal({
                     icon: 'error',
                     text: response.message,
                   });
              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            }
          });

        }
        function resendCountdown() {
            var timerDuration = 30; // Duration in seconds
            var timer = timerDuration; // Set the initial timer value


            // Start the countdown
            var countdown = setInterval(function () {
                if (timer > 0) {
                    $('#resendOtp').addClass('disabled');
                    $('#timer').text(' in ' + timer + 's');
                    timer--;
                } else {
                    // Enable the Resend OTP link after countdown
                    clearInterval(countdown);
                    $('#timer').text(''); // Clear the timer text
                    $('#resendOtp').removeClass('disabled'); // Enable the link
                    $('#resendOtp').off('click'); // Remove the previous click event to allow resending
                }
            }, 1000); // 1 second interval


        }
        function resendOtp() {
          $.ajax({
              url: '{{ url("frontend/submitlogin") }}',
              type: "post",
              data: {
                  'formdata': $("#verifyotpform").serialize(),
                  '_token': $('input[name=_token]').val()
              },
              success: function (data) {
                  if (data.success == 1) {
                      $("#login").hide();
                      $("#otpform_modal").modal('show');
                      $('.otp-input-field').val('');
                      // $("#otpform").show();
                      $("#otpkey").val(data.key);
                      $("#phonenumbers").val(data.phonenumber);
                      $("#countrycode").val(data.countrycode);
                      $("#countryCodeShort").val(data.countryCodeShort);
                      $("#countryCodeShorts1").val(data.countryCodeShort);

                      swal(
                          "Success!",
                          "An OTP has been sent to your registered phone number.(" + data.otp + ")",
                          "success",
                      ).then(() => {
                          console.log(data);

                      });
                      resendCountdown()
                  } else {

                  }
              },
              error: function(xhr) {
            
                  handleError(xhr);
              }
          });

          }

        
        function markAsRead(key){
          $.ajax({
            type: "POST",
            url: '{{ url("/notifications/markasread") }}',
            data: {
              'notification_key' : key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                  window.location.href = response.redirectUrl;
                }
            
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
        })
      }

      function addnotes(type){
        if(type == 'add'){
          $("#addnotes").show();
          $("#remove").show();
          $("#add").hide();
        }else{
          $("#addnotes").hide();
          $("#remove").hide();
          $("#add").show();
        }
      }

      </script>

    </div>
  </div>
  <footer>
    <div class="d-flex justify-content-lg-between flex-lg-row flex-column align-items-center">
      <div class="text-lg-start text-center"> 
        <img src="{{ asset("images/transpernt_logo.png")}}" class="img-fluid logo">
      </div>
      <div class="text-center my-lg-0 my-1">
        <p> Copyright © {{env('APP_NAME')}} {{date('Y')}}. All rights reserved.</p>
      </div>
      <div>
        <ul class="social-media">
          <li><a><i class="fa-brands fa-facebook-f"></i></a></li>
          <li><a><i class="fa-brands fa-x-twitter"></i></a></li>
          <li><a><i class="fa-brands fa-instagram"></i></a></li>
        </ul>
      </div>
    </div>
  </footer>
</body>

</html>


<div class="modal login-modal fade" id="editpatientModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->

      </div>
      <div class="modal-body text-center position-relative" id="editpatient">
        <h4 class="text-center fw-medium mb-0 ">Edit Patient</h4>




      </div>
    </div>
  </div>
</div>
<div class="modal login-modal fade" id="otpform_modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" >
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a aria-label="Close" onclick="closeOtpModal()"><span
                        class="material-symbols-outlined">close</span></a>
            </div>

            <div class="modal-body text-center">
                <h4 class="text-center fw-bold mb-0">Verify Phone Number</h4>
                <p>OTP has been sent to<span class="fw-medium primary phn-otp ms-2" id="otpPhone"></span></p>

                <form method="POST" id="verifyotpform">
                    @csrf
                    <div class="form-group otp-input position-relative my-4">
                        <input type="text" class="form-control otp-input-field" id="otp1" maxlength="1">
                        <input type="text" class="form-control otp-input-field" id="otp2" maxlength="1">
                        <input type="text" class="form-control otp-input-field" id="otp3" maxlength="1">
                        <input type="text" class="form-control otp-input-field" id="otp4" maxlength="1">
                        <input type="hidden" name="otp" id="otp_value" class="form-control">
                        <input type="hidden" name="hasOtp" id="hasOtp" class="form-control" value="1">
                        <input type="hidden" name="type" id="type" class="form-control" value="@if(isset($type)) {{$type}} @else patient @endif">
                    </div>
                    <input type="hidden" name="otpkey" class="form-control" id="otpkey">
                    <input type="hidden" name="phonenumber" class="form-control" id="phonenumbers">
                    <input type="hidden" name="countrycode" class="form-control" id="countrycode">
                    <input type="hidden" name="countryCodeShort" class="form-control" id="countryCodeShorts1">
                    <input type="hidden" name="countryId" class="form-control" id="countryId">
                    <p id="credslabel" class="top-error"></p>
                </form>


                <div class="btn_alignbox mt-3">
                    <a href="javascript:void(0)" onclick="verifyOtp()" class=" btn btn-primary w-100 btndisable">Verify</a>
                </div>
                <div class="text-center mt-4">
                    <p class="fwt-light">Didn’t get OTP Code?</p>
                    <p>
                        <a onclick="resendOtp()" href="javascript:void(0)" id="resendOtp"
                            class="primary fw-medium text-decoration-underline">Resend OTP</a>
                        <span id="timer timeR" class="gray ms-2"> in 30s</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
  <div id="slide-popup" class="popup join-popup" style="display:none;">
        <div class="popup-content">
            <!-- <span id="close-popup" class="close-btn">&times;</span> -->
            
            <div class="user_inner">
              <img src="{{ asset('images/default_img.png') }}" alt="patient" id="profileimage">
              <div class="user_info">
                  <h6 class="primary fw-medium m-0 pb-1">Patient Waiting</h6>
                  <p class="m-0" ><span class="primary fw-medium" id="slide-message-user"></span><span id="slide-message"></span></p>
              </div>
            </div>
            <div class="btn_alignbox ms-md-3 mt-md-0 mt-3">
              <button type="button" class="slide-close" id="closeSlidePopup">Close</button>
              <button class="slide-btn align_middle" id="joinCallBtn"><span class="material-symbols-outlined">videocam  </span>Join Call</button>
            </div>
        </div>
    </div>
<script>
  $(document).ready(function() {
    // Initialize form validation
    $("#verifyotpform").validate({
                ignore: [],
                rules: {
                    otp: {
                        required: true,
                        minlength: 4 // Ensure at least 4 digits
                    }
                },
                messages: {
                    otp: {
                        required: 'Please enter OTP.',
                        minlength: 'OTP must be at least 4 digits long.'
                    }
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element); // Place error messages after the input fields
                }
            });
          });
function getNotificationsList(selectedDate='') {
  
 
        showPreloader('notificationlist');
        $.ajax({
            type: "POST",
            url: '{{ url("/notifications/list") }}',
            data: {
              'date': selectedDate,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                   $("#notificationlist").html(response.view);
                }
             
            }, 
            error: function(xhr) {
               
              handleError(xhr);
            },
        })
    }
    function appointmentExist(){
      var url = "{{url('users/checkappointmenttagged')}}";
      $.ajax({
        type: "POST",
        url: url,
        data: {
            '_token': $('input[name=_token]').val()
        },
        success: function (data) {
          if (data.success == 1) {
            deleteuser()
          }else if(data.error == 1){
            swal(
                "Warning!",
                data.errormsg,
                "warning",
            ).then(() => {
                console.log(data);
            });
          }
        }
      });
    }
    function deleteuser() {
        var url = "{{url('users/deleteclinicuser')}}";
        swal("Are you sure you want to delete your account?", {
            title: "Delete!",
            icon: "warning",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
               // Show loader
               var loaderimgPath = "{{ asset('images/loader.gif') }}";
                $('#disconnectloader').html('<div id="loaderdeluser" class="modal-backdrop"><div class="modal-body text-center h-100"><img src="' + loaderimgPath + '" class="loaderImg"></div></div>');


                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                      
                      $('#loaderdeluser').remove();
                      $('#disconnectloader').empty();
                        if (data.success == 1) {
                            $("#otpform_modal").modal('show');
                            $('#otp1').focus();
                            $("#otpkey").val(data.key);
                            $("#phonenumbers").val(data.phonenumber);
                            $("#countrycode").val(data.countrycode);
                            $("#countryCodeShorts").val(data.countryCodeShort);
                            $("#countryCodeShorts1").val(data.countryCodeShort);
                            $("#countryId").val(data.countryId);
                            $('#otpPhone').text(data.countrycode + ' ' + data.phonenumber);
                            $("#type").val(data.type);
                            swal({
                                title: "Success!",
                                text: "An OTP has been sent to your registered phone number.(" + data.otp + ")" ,
                                icon: "success",
                                buttons: false,
                                timer: 2000 // Closes after 2 seconds
                            }).then(() => {
                                console.log(data);
                            });
                            resendCountdown();
                        }else if(data.error == 1){
                            swal(
                                "Warning!",
                                data.errormsg,
                                "warning",
                            ).then(() => {
                                console.log(data);
                            });
                        } else {
                            showOtpError(data.errormsg, 'login');
                            swal(
                                "Error!",
                                data.errormsg,
                                "error",
                            ).then(() => {
                                console.log(data);
                            });
                        }
                    },
                    error: function(xhr) {
                        handleError(xhr);
                    }
                });
                // Cancel the request if the nurse navigates away
                $(window).on("unload", function () {
                    xhr.abort();
                });
            }
        });
    }
    function closeOtpModal() {
        $('#otpform_modal').modal('hide');
        $('#verifyotpform')[0].reset();
    }
    function verifyOtp() {
        var otpValue = '';
        $('.otp-input-field').each(function () {
            otpValue += $(this).val();
        });
        $('#otp_value').val(otpValue);
        $('.btndisable').addClass("disabled");
        if ($("#verifyotpform").valid()) {
            $.ajax({
                url: '{{ url("users/verifyotp") }}',
                type: "post",
                data: {
                    'formdata': $("#verifyotpform").serialize(),
                    '_token': $('input[name=_token]').val()
                },
                success: function (data) {
                    if (data.success == 1) {
                  
                        console.log(data.token);
                        if (data.token == 'delete') {
                            window.location.href = "{{route('logout')}}";
                        }
                        $("#otpform_modal").modal('hide');

                        swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                          window.location.href = "{{url('/login')}}";
                        });

                        // swal(
                        //     "Success!",
                        //     data.message,
                        //     "success",
                        // ).then(() => {
                        //     window.location.href = "{{url('/login')}}";
                        //     console.log(data);
                        // });
                    }else if(data.error == 1){
                        swal(
                            "Error!",
                            data.errormsg,
                            "error",
                        ).then(() => {
                            console.log(data);
                        });
                        $('.otp-input-field').val('');
                        $('#otp_value').val('');
                        $('.btndisable').removeClass("disabled");
                        $('.otp-input-field').each(function() {
                            $(this).blur(); // Remove focus from all OTP fields
                        });
                        $('.otp-input-field').first().focus();
                    } else {
                        $('.otp-input-field').val('');
                        $('#otp_value').val('');
                        $('.btndisable').removeClass("disabled");
                        showOtpError('Invalid OTP. Please try again.');
                    }
                },
                error: function(xhr) {
                    
                    handleError(xhr);
                },
            });
        }else{
            $('.btndisable').removeClass("disabled");
        }
    }

        // Function to display OTP error message dynamically
        function showOtpError(message, type = '') {
            var otpField, errorElement;

            if (type == 'login') {
                otpField = $('#credslabel'); // The field where the OTP is entered
                errorElement = $('<label class="error"></label>').text(message);
                otpField.html(errorElement);
                $('.otp-input-field').each(function() {
                $(this).blur(); // Remove focus from all OTP fields
            });
            } else {
                otpField = $('#otp_value'); // The field where the OTP is entered
                errorElement = $('<label class="error"></label>').text(message); // Create the error label
                otpField.after(errorElement); // Insert error message after the OTP input field
                $('.otp-input-field').each(function() {
                $(this).blur(); // Remove focus from all OTP fields
            });
            $('.otp-input-field').first().focus();
            }



            // Fade out the error message after 10 seconds
            setTimeout(function() {
                // errorElement.fadeOut(500, function() {
                //     $(this).remove(); // Remove the element from the DOM after fading out
                // });
            }, 3000); // 10000 milliseconds = 10 seconds

        }


    document.addEventListener("DOMContentLoaded", function () {
    const closeBtn = document.querySelector(".slide-close");
    const popup = document.getElementById("slide-popup");
    const popupContent = document.querySelector(".popup-content");

    
});

        
</script>
<style>
    /* Fix Google Autocomplete dropdown inside modal */
    .pac-container {
        z-index: 9999 !important;
    }
</style>

 <!-- google address auto fill -->
 <script>
  let autocomplete; // Store autocomplete globally
  function initializeAutocomplete() {
    let addressInput = document.getElementById('address');
    if (addressInput) {
        addressInput.setAttribute("placeholder", ""); // Ensures no placeholder
    }

    if (typeof google === "undefined" || !google.maps || !google.maps.places) {
        console.error("Google Maps API failed to load. Please check your API key.");
        return;
    }

    let input = document.getElementById('address');
    if (!input) {
        console.log("Address input field NOT found!");
        return;
    }

    let countryDropdown = document.querySelector('.autofillcountry'); // Get country code
    let defaultCountry = countryDropdown ? countryDropdown.value : "US"; // Default to US

    autocomplete  = new google.maps.places.Autocomplete(input, {
        types: ['geocode', 'establishment'],
         componentRestrictions: { country: defaultCountry } // Restrict to US addresses
    });

    console.log("Google Places Autocomplete initialized successfully.");

    autocomplete.addListener('place_changed', function () {
        console.log("Place changed event triggered.");
        
        var place = autocomplete.getPlace();
        if (!place || !place.address_components) {
            console.error("No address components found.");
            return;
        }
       // console.log(place);
        var addressComponents = {
          street_number: "",
          street: "",
          city: "",
          state: "",
          zip: "",
          country: ""
        };

        place.address_components.forEach(component => {
          const types = component.types;

          if (types.includes("street_number")) {
              addressComponents.street_number = component.long_name;
          }

          if (types.includes("route")) {
              addressComponents.street += (addressComponents.street ? " " : "") + component.long_name;
          }

          if (types.includes("locality")) {
              addressComponents.city = component.long_name;
          }

          if (types.includes("administrative_area_level_1")) {
              addressComponents.state = component.short_name;
          }

          if (types.includes("postal_code")) {
              addressComponents.zip = component.long_name;
          }

          if (types.includes("country")) {
              addressComponents.country = component.long_name;  // ✅ This should catch the country
          }
        });
        

        console.log("Extracted Address Components:", addressComponents);

        function safeSetValue(id, value) {
            let element = document.getElementById(id);
            if (element) {
                element.value = value;
                let label = element.closest(".form-group")?.querySelector(".float-label");
                if (label && value.trim() !== "") {
                    label.classList.add("active");
                   
                }
            }
        }

         /* --- extract the usual pieces --- */
          const comps = { street_number:"", street:"", city:"", state:"", zip:"", country:"" };

        place.address_components.forEach(c => {
          if (c.types.includes("street_number"))               comps.street_number = c.long_name;
          if (c.types.includes("route"))                       comps.street        = c.long_name;
          if (c.types.includes("locality"))                    comps.city          = c.long_name;
          if (c.types.includes("administrative_area_level_1")) comps.state         = c.short_name;
          if (c.types.includes("postal_code"))                 comps.zip           = c.long_name;
          if (c.types.includes("country"))                     comps.country       = c.long_name;
        });

        /* ---- build first‑line without duplicates ---- */
        const streetLine   = `${comps.street_number} ${comps.street}`.trim();           // 12399 S Apopka Vineland Rd
        const nameIsStreet = place.name &&
                            streetLine &&
                            place.name.trim().toLowerCase() === streetLine.toLowerCase();

        const firstLineParts = [];
        if (place.name && !nameIsStreet) firstLineParts.push(place.name);               // add only if different
        if (streetLine)                  firstLineParts.push(streetLine);

        const firstLine = firstLineParts.join(", "); 

        console.log('addree'+firstLine);
        console.log('addree111'+addressComponents.street_number);
        safeSetValue('address', firstLine);
        // safeSetValue('address', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
        safeSetValue('city', addressComponents.city || '');
        safeSetValue('zip', addressComponents.zip || '');
        safeSetValue('state', addressComponents.state || '');
        safeSetValue('country', addressComponents.country || '');

        let stateDropdown = document.getElementById('state_id');
        if (stateDropdown) {
          for (let option of stateDropdown.options) {
            if (option.dataset.shortcode === addressComponents.state) {
              option.selected = true;
              break;
            }
          }
        }
        let countryDropdown = document.getElementById('country_id');
        if (countryDropdown) {
          for (let option of countryDropdown.options) {
            if (option.text.trim().toLowerCase() === addressComponents.country.trim().toLowerCase()) {
              option.selected = true;
              break;
            }
          }
        }
        $("#address, #city, #zip, #state_id").each(function () {
          $(this).valid(); 
        });
    });

  
    let focusedIndex = -1;
    let suggestions = [];
    let textarea = document.getElementById('address');

    // Add event listeners for keyboard navigation
    textarea.addEventListener('keydown', function(e) {
        const suggestionsList = document.getElementsByClassName('pac-container')[0];
        if (!suggestionsList) return;

        suggestions = suggestionsList.getElementsByClassName('pac-item');
        
        // Handle special keys
        switch(e.key) {
            case 'ArrowDown':
                // Only prevent default if suggestions are showing
                if (suggestions.length > 0) {
                    e.preventDefault();
                    focusedIndex = Math.min(focusedIndex + 1, suggestions.length - 1);
                    updateFocus();
                }
                break;

            case 'ArrowUp':
                // Only prevent default if suggestions are showing
                if (suggestions.length > 0) {
                    e.preventDefault();
                    focusedIndex = Math.max(focusedIndex - 1, -1);
                    updateFocus();
                }
                break;

            case 'Enter':
                // Only prevent default if a suggestion is focused
                if (focusedIndex > -1 && suggestions.length > 0) {
                    e.preventDefault();
                    suggestions[focusedIndex].click();
                    focusedIndex = -1;
                }
                break;

            case 'Escape':
                focusedIndex = -1;
                textarea.blur();
                break;
        }
    });

    // Reset focus when the input changes
    textarea.addEventListener('input', function() {
        focusedIndex = -1;
    });
}

function updateFocus() {
        Array.from(suggestions).forEach((suggestion, index) => {
            if (index === focusedIndex) {
                suggestion.classList.add('pac-item-selected');
                suggestion.scrollIntoView({ block: 'nearest' });
            } else {
                suggestion.classList.remove('pac-item-selected');
            }
        });
    }

function updateAutocompleteCountry() {
    let selectedCountry = document.querySelector('.autofillcountry')?.value || 'US';
  console.log('new'+selectedCountry)
    if (autocomplete) {
        autocomplete.setComponentRestrictions({ country: selectedCountry });
    } else {
        initializeAutocomplete(); // Reinitialize if needed
    }
    $("#address, #city, #zip, #state_id,#state").each(function () {
        $(this).val(''); // Clear the input field
        toggleLabel(this);
    });
}

// Initialize on window load
window.onload = function () {
    initializeAutocomplete();
};


// function initializeAutocomplete() {

//     let addressInput = document.getElementById('address');
//     if (addressInput) {
//         addressInput.setAttribute("placeholder", ""); // Ensures no placeholder
//     }

//     // console.log("Initializing Google Places Autocomplete...");
//     if (typeof google === "undefined" || !google.maps || !google.maps.places) {
//         console.error("Google Maps API failed to load. Please check your API key.");
//         // alert("Error: Google Maps API failed to load. Check the console.");
//         return;
//     }

//     let input = document.getElementById('address');
//     if (!input) {
//         console.log("Address input field NOT found!");
//         return;
//     }

//     var autocomplete = new google.maps.places.Autocomplete(input, {
//         types: ['address'],
//         componentRestrictions: { country: "US" }
//     });

//     console.log("Google Places Autocomplete initialized successfully.");

//     autocomplete.addListener('place_changed', function () {
//         console.log("Place changed event triggered.");
        
//         var place = autocomplete.getPlace();
//         if (!place || !place.address_components) {
//             console.error("No address components found.");
//             // alert("Invalid address selection. Please choose a valid address from the dropdown.");
//             return;
//         }

//         var addressComponents = {
//             street_number: "",
//             street: "",
//             city: "",
//             state: "",
//             zip: ""
//         };

//         place.address_components.forEach(component => {
//             const types = component.types;
//             if (types.includes("street_number")) addressComponents.street_number = component.long_name;
//             if (types.includes("route")) addressComponents.street = component.long_name;
//             if (types.includes("locality")) addressComponents.city = component.long_name;
//             if (types.includes("administrative_area_level_1")) addressComponents.state = component.short_name;
//             if (types.includes("postal_code")) addressComponents.zip = component.long_name;
//         });

//         console.log("Extracted Address Components:", addressComponents);

//         // Safe function to prevent errors
//         function safeSetValue(id, value) {
//             let element = document.getElementById(id);
//             if (element) {
//                 element.value = value;

//                  // Add "active" class if the field is prefilled
//                 let label = element.closest(".form-group").querySelector(".float-label");
//                 if (label && value.trim() !== "") {
//                     label.classList.add("active");
//                 }

//             }
//         }

//         safeSetValue('address', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
//         safeSetValue('city', addressComponents.city || '');
//         safeSetValue('zip', addressComponents.zip || '');
//         safeSetValue('state', addressComponents.state || '');


//         // Select the state in the dropdown
//         let stateDropdown = document.getElementById('state_id');
//         if (stateDropdown) {
//             for (let option of stateDropdown.options) {
//               // console.log('op'+option.text)
//               //   console.log('optt'+addressComponents.state)

//                 if (option.dataset.shortcode === addressComponents.state) {
//                     option.selected = true;
//                     break;
//                 }
//             }
//         }
//     });
// }

checkVideoCall();
var socket = null; // Initialize socket variable

// Function to connect the WebSocket
function connectSocket() {
    const socketUrl = "{{env('WSS_SOCKET_END_POINT')}}";
    socket = new WebSocket(socketUrl);
const participantKey = "{{ Session::get('user.userSessionID') }}"; // Participant ID

    // WebSocket event listeners
    socket.onopen = function(event) {
        console.log('WebSocket connection opened.');
        // Define the JSON payload to send
        console.log('WebSocket connection established.');
        console.log("{{Session::get('socket.chats_participant_uuid')}}");

        const payload = {
            "action": "sendmessage",
            "data": {
                "event": "connect",
                "participant_uuid": participantKey
            }
        };
        const jsonPayload = JSON.stringify(payload);
        socket.send(jsonPayload);
        socket.onmessage = handleMessage;
    };

    socket.onerror = function(error) {
        console.error('WebSocket error:', error);
    };

    // Reconnect if the WebSocket connection is closed unexpectedly
    socket.onclose = function(event) {
        console.log("WebSocket connection closed unexpectedly. Reconnecting...");
        setTimeout(connectSocket, 3000); // Reconnect after 3 seconds
    };

   
}


// Function to handle incoming messages
function handleMessage(event) {
    console.log('Message received:', event.data);
    var jsonObj = JSON.parse(event.data);
    console.log(jsonObj)
    var eventValue = jsonObj.message;
    var eventValuekey = jsonObj.messageuser;
    var messageprofileimage = jsonObj.messageprofileimage;
    if(jsonObj.event =='changeclinic'){
          const clinic_id = "{{ Session::get('user.clinicID') }}"; // Participant ID
            if(jsonObj.clinic_id != clinic_id){
                swal("Error!", 'Clinic already switched in another tab.', "error");
                setTimeout(function(){ window.location.reload(); },2000);
            }
    }
    if(jsonObj.event =='waitingroom'){
         // Dynamically set the URL for the "Join Call" button
        const joinCallUrl = "{{url('meet/')}}/"+jsonObj.aptkey; // Assuming the URL comes from the response

        // Attach onclick event to the button after the AJAX response
        $('#joinCallBtn').click(function() {
            window.open(joinCallUrl, "_blank");
        });
        var roomKey = jsonObj.roomKey;
        
        
        showSlidePopup(roomKey,eventValue,eventValuekey,messageprofileimage);
        $("#closeSlidePopup").attr("onclick", "closeBtnEvent('"+roomKey+"')");
         $("#joinCallBtn").attr("onclick", "joinBtnEvent('"+jsonObj.aptkey+"')");
        getAppointments();
        online('open');
    }
    
}

// Call connectSocket to initiate the connection

connectSocket();
function changeClinicPayload(){
        const participantKey = "{{ Session::get('user.userSessionID') }}"; // Participant ID
        const clinic_id = "{{ Session::get('user.clinicID') }}"; // Participant ID


        const payload = {
            "action": "sendmessage",
            "data": {
                "event": "changeclinic",
                "participant_uuid": participantKey,
                "clinic_id": clinic_id
            }
        };
        const jsonPayload = JSON.stringify(payload);
        socket.send(jsonPayload);
}
function showSlidePopup(roomKey,message,eventValuekey,messageprofileimage) {
         const popup = document.getElementById('slide-popup');
        if(localStorage.getItem("videoslide_" + roomKey)){
           popup.style.display='none'; // Slide out
        }else{
          const popupMessage = document.getElementById('slide-message');
          const popupMessage1 = document.getElementById('slide-message-user');
          const profileimage = document.getElementById('profileimage');
         
          popupMessage.textContent = message || 'Fetching data...';
          popupMessage1.textContent = eventValuekey || '';
          profileimage.src =  messageprofileimage || '';
          popup.style.display='block'; // Slide out
          // popup.style.left='50%'; // Slide out
        }
       
    } 
        function closeBtnEvent(roomKey){
            localStorage.setItem("videoslide_"+roomKey, "close");
            const popup = document.getElementById('slide-popup');
            popup.style.display='none'; // Slide out
        }
    function getAppointments() {
      showPreloader('appointment-tbody','upcomingloadercls');
  
      $.ajax({
        type: "POST",
        url: '{{ url("/dashboard/appointmentlist") }}',
        data: {
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          // Handle the successful response
          if(response.success == 1){
            $("#appointment-tbody").html(response.view);
            $("#appointment-tbody").removeClass('upcomingloader');
          }
        },
        error: function(xhr) {
          if(xhr.status != 403){
            handleError(xhr);
          }
        },
        complete: function() {
          // Reset the flag to allow the request to be sent again
          isRequestProgress = false;
          console.log('Request complete');
        }
      })
    }
    function online(status, page = 1, perPage = 10) {
      var url = "{{route('appointment.appointmentList')}}";
      var baseUrl = "{{url('appointments')}}";
      var type = "{{ $_GET['type'] ?? '' }}";
      var newUrl = (type!='') ? baseUrl + "?status=" + status + "&type=" + type : baseUrl + "?status=" + status;

      // Update the URL in the browser's address bar without reloading the page
      window.history.pushState({ path: newUrl }, '', newUrl);
      $('#online-content').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');

      $.ajax({
        type: "get",
        url: url,
        data: {
          'status': status,
          'type': type,
          'page': page,
          'perPage': perPage,

        },
        success: function(response) {
          // Handle the successful response
          $("#online-content").html(response.html);

        },
        error: function(xhr, status, error) {
          // Handle any errors
          // window.location.reload();
          console.error('AJAX Error: ' + status + ': ' + error);
        },
      })
    }
    function checkVideoCall(){
      $.ajax({
        type: "POST",
        url: "{{ URL::to('checkvideocall')}}",
        data: {
          "_token": "{{ csrf_token() }}"
        },
        dataType: 'json',
        success: function(data) {
          if (data.success == 1) {
            if(data.message!=''){
                showSlidePopup(data.roomKey,data.message,data.messageuser,data.messageProfileImage);
                $("#closeSlidePopup").attr("onclick", "closeBtnEvent('"+data.roomKey+"')");
                $("#joinCallBtn").attr("onclick", "joinBtnEvent('"+data.aptkey+"')");
       
            }
          }
        },error: function(xhr) {
          handleError(xhr);
        }
      }); 
    }

     function joinBtnEvent(key){
            const popup = document.getElementById('slide-popup');
            popup.style.display='none'; // Slide out
            const joinCallUrl = "{{url('meet/')}}/"+key; // Assuming the URL comes from the response
            window.open(joinCallUrl, "_blank");
    }
    $(document).ready(function() {
      $(".logoutBtn").on("click",function() {
          localStorage.clear(); // Clears all stored data
        
      });
  });


  function enableAddOn(useruuid=''){
    $("#enableAddon").modal('show');
    showPreloader('appendaddondata')
    $.ajax({
      url: '{{ url("/users/enableaddon") }}',
      type: "post",
      data: {
        'useruuid': useruuid,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#appendaddondata").html(data.view);
          $('#enableAddon').find('input, textarea').each(function() {
            toggleLabel(this);
          });
          initializeAutocompleteBilling();

          // Restore form data if available
          var savedFormData = localStorage.getItem('enableAddonFormData');
          if (savedFormData) {
              savedFormData = JSON.parse(savedFormData)
              savedFormData.forEach(function(item) {
              var $el = $('#enableAddon [name="' + item.name + '"]');
              if ($el.length) {
                if ($el.is(':checkbox') || $el.is(':radio')) {
                  $el.each(function() {
                    if ($(this).val() == item.value) {
                      $(this).prop('checked', true);
                    }
                  });
                } else if ($el.is('select')) {
                  $el.val(item.value).trigger('change');
                } else {
                  $el.val(item.value).trigger('input').trigger('blur');
                }
              }
            });
            // Remove the saved data after restoring
            localStorage.removeItem('enableAddonFormData');
          }
        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      },
    });
  }
</script>


<!-- Users-enable add-on Modal -->
<div class="modal fade" id="enableAddon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl subscription-modal-xl ">
    <div class="modal-content subscription-modal p-0">
      <div class="modal-header modal-bg p-0 position-relative">
        <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body p-0" id="appendaddondata">

      </div>
    </div>
  </div>
</div>

<div class="modal login-modal fade" id="successSubscription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('images/success_signin.png')}}" class="img-fluid">
                <h4 class="text-center fw-medium mb-0 mt-4">Eprescription enabled successfully</h4>
                <!-- <small class="gray">Your addon subscription has been updated</small> -->
            </div>
        </div>
    </div>
</div>


<!-- Edit User Modal -->
<div class="modal login-modal fade" id="editUser_dotsepot" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editUse_dotsepot"></div>
    </div>
  </div>
</div>