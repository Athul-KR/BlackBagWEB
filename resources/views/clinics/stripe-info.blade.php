<div class="col-12">

    <section>
        <!-- <div class="text-start mb-3">
            <h4>Payment Portal</h4>
            <p class="mb-0">{{$stripeData['text']}}</p>
        </div> -->
        <div class="row mt-4">
            <div class="col-xl-9 col-12 mx-auto" @if($stripeData['is_connected'] == '0') style="display: none;" @endif> 
                <div class="border rounded-4 p-4">
                    <div class="row align-items-center">
                        <div class="col-12"> 
                            <div class="image-container text-center mb-4"> 
                                <img src="{{ asset('images/payment_portal.png') }}" class="img-fluid portal-img">
                            </div>
                        </div>
                        <div class="col-12"> 
                            <div class="border rounded-4 p-4">
                                <div class="row">
                                     @if($stripeData['is_connected'] == 1)
                                    <div class="col-12 col-lg-4"> 
                                        <div class="text-start"> 
                                            <h6 class="fw-medium mb-0">Name</h6>
                                             <p class="mb-0">{{$clinicUser['name']}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4"> 
                                        <div class="text-start"> 
                                             <h6 class="fw-medium mb-0">Account ID</h6>
                                             <p class="mb-0">{{$stripeData['stripe_user_id']}}</p>
                                        </div>
                                    </div>
                                     @endif
                                    <div class="col-12 col-lg-4"> 
                                        <div class="text-center text-lg-end mt-lg-0 mt-3">
                                            <a class="btn {{ $stripeData['is_connected'] == '0' ? 'btn-primary' : 'btn-danger ' }}" onclick="stripeAction({{ json_encode($stripeData)}})"> {{ $stripeData['is_connected'] == "1" ? 'Disconnect' : 'Connect' }}</a>
                                        </div>
                                    </div>

                                </div>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if($stripeData['is_connected'] == '0')
            <div class="col-12">
                <div class="border rounded-4 p-4 bg-white">
                    <div class="row g-4">
                        <div class="col-lg-4 col-12 text-center">
                            <h5 class="fw-medium mb-0">Connect Your Bank Account</h5>
                            <p class="gray mb-3">Enable Fast, Secure Payouts for Your Patient Payments.</p>
                            <img src="{{asset('/images/stripe.png')}}" alt="Connect Bank" class="img-fluid onboard-innerImg">
                        </div>
                        <div class="col-lg-8 col-12">
                            <div class="row g-4">
                                <div class="col-12">
                                    <h6 class="fw-medium">Why Connect</h6>
                                    <ul class="list-unstyled imp-point">
                                        <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Receive payouts from patient subscriptions directly to your bank account</li>
                                        <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Enable seamless and automated revenue flow</li>
                                        <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>Ensure compliance with financial regulations</li>
                                    </ul>
                                </div>
                                
                                
                                </div>
                                <div class="col-12">
                                    <p class="primary fw-medium"><span class="primary fw-bold">Note:</span> Your data is securely processed by Stripe. BlackBag does not store or access your banking information.</p>
                                </div>
                                <div class="btn_alignbox justify-content-end">
                                    
                                    <button type="button" onclick="stripeAction({{ json_encode($stripeData)}})" class="btn btn-primary">Connect With Stripe</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
