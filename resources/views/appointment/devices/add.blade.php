
<div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Order Devices</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <div class="row align-row mb-4">
                @if( !empty($rpmDevices) )
                    @foreach( $rpmDevices as $rpm )
                        <div class="col-12 devicecls">
                            <div class="checkbox-container">
                                <div class="form-check">
                                    <label class="form-check-label w-100" for="checkbox_{{$rpm['device_uuid']}}">
                                        <div class="row align-items-center w-100">
                                            <div class="col-lg-8 d-flex align-items-center ps-0">
                                                <div class="d-flex align-items-center gap-3">
                                                    <input class="form-check-input" type="checkbox" id="checkbox_{{$rpm['device_uuid']}}" name="rpmdevices[]" value="{{$rpm['device_uuid']}}">
                                                    <img src="{{asset('/images/rpmdevices/'.$rpm['category'].'.png')}}" alt="Checkbox Image" class="image-device">
                                                    <div class="checkbox-info text-start">
                                                        <p class="primary fw-medium mb-1">{{$rpm['device']}}</p>
                                                        <small>{{$rpm['category']}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 pe-0">
                                                <div class="row text-end">
                                                    <div class="col-7">
                                                        <p class="primary fw-medium mb-1">${{ number_format($rpm['one_time_charge'],2) }}</p>
                                                        <small>One time charge</small>
                                                    </div>
                                                    <div class="col-5">
                                                        <p class="primary fw-medium mb-1">${{ number_format($rpm['per_month_amount'],2) }}</p>
                                                        <small>per month</small>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                    
                    @if( !empty($activeDevices))
                   
                        <div class="col-12">
                            <h4 class="fw-medium mb-0">Currently Using Devices</h4>
                        </div>
                     @foreach( $activeDevices as $act)
                        <div class="col-12">
                            <div class="checkbox-container">
                                <div class="form-check">
                                    <label class="form-check-label w-100" for="checkbox1">
                                        <div class="row align-items-center w-100">
                                            <div class="col-lg-12 d-flex align-items-center ps-0">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img src="{{asset('/images/rpmdevices/'.$act['category'].'.png')}}" alt="Checkbox Image" class="image-device">
                                                    <div class="checkbox-info text-start">
                                                        <p class="primary fw-medium mb-1">{{$act['device']}}</p>
                                                        <small>{{$act['category']}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    @endif
                </div>
                <div class="btn_alignbox">
                    <button type="button" class="btn btn-primary w-100 rpmorderbtn" onclick="placeOrder()" >Place Order</button>
                </div>
