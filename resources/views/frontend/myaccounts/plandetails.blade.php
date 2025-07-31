                <div class="text-center px-lg-5">
                    <h4 class="fw-bold mb-3">Current Plan</h4>
                </div>
                <div class="border rounded rounded-3 p-4 h-100"> 
                    <div class="plans-head"> 
                        <img @if(!empty($patientSubscriptions)) src="{{asset('frontend/images/gold.png')}}" @else src="{{asset('frontend/images/diamond.png')}}" @endif alt="Badge" class="subtype-icon">
                        <h2 class="fw-bold my-2">@if(!empty($patientSubscriptions)) {{$patientSubscriptions['plan_name']}} @else Pay As You Go Plan @endif</h2>
                        <p class="mb-3">@if(!empty($patientSubscriptions)) {{$patientSubscriptions['description']}} @else Designed for flexibility and convenience, this plan allows you to access high-quality care only when you need it. No ongoing commitment — just pay per visit, whether in-person or virtual.@endif</p>
                    </div>
                    <?php $corefunctions = new \App\customclasses\Corefunctions; ?> 
                    <div class="row mb-4">
                        <div class="col-12 col-lg-6">
                            <div class="fees-container border-bottom-0 border-r p-0 my-3"> 
                                <div class="d-flex align-items-center gap-3"> 
                                    <h2 class="mb-0">@if(!empty($patientSubscriptions)) $<?php echo $corefunctions->formatAmount($patientSubscriptions['virtual_fee']); ?> @else $<?php echo $corefunctions->formatAmount($clinic['virtual_fee']); ?> @endif</h2>
                                    <div> 
                                        <p class="mb-0">Virtual</p>
                                        <p class="mb-0">Appointment Fee</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-12 col-lg-6"> 
                            <div class="fees-container border-bottom-0 p-0 my-3"> 
                                <div class="d-flex align-items-center gap-3"> 
                                    <h2 class="mb-0">@if(!empty($patientSubscriptions)) $<?php echo $corefunctions->formatAmount($patientSubscriptions['inperson_fee']); ?> @else $<?php echo $corefunctions->formatAmount($clinic['inperson_fee']); ?> @endif</h2>
                                    <div> 
                                        <p class="mb-0">In-Person</p>
                                        <p class="mb-0">Appointment Fee</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="fees-container-highlight"> 
                        <div class="d-flex align-items-center gap-3"> 
                            <h3 class="mb-0">@if(!empty($patientSubscriptions)) $<?php echo $corefunctions->formatAmount($patientSubscriptions['annual_amount']); ?>@else $0 @endif</h3>
                            <div> 
                            <p class="mb-0 white">Subscription</p>
                                <p class="mb-0 white"> Fee</p>
                            </div>
                        </div>
                    </div>
                </div>