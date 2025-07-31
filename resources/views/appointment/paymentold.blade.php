<div class="modal-header modal-bg p-0 position-relative">
                      <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                  </div>
                  <div class="modal-body">
                    <div class="text-center amount_body">
                      <h4 class="text-center fwt-bold mb-1">Appointment Fee</h4>
                      <small class="gray">Please pay the appointment fee to continue with your appointment. </small>
                      <h5 class="mt-4 mb-2 fwt-bold">Total Amount</h5>
                      <h3 class="mb-4"><span class="gray">$</span>{{number_format($amount,2)}}</h3>
                    </div>
                    <form method="POST" action="" id="feechange" autocomplete="off">
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
                          <div id="card-element">

                          </div>
                        </div>
                        

                        <!--
                        <div class="col-lg-6 col-12">
                          <div class="form-group form-outline mb-3">
                            <label for="input" class="">Valid Till</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                          </div>
                        </div>
                        <div class="col-lg-6 col-12">
                          <div class="form-group form-outline mb-3">
                            <label for="input" class="">CVV</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                          </div>
                        </div> -->
                        <div class="btn_alignbox mt-5">
                        <button type="submit" id="submitbtn"  class="btn btn-primary w-100" >Pay Now</button>
                        </div>
                      </div>


                </form>
              </div>

<div id="modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <iframe id="modalIframe" src="" style="width: 100%; height: 80vh; border: none;"></iframe>
    </div>
</div>


<script>
 $(document).ready(function() {

  $('#feechange').validate({
            ignore: [],
            rules: {
              name_on_card: 'required',
               

            },
            messages: {
                name_on_card: 'Please enter name.',
                

            },

        });


    // Initialize Stripe with the platform's publishable key
    const stripe = Stripe("{{ env('STRIPE_KEY') }}", {
            stripeAccount: "{{ $stripeAcc }}" // Pass the connected account ID from Laravel
        });
    var style = {
        hidePostalCode: true,
        base: {
            color: '#564c4c',
            lineHeight: '20px',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '15px',
            '::placeholder': {
                color: '#a1a1a1'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };

    var elements = stripe.elements();
    var cardElement = elements.create('card', { hidePostalCode: true, style: style });
    cardElement.mount('#card-element');

    // Handle validation errors from the card Element
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('new-card-errors');
        displayError.textContent = event.error ? event.error.message : '';
        $(".paymentblock").toggleClass('card-error', !!event.error);
    });

    // Handle form submission
    var form = document.getElementById("feechange");
    form.addEventListener("submit", async (event) => {
        event.preventDefault();

       
        
        const { error, paymentMethod } = await stripe.createPaymentMethod({
                      type: 'card',
                      card: cardElement,
                    });

        if (error) {
            console.error('Error creating payment method:', error);
            return;
        }

        const paymentMethodId = paymentMethod.id;
        var appoinmentuuid = '{{ $appoinmentuuid }}';

        // Send the PaymentMethod ID to the backend to create a PaymentIntent
        $.ajax({
            type: "POST",
            url: "{{ url('payment/createpaymentIntent') }}",
            data: {
                'payment_method': paymentMethodId,
                'appoinment_uuid': appoinmentuuid,
                "_token": "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(data) {
                if (data.success == 1) {
                    
                    if(data.paymentstatus =='requires_action' ){
                        
                        
                        // Confirm the PaymentIntent on the frontend with the provided clientSecret
                        stripe.confirmCardPayment(data.clientSecret, {
                            payment_method: paymentMethodId
                        }, {
                            stripeAccount: "{{ $stripeAcc }}" // Reuse the connected account ID
                        }).then(function(result) {
                            if (result.error) {
                                swal({
                                 icon: 'error',
                                 text: 'Error confirming PaymentIntent:'+ result.error.message,
                               });
                            } else {
                                console.log(result.paymentIntent.status);
                                if(result.paymentIntent.status == 'succeeded'){
                                    stripeTokenHandler(data.payment_intent_id);
                                }else if(result.paymentIntent.status == 'requires_payment_method'){
                                    swal({
                                     icon: 'error',
                                     text: result.paymentIntent.last_payment_error ? result.paymentIntent.last_payment_error.message : "Payment method required.",
                                   });
                                    
                                    
                                }else if(result.paymentIntent.status == 'requires_action'){
                                      if (result.paymentIntent.action_url) {
                                         $('#modalIframe').attr('src', result.paymentIntent.action_url);
                                         $('#modal').fadeIn();
                                        }
                                }
                                
                            }
                        });
                    }else{
                      console.log('test')
                       stripeTokenHandler(data.payment_intent_id); 
                    }
                } else {
                   swal({
                     icon: 'error',
                     text: data.message,
                   });
                 }
            },
            error: function(xhr) {
               
              handleError(xhr);
           },
        });
    });
});

    // Submit the form with the token ID.
function stripeTokenHandler(paymentIntent) {
 
    if($("#feechange").valid()){
        console.log(paymentIntent);
        continuePayment(paymentIntent);
        //form.submit(); 
    }
}
function continuePayment(setupIntentID){
    
        var appoinmentuuid = '<?php echo $appoinmentuuid;?>';
          $('#videomeet_modal').modal('show');
          $('#videomeet').html('<div class="d-flex justify-content-center py-5">Processing Payment....</div>');

          $.ajax({
            type: "POST",
            url: "{{url('payment/submitpayment')}}",
            data: {
              'formdata': $('#feechange').serialize(),
              'appoinment_uuid': appoinmentuuid,
              'setupIntentID': setupIntentID,
                 "_token": "{{ csrf_token() }}",
                
            },

            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function (response) {
              // Populate form fields with the logger details

              if (response.status == 1) {
                  $('#videomeet').html(response.html);
//                  setTimeout(function() { 
//                      window.location.reload();
//                        window.open("{{ url('meet/') }}/" + appoinmentuuid, '_blank'); 
//                      $('#paymentsuccess').modal('hide');
//                      $('#videomeet_modal').modal('hide');
//                    }, 3000);
                // $("#videomeet").html(response.view);

              }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
          });

}    
     
</script>


            