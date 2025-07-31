@if(!empty($medicathistoryDetails))
   
        <form method="POST" id="editimmunizationform" autocomplete="off">
        @csrf
            <div class="row align-items-center"> 
                <div class="col-md-10"> 
                    <div class="row"> 
                        <div class="col-md-12"> 
                            <div class="form-group form-floating">
                                <select class="form-select valcls" name="immunizations[0][immunization]" >
                                    <option disabled="" selected="">Select Vaccine</option>
                                    @if(!empty($immunizationTypes))
                                        @foreach($immunizationTypes as $imt)
                                            <option value="{{$imt['id']}}" @if($imt['id'] == $medicathistoryDetails['immunizationtype_id']) selected @endif>{{$imt['immunization_type']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <label class="select-label">Vaccine</label>
                            </div>
                        </div>
                        <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                        <input type="hidden" name="hasvalue" id="hasvalue" />
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="btn_alignbox justify-content-end mt-md-0 mt-3">
                        <a class="opt-btn" onclick="updateImmunization('immunizations','{{$medicathistoryDetails['immunization_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('immunizations')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                    </div>
                </div>
            </div>
        </form>
 
@endif
<script>
    $(document).ready(function () {
        hasFormValue();
    });
</script>

