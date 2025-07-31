@extends('layouts.app')
@section('title', 'Payouts')
@section('content')


      <section id="content-wrapper">
                    <div class="container-fluid p-0">
                      <div class="row h-100">
                        <div class="col-lg-12">
                          <div class="row">
                           
                            <div class="col-lg-12 mb-3">
                              <div class="web-card h-100 mb-3">
                                <div class="row">
                                  <div class="col-sm-4 text-center text-sm-start">
                                    <h4 class="mb-md-0">Payouts</h4>
                                  </div>
                                  <div class="col-sm-8 text-center text-sm-end">
                                    <div class="btn_alignbox justify-content-md-end">
                                   
                                      <a class="btn filter-btn"  onclick="getFilter()" ><span class="material-symbols-outlined">filter_list</span>Filters</a>
                                    </div>


                                       
                                     

                                      </div>
                                      <div class="col-12"> 
                                        <div @if( (isset($_GET['startDate'])) || (isset($_GET['patient']) ) ) style="display: block;" @else style="display: none;" @endif id="patientfilter" class="collapse-filter @if( (isset($_GET['startDate'])) || (isset($_GET['patients']) ) ) show @endif">
                                          <form id="search" method="GET">
      
                                          <div class="row justify-content-end mt-3">
      
                                            <div class="col-md-4 d-flex align-items-center">
                                            <div class="form-group form-outline select-outline mb-3 w-100">
                                              <i class="fa-solid fa-user-tag"></i>
                                              <select name="patient" id="patient" class="form-select" onchange="submitfilter();">
                                                <option value="">Patient</option>
                                                @if(!empty($patientDetails))
                                                  @foreach($patientDetails as $pd)
                                                    <option value="{{$pd['patients_uuid']}}" @if(isset($_GET['patient']) && $_GET['patient'] == $pd['patients_uuid']) selected @endif>{{$pd['name']}}</option>
                                                  @endforeach
                                                @endif
                                              </select>
                                           </div>
                                          </div>
      
      
                                            <div class="col-md-6 ps-0">
                                              <div class="align_middle">
                                                  <div class="form-group form-outline w-100">
                                                    <i class="material-symbols-outlined">calendar_month</i>
                                                    <label class="float-label @if($startDate!='' && $endDate !='' ) active @endif">Select Date Range</label>
                                                    <input type="text" id="dateRange" @if($startDate!='' && $endDate !='' ) value="{{ date('m/d/Y', strtotime($startDate)) }} - {{ date('m/d/Y', strtotime($endDate)) }}" @endif  class="form-control dateRange">
                                                    <!-- <input type="text" id="dateRange" value="{{$startDate}} - {{$endDate}}" class="form-control dateRange"> -->
      
                                                  </div>
                                                  <a onclick="submitfilter()" id="submitfilter" class="btn btn-primary">Submit</a>
                                                  <button type="button" class="btn btn-outline-primary" onclick="clearFilter();">Clear All</button>
                                                </div>
                                              </div>
      
                                              <input type="hidden" name="startDate" id="startDate" value="{{$startDate}}" class="form-control mt-2 mb-3">
                                              <input type="hidden" name="endDate" id="endDate" value="{{$endDate}}" class="form-control mt-2 mb-3">
                                            </div>
                              
                                               
                                          </form>
                                            </div>
                                      </div>
                                  </div>

                                 

                                  
                                

                                  <div class="col-12">
                                    <div class="tab_box">
                                        
                                </div>
                               
                                  <div class="col-lg-12 mb-3 mt-4">
                                    <div class="table-responsive">
                                      <table class="table table-hover table-white text-start w-100">
                                      <thead>
                                        <tr>
                                          <th style="width: 30%">Patient</th>
                                          <th style="width: 20%">Clinican</th>
                                          <th style="width: 15%">Appointment Date</th>
                                          <th style="width: 15%" class="text-end">Appointment Fee</th>
                                          <th style="width: 15%">Payment Date </th>


                                          <th style="width: 5%" class="text-end">Actions</th>
                                         
                                        </tr>
                                      </thead>
                                      <tbody>
                                    
                                      @if(!empty($paymentData['data']))
                                      @foreach($paymentData['data'] as $pl)
                                      @if(isset($appointment[$pl['parent_id']]))
                                        <tr>
                        
                                        <td style="width: 30%">
                                            <div class="user_inner">
                                              <?php
                                                $patientDetails = $appointment[$pl['parent_id']]['patient_user'] ;
                                                $patient = $appointment[$pl['parent_id']]['patient'] ;
                                                $corefunctions = new \App\customclasses\Corefunctions;
                                                if($patient['profile_image'] !=''){
                                                  $patient['profile_image'] = $corefunctions -> resizeImageAWS($patient['id'],$patient['profile_image'],$patient['first_name'],180,180,'2');
                                                }
                                                $age = $corefunctions -> calculateAge($patientDetails['dob']);

                                              ?>
                                                <img @if($patient['profile_image'] !='') src="<?php echo $patient['profile_image'] ?>" @else src="{{asset('images/default_img.png')}}" @endif>
                                                <div class="user_info">
                                                  <a  @if($patientDetails['deleted_at'] == '') href="{{url('appointment/'.$appointment[$pl['parent_id']]['appointment_uuid'].'/details')}}" @endif>
                                                    <h6 class="primary fw-medium m-0">{{$patient['first_name']}}</h6>
                                                    <p class="m-0">{{$age}} | {{ $patientDetails['gender'] == '1' ? 'Male' : ($patientDetails['gender'] == '2' ? 'Female' : 'Other') }}</p>
                                                    @if($status == 'inactive' && isset($patientDetails['account_deleted']) && $patientDetails['account_deleted'] == '1')<p><span class="badge bg-danger text-dark">Deleted</span></p>@endif
                                                  </a>
                                                </div>
                                            </div>
                                          </td>
                                         
                                          <td style="width: 20%">
                                          <div class="user_inner">
                                                <?php     
                                                        
                                                    $image = $corefunctions -> resizeImageAWS($appointment[$pl['parent_id']]['consultant']['id'],$appointment[$pl['parent_id']]['consultant']['profile_image'],$appointment[$pl['parent_id']]['consultant']['first_name'],180,180,'1');
                                                ?>

                                                <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif>

                                                <div class="user_info">
                                                <a @if($patientDetails['deleted_at'] == '')   href="{{url('appointment/'.$appointment[$pl['parent_id']]['appointment_uuid'].'/details')}}" @endif>

                                                    <h6 class="primary fw-medium m-0">{{ $corefunctions -> showClinicanNamePayout($appointment[$pl['parent_id']]['consultant'],$appointment[$pl['parent_id']]['consultant_clinic_user']['designation_id'],1); }}</h6>
                                                    <p class="m-0">{{ $appointment[$pl['parent_id']]['consultant']['email']  ?? 'N/A' }}</p>
                                                    </a> 
                                                  </div>

                                              
                                            </div>
                                          </td>
                                         
                                          <td style="width:15%"><?php echo $corefunctions->timezoneChangeAppointment($appointment[$pl['parent_id']]['appointment_date'],$appointment[$pl['parent_id']]['appointment_time'],"M d, Y | h:i A") ?></td>
                       
                                          <td style="width: 15%" class="text-end"> ${{ number_format($appointment[$pl['parent_id']]['appointment_fee'],2) }} </td>

                                        
                                          <td style="width:15%">@if(isset($pl['created_at']) && $pl['created_at'] !='')<?php echo $corefunctions->timezoneChange($pl['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($pl['created_at'],'h:i A') ?> @endif</td>
     
                                          

                                          <td style="width:5%" class="text-end">
                                            @if($patientDetails['deleted_at'] == '') 
                                            <div class="d-flex align-items-center justify-content-end">
                                              <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item fw-medium" href="{{url('appointment/'.$appointment[$pl['parent_id']]['appointment_uuid'].'/details')}}" data-bs-toggle="tooltip" title="View"><i class="fa-solid fa-eye me-2"></i>View</a></li>                                      
                                               
                                              </ul>
                                            </div>
                                            @endif
                                          </td>
                                          
                                        </tr> 
                                        @endif
                                        @endforeach
                                        @else

                                       
                                         
                                          <tr class="text-center">
                                                <td colspan="8">
                                                    <div class="flex justify-center">
                                                        <div class="text-center  no-records-body">
                                                            <img src="{{asset('images/nodata.png')}}"
                                                                class=" h-auto">
                                                            <p>No records found</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                           

                                        @endif
                                       
                                        
                                      </tbody>
                                    </table>
                                  </div>  
                                  </div>
                                  <div class="col-12">
                                    <div class="row">
                                    @if(!empty($paymentData['data']))
                                      <div class="col-lg-6">
                                      <form method="GET" action="{{ route('payouts.list') }}">
                                        <div class="sort-sec">
                                          <p class="me-2 mb-0">Displaying per page :</p>
                                          <select class="form-select" aria-label="Default select example" name="limit" onchange="this.form.submit()">
                                          <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                                          <option value="15" {{ $limit == 15 ? 'selected' : '' }}>15</option>
                                          <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                                          </select>
                                       </div>
                                      </form>
                                      </div>
                                      @endif
                                      <div class="col-lg-6">
                                      {{ $paymentDetails->links('pagination::bootstrap-5') }}
                                     
                                      </div>

                                    </div>

                                  </div>
                                </div>
                              </div>
                           </div>
                          </div>
                        </div>
                         
                        </div>
                      </div>
                    </section>



                    

                    

                

          <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->


<script type="text/javascript">
   function toggleLabel(input) {
        const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
        $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
    }
    
  function clearFilter() {
      window.location.href = "{{url('/payouts')}}";
  }
  function getFilter() {
                          
      if ($("#patientfilter").hasClass("show")) {
        $("#patientfilter").removeClass('show')
        $("#patientfilter").hide();
      }else{
        
        $("#patientfilter").show();
        $("#patientfilter").addClass('show')
      }
    }
  $('#search').keypress(function(event) {
    if (event.which === 13) { // Enter key code is 13
        event.preventDefault(); // Prevent the default form submit
        $("#search").submit();
    }
});
function submitfilter(){
  $("#search").submit();

}
    $(document).ready(function(){
       // Handle the datetime picker widget appearance by re-checking label state
       $(document).on('click', '.dateRange', function () {
                const input = $(this).closest('.time').find('input');
                toggleLabel(input[0]);
            });

    
            // Initialize the daterangepicker
            $('#dateRange').daterangepicker({
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 days': [moment().subtract(6, 'days'), moment()],
                    'Last 2 weeks': [moment().subtract(13, 'days'), moment()],
                    'Last 15 days': [moment().subtract(14, 'days'), moment()],
                    'Last 1 month': [moment().subtract(1, 'months'), moment()],
                    'Last 3 months': [moment().subtract(3, 'months'), moment()],
                    'Last Year': [moment().subtract(1, 'years'), moment()]
                },
                opens: 'left',
                startDate: moment().subtract(14, 'days'),
                endDate: moment(),
                autoApply: true,
                alwaysShowCalendars: true,
                showCustomRangeLabel: false,
                linkedCalendars: false,
                showDropdowns: true,
                autoUpdateInput: false
            });

            // Update the input field on apply
            $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
                $("#startDate").val(picker.startDate.format('MM/DD/YYYY'));
                $("#endDate").val(picker.endDate.format('MM/DD/YYYY'));

                toggleLabel(this);
            });
          });

$('#endDate').datepicker({
				maxDate:new Date()
			});
			$('#startDate').datepicker({
				maxDate:new Date()
			});
  
$('#search').keypress(function(event) {
    if (event.which === 13) { // Enter key code is 13
        event.preventDefault(); // Prevent the default form submit
        $("#search").submit();
    }
});

 
 

</script>

 
          

@stop
