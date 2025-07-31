@extends('frontend.master')
@section('title', 'My Receipts')
@section('content')


<section class="details_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="row">
                        <div class="col-sm-5 text-center text-sm-start">
                            <h4 class="mb-md-0">Receipts</h4>
                        </div>
                        <div class="col-sm-7 text-center text-sm-end">
                            <div class="btn_alignbox justify-content-sm-end">

                            </div>
                        </div>
                <div class="col-lg-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                      <thead>
                        <tr>
                          <th style="width:25%">Receipt ID</th>
                       
                           <th style="width:25%">Clinician</th>
                          <th style="width:10%" class="text-end">Amount</th>
                          <th style="width:30%">Appointment Date & Time</th>
                          <!-- <th style="width:20%">Status</th> -->
                          <th class="text-end" style="width:10%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                        @if($paymentData['data'])
                          @foreach($paymentData['data'] as $pds)
                          
                      
                            <tr>
                              <td style="width:25%">
                              #{{ $pds['receipt_num'] }}
                              </td>
                              <td style="width:25%">
                                 @if(isset($appointment[$pds['parent_id']]) && !empty($appointment[$pds['parent_id']])) 
                              <?php
                                    $corefunctions = new \App\customclasses\Corefunctions;
                                    
                                      $logo_path= $corefunctions -> resizeImageAWS($appointment[$pds['parent_id']]['consultant_clinic_user']['user']['id'],$appointment[$pds['parent_id']]['consultant_clinic_user']['user']['profile_image'],$appointment[$pds['parent_id']]['consultant_clinic_user']['user']['first_name'],180,180,'1');
                                  ?>
                                   <div class="user_inner">
                                  <img src="{{$logo_path}}" alt="User">
                                <div class="user_info">
                                    <a id="view-appointment"  href="{{ route('appointmentDetails', [$appointment[$pds['parent_id']]['appointment_uuid']]) }}">
                                        
                                        <h6 class="primary fw-medium m-0">{{ $corefunctions -> showClinicanName($appointment[$pds['parent_id']]['consultant_clinic_user'],'1');}}</h6>
                                        <small class="m-0">{{ $appointment[$pds['parent_id']]['consultant_clinic_user']['email'] ?? 'N/A' }}</small>
                                    </a>
                                </div>
                                </div>
                                  @endif
                              </td>
                              
                              

                              <td style="width:10%" class="text-end">
                             ${{ number_format($pds['amount'],2) }}
                              </td>

                             <td style="width:30%">
                            @if(isset($appointment[$pds['parent_id']]) && !empty($appointment[$pds['parent_id']]))
                            <?php echo $corefunctions->timezoneChange($appointment[$pds['parent_id']]['appointment_date'],'M d, Y') ?> | <?php echo $corefunctions->timezoneChange($appointment[$pds['parent_id']]['appointment_time'],'h:i A') ?>
                            @endif
                              </td>

                              <!--  <td style="width:25%">
                             --
                              </td> -->

                              <td class="text-end" style="width:10%">
                                <div class="d-flex align-items-center justify-content-end">
                                  <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                 
                                    <li>
                                      <a href="{{url('receipt/'.$pds['payment_uuid'].'/download')}}"  class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-download me-2"></i>Download Receipt
                                      </a>
                                    </li>

                                    <li>
                                      <a onclick="viewReceipt('{{$pds['payment_uuid']}}')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-eye me-2"></i>View Receipt
                                      </a>
                                    
                                    </li>
                                    
                                  </ul>
                                </div>
                              </td>
                            </tr>
                          @endforeach
                        @else
                        <tr class="text-center">
                            <td colspan="8">
                                <div class="flex justify-center">
                                    <div class="text-center no-records-body">
                                        <img src="{{asset('images/nodata.png')}}"
                                            class=" h-auto" alt="no records">
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
                    <form method="GET"  >
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
    
</section>

<!-- Import Data Modal -->
<div class="modal login-modal fade" id="import_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body" id="import_data_modal"></div>
    </div>
  </div>
</div>


<!-- Import Data Modal -->
<div class="modal login-modal fade" id="import_preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body" id="import_preview_modal"></div>
    </div>
  </div>
</div>

<!-- Add Doctor Modal -->
<div class="modal login-modal fade" id="addDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="addDoctor"></div>
    </div>
  </div>
</div>


<!-- edit Doctor Modal -->
<div class="modal login-modal fade" id="editDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editDoctor"></div>
    </div>
  </div>
</div>

<!-- edit Doctor Modal -->
<div class="modal login-modal fade" id="viewreceipt_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        
     <div class="modal-header modal-bg p-0 position-relative">
        <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body text-center" id="viewreceipt"></div>
    </div>
  </div>
</div>

<script>

function viewReceipt(pkey) {
   // showPreloader('receiptpdf');
    $("#viewreceipt_modal").modal('show');
   $("#viewreceipt").html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"  alt="Loader"  alt="Loader"></div>');
    $.ajax({
        type: "POST",
        url: "{{ URL::to('viewreceipt')}}",
        data:{ 
            'key': pkey,
            "_token": "{{ csrf_token() }}"
        },
        dataType : 'json',
        success: function(data) {
            if(data.success==1){
                $("#viewreceipt").html(data.view);
            }
        },
        error: function(xhr) {
               
          handleError(xhr);
        },
    });
}


</script>

@stop
