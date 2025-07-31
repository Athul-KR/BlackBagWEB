@if(!empty($medicathistoryDetails))
    <div class="">  
        <form method="POST" id="editmedicationform" autocomplete="off">
        @csrf
            <div class="row align-items-start"> 
                <div class="col-md-10"> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="history-box"> 
                                <div class="form-group form-floating drugclsedit">
                                    <select class="form-select valcls" id="edit_type_{{$medicathistoryDetails['medication_uuid']}}" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][type]" onchange="toggleDrugEdit(this,'{{$medicathistoryDetails['medication_uuid']}}');">
                                        <option value="">Select Drug Name</option>
                                        <option value="list">Select from the list</option>
                                        <option value="medicine">Add your own medicine</option>
                                    </select>
                                    <label class="select-label">Drug Name</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="drugnamediv_{{$medicathistoryDetails['medication_uuid']}}"> 
                            <div class="history-box"> 
                                <div class="form-group form-outline drugnclserroredit">
                                    <label class="float-label active">Drug Name</label>
                                    <input type="text" class="form-control drugnclsedit" id="edit_medicine_name_{{$medicathistoryDetails['medication_uuid']}}" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][medicine_name]" @if(isset($medicathistoryDetails['medicine_name']) && $medicathistoryDetails['medicine_name'] != '') value="{{$medicathistoryDetails['medicine_name']}}" @else value="{{$medicine}}" @endif>
                                    <input type="hidden" id="edit_medicine_id_{{$medicathistoryDetails['medication_uuid']}}" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][medicine_id]" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="history-box"> 
                                <div class="form-group form-outline">
                                    <label class="float-label active">Prescribed By</label>
                                    <input type="text" class="form-control" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][prescribed_by]" placeholder="" data-medicationcount="{{$medicathistoryDetails['medication_uuid']}}" @if(isset($medicathistoryDetails['prescribed_by']) && $medicathistoryDetails['prescribed_by'] != '') value="{{$medicathistoryDetails['prescribed_by']}}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="history-box"> 
                                <div class="form-group form-outline">
                                    <label class="float-label active">Diagnosis</label>
                                    <input type="text" class="form-control condition" name="condition" placeholder="" data-medicationcount="{{$medicathistoryDetails['medication_uuid']}}" @if(!empty($medicathistoryDetails) && $medicathistoryDetails['conditions'] != '') value="{{$medicathistoryDetails['conditions']}}" @endif>
                                    <input class="patient-ctn" id="condition_id" type="hidden" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][condition_id]" @if(!empty($medicathistoryDetails) && $medicathistoryDetails['condition_id'] != '' && $medicathistoryDetails['condition_id'] != '0') value="{{$medicathistoryDetails['condition_id']}}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="quantitydiv">
                            <div class="history-box"> 
                                <div class="form-group form-outline quantityclserror">
                                    <label class="float-label active">Quantity</label>
                                    <input type="text" class="form-control quantitycls" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][quantity]" placeholder="" data-medicationcount="{{$medicathistoryDetails['medication_uuid']}}" @if(isset($medicathistoryDetails['quantity']) && $medicathistoryDetails['quantity'] != '') value="{{$medicathistoryDetails['quantity']}}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="strengthdiv_{{$medicathistoryDetails['medication_uuid']}}">
                            <div class="history-box"> 
                                <div class="form-group form-outline strengthclserroredit">
                                    <label class="float-label active">Strength</label>
                                    <input type="text" class="form-control strengthclsedit" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][strength]" @if( $medicathistoryDetails['strength'] != 0 ) value="{{$medicathistoryDetails['strength']}}" @endif placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="strengthunitdiv_{{$medicathistoryDetails['medication_uuid']}}"> 
                            <div class="history-box"> 
                                <div class="form-group form-floating strengthunitclserroredit"> 
                                    <select class="form-select strengthunitclsedit" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][strength_unit_id]" placeholder=""> 
                                        <option value="">Select Stength Unit</option>
                                        @foreach($strengthUnits as $suv)
                                            <option value="{{$suv['id']}}" @if($medicathistoryDetails['strength'] != 0 && $suv['id'] == $medicathistoryDetails['strength_unit_id']) selected @endif>{{$suv['strength_unit']}}</option> 
                                        @endforeach
                                    </select> 
                                    <label class="select-label">Stength Unit</label>
                                </div> 
                            </div> 
                        </div> 
                        <div class="col-md-6 mb-3">
                            <div class="history-box"> 
                                <div class="form-group form-outline">
                                    <label class="float-label active">Start Date</label>
                                    <input type="text" class="form-control startdate" id="startdate" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][start_date]" placeholder="" data-medicationcount="{{$medicathistoryDetails['medication_uuid']}}" @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['start_date']) && $medicathistoryDetails['start_date'] != '') value="{{date('m/d/Y',strtotime($medicathistoryDetails['start_date']))}}" @endif>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3" id="dispensediv_{{$medicathistoryDetails['medication_uuid']}}"> 
                            <div class="history-box"> 
                                <div class="form-group form-floating dispenseunitclserroredit"> 
                                    <select class="form-select dispenseunitclsedit" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][dispense_unit_id]" placeholder=""> 
                                        <option value="">Select Dispense Unit</option>
                                        @foreach($dispenseUnits as $suv)
                                            <option value="{{$suv['id']}}" @if($medicathistoryDetails['dispense_unit_id'] != 0 && $suv['id'] == $medicathistoryDetails['dispense_unit_id']) selected @endif>{{$suv['form']}}</option> 
                                        @endforeach
                                    </select> 
                                    <label class="select-label">Dispense Unit</label>
                                </div> 
                            </div> 
                        </div> 
                        <div class="col-md-6 mb-3">
                            <div class="history-box"> 
                                <div class="form-group form-outline">
                                    <label class="float-label active">When to Take?</label>
                                    <textarea type="text" class="form-control" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][frequency]" placeholder="" data-medicationcount="{{$medicathistoryDetails['medication_uuid']}}">@if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['frequency']) && $medicathistoryDetails['frequency'] != '') {{ $medicathistoryDetails['frequency'] }} @endif</textarea>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                        <input type="hidden" name="hasvalue" id="hasvalue" class="drunameclsedit" value="1"/>
                        <input type="hidden" class="form-control coucetype"  id="coucetype" name="medications['{{$medicathistoryDetails['medication_uuid']}}'][key]" value="{{$medicathistoryDetails['medication_uuid']}}">
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="btn_alignbox justify-content-end">
                        <a class="opt-btn" href="javascript:void(0);" onclick="updateMedication('patient-medications','{{$medicathistoryDetails['medication_uuid']}}');" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined success">check</span>
                        </a>
                        <a class="opt-btn danger-icon" href="javascript:void(0);" onclick="getmedicalhistoryData('patient-medications')" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="material-symbols-outlined success">close</span>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
<div class="modal fade" id="editmedicinemodal_{{$medicathistoryDetails['medication_uuid']}}" tabindex="-1" aria-labelledby="editmedicinemodalLabel"aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                <!-- <h4 class="fw-bold mb-0" id="patientNotesLabel"> Notes</h4> -->
                </div>
                <h4 class="fwt-bold mb-3">Select From the List</h4>
                <div class="form-group form-outline">
                    <label class="float-label">Medicine</label>
                    <input type="text" class="form-control medicine valcls" name="medicine" placeholder="">
                    <input class="patient-ctn" type="hidden" name="edit_medication_id" id="edit_medication_id">
                    <input class="patient-ctn" type="hidden" name="edit_medication_name" id="edit_medication_name">
                </div>
                <input type="hidden" name="editcount" id="editcount" />
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="updateMedicine()" id="updateButton" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        getEditMedicines();
        getConditions();
        datetimePicker();
    });
    function datetimePicker() {
        $('#startdate').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'en',
            useCurrent: true,
            maxDate: moment().endOf('day'), // Ensures today is selectable
        });
    }
    function toggleDrugEdit(ths,count){
        if ($(ths).val() == 'list') {
            $("#editmedicinemodal_"+count).modal('show');
            $('#editmedicationform')[0].reset();
            $('#editmedicationform').validate().resetForm();
            $("#editcount").val(count);
            $("#drugnamediv_"+count).hide();
        }else if($(ths).val() == 'medicine'){
            $("#drugnamediv_"+count).show();
            $("#edit_medicine_name_" + count).prop('readonly', false);
            $("#edit_medicine_name_"+count).val('');
            getEditMedicines();
        }
    }
    function getEditConditions(){
        $( ".condition" ).autocomplete({
            autoFocus: true,
            source: function(request, response) {
                $.getJSON('{{ url('intakeform/condition/search') }}', 
                    {  
                        term: request.term 
                    }, 
                    response);
            },
            minLength: 2,
            data: {
                // term : request.term,
            },
            select: function( event, ui ) {
                const medicationCount = $(this).data('medicationcount');
                var conditionInput = $(this);
    
                if (ui.item.key != '0') {
                    conditionInput.siblings(`input[name="medications['${medicationCount}'][condition_id]"]`).val(ui.item.key);
                    var count = 1;
                    var countVal = '';
                } else {
                    conditionInput.val('');
                    conditionInput.siblings("input[name=condition]").val(''); 
                    event.preventDefault();
                }
            },
            focus: function (event, ui) {
                selectFirst: true;
                event.preventDefault();
            },
            open: function( event, ui ) {
                $(this).autocomplete("widget")
                    .appendTo("#results").css({'position' : 'static','width' : '100%'});
                $('.ui-autocomplete').css('z-index','9999');
                $('.ui-autocomplete').addClass('srchuser-dropdown');
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li><span class='srchuser-downname'>"+item.label+"</span></li>" ).data( "ui-autocomplete-item", item.key ) .appendTo( ul );
        };
    }
    function getEditMedicines(){
        $( ".medicine" ).autocomplete({
            autoFocus: true,
            source: function(request, response) {
                $.getJSON('{{ url('intakeform/medicine/search') }}', 
                    {  
                        term: request.term 
                    }, 
                    response);
            },
            minLength: 2,
            data: {
                // term : request.term,
            },
            select: function( event, ui ) {
                var medicineInput = $(this);
    
                if (ui.item.key != '0') {
                    medicineInput.siblings("input[name=edit_medication_id]").val(ui.item.key);
                    medicineInput.siblings("input[name=edit_medication_name]").val(ui.item.label);
                    var count = 1;
                    var countVal = '';
                } else {
                    medicineInput.val('');
                    medicineInput.siblings("input[name=medicine]").val(''); 
                    event.preventDefault();
                }
            },
            focus: function (event, ui) {
                selectFirst: true;
                event.preventDefault();
            },
            open: function( event, ui ) {
                $(this).autocomplete("widget")
                    .appendTo("#results").css({'position' : 'static','width' : '100%'});
                $('.ui-autocomplete').css('z-index','9999');
                $('.ui-autocomplete').addClass('srchuser-dropdown');
            }
        }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {
            return $( "<li><span class='srchuser-downname'>"+item.label+"</span></li>" ).data( "ui-autocomplete-item", item.key ) .appendTo( ul );
        };
    }
    function updateMedicine(){
        var count = $("#editcount").val();
        var selectedMedicine = $("#edit_medication_name").val();
        var selectedValue = $("#edit_medication_id").val();
        if (selectedMedicine.trim() !== "What is this prescribed for?") {
            $("#drugnamediv_"+count).show();
            $("#edit_medicine_name_" + count).val(selectedMedicine);
            $("#edit_medicine_name_" + count).prop('readonly', true);
            $("#edit_medicine_id_" + count).val(selectedValue);
            $("#edit_type_" + count).val('list');
            $("#editmedicinemodal_"+count).modal('hide');
            $('input, textarea').each(function () {
                toggleLabel(this);
            });

        }
    }
</script>
