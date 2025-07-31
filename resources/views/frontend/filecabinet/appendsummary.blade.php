@if($fileDets['summarized_data'] != '')
    {{$fileDets['summarized_data']}}
@else
    <div class="d-flex align-items-center justify-content flex-column h-100">
        <img class="preldr-img" src="{!! asset('images/summarizepdf.gif') !!}" alt="Summerized Data">
    </div>
@endif