<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Onboarding | BlackBag</title>
    
    <!-- Core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('css/navbar.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/css/intlTelInput.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colorbox.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
  
</head>
<body>

<div id="navbar-wrapper" class="header-fixed">
    <nav class="navbar navbar-inverse onboard-nav">
        <div class="container-fluid">
            <div class="navbar-header">
                <div class="row align-items-center">
                    <div class="col-6">
                        <div class="d-flex align-items-center">
                            <img src="{{asset('/images/logo.png')}}" class="img-fluid logo">
                        </div>
                       
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center nav-top">
                            <div class="right-sec">    
                                <div class="profile-hd">
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
                                                    <h6 class="mb-0 primary fw-medium"> {{Session::get('user.firstName')}}</h6>
                                                </div>
                                            </div>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end profile-drpdown p-0 py-3">
                                            @if((Session::has('user.hasWorkSpace')) && Session::get('user.hasWorkSpace') == 1)
                                                <li class="mx-3">
                                                    <a class="dropdown-item p-0" onclick="changeClinic()">
                                                    <div class="d-flex align-items-center justify-content-start gap-2">
                                                        <span class="material-symbols-outlined fl-icon primary">cached</span>
                                                        <p class="mb-0 gray">Switch Clinic</p>
                                                    
                                                    </div>
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="px-3">
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
                </div>
            </div>
        </div>
    </nav>
</div>

@yield('content')

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
                <!-- <small class="gray">Your subscription plan has been updated</small> -->
            </div>
        </div>
    </div>
</div>

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

<footer>
    <div class="d-flex justify-content-lg-between flex-lg-row flex-column align-items-center">
      <div class="text-lg-start text-center"> 
        <img src="{{ asset('images/transpernt_logo.png')}}" class="img-fluid logo">
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

<script src="https://js.stripe.com/v3/"></script>  
<script>
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
    function changeClinic() {
        $("#change_clinic_modal").modal('show');
        showPreloader('cliniclist');
        $.ajax({
            url: '{{ url("/frontend/workspace/change") }}',
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
    function selectTeam(clinicID) {
        $.ajax({
            url: '{{ url("/frontend/workspace/select") }}',
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
    function addClinic() {
        $.ajax({
            url: '{{ url("frontend/add/workspace") }}',
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

    function initializeAddCard(){
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
    }
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
    $(document).ready(function () {
        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');

            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }

        // Initialize all inputs on page load
        $('input, textarea').each(function () {
            toggleLabel(this);
        });

        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function () {
            toggleLabel(this);
        });

        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function (e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });
    });

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

  

    function enableAddOn(){
        $("#enableAddon").modal('show');
        showPreloader('appendaddondata')
        $.ajax({
            url: '{{ url("/users/enableaddon") }}',
            type: "post",
            data: {
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
                        savedFormData = JSON.parse(savedFormData);

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
                                    if (item.name === 'address') {
                                        $el.val(item.value);
                                        $el.trigger('input').trigger('blur');
                                        // Manually activate the floating label if present
                                        $el.siblings('.float-label').addClass('active');
                                    } else if (item.name === 'city') {
                                        $el.val(item.value);
                                        $el.trigger('input').trigger('blur');
                                        $el.siblings('.float-label').addClass('active');
                                    } else {
                                        $el.val(item.value).trigger('input').trigger('blur');
                                    }
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
                    // Redirect to the login page
                    window.location.href = '/login';  // Explicit login redirect instead of reloading
                });
            }
        } 
    }
    function showPreloader(parmID) {
        var loaderimgPath = "{{ asset('images/loader.gif') }}";
        $('#' + parmID).html('<div class="text-center "><img src="' + loaderimgPath + '" class="loaderImg"></div>');
    }
    $(document).ready(function() {
        $('#successSubscription').on('hidden.bs.modal', function () {
            getOnboardingDetails('eprescribe');
        });
        var formtype= '{{$latestStep}}';
    });  
    function getOnboardingDetails(type,formname='',islater='') {
    
        if ((type == 'choose-addons' && islater !='1') && ( $('#planslist').length === 0 || !$('#planslist').is(':visible'))) {
            swal('Warning','Please add any plan to continue','warning');
            return ;
          

        }

       showPreloader("step_" + type);
       let formdata = formname !='' ? $("#"+formname).serialize() : '';
       var currentStepId = $("#"+type+"_stepId").val() || 1;
       $.ajax({
           type: "POST",
           url: '{{ url("/onboarding/") }}/' + type,
           data: {
             'formdata': formdata,
             'formType' : 'onboarding',
               "currentStepId": 1,
               "nextstep": type,
               "islater" : islater ,
                "_token": "{{ csrf_token() }}"
           },
           success: function(response) {
               if(response.success == 1){
                if(type=='subscription_plan'){
                    getPlanList();
                }else if( type== 'eprescribe'){
                    window.location.href = "{{ url('/dashboard/') }}"  ;
                }else{
                    window.location.href = "{{ url('/onboarding/') }}/" + response.step ;
                }
               
               }
           },
           error: function(xhr) {
               handleError(xhr);
           },
       })
   }
   function getPlanList() {
      $(".addplanscls").hide() ;
      $("#planslist").show() ;
      showPreloader('planslist');
   
      $.ajax({
          type: "POST",
          url: '{{ url("/onboarding/subscriptionplan") }}',
          data: {
            
               "_token": "{{ csrf_token() }}"
          },
          success: function(response) {
              if(response.success == 1){
                if(response.is_list == 1){
                    $(".addplanscls").show() ;
                    $("#planslist").hide() ;
                    $("#addplanbtnsubmit").hide();
                }else{
                    $("#planslist").html(response.view);
                }
                   
              
              }
          },
          error: function(xhr) {
              handleError(xhr);
          },
      })
  }

  function submitCard(){
    var latestStep = "{{$latestStep}}";
 
        if($('#addcardsform').valid()){
            $("#submitbtn").addClass('disabled');
            $("#submitbtn").prop('disabled',true);
            $.ajax({
                url: '{{ url("/addcard") }}',
                type: "post",
                data: {
                    'formdata': $("#addcardsform").serialize(),
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#addCreditCard").modal('hide');
                        $("#editplan").modal('hide');
                        $("#submitbtn").removeClass('disabled');
                        $("#submitbtn").prop('disabled',false);
                        $('#addcardsform')[0].reset();
                        $("#addCard").modal('hide');
                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            if( latestStep == 'choose-addons' ){
                                enableAddOn();
                                setTimeout(function(){
                                    var radio = $("#selected_card_" + data.key);
                                    $(".selectedcardcls").prop("checked", false);
                                    if (radio.length > 0) {
                                        radio.prop("checked", true).trigger("change");
                                        console.log("Radio checked successfully");
                                        $("#cardadded").val('1');
                                    } else {
                                        console.error("Radio button not found");
                                    }
                                }, 1000);
                            }else if(latestStep == 'patient-subscriptions'){
                                let formdata = $("#addplanform").serialize() ;
                                savePlanDetails('subscription_plan',formdata);
                                 $("#iscard").val('1');
                                 const imageBaseUrl = "{{ asset('cards') }}/";
                                 var cardHtml = `
                                    <h5 class="fw-bold my-3">Card on File</h5>
                                    <div class="border rounded-4 p-4 bg-white"> 
                                        <div class="user_inner">
                                            <img src="${imageBaseUrl}${data.card_type}.svg">
                                            <div class="user_info">
                                                <h6 class="primary fw-medium mb-1">Card Ending in ${data.card_number}</h6>
                                                <p class="m-0">Expiry ${data.exp_month}/${data.exp_year}</p>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                $("#cards").html(cardHtml);

                            }else{
                              
                                $("#iscard").val('1');
                                
                                
                            }
                        });
                    } else {
                        swal(data.errormsg, {
                            icon: "error",
                            text: data.errormsg,
                            button: "OK",
                        });
                        $("#submitbtn").removeClass('disabled');
                        $("#submitbtn").prop('disabled',false);
                    }
                },
                error: function(xhr) {
                    
                    handleError(xhr);
                }
            });
        }
    }
    
    
//   function goToStep(step) {
//     // Show selected step, hide others
//     $('.step-section').hide();
//     $('.step-section[data-step="' + step + '"]').show();

//     // Toggle active class
//     $('.circle').removeClass('active');
//     $('.stepper[data-step="' + step + '"] .circle').addClass('active');
//   }

  $(document).ready(function () {
    // Stepper click
    $('.stepper').click(function () {
      const step = $(this).data('step');
    //   goToStep(step);
    });

    // Continue button click
    $('.continue').click(function () {
      const nextStep = $(this).data('next');
    //   goToStep(nextStep);
    });

    // Initialize
    // goToStep(1);
  });

            function toggleLabel(input) {
                    const $input = $(input);
                    const value = $input.val();
                    const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
                    const isFocused = $input.is(':focus');
            
                    // Ensure .float-label is correctly selected relative to the input
                    $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
                }
            
            $(document).ready(function () {
             
                // Initialize all inputs on page load
                $('input, textarea').each(function () {
                    toggleLabel(this);
                });
            
                // Handle input events
                $(document).on('focus blur input change', 'input, textarea', function () {
                    toggleLabel(this);
                });
            
                // Handle dynamic updates (e.g., Datepicker)
                $(document).on('dp.change', function (e) {
                    const input = $(e.target).find('input, textarea');
                    if (input.length > 0) {
                        toggleLabel(input[0]);
                    }
                });
            });
   



</script>
  
<div class="modal login-modal fade" id="addCreditCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">  
                <div class="row">
                    <div class="col-sm-10 col-lg-8 mx-auto"> 
                        <div class="text-center mb-3">     
                            <img src="{{asset('/images/addcreditcard.png')}}" alt="Credit card" class="img-fluid onboard-innerImg">      
                            <h3 class="fw-bold my-3 primary">Zero-Dollar Appointments Require a Card on File</h3>
                            <p class="gray fw-light">To offer $0 appointments, a valid credit card must be saved to your account. A $5.00 service fee will be automatically charged to your card when the appointment begins. This ensures secure processing and uninterrupted access to appointment features.</p>
                        </div>    
                    </div>
                </div>
                <div class="btn_alignbox mt-3">
                    <a class="btn btn-primary align_middle" onclick="addCard()"><span class="material-symbols-outlined">add</span>Add Card</a>
                </div>
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

<div class="modal login-modal fade" id="addCard" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">   
                <div class="text-center mb-3">           
                    <h4 class="fw-bold mb-0 primary">Add New Card</h4>
                    <small class="gray fw-light">Please enter the card details</small>
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
                        <div class="btn_alignbox mt-3">
                            <button type="submit" id="submitbtn" class="btn btn-primary w-100">Add Card</button>
                        </div>
                    </div>
                </form>
           

                
                <!-- <div class="btn_alignbox justify-content-end mt-3">
                    <a href="" class="btn btn-outline">Close</a>
                    <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="">Add Card</a>
                </div> -->
            </div>
        </div>
    </div>
</div>
    
</body>
</html>