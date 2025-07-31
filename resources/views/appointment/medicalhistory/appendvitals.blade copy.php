    <div class="col-12 mb-3" id="datefilter" style="display:block;"> 
        <div class="btn_alignbox justify-content-end position-relative"> 
            <div class="filter-box" >
                <input type="text" name="daterange" id="daterange" class="form-control daterange" style="width: 300px;" />
            </div>
        </div>
    </div>
    <div class="outer-wrapper box-cnt-inner">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            @foreach($medicalHistory as $index => $history)
                @php
                    $collapseId = "flush-collapse-".$index;
                    $headingId = "flush-heading-".$index;
                @endphp
                <div class="accordion-item">
                    <h2 class="accordion-header" id="{{$headingId}}">
                        <button class="accordion-button collapsed accrclp_{{$history['type']}}" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#{{$collapseId}}" 
                            aria-expanded="false" aria-controls="{{$collapseId}}" 
                            onclick="medicalHistoryGraph('{{$history['type']}}','chart','{{$index}}')">
                            <div class="row align-items-center collapse-header w-100">
                                <div @if($viewType == 'video' ) class="col-4" @elseif($history['type'] == 'blood_pressure') class="col-8 col-lg-2 order-0 order-lg-0" @else class="col-8 col-lg-2 order-0 order-lg-0"  @endif >
                                    <h5 class="fw-medium">{{$history['title']}}</h5>
                                </div>
                                @if($history['value1'] != null && $history['type'] == 'blood_pressure')
                                    <div  @if($viewType == 'video' ) class="col-lg-8 video accrclpopen_{{$history['type']}}" @else class="col-12 col-lg-10 accrclpopen_{{$history['type']}} order-2 order-lg-1" @endif>
                                        <div @if($viewType == 'video' ) class="row text-end pe-3" @else class="row text-end pe-lg-3 mt-lg-0 mt-3" @endif>
                                            <div class="col-4">
                                                <small>{{$history['date']}}</small>
                                                <p class="l-primary mt-1 mb-0">{{$history['value']}} {{$history['unit']}} (sys)</p>
                                            </div>
                                            <div class="col-4">
                                                <small class="mb-1">{{$history['date']}}</small>
                                                <p class="l-danger fw-medium mt-1 mb-0">{{$history['value1']}} {{$history['unit']}} (dia)</p>    
                                        
                                            </div>

                                            <div class="col-4">
                                                <small class="mb-1">{{$history['date']}}</small>
                                                <p class="l-danger fw-medium mt-1 mb-0">@if($history['value2'] !=''){{$history['value2']}} BPM @else -- @endif</p>    
                                            </div>

                                        </div>
                                    </div>
                                @elseif($history['value1'] != null && $history['type'] == 'cholesterol')
                                    <div  @if($viewType == 'video' ) class="col-lg-8 video accrclpopen_{{$history['type']}}" @else class="col-12 col-lg-10 accrclpopen_{{$history['type']}} order-2 order-lg-1" @endif>
                                        <div @if($viewType == 'video' ) class="row text-end pe-3" @else class="row text-end pe-lg-3 mt-lg-0 mt-3" @endif>
                                            <div class="col-4">
                                                <small>{{$history['date']}}</small>
                                                <p class="l-primary mt-1 mb-0">@if($history['value'] !='') {{$history['value']}} mg/dL (total) @else -- @endif</p>
                                            </div>
                                            <div class="col-4">
                                                <small class="mb-1">{{$history['date']}}</small>
                                                <p class="l-danger fw-medium mt-1 mb-0">@if($history['value'] !='') {{$history['value1']}} mg/dL (hdl) @else -- @endif</p>    
                                        
                                            </div>

                                            <div class="col-4">
                                                <small class="mb-1">{{$history['date']}}</small>
                                                <p class="l-danger fw-medium mt-1 mb-0">@if($history['value2'] !=''){{$history['value2']}} mg/dL (ldl) @else -- @endif</p>    
                                            </div>

                                        </div>
                                    </div>
                                @else
                                    <div  @if($viewType == 'video' ) class="col-lg-8 video accrclpopen_{{$history['type']}}" @else class="col-12 col-lg-10 accrclpopen_{{$history['type']}} order-2 order-lg-1" @endif>
                                        <div  @if($viewType == 'video' ) class="row justify-content-end text-end pe-3" @else class="row text-end pe-lg-3 mt-lg-0 mt-3"@endif>
                                            <div @if($viewType == 'video' ) class="col-6" @else class="col-12" @endif>
                                                <small>{{$history['date']}}</small>
                                                <p class="l-primary mt-1 mb-0">@if($history['value'] != '') {{$history['value']}} {{$history['unit']}} @else -- @endif </p>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                                <div class="@if($viewType == 'video' ) col-3 @elseif($history['type'] == 'blood_pressure') col-4 col-lg-2 @else col-4 col-lg-2 @endif addcls_{{$history['type']}} order-1 order-lg-2" style="display:none"> 
                                    @if($history['type'] != 'bmi')
                                        <div class="btn_alignbox justify-content-end colps-btn w-100 me-lg-1">
                                            <a onclick="addmedications('{{$history['type']}}')" class="btn btn-primary btn-sm btn-align" data-bs-toggle="modal" >
                                                <span class="material-symbols-outlined">add</span>Add Data
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div> 
                            <span class="material-symbols-outlined arrow-btn"> keyboard_arrow_down</span>
                        </button>
                    </h2>
                    <div id="{{$collapseId}}" class="accordion-collapse collapse" 
                        aria-labelledby="{{$headingId}}" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            <div @if($viewType == 'video' ) class="row" @else class="row mb-3" @endif >
                                <div class="col-6">
                                    <ul class="nav nav-pills gap-2 d-flex flex-nowrap mb-lg-0" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="active opt-action medicaldetailscls medical-chart" id="pills-summary-tab-{{$index}}" onclick="medicalHistoryGraph('{{$history['type']}}','chart')"
                                                
                                                aria-controls="pills-summary-{{$index}}" aria-selected="true">
                                                <span class="material-symbols-outlined">bar_chart</span>
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="opt-action medicaldetailscls medical-list" id="pills-transcription-tab-{{$index}}" onclick="medicalHistoryGraph('{{$history['type']}}','list')"
                                                data-bs-toggle="pill"  type="button" role="tab" 
                                                aria-controls="pills-transcription-{{$index}}" aria-selected="false">
                                                <span class="material-symbols-outlined">table</span>
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            
                            
                            </div>
                            <div class="tab-content" id="{{$history['type']}}-chart"></div>
                        </div>
                    </div>
                </div>
            @endforeach
            <input type="hidden" id="selectedStartDate" value="">
            <input type="hidden" id="selectedEndDate" value="">
            <input type="hidden" id="selectedLabel" value="recent">


        </div>
    </div>


<script>
    $(function () {
        initDateRangePicker();
        });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
