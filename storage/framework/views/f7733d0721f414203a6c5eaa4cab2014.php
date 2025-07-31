
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="<?php echo e(asset('images/favicon.png')); ?>" sizes="64x64" type="image/png">
        <meta name="keywords" content="HTML, CSS, JavaScript">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         <title>BlackBag</title>
         <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <!-- css -->
        <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/tele-med.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('css/navbar.css')); ?>">
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
                  <img src="<?php echo e(asset('images/loginlogo.png')); ?>" class="img-fluid" alt="Logo">
                  <a  href="<?php echo e(url('/login')); ?>" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
                </div>
                  <div class="login-img-txt">
                      <h3>Virtual Care at Your Fingertips</h3>
                      <p>Providing you with reliable and convenient telehealth services. Meet with doctors online, discuss your health concerns, and get timely medical advice.</p>
                  </div>
              </div>
              <div class="d-lg-none d-block d-flex justify-content-center mob-logo w-100">
                <img src="<?php echo e(asset('images/logo.png')); ?>" class="img-fluid logo_singin" alt="Logo">
                <a  href="<?php echo e(url('/login')); ?>" onclick="backTologin()" class="back_btn backbtn" style="display: none;"><span class="material-symbols-outlined">arrow_left_alt</span>Back</a>
              </div>
          </div>

          <div class="col-12 col-lg-6">
              <div class="card-body">
                  <div class="row" id="login" >
                      <div class="col-md-8 col-lg-12 col-xl-10 col-xxl-8 mx-auto">
                          <div class="login-form text-center position-relative">

                              <p id="credslabel" class="top-error"></p>
                              <div class="mt-4">
                               
                                <h1 class="mb-3">Welcome Back</h1>
                              
                                  <?php if(  session()->has('patient.userID')): ?><?php endif; ?>
                                  <?php if(  $alreadyLoggined==1): ?>
                                  <div class="text-center">
                                        <span class="material-symbols-outlined warning-icon">warning</span>
                                        <div class="invitation-wrapper mt-2 mb-4">
                                            <h5 class="mb-0">A user is already logged in to the system. Please logout to continue accepting the invite.</h5>
                                        </div>
                                        <div class="text-center">
                                            <a  href=" <?php echo e(url('frontend/logout?redirectinvite=invitation/'.$key.'/patient')); ?>"  class="btn btn-primary w-100">Logout</a>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="text-center">
                                        <span class="material-symbols-outlined primary accept-icon">handshake</span>
                                        <div class="mt-2 mb-4">
                                            <h5 class="mb-0">You have been invited to join <?php if(!empty($clinicDetails)): ?> <?php echo e($clinicDetails['name']); ?> <?php endif; ?>.What would you like to do?</h5>
                                        </div>
                                    </div>
                      
                                    <div class="btn_alignbox flex-row">
                                        <a class="btn btn-outline-danger w-100 submitbtn"  onclick="acceptInvitation('0')" >Decline</a>
                                        <a class="btn btn-primary w-100 submitbtn"  onclick="acceptInvitation('1')" >Accept</a>
                                    </div>

                                  <?php endif; ?>


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
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.19.0/jquery.validate.min.js"></script>
<!-- Bootstrap JS (with Popper.js for modals to work) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<script type="text/javascript">

function acceptInvitation(accept) {

    var alreadyLoggedIn = "<?php echo e($alreadyLoggined); ?>";
    var accessToken = "<?php echo e(Session::get('user.authaccessToken')); ?>";
    var msg = (accept === 1) ? "Are you sure you want to accept the invitation?" : "Are you sure you want to decline the invitation?";

    swal({
        text: msg,
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancel",
                visible: true,
                className: "btn-secondary",
            },
            confirm: {
                text: "OK",
                className: "btn-danger",
            }
        },
        dangerMode: true,
    }).then((willConfirm) => {
        if (willConfirm) {
            $.ajax({
                type: "POST",
                url: "<?php echo e(URL::to('doctors/invitationstatuschange/'.$key)); ?>",
                data: {
                    type: "patient",
                    accept: accept,
                    "_token": "<?php echo e(csrf_token()); ?>"
                },
                dataType: 'json',
                success: function(data) {
                    if (data.success == 1) {
                        swal("Success", "Invitation accepeted.", "success").then(() => {
                            window.location.href = "<?php echo e(url('/home')); ?>";
                        });
                    } else if (data.success == 2) {
                        swal("Notice", "You need to log in.", "info").then(() => {
                            window.location.href = "<?php echo e(url('login')); ?>";
                        });
                    } else {
                        swal("Error", data.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred: " + error, "error");
                }
            });
        } else {
            swal("Cancelled", "Your response has not been recorded.", "error");
        }
    });
}



  </script>




<?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/patient/invitation.blade.php ENDPATH**/ ?>