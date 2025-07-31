
                                    <div class="tab-pane show active deviceorders" id="current" role="tabpanel">
                                        @if( !empty($rpmdOrders))
                                        @foreach( $rpmdOrders as $rpo)
                                        <div class="border rounded rounded-3 p-3 mb-3 devicelists" id="rpmorder_{{$rpo['rpm_order_uuid']}}">
                                            <div class="row g-3 align-items-center">
                                                <div class=" @if($type !='current') col-12 col-lg-9 @else col-12 @endif">
                                                    <div class="row"> 
                                                        <div class="col-lg-3"> 
                                                            @if( isset( $rpo['devices'] ) && !empty( $rpo['devices'] ))
                                                            
                                                            <?php $hasMoreDevice = ( count($rpo['devices']) > 3 ) ? '1' : '0';
                                                                $countDevice = 1;
                                                                $remainingCount = count($rpo['devices']) - 3;
                                                            ?>
                                                            @if(  count($rpo['devices']) > 1 )
                                                            
                                                            <div class="d-flex align-items-center h-100 gap-2">
                                                                 
                                                                @foreach( $rpo['devices'] as $dv)
                                                              
                                                                
                                                                <div class="border rounded rounded-3-2 p-2"> 
                                                                    <img src="{{$dv['device_image']}}" class="tool-img">
                                                                </div>
                                                                <?php 
                                                                if( $countDevice == 3){
                                                                    break;
                                                                }
                                                                $countDevice++; ?>
                                                                @endforeach
                                                                @if( $hasMoreDevice == 1 )
                                                           
                                                                <div class="border rounded rounded-3-2 p-2 more-devices-box"> 
                                                                   <a onclick="showDevices('{{$rpo['rpm_order_uuid']}}')"><span>+{{$remainingCount}}</span></a>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            @else
                                                            <label class="sm-label">Order #:</label>
                                                                {{$rpo['order_code']}}
                                                                @if( isset( $rpo['devices']['0'] ) )
                                                                <div class="user_inner tools_inner">
                                                                    <img src="{{$rpo['devices']['0']['device_image']}}">
                                                                    <div class="user_info">
                                                                        <h6 class="primary fw-bold m-0">{{$rpo['devices']['0']['device_name']}}</h6>
                                                                        <p class="m-0">{{$rpo['devices']['0']['device_category']}}</p>  
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            @endif
                                                         
                                                            @endif
                                                        </div>
                                                        <div class="col-lg-2">
                                                             <label class="sm-label">Order #:</label>
                                                             <h6 class="fw-bold mb-0"> {{$rpo['order_code']}}</h6>
                                                        </div>
                                                        <div class="@if($type !='current') col-lg-3 @else col-lg-4 @endif"> 
                                                            <label class="sm-label">Ordered By:</label>
                                                            <div class="user_inner mt-1">
                                                                <img src="@if( isset($rpo['user_image']) ){{$rpo['user_image']}} @endif">
                                                                <div class="user_info">
                                                                    <h6 class="primary fw-bold m-0">@if( isset($rpo['created_user']) ){{$rpo['created_user']}} @endif</h6>
                                                                    <p class="m-0">@if( isset($rpo['clinic_name']) ){{$rpo['clinic_name']}} @endif </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="@if($type !='current') col-lg-4 @else col-lg-3 @endif"> 
                                                            <div class="row"> 
                                                                <div class="col-12 col-lg-6"> 
                                                                    <label class="sm-label">Ordered Date:</label>
                                                                    <h6 class="fw-bold mb-0">{{$rpo['ordered_date']}}</h6>
                                                                </div>
                                                                <div class="col-12 col-lg-6"> 
                                                                    <label class="sm-label">Ordered Time:</label>
                                                                    <h6 class="fw-bold mb-0">{{$rpo['ordered_time']}}</h6>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @if($type !='current')
                                                <div class="col-12 col-lg-3"> 
                                                    <div class="btn_alignbox device-btn-box justify-content-md-end"> 
                                                        @if( $rpo['status'] == '-1')
                                                        <a class="btn btn-outline-primary" onclick="deviceStatusChange('{{$rpo['rpm_order_uuid']}}','reject')">Reject </a>
                                                        <a type="button" class="btn btn-primary" onclick="deviceStatusChange('{{$rpo['rpm_order_uuid']}}','accept')">Accept</a>
                                                        @endif
                                                        
                                                      @if( $rpo['status'] == '2')
                                                        <a class="btn btn-outline-primary" onclick="trackOrder('{{$rpo['rpm_order_uuid']}}')">Track Order </a>
                                                        @endif
                                                        @if( $rpo['status'] == '1' )
                                                        <div class="block text-end">
                                                            <p class="mb-2"><b>Awaiting Fulfillment</b></p>
                                                            <a class="btn btn-outline-primary" onclick="cancelOrder('{{$rpo['rpm_order_uuid']}}')">Cancel Order </a>
                                                        </div>
                                                        @endif
                                                        <!--  <button class="btn opt-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="material-symbols-outlined">more_vert</span>
                                                        </button>-->
                                                        <!--<ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a href="#" class="dropdown-item fw-medium align_middle gap-0" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="material-symbols-outlined me-2">block</i>Cancel Subscription</a></li>
                                                        </ul>-->
                                                    </div>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                            <div class="border rounded rounded-3 p-3 mb-3">
                                                <div class="text-center no-records-body">
                                                    <img src="{{asset('frontend/images/nodata.png')}}"
                                                        class=" h-auto" alt="no records">
                                                    <p>No records found</p>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <input type="hidden" name="rpmorderkey" id="rpmorderkey">
                                        <input type="hidden" name="rpmorderstatus" id="rpmorderstatus">
                                    </div>

<script>
$(document).on('click', '.card_close', function (e) {

    e.preventDefault(); // Optional: prevent default link behavior
    
     var rpmoderkey = $("#rpmorderkey").val();
     var status =    $("#rpmorderstatus").val();
     updateOrderStatus(rpmoderkey,status);


});
    function deviceStatusChange(key, status) {
    swal({
      text: "Are you sure you want to " + status + " this order?",
        // text: status !,
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
            updateOrderStatus(key,status);
        }
    });
}
    function updateOrderStatus(key,status){
        $("#rpmorderkey").val(key);
        $("#rpmorderstatus").val(status);
      // AJAX call only runs if confirmed
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/devices/statuschange') }}",
            data: {
                'key': key,
                'status': status,
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json'
        }).then(response => {
            if (response.success == 1) {
                if( status == 'reject'){
                      swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                          $("#rpmorder_"+key).remove();
                          if( $(".devicelists").length < 1 ){
                              $(".deviceorders").append('   <div class="border rounded rounded-3 p-3 mb-3"><div class="text-center no-records-body"><img src="{{asset('frontend/images/nodata.png')}}" class=" h-auto" alt="no records"><p>No records found</p></div></div>');
                          }
                          if( response.deviceOrdersCount > 0){
                              $(".deviceOrdersCount").html(response.deviceOrdersCount);
                              $(".pendingdevicetabcount").html(response.deviceOrdersCount);
                          }else{
                              $(".accountdevicecount").html('');
                              $(".pendingdevicetabcount").html('');
                          }

                        });
                }else{
                    swal.close();
                    $("#orderDetails").modal('show');
                    $("#device_acceptorders").html('');
                    showPreloader('device_acceptorders');
                     $("#device_acceptorders").html(response.view);
                }

            } else {
                swal("Error!", response.message, "error");
            }
        }).catch(xhr => {
          handleError(xhr);
        });
    }

    function showDevices(orderuuid){
           $("#orderdevicesperorder").modal('show');
        showPreloader('appendorderdevicesperorder');
        $.ajax({
            url: '{{ url("/myaccounts/getorderdevices") }}',
            type: "post",
            data: {
                'orderuuid': orderuuid,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#appendorderdevicesperorder").html(data.view);
                  
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }
       function trackOrder(key){
        $("#trackorder").modal('show');
        showPreloader('appendtrackorder');
        $.ajax({
            url: '{{ url("/myaccounts/trackorder") }}',
            type: "post",
            data: {
                'key': key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#appendtrackorder").html(data.view);
                  
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }  
    function cancelOrder(key){
    swal({
      text: "Are you sure you want to cancel this order?",
        // text: status !,
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
            url: '{{ url("/myaccounts/cancelorder") }}',
            type: "post",
            data: {
                'key': key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                     swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                          $("#rpmorder_"+key).remove();
                          if( $(".devicelists").length < 1 ){
                              $(".deviceorders").append('   <div class="border rounded rounded-3 p-3 mb-3"><div class="text-center no-records-body"><img src="{{asset('frontend/images/nodata.png')}}" class=" h-auto" alt="no records"><p>No records found</p></div></div>');
                          }
                          if( response.deviceOrdersCount > 0){
                              $(".deviceOrdersCount").html(response.deviceOrdersCount);
                              $(".pendingdevicetabcount").html(response.deviceOrdersCount);
                          }else{
                              $(".accountdevicecount").html('');
                              $(".pendingdevicetabcount").html('');
                          }

                        });
                  
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
        }
    });
        
    }
</script>
