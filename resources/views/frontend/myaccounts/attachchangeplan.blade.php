<?php $corefunctions = new \App\customclasses\Corefunctions; ?>  
<div class="row g-4 align-items-center my-4">
    <div class="col-12 col-lg-8">
        <div class="d-flex align-items-center gap-3">  
            <a href="javascript:void(0);" onclick="changeTab('subscriptions');" class="primary"><span class="material-symbols-outlined">arrow_back</span></a>
            <div class="user_inner user_inner_xl">
                <img src="{{$clinic['clinic_logo']}}">
                <div class="user_info">
                    <h5 class="primary fw-bold m-0">{{$clinic['name']}}</h5> 
                    <p class="mb-0 gray">Upgrade plan or continue with current plan</p> 
                    @if(!empty($currentSubscriptionDets) && !empty($renewalSubscriptionDets))
                    <p class="mb-0 gray">You are currently on {{$currentSubscriptionDets['plan_name']}}. Your subscription will switch to {{$renewalSubscriptionDets['plan_name']}} on {{date('m/d/Y',strtotime($patientSubscriptionDets['renewal_date']))}}.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4"> 
        <div class="toggle-switch d-flex align-items-center justify-content-end">
            <span class="me-2 gray" id="monthlyText">Yearly</span>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" name="billingToggle" id="billingToggle" @if($type == 'monthly') checked @endif onclick="handleBillingToggle()">
            </div>
            <span class="gray" id="yearlyText">Monthly</span>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-4 "  @if(!empty($patientSubscriptionDets) && ($patientSubscriptionDets['tenure_type_id'] == '2') && $type == 'monthly') style="display:none;" @elseif(!empty($patientSubscriptionDets) && ($patientSubscriptionDets['tenure_type_id'] == '1') && $type == 'yearly') style="display:none;" @endif >
        <div class="plan-highlighted  rounded rounded-3 p-4 h-100">
            <div class="d-flex flex-column justify-content-between h-100"> 
                <div class="plans-head position-relative"> 
                    <div class="current-plan d-inline-flex align_middle"><span class="material-symbols-outlined">license</span><small class="white">Current Plan</small></div>
                    <img @if(!empty($patientSubscriptionDets)) src="{{asset('images/plan_icons/'.$planIcons[$patientSubscriptionDets['plan_icon_id']]['icon_path'])}}" @else src="{{asset('images/plan_icons/Diamond.png')}}" @endif alt="Badge" class="subtype-icon">
                    <h2 class="fw-bold my-2">@if(!empty($patientSubscriptionDets)) {{$patientSubscriptionDets['plan_name']}} @else Pay As You Go Plan @endif</h2>
                    <p class="mb-0">@if(!empty($patientSubscriptionDets)) <?php echo nl2br($patientSubscriptionDets['description']) ?> @else Designed for flexibility and convenience, this plan allows you to access high-quality care only when you need it. No ongoing commitment — just pay per visit, whether in-person or virtual.@endif</p>
                </div>
                <div> 
                    <div class="fees-container"> 
                        <div class="d-flex align-items-center gap-3"> 
                            <h2 class="mb-0">
                                @if(!empty($patientSubscriptionDets)) 
                                    ${{ floor($patientSubscriptionDets['virtual_fee']) == $patientSubscriptionDets['virtual_fee'] ? number_format($patientSubscriptionDets['virtual_fee'], 0) : number_format($patientSubscriptionDets['virtual_fee'], 2) }}
                                @else 
                                    ${{ floor($clinic['virtual_fee']) == $clinic['virtual_fee'] ? number_format($clinic['virtual_fee'], 0) : number_format($clinic['virtual_fee'], 2) }}
                                @endif
                            </h2>
                            <div> 
                                <p class="mb-0">Virtual</p>
                                <p class="mb-0">Appointment Fee</p>
                            </div>
                        </div>
                    </div>
                    <div class="fees-container border-bottom-0"> 
                        <div class="d-flex align-items-center gap-3"> 
                            <h2 class="mb-0">
                                @if(!empty($patientSubscriptionDets)) 
                                    ${{ floor($patientSubscriptionDets['inperson_fee']) == $patientSubscriptionDets['inperson_fee'] ? number_format($patientSubscriptionDets['inperson_fee'], 0) : number_format($patientSubscriptionDets['inperson_fee'], 2) }}
                                @else 
                                    ${{ floor($clinic['inperson_fee']) == $clinic['inperson_fee'] ? number_format($clinic['inperson_fee'], 0) : number_format($clinic['inperson_fee'], 2) }}
                                @endif
                            </h2>
                            <div> 
                                <p class="mb-0">In-Person</p>
                                <p class="mb-0">Appointment Fee</p>
                            </div>
                        </div>
                    </div>
                    <div class="fees-container-highlight"> 
                        <div class="d-flex align-items-center gap-3"> 
                            <h3 class="mb-0 monthlycls" style="display:none;">
                                @if(!empty($patientSubscriptionDets)) 
                                    ${{ floor($patientSubscriptionDets['monthly_amount']) == $patientSubscriptionDets['monthly_amount'] ? number_format($patientSubscriptionDets['monthly_amount'], 0) : number_format($patientSubscriptionDets['monthly_amount'], 2) }}
                                @else 
                                    $0
                                @endif
                            </h3>
                            <h3 class="mb-0 yearlycls">
                                @if(!empty($patientSubscriptionDets)) 
                                    ${{ floor($patientSubscriptionDets['annual_amount']) == $patientSubscriptionDets['annual_amount'] ? number_format($patientSubscriptionDets['annual_amount'], 0) : number_format($patientSubscriptionDets['annual_amount'], 2) }}
                                @else 
                                    $0
                                @endif
                            </h3>
                            <div> 
                                <p class="mb-0 white yearlycls">Yearly</p>
                                <p class="mb-0 white monthlycls" style="display:none;">Monthly</p>
                                <p class="mb-0 white">Subscription Fee</p>
                            </div>
                        </div>
                    </div>
                   
                    <div class="btn_alignbox mt-4"> 
                        <button type="button" class="btn btn-outline-primary w-100">Current Plan</button>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>

    @if(!empty($patientSubscriptionDets))
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
                        
                    </div>
                </div>
            </div>
        </div>
    @endif
  
    @if(!empty($clinicSubscriptions))
        @foreach($clinicSubscriptions as $clinicSubscription)
     
        @if(!empty($patientSubscriptionDets) && $clinicSubscription['id'] != $patientSubscriptionDets['clinic_subscription_id'] && !empty($patientSubscriptionDets) && (($patientSubscriptionDets['tenure_type_id'] == '2' && $type == 'yearly') || ($patientSubscriptionDets['tenure_type_id'] == '1' && $type == 'monthly')) )
      
        <div class="col-12 col-lg-4">
                <div class="border rounded-3 p-4 h-100">
                    <div class="d-flex flex-column justify-content-between h-100"> 
                        <div class="plans-head"> 
                            <img src="{{asset('images/plan_icons/'.$planIcons[$clinicSubscription['plan_icon_id']]['icon_path'])}}" alt="Badge" class="subtype-icon">
                            <h2 class="fw-bold my-2">{{$clinicSubscription['plan_name']}}</h2>
                            <p class="mb-0">@if(isset($clinicSubscription['description'])){{$clinicSubscription['description']}} @endif</p>
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
                                    <h3 class="mb-0 yearlycls" @if($type == 'monthly') style="display:none;" @endif>
                                        ${{ floor($clinicSubscription['annual_amount']) == $clinicSubscription['annual_amount'] ? number_format($clinicSubscription['annual_amount'], 0) : number_format($clinicSubscription['annual_amount'], 2) }}
                                    </h3>
                                    <h3 class="mb-0 monthlycls" @if($type == 'yearly') style="display:none;" @endif>
                                        ${{ floor($clinicSubscription['monthly_amount']) == $clinicSubscription['monthly_amount'] ? number_format($clinicSubscription['monthly_amount'], 0) : number_format($clinicSubscription['monthly_amount'], 2) }}
                                    </h3>
                                    <div> 
                                        <p class="mb-0 white yearlycls" @if($type == 'monthly') style="display:none;" @endif>Yearly</p>
                                        <p class="mb-0 white monthlycls" @if($type == 'yearly') style="display:none;" @endif>Monthly</p>
                                        <p class="mb-0 white">Subscription Fee</p>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_alignbox mt-4"> 
                                <button type="button" class="btn btn-primary w-100" onclick="showPaymentModal('{{$clinic['id']}}','{{$clinicSubscription['clinic_subscription_uuid']}}');">Change Plan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(empty($patientSubscriptionDets) || ( !empty($patientSubscriptionDets) && (($patientSubscriptionDets['tenure_type_id'] == '2' && $type == 'monthly') || ($patientSubscriptionDets['tenure_type_id'] == '1' && $type == 'yearly')) ))
        <div class="col-12 col-lg-4">
                <div class="border rounded-3 p-4 h-100">
                    <div class="d-flex flex-column justify-content-between h-100"> 
                        <div class="plans-head"> 
                            <img src="{{asset('images/plan_icons/'.$planIcons[$clinicSubscription['plan_icon_id']]['icon_path'])}}" alt="Badge" class="subtype-icon">
                            <h2 class="fw-bold my-2">{{$clinicSubscription['plan_name']}}</h2>
                            <p class="mb-0">{{$clinicSubscription['description']}}</p>
                        </div>
                        <div> 
                            <div class="fees-container"> 
                                <div class="d-flex align-items-center gap-3"> 
                                    <h2 class="mb-0">
                                        ${{ floor($clinicSubscription['virtual_fee']) == $clinicSubscription['virtual_fee'] ? number_format($clinicSubscription['virtual_fee'], 0) : number_format($clinicSubscription['virtual_fee'], 2) }}
                                    </h2>
                                    <div> 
                                        <p class="mb-0">Virtual</p>
                                        <p class="mb-0">Appointment Fee</p>
                                    </div>
                                </div>

                            </div>
                            <div class="fees-container border-bottom-0"> 
                                <div class="d-flex align-items-center gap-3">
                                    <h2 class="mb-0">
                                        ${{ floor($clinicSubscription['inperson_fee']) == $clinicSubscription['inperson_fee'] ? number_format($clinicSubscription['inperson_fee'], 0) : number_format($clinicSubscription['inperson_fee'], 2) }}
                                    </h2> 
                                    <div> 
                                        <p class="mb-0">In-Person</p>
                                        <p class="mb-0">Appointment Fee</p>
                                    </div>
                                </div>
                            </div>
                            <div class="fees-container-highlight"> 
                                <div class="d-flex align-items-center gap-3"> 
                                    <h3 class="mb-0 yearlycls" @if($type == 'monthly') style="display:none;" @endif>
                                        ${{ floor($clinicSubscription['annual_amount']) == $clinicSubscription['annual_amount'] ? number_format($clinicSubscription['annual_amount'], 0) : number_format($clinicSubscription['annual_amount'], 2) }}
                                    </h3>
                                    <h3 class="mb-0 monthlycls" @if($type == 'yearly') style="display:none;" @endif>
                                        ${{ floor($clinicSubscription['monthly_amount']) == $clinicSubscription['monthly_amount'] ? number_format($clinicSubscription['monthly_amount'], 0) : number_format($clinicSubscription['monthly_amount'], 2) }}
                                    </h3>
                                    <div> 
                                        <p class="mb-0 white yearlycls" @if($type == 'monthly') style="display:none;" @endif>Yearly</p>
                                        <p class="mb-0 white monthlycls" @if($type == 'yearly') style="display:none;" @endif>Monthly</p>
                                        <p class="mb-0 white">Subscription Fee</p>
                                    </div>
                                </div>
                            </div>
                            <div class="btn_alignbox mt-4"> 
                                <button type="button" class="btn btn-primary w-100" onclick="showPaymentModal('{{$clinic['id']}}','{{$clinicSubscription['clinic_subscription_uuid']}}');">Change Plan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @endforeach
    @endif
    
</div>
<script>
    function handleBillingToggle() {
        const billingToggle = document.getElementById('billingToggle');
        if (!billingToggle.checked) {
            $(".monthlycls").hide();
            $(".yearlycls").show();
            $(".monthlycurrentplan").hide();
            $(".yearcurrentPlan").show();
            changePlan('{{$clinic['id']}}','yearly');
        } else {
            $(".monthlycls").show();
            $(".yearlycls").hide();
            $(".yearcurrentPlan").hide();
            $(".monthlycurrentplan").show();
            changePlan('{{$clinic['id']}}','monthly');
        }
       
    }
</script>