<div class="tab-pane fade show active" id="pills-addon" role="tabpanel" aria-labelledby="pills-addon-tab">
  <div class="row g-4">
        @if(empty($users))
        <div class="col-12">
            <div class="border rounded-4 p-4 bg-white"> 
                <div class="row align-items-center mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{asset('/images/escribe.png')}}" alt="icon" class="escribe-icon">
                            <div>
                                <h4 class="gray fw-medium mb-1">Optional Add-On</h4>
                                <h2 class="font-large mb-0 fw-bold">ePrescribe</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="btn_alignbox justify-content-md-end gap-4">
                            <div>
                                <h5 class="mb-0 fw-bold">$79.00</h5>
                                <p class="gray mb-0">Per month</p>
                            </div>
                            @if(session()->get('user.userType') == 'clinics')
                            <a class="btn btn-primary" onclick="enableAddOn();"> Enable ePrescribe</a>
                            @endif
                        </div>
                    </div>

        
                </div>

                <div class="gray-border"></div>

                <div class="mt-3">
                    <small class="fw-exlight">Add-On includes:</small>
                    <ul class="list-unstyled imp-point mt-2 mb-0">
                        <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>One-time Setup: $250</li>
                        <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>12-month minimum commitment required</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
        <?php 
        $corefunctions = new \App\customclasses\Corefunctions;?>
        @if(!empty($users))
        <div class="col-12"> 
            <div class="border rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-lg-center flex-lg-row flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{asset('/images/escribe.png')}}" class="img-fluid escribe-img" alt="escribe">
                        <div class="">
                            <p class="gray fw-medium mb-0">Addons</p>
                            <h2 class="font-large mb-0 fw-bold">ePrescribe</h2>
                        </div>
                    </div>
                
                    <div class="text-lg-end">
                        <div class="d-flex align-items-center gap-2 onboard-success mb-1">
                            <span class="material-symbols-outlined">verified</span>
                            <h4 class="fw-bold m-0">ePrescription Enabled</h4>
                        </div>
                        <p class="m-0">Next Payment Due - {{$nextPaymentDue}}</p>
                    </div>
                </div>
            </div>
        </div>

        @endif


  </div>
    
</div>


<!-- Users-enable add-on Modal -->
<div class="modal fade" id="enableAddonstatic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl subscription-modal-xl ">
        <div class="modal-content subscription-modal p-0">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0 ">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="subscription-box">
                            <h4>Subscribe to Blackbag ePrescribe</h4>
                            <div class="amount align-items-start gap-2">
                                <div class="d-flex flex-column">
                                    <div class="align_middle align-items-start">
                                        <h1 class="display-5 fw-bold mb-0">$79.00</h1>
                                        <p class="fw-light mb-0">per doctor</p>
                                    </div>
                                    <p>ePrescription Monthly Fee</p>
                                </div>
                            </div>
                            <div class="feature-box d-flex gap-3">
                                <img src="{{asset('images/bb-eprescribe.png')}}" class="escribe-icon" alt="">
                                <div>
                                    <strong>Blackbag ePrescribe</strong><br />
                                    <small>
                                    BlackBag ePrescribe unlocks fast, accurate, and secure digital prescribing — helping you save time, reduce errors, and deliver a seamless experience for your patients.
                                    </small>
                                </div>
                            </div>
                            <div class="amount-list mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <p>One Time Setup Fee</p>
                                    <span><strong>$250.00</strong></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <p>Amount Per Prescriber</p>
                                    <span>($79.00 × 1) <strong class="ms-1">$79.00</strong></span>
                                </div>
                                <hr />
                                <div class="d-sm-flex  justify-content-between     total-price text-end  ">
                                    <span>Total Due Today</span>
                                    <span class="ms-2">$344.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Subscription Form -->
                <div class="col-lg-6">
                    <div class="form-container ">
                    <form>
                    <!-- Prescriber Selection -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3">Prescribers</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-outline no-iconinput">
                                    <label for="input">Select Patient</label>
                                
                                    <div class="dropdownBody">
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                            </a>
                                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                                <li class="dropdown-item">
                                                    <div class="form-outline input-group ps-1">
                                                        <div class="input-group-append">
                                                        <button class="btn border-0" type="button">
                                                            <i class="fas fa-search fa-sm"></i>
                                                        </button>
                                                        </div>
                                                        <input type="text" class="form-control border-0 small" placeholder="Search Patient" aria-label="Search" aria-describedby="basic-addon2">
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="slt-prescribers">
                                    <div class="user_inner">
                                        <img src="{{asset('images/doct1.png')}}" class="img-fluid">
                                        <div class="user_info">
                                            <h6 class="primary fw-medium m-0">Jelani Kasongo, MD</h6>
                                            <p class="m-0">jelanikasongo@gmail.com</p>
                                        </div>
                                    </div>
                                    <div class="gray-borde mt-3 mb-3"></div>
                                    <div class="prescribers">
                                        <p class="m-0">Would you like to enable Blackbag ePrescribe for yourself.</p>
                                        <div class="d-flex gap-3">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">YES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">NO</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>


          <!-- Card Info -->
          <h5 class="fw-bold mb-2">Payment Method</h5>
          <h6 class="sub-h mb-3">Card Information</h6>
          <div class="row mt-2">
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Name On Card</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Card Number</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Expiry</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">CCV</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
          </div>

          <!-- Billing Address -->
          <h6 class="sub-h my-3">Billing Address</h6>
          <div class="row mt-2">
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Address</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">City</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">ZIP</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
                        
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">State</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
                                    
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Countrye</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
          </div>

          <!-- Disclaimer -->
          <small class="text-muted d-block mb-3">
            <span class="text-danger">*</span> By confirming your subscription, you agree to an annual commitment and authorize BlackBag to charge you monthly in accordance with our terms. You may cancel anytime, and your subscription will remain active until the end of the billing period.
          </small>

          <!-- Submit Button -->
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#successSubscription">Confirm Subscription</button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>


<div class="modal login-modal payment-success fade" id="viewinvoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">View Invoice</h5>
                </div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0" id="invoicepdf">
                <div class="preloaderappend inquirylistloder centered notification-loader"><img src="{{ asset('img/loading.gif') }}">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Users-enable add-on Modal -->
<script src="https://js.stripe.com/v3/"></script>  



<script>
      function addCard(){
        $("#enableAddon").modal('hide');
        $("#addCard").modal('show');
        initializeAddCard();
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
</script>

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