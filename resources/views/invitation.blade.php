
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
        <meta name="keywords" content="HTML, CSS, JavaScript">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> @if(isset($seo['title']) && !empty($seo['title'])) {{$seo['title']  }} @else BlackBag  @endif</title>
        <meta name="keywords" content="{{ isset($seo['keywords'])&& $seo['keywords']!='' ? $seo['keywords'] : '' }}">
        <meta name="description" content="{{ isset($seo['description'])&& $seo['description']!='' ? $seo['description'] : '' }}">
        
         <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- css -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/tele-med.css') }}">
        <link rel="stylesheet" href="{{ asset('css/navbar.css')}}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

     
    </head>
    
    <body class="bg-white">
      <section class="signin-page">
        <div class="container-fluid p-0">
          <div class="row align-items-center">
          <div class="col-12 col-lg-6">

              <div class="sign-in-left-sec">
                <div class="d-flex justify-content-between w-100">
                  <img src="{{ asset('images/loginlogo.png')}}" class="img-fluid" alt="Logo">
                  <a  href="{{url('/login')}}" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                </div>
                  <div class="login-img-txt">
                      <h3>Virtual Care at Your Fingertips</h3>
                      <p>Providing you with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.</p>
                  </div>
              </div>
              <div class="d-lg-none d-block d-flex justify-content-center mob-logo w-100">
                <img src="{{asset('images/logo.png')}}" class="img-fluid logo_singin" alt="Logo">
                <a  href="{{url('/login')}}" onclick="backTologin()" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
              </div>
          </div>

          <div class="col-12 col-lg-6">
              <div class="card-body">
                  <div class="row" id="login" >
                      <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-8 mx-auto">
                          <div class="login-form text-center position-relative">

                              <p id="credslabel" class="top-error"></p>
                              <div class="login-inner-data mt-4">
                               
                                    <div class="text-center declinecls" style="display:none">
                                        <span class="material-symbols-outlined primary error-icon"> running_with_errors</span>
                                        <div class="mt-2 mb-4">
                                            <h5 class="mb-0">You have declined the request </h5>
                                        </div>
                                    </div>

                                
                                @if ( $haserror==1)
                                    <div class="text-center">
                                        <span class="material-symbols-outlined primary error-icon"> running_with_errors</span>
                                        <div class="mt-2 mb-4">
                                            <h5 class="mb-0">Link Expired!</h5>
                                        </div>
                                    </div>
                                @else
                                    <img src="{{$clinicDetails['logo'] ?? asset('images/default_clinic.png')}}" class="user-img actioncls" alt="Blackbag">
                                    <h1 class="my-3 actioncls">Welcome {{$name}},</h1>
                                    @if (  $alreadyLoggined==1)
                                        <div class="text-center actioncls">
                                            <span class="material-symbols-outlined warning-icon">warning</span>
                                            <div class="invitation-wrapper mt-2 mb-4">
                                                <h5 class="mb-0">A user is already logged in to the system. Please logout to continue accepting the invite.</h5>
                                            </div>
                                            <div class="text-center">
                                                <a  href=" {{url('logout?redirectinvite=invitation/'.$invitationkey)}}"  class="btn btn-primary w-100">Logout</a>
                                            </div>
                                        </div>
                                    @elseif ( isset($isDeleted) && $isDeleted == '1')
                                    <div class="text-center">
                                        <span class="material-symbols-outlined primary error-icon">emergency_home</span>
                                        <div class="mt-2 mb-4">
                                            <h5 class="mb-0">Sorry! Your account has been suspended by admin</h5>
                                        </div>
                                    </div>
                                    @else

                                        <div class="text-center actioncls">
                                            <div class="mt-2 mb-4">
                                                <h5 class="mb-0">You have been invited to join @if(!empty($clinicDetails)){{$clinicDetails['name']}}@endif by {{$clinicianname}}.</h5>
                                            </div>
                                        </div>
                                        <div class="btn_alignbox d-flex gap-2 actioncls">
                                            <a class="btn btn-primary flex-grow-1 submitbtn" onclick="acceptInvitation('1')">Accept</a>
                                            <a class="btn btn-outline-danger flex-grow-1 submitbtn" onclick="acceptInvitation('0')">Decline</a>
                                        </div>
                                    @endif
                                @endif
                              </div>
                          </div>
                      </div>
                  </div>



                
             

              </div>
          </div>
        </div>
      </div>
    </section>
  
<!-- Correct script order -->
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<!-- Bootstrap JS (with Popper.js for modals to work) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">

function acceptInvitation(accept) {
    var alreadyLoggined = "{{$alreadyLoggined}}";
    var accessToken = "{{Session::get('user.authaccessToken')}}";
    var msg = (accept == 1) ? "Are you sure you want to accept the invitation?" : "Are you sure you want to decline the invitation?";

    swal({
        text: msg,
      
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                value: true,
                visible: true,
                className: "btn-danger",
                closeModal: false // Keeps the modal open during AJAX request
            }
        }
    }).then((isConfirmed) => {
        if (isConfirmed) {
            // Perform the AJAX request only if confirmed
            $.ajax({
                type: "POST",
                url: "{{ URL::to('doctors/invitationstatuschange/'.$invitationkey)}}",
                data: {
                    'accept': accept,
                    "_token": "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(data) {
                   
                    if (data.success == 1) {
                        window.location.href = "{{url('login?')}}invitationkey=" + data.key;
                    } else if (data.success == 2) {
                        swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            $('.btn_alignbox').removeClass('d-flex');
                            $('.actioncls').hide();
                            $('.declinecls').show();
                        });

                        // swal("Success!", data.message, "success").then(() => {
                        //     $('.actioncls').hide();
                        //     $('.declinecls').show();
                        //     // window.location.reload();
                        // });
                        
                    } else {
                        swal('Cancelled', data.message, 'error');
                        setTimeout(function() {
                            window.location.href = "{{url('login')}}";
                        }, 600);
                    }
                },
                error: function(xhr, status, error) {
                    swal('Error', 'An error occurred: ' + error, 'error'); // Handle AJAX error
                }
            });
        } else {
            // swal('Cancelled', 'Your response has not been recorded.', 'error');
        }
    });
}



  </script>


</body>

</html>



