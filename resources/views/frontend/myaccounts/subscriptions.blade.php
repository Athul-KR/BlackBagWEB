<div class="d-flex flex-column gap-3"> 
    @if(!empty($clinics))
        @foreach($clinics as $clinic)
            <div class="border rounded rounded-3 p-3 w-100">
                <div class="row g-3 align-items-center">
                    <div class="col-lg-9">
                        <div class="row g-3 align-items-center"> 
                            <div class="col-lg-6"> 
                                <div class="user_inner user_inner_xl">
                                    <img src="{{$clinic['clinic_logo']}}">
                                    <div class="user_info">
                                     
                                            <h6 class="primary fw-bold m-0">{{$clinic['name']}}</h6>
                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4"> 
                                <div class="user_inner plan-img">
                                    <img @if(empty($clinic['subscriptions'])) src="{{asset('images/plan_icons/Diamond.png')}}" @else src="{{asset('images/plan_icons/'.$planIcons[$clinic['subscriptions']['plan_icon_id']]['icon_path'])}}" @endif>
                                    <div class="user_info">
                                        <?php $plankey = isset($clinic['subscriptions']['patient_subscription_uuid']) ? $clinic['subscriptions']['patient_subscription_uuid'] : ''; ?>
                                        <div class="align_middle justify-content-start"><p class="m-0">Clinic Center</p><a onclick="subscriptionDetails('{{$plankey}}','{{$clinic['id']}}')" class="popup-info"><span class="material-symbols-outlined">info</span></a></div>
                                        <h5 class="primary premium fw-bold m-0">@if(!empty($clinic['subscriptions'])) {{$clinic['subscriptions']['plan_name']}} @else Pay As You Go Plan @endif</h5>
                                    </div>
                                </div>
                            </div>
                            @if(!empty($clinic['subscriptions'])) 
                            <div class="col-lg-2"> 
                                <div class="row"> 
                                    <div class="col-12"> 
                                        <label class="sm-label">Next Renewal</label>
                                        <h6 class="fw-bold mb-0">{{date('m/d/Y',strtotime($clinic['subscriptions']['renewal_date']))}}</h6>
                                        <span class="badge badge-outline-dark">{{$clinic['clinicsubscriptions'][$clinic['subscriptions']['renewal_plan_id']]['plan_name']}}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-3"> 
                        <div class="row align-items-center"> 
                            <div class="col-9">
                                <div class="btn_alignbox justify-content-end">
                                    <a href="javascript:void(0);" onclick="changePlan('{{$clinic['id']}}','yearly');" class="btn btn-primary">Change Plan</a>
                                </div>
                            </div> 
                            <div class="col-3">
                                <div class="btn_alignbox justify-content-end">
                                    @if(!empty($clinic['subscriptions']))
                                    <a class="btn opt-btn align_middle" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined">more_vert</span></a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item fw-medium text-danger" onclick="cancelSubscription('{{$clinic['subscriptions']['patient_subscription_uuid']}}','{{$clinic['id']}}')"><i class="fa-solid fa-ban me-2"></i>
                                                Cancel Subscription
                                            </a>
                                        </li>
                                    </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="border rounded rounded-3 p-3 mb-3">
            <div class="text-center no-records-body">
                <img src="{{asset('frontend/images/nodata.png')}}"
                    class=" h-auto" alt="no records">
                <p>No records found</p>
            </div>
        </div>
    @endif
   
</div>


<script>
</script>

<div class="modal login-modal fade" id="subscriptionDetailsmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="subscriptionDetails">
             
            </div>
        </div>
    </div>
</div>