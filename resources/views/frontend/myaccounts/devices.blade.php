 <script>
 $(document).ready(function () {
     getDevices('current');
  });   
     function getDevices(type='c'){
            $(".alldevicetabs").removeClass('active');
            $(".devicetabs_"+type).addClass('active');
            showPreloader('devicesTabContent');
             $.ajax({
                type: "POST",
                url: "{{ url('/myaccounts/devices') }}",
                data: {
                    "type":type,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    // Handle the successful response
                    if(response.success == 1){
                        $("#devicesTabContent").html(response.view);

                      
                    }
                },
                error: function(xhr) {
                    // handleError(xhr);
                },
            })
     }

</script>




                                <div class="tab-box-inner">
                                    <ul class="nav nav-pills mb-4 border-0" id="devicesTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active align_middle alldevicetabs devicetabs_current" onclick="getDevices('current')" type="button" role="tab"><span class="material-symbols-outlined">browse_activity</span>Current Devices</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link align_middle alldevicetabs devicetabs_pending" onclick="getDevices('pending')"><span class="material-symbols-outlined">hourglass_bottom</span>Pending Orders @if( isset($deviceOrdersCount) && $deviceOrdersCount > 0)<span class="badge bg-dark ms-1 rounded-count pendingdevicetabcount">{{$deviceOrdersCount}}</span>@endif</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link align_middle alldevicetabs devicetabs_rejected" onclick="getDevices('rejected')" type="button" role="tab"><span class="material-symbols-outlined">block</span>Rejected</button>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Tab Content -->
                                <div class="tab-content" id="devicesTabContent">
                                    
                                  
                                 
                                </div>