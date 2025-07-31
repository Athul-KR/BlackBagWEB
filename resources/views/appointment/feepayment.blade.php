
 <link rel="stylesheet" href="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/dist/videosdk-ui-toolkit.css')}}">
<div id="join-flow">
                <h1>Zoom Video SDK Sample JavaScript</h1>
                <p>User interface offered by the Video SDK UI Toolkit</p>
        
            </div>
        
            <div id='sessionContainer'></div>


<!--
<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12 mb-3">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="" class="primary">Appointment</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment</li>
                    </ol>
                </nav>
            </div>
              <div class="col-lg-7 col-xl-6 col-12  mb-3">
              <div class="web-card h-100 mb-3 overflow-hidden">
                  <form method="POST" action="" id="feechange">
                    @csrf
                            <div class="row">
                              <div class="col-12">
                                <h5 class="" id="appointmentFeeModalLabel">Appointment Fee</h5>
                                <p>You are required to pay an appointment fee to continue your appointment call.</p>
                             
                                <div class="d-flex align-items-end my-4">
                                  <p class="mb-0">Total</p>
                                  <h2 class="ms-2 mb-0"><strong>${{$amount}}</strong></h2>
                                </div>
                                <div class="">
                                  <div class=" paymentblock">
                                    <div id="card-element"> Stripe Elements will go here </div>
                                  </div>
                                  <p class="card-error" id="new-card-errors"  role="alert"></p>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                  <button type="submit" id="submitbtn"  class="btn btn-primary">Pay Now</button>
                                </div>
                              </div>
                            </div>
                    </form>

</div>

              </div>
            </div>
    </div>
   
</section>
-->











<script src="https://js.stripe.com/v3/"></script>  
<div id="modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <iframe id="modalIframe" src="" style="width: 100%; height: 80vh; border: none;"></iframe>
    </div>
</div>
<script>
    
const name = @json('66777ddd');
const userName = `User-${new Date().getTime().toString().slice(6)}`;
</script>
<script src="{{ asset('js/meet/@zoom/videosdk-ui-toolkit/index.js')}}" type="module"></script>
<script src="{{ asset('js/meet/scripts.js')}}" type="module"></script>
<script>
    $(document).ready(function() {
    getVideoSDKJWT();
    });
</script>
<script src="{{ asset('js/meet/coi-serviceworker.min.js')}}" ></script>
<script>
    <?php /* 
// $(document).ready(function() {
//    // Initialize Stripe with the platform's publishable key
//    const stripe = Stripe("{{ env('STRIPE_KEY') }}", {
//            stripeAccount: "{{ $stripeAcc }}" // Pass the connected account ID from Laravel
//        });
//    var style = {
//        hidePostalCode: true,
//        base: {
//            color: '#32325d',
//            lineHeight: '18px',
//            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
//            fontSmoothing: 'antialiased',
//            fontSize: '16px',
//            '::placeholder': {
//                color: '#aab7c4'
//            }
//        },
//        invalid: {
//            color: '#fa755a',
//            iconColor: '#fa755a'
//        }
//    };
//
//    var elements = stripe.elements();
//    var cardElement = elements.create('card', { hidePostalCode: true, style: style });
//    cardElement.mount('#card-element');
//
//    // Handle validation errors from the card Element
//    cardElement.addEventListener('change', function(event) {
//        var displayError = document.getElementById('new-card-errors');
//        displayError.textContent = event.error ? event.error.message : '';
//        $(".paymentblock").toggleClass('card-error', !!event.error);
//    });
//
//    // Handle form submission
//    var form = document.getElementById("feechange");
//    form.addEventListener("submit", async (event) => {
//        event.preventDefault();
//
//       
//        
//        const { error, paymentMethod } = await stripe.createPaymentMethod({
//                      type: 'card',
//                      card: cardElement,
//                    }, {
//                      stripeAccount: "{{$stripeAcc}}", // Replace with the connected account ID
//                    });
//
//        if (error) {
//            console.error('Error creating payment method:', error);
//            return;
//        }
//
//        const paymentMethodId = paymentMethod.id;
//        var appoinmentuuid = '{{ $appoinmentuuid }}';
//
//        // Send the PaymentMethod ID to the backend to create a PaymentIntent
//        $.ajax({
//            type: "POST",
//            url: "{{ url('payment/createpaymentIntent') }}",
//            data: {
//                'payment_method': paymentMethodId,
//                'appoinment_uuid': appoinmentuuid,
//                "_token": "{{ csrf_token() }}",
//            },
//            dataType: 'json',
//            success: function(data) {
//                if (data.success == 1) {
//                    
//                    if(data.paymentstatus =='requires_action' ){
//                        
//                        
//                        // Confirm the PaymentIntent on the frontend with the provided clientSecret
//                        stripe.confirmCardPayment(data.clientSecret, {
//                            payment_method: paymentMethodId
//                        }, {
//                            stripeAccount: "{{ $stripeAcc }}" // Reuse the connected account ID
//                        }).then(function(result) {
//                            if (result.error) {
//                                swal({
//                                 icon: 'error',
//                                 text: 'Error confirming PaymentIntent:'+ result.error.message,
//                               });
//                            } else {
//                                console.log(result.paymentIntent.status);
//                                if(result.paymentIntent.status == 'succeeded'){
//                                 
//                                    stripeTokenHandler(result.paymentIntent.id);
//                                }else if(result.paymentIntent.status == 'requires_payment_method'){
//                                    swal({
//                                     icon: 'error',
//                                     text: result.paymentIntent.last_payment_error ? result.paymentIntent.last_payment_error.message : "Payment method required.",
//                                   });
//                                    
//                                    
//                                }else if(result.paymentIntent.status == 'requires_action'){
//                                      if (result.paymentIntent.action_url) {
//                                         $('#modalIframe').attr('src', result.paymentIntent.action_url);
//                                         $('#modal').fadeIn();
//                                        }
//                                }
//                                
//                            }
//                        });
//                    }else{
//                       stripeTokenHandler(data.payment_intent_id); 
//                    }
//                } else {
//                   swal({
//                     icon: 'error',
//                     text: data.message,
//                   });
//                 }
//            }
//        });
//    });
//});
//
//    // Submit the form with the token ID.
//function stripeTokenHandler(paymentIntent) {
// 
//    if($("#feechange").valid()){
//        console.log(paymentIntent);
//        continuePayment(paymentIntent);
//        //form.submit(); 
//    }
//}
//function continuePayment(setupIntentID){
//    console.log(setupIntentID);
//        var appoinmentuuid = '<?php echo $appoinmentuuid;?>';
//          $('#videomeet_modal').modal('show');
//          $('#videomeet').html('<div class="d-flex justify-content-center py-5">Processing Payment....</div>');
//
//          $.ajax({
//            type: "POST",
//            url: "{{url('payment/submitpayment')}}",
//            data: {
//              'appoinment_uuid': appoinmentuuid,
//              'setupIntentID': setupIntentID,
//             
//                 "_token": "{{ csrf_token() }}",
//                
//            },
//
//            headers: {
//              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//            },
//
//            success: function (response) {
//              // Populate form fields with the logger details
//
//              if (response.success == 1) {
//                $("#videomeet").html(response.view);
//
//              }
//            },
//            error: function (xhr) {
//              // Handle errors
//              var errors = xhr.responseJSON.errors;
//              if (errors) {
//                $.each(errors, function (key, value) {
//                  console.log(value[0]); // Display first error message
//                });
//              }
//            },
//          });
//
//}    
     
</script>
*/ ?>
