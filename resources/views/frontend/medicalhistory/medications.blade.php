                <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Medications</h5>
                                        <div class="btn_alignbox"> 
                                            <a onclick="addMedication()" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Are you currently taking any medications?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="yesCheckbox" value="yes">
                                                                    <label class="form-check-label" for="yesCheckbox">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="noCheckbox" value="no">
                                                                    <label class="form-check-label" for="noCheckbox">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take medication for blood pressure?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="yes">
                                                                    <label class="form-check-label" for="">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="no">
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take medication for diabetes medications?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take medication for cholesterol medications?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            
                                        </div>
                                    </div>


<script>

  var ctCnt = 1;
    function addmedication(){
        var type = 'bp';
        var bphtml = 
        '<div class="col-12" id="bloodpressure_'+ctCnt+'"> <div class="inner-history"> <div class="row align-items-center"> <div class="col-md-10"> <div class="row"> '+
        '<div class="col-md-3"><div class="history-box"> <div class="form-group form-outline"><label class="float-label">Systolic (mmHg)</label><input type="text" class="form-control" id="systolic_'+ctCnt+'" name="blood_pressure[systolic]"  placeholder=""></div></div></div>'+
        '<div class="col-md-3"> <div class="history-box"> <div class="form-group form-outline"><label class="float-label">Diastolic (mmHg)</label><input type="text" class="form-control" id="diastolic_'+ctCnt+'" name="blood_pressure[diastolic]" placeholder=""></div></div></div>'+
        '<div class="col-md-3"> <div class="history-box"> <div class="form-group form-outline"><label class="float-label">Pulse (bpm)</label><input type="text" class="form-control" id="pulse_'+ctCnt+'"  name="blood_pressure[pulse]" placeholder=""></div></div></div>'+
        '<div class="col-md-3"> <div class="history-box"> <div class="form-group form-outline"><input type="text" class="form-control bpdate"  id="reportdate'+ctCnt+'" name="blood_pressure[bpdate]" placeholder="Report Date"></div></div></div>'+
        '<div class="col-md-3"> <div class="history-box"> <div class="form-group form-outline"><input type="text" class="form-control bptime"  id="bptime'+ctCnt+'" name="blood_pressure[bptime]" placeholder="Report Time"></div></div></div>'+
        '<input type="hidden" class="form-control coucetype"  id="coucetype'+ctCnt+'" name="blood_pressure[sourcetype]" value="2"></div></div><div class="col-md-2"> <div class="btn_alignbox justify-content-end">'+
        '<a class="opt-btn" onclick="submitIntakeForm(\''+type+'\')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>'+
        '</div></div></div></div></div>' ;

        var idcn = ctCnt - 1 ;
        $('#bloodpressure_'+idcn).after(bphtml);
        ctCnt++;
    }

    function submitIntakeForm(formtype) {
    
        if ($("#intakeform").valid()) {
            let formdata = $("#intakeform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                'formtype' : formtype,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                    getmedicalhistoryData(formtype);
                    } else {
                    
                    }
                },
                error: function(xhr) {
               
                    handleError(xhr);
                },
            });
        } else {
            if ($('.error:visible').length > 0) {
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: ($('.error:visible').first().offset().top - 100)
                    }, 500);
                }, 500);
            }
        }
    }



   

</script>