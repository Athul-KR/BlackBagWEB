<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>" sizes="64x64" type="image/png">
  <meta name="keywords" content="HTML, CSS, JavaScript">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title> BlackBag | <?php echo $__env->yieldContent('title'); ?></title>

  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <!-- css -->
  <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/tele-med.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/navbar.css')); ?>">
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />


  <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>
  <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script src="<?php echo e(asset('js/main.js')); ?>"></script>


  <!-- Include Bootstrap DateTimePicker CDN -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script> -->


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>

  <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/colorbox.css')); ?>">
  <script type="text/javascript" src="<?php echo e(asset('js/jquery.colorbox.js')); ?>"></script>
  <script src="<?php echo e(asset('/tinymce/tinymce.min.js')); ?>" defer></script>


</head>

<body>
  <div class="wrapper-container">
    <div id="disconnectloader" class="disonnect-loader"> </div>
    <div id="navbar-wrapper" class="sticky-top">
      <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <div class="row">
              <div class="col-2 col-lg-3">
                <div class="d-flex align-items-center d-md-block d-none">
                  <img src="<?php echo e(asset('images/logo.png')); ?>" class="img-fluid logo">
                </div>
                <a href="javascript:void(0)" class="btn btn-primary res-menu d-md-none" data-bs-toggle="offcanvas"
                  href="#offcanvasExample" role="button" aria-controls="offcanvasExample"><span
                    class="material-symbols-outlined">
                    menu
                  </span>
                </a>

              </div>
              <div class="col-10 col-lg-9">
                <div class="d-flex align-items-center nav-top">
                    <form style="display:block;" id="globalsearchadmin" method="GET" action="">
                 
                  <div class="input-group search-box">
                    <div class="input-group-text" id="basic-addon1"><span class="material-symbols-outlined">
                        search
                      </span>
                    </div>
                    <input type="text" class="form-control" placeholder="Search for doctors, patients, and more..."
                      aria-label="Username" aria-describedby="basic-addon1" id="search-input-admin" value="<?php if(isset($searchValueAdmin)): ?><?php echo e(trim($searchValueAdmin)); ?><?php endif; ?>">
                      
                  </div>
                    </form>
                  <div class="right-sec">

                    <div class="notfctn-hd">
                      <div class="btn-group dropdown">
                        <button type="button " class="btn dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" onclick="getNotificationsList();">
                          <img src="<?php echo e(asset('images/notifications.png')); ?>" alt="">
                          <?php  $corefunctions = new \App\customclasses\Corefunctions; $notCount = $corefunctions->getUnreadNotCount(); ?>
                            <?php if($notCount > 0 ): ?><span class="btn-ntfcn"></span><?php endif; ?>
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
                            <?php

                            $corefunctions = new \App\customclasses\Corefunctions;

                            $clinicLogo = (session('user.clinicLogo') != '') ? session('user.clinicLogo') : asset('images/default_clinic.png');
                            $userLogo = (session('user.userLogo') != '') ? session('user.userLogo') : asset('images/default_img.png');
                            
                           
                            ?>

                            <img class="pfl-img" src="<?php echo e($userLogo); ?>">
                            <div class="pftl-txt-hd pftl-txt">
                              <span>Welcome</span>
                              <h6 class="mb-0 primary fw-medium"> <?php echo e(Session::get('user.firstName')); ?>

                                <?php echo e(Session::get('user.lastName')); ?>

                              </h6>

                            </div>
                          </div>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end profile-drpdown p-0 py-3">

                          <li class="px-3 mx-3">
                            <div class="d-flex align-items-center lst-prfl">
                              <img class="pfl-img me-2" src="<?php echo e($clinicLogo); ?>">
                              <div class="pftl-txt text-start">
                                <h6 class="mb-0 primary fw-medium"><?php echo e(Session::get('user.firstName')); ?>

                                  <?php echo e(Session::get('user.lastName')); ?>

                                </h6>
                                <small class="mb-0 gray"><?php echo e(Session::get('user.email')); ?></small>
                              </div>
                            </div>
                          </li>


                          <li class="px-3 mx-3">
                            <div class="switch_workspace border-top border-bottom">
                              <div class="workspace_text">
                                 <small>Current Organization</small> 
                                <h6 class="fw-medium m-0"><?php echo e(Session::get('user.clinicName')); ?></h6>
                              </div>
                              <?php if((Session::has('user.hasWorkSpace')) && Session::get('user.hasWorkSpace') == 1): ?>
                              <a onclick="changeClinic()" class="btn btn-primary">Switch Workspace</a>
                              <?php endif; ?>
                            </div>
                          </li>

                          <li class="px-3 mx-3">
                            <a <?php if(Session::get('user.userType')=='nurse' ): ?> href="<?php echo e(url('nurse/view/'.Session::get('user.clinicuser_uuid'))); ?>" <?php else: ?> href="<?php echo e(route('clinic.profile')); ?>" <?php endif; ?> class="dropdown-item danger-btn p-0" type="button">
                              <div class=" d-flex align-items-center justify-content-start gap-2">
                                <span class="material-symbols-outlined primary">account_box</span>
                                <p class="mb-0 gray">View Profile</p>
                              </div>
                            </a>
                          </li>
                          <li class="px-3 mx-3">
                            <a onclick="addClinic()" class="dropdown-item danger-btn p-0">
                              <div class=" d-flex align-items-center justify-content-start gap-2">
                                <span class="material-symbols-outlined primary">service_toolbox</span>
                                <p class="mb-0 gray">Add Organization</p>
                              </div>
                            </a>
                          </li>
                          <?php if((Session::has('user.stripeConnection')) && Session::get('user.stripeConnection') == 1 && (Session::get('user.userType') =='clinics'  ) ): ?>
                          <li class="px-3 mx-3">
                            <a onclick="disconnectSrtipe()" class="dropdown-item p-0">
                              <div class=" d-flex align-items-center justify-content-start gap-2">
                                <span class="material-symbols-outlined primary">credit_card</span>
                                <p class="mb-0 gray">Disconnect Stripe</p>
                              </div>
                            </a>
                          </li><?php endif; ?>
                          <li class="px-3 mx-3">
                            <a class="dropdown-item danger-btn p-0" href="<?php echo e(url('/logout')); ?>">
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
          <ul class="sidebar-nav">
            <li class="d-md-none d-block">
              <img src="<?php echo e(asset('images/logo.png')); ?>" class="img-fluid side-logo">
            </li>
            <li class="<?php echo e(request()->routeIs('dashboard*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(route('dashboard')); ?>">
                  <span class="material-symbols-outlined">dashboard</span>
                  <p class="mb-0">Dashboard</p>
                </a>
              </div>
            </li>
            <li class="<?php echo e(request()->routeIs('appointment*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(route('appointment.list', ['type' => 'online', 'status' => 'upcoming'])); ?>">
                  <span class="material-symbols-outlined">list_alt</span>
                  <p class="mb-0">Appointments</p>
                </a>
              </div>
            </li>
          
            <?php if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor' || session()->get('user.userType') == 'nurse'): ?>
            <li class="<?php echo e(request()->routeIs('patient*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(route('patient.list')); ?>">
                  <span class="material-symbols-outlined">clinical_notes</span>
                  <p class="mb-0">Patient Records</p>
                </a>
              </div>
            </li>
            <?php endif; ?>
            <?php if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor'): ?>
            <li class="<?php echo e(request()->routeIs('doctor*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(route('doctor.list')); ?>">
                  <span
                    class="material-symbols-outlined <?php if(isset($menucls) && $menucls == 'doctors'): ?> active <?php endif; ?> ">stethoscope</span>
                  <p class="mb-0">Doctors</p>
                </a>
              </div>
            </li>
            <?php endif; ?>
            <?php if(session()->get('user.userType') != 'patient'): ?>
            <li class="<?php echo e(request()->routeIs('nurse*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(route('nurse.list')); ?>">
                  <span class=" material-symbols-outlined">person_3</span>
                  <p class="mb-0">Nurses</p>
                </a>
              </div>
            </li>
            <?php endif; ?>
            <?php if(session()->get('user.userType') == 'clinics'): ?>
            <li class="<?php echo e(request()->routeIs('notification*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(route('notification')); ?>">
                  <span class="material-symbols-outlined">notifications_active</span>
                  <p class="mb-0">Notifications</p>
                </a>
              </div>
            </li>
            <li class="<?php echo e(request()->routeIs('support*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(url('support')); ?>">
                  <span class="material-symbols-outlined">headphones</span>
                  <p class="mb-0">Support</p>
                </a>
              </div>
            </li>
            <?php endif; ?>

            <?php if(session()->get('user.userType') == 'patient' ): ?>
            <li class="<?php echo e(request()->routeIs('payment*') ? 'active' : ''); ?>">
              <div>
                <a href="<?php echo e(url('payment/myreceipt')); ?>">
                  <span class=" material-symbols-outlined">receipt</span>
                  <p class="mb-0">My Receipt</p>
                </a>
              </div>
            </li>
            <?php endif; ?>

          </ul>
          <ul class="sidebar-nav nav-toggle">
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

      <?php if(session()->has('success')): ?>
      <!-- <div class="alert alert-success msg mt-2  mb-4 pt-2 pb-2">
      <?php echo e(session()->get('success')); ?>

      </div> -->
      <script>
        document.addEventListener('DOMContentLoaded', function() {
          swal(
                    "Success!",
                    "<?php echo e(session()->get('success')); ?>",
                    "success",
                );
                setTimeout(function() {
                    location.reload(); // Refresh the page
                }, 4000);
        });
      </script>
      <?php endif; ?>

      <?php if(session()->has('error')): ?>
      <div class="">
        

        <script>
          document.addEventListener('DOMContentLoaded', function() {
            swal({
              title: 'Error!',
              text: "<?php echo e(session()->get('error')); ?>",
              icon: 'warning',
              confirmButtonText: 'OK'
            });
          });
        </script>
      </div>

      <?php endif; ?>

      <?php echo $__env->yieldContent('content'); ?>





      


      <script>
          
             function globalSearch(sendAJAX='0',isloadmore='0'){
       
            if( $("#globalsearchadmin").valid() || searchTerm !=''){
                
                if( (sendAJAX == 0) && ($("#last_searchid").val() == 0) && isloadmore == '1'){
                    return;
                }
                var lastSearchId = ( $("#last_searchid").length > 0 ) ? $("#last_searchid").val() : 0;

                var searchterm =$("#search-input-admin").val();
              
                $.ajax({
                type: "POST",
                url: "<?php echo e(URL::to('globalsearch')); ?>",
                data: {
                    "searchterm": searchterm,
                    "isloadmore":isloadmore,
                    "lastSearchId":lastSearchId,

                    "_token": "<?php echo e(csrf_token()); ?>"
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == 1) {
                      
                        if(data.lastSearchId == 0){
                            $('#send_ajax_search').val('0');
                            sendAJAX =0;
                        }
                        if( $(".append_admin_global_search").length > 0 ){
                           
                            if(lastSearchId != 0 && isloadmore ==1 ){
                                if(data.lastSearchId != 0){
                                    $(".append_admin_global_search").append(data.view);
                                    }
                              
                            }else{
                                $(".append_admin_global_search").html(data.view);
                            }
                            $('#last_searchid').val( data.lastSearchId );

                        }else{
                          
                            var toURL = "<?php echo e(URL::to('/globalsearch')); ?>";
                            var searchterm = $('#search-input-admin').val();

                            if (searchterm.trim() !== "") {
                                toURL += "?search=" + encodeURIComponent(searchterm);
                            }
                        
                            window.location.href = toURL;
                        }
                        var searchTerms =$("#search-input-admin").val();
                       
                        $(".admin_search_head").html("Search Results for <span class='highlighted'>"+searchTerms+"</span>");
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

            url: '<?php echo e(url("/workspace/change")); ?>',
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
            }
          });
        }

        function disconnectSrtipe() {
          swal(
            "",
            'Are you sure you want to disconnect stripe?',
            'warning',
          ).then((e) => {
            event.preventDefault();
            var loaderimgPath = "<?php echo e(asset('images/loader.gif')); ?>";
            $('#disconnectloader').append(' <div class="modal-backdrop"><div class="modal-body text-center h-100"><img src="' + loaderimgPath + '" class="loaderImg"></div></div>');
            $.ajax({

              url: '<?php echo e(url("/disconnect/stipe")); ?>',
              type: "post",
              data: {
                '_token': $('meta[name="csrf-token"]').attr('content')
              },
              dataType: 'json',
              success: function(data) {
                // checkSession(data);
                if (data.success == 1) {
                  window.location.href = "<?php echo e(url('logout')); ?>";
                }
              }
            });
          });
        }

        function selectTeam(clinicUserKey, typeId) {

          $.ajax({

            url: '<?php echo e(url("/workspace/select")); ?>',
            type: "post",
            data: {
              'clinicUserKey': clinicUserKey,
              'typeId': typeId,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {
              // checkSession(data);
              if (data.success == 1) {

                window.open(data.redirecturl, '_blank');

              }
            }
          });
        }

        function addClinic() {
          $.ajax({
            url: '<?php echo e(url("add/workspace")); ?>',
            type: "post",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                $("#registerUser").modal('show');
                $("#registerUserForm").html(data.view);
              } else {

              }
            }
          });

        }


        // Function to toggle the 'active' class

        function toggleLabel(input) {
          const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
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
                    error.insertAfter( element.parent('div') );
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




      <script>
        function showPreloader(parmID) {
          var loaderimgPath = "<?php echo e(asset('images/loader.gif')); ?>";
          $('#' + parmID).html('<div class="modal-body text-center"><img src="' + loaderimgPath + '" class="loaderImg"></div>');
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
            <div class="modal-body text-center">
              <h4 class="text-center fw-medium mb-0">Add New Appointment</h4>
              <small class="gray">Please enter patient details and create an appointment.</small>
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
            <div class="modal-body text-center">
              <h4 class="text-center fw-medium mb-0">Edit Appointment</h4>
              <small class="gray">Please enter patient details and create an appointment.</small>
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
                        <img src="<?php echo e(asset('images/success-img.png')); ?>" class="img-fluid p-3">
                        <h4 class="text-center fw-bold mb-0">Booking Confirmed</h4>
                        <small class="gray">You can now meet the doctor at the allotted time</small>
                      </div>
                    </div>
                  </div>
                </div>
  
          <!--- Payment end ---->
      <script>
        function createPatient() {

          $("#addAppointment").modal('hide');
          $("#addPatientModal").modal('show');

          showPreloader('addPatientform')
          $.ajax({
            url: '<?php echo e(url("/patient/create")); ?>',
            type: "post",
            data: {
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                $("#addPatientform").html(data.view);
                $('#patientform')[0].reset(); // Reset the form
                loadColorBox();
              }
            }
          });
        }


        function submitPatient() {

          if ($("#patientform").valid()) {
            $("#submitpatient").addClass('disabled');
            $("#submitpatient").text("Submitting...");
            $.ajax({
              url: '<?php echo e(url("/patient/store")); ?>',
              type: "post",
              data: {
                'formdata': $("#patientform").serialize(),
                '_token': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                if (data.success == 1) {
                  swal("Success!", data.message, "success");
                  $('#search_li').append('<li  class="dropdown-item  select_patient_list" style="cursor:pointer"><div class="dropview_body profileList profileList-patient"><p class="select_patient_item" data-id="' + data.patientid + '">' + data.patientname + '</p></div></li>')
                  $('#patient_input').val(data.patientid);
                  $("#addPatientModal").modal('hide');
                  $("#nopatients").hide() ;
                  //window.location.reload();
                } else {
                  swal("Error!", data.message, "success");

                }
              }
            });
          }
        }

        function editAppointment(key, status, type, userType) {

          $("#editAppointment").modal('show');

          $('#appointment_edit_modal').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

          $.ajax({
            type: "POST",
            url: '<?php echo e(url("/appointment/edit")); ?>',
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
                console.log('success')
                $("#appointment_edit_modal").html(response.view);
              }
            },
            error: function(xhr) {
              // Handle errors
              var errors = xhr.responseJSON.errors;
              if (errors) {
                $.each(errors, function(key, value) {
                  console.log(value[0]); // Display first error message
                });
              }
            },
          });
          // });

        }

        function notes(uuid) {

          $("#appointmentNotes").modal('show');
          var uuid = uuid;
          var url = "<?php echo e(route('appointment.note')); ?>";
          $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

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
              // Handle errors
              var errors = xhr.responseJSON.errors;
              if (errors) {
                $.each(errors, function(key, value) {
                  console.log(value[0]); // Display first error message
                });
              }
            },
          });

        }

        //Create appointment Blade View function
        // $(document).on("click", "#appointment_create", function() {

        function createAppointment() {

          $('#addAppointment').modal('show');
          showPreloader('appointment_create_modal');

          $.ajax({
            type: "GET",
            url: '<?php echo e(url("/appointment/create")); ?>',
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
              // Populate form fields with the details
              if (response.status == 1) {
                $("#appointment_create_modal").html(response.view);
              }
            },
            error: function(xhr) {
              // Handle errors
              var errors = xhr.responseJSON.error;
              if (errors) {
                $.each(errors, function(key, value) {
                  console.log(value[0]); // Display first error message
                });
              }
            },
          });
        }
        // });
        function joinMeet(appoinment_uuid) {
          $('#videomeet_modal').modal('show');
          $('#videomeet').html('<div class="d-flex justify-content-center py-5"><img src="<?php echo e(asset("images/loader.gif")); ?>" width="250px"></div>');

          $.ajax({
            type: "POST",
            url: "<?php echo e(url('appointment/joinvideo')); ?>",
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

              }
            },
            error: function(xhr) {
              // Handle errors
              var errors = xhr.responseJSON.errors;
              if (errors) {
                $.each(errors, function(key, value) {
                  console.log(value[0]); // Display first error message
                });
              }
            },
          });

        }
      </script>

    </div>
  </div>

  <footer>
    <div class="d-flex justify-content-between">
      <div>
        <p><?php echo e(env('APP_NAME')); ?> <?php echo e(date('Y')); ?> © All rights reserved</p>
      </div>
      <div>
        <ul class="social-media">
          <li><a><i class="fa-brands fa-facebook-f"></i></a></li>
          <li><a><i class="fa-brands fa-x-twitter"></i></a></li>
          <li><a><i class="fa-brands fa-square-instagram"></i></a></li>
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

<script>
function getNotificationsList(selectedDate='') {
  
 
        showPreloader('notificationlist');
        $.ajax({
            type: "POST",
            url: '<?php echo e(url("/notification/list")); ?>',
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
            error: function(xhr, status, error) {
                // Handle any errors
                console.error('AJAX Error: ' + status + ': ' + error);
            },
        })
    }
</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/layouts/app.blade.php ENDPATH**/ ?>