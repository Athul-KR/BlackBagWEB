<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Patient Onboarding | BlackBag</title>
        
        <!-- Core CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('css/navbar.css')}}">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/colorbox.css') }}">
        <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Core JavaScript -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/intlTelInput.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
        <script type="text/javascript" src="{{ asset('js/jquery.colorbox.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&libraries=places" async defer></script>
        <script src="{{ asset('frontend/js/script.js')}}"></script>
    </head>
    <body>

        <div class="container-fluid">
            <nav class="navbar navbar-expand-xl fixed-top p-3 nav-topbar">
                <div class="d-flex align-items-center justify-content-between w-100">
                    <img src="{{asset('/images/logo.png')}}" class="img-fluid logo">
                    <div class="d-flex align-items-center nav-top">
                        <div class="right-sec">    
                            <div class="profile-hd border-start-0">
                                <div class="btn-group">
                                    <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <div class="d-flex align-items-center">
                                        @php

                                        $corefunctions = new \App\customclasses\Corefunctions;

                                        $userLogo = (session('user.userLogo') != '') ? session('user.userLogo') : asset('images/default_img.png');

                                    
                                        @endphp
                                            <img class="pfl-img" src="{{$userLogo}}">
                                            <div class="pftl-txt-hd pftl-txt">
                                                <span>Welcome</span>
                                                <h6 class="mb-0 primary fw-medium"> 
                                                    {{ session('user.firstName') }}
                                                    @if(session()->has('user.middleName') && session('user.middleName'))
                                                        {{ session('user.middleName') }}
                                                    @endif
                                                    {{ session('user.lastName') }}
                                                </h6>
                                            </div>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end profile-drpdown p-0 py-3">
                                        <li class="p-0">
                                           <a class="dropdown-item danger-btn p-0" href="{{url('/logout')}}">
                                                <div class=" d-flex align-items-center justify-content-start gap-1">
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
            </nav>
        </div>

        <section>
            <div class="container"> 
                <div class="onboarding-wrapper"> 
                    <div class="d-flex justify-content-between align-items-center flex-nowrap">
                        <div>
                            <h3 class="extra-bold">Choose Your Subscription</h3>
                            <p class="gray fw-light mb-0">Select a plan that fits your care needs.</p> 
                        </div>
                        <div class="toggle-switch d-flex align-items-center justify-content-end">
                            <span class="me-2 gray" id="monthlyText">Yearly</span>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" name="billingToggle" id="billingToggle" onclick="handleBillingToggle()">
                            </div>
                            <span class="gray" id="yearlyText">Monthly</span>
                        </div>
                    </div>
                    <div class="row g-4 align-items-center my-4">
                        <div class="col-12 col-lg-8">
                            <div class="d-flex align-items-center gap-3">  
                                <div class="user_inner user_inner_xl">
                                    <img src="{{$clinic['clinic_logo']}}">
                                    <div class="user_info">
                                        <h4 class="primary fw-bold m-0">{{$clinic['name']}}</h4> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12 col-lg-4">
                            <div class="border rounded-3 p-4 h-100">
                                <div class="d-flex flex-column justify-content-between h-100"> 
                                    <div class="plans-head"> 
                                        <img src="{{asset('images/plan_icons/Diamond.png')}}" alt="Badge" class="subtype-icon">
                                        <h2 class="fw-bold my-2">Pay As You Go Plan</h2>
                                        <p class="mb-0">Designed for flexibility and convenience, this plan allows you to access high-quality care only when you need it. No ongoing commitment — just pay per visit, whether in-person or virtual.</p>
                                    </div>
                                    <div> 
                                        @if($clinic['appointment_type_id'] != '2')
                                        <div class="fees-container"> 
                                            <div class="d-flex align-items-center gap-3"> 
                                                <h2 class="mb-0">
                                                    ${{ floor($clinic['virtual_fee']) == $clinic['virtual_fee'] ? number_format($clinic['virtual_fee'], 0) : number_format($clinic['virtual_fee'], 2) }}
                                                </h2>
                                                <div> 
                                                    <p class="mb-0">Virtual</p>
                                                    <p class="mb-0">Appointment Fee</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        @if($clinic['appointment_type_id'] != '1')
                                        <div class="fees-container border-bottom-0"> 
                                            <div class="d-flex align-items-center gap-3">
                                                <h2 class="mb-0">
                                                    ${{ floor($clinic['inperson_fee']) == $clinic['inperson_fee'] ? number_format($clinic['inperson_fee'], 0) : number_format($clinic['inperson_fee'], 2) }}
                                                </h2>
                                                <div> 
                                                    <p class="mb-0">In-Person</p>
                                                    <p class="mb-0">Appointment Fee</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="fees-container-highlight"> 
                                            <div class="d-flex align-items-center gap-3"> 
                                                <h3 class="mb-0 yearlycls">$0</h3>
                                                <h3 class="mb-0 monthlycls" style="display:none;">$0</h3>
                                                <div> 
                                                    <p class="mb-0 white yearlycls">Yearly</p>
                                                    <p class="mb-0 white monthlycls" style="display:none;">Monthly</p>
                                                    <p class="mb-0 white">Subscription Fee</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="btn_alignbox mt-4"> 
                                            <a href="javascript:void(0);" onclick="confirmPayAsYouGrow();" class="btn btn-primary w-100">Choose Plan</a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(!empty($clinicSubscriptions))
                            @foreach($clinicSubscriptions as $clinicSubscription)
                                <div class="col-12 col-lg-4">
                                    <div class="border rounded-3 p-4 h-100">
                                        <div class="d-flex flex-column justify-content-between h-100"> 
                                            <div class="plans-head"> 
                                                <img @if(isset($planIcons[$clinicSubscription['plan_icon_id']])) src="{{asset('images/plan_icons/'.$planIcons[$clinicSubscription['plan_icon_id']]['icon_path'])}}" @else src="{{asset('images/plan_icons/Diamond.png')}}" @endif alt="Badge" class="subtype-icon">
                                                <h2 class="fw-bold my-2">{{$clinicSubscription['plan_name']}}</h2>
                                                <p class="mb-0"><?php echo nl2br($clinicSubscription['description']) ?></p>
                                            </div>
                                            <div> 
                                            @if($clinic['appointment_type_id'] != '2')
                                                <div class="fees-container"> 
                                                    <div class="d-flex align-items-center gap-3"> 
                                                        <h2 class="mb-0">
                                                            @if(isset($clinicSubscription['has_per_appointment_fee']) && $clinicSubscription['has_per_appointment_fee'] == '1')
                                                                <?php echo $corefunctions->formatAmount($clinicSubscription['virtual_fee']); ?>
                                                            @else
                                                                <?php echo $corefunctions->formatAmount($clinic['virtual_fee']); ?>
                                                            @endif
                                                        </h2>
                                                        <div> 
                                                            <p class="mb-0">Virtual</p>
                                                            <p class="mb-0">Appointment Fee</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($clinic['appointment_type_id'] != '1')
                                                    <div class="fees-container border-bottom-0"> 
                                                        <div class="d-flex align-items-center gap-3"> 
                                                            <h2 class="mb-0">
                                                                @if(isset($clinicSubscription['has_per_appointment_fee']) && $clinicSubscription['has_per_appointment_fee'] == '1')
                                                                    <?php echo $corefunctions->formatAmount($clinicSubscription['inperson_fee']); ?>
                                                                @else
                                                                    <?php echo $corefunctions->formatAmount($clinic['inperson_fee']); ?>
                                                                @endif
                                                            </h2>
                                                            <div> 
                                                                <p class="mb-0">In-Person</p>
                                                                <p class="mb-0">Appointment Fee</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="fees-container-highlight"> 
                                                    <div class="d-flex align-items-center gap-3"> 
                                                        <h3 class="mb-0 yearlycls">
                                                            ${{ floor($clinicSubscription['annual_amount']) == $clinicSubscription['annual_amount'] ? number_format($clinicSubscription['annual_amount'], 0) : number_format($clinicSubscription['annual_amount'], 2) }}
                                                        </h3>
                                                        <h3 class="mb-0 monthlycls" style="display:none;">
                                                            ${{ floor($clinicSubscription['monthly_amount']) == $clinicSubscription['monthly_amount'] ? number_format($clinicSubscription['monthly_amount'], 0) : number_format($clinicSubscription['monthly_amount'], 2) }}
                                                        </h3>
                                                        <div> 
                                                            <p class="mb-0 white yearlycls">Yearly</p>
                                                            <p class="mb-0 white monthlycls" style="display:none;">Monthly</p>
                                                            <p class="mb-0 white">Subscription Fee</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn_alignbox mt-4"> 
                                                    <button type="button" class="btn btn-primary w-100" onclick="showPaymentModal('{{$clinic['id']}}','{{$clinicSubscription['clinic_subscription_uuid']}}');">Choose Plan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </section>


        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-xxl-7 col-lg-5 col-12">
                                <div class="image-container">
                                    <img src="{{ asset('frontend/images/transpernt_logo.png')}}" class="img-fluid" alt="BlackBag Logo">
                                    <h5 class="mt-2">Virtual Care at Your Fingertips</h5>
                                </div>
                            </div>
                            <div class="col-xxl-5 col-lg-7 col-12">
                                <div class="footer-inner mt-lg-0 mt-3">
                                    <div>
                                        <ul>
                                            <li class="fwt-bold">BlackBag</li>
                                            <?php /* <!-- <li><a class="white" data-bs-toggle="modal" data-bs-dismiss="modal"
                                                    data-bs-target="#changePass">Join Us</a>
                                            </li> -->*/?>
                                            
                                            <li><a href="{{route('frontend.contactUs')}}" class="white">Contact Us</a></li>
                                            <li><a href="{{route('frontend.pricing')}}" class="white">Pricing</a></li>
                                            <!-- <li><a href="{{route('frontend.contactUs')}}" class="white">Help & Support</a></li> -->
                                        </ul>
                                    </div>
                                    <?php /* <!-- <div>
                                        <ul>
                                            <li class="fwt-bold">For Patients</li>
                                            <li><a href="{{route('frontend.findDoctorsAndClinics')}}" class="white">Find
                                                    Doctors</a></li>
                                            <li><a class="white">Search Specialities</a></li>
                                        </ul>
                                    </div> -->*/?>
                                    <div>
                                        <ul>
                                            <li class="fwt-bold">More</li>
                                            <li><a href="{{route('frontend.privacyPolicy')}}" class="white">Privacy Policy</a></li>
                                            <li><a href="{{route('frontend.termsAndCondition')}}" class="white">Terms & Conditions</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <hr>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <ul class="my-sm-0 mb-3">
                                        <li> Copyright © {{env('APP_NAME')}} {{date('Y')}}. All rights reserved.</li>
                                </ul>
                            </div>
                            <!-- <div class="col-md-6 col-12">
                                <ul class="social-media flex-row justify-content-center justify-content-sm-end">
                                    <li><a  href="#" class="white" onclick="return false;"><i class="fa-brands fa-instagram"></i></a></li>
                                    <li><a href="#"class="white" onclick="return false;"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="#"class="white" onclick="return false;"><i class="fa-brands fa-x-twitter"></i></a></li>
                                </ul>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>


<div class="modal fade" id="upgradePlans" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl subscription-modal-xl">
        <div class="modal-content subscription-modal p-0">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close">
                <span class="material-symbols-outlined">close</span>
                </a>
            </div>
            <div class="modal-body p-0" id="appendpaymentdata">
                
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal payment-success fade" id="add_card_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center amount_body mb-3">
                    <h4 class="text-center fwt-bold mb-1">Add New Card</h4>
                    <p class="fw-light gray">Please enter card details</p>
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
                            <div id="add_card_element">

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

<div class="modal login-modal fade" id="successSubscription" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('images/success_signin.png')}}" class="img-fluid">
                <h4 class="text-center fw-bold mb-2 mt-4">Subscription Successful</h4>
                <p class="fw-light gray">Your card and billing information has been added successfully.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    function handleBillingToggle() {
        const billingToggle = document.getElementById('billingToggle');
        if (!billingToggle.checked) {
            $(".monthlycls").hide();
            $(".yearlycls").show();
        } else {
            $(".monthlycls").show();
            $(".yearlycls").hide();
        }
    }
    function showPaymentModal(clinicId,subscriptionkey){
        var isMonthlyChecked = $("#billingToggle").prop("checked");
        var isMonthlyChecked = isMonthlyChecked ? 1 : 0; 
        $.ajax({
            type: "POST",
            url: '{{ url("/myaccounts/fetchpaymentdetails") }}',
            data: {
                "clinicid": clinicId,
                "subscriptionkey": subscriptionkey,
                "isMonthlyChecked":isMonthlyChecked,
                'type' : 'register',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    $("#upgradePlans").modal('show');
                    $("#appendpaymentdata").html(response.view);
                    initializeAutocompleteBilling();
                    $('input, textarea').each(function () {
                        toggleLabel(this);
                    });
                }
                  
            },
            error: function(xhr) {
                // handleError(xhr);
            },
        })
    }
    
    function confirmPayAsYouGrow(){
        let msg = 'Are you sure you want to proceed with the Pay As You Go plan?';
        swal({
            text: msg,
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
                swal.close();
                window.location.href = "{{url('onboarding/getstarted')}}";
            }
        });
    }
</script>