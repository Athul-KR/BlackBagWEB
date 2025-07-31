  <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Selected Devices</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <div class="row align-row mb-4">
                    @if( !empty($rpmDevices))
                    @foreach( $rpmDevices as $rpm)
                    <div class="col-12">
                        <div class="checkbox-container">
                            <div class="form-check">
                                <label class="form-check-label w-100" for="checkbox1">
                                    <div class="row align-items-center w-100">
                                        <div class="col-lg-8 d-flex align-items-center ps-0">
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{asset('/images/rpmdevices/'.$rpm['category'].'.png')}}" alt="Checkbox Image" class="image-device">
                                                <div class="checkbox-info text-start">
                                                    <p class="primary fw-medium mb-1">{{$rpm['device']}}</p>
                                                    <small>{{$rpm['category']}}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" name="rpmdevices[]" value="{{$rpm['device_uuid']}}">
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
                  <div class="col-12">
                        <h5 class="mb-3 fw-medium">Payment  Details</h5>
                        <table class="table payment-table mb-0">
                            <tbody>
                                <tr>
                                    <td><small>One time device charge</small></td>
                                    <td class="text-end"><p class="mb-0 fw-medium">${{ number_format($oneTimeTotal,2) }}</p></td>
                                </tr>
                                <tr>
                                    <td><small>Monthly RPM</small></td>
                                    <td class="text-end">
                                        <p class="mb-0 fw-medium">${{ number_format($perMonthTotal,2) }}</p>
                                        <small class="fst-italic">(Starting from: {{date('m/d/Y')}})</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr class="m-0">
                                    </td>
                               
                                </tr>
                                <tr>
                                    <td><small>Total</small></td>
                                    <td class="text-end"><h5 class="mb-0 fw-medium">${{ number_format($totalAmount,2) }}</h5></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>


                </div>

                <div class="btn_alignbox">
                    <button type="button" class="btn btn-primary w-100 rpmorderbtn"  onclick="confirmOrder()" >Confirm Order</button>
                </div>