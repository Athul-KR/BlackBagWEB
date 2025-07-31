
<!-- notes  -->
<div class="modal login-modal fade" id="notes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
            <div class="modal-body" id="addnotesmodal">
                
            </div>
        </div>
    </div>
</div>

<!--  lab tests -->
<div class="modal login-modal fade" id="labtests" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
            <div class="modal-body" id="addtabsmodal">
               
            </div>
        </div>
    </div>
</div>

<!-- print preview -->

<div class="modal login-modal fade" id="printview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-medium m-0">Order Preview</h4>
                    <div class="btn_alignbox">
                 
                        <a href="javascript:void(0);" class="btn btn-outline-primary btn-align" id="orderbckbtn" onclick="editOrder();">
                            <span class="material-symbols-outlined align-middle">arrow_back</span> Back
                        </a> 
                     
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

<div class="modal fade" id="medicinemodal" tabindex="-1" aria-labelledby="pmedicinemodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <!-- <h4 class="fw-bold mb-0" id="patientNotesLabel"> Notes</h4> -->
                </div>
                <h4 class="fwt-bold mb-3">Select From the List</h4>
                <div class="form-group form-outline form-outer">
                    <label class="float-label">Medicine</label>
                    <input type="text" class="form-control medicine" name="medicine" id="medicine" placeholder="">
                    <input class="patient-ctn" type="hidden" name="medication_id" id="medication_id">
                    <input class="patient-ctn valcls" type="hidden" name="medication_name" id="medication_name">
                </div>
                <input type="hidden" name="count" id="count" />
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" onclick="hideMedicineModal()">Close</button>
                    <button type="button" onclick="saveMedicine()" id="saveButton" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- add data -->
 
<div class="modal login-modal fade" id="adddata" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
            <div class="modal-body" id="appenddata">
              
            </div>
        </div>
    </div>
</div>

<!-- summary -->

<div class="modal login-modal fade" id="summary" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Scanning Report.pdf</h4>
                    <div class="btn_alignbox">
                        <button type="button" class="btn btn-outline-primary">Download</button>
                        <button type="button" class="btn btn-primary">Save Changes</button>
                        <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                    </div>
                    
                </div>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <img src="{{asset('images/scanreport.png')}}" class="report-img" alt="Report Image">

                    </div>
                    <div class="col-12 col-lg-8">
                        <div class="d-flex justify-content-between mb-4">
                            <h5 class="fw-medium">Summary</h5>
                            <div class="btn_alignbox">
                                <a class="scribe"><span class="text-linear fw-bold fst-italic"><img src="{{ asset('/images/linearimg.png')}}" alt="icon" class="me-1">Summarized by BlackBag AI</span></a>
                            </div>
                        </div>
                        <p>John Doe, a 55-year-old male, underwent a Complete Blood Count (CBC) test. The report indicates a low hemoglobin level (12.5 g/dL, reference: 13.0–17.0 g/dL) and a high packed cell volume (57.5%, reference: 40–50%), suggesting possible anemia. The RBC count is within range at 5.2 mill/cumm, while other parameters such as MCV (87.75 fL), MCH (27.2 pg), and RDW (13.6%) fall within or close to reference values.
                            The total WBC count is 9000 cumm, which is normal (reference: 4000–11000 cumm), with differential counts showing neutrophils at 60%, lymphocytes at 31%, and other white cell types within normal limits. Platelet count is 320,000 cumm, which is also within the normal range (150,000–410,000 cumm). Further confirmation for anemia is recommended.</p>
                        <div class="d-flex justify-content-between mb-1">
                            <h5 class="fw-medium">Lab Report</h5>
                        </div>
                        <div class="table-responsive table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Test</th>
                                        <th>Normal Range</th>
                                        <th>Patient Readings</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td data-title="Test">White Blood Cells (WBC)</td>
                                        <td data-title="Normal Range">4.8 - 10.8</td>
                                        <td data-title="Patient Readings">6.9</td>
                                        <td data-title="Notes"><input type="text" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Test">Red Blood Cells (RBC)</td>
                                        <td data-title="Normal Range">4.7 - 6.1</td>
                                        <td data-title="Patient Readings">6.5</td>
                                        <td data-title="Notes"><input type="text" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Test">Haemoglobin (HB/Hgb)</td>
                                        <td data-title="Normal Range">14 - 18</td>
                                        <td data-title="Patient Readings">16</td>
                                        <td data-title="Notes"><input type="text" class="form-control"></td>
                                    </tr>
                                    <tr>
                                        <td data-title="Test">Platelet Count</td>
                                        <td data-title="Normal Range">150 - 450</td>
                                        <td data-title="Patient Readings">220</td>
                                        <td data-title="Notes"><input type="text" class="form-control"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>

<!-- order services -->

<div class="modal login-modal fade" id="orderservices" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content outer-wrapper">
            <div class="modal-body">
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Order Services</h4>
                    <a  class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <div class="row service-row align-row mb-4">
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="checkbox-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox1">
                                <label class="form-check-label" for="checkbox1">
                                    <img src="{{asset('/images/service1.png')}}" alt="Checkbox Image" class="image-checkbox">
                                    <p>Transportation</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="checkbox-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox1">
                                <label class="form-check-label" for="checkbox1">
                                    <img src="{{asset('/images/service2.png')}}" alt="Checkbox Image" class="image-checkbox">
                                    <p>Personal Care</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="checkbox-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox1">
                                <label class="form-check-label" for="checkbox1">
                                    <img src="{{asset('/images/service3.png')}}" alt="Checkbox Image" class="image-checkbox">
                                    <p>Care Planning</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="checkbox-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox1">
                                <label class="form-check-label" for="checkbox1">
                                    <img src="{{asset('/images/service4.png')}}" alt="Checkbox Image" class="image-checkbox">
                                    <p>Home Safety</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="checkbox-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox1">
                                <label class="form-check-label" for="checkbox1">
                                    <img src="{{asset('/images/service5.png')}}" alt="Checkbox Image" class="image-checkbox">
                                    <p>Errands & Chores</p>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="checkbox-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox1">
                                <label class="form-check-label" for="checkbox1">
                                    <img src="{{asset('/images/service6.png')}}" alt="Checkbox Image" class="image-checkbox">
                                    <p>Other Services</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group form-floating mb-4">
                    <i class="material-symbols-outlined">category</i>
                    <select name="gender" id="gender" class="form-select">
                        <!-- <option value="">Select Gender</option> -->
                            <option value="1">Sub Category</option>
                    </select>
                </div>
                <div class="form-group form-outline form-textarea mb-4">
                    <label for="input" class="float-label">Notes</label>
                    <i class="fa-solid fa-file-lines"></i>
                    <textarea class="form-control" name="note" rows="4" cols="4"></textarea>
                </div>

                <div class="btn_alignbox">
                    <button type="button" class="btn btn-primary w-100"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Send Referral</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- order devices -->

<div class="modal login-modal fade" id="orderdevices" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content outer-wrapper">
            <form method="POST" name="add_deviceorderform" id="add_deviceorderform" autocomplete="off">
             @csrf
            <div class="modal-body" id="appendorderdevices">
               
            </div>
          </form>
        </div>
    </div>
</div>



<!-- loader -->

<div class="modal login-modal fade" id="loader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img alt="Blackbag" src="images/loader.gif" class="img-fluid">
            </div>
        </div>
     </div>
</div>

<!-- success service -->

<div class="modal login-modal fade" id="SuccessLoader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img alt="Blackbag" src="images/success-img.png" class="img-fluid">
                <h4 class="fw-bold mb-1 mt-3">Service referred! </h4>
                <p class="px-5 mb-0">The Service team wil contact the patient soon.</p>
            </div>
        </div>
    </div>
</div>

<!-- order placed -->

<div class="modal login-modal fade" id="orderdevicesuccessloader" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img alt="Blackbag" src="{{asset('images/invite-img.png')}}" class="img-fluid">
                <h4 class="fw-bold mb-1 mt-3">Order Sent to patient!</h4>
                <p class="px-5 mb-0">The order will be placed once the patient accepts the charges.</p>
            </div>
        </div>
    </div>
</div>

<!-- order devices -->


  <div class="modal prescription-modal fade" id="prescriptionmodal" tabindex="-1" aria-labelledby="onboardingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
          </div>
          <h5 class="mb-3">Prescription</h5>
          <iframe src="" width="100%" height="100%" frameborder="0"></iframe>
          <div class="btn_alignbox justify-content-end mt-4">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

<style>
.daterangepicker td, .daterangepicker th {
    text-align: center;
    width: 20px;
    height: 20px;
    border-radius: 4px;
    border: 1px solid transparent;
    white-space: nowrap;
    cursor: pointer; } 
</style>



<script>
    $(document).ready(function() {
        <?php if(isset($type) && $type == 'appointment') { ?>
            $('#pills-vitals-tab').trigger('click');
        <?php } else { ?>
            $('#appointmentspatients').trigger('click');
        <?php } ?>
        $('#startDate').datepicker({
            maxDate:new Date()
        });
    });  
    
    $('#prescriptionmodal').on('hidden.bs.modal', function () {
        $('#pills-medications-tab').trigger('click');

    });
    function medicalHistoryGraph(type,viewtype='',index=0,page=1,pagelimit=10) {
       
        var pageviewType = '{{$viewType}}';
        pagelimit = $("#perPage").val();
        if ($('.accrclp_'+type).hasClass('collapsed')) {
            if(pageviewType == 'video'){
                $('.accrclpopen_'+type).removeClass('col-xl-6').addClass('col-xl-8');
            }else{
                $('.accrclpopen_'+type).removeClass('col-12 col-lg-8').addClass('col-12 col-lg-10');
            }
           
            $('.addcls_'+type).hide();
          return ;
        }else{
           
            if(pageviewType == 'video'){
                $('.accrclpopen_'+type).removeClass('col-xl-8').addClass('col-xl-6');
            }else{
                // if(type == 'blood_pressure'){
                //     $('.accrclpopen_'+type).removeClass('col-12 col-lg-10').addClass('col-12 col-lg-8');
                    
                // }
                    $('.accrclpopen_'+type).removeClass('col-12 col-lg-10').addClass('col-12 col-lg-8');
                
               
            }
            $('.addcls_'+type).show();
        }
        showPreloader(type+'-chart');
        let start = $('#selectedStartDate').val();
        let end = $('#selectedEndDate').val();
        let label = $('#selectedLabel').val();
        $('.medicaldetailscls').removeClass('active');
        $('.medical-'+viewtype).addClass('active');
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/medicalhistorygraph") }}',
            data: {
                "type"      : type,
                "viewtype"  : viewtype,
                "startDate" : start ,
                "endDate"   : end ,
                "label"     : label ,
                "page"      : page ,
                "pagelimit" : pagelimit ,
                "userID"    : '{{$patientId}}',
                '_token'    : $('meta[name="csrf-token"]').attr('content')

            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    // $('#isViewMore').attr('onclick', "medicalHistoryGraph('" + type + "','" + viewtype + "',''," + response.lastVitalID + ", 1)");                    $("#appendlistloadmore_"+type).append(response.view);

                    // if(response.lastVitalID == 0 ){
                       
                    //     $("#isViewMore").hide();
                    // }
                    // if( isloadmore == 1){

                    //     $("#appendlistloadmore_"+type).append(response.view);
                    //     $("#lastVitalID").append(response.lastVitalID);
                        
                    // }else{
                        $("#"+type+"-chart").html(response.view);
                        
                        //  Ensure chart is only loaded when tab is visible
                        $('#pills-summary-tab').on('shown.bs.tab', function () {
                            loadChart(response.labels, response.values);
                        });

                        // If the summary tab is active, load the chart immediately
                        if ($('#pills-summary').hasClass('show active')) {
                            loadChart(response.labels, response.values);
                        }
                        $('#pills-summary-tab-' + index).on('shown.bs.tab', function () {
                            loadChart(response.labels, response.values);
                        });
                        $("#pagination-vitals").html(response.pagination); // Update pagination links
                        // Attach click event to pagination links
                        $("#pagination-vitals a").on("click", function(e) {
                            e.preventDefault();
                            const newPage = $(this).attr("href").split("page=")[1];
                            medicalHistoryGraph(type, viewtype,'', newPage);
                        });

                    // }
                }
                
            },
            error: function(xhr) {
                
                handleError(xhr);
            },
        })
    }
    function initDateRangePicker() {
  
        var $input = $('#daterange');
        var start = moment().subtract(2, 'days');
        var end = moment();
        $input.val('Recent');
        $input.daterangepicker({
            parentEl: '.filter-box',
            startDate: start,
            endDate: end,
            maxDate: moment().endOf('day'),
            autoUpdateInput: false,
            opens: 'left',
            

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
            },
            
         

        }, (start, end, label) => {
            $('#selectedStartDate').val(start.format('YYYY-MM-DD'));
            $('#selectedEndDate').val(end.format('YYYY-MM-DD'));
       
            $('#selectedLabel').val(label);
        
            if (label === 'Recent') {
                $input.val('Recent');
            } else {
                $input.val(start.format('MM/DD/YYYY') + ' - ' + end.format('MM/DD/YYYY'));
            }
            let viewtype = 'chart';
            let formType = $('#formType').val();
            if (formType) {
                medicalHistoryGraph(formType, viewtype);
            }
          
        });
       
      
    }
    
 
    function getAppointmentMedicalHistory(type,page=1) {
        var patientId = '{{$patientId}}';
        var key = '{{$key}}';
        var viewType = '{{$viewType}}';
        showPreloader("pills-"+type);
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/medicalhistory") }}',
            data: {
                "type": type,
                "key" : key,
                "view" :viewType,
                "page":page,
                'patientId': patientId,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    $("#pills-"+type).html(response.view); 
                    if(type=="vitals"){
                        initDateRangePicker();
                    }
                    if(type == 'notes'){
                        $("#pagination-note a").on("click", function(e) {
                            e.preventDefault();
                            const newPage = $(this).attr("href").split("page=")[1];
                            getAppointmentMedicalHistory(type,newPage);
                        });
                    }
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }
    
    function addNotes(){
        $('#notes').modal('show');
        
        var viewType = '{{$viewType}}';
        var key = '{{$key}}';
        showPreloader('addnotesmodal');

        $.ajax({
            url: '{{ url("/appointment/addnotes")}}',
            type: "post",
            data: {
                "userID": '{{$patientId}}',
                "view" :viewType,
                "key": key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#addnotesmodal").html(data.view);
                    $('input, textarea').each(function () {
                    toggleLabel(this);
                    });
                } else {
                
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }

    function saveNotes(){
        if($("#addnoteform").valid()){
           
            $("#addbtn").addClass('disabled');

            $.ajax({
                url: '{{ url("/notes/savenotes") }}',
                type: "post",
                data: {
                'formData' :  $("#addnoteform").serialize(),
                "userID": '{{$patientId}}',
                '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == 1) {

                        $("#addbtn").removeClass('disabled');
                        swal("Success!",'Note added successfully', "success");
                        $('#notes').modal('hide');
                        getAppointmentMedicalHistory('notes')
                    } else {
                        swal("error!", data.errormsg, "error");
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }
    }

    function updateNotes(key){
        if($("#addnoteform").valid()){
            $("#addbtn").addClass('disabled');

            $.ajax({
                url: '{{ url("/notes/updatenotes") }}',
                type: "post",
                data: {
                'formData' :  $("#addnoteform").serialize(),
                "userID": '{{$patientId}}',
                "medicalnotekey"  : key ,
                '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#addbtn").removeClass('disabled');
                        swal("Success!", data.message, "success");
                        $('#notes').modal('hide');
                        getAppointmentMedicalHistory('notes')

                    } else {
                        swal("error!", data.errormsg, "error");
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }
    }



    function getPatientAppointments(type,status,patientKey, page = 1,) {
        $('.tabcls').removeClass('active');
        $('.tabcls').removeClass('show');
        $('.tabclass').removeClass('active');
        const limit = $('#pagelimit').val(); // Get the selected limit value
        if(type == 'appointments'){
            $('.appointments').addClass('active');
            $('#appointmentspatients').addClass('active');
            $('#appointmentspatients').addClass('show');
        }else if(type == 'filecabinet'){
            $('.filecabinet').addClass('active');
            showPreloader("filecabinetpatients");
            $('#filecabinetpatients').addClass('active');
            $('#filecabinetpatients').addClass('show');
        }else{
            $('.medical').addClass('active');
            $('.appointments').removeClass('active');
            $('.filecabinet').removeClass('active');
        }
        showPreloader('appointments');
        $.ajax({
            type: "POST",
            url: '{{ url("/patients/appointmentlist") }}',
            data: {
                "type": type,
                'status': status,
                'limit' : limit,
                'page': page,
                'patientKey' : patientKey,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    if(type == 'appointments'){
                        $("#appointmentspatients").html(response.view);
                    }else if(type == 'filecabinet'){
                        $("#filecabinetpatients").html(response.view);
                    }
                    $("#pagination-links").html(response.pagination); // Update pagination links
                    // Attach click event to pagination links
                    $("#pagination-links a").on("click", function(e) {
                        e.preventDefault();
                        const newPage = $(this).attr("href").split("page=")[1];
                        getPatientAppointments(type, status, patientKey, newPage);
                    });
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        })
    }
    function addLabtests(){
        $('#labtests').modal('show');
        var key = $('#key').val('');
        showPreloader('addtabsmodal');
        $.ajax({
            url: '{{ url("/appointment/addlabs")}}',
            type: "post",
            data: {
                "userID": '{{$patientId}}',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#addtabsmodal").html(data.view);
                    allFormData = [];
                    $('input, textarea').each(function () {
                        toggleLabel(this);
                    });
                } else {
                
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }
    function addImagings(){
        $('#labtests').modal('show');
        
        showPreloader('addtabsmodal');
        var labkey = $('#labkey').val('');
        var key = $('#key').val('');
        $.ajax({
            url: '{{ url("/appointment/addimaging")}}',
            type: "post",
            data: {
                "userID": '{{$patientId}}',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    allImgFormData = [];
                    $("#addtabsmodal").html(data.view);
                    multiselect();
                } else {
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }
    function downloadOrder(){
        var key = $('#key').val();
        window.open("{{ url('labs/print') }}/" + key+'?is_download=1', '_blank');
    }
    function editOrder(){
        var key = $('#key').val();
        var labkey = $('#labkey').val();
        $("#printview").modal('hide');
        $("#labtests").modal('show');
        
        $.ajax({
            url: '{{ url("labs/editorder")}}',
            type: "post",
            data: {
                'userID': '{{$patientId}}',
                'labkey': labkey,
                'formdata' : $('#all_entries').val() ,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#previewlabs").html(data.view);
                } else {
                    swal("Error!", data.message, "error");
                }
            },
            error: function(xhr) {
                handleError(xhr);
            }
        });
    }
    function printOrder(){
        var key = $('#key').val();
        window.open("{{ url('labs/print') }}/" + key, '_blank');
    }
    function addmedications(type) {
        
        $('#adddata').modal('show');
     
        showPreloader('appenddata');
       
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/addmedicalhistory") }}',
            data: {
                "type": type,
                "userID": '{{$patientId}}',
                '_token': $('meta[name="csrf-token"]').attr('content')

            },
            success: function(response) {
               
                // Handle the successful response
                if(response.success == 1){
                   
                    $("#appenddata").html(response.view);
                  
                    $('#startDate').datepicker({
                        maxDate:new Date()
                    });
                    // $('.accrclp_'+type).trigger('click');
                   
                }
            },
            error: function(xhr) {
            
            
            },
        })
    }

    function editVitalSection(key,type,formtype) {
        var patientId = '{{$patientId}}';
        $('#adddata').modal('show');
        showPreloader('appenddata');
        $.ajax({
            url: '{{ url("appointment/medicalhistory/editvitails")}}',
            type: "post",
            data: {
                'type' : type,
                'formtype' : formtype,
                'patientID' : patientId,
                'key': key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $('input').each(function() {
                        toggleLabel(this);
                    });
                    $("#appenddata").html(data.view);
                } else {
                
                }
            },
            error: function(xhr) {
                
                handleError(xhr);
            },
        });
    }

    function deleteVitalSection(key,type,view='') { 
        type = (type == 'blood_pressure') ? 'bp' : type ;
        var msg = (type == 'medications') ? 'Are you sure you want to delete this medication?' : 'Are you sure you want to delete the medical history?'; 
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
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                    
                        if (data.success == 1) {
                            swal.close();
                            if(type == 'medications'){
                                getAppointmentMedicalHistory('medications');
                            }else if(view == 'history'){
                                getHistoryDetails(type,view)
                            }else{
                                getAppointmentMedicalHistory('vitals');
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
    $('#orderdevicesuccessloader').on('hidden.bs.modal', function () {
        getAppointmentMedicalHistory('devices');
    });
    function getHistoryDetails(type,viewtype='',index=0) {
        showPreloader(type+'-history');
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/history") }}',
            data: {
                "type": type,
                "viewtype":viewtype,
                "userID": '{{$patientId}}',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    $("#"+type+"-history").html(response.view);
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }
    function submitIntakeForm(formtype,formname,view) {
        if(formtype == 'bp' || formtype ==  'glucose' || formtype ==  'cholesterol'){
            hasFormValue();
        }
       
        var patientID = '{{$patientId}}';
        if ($("#"+formname).valid()) {
            $("#submitbpbtn").addClass('disabled');
            let formdata = $("#"+formname).serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'patientID': patientID,
                    'formdata': formdata,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        $('#adddata').modal('hide');
                        if(formtype == 'medications'){
                            getAppointmentMedicalHistory('medications');
                        }if(view == 'history'){
                            getHistoryDetails(formtype,view);
                        }else{
                          
                            let viewtype = $('#viewtype').val();
                            getAppointmentMedicalHistory('vitals');
                            $('.accrclp_'+view).removeClass('collapsed');
                            $('.accrclp_'+view).trigger('click');

                            // medicalHistoryGraph(view,viewtype);
                        }
                    } else {
                        $("#submitbpbtn").removeClass('disabled');
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            });
        } else {
            if ($('.error:visible').length > 0) {
                setTimeout(function() {

                }, 500);
            }
        }
    }
    // Declare this ONCE at the top (outside of any function)
    let allFormData = [];
    function submitOrder(type='') {
        if(type== 'all'){
            selectAllItems();
        }
      
        if ($("#ordertestform").valid()) {
            $("#submitbpbtn").addClass('disabled');
            let formdata = $("#ordertestform").serializeArray();
            let entry = {};
            formdata.forEach(field => {
                // Exclude search fields if not needed
                if (!field.name.startsWith("search_")) {
                    entry[field.name] = field.value;
                }
            });
            const newCatId = entry['category_id'];
            const newSubCatIds = (entry['subcategory_id'] || '').split(',');

            // Check for any overlap with existing entries
            const isDuplicate = allFormData.some(item => {
                const sameCategory = item['category_id'] === newCatId;
                const existingSubIds = (item['subcategory_id'] || '').split(',');

                // Check if any subcategory ID overlaps
                const hasOverlap = newSubCatIds.some(id => existingSubIds.includes(id));

                return sameCategory && hasOverlap;
            });

            if (isDuplicate) {
                swal("Warning", "One or more of the selected subcategories in this category are already added.", "warning");
                $("#submitbpbtn").removeClass('disabled');
                $('#subcategory_label').text('Sub Category');
                $('#subcategory_id').val('');
                return;
            }
           



            // Push to the global array
            allFormData.push(entry);
            // Store in the hidden field
            $('#all_entries').val(JSON.stringify(allFormData));
            var patientID = '{{$patientId}}';
            $.ajax({
                url: '{{ url("labs/addorder")}}',
                type: "post",
                data: {
                    'userID': patientID,
                    'formdata' : $('#all_entries').val() ,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        // Clear inputs
                        getSubcategoryList('','');
                        $('#category_id').val('');
                        $('#subcategory_id').val('');
                        $('#description').val('');
                        $('#category_label').text('Category');
                        // $('#subcategory_label').text('Sub Category');

                        // $('#search_li_subcategory').empty().append(`
                        //     <li class="dropdown-item">
                        //         <div class="dropview_body profileList justify-content-center">
                        //             <p>No records found</p>
                        //         </div>
                        //     </li>
                        // `);
                      

                        $("#previewlabs").html(data.view);
                    
                    } else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }
    }

    function deleteOrderTest(type,key,parentID) { 
        var msg = 'Are you sure you want to delete the order?'
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
                swal.close();
                $("#"+type+'_'+key).remove();
                var subcount = $('.subcategorycls_'+parentID).length ;  
                if(subcount < 1){
                    $(".categorycls_"+parentID).remove();
                    allFormData = allFormData.filter(entry => entry.category_id !== parentID);
                }
              

                allFormData = allFormData.map(entry => {
                    if (entry.category_id == parentID) {
                        const subIds = entry.subcategory_id.split(',');
                        const filteredSubIds = subIds.filter(id => id !== key);

                        // If no subcategories left, exclude the whole entry
                        if (filteredSubIds.length === 0) {
                            return null;
                        }
                    
                        // Update entry with remaining subcategories
                        entry.subcategory_id = filteredSubIds.join(',');
                        return entry;
                    }
                    return entry;
                }).filter(entry => entry !== null);

                // Update the hidden input after removing
                $('#all_entries').val(JSON.stringify(allFormData));

                let currentData = JSON.parse($('#labtestdata').val());

                currentData = currentData.filter(entry => {
                    return !(entry.category_id == parentID && entry.subcategory_id == key);
                });

                $('#labtestdata').val(JSON.stringify(currentData));
            }
        });
    }

    // Declare this ONCE at the top (outside of any function)
    let allImgFormData = [];
    function submitImaging() {
        if ($("#ordertestform").valid()) {
            $("#submitbpbtn").addClass('disabled');
            let formdata = $("#ordertestform").serializeArray();
            console.log(formdata);
            let entry = {};
            formdata.forEach(field => {
                if (!field.name.startsWith("search_")) {
                    if (entry[field.name]) {
                        // If already an array, push to it
                        if (Array.isArray(entry[field.name])) {
                            entry[field.name].push(field.value);
                        } else {
                            // Convert to array if it's a single value
                            entry[field.name] = [entry[field.name], field.value];
                        }
                    } else {
                        entry[field.name] = field.value;
                    }
                }
            });
            // Push to the global array
            allImgFormData.push(entry);
            // Store in the hidden field
            $('#all_img_entries').val(JSON.stringify(allImgFormData));
            var patientID = '{{$patientId}}';
            $.ajax({
                url: '{{ url("imaging/addorder")}}',
                type: "post",
                data: {
                    'userID': patientID,
                    'formdata' : $('#all_img_entries').val() ,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        // Clear inputs
                        let dateValue = $('#test-date').val(); // Save current date value
                        $('#ordertestform')[0].reset(); // Reset the form (this also resets the date field)
                        // Restore the date field value
                        $('#test-date').val(dateValue);
                        $('#category_id').val('');
                        $('#subcategory_id').val('');
                        $('#description').val('');
                        $('#category_label').text('Category');
                        $('#subcategory_label').text('Sub Category');

                        $('#search_li_subcategory').empty().append(`
                            <li class="dropdown-item">
                                <div class="dropview_body profileList justify-content-center">
                                    <p>No records found</p>
                                </div>
                            </li>
                        `);
                        $("#submitbpbtn").removeClass('disabled');
                        $("#previewimaging").html(data.view);
                        
                    } else {
                        $("#submitbpbtn").removeClass('disabled');
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                }
            });
        }
    }

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
                "userID": '{{$patientId}}',
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
                    getAppointmentMedicalHistory('imaging')
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
    function showPrintView(orderKey=''){
        var key = $('#key').val();
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
                "userID": '{{$patientId}}',
                'formdata' : $('#all_entries').val() ,
                'orderKey'  : orderKey ,
                'key': key,
                'labkey': labkey,
            },
            success: function(response) {
                if (response.success == 1) {
                    // Replace the dropdown items with the new HTML
                    $('#appenddatapreview').html(response.view);
                    $('#key').val(response.key);
                    $('#labkey').val(response.key);
                    getAppointmentMedicalHistory('labs');
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

    function deleteOrderImaging(type,key,parentID) { 
        var msg = 'Are you sure you want to delete the imaging?'
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
                swal.close();
                $("#"+type+'_'+key).remove();
                var subcount = $('.subcategorycls_'+parentID).length ;  
                
                if(subcount < 1){
                    $(".categorycls_"+parentID).remove();
                    allImgFormData = allImgFormData.filter(entry => entry.category_id !== parentID);
                }

                allImgFormData = allImgFormData.filter(entry => {
                    return !(entry.category_id == parentID && entry.subcategory_id == key);
                });

                // Update the hidden input after removing
                $('#all_img_entries').val(JSON.stringify(allImgFormData));

                let currentData = JSON.parse($('#imgtestdata').val());

                currentData = currentData.filter(entry => {
                    return !(entry.category_id == parentID && entry.subcategory_id == key);
                });

                $('#imgtestdata').val(JSON.stringify(currentData));
            }
        });
    }


    function deleteImaging(key,type='',parentID='') { 
        var msg = 'Are you sure you want to delete the imaging?'
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
                        url: '{{ url("/imaging/delete")}}',
                        type: "post",
                        data: {
                            'type' : type,
                            'key': key,
                            '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success == 1) {
                                swal.close();
                                getAppointmentMedicalHistory('imaging')
                            } 
                        },
                        error: function(xhr) {
                            handleError(xhr);
                        },
                    });
               
       
            }
        });
    }
    function multiselect(){
        VirtualSelect.init({ 
            ele: '#options',
            search: true,
        });
    }
    function deleteTest(type,key,list='') { 
        var msg = 'Are you sure you want to delete the order?'
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
                    url: '{{ url("/labs/deleteitem")}}',
                    type: "post",
                    data: {
                        'type' : type,
                        'key': key,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            swal.close();
                            if(list == '1'){
                                getAppointmentMedicalHistory('labs')
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
    function getLabsDetails(key) {
        showPreloader(key+'-labs');
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/history") }}',
            data: {
                "type": 'lab',
                "labkey": key ,
                "appkey": '{{$key}}',
                "userID": '{{$patientId}}',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    $("#"+key+"-labs").html(response.view);
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }
    function getPreviewList(lab_test_uuid='') {
        var patientID = '{{$patientId}}';
        var appKey = '{{$key}}';
        $.ajax({
            url: '{{ url("labs/orderlist")}}',
            type: "post",
            data: {
                'userID': patientID,
                'appKey' : appKey ,
                'lab_test_uuid' : lab_test_uuid ,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#previewlabs").html(data.view);
                } else {
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }


    function editImagingOrder(key){
       
        $("#printimgview").modal('hide');
        $("#labtests").modal('show');
        $.ajax({
            url: '{{ url("imaging/editorder")}}',
            type: "post",
            data: {
                'userID': '{{$patientId}}',
                'labkey': key,
                'formdata' : $('#all_img_entries').val() ,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#previewimaging").html(data.view);
                } else {
                    swal("Error!", data.message, "error");
                }
            },
            error: function(xhr) {
                handleError(xhr);
            }
        });
    }


    function openSoapNotes(medicalnotekey,type='',newPage=1) {
        if ($('.'+type+'soapnotecls_'+medicalnotekey).hasClass('collapsed')) {
           
          return ;
        }

       showPreloader('appendsoapnotes_'+medicalnotekey);
     
       $.ajax({
           type: "POST",
           url: '{{ url("/notes/details") }}',
           data: {
               "medicalnotekey" : medicalnotekey,
               "userID"         : '{{$patientId}}',
               'page'           : newPage,
               'type'           : type ,
               '_token'         : $('meta[name="csrf-token"]').attr('content')

           },
           success: function(response) {
               // Handle the successful response
               if(response.success == 1){
                
                    $("#"+type+"appendsoapnotes_"+medicalnotekey).html(response.view);
                    
               }
               
           },
           error: function(xhr) {
               
               handleError(xhr);
           },
       })
   }


   function deleteSoapNotes(medicalnotekey) {
        swal({
            text: 'Are you sure you want to delete this note ?',
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
                    type: "POST",
                    url: '{{ url("/notes/delete") }}',
                    data: {
                        "medicalnotekey" : medicalnotekey,
                        "userID"         : '{{$patientId}}',
                        '_token'         : $('meta[name="csrf-token"]').attr('content')

                    },
                    success: function(response) {
                        // Handle the successful response
                        if(response.success == 1){
                            swal.close();
                            getAppointmentMedicalHistory('notes')
                        }else{
                            swal(data.errormsg, {
                                icon: "error",
                                text: data.errormsg,
                                button: "OK",
                            });
                        }
                        
                    },
                    error: function(xhr) {
                        
                        handleError(xhr);
                    },
                })
            }
        });
    }

    function editNotes(medicalnotekey){
        $('#notes').modal('show');
        var viewType = '{{$viewType}}';
        showPreloader('addnotesmodal');

        $.ajax({
            url: '{{ url("/notes/editnotes")}}',
            type: "post",
            data: {
                "userID": '{{$patientId}}',
                "medicalnotekey" : medicalnotekey,
                "view" :viewType,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#addnotesmodal").html(data.view);
                    $('input, textarea').each(function () {
                        if ($(this).val()) {
                            $(this).siblings('label').addClass('active');
                        }
                    });
                }else{
                    $('#notes').modal('hide');
                    swal(data.errormsg, {
                        icon: "error",
                        text: data.errormsg,
                        button: "OK",
                    });
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }
    
    function openOrderDevices(){
        $("#orderdevices").modal('show');
        showPreloader('appendorderdevices');
        $.ajax({
            url: '{{ url("/devices/add")}}',
            type: "post",
            data: {
                "userID": '{{$patientId}}',
                'type':'add',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#appendorderdevices").html(data.view);

                } else {

                }   
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });

    }  

    
    function placeOrder(){
        
        $('#add_deviceorderform').validate({
            rules: {
                'rpmdevices[]': {
                    required: true,
                    remote: {
                        url: "{{ url('/devices/checkselecteddeviceexist') }}",
                        cache: false, // This prevents caching of responses
                        data: {
                            'type': 'other',
                            "userID": '{{$patientId}}',
                            '_token': $('input[name=_token]').val(),
                            'rpmdeviceuuids': function() {
                                return $("input[name='rpmdevices[]']:checked").map(function() {
                                    return $(this).val();
                                }).get();
                            }
                        },
                        type: "post",
                        dataFilter: function(response) {
                              // Parse the server's response
                            const res = JSON.parse(response);
                            if (res.valid) {
                                return true; // Validation passed
                            } else {
                                // Dynamically return the error message
                                return "\"" + res.message + "\"";
                            }
                        }
                    }
                }
            },
            messages: {
                'rpmdevices[]': {
                    required: "Please select at least one device"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "rpmdevices[]") {
                   $('.devicecls').last().after(error);
                } else {
                    error.insertAfter(element);
                }
            }
            
        });
         if($("#add_deviceorderform").valid()){
             $(".rpmorderbtn").addClass('disabled');
            $.ajax({
                url: '{{ url("/devices/add")}}',
                type: "post",
                data: {
                    "userID"    : '{{$patientId}}',
                    'formData'  :  $("#add_deviceorderform").serialize(),
                     'type'     :  'placeorder',
                    '_token'    : $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#appendorderdevices").html(data.view);

                    } else {
                           swal(data.errormsg, {
                                icon: "error",
                                text: data.errormsg,
                                button: "OK",
                            });
                        $(".rpmorderbtn").removeClass('disabled');
                    }   
                },
                error: function(xhr) {

                    handleError(xhr);
                },
            });
         }
        
    }   
    function confirmOrder(){
        $(".rpmorderbtn").addClass('disabled');
        $.ajax({
            url: '{{ url("/devices/add")}}',
            type: "post",
            data: {
                "userID"    : '{{$patientId}}',
                'formData'  :  $("#add_deviceorderform").serialize(),
                 'type'     :  'confirmorder',
                '_token'    : $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#orderdevices").modal('hide');
                    $("#orderdevicesuccessloader").modal('show');

                } else {

                }   
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
        
    }
        
    function showPrescription(){
        var iframe = $('#prescriptionmodal iframe');
        iframe.attr('src', 'about:blank');
        var loaderimgPath = "{{ asset('images/loader.gif') }}";
         $('#prescriptionmodal iframe').attr('src', loaderimgPath);
        $("#prescriptionmodal").modal('show');
        
        $.ajax({
            url: '{{ url("/prescription/add")}}',
            type: "post",
            data: {
                "userID": '{{$patientId}}',
                'type':'add',
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    if( data.iframeurl != ''){
                        $('#prescriptionmodal iframe').attr('src', data.iframeurl);
                    }

                } else {
                    swal({
                        title: "Error!",
                        text: data.errormsg,
                        icon: "error",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                       // window.location.reload();
                    });

                }   
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });

    }




</script>