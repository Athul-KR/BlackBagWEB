@extends('onboarding.onboarding')
@section('title', 'Business Details')
@section('content')    
<section class="mx-lg-5 px-lg-5">
    <div class="container-fluid">
        <div class="wrapper res-wrapper onboard-wrapper">
       
          
            @include('onboarding.tabs')

            <div class="web-card mb-5"> 
                <div id="step-content">
                    <div class="step-section" data-step="4" >
                         <div class="onboard-box"> 
                            <div class="d-flex justify-content-between"> 
                                <div> 
                                    <h4 class="fw-bold">Patient Subscription Plans</h4>
                                    <p class="gray">Patient subscriptions help you deliver consistent care and generate recurring revenue. You can create multiple plans to suit different patient needs.</p>
                                </div>
                                    <!-- <a href="" class="primary align_middle fw-medium"><span class="material-symbols-outlined">keyboard_backspace</span>Back</a> -->
                            </div>

                            <div class="col-lg-7 col-sm-10 col-12 mx-auto text-center addplanscls" @if(!empty($subscritionList)) style="display:none;" @endif>
                                <div class="my-4">
                                        <img src="{{asset('/images/sub-plan.png')}}" alt="Subscription Plans" class="img-fluid onboard-innerImg">
                                </div>

                                    <h5 class="fw-bold mb-2">Let's Set Up Your First Patient Subscription Plan</h5>
                                    <p class="gray">Click <span class="fw-bold">"Add Plan"</span> to get started with your first subscription offering.</p>

                                    <!-- onclick="savePlanDetails('subscription_plan','','generic')" -->
                                    <div class="btn_alignbox my-4">
                                        <button  onclick="previewTemplates('subscription_plan','','generic')" class="btn btn-outline-primary align_middle"><span class="material-symbols-outlined">file_save</span> Use a Template </button>
                                        <button class="btn btn-primary align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" onclick="addNewPlan()"><span class="material-symbols-outlined">add</span>Add Plan</button>
                                    </div>

                                    <a onclick="getOnboardingDetails('choose-addons','','1')" ><p class="fw-middle text-decoration-underline primary">We do not offer Patient Subscription Plans.</p></a>
                                    <p class="gray primary fw-light"><span class="asterisk">*</span> You can always come back and add Patient Subscription Plans from your account settings.</p>
                                
                                </div>
                            
                                <div class="row g-4 planslist" id="planslist">
                                    @if(!empty($subscritionList))
                                        @include('onboarding.subscriptionplans')
                                    @endif
                                </div>
                                <input type="hidden" id="iscard" @if(!empty($clincCard)) value="1" @endif name="iscard">
                            
                                <div class="col-12" id="cards">
                                @if(!empty($clincCard))
                                    <h5 class="fw-bold my-3">Card on File</h5>
                                    <div class="border rounded-4 p-4 bg-white"> 
                                        <div class="user_inner">
                                            <img src="{{ asset('cards/'.$clincCard['card_type'].'.svg') }}" >
                                            <div class="user_info">
                                                <h6 class="primary fw-medium mb-1">Card Ending in {{$clincCard['card_number']}}</h6>
                                                <p class="m-0">Expiry {{$clincCard['exp_month']}}/{{$clincCard['exp_year']}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            
                                <div class="btn_alignbox justify-content-end mt-3"> 
                                 
                                    <button type="button"  @if(empty($subscritionList)) style="display:none;" @endif id="addplanbtnsubmit" class="btn btn-outline align_middle_block" onclick="addNewPlan()" ><span class="material-symbols-outlined">add</span>Add  Plan</button>
                                  
                                    <button type="button" class="btn btn-primary" onclick="getOnboardingDetails('choose-addons')" >Save & Continue</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



@php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp


<div class="modal login-modal fade" id="addPlan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="appendplandetails">   
                
            </div>
        </div>
    </div>
</div>

<!-- Add Preview Modal -->
<div class="modal login-modal fade" id="previewTemplatesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">   
                <div class="text-start mb-3">           
                    <h4 class="fw-bold mb-0 primary"> Generic Plans</h4>
                    <small class="gray fw-light">Review the generic plans before adding them to your clinic.</small>
                </div>
                <div id="previewPlansContainer">
                    @if(!empty($genericPlans))
                        @foreach($genericPlans as $plan)
                        <div class="border rounded-4 p-3 mb-3">
                            <h5 class="fw-bold mb-2">{{$plan['plan_name']}}</h5>
                            <div class="gray-border my-2"></div>
                            <p class="gray mb-2">{{$plan['description']}}</p>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 d-flex justify-content-between min-w-tag fw-light me-2"><span>Monthly Fee</span> <span>: </span> </p>
                                        <p class="mb-0 primary fw-bold"> ${{$plan['monthly_amount']}}</p> 
                                    </div>
                                     <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-1 d-flex justify-content-between min-w-tag fw-light me-2"><span>Annual Fee</span> <span>: </span> </p>
                                        <p class="mb-0 primary fw-bold"> ${{$plan['annual_amount']}}</p> 
                                     </div>
                                </div>
                              
                            </div>
                        </div>
                        @endforeach
                    @endif
                    <div class="info-box">
                        <p class="gray mb-0 align_middle justify-content-start gap-2">
                            <i class="material-symbols-outlined">info</i>
                            These plans will be automatically added to your clinic when you click "Continue".
                        </p> 
                    </div>
                </div>
                <div class="btn_alignbox justify-content-end mt-4">
                    <a class="btn btn-outline" data-bs-dismiss="modal">Cancel</a>
                    <a onclick="savePlanDetails('subscription_plan','','generic')" id="savegenericplans" class="btn btn-primary">Continue</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal fade" id="editplan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="editplansubcription">   
               
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    function addCard(){
        $("#addCard").modal('show');
        $("#addCreditCard").modal('hide');
    }
    $(document).ready(function () {
        $('#addcardsform').validate({
            ignore: [],
            rules: {
                name_on_card: {
                    required: true,
                    letterswithspaces: true
                },
                card_number: {
                    required: true,
                },
                expiry_month: {
                    required: true,
                },
                expiry_year: {
                    required: true,
                },
                ccv: {
                    required: true,
                    minlength: 3,
                    number: true
                },
            },
            messages: {
                name_on_card: {
                    required: "Please enter your name",
                    letterswithspaces: "Please enter valid name."
                },
                card_number: {
                    required: "Please enter card number",
                    minlength:"Please enter valid card number",
                    number:"Please enter valid card number",
                },
                expiry_month: {
                    required: "Please select a month",
                    max: "Please enter valid month ",
                    min:"Please enter valid monthr ",
                    number:"Please enter valid month",
                },
                ccv: {
                    required: "Please enter cvv",
                    minlength:"Please enter valid cvv ",
                    number:"Please enter valid cvv",
                },
                expiry_year: {
                    required: "Please select a year",
                    min:"Please enter valid year",
                    number:"Please enter valid year",
                }
            },
        });
        $("#addplanform").validate({
            ignore: [],
            rules: {
                plan_name : {
                    required: true,
                    remote: {
                        url: "{{ url('/validateplan') }}",
                        data: {
                            'type': 'plan',
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    }
                },
                
                description: 'required',
                monthly_amount: {
                    required: true,
                    amountCheck: true,
                },
                annual_amount: {
                    required: true,
                    amountCheck: true,
                },
                plan_icon_id : 'required'
            },

            messages: {
                plan_name : {
                    required :"Please enter plan name.",
                    remote :"This plan name already added."
                },
                
                description: "Please enter description.",
                monthly_amount: {
                    required: "Please enter appointment fees.",
                    amountCheck: "Please enter a valid fee.",
                },
                annual_amount: {
                    required: "Please enter appointment fees.",
                    amountCheck: "Please enter a valid fee.",
                },
                plan_icon_id : 'Please choose a subscription icon.'
            },
            errorPlacement: function (error, element) {
                if(element.hasClass("timedurationcls")){
                    error.insertAfter(".timedurationerr");
                }else if(element.hasClass("appointment_typecls")){
                    error.insertAfter(".appointmenttypeerr");
                }else{
                    error.insertAfter(element);
                }

            },
        });
        $.validator.addMethod("letterswithspaces", function(value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/i.test(value);
        }, "Please enter only letters and spaces");
        
        // Custom method to check for amount check
        $.validator.addMethod(
            "amountCheck", // Custom method name
            function(value, element) {
                // Regular expression for amount validation with up to 2 decimal places
                var regex = /^(?!0\d)(\d{1,3}(,\d{3})*|\d+)(\.\d{1,2})?$/;

                // Check if the value is optional or matches the regex
                return this.optional(element) || regex.test(value);
            },
            "Please enter a valid amount (up to 2 decimal places)."
        );

        $(".planslist").sortable({
            handle: ".handle",
            update: function (event, ui) {
                let order = [];
                $(".planslist > .col-12").each(function (index) {
                let uuid = $(this).find("[onclick^='editPlan']").attr("onclick").match(/'([^']+)'/)[1];
                    order.push({
                        uuid: uuid,
                        sort_order: index + 1
                    });
                });
                $.ajax({
                    url: "{{url('/update-plan-order')}}",
                    method: "POST",
                    data: {
                        order: order,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        console.log("Sort order updated");
                    },
                    error: function () {
                        alert("Failed to update sort order.");
                    }
                });
            }
        });
    });
    
    function selectIcon(iconid){
        if( $("#icon_"+iconid).hasClass('active') ){
            $("#plan_icon_id").val('');
            $("#icon_"+iconid).removeClass('active');
        }else{
            $(".icon-div").removeClass('active');
            $("#plan_icon_id").val(iconid);
            $("#icon_"+iconid).addClass('active');
        }
        
        $("#plan_icon_id").valid();
    }
   
    function stripeElaments(){
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
            stripe.confirmCardSetup(
                clientSecret,
                {
                    payment_method: {
                        card: cardElement
                    },
                }
            ).then(function(result) {
                if (result.error) {
                    var errorElement = document.getElementById('add-card-errors');
                    errorElement.textContent = result.error.message;
                } else {
                    // The payment succeeded!
                    console.log(result);
                    stripeTokenHandler(result.setupIntent.payment_method,result.setupIntent.id);
                }
            });
        });
    }
    // Submit the form with the token ID.
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

    function addNewPlan(){
        $(".icon-div").removeClass('active');
        $("#plan_icon_id").val('');
        $.ajax({
            type: "POST",
            url: '{{ url("/onboarding/plans/add") }}' ,
            data: {
                "nextstep": 'subscription_plan',
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success == 1){
                    $("#editplan").modal('show');
                    $("#editplansubcription").html(response.view);
                    $('#addplanform')[0].reset();
                    $("#addplanbtn").removeClass('disabled');
                    $('label.error').remove();
                    $('.appoinmentfee').hide();
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
        
    }
    
    function deletePlan(key){
        swal({
      text: "Are you sure you want to delete the plan?",
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
            type: "POST",
            url: '{{ url("/onboarding/plan/delete") }}' ,
            data: {
              
                "key": key,
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success == 1){
                    swal.close();
                    swal(response.message, {
                      title: "Success!",
                      text: 'Plan deleted successfully',
                      icon: "success",
                      buttons: false,
                      timer: 2000 // Closes after 2 seconds
                  }).then(() => {
                    getPlanList();
                  });
                   
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
        }
    });
  }
    function editPlan(key){
        $("#editplan").modal('show');
        
     
        $.ajax({
            type: "POST",
            url: '{{ url("/onboarding/plan/edit") }}' ,
            data: {
              
                "key": key,
                "nextstep": 'subscription_plan',
                
                    "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success == 1){
                    $("#editplansubcription").html(response.view);
                    $('input, textarea').each(function () {
                        toggleLabel(this);
                    });
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })


    }
    function updatePlan(key){
        if ($("#editplanform").valid()) {

            var icard = $("#iscard").val();
            
            if( icard !='1' && ( $("#appointmnetfee").is(':checked') && ($("#inperson_fee").is(':visible') &&  ( ($("#inperson_fee").val() == '0') || ($("#inperson_fee").val() == '0.00') )) || ( $("#virtual_fee").is(':visible') && ($("#virtual_fee").val() == '0' || $("#virtual_fee").val() == '0.00' )) ))
            {
             
                $("#addPlan").modal('hide');
                $("#addCreditCard").modal('show');
                stripeElaments();
             
            }else{
                $.ajax({
                    type: "POST",
                    url: '{{ url("/onboarding/subscription_plan") }}' ,
                    data: {
                    
                        "key": key,
                        "currentStepId": 4,
                        "nextstep": 'subscription_plan',
                        'formdata': $("#editplanform").serialize() ,
                            "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if(response.success == 1){
                            $("#editplan").modal('hide');
                            getPlanList();
                        }
                    },
                    error: function(xhr) {
                        handleError(xhr);
                    },
                }) 
              
                
            }


       
        }
    }
    

    function addSubscriptionPlan(){
    
        if ($("#addplanform").valid()) {
            $("#addplanbtn").addClass('disabled');
            let formdata = $("#addplanform").serialize() ;
            var icard = $("#iscard").val();
            
            if( icard !='1' && ( $("#appointmnetfee").is(':checked') && ($("#inperson_fee").is(':visible') &&  ( ($("#inperson_fee").val() == '0') )) || ( $("#virtual_fee").is(':visible') && $("#virtual_fee").val() == '0') ))
            {
             
                $("#editplan").modal('hide');
                $("#addCreditCard").modal('show');
                stripeElaments();
                
               
             
            }else{
                // getOnboardingDetails('subscription_plan',formdata) ;
               
                savePlanDetails('subscription_plan',formdata);
              
                
            }
        }
    }
    function savePlanDetails(type,formdata='',plantype=''){
        $("#savegenericplans").addClass('disabled');
        $.ajax({
                    type: "POST",
                    url: '{{ url("/onboarding/subscription_plan") }}' ,
                    data: {
                        'formdata': formdata,
                        'plan_type' : plantype,
                        "currentStepId": 1,
                        "nextstep": 'subscription_plan',
                       
                            "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if(response.success == 1){
                            $("#addPlan").modal('hide');
                            $("#editplan").modal('hide');
                            
                            $('#previewTemplatesModal').modal('hide');
                            getPlanList();
                            $("#addplanbtnsubmit").show();
                            $("#savegenericplans").removeClass('disabled');
                        }
                    },
                    error: function(xhr) {
                        handleError(xhr);
                    },
                })

    }
    $(document).ready(function() {
        $(document).on('change', '.appointment-type[type="checkbox"]', function() {
            console.log('check')
            // Check if the checkbox is checked
            if ($(this).is(':checked')) {
                $('.appoinmentfee').show(); // Show the extra input
                $('input').each(function() {
                    toggleLabel(this);
                });
            } else {
                $('.appoinmentfee').hide(); 
            }
        });
    });

function previewTemplates(type, formdata='', plantype='') {
    // Show the preview modal
    $('#previewTemplatesModal').modal('show');
    $("#savegenericplans").removeClass('disabled');
}

</script>









@stop