@if(!empty($medicathistoryDetails))
    <div class="">  
        <form method="POST" id="edithistoryform" autocomplete="off">
        @csrf
            <div class="row align-items-start"> 
                <div class="col-md-10"> 
                    <div class="row"> 
                        <div class="col-md-6"> 
                            <div class="history-box"> 
                                <div class="form-group form-floating relationerr">
                                    <select class="form-select relationcls valcls" name="relation" placeholder="">
                                        <option value="">Select Relation</option>
                                        @if(!empty($relations))
                                            @foreach($relations as $rl)
                                                <option value="{{$rl['id']}}" @if(isset($medicathistoryDetails['relation_id']) && $medicathistoryDetails['relation_id'] != '0' && $rl['id'] == $medicathistoryDetails['relation_id']) selected @endif>{{$rl['relation']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <label class="select-label">Relation</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="history-box"> 
                                <div class="form-group form-outline conditionerr">
                                    <label class="float-label">Condition(s)</label>
                                    <input type="text" class="form-control condition" name="condition"  placeholder="">
                                    <input class="conditioncls" type="hidden" name="hascondition" id="hascondition" value="1">
                                </div>
                                <div class="multi-wrapper" id="multiselect">
                                    <div class='selected-conditions-container'>
                                        @if(!empty($medicathistoryDetails['conditions']))
                                        @foreach($medicathistoryDetails['conditions'] as $condition)
                                            <div class="selected-condition mt-2" data-id="{{$condition['id']}}">
                                                <p>{{$condition['name']}}</p>
                                                <button type="button" class="remove-condition"><span class="material-symbols-outlined">close</span></button>
                                            </div>
                                            <input type="hidden" name="condition_id[]" value="{{$condition['id']}}">
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                        <input type="hidden" name="hasmedihisvalue" id="hasmedihisvalue" />
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="btn_alignbox justify-content-end">
                        <button type="button" id="updatefhbtn" class="opt-btn" onclick="updateFamilyHistoryForm('family-history','{{$medicathistoryDetails['patient_condition_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></button><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('family-history')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
<script>
    $(document).ready(function () {
        getConditions();
        hasFormValue();
    });
    function updateFamilyHistoryForm(formtype, key) {
        validateFamilyConditionForms();
        if ($("#edithistoryform").valid()) {
            let formdata = $("#edithistoryform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/medicationhistory/update")}}',
                type: "post",
                data: {
                    'key': key,
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

    function validateFamilyConditionForms() {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        var realtionID =  "@if(!empty($medicathistoryDetails)) {{$medicathistoryDetails['relation_id']}} @else null @endif";
        $("#edithistoryform").validate({
            ignore: [],
            rules: {
                relation: {
                    required:true,
                    remote: {
                        url: "{{ url('/intakeform/checkrelationexists') }}",
                        data: {
                            'patientID': patientID,
                            'realtionID' : realtionID ,
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                        async: false,
                    },
                },
                hascondition: "required"
            },
            messages: {
                relation: {
                    required: "Please select relation",
                    remote: "Relation already added",
                },
                hascondition: "Please select atleast one condition"
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("relationcls")) {
                    error.insertAfter(".relationerr");
                } else if (element.hasClass("conditioncls")) {
                    error.insertAfter(".conditionerr");
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }



    

</script>

