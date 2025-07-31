<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fw-medium">Medical Conditions</h5>
    <div class="btn_alignbox">
        <a href="javascript:void(0);" onclick="addRelation();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
    </div>
</div>
<div class="history-wrapperBody">
    <div class="row">
        <div class="col-12 relation-append">
        </div>
        <div class="col-12">
            @if(!empty($medicathistoryDetails))
            @foreach($medicathistoryDetails as $hsk => $hsv)
            <?php $sourceType = isset($hsv['source_type_id']) && $hsv['source_type_id'] == 1 ? 'Intake Form' : (isset($hsv['source_type_id']) && $hsv['source_type_id'] == 2 ? 'Patient' : 'Clinic');  ?>
            <div class="inner-history medical-conditionscls_{{$hsv['patient_condition_uuid']}}">
                <div class="row">
                    <div class="col-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Condition(s)</h6>
                                    <p>@if(isset($hsv['condition_id']) && $hsv['condition_id'] != 0) {{$conditionDetails[$hsv['condition_id']]['condition']}} @else -- @endif</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="history-box">
                                    <h6>Source Type</h6>
                                    <p>{{$sourceType}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                    @if($hsv['created_by'] == Session::get('user.userID'))
                    <div class="col-3">
                        <div class="btn_alignbox justify-content-end">
                            <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined">more_vert</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a onclick="editMHSection('{{$hsv['patient_condition_uuid']}}','medical-conditions')" class="dropdown-item fw-medium" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                <li><a onclick="deleteMHSection('{{$hsv['patient_condition_uuid']}}','medical-conditions')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    <div class="col-12">
                        <div class="history-info flex-wrap">
                            <h6 class="mb-0">
                                {{$userDetails[$hsv['created_by']]['first_name']}}{{$userDetails[$hsv['created_by']]['last_name']}}
                                @if(isset($clinicUser[$hsv['created_by']]['designation']['name'])), {{$clinicUser[$hsv['created_by']]['designation']['name']}}@else{{''}}@endif

                            </h6>
                            <div class="d-flex align-items-center flex-wrap">
                                <span class="update-info mx-1"></span>
                                <small>Last updated:</small><small class="ms-1"> @if(isset($hsv['updated_at']) && $hsv['updated_at'] != '')
                                    <?php echo $corefunctions->timezoneChange($hsv['updated_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv['updated_at'], "h:i A") ?>
                                    @else <?php echo $corefunctions->timezoneChange($hsv['created_at'], "M d, Y") ?> | <?php echo $corefunctions->timezoneChange($hsv['created_at'], "h:i A") ?> @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
            <div class="flex justify-center no-records" @if(!empty($medicathistoryDetails)) style="display:none;" @else style="display:block;" @endif>
                <div class="text-center  no-records-body">
                    <img src="{{asset('images/nodata.png')}}"
                        class=" h-auto" alt="no records">
                    <p>No records found</p>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        getConditions();
        hasFormValue();
    });
 
    function hasFormValue() {
        var hasVal = '';

        $("#hasvalue").val('');

        // Check if any input field (including autocomplete) has a value
        $(".valcls").each(function() {
            if ($(this).val().trim() !== '') {
                hasVal = 1;
            }
        });

        $("#hasvalue").val(hasVal);

        // Trigger validation
        $("#hasvalue").valid();

        // Hide error message dynamically if a value is entered
        if (hasVal) {
            $("#condition_id-error").hide();
        }
       
    }

    function getConditions() {
        $(".condition").autocomplete({
            autoFocus: true,
            source: function(request, response) {
                $.getJSON("{{ url('intakeform/condition/search') }}", {
                        term: request.term
                    },
                    response);
            },
            minLength: 2,
            data: {
                // term : request.term,
            },
            select: function(event, ui) {
                var conditionInput = $(this);

                if (ui.item.key != '0') {
                    conditionInput.siblings("input[name=condition_id]").val(ui.item.key);
                    var count = 1;
                    var countVal = '';
                } else {
                    conditionInput.val('');
                    conditionInput.siblings("input[name=condition]").val('');
                    event.preventDefault();
                }
            
            },
            focus: function(event, ui) {
                selectFirst: true;
                event.preventDefault();
            },
            open: function(event, ui) {
                $(this).autocomplete("widget")
                    .appendTo("#results").css({
                        'position': 'static',
                        'width': '100%'
                    });
                $('.ui-autocomplete').css('z-index', '9999');
                $('.ui-autocomplete').addClass('srchuser-dropdown');
            }
        }).data("ui-autocomplete")._renderItem = function(ul, item) {
            return $("<li><span class='srchuser-downname'>" + item.label + "</span></li>").data("ui-autocomplete-item", item.key).appendTo(ul);
        };
        $(document).on("input", ".valcls", function () {
            console.log('error')
            hasFormValue();
            $(this).valid(); // This ensures validation updates dynamically
        });

    }

    function addRelation() {
        const relationHtml = `
            <div class="inner-history relation-item"> 
            <form method="POST" id="historyform" autocomplete="off">
            @csrf
                <div class="row align-items-start"> 
                    <div class="col-md-10"> 
                        <div class="row">
                            <div class="col-md-12"> 
                                <div class="history-box"> 
                                    <div class="form-group form-outline conditioncls">
                                        <label class="float-label">Condition(s)</label>
                                        <input type="text" class="form-control condition" name="condition" placeholder="">
                                        <input class="patient-ctn valcls" type="hidden" name="condition_id">
                                        <input type="hidden" name="relation" value="19">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                            <input type="hidden" name="hasvalue" id="hasvalue" />
                        </div>
                    </div>
                    <div class="col-md-2"> 
                        <div class="btn_alignbox justify-content-end">
                            <button type="button" class="opt-btn" id="submitcndtnbtn" href="javascript:void(0);" onclick="submitHistoryForm('medical-conditions');" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">check</span>
                            </button>
                            <a class="opt-btn danger-icon" href="javascript:void(0);" onclick="removeFamilyHistory(this);" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="material-symbols-outlined success">close</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            </div>
        `;

        // Append the new vaccine select to the vaccine-append container
        $('.relation-append').html(relationHtml);
        getConditions();
        $('.no-records').hide();
    }

    function removeFamilyHistory(element) {
        $(element).closest('.relation-item').remove();
        if ($('.relation-item').length == 0) {
            $('.no-records').show();
        }
    }

    function validateHistoryForms() {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        $("#historyform").validate({
            ignore: [],
            rules: {
                condition_id: {
                    required: true,
                    remote: {
                        url: "{{ url('/intakeform/checkconditionexists') }}",
                        data: {
                            'patientID': patientID,
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                        async: false,
                    },
                },
            },
            messages: {
                condition_id: {
                    required: "Please select condition",
                    remote: "Condition already added",
                },
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') == 'condition_id') {
                    error.insertAfter('.conditioncls');
                } else {
                    error.insertAfter(element);
                }
            },
        });
    }

    function validateEditHistoryForms() {
        $("#edithistoryform").validate({
            ignore: [],
            rules: {
                hasmedihisvalue: "required",
                // condition_id: {
                //     remote: {
                //         url: "{{url('/intakeform/checkconditionexists')}}";,
                //         data: {
                //             _token: $("input[name=_token]").val(),
                //         },
                //         type: "post",
                //     },
                // }
            },
            messages: {
                hasmedihisvalue: "Please enter any one of the record",
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
        });
    }

    function submitHistoryForm(formtype) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        validateHistoryForms();
        hasFormValue();
        if ($("#historyform").valid()) {
            $("#submitcndtnbtn").prop('disabled', true);
            let formdata = $("#historyform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/medicalcondition/store")}}',
                type: "post",
                data: {
                    'patientID': patientID,
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
                }
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

    function hasEditFormValue() {
        var hasVal = '';
        
        $(".valcls").each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#hasmedihisvalue").val(hasVal);
    }



    function updateHistoryForm(formtype, key) {
       
        validateEditHistoryForms();
        hasEditFormValue();
    
        if ($("#edithistoryform").valid()) {
            let formdata = $("#edithistoryform").serialize();
            $.ajax({
                url: '{{ url("/intakeform/medicationhistory/update")}}',
                type: "post",
                data: {
                    'key': key,
                    'formdata': formdata,
                    'formtype' : formtype,
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

    $(document).ready(function () {
    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== '';
        const isFocused = $input.is(':focus');

        // Correct selector for all cases (only applies to visible inputs)
        $input.closest('.form-group').find('.float-label').toggleClass('active', hasValue || isFocused);
    }
    
    // Initialize only visible inputs on page load
    $('input:visible, textarea:visible').each(function () {
        toggleLabel(this);
    });

    // Handle input events (only on visible inputs)
    $(document).on('focus blur input change', 'input:visible, textarea:visible', function () {
        toggleLabel(this);
    });

    // Handle dynamic updates (e.g., Datepicker) — only trigger for visible inputs
    $(document).on('dp.change', function (e) {
        const input = $(e.target).find('input:visible, textarea:visible');
        if (input.length > 0) {
            toggleLabel(input[0]);
        }
    });
});


</script>