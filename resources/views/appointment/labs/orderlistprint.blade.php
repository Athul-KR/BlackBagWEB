

<div class="card">
    <div class="card-body">


    <?php
        $corefunctions = new \App\customclasses\Corefunctions;
        $clinicLogo = $corefunctions->getClinicLogo();
    ?>
    @if(!empty($finalTestArray))
        
  
            <div class="row g-2">
                @if(!empty($clinicDetails))
                <div class="col-12 border-bottom pb-3"> 
                    <div class="row align-items-center">
                        <div class="col-9"> 
                            <div class="d-flex align-items-center gap-2">
                                <img alt="Blackbag" src="{{ $clinicLogo}}" class="logo me-2 cliniclogocls">
                                <h4 class="mb-0">{{$clinicDetails['name']}}</h4>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="d-flex flex-column align-items-baseline text-start gap-2">
                                <p class="primary btn-align justify-content-end mb-0"><span class="material-symbols-outlined">mail</span>{{$clinicDetails['email']}}</p>
                                <p class="primary btn-align justify-content-end mb-0"><span class="material-symbols-outlined">call</span>@if(isset($countryCodedetails['country_code'])) {{ $countryCodedetails['country_code'] }} @endif  <?php echo $corefunctions->formatPhone($clinicDetails['phone_number']) ?></p>
                                <p class="primary btn-align justify-content-end align-items-start mb-0"><span class="material-symbols-outlined">pin_drop</span><?php $corefunctions = new \App\customclasses\Corefunctions;
                                    $address = $corefunctions->formatAddress($clinicDetails); ?>
                                    <?php echo nl2br($address); ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                <div class="col-12"> 
                    <div class="row align-items-start">
                        <div class="col-md-5">
                            <div class="user_inner">
                                <img  src="{{$patientDetails['logo_path']}}" alt="Patient">
                                <div class="user_info">
                                    <h6 class="primary fw-medium mb-1">{{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h6>
                                    <p class="mb-0">{{$patientDetails['age']}} | @if($patientDetails['gender'] == '1') Male @elseif($patientDetails['gender'] == '2') Female @else Other @endif </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h6 class="primary fw-medium mb-1">Ordered by</h6>
                            <p class="mb-1">{{ $corefunctions -> showClinicanNameUser($userDetails,'0')}}</p>

                            <div class="print-info mb-1">
                                <i class="material-symbols-outlined">mail</i>
                                <small>{{$userDetails['email']}}</small>
                            </div>
                            <div class="print-info">
                                <i class="material-symbols-outlined">call</i>
                                <small>@if(!empty($userCountryCode)){{$userCountryCode['country_code']}} @endif <?php echo $corefunctions->formatPhone($userDetails['phone_number']) ?></small>
                            </div>


                        </div>
                        <div class="col-md-3">
                            <h6 class="primary fw-medium mb-1">Date of test</h6>
                            <p class="mb-0">@if(!empty($orderLists)) <?php echo $corefunctions->timezoneChange($orderLists['test_date'],"m/d/Y") ?> @else --  @endif</p>
                        </div>
                    </div>
                </div>
                <div class="col-12"> 
                    <div class="text-center border-top border-bottom py-3">
                        <h5 class="primary fw-bold mb-0">
                            Lab Test Form</h5>
                    </div>
                </div>
                <div class="col-12"> 

                    <div class="row">
                        @foreach ($finalTestArray as $labTestId => $items) 
                        <div class="col-12"> 
                            <div class="categorycls_{$labTestId}}">
                                <div class="catgry-main mb-2">
                                    <h6 class="mb-0 primary fw-bold">{{$categoryDetails[$labTestId]['name']}}</h6>
                                </div>
                                @foreach ($items as $item)  
                                <div class="catgry-sub mb-2">
                                    <div class="row">
                                        <div class="col-12">
                                            @if(isset($item['sub_lab_test_id']) && $item['sub_lab_test_id'] !='')
                                            <p class="primary fw-medium mb-0">{{$categoryDetails[$item['sub_lab_test_id']]['name']}}</p>
                                            @endif
                                            @if(isset($item['description']) && $item['description'] !='')
                                            <p class="text-muted fst-italic mb-0">{!! nl2br(e($item['description'])) !!}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-start"> 
                        <div class="d-flex flex-column mb-1">
                            <p class="fw-light mb-0">Signed By :</p>
                            <p class="primary fw-middle mb-0">{{ $corefunctions -> showClinicanNameUser($userDetails,'0')}}</p>
                        </div>
                        <div class="d-flex flex-column">
                            <p class="fw-light mb-0">Signed On :</p>
                            <p class="primary fw-middle mb-0">@if(!empty($orderLists)) <?php echo $corefunctions->timezoneChange($orderLists['test_date'],"m/d/Y") ?> @else --  @endif</p>
                        </div>
                        
                    </div>

                </div>

                <div class="col-12"> 
                    <div class="footer-wrapper"> 
                        <img alt="Blackbag" src="{{ asset('images/logo.png') }}">
                        <h6 class="mt-2 mb-0">Copyright © BlackBag. All rights reserved.</h6>
                    </div>
                </div>

                
            </div>
    

    @else
        <div class="nopreview-sec">
            <img src="{{asset('images/nopreview.png')}}" class="img-fluid" frameborder="0" alt="No Preview">
        </div>
    @endif

    </div>
</div>



