<div class="container">
  <div class="row">
    <div class="col-12 mb-3">

        <div class="row">
          <div class="col-5 text-start">
            <h4 class="mb-md-0">Receipts</h4>
          </div>
          <div class="col-7 text-end">
            <div class="btn_alignbox justify-content-end flex-wrap">
              <a class="btn filter-btn"  onclick="getFilter()" ><span class="material-symbols-outlined">filter_list</span>Filters</a>
            </div>
          </div>
          <div class="col-12"> 
            <div class="btn_alignbox justify-content-sm-end"> 
              <div id="patientfilter" class="collapse-filter">
                <form id="search" method="GET">
                  <div class="align_middle w-100 flex-md-row flex-column my-3">
                    <div class="form-group form-floating w-100">
                      <i class="fa-solid fa-user-tag"></i>
                      <select name="clinicid" id="clinicid" class="form-select" onchange="submitFilter();">
                        <option value="">Select Clinic</option>
                        @if(!empty($patientClinics))
                          @foreach($patientClinics as $clinic)
                            <option value="{{$clinic['id']}}" @if(request()->get('clinicid') == $clinic['id']) selected @endif>{{$clinic['name']}}</option>
                          @endforeach
                        @endif
                      </select>
                      <label class="select-label">Clinic</label>
                    </div>
                    <div class="btn_alignbox">
                      <button type="button" class="btn btn-outline-primary" onclick="clearFilter();">Clear All</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>

          </div>
          <div class="col-lg-12 mb-3 mt-4">
            <div class="table-responsive">
              <table class="table table-hover table-white text-start w-100">
                <thead>
                  <tr>
                    <th style="width:25%">Receipt ID</th>
                    <th style="width:25%">Clinic</th>
                    <th style="width:10%" class="text-end">Amount</th>
                    <th style="width:25%">Payment Date & Time</th>
                    <th style="width:10%">Type</th>
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
                           {{ $pds['clinic_name'] ?? '' }}
                        </td>
                        <td style="width:10%" class="text-end">
                          ${{ number_format($pds['amount'],2) }}
                        </td>
                        <td style="width:25%">
                          <?php echo $corefunctions->timezoneChange($pds['created_at'],'M d, Y') ?> | <?php echo $corefunctions->timezoneChange($pds['created_at'],'h:i A') ?>
                        </td>
                        <td style="width:10%">
                          {{ ucwords($pds['parent_type']) }}
                        </td>
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
              <div class="col-lg-6" id="pagination">
                {{ $paymentDetails->links('pagination::bootstrap-5') }}
              </div>
            </div>
          </div>
        </div>
    
    </div>
  </div>
</div>

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
  $(document).ready(function() {
    //Pagination through ajax - pass the url
    $(document).on('click', '.pagination a', function(e) {
      e.preventDefault();
      const pageUrl = $(this).attr('href');
      const urlObj = new URL(pageUrl); // Create a URL object
      var page = urlObj.searchParams.get('page');
      changeTab('receipts',page)
    });
    @if(request()->get('clinicid'))
      $("#patientfilter").show().addClass('show');
    @else
      $("#patientfilter").hide().removeClass('show');
    @endif
  });
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
  function getFilter() {                  
    if ($("#patientfilter").hasClass("show")) {
      $("#patientfilter").removeClass('show')
      $("#patientfilter").hide();
    }else{
      $("#patientfilter").show();
      $("#patientfilter").addClass('show')
    }
  }
  function submitFilter(){
    var clinicId = $("#clinicid").val();
    const queryParams = new URLSearchParams({
      clinicId: clinicId
    });
    changeTab('receipts','1',clinicId,queryParams.toString());
  }
  function clearFilter() {
    changeTab('receipts');
  }
</script>
