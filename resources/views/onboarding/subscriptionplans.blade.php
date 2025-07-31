                                @if(!empty($subscritionList))
                                @foreach($subscritionList as $plans)
                           
                                <div class="col-12">
                                    <div class="border rounded-4 p-4 bg-white"> 
                                        <div class="row">
                                            <div class="col-12 col-lg-8">
                                                <div class="user_inner plan-img mb-1">
                                                    <img src="{{asset('images/plan_icons/'.$planIcons[$plans['plan_icon_id']]['icon_path'])}}" >
                                                    <h3 class="fw-bold mb-0">{{$plans['plan_name']}}</h3>
                                                </div>

                                                <!-- <h3 class="fw-bold">{{$plans['plan_name']}}</h3> -->
                                                <p class="gray mb-1"><?php echo nl2br(e($plans['description'])) ?></p>

                                                
                                                @if($plans['has_per_appointment_fee'] != '0')
                                                    <p class="mb-2 primary fw-medium d-flex align-items-start justify-content-start gap-1">Appointment Fee <span class="material-symbols-outlined">paid</span></p>

                                                   <div class="d-flex gap-4 mb-3">
                                                        @if(  $plans['inperson_fee'] != '' && $clinicDetails['appointment_type_id'] != '1' )
                                                        <div class="d-flex gap-2">
                                                            <span class="gray appointment-text">In Person :</span>  <h4 class="mb-0 primary fw-bold font-large"> ${{$plans['inperson_fee']}} </h4>
                                                        </div>
                                                        @endif

                                                        @if( $plans['virtual_fee'] != '' && $clinicDetails['appointment_type_id'] != '2'  )
                                                        <div class="d-flex gap-2">
                                                            <span class="gray appointment-text">Virtual :</span>  <h4 class="mb-0 primary fw-bold font-large"> ${{$plans['virtual_fee']}} </h4>
                                                        </div>
                                                        @endif
                                                   </div>
                                                @endif
                                            </div>
                                            <div class="col-12 col-lg-4">
                                                <div class="btn_alignbox d-flex justify-content-lg-end align-items-md-start gap-2 mb-lg-0 mb-3 w-100">
                                                    <a class="btn opt-btn" onclick="editPlan('{{$plans['clinic_subscription_uuid']}}')">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </a>
                                                    <a class="btn opt-btn danger" onclick="deletePlan('{{$plans['clinic_subscription_uuid']}}')">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </a>
                                                    @if(count($subscritionList) > 1)
                                                        <a class="btn opt-btn move-cursor handle">
                                                            <span class="material-symbols-outlined">drag_pan</span>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="gray-border"></div>

                                       
                                        <div class="row text-center mt-3">
                                            <div class="col-12 col-lg-5">
                                                <div class="d-flex flex-lg-row flex-column gap-2 text-start align-items-lg-end mb-lg-0 mb-3"> 
                                                    <h2 class="fw-bold mb-0 font-large">${{$plans['monthly_amount']}}</h2>
                                                    <small class="gray">Monthly <br> Subscription Fee</small>
                                                </div>
                                            </div>
                                            <div class="col-lg-1 col-md-1 border-l d-lg-block d-none"> 
                                            </div>
                                            
                                            <div class="col-12 col-lg-5">
                                                <div class="d-flex flex-lg-row flex-column gap-2 text-start align-items-lg-end">
                                                    <h2 class="fw-bold mb-0 font-large">${{$plans['annual_amount']}}</h2>
                                                    <small class="gray">Annual <br> Subscription Fee</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              
                                @endforeach
                                @endif


    <script>
        
    </script>

