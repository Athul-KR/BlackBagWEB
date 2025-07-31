@foreach($appointmentNotes as $apn)
<div>
    <span>{{\Carbon\Carbon::parse($apn->created_at)->setTimezone($userTimeZone)->format('h:i A')}}, {{\Carbon\Carbon::parse($apn->created_at)->setTimezone($userTimeZone)->format('m/d/Y')}}</span>
    <p>{{$apn->notes}}</p>
</div>
@endforeach