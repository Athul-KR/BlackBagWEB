@extends('frontend.master')
@section('title', 'Medical History')
@section('content')

<section class="details_wrapper">



    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="web-card h-100 mb-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="text-start">
                                <h4 class="fwt-bold mb-4">Medical History</h4>
                            </div>
                            <div class="nav flex-column nav-pills settings-tab history-tab gap-2 me-xl-3 border-bottom-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active show" id="tab-bp" onclick="getmedicalhistoryData('bp')" data-bs-toggle="pill" data-bs-target="#content-bp" type="button" role="tab" aria-controls="content-blood-pressure" aria-selected="true">
                                    <span class="material-symbols-outlined">blood_pressure</span>Blood Pressure
                                </button>
                                <button class="nav-link" id="tab-glucose" data-bs-toggle="pill" onclick="getmedicalhistoryData('glucose')" data-bs-target="#content-glucose" type="button" role="tab" aria-controls="content-glucose-levels" aria-selected="false">
                                    <span class="material-symbols-outlined">glucose</span>Glucose Levels
                                </button>
                                <button class="nav-link" id="tab-cholesterol" data-bs-toggle="pill" onclick="getmedicalhistoryData('cholesterol')"  data-bs-target="#content-cholesterol" type="button" role="tab" aria-controls="content-cholesterol-levels" aria-selected="false">
                                    <span class="material-symbols-outlined">cardiology</span>Cholesterol Levels
                                </button>
                                <button class="nav-link" id="tab-measurements" data-bs-toggle="pill" onclick="getmedicalhistoryData('measurements')" data-bs-target="#content-measurements" type="button" role="tab" aria-controls="content-physical-measurements" aria-selected="false">
                                    <span class="material-symbols-outlined">body_fat</span>Physical Measurements 
                                </button>
                                <button class="nav-link" id="tab-oxygen-saturations" data-bs-toggle="pill" onclick="getmedicalhistoryData('oxygen-saturations')" data-bs-target="#content-oxygen-saturations" type="button" role="tab" aria-controls="content-oxygen-saturations" aria-selected="false">
                                    <span class="material-symbols-outlined">monitor_heart</span>Oxygen Saturations 
                                </button>
                                <button class="nav-link" id="tab-temparature" data-bs-toggle="pill" onclick="getmedicalhistoryData('temparature')" data-bs-target="#content-temparature" type="button" role="tab" aria-controls="content-temparature" aria-selected="false">
                                <span class="material-symbols-outlined">thermometer</span>Body Temperature
                                </button>
                                <button class="nav-link" id="tab-patient-medications" data-bs-toggle="pill" onclick="getmedicalhistoryData('patient-medications')" data-bs-target="#content-patient-medications" type="button" role="tab" aria-controls="content-medications" aria-selected="false">
                                    <span class="material-symbols-outlined">pill</span>Medications
                                </button>
                                <button class="nav-link" id="tab-medical-conditions" data-bs-toggle="pill" onclick="getmedicalhistoryData('medical-conditions')" data-bs-target="#content-medical-conditions" type="button" role="tab" aria-controls="content-medical-conditions" aria-selected="false">
                                    <span class="material-symbols-outlined">respiratory_rate</span>Medical Conditions
                                </button>
                                <button class="nav-link" id="tab-allergies" data-bs-toggle="pill" onclick="getmedicalhistoryData('allergies')" data-bs-target="#content-allergies" type="button" role="tab" aria-controls="content-allergies" aria-selected="false">
                                    <span class="material-symbols-outlined">allergy</span>Allergies
                                </button>
                                <button class="nav-link" id="tab-immunizations" data-bs-toggle="pill" onclick="getmedicalhistoryData('immunizations')" data-bs-target="#content-immunizations" type="button" role="tab" aria-controls="content-immunizations" aria-selected="false">
                                    <span class="material-symbols-outlined">syringe</span>Immunizations
                                </button>
                                <button class="nav-link" id="tab-family-history" data-bs-toggle="pill" onclick="getmedicalhistoryData('family-history')" data-bs-target="#content-family-history" type="button" role="tab" aria-controls="content-family-history" aria-selected="false">
                                    <span class="material-symbols-outlined">family_home</span>Family Medical History
                                </button>

                                <button class="nav-link" id="tab-labs" data-bs-toggle="pill" onclick="getAppointmentMedicalHistory('labs')" data-bs-target="#content-labs" type="button" role="tab" aria-controls="content-labs" aria-selected="false">
                                <span class="material-symbols-outlined">experiment</span>Labs
                                </button>
                                <button class="nav-link" id="tab-imaging" data-bs-toggle="pill" onclick="getAppointmentMedicalHistory('imaging')" data-bs-target="#content-imaging" type="button" role="tab" aria-controls="content-imaging" aria-selected="false">
                                    <span class="material-symbols-outlined">lab_profile</span>Imaging
                                </button>
                               

                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="content-bp" role="tabpanel" aria-labelledby="tab-blood-pressure">
                                   
                                </div>
                                <div class="tab-pane fade" id="content-glucose" role="tabpanel" aria-labelledby="tab-glucose-levels">
                                   
                                </div>

                                <div class="tab-pane fade" id="content-cholesterol" role="tabpanel" aria-labelledby="tab-cholesterol-levels">
                                   
                                </div>
                                <div class="tab-pane fade" id="content-measurements" role="tabpanel" aria-labelledby="tab-measurements">
                                   
                                </div>
                                <div class="tab-pane fade" id="content-oxygen-saturations" role="tabpanel" aria-labelledby="tab-oxygen-saturations">

                                </div>
                                <div class="tab-pane fade" id="content-temparature" role="tabpanel" aria-labelledby="tab-temparature">
                                    
                                    </div>
                                <div class="tab-pane fade" id="content-patient-medications" role="tabpanel" aria-labelledby="tab-medications">
                                 
                                </div>
                                <div class="tab-pane fade" id="content-medical-conditions" role="tabpanel" aria-labelledby="tab-medical-conditions">
                                    
                                </div>
                                <div class="tab-pane fade" id="content-allergies" role="tabpanel" aria-labelledby="tab-allergies">
                                    
                                </div>
                                <div class="tab-pane fade" id="content-immunizations" role="tabpanel" aria-labelledby="tab-immunizations">
                                    
                                </div>
                                <div class="tab-pane fade" id="content-family-history" role="tabpanel" aria-labelledby="tab-family-history">
                                    
                                </div>

                                <div class="tab-pane fade" id="content-labs" role="tabpanel" aria-labelledby="tab-labs">
                                    
                                </div>

                                <div class="tab-pane fade" id="content-imaging" role="tabpanel" aria-labelledby="tab-imaging">
                                    
                                </div>
                            

                                <input type="hidden" id="selectedStartDate" value="">
                                <input type="hidden" id="selectedEndDate" value="">
                                <input type="hidden" id="selectedLabel" value="recent">
                                <input type="hidden" name="key" id="key" >

                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>

</section>

<div class="modal login-modal fade" id="confirm-data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-center fw-medium mb-0 ">Are You Sure you want to change this data?</h4>
                <div class="btn_alignbox"> 
                    <a class="btn btn-outline-primary">Cancel</a>
                    <a class="btn btn-outline-primary">Change Data</a>
                </div>
            </div>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
label.error {
    color: var(--danger);
    font-size: 0.75rem !important;
    bottom: -22px !important;
    top: auto;
    left: 0;
    font-weight: 500;
}
</style>

<script>

function showPrintView(orderKey=''){
        // var key = $('#key').val();
        var labkey = $('#labkey').val();
        const data = JSON.parse($('#labtestdata').val() || '[]');
   
        if(orderKey == '' && (($('#labtestdata').val() == '') || ( data.length === 0))){
            swal("Warning!", "Please add atlest one order before save", "warning");
            return ;
        }
        $("#labtests").modal('hide');
        $("#printview").modal('show');
        if(orderKey != ''){
            $("#orderbckbtn").hide();
        }else{
            $("#orderbckbtn").show();
        }
        showPreloader('appenddatapreview');
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{url('/labs/getorderlist')}}",
            data: {
                "userID": '',
                'formdata' : $('#all_entries').val() ,
                'orderKey'  : orderKey ,
               
                'labkey': labkey,
            },
            success: function(response) {
                if (response.success == 1) {
                    // Replace the dropdown items with the new HTML
                    $('#appenddatapreview').html(response.view);
                    $('#key').val(response.key);
                    $('#labkey').val(response.key);
                    // getAppointmentMedicalHistory('labs');
                }else{
                    $("#printview").modal('hide');

                    swal("Error!", response.message, "error");
                }
            },
            error: function(xhr) {
            
                handleError(xhr);
            },
        })
    }


function getAppointmentMedicalHistory(type,page=1) {
        var patientId = '';
      
        showPreloader("content-"+type);
       
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/medicalhistory") }}',
            data: {
                "type": type,
                // "view" :viewType,
                "page":page,
                'patientId': patientId,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    $("#content-"+type).html(response.view); 
                   
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }


    $(document).ready(function () {
      
        getmedicalhistoryData('bp');
        var selectedStartDate = "{{ $startDate ?? '' }}";
        var selectedEndDate = "{{ $endDate ?? '' }}";
        var selectedLabel = "{{ $label ?? '' }}";

    });
    function initDateRangePicker(type) {
        
        var $input = $('#daterange');
        var start = moment().subtract(2, 'days');
        var end = moment();
        var defaultLabel = ($('#daterange').val() == '') ? 'Recent' : $('#daterange').val();
       
        $input.val(defaultLabel);

        $input.daterangepicker({
            parentEl: '.filter-box',
            startDate: start,
            endDate: end,
            maxDate: moment().endOf('day'),
            autoUpdateInput: false,
            opens: 'right',
            locale: {
                format: 'MM/DD/YYYY',
                cancelLabel: 'Clear'
            },
            ranges: {
                'Recent': [moment().subtract(2, 'days'), moment()],
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [
                    moment().subtract(1, 'month').startOf('month'),
                    moment().subtract(1, 'month').endOf('month')
                ]
            }
        }, function(start, end, label) {
            $('#selectedStartDate').val(start.format('YYYY-MM-DD'));
            $('#selectedEndDate').val(end.format('YYYY-MM-DD'));
            $('#selectedLabel').val(label);

            if (label === 'Recent') {
                $input.val('Recent');
            } else {
                $input.val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
            }
            let formType = $('#formType').val();
            if( formType == 'height' || formType == 'weight' ){
                getmedicalhistoryDatapm(formType);
                // getmedicalhistoryData('measurements');
            }else{
                getmedicalhistoryData(type);
            }


          
        });

        $input.on('show.daterangepicker', function (ev, picker) {
            setTimeout(() => {
                const currentLabel = $('#selectedLabel').val() || defaultLabel;

                $('.ranges li').removeClass('active');
                $('.ranges li').each(function () {
                    if ($(this).attr('data-range-key') === currentLabel) {
                        $(this).addClass('active');
                    }
                });

                // 👇 Force trigger callback if clicking the same label again (like "Recent")
                $('.ranges li').off('click.forceTrigger').on('click.forceTrigger', function () {
                    const clickedLabel = $(this).attr('data-range-key');
                    if (clickedLabel === 'Recent') {
                        picker.setStartDate(moment().subtract(2, 'days'));
                        picker.setEndDate(moment());
                        $('#selectedStartDate').val(picker.startDate.format('YYYY-MM-DD'));
                        $('#selectedEndDate').val(picker.endDate.format('YYYY-MM-DD'));
                        $('#selectedLabel').val('Recent');
                        $input.val('Recent');
                        // getmedicalhistoryData(type);
                        let formType = $('#formType').val();
                        if( formType == 'height' || formType == 'weight' ){
                            getmedicalhistoryDatapm(formType);
                            // getmedicalhistoryData('measurements');
                        }else{
                            getmedicalhistoryData(type);
                        }
                    }
                });

            }, 0);
        });

    }


    function getmedicalhistoryData(type,page=1) {
        showPreloader("content-"+type);
        
        let start = $('#selectedStartDate').val();
        let end = $('#selectedEndDate').val();
        let label = $('#selectedLabel').val();

        $.ajax({
            type: "POST",
            url: '{{ url("/medicalhistory/edit") }}',
            data: {
                "type": type,
                "startDate" : start ,
                "endDate"   : end ,
                "label"     : label ,
                "page"      : page ,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    $('.nav-link').removeClass('show');
                    $('.nav-link').removeClass('active');
                    $('.tab-pane').removeClass('show');
                    $('.tab-pane').removeClass('active');
                    $('.tab-pane').html('');
                    $("#tab-"+type).addClass('show');
                    $("#tab-"+type).addClass('active');
                    $("#content-"+type).addClass('show');
                    $("#content-"+type).addClass('active');
                    $("#content-"+type).html(response.view);

                    $('#selectedStartDate').val(response.startDate);
                    $('#selectedEndDate').val(response.endDate);
                    $('#selectedLabel').val(response.label);
                    if(type !='measurements'){
                       
                        loadChart(response.labels, response.values);
                        dateRandeLabel(response.startDate,response.endDate,response.label);
                         initDateRangePicker(type);
                    }
                  
                    // Attach click event to pagination links
                    $("#pagination-medical a").on("click", function(e) {
                        e.preventDefault();
                        const newPage = $(this).attr("href").split("page=")[1];
                        getmedicalhistoryData(type,newPage);
                    });
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        })
    }
    
    function dateRandeLabel(startDates,endDates,label) {
            // Update the daterange input value based on the returned start and end dates
            var startDate = moment(startDates).format('MM/DD/YYYY');
            var endDate = moment(endDates).format('MM/DD/YYYY');
            
            if (label == 'Recent' || label == 'recent') {
                $('#daterange').val('Recent'); // Keep 'Recent' if that's the label
            } else {
                $('#daterange').val(startDate + ' - ' + endDate); // Update with selected date range
            }

    }

    function editMHSection(key,type) {
        $.ajax({
            url: '{{ url("/medicalhistory/editform")}}',
            type: "post",
            data: {
            'formtype' : type,
                'key': key,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    // bpcls_
                    $('#'+type+'_'+key).remove();
                    $('.'+type+'cls_'+key).html(data.view);
                    
                } else {
                
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        });
    }
    function deleteMHSection(key,type) { 
        if(type == 'patient-medications'){
            var msg = 'Are you sure you want to delete the medication?';
        }else{
            var msg = 'Are you sure you want to delete the medical history?'; 
        }
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                text: "OK",
                value: true,
                closeModal: false // Keeps the modal open until AJAX is done
                }
            },
            dangerMode: true
        }).then((willConfirm) => {
            if (willConfirm) {

        $.ajax({
            url: '{{ url("/medicalhistory/deleteform")}}',
            type: "post",
            data: {
                'formtype' : type,
                'key': key,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    swal.close();
                    $('#'+type+'_'+key).remove();
                    console.log('test'+type)
                    if(type == 'weight' || type == 'height' ){
                        
                        getmedicalhistoryDatapm(type);
                    }else{
                        
                        getmedicalhistoryData(type);
                    }
                } else {
                
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        });
    }
});
}
    function remove(type,cnt){
        $('#'+type+'_'+cnt).remove();
        if($('#'+type+'_'+cnt).length == 0){
            $('.no-records').show();
        }
    }

    function validateUserForm(id,cnt){
      
        var hasValue = $('#'+id+'_' + cnt + ' input')
        .not('.bptime, .bpdate, .coucetype, .fasting') // Exclude specific fields
        .filter(function () {
            return this.value.trim() !== ""; // Check if any value exists
        }).length > 0;
     
        if (!hasValue) {
          
          console.log('1')
            // If no value exists, display error message
            var errorLabel = $('<label class="error">Please enter at least one value to save the record.</label>');

            // Remove any existing error messages
            $('#'+id+'_' + cnt).find('.text-danger').remove();

            if ($('#'+id+'_' + cnt).find('.error').length === 0) {
                // Append the error message
                $('#'+id+'_' + cnt+' .inner-history').append(errorLabel);
            }

            return false; // Stop further execution
        }else{
            
            console.log('2')
            $('#'+id+'_' + cnt).find('.text-danger').remove();
            return true;
        }
    }

    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
        const isFocused = $input.is(':focus');

        // Ensure .float-label is correctly selected relative to the input
        $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
    }
    $(document).ready(function () {


    // Initialize all inputs on page load
    $('input, textarea').each(function () {
        toggleLabel(this);
    });

    // Handle input events
    $(document).on('focus blur input change', 'input, textarea', function () {
        toggleLabel(this);
    });

    // Handle dynamic updates (e.g., Datepicker)
    $(document).on('dp.change', function (e) {
        const input = $(e.target).find('input, textarea');
        if (input.length > 0) {
            toggleLabel(input[0]);
        }
    });
});
function showImaginfPrintView(orderKey=''){
    var key = $('#key').val();
    console.log(orderKey);
    if(orderKey == '' && ($('#imgtestdata').val() == '')){
        swal("Warning!", "Please add atlest one order before save", "warning");
        return ;
    }
    $("#printimgview").modal('show');
    showPreloader('appenddataimgpreview');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: "post",
        url: "{{url('/imaging/getorderlist')}}",
        data: {
            "userID": '',
            'formdata' : $('#imgtestdata').val() ,
            'orderKey'  : orderKey ,
            'labkey'   : key ,
        
        },
        success: function(response) {
            if (response.success == 1) {
            // Replace the dropdown items with the new HTML
                $('#appenddataimgpreview').html(response.view);
                $('#key').val(response.key);
                $('#labkey').val(response.key);
                // getAppointmentMedicalHistory('imaging')
            }else{
                $("#printimgview").modal('hide');
                swal("Error!", response.message, "error");
            }
        },
        error: function(xhr) {
        
            handleError(xhr);
        },
    })
}

function downloadOrder(){
    var key = $('#key').val();
    window.open("{{ url('labs/print') }}/" + key+'?is_download=1', '_blank');
}
function printOrder(){
        var key = $('#key').val();
        window.open("{{ url('labs/print') }}/" + key, '_blank');
    }
</script>
<!-- print preview -->

<div class="modal login-modal fade" id="printview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-medium m-0">Order Preview</h4>
                    <div class="btn_alignbox">
                        
                        <a  class="cls-btn" data-bs-dismiss="modal" aria-label="Close">
                            <span class="material-symbols-outlined">close</span>
                        </a>
                    </div>
                </div>
                <div class="preview-container" id="appenddatapreview">

                </div>
                <div class="btn_alignbox justify-content-end mt-3">
                    <a href="javascript:void(0);" onclick="downloadOrder();" class="btn btn-outline-primary btn-align"><span class="material-symbols-outlined">download</span>Download</a>
                    <a href="javascript:void(0);" onclick="printOrder();" class="btn btn-primary btn-align"><span class="material-symbols-outlined">print</span>Print Order</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal fade" id="printimgview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
            <div class="modal-body"  id="appenddataimgpreview">
              
            </div>
        </div>
    </div>
</div>

@endsection()