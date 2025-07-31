<?php
$corefunctions = new \App\customclasses\Corefunctions;
?>

    <form method="POST" id="addordertestform" autocomplete="off">
    @csrf

    <input type="hidden" name="formDatas" id="labtestdata" @if(isset($formdata)) value="{{$formdata}}" @endif>
        <div class="card rounded-3">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12"> 
                        <div class="row align-items-start">
                            <div class="col-md-5">
                                <div class="user_inner">
                                    <img  src="{{$patientDetails['logo_path']}}" alt="Patient">
                                    <div class="user_info">
                                        <h6 class="primary fw-medium  mb-0">{{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h6>
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
                                    <small>@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif <?php echo $corefunctions->formatPhone($userDetails['phone_number']) ?></small>
                                </div>
                             
                            </div>
                            <div class="col-md-3">
                                <h6 class="primary fw-medium mb-1">Date of order</h6>
                                <p class="mb-0">@if(!empty($orderLists)) <?php echo $corefunctions->timezoneChange($orderLists['test_date'],"m/d/Y") ?> @else --  @endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"> 
                        <div class="text-center border-top border-bottom py-3">
                            <h5 class="primary fw-bold mb-0">Lab Test Form</h5>
                        </div>
                    </div>
                    <div class="col-12"> 

                        <div class="row">
                            @if(!empty($finalTestArray))
                            @foreach ($finalTestArray as $labTestId => $items) 
                            <div class="col-12"> 
                                <div id="main_{{$labTestId}}" class="categorycls_{{$labTestId}}">
                                    <div class="catgry-main mb-2" id="catogory_{{$labTestId}}">
                                        <h6 class="mb-0 primary fw-bold">{{$categoryDetails[$labTestId]['name']}}  </h6>
                                    </div>
                                    @foreach ($items['subcategories'] as $item) 
                                    <div id="sub_{{$item['subcategory_id']}}" class="catgry-sub mb-2 sub_{{$item['subcategory_id']}} subcategorycls_{{$labTestId}}">
                                        <div class="row g-3">
                                            <div class="col-11">
                                                @if(isset($item['subcategory_id']) && $item['subcategory_id'] !='')
                                                <p class="primary fw-medium mb-0">{{$categoryDetails[$item['subcategory_id']]['name']}}</p>
                                                @endif
                                                @if(isset($item['description']) && $item['description'] !='')
                                                <p class="text-muted fst-italic mb-0">{!! nl2br(e($item['description'])) !!}</p>
                                                @endif
                                            </div>
                                            <div class="col-1"> 
                                                <div class="btn_alignbox justify-content-end">
                                                    <a onclick="deleteOrderTest('sub','{{$item['subcategory_id']}}','{{$labTestId}}')" class="dlt-btn btn-align">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                            @endif

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
            </div>
        </div>
