<div class="row">
    <div class="col-12"> 
        <h4 class="text-start fw-bold">Switch Workspace</h4>
        <hr>
    </div>
    @if( !empty($clinicDetails) )
        @foreach( $clinicDetails as $cd)
            <div class="col-12"> 
                <div class="d-flex justify-content-between border-bottom py-3"> 
                    <div class="user_inner">
                        <div class="image-wrapper">
                            <?php
                                $corefunctions = new \App\customclasses\Corefunctions;
                               
                                $cd['logo_path'] = isset($cd['logo'] ) && $cd['logo'] !='' ? $corefunctions->getAWSFilePath($cd['logo']) : '';
                               
                               
                            ?>

                            <img @if($cd['logo_path'] !='') src="{{ $cd['logo_path'] }}" @else src="{{ asset('images/default_clinic.png')}}" @endif>
                        </div>
                        <div class="user_info">
                            <a href="" class="text-start">
                                <h6 class="primary fw-medium m-0">{{ $cd['name'] }} </h6>
                                
                               
                            </a>
                        </div>
                    </div>
                    <div class="btn_alignbox"> 

                    @if($cd['id'] == Session::get('user.clinicID') )

                        <a class="btn" href="javascript:void(0);">Current Workspace</a>
                    @else
                        <a class="btn btn-primary" onclick="selectTeam('{{$cd['id']}}')">Switch Workspace</a>
                    @endif
                    </div>
                </div>
            </div>
        @endforeach
        @if($patientDetails>0)
    <div class="col-12"> 
                <div class="d-flex justify-content-between border-bottom py-3"> 
                    <div class="user_inner">
                        <div class="image-wrapper">
                            <img src="{{ asset('images/patient_portal.png')}}">
                        </div>
                        <div class="user_info">
                            <a href="" class="text-start">
                                <h6 class="primary fw-medium m-0">Patient Portal</h6>
                            </a>
                        </div>
                    </div>
                    <div class="btn_alignbox"> 

                    @if(Session::get('user.userType') == 'patient' )

                        <a class="btn" href="javascript:void(0);">Current</a>
                    @else
                         <a class="btn btn-primary" onclick="selectPatient()">Switch</a>
                    @endif
                    </div>
                </div>
            </div>
             
        @endif
    @else
        <div class="col-12"> 
            <p class="mb-0">No Team found</p>
        </div>
    @endif
</div>