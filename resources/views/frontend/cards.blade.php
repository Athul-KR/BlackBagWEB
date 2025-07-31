@if(!empty($userCards))
    @foreach ($userCards as $cards)
        <div class="pay-card-sec border rounded-4 p-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap w-100 gap-3">
                <!-- Card Details -->
                <div class="d-flex align-items-center gap-2">
                    @if(isset($type) && $type == 'payment')
                    <div class="form-check">
                        <input class="form-check-input selectedcardcls" type="radio" name="selected_card" id="selected_card_{{ $cards['id'] }}" value="{{ $cards['patient_card_uuid'] }}" @if(isset($cards['is_default']) && ($cards['is_default'] =='1')) checked @endif>
                    </div>
                    @endif 
                    <img src="{{ asset('cards/'.$cards['card_type'].'.svg') }}" class="me-3" style="width: 50px;">
                    <div class="text-start">
                        <h6 class="fwt-bold mb-1">Card Ending In {{$cards['card_num']}}</h6>
                        <small class="fw-middle mb-1">Expiry: {{$cards['expiry']}}</small>
                        <small class="gray fw-middle align_middle justify-content-start mb-0">
                            <span class="material-symbols-outlined">person</span> {{$cards['name_on_card']}}
                        </small>
                    </div>
                </div>

               

              
                <div class="d-flex align-items-center">
                
                    @if( $cards['is_default'] == 0 )
                        @if(isset($type) && $type == 'mycards')
                            <div class="d-flex align-items-center me-4">
                                <small class="gray pe-2">Mark as Primary</small>
                                <input class="form-check-input" value="1" type="radio" name="markasdefault" id="markasdefault" onclick="markAsDefault('{{$cards['patient_card_uuid']}}')" 
                                @if(isset($cards['is_default']) && ($cards['is_default'] =='1')) checked @endif>
                            </div>
                        @endif
                    @else
                        <p class="text-success fw-bold d-flex align-items-center mb-0">
                            <span title="Marked As Default" class="material-symbols-outlined me-1 text-success">verified</span> Primary Card
                        </p>
                    @endif

                    @if($cards['is_default'] == 0 && isset($type) && $type == 'mycards' )
                        <a onclick="removeCard('{{$cards['patient_card_uuid']}}')"  class="dlt-btn btn-align">
                           <span class="material-symbols-outlined">delete</span>
                        </a>
                    @endif
                </div>
               
            </div>
        </div>
    @endforeach
@else
    @if(isset($type) && $type == 'mycards')
    <div class="flex justify-center">
        <div class="text-center no-records-body">
            <img src="{{asset('images/nodata.png')}}"
                class=" h-auto">
            <p>No Cards Added Yet</p>
        </div>
    </div>
    @endif
@endif