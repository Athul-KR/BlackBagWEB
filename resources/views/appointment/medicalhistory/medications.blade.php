<div class="outer-wrapper box-wrapper">
    <div class="accordion accordion-flush" id="accordionFlushExample">
        <div class="col-12">
            <div class="btn_alignbox justify-content-end">
                <a onclick="addmedications('medications')" class="btn btn-primary btn-sm btn-align" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#adddata">
                    <span class="material-symbols-outlined">add</span>Add Data
                </a>
            </div>
        </div>
        @if(!empty($medicathistoryDetails))
        @foreach($medicathistoryDetails as $hsk => $hsv)
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed d-flex justify-content-between" type="button">
                    <div class="row align-items-center collapse-header w-100">
                        <div class="col-12 col-lg-9"  data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$hsv['id']}}" aria-expanded="false" aria-controls="flush-collapse{{$hsv['id']}}">
                            <h5 class="fw-medium">@if(isset($hsv['medicine_name']) && $hsv['medicine_name'] != '') {{$hsv['medicine_name']}} @elseif(isset($hsv['medicine_id']) && $hsv['medicine_id'] != '' && $hsv['medicine_id'] != '0') {{$medicineDetails[$hsv['medicine_id']]['medicine']}} @else -- @endif</h5>
                        </div> 
                        @if(isset($hsv['created_by']) && $hsv['created_by'] == Session::get('user.userID') && $hsv['source_type_id'] != '5' )
                        <div class="col-12 col-lg-3">
                            <div class="btn_alignbox justify-content-end pe-3 mt-lg-0 mt-3" id="nocollapse">
                                <!-- <span class="badge bg-warning">Order Pending</span> -->
                                
                                <a class="btn btn-opt opt-action" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a href="javascript:void(0);" onclick="editVitalSection('{{$hsv['medication_uuid']}}','medications','medications')" class="dropdown-item">
                                            <i class="fa-solid fa-pen me-2"></i><span>Edit</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0);" onclick="deleteVitalSection('{{$hsv['medication_uuid']}}','medications')" class="dropdown-item">
                                            <i class="fa-solid fa-trash-can me-2"></i><span>Delete</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div> 
                    <div class="d-flex align-items-center"> 
                        
                        <span class="material-symbols-outlined arrow-btn"  data-bs-toggle="collapse" onclick="toggleCollapse({{$hsv['id']}})" aria-expanded="false" aria-controls="flush-collapse{{$hsv['id']}}"> keyboard_arrow_down</span>
                    </div>
                </button>
            </h2>
            <div id="flush-collapse{{$hsv['id']}}" class="accordion-collapse collapse tabcontent" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample"> 
                <div class="accordion-body">
                    <div class="row align-row">
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="collaspe-info">
                                <small class="fw-light">Quantity</small>
                                <p class="fw-medium">@if(isset($hsv['quantity']) && $hsv['quantity'] != '' && $hsv['quantity'] != '0') {{$hsv['quantity']}} @else -- @endif</p>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="collaspe-info">
                                <small class="fw-light">Dosage</small>                                                              
                                <p class="fw-medium">@if(isset($hsv['strength']) && $hsv['strength'] != '' && $hsv['strength'] != '0') {{$hsv['strength']}} {{$strengthUnits[$hsv['strength_unit_id']]['strength_unit']}} @else -- @endif</p>                                                              
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="collaspe-info">
                                <small class="fw-light">Diagnosis</small>                                                          
                                <p class="fw-medium">@if(isset($hsv['conditions']) && $hsv['conditions'] != '') {{$hsv['conditions']}} @else -- @endif</p>  
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="collaspe-info">
                                <small class="fw-light">When to Take</small>                                                          
                                <p class="fw-medium">@if(isset($hsv['frequency']) && $hsv['frequency'] != '') <?php echo nl2br($hsv['frequency']) ?> @else -- @endif</p>  
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="collaspe-info">
                                <small class="fw-light">Date Started</small>                                 
                                <p class="fw-medium">@if(isset($hsv['start_date']) && $hsv['start_date'] != NULL) {{$hsv['start_date']}} @else -- @endif</p>  
                                                                
                            </div>
                        </div>
                        <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="collaspe-info">
                                <small class="fw-light">Prescribed By</small>                                 
                                <p class="fw-medium">@if(isset($hsv['prescribed_by']) && $hsv['prescribed_by'] != '') {{$hsv['prescribed_by']}} @else -- @endif</p>  
                                <small class="fw-light"><?php echo $corefunctions->timezoneChange($hsv['created_at'],"m/d/Y h:i A") ?></small>             
                            </div>
                        </div>
                        <div class="col-12 col-md-4 col-xl-3">
                            <div class="collaspe-info">
                                <small class="fw-light">Dispense Unit</small>                                                              
                                <p class="fw-medium">@if(isset($hsv['dispense_unit_id']) && $hsv['dispense_unit_id'] != '' && $hsv['dispense_unit_id'] != '0') {{$dispenseUnits[$hsv['dispense_unit_id']]['form']}} @else -- @endif</p>                                                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
<div class="col-12 mt-3">
    <div class="row justify-content-end">
        @if(!empty($medicathistoryArray))
        <div class="col-md-6">
            <div class="sort-sec">
                <p class="me-2 mb-0">Displaying per page :</p>
                <select name="perPage" id="perPage" class="form-select d-inline-block" aria-label="Default select example" onchange="perPage()">
                    <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                    <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                    <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                </select>
            </div>
        </div>
        @endif
        <div class="col-md-6">
            <div id="pagination-links">
                {{ $medicathistoryArray->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        //Pagination through ajax - pass the url
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            const pageUrl = $(this).attr('href');
            const urlObj = new URL(pageUrl); // Create a URL object
            var page = urlObj.searchParams.get('page');
            getAppointmentMedicalHistory('medications',page)
        });
    });
    function toggleCollapse(id) {
        const selected = $('#flush-collapse' + id);
        if (selected.hasClass('show')) {
            selected.removeClass('show');
        } else {
            $('.accordion-collapse').removeClass('show');
            selected.addClass('show');
        }
    }
</script>