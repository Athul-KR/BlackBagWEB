<?php
    $corefunctions = new \App\customclasses\Corefunctions;
?>

<div class="accordion-body">
    <h6 class="fw-medium mb-3">Participants</h6> 
    @if( count($participants) > 0 )
    @foreach($participants as $participant)

    <div class="participant-wrapper"> 
        <div class="row align-items-center">
            <div class="col-md-4 d-flex align-items-center">
                <div class="user_inner">

                <?php
                
                            $logopath = '';
                            if($participant['participant_type'] == 'patient'){
                                $logopath = isset($patientDetails[$participant['participant_id']]['user']['id']) ? $corefunctions->resizeImageAWS($patientDetails[$participant['participant_id']]['user']['id'], $patientDetails[$participant['participant_id']]['user']['profile_image'], $patientDetails[$participant['participant_id']]['user']['first_name'], 180, 180, '1') : '';
                            }else{
                                $logopath = $corefunctions->resizeImageAWS($clinicUserDetails[$participant['participant_id']]['user']['id'], $clinicUserDetails[$participant['participant_id']]['user']['profile_image'], $clinicUserDetails[$participant['participant_id']]['user']['first_name'], 180, 180, '1');
                            }
                            ?>


                    <img alt="Blackbag"  @if($logopath !='') src="{{($logopath)}}" @else src="{{asset('images/default_img.png')}}" @endif>
                    <div class="user_info">
                        <h6 class="primary fw-medium m-0">@if($participant['participant_type'] == 'patient') @if(isset($patientDetails[$participant['participant_id']]['user'])){{ $patientDetails[$participant['participant_id']]['user']['first_name'] }} @else -- @endif @else{{ $corefunctions->showClinicanName($clinicUserDetails[$participant['participant_id']],'1')}}@endif</h6>
                        <p class="m-0">@if($participant['participant_type'] == 'patient')  @if(isset($patientDetails[$participant['participant_id']]['user'])) {{ $patientDetails[$participant['participant_id']]['user']['email'] }} @endif @else{{ $clinicUserDetails[$participant['participant_id']]['user']['email'] }}@endif</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="collaspe-info">
                    <small class="fw-light">Role:</small>
                    <p class="fw-medium primary">@if($participant['participant_type'] == 'clinics') Clinician @else {{ ucfirst($participant['participant_type']) }} @endif</p>
                </div>

            </div>
            <div class="col-md-4">
                <div class="collaspe-info">
                    <small class="fw-light">Duration:</small>
                    <p class="fw-medium primary"> @if($participant['total_duration'] > 0)
                                @php
                                    $totalSeconds = $participant['total_duration'];
                                    $hours = intdiv($totalSeconds, 3600);
                                    $minutes = round(($totalSeconds % 3600) / 60); // Rounded minutes
                                @endphp

                                @if($hours > 0)
                                    {{ $hours }} {{ $hours > 1 ? 'hours' : 'hour' }}
                                @endif

                                @if($minutes > 0)
                                    {{ $hours > 0 ? ' and ' : '' }} {{ $minutes }} {{ $minutes > 1 ? 'minutes' : 'minute' }}
                                @endif
                            @else
                                --
                            @endif</p>
                </div>
                
            </div>
        </div>
    </div>

    @endforeach
    @else
        <div class="flex justify-center">
            <div class="text-center no-records-body">
                <img alt="Blackbag" src="{{asset('images/nodata.png')}}" class="h-auto">
                <p>No participants found</p>
            </div>
        </div>
    @endif

</div>
 
                                                    
    