<div class="row g-3"> 
    @if(!empty($rpmdOrders))
        @foreach($rpmdOrders as $orders)
            @if(!empty($orders['devices']))
                @foreach($orders['devices'] as $device)
                    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                    <div class="col-12">
                        <div class="border rounded rounded-3 p-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-12">                            
                                    <div class="row "> 
                                        <div class="col-lg-8">                                                                                                                                                                                                  
                                            <div class="user_inner tools_inner">
                                                <img src="{{ $device['device_image'] }}">
                                                <div class="user_info">
                                                    <h6 class="primary fw-bold mb-1">{{ $device['device_name'] }}</h6>
                                                    <p class="m-0 sm-label">{{ $device['device_category'] }}</p>
                                                </div>                                                                                                                                                                           
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4"> 
                                            <div class="d-flex justify-content-end">
                                                <div>
                                                    @if($orders['status'] == '2' && isset($orders['tracking_number']) && $orders['tracking_number'] != '')
                                                    <p class="warning fw-medium sm-label mb-0">Shipped</p>
                                                    <p class="sm-label mb-0">Tracking No : <span class="fw-medium">{{ $orders['tracking_number'] }}</span></p>
                                                    @endif
                                                    @if($orders['status'] == '4')
                                                    <p class="success fw-medium sm-label mb-0">Delivered</p>
                                                    @endif
                                                        @if($orders['status'] == '1')
                                                    <div class="text-end">
                                                        <p class="danger fw-medium sm-label mb-0">Awaiting Fulfillment</p>
                                                        <!-- <a class="badge badge-danger cancel-order" onclick="cancelOrder('{{$orders['rpm_order_uuid']}}')">Cancel Order </a> -->
                                                        <a class="btn btn-outline-primary cancel-order p-2" onclick="cancelOrder('{{$orders['rpm_order_uuid']}}')">Cancel Order </a>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-4 border-top pt-3">
                                            <div class="row">
                                                <div class="col-lg-5"> 
                                                    <label class="sm-label">Ordered By:</label>
                                                    <div class="user_inner mt-1">
                                                        <img src="{{ $orders['ordered_by_image'] }}">
                                                        <div class="user_info">  
                                                            <h6 class="primary fw-middle mb-1">{{ $orders['ordered_by'] }}</h6>
                                                            <p class="m-0">{{ $orders['ordered_by_email'] }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2"> 
                                                    <label class="sm-label">Order No:</label>
                                                    <h6 class="fw-bold mb-0">{{$orders['order_code']}}</h6>
                                                </div>
                                                <div class="col-lg-3"> 
                                                    <label class="sm-label">Ordered On:</label>
                                                    <h6 class="fw-middle mb-0"><?php echo $corefunctions->timezoneChange($orders['created_at'],"M d, Y h:i A") ?></h6>
                                                </div>
                                                <div class="col-lg-2 text-end">
                                                    <label class="sm-label">Status:</label>
                                                    <div>
                                                            @php
                                                        $statuses = [
                                                            -1 => 'Pending',
                                                            1 => 'Accepted',
                                                            2 => 'Accepted',
                                                            4 => 'Accepted',
                                                            ];
                                                        @endphp
                                                        <h6 class="fw-bold mb-1">{{ $statuses[$orders['status']] }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div> 
                        </div>
                    </div> 
                @endforeach
            @endif
        @endforeach
    @else
        <div class="flex justify-center">
            <div class="text-center no-records-body">
                <img alt="Blackbag" src="{{asset('images/nodata.png')}}"
                    class=" h-auto">
                <p>No records found!</p>
            </div>
        </div>
    @endif
</div>

<script>

 function cancelOrder(key){
    swal({
      text: "All devices under this order will be cancelled. Are you sure you want to cancel this order.?",
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
            url: '{{ url("/devices/cancelorder") }}',
            type: "post",
            data: {
                'key': key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                   swal("Order cancelled successfully.");
                    getAppointmentMedicalHistory('devices');
                  
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