

        @if(!empty($devices))
            @foreach($devices as $device)
                <div class="col-12">
                    <div class="border rounded rounded-3 p-3">    
                        <div class="row align-items-center"> 
                            <div class="col-lg-12">                                                                                                                                                                                                  
                            <div class="user_inner tools_inner">
                                <img src="{{ $device['device_image'] }}">
                                <div class="user_info">
                                <h6 class="primary fw-bold mb-1">{{ $device['device'] }}</h6>
                                <p class="m-0 sm-label">{{ $device['category'] }}</p>
                                </div>                                                                                                                                                                           
                            </div>
                            </div>
                        </div> 
                    </div>
                </div> 
            @endforeach
        @endif

