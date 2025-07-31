<div class="tab-pane fade show active" id="pills-addon" role="tabpanel" aria-labelledby="pills-addon-tab">
  <div class="row g-4">
        @if($isenabledaddon == '0')
        <div class="col-12">
            <div class="border rounded-4 p-4 bg-white"> 
                <div class="row align-items-center mb-4">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{asset('/images/escribe.png')}}" alt="icon" class="escribe-icon">
                            <div>
                                <h4 class="gray fw-medium mb-1">Optional Add-On</h4>
                                <h2 class="font-large mb-0 fw-bold">ePrescribe</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="btn_alignbox justify-content-md-end gap-4">
                            <div>
                                <h5 class="mb-0 fw-bold">$79.00</h5>
                                <p class="gray mb-0">Per month</p>
                            </div>
                            @if( isset($isUsUser) && $isUsUser == 0)
                            <a class="btn btn-primary" onclick="disableePrescribe();"> Enable ePrescribe</a>
                            @else
                            <a class="btn btn-primary" onclick="enableAddOn();"> Enable ePrescribe</a>
                            @endif
                        </div>
                        @if($cancelledDate !='')
                            <div class="cancelled-box mt-3">
                                <span class="material-symbols-outlined primary">warning</span>
                                <small class="m-0 fw-light">Cancelled On - {{$cancelledDate}}</small>
                            </div>
                        @endif
                    </div>

        
                </div>

                <div class="gray-border"></div>

                <div class="mt-3">
                    <small class="fw-exlight">Add-On includes:</small>
                    <ul class="list-unstyled imp-point mt-2 mb-0">
                        <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>One-time Setup: $250</li>
                        <li class="gray"><span class="material-symbols-outlined gray me-1">check_circle</span>12-month minimum commitment required</li>
                    </ul>
                </div>
            </div>
        </div>
        @endif
        <?php 
        $corefunctions = new \App\customclasses\Corefunctions;?>
        @if($isenabledaddon == '1')
        <div class="col-12"> 
            <div class="border rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-lg-center flex-lg-row flex-column gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{asset('/images/escribe.png')}}" class="img-fluid escribe-img" alt="escribe">
                        <div class="">
                            <p class="gray fw-medium mb-0">Addons</p>
                            <h2 class="font-large mb-0 fw-bold">ePrescribe</h2>
                        </div>
                    </div>
                
                    <div class="text-lg-end">
                        <div class="d-flex align-items-center gap-2 onboard-success mb-1">
                            <span class="material-symbols-outlined">verified</span>
                            <h4 class="fw-bold m-0">ePrescription Enabled</h4>
                        </div>
                        @if($nextPaymentDue !='')
                        <p class="m-0">Next Payment Due - {{$nextPaymentDue}}</p>
                        @endif
                        <a onclick="cancelClinicEprescription()" class="align_middle justify-content-end fw-medium">
                            <p class="text-decoration-underline primary mb-0">Cancel Eprescription</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6"> 
            <div class="border rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2"> 
                    <h5 class="primary fw-medium mb-0">Prescribers</h5>
                    @if($isAddPrescribers > 0)
                    <a onclick="enableAddOn();" class="align_middle fw-medium"><span class="material-symbols-outlined primary">add</span><p class="text-decoration-underline primary mb-0">Add Prescribers</p></a>
                    @endif
                </div>
              
                @if(!empty($users))
                    @foreach($users as $user)
                        <?php 
                            
                            if($user['user_type_id'] == '1' || $user['user_type_id'] == '2'){
                                $image = $corefunctions -> resizeImageAWS($user['id'],$user['logo_path'],$user['name'],180,180,'1');
                                $name = $corefunctions -> showClinicanNameUser($user,'0');
                            }else{
                                $image = $corefunctions -> resizeImageAWS($user['id'],$user['logo_path'],$user['name'],180,180,'1');
                                $name = $user['name'];
                            }
                        ?>
                        <div class="border rounded-4 p-3 bg-white mb-3"> 
                            <div class="row align-items-center g-3">
                                <div class="col-12 col-xl-8"> 
                                    <div class="user_inner user_inner_xl">
                                        <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif  class="img-fluid" alt="user">
                                        <div class="user_info">
                                            <h5 class="primary text-break fw-medium mb-1">{{ $name }}</h5>
                                            <p class="m-0 text-break">{{ $user['email'] }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-4"> 
                                    <a onclick="cancelEprescription('{{$user['clinic_user_uuid']}}')" class="align_middle fw-medium"><p class="text-decoration-underline primary mb-0">Cancel Eprescription</p></a>
                                    <!-- <div class="d-flex align-items-center justify-content-xl-end gap-2 onboard-success text-start">
                                            <span class="material-symbols-outlined">verified</span>
                                            <h5 class="fw-medium m-0">Onboarding Complete</h5>
                                        </div> -->
                                    <!-- <div class="d-flex align-items-center justify-content-xl-end gap-2 onboard-pending text-start">
                                        <span class="material-symbols-outlined">hourglass_top</span>
                                        <h5 class="text-success fw-medium m-0 text-break">Onboarding Pending</h5>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
               


            </div>
        </div>
     
        <div class="col-12 col-lg-6"> 
            <div class="border rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap"> 
                    <h5 class="primary fw-medium mb-0">Invoices</h5>
                </div>
         
                    <div class="table-container">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Invoice Number</th>
                                    <th>Date</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($invoices))
                                    @foreach($invoices as $invoice)
                                        <tr>
                                            <td data-label="Invoice Number">INV/{{ $invoice['invoice_number'] }}</td>
                                            <?php 
                                                $date = (isset($invoice['created_at']) && ($invoice['created_at'] != "")) 
                                                    ? $corefunctions->timezoneChange($invoice['created_at'], "d M Y") 
                                                    : ""; 
                                            ?>
                                            <td data-label="Date">{{ $date }}</td>
                                            <td data-label="Actions" class="text-end">
                                        <div class="btn_alignbox justify-content-end"> 
                                            <a class="btn border-0 opt-view" href="{{url('invoice/'.$invoice['invoice_uuid'].'/download')}}" >
                                                <span class="material-symbols-outlined">download_2</span>
                                            </a>
                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a onclick="viewInvoice('{{ $invoice['invoice_uuid'] }}')" class="dropdown-item fw-medium">
                                                        <i class="fa-solid fa-eye me-2"></i>
                                                        <span>View</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a onclick="viewReceipt('{{ $invoice['payment_id'] }}')" class="dropdown-item fw-medium">
                                                        <i class="fa-solid fa-file-invoice me-2"></i>
                                                        <span>View Receipt</span>
                                                    </a>
                                                </li>
                                                <!-- <li>
                                                    <a href="" class="dropdown-item fw-medium">
                                                        <i class="fa-solid fa-pen me-2"></i>
                                                        <span>Edit</span>
                                                    </a>
                                                </li> -->
                                            </ul>
                                        </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                              
                            </tbody>
                        </table>
                    </div>
           
            </div>
        </div>

        @endif


  </div>
    
</div>


<!-- Users-enable add-on Modal -->
<div class="modal fade" id="enableAddonstatic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl subscription-modal-xl ">
        <div class="modal-content subscription-modal p-0">
            <div class="modal-header modal-bg p-0 position-relative">
              <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0 ">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="subscription-box">
                            <h4>Subscribe to Blackbag ePrescribe</h4>
                            <div class="amount align-items-start gap-2">
                                <div class="d-flex flex-column">
                                    <div class="align_middle align-items-start">
                                        <h1 class="display-5 fw-bold mb-0">$79.00</h1>
                                        <p class="fw-light mb-0">per doctor</p>
                                    </div>
                                    <p>ePrescription Monthly Fee</p>
                                </div>
                            </div>

                            <div class="feature-box d-flex gap-3">
                                <img src="{{asset('images/bb-eprescribe.png')}}" class="escribe-icon" alt="">
                                <div>
                                    <strong>Blackbag ePrescribe</strong><br />
                                    <small>
                                    BlackBag ePrescribe unlocks fast, accurate, and secure digital prescribing — helping you save time, reduce errors, and deliver a seamless experience for your patients.
                                    </small>
                                </div>
                            </div>
                            <div class="amount-list mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <p>One Time Setup Fee</p>
                                    <span><strong>$250.00</strong></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <p>Amount Per Prescriber</p>
                                    <span>($79.00 × 1) <strong class="ms-1">$79.00</strong></span>
                                </div>
                                <hr />
                                <div class="d-sm-flex  justify-content-between     total-price text-end  ">
                                    <span>Total Due Today</span>
                                    <span class="ms-2">$344.00</span>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Subscription Form -->
                <div class="col-lg-6">
                    <div class="form-container ">
                    <form>
                    <!-- Prescriber Selection -->
                    <div class="mb-4">
                        <h4 class="fw-bold mb-3">Prescribers</h4>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-outline no-iconinput">
                                    <label for="input">Select Patient</label>
                                
                                    <div class="dropdownBody">
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                            </a>
                                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                                <li class="dropdown-item">
                                                    <div class="form-outline input-group ps-1">
                                                        <div class="input-group-append">
                                                        <button class="btn border-0" type="button">
                                                            <i class="fas fa-search fa-sm"></i>
                                                        </button>
                                                        </div>
                                                        <input type="text" class="form-control border-0 small" placeholder="Search Patient" aria-label="Search" aria-describedby="basic-addon2">
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                                <li class="dropdown-item">
                                                    <div class="dropview_body profileList">
                                                    <input class="form-check-input" type="checkbox" id="" name="option1" value="something" >
                                                    <img  src="{{asset('images/responsive_loginbg.jpg')}}">
                                                    <p class="m-0">Justin Taylor</p>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="slt-prescribers">
                                    <div class="user_inner">
                                        <img src="{{asset('images/doct1.png')}}" class="img-fluid">
                                        <div class="user_info">
                                            <h6 class="primary fw-medium m-0">Jelani Kasongo, MD</h6>
                                            <p class="m-0">jelanikasongo@gmail.com</p>
                                        </div>
                                    </div>
                                    <div class="gray-borde mt-3 mb-3"></div>
                                    <div class="prescribers">
                                        <p class="m-0">Would you like to enable Blackbag ePrescribe for yourself.</p>
                                        <div class="d-flex gap-3">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">YES</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">NO</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
        </div>


          <!-- Card Info -->
          <h5 class="fw-bold mb-2">Payment Method</h5>
          <h6 class="sub-h mb-3">Card Information</h6>
          <div class="row mt-2">
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Name On Card</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Card Number</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Expiry</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">CCV</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
          </div>

          <!-- Billing Address -->
          <h6 class="sub-h my-3">Billing Address</h6>
          <div class="row mt-2">
            <div class="col-md-12 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Address</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>

            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">City</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
            
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">ZIP</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
                        
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">State</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
                                    
            <div class="col-md-6 mb-3">
              <div class="form-group form-outline no-iconinput">
                  <label for="input" class="float-label">Countrye</label>
                  <input type="email" class="form-control" id="" name="">
              </div>
            </div>
          </div>

          <!-- Disclaimer -->
          <small class="text-muted d-block mb-3">
            <span class="text-danger">*</span> By confirming your subscription, you agree to an annual commitment and authorize BlackBag to charge you monthly in accordance with our terms. You may cancel anytime, and your subscription will remain active until the end of the billing period.
          </small>

          <!-- Submit Button -->
          <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#successSubscription">Confirm Subscription</button>
        </form>
      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>


<div class="modal login-modal payment-success fade" id="viewinvoice" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" id="_modal">
            <div class="modal-header modal-bg p-0 position-relative">
                <div>
                    <h5 class="modal-title" id="exampleModalLabel">View Invoice</h5>
                </div>
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body p-0" id="invoicepdf">
                <div class="preloaderappend inquirylistloder centered notification-loader"><img src="{{ asset('img/loading.gif') }}">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Users-enable add-on Modal -->

<!-- View Receipt Modal -->
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
    function cancelEprescription(key){
        swal({
            title: '',
            text: 'Are you sure you want to cancel eprescription for this user?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/clinicuser/eprescription/cancel')}}",
                    data: {
                        'key': key,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == 1) {
                            swal("Success!", data.message, "success").then(() => {
                                tabContent('addons');
                            });
                        } else {
                            swal("Error!", data.message, "error");
                        }
                    }
                });
            }
        });
    }
    function cancelClinicEprescription(key){
        swal({
            title: '',
            text: 'Are you sure you want to cancel eprescription for this clinic?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/clinic/eprescription/cancel')}}",
                    data: {
                        'key': key,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == 1) {
                            swal("Success!", data.message, "success").then(() => {
                                tabContent('addons');
                            });
                        } else {
                            swal("Error!", data.message, "error");
                        }
                    }
                });
            }
        });
    }
    function viewReceipt(pid) {
        $("#viewreceipt_modal").modal('show');
        $("#viewreceipt").html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"  alt="Loader"  alt="Loader"></div>');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('viewreceiptbyid')}}",
            data:{ 
                'id': pid,
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
    function viewInvoice(pkey) {
        $("#viewinvoice").modal('show');
        $("#invoicepdf").html('<div class="preloaderappend inquirylistloder  notification-loader billing_loader"><img src="{{ asset('img/loading.gif') }}"></div><iframe id="invoice_iframe"  width="100%" height="600"></iframe>');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/subscriptions/viewinvoice')}}",
            data:{ 
                'key': pkey,
                "_token": "{{ csrf_token() }}"
            },
            dataType : 'json',
            success: function(data) {
                if(data.success==1){ 
                    $('#invoice_iframe').attr('src', data.invoicePath);
                    $('#invoice_iframe').on('load', function() {
                        $(".preloaderappend").hide();
                    });
                }
            }
        });
    }

    function submitCard(){
      if($('#addcardsform').valid()){
       
        $("#submitcardbtn").addClass('disabled');
        $("#submitcardbtn").prop('disabled',true);
        $.ajax({
          url: '{{ url("/addcard") }}',
          type: "post",
          data: {
            'formdata': $("#addcardsform").serialize(),
            '_token': $('input[name=_token]').val()
          },
          success: function(data) {
            if (data.success == 1) {
              swal(data.message, {
                icon: "success",
                text: data.message,
                buttons: false,
                timer: 2000
              }).then(() => {
                $("#submitcardbtn").removeClass('disabled');
                $("#submitcardbtn").prop('disabled',false);
                $("#addCard").modal('hide');
                enableAddOn();
                setTimeout(function(){
                  var radio = $("#selected_card_" + data.key);
                  var checkbox = $(".select-user");
                  if (checkbox.is(':checked')) {
                    selectUser(checkbox[0]);
                  }
                  $(".selectedcardcls").prop("checked", false);
                  if (radio.length > 0) {
                    radio.prop("checked", true).trigger("change");
                    console.log("Radio checked successfully");
                    $("#cardadded").val('1');
                  } else {
                    console.error("Radio button not found");
                  }
                }, 1000);
              });
            } else {
              swal(data.errormsg, {
                icon: "error",
                text: data.errormsg,
                button: "OK",
              });
              $("#submitcardbtn").removeClass('disabled');
              $("#submitcardbtn").prop('disabled',false);

              $("#addCard").modal('hide');

            }
          },
          error: function(xhr) {
            handleError(xhr);
          }
      });
    }
  }
       function disableePrescribe(){
        var errormsg = "ePrescirption can only be enabled for US based clinicians/admins";
         swal(errormsg, {
                icon: "error",
                text: errormsg,
                button: "OK",
              });
    }
</script>