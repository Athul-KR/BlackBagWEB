


<?php
$corefunctions = new \App\customclasses\Corefunctions;
?>

    <form method="POST" id="imagingform" autocomplete="off">
    @csrf

    <input type="hidden" name="formDatas" id="imgtestdata" @if(isset($formdata)) value="{{$formdata}}" @endif>
        <div class="card">
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-12"> 
                        <div class="row align-items-start">
                            <div class="col-md-5">
                                <div class="user_inner">
                                    <img src="{{$patientDetails['logo_path']}}" alt="Patient">
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
                                    <small>@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif <?php echo $corefunctions->formatPhone($userDetails['phone_number']) ?></small>
                                </div>

                            </div>
                            <div class="col-md-3">
                                <h6 class="primary fw-medium mb-1">Date of Order </h6>
                                <p class="mb-0">@if(!empty($imagingList)) <?php echo $corefunctions->timezoneChange($imagingList['test_date'],"m/d/Y") ?> @else --  @endif</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"> 
                        <div class="text-center border-top border-bottom py-3">
                            <h5 class="primary fw-bold mb-0">Radiology Order Form</h5>
                        </div>
                    </div>
                    <div class="col-12"> 

                        <div class="row">
                       
                        @if(!empty($finalTestArray))
                        @foreach ($finalTestArray as $labTestId => $items) 
                         
                            <div class="col-12"> 
                                <div id="main_{{$labTestId}}" class="categorycls_{{$labTestId}}">
                                    <div class="catgry-main mb-2" id="catogory_{{$labTestId}}">
                                        <h6 class="mb-0 primary fw-bold">{{$categoryDetails[$labTestId]['name']}} @if(isset($items['is_contrast']))
                                           
                                        @endif
                                        </h6>
                                    </div>
                                    @if(isset($items['subcategories']))
                                    @foreach ($items['subcategories'] as $item) 
                                    <?php
                      
                                    $selectedOption =  implode(', ', $item['options']); // Output: Bilateral, External
                                    ?>
                                    <div id="sub_{{$item['subcategory_id']}}" class="catgry-sub mb-2 sub_{{$item['subcategory_id']}} subcategorycls_{{$labTestId}}">
                                        <div class="row align-items-center">
                                            <div class="col-7">
                                                <p class="primary fw-medium mb-0">@if(isset($categoryDetails[$item['subcategory_id']])){{$categoryDetails[$item['subcategory_id']]['name']}} @endif @if(!empty($selectedOption)) ({{$selectedOption}})  @endif @if($item['is_contrast'] !='')({{ $item['is_contrast'] ? 'With Contrast' : 'Without Contrast' }}) @endif </p>
                                                @if(isset($item['description']) && $item['description'] !='')
                                                <p class="text-muted fst-italic mb-0">{!! nl2br(e($item['description'])) !!} </p>
                                                @endif
                                            </div>

                                            <div class="col-5"> 
                                                <div class="d-flex justify-space-between">  
                                                    @if(isset($categoryDetails[$item['subcategory_id']]) && isset($imagingcptCodes[$item['subcategory_id']]))
                                                    <div class="text-end w-100">
                                                        <p class="fw-medium primary mb-0"><span class="gray fw-light">CPT: </span>@if(isset($cptCodes[$imagingcptCodes[$item['subcategory_id']]['cpt_code_id']])) {{$cptCodes[$imagingcptCodes[$item['subcategory_id']]['cpt_code_id']]['cpt_code']}} @endif</p>
                                                    </div>
                                                    @endif
                                                    <div class="btn_alignbox justify-content-end w-100">
                                                        <a onclick="deleteOrderImaging('sub','{{$item['subcategory_id']}}','{{$labTestId}}')" class="dlt-btn btn-align">
                                                            <span class="material-symbols-outlined">delete</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
