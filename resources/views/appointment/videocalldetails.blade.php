<?php
    $corefunctions = new \App\customclasses\Corefunctions;
?>
<div class="table-responsive min-h-auto card-table inner-tb mb-3">
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Duration</th>
            <th>Start Time</th>
            <th>End Time</th>
        </tr>
    </thead>
    <tbody>
        @if(!empty($videocall))
        <tr>
            <td>
                @if($videocall->duration > 0 && $videocall->duration != '' )
                    @php
                        $totalSeconds = $videocall->duration;
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
                @endif
            </td>
            <td>@if(isset($videocall->call_started) && $videocall->call_started != '') <?php echo $corefunctions->timezoneChange($videocall->call_started,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($videocall->call_started,'h:i A','0') ?> @else -- @endif</td>
            <td>@if(isset($videocall->call_ended) && $videocall->call_ended != '') <?php echo $corefunctions->timezoneChange($videocall->call_ended,"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($videocall->call_ended,'h:i A','0') ?> @else -- @endif</td>
        </tr>
        <!-- Participants Row -->
        <tr>
            <td colspan="4">
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Participant Name</th>
                            <th>Type</th>
                            <th class="text-end">Duration</th>
                            <!-- <th>Start Time</th>
                            <th>End Time</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($participants) )
                            @foreach($participants as $participant)
                            <tr>
                                @if($participant['participant_type'] == 'patient')
                                        <td>{{ $patientDetails[$participant['participant_id']]['user']['first_name'] }}</td>
                                        @else
                                        <td>{{ $corefunctions -> showClinicanName($clinicUserDetails[$participant['participant_id']],'1');}}</td>
                                        
                                        @endif
                                <td>@if($participant['participant_type'] == 'clinics') Clinician @else {{ ucfirst($participant['participant_type']) }} @endif</td>
                                <td class="text-end">
                                    @if($participant['total_duration'] > 0)
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
                                        @endif

                                    <!-- @if(isset($participant['initiated']) && $participant['initiated'] != '' && isset($participant['completed']) && $participant['completed'] != '') 
                                        @php
                                            $differenceInMinutes = intdiv(abs($participant['completed'] - $participant['initiated']), 60);
                                        @endphp

                                        @if($differenceInMinutes >= 60)
                                            @php
                                                $hours = intdiv($differenceInMinutes, 60);
                                                $minutes = $differenceInMinutes % 60;
                                            @endphp

                                            {{ $hours }} {{ $hours > 1 ? 'hours' : 'hour' }} 
                                            @if($minutes > 0)
                                                and {{ $minutes }} {{ $minutes > 1 ? 'minutes' : 'minute' }}
                                            @endif
                                        @else
                                            {{ $differenceInMinutes }} {{ $differenceInMinutes > 1 ? 'minutes' : 'minute' }}
                                        @endif
                                    @else -- @endif -->
                                </td>
                                <!-- <td>@if(isset($participant['initiated']) && $participant['initiated'] != '' && $participant['is_reject'] == '0') <?php echo $corefunctions->timezoneChange($participant['initiated'],"M d, Y",'0') ?> |  <?php echo $corefunctions->timezoneChange($participant['initiated'],'h:i A','0') ?> @else -- @endif</td>
                            <td>@if(isset($participant['completed']) && $participant['completed'] != ''  && $participant['is_reject'] == '0') <?php echo $corefunctions->timezoneChange($participant['completed'],"M d, Y",'0') ?> | <?php echo $corefunctions->timezoneChange($participant['completed'],'h:i A','0') ?> @else -- @endif</td> -->
                            </tr>
                            @endforeach
                        @else
                        <tr>
                            <td colspan="5" class="text-center" style="background: #f4f4f4 !important;">
                                <div class="flex justify-center">
                                    <div class="text-center  no-records-body">
                                        <img alt="Blackbag" src="{{asset('images/nodata.png')}}"
                                            class=" h-auto">
                                        <p>No records found</p>
                                    </div>
                                </div>
                            </td>
                           
                        </tr>
                        @endif
                    </tbody>
                </table>
            </td>
        </tr>
        @else
        <tr>
            <td colspan="5" class="text-center" style="background: #f4f4f4 !important;">No video call data available.</td>
        </tr>
        @endif
    </tbody>
</table>
</div>