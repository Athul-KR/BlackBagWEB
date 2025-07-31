@extends('frontend.master')
@section('title', 'File Cabinet')
@section('content')
<section class="details_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="web-card h-100 mb-3" id="filecabinetpatients">
                    @include('frontend.filecabinet.files')
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function showFiles(key){
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        showPreloader("filecabinetpatients");
        $.ajax({
            url: '{{ url("/patients/getfiles") }}',
            type: "post",
            data: {
                'key' : key,
                'patientID': patientID,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    const newUrl = "{{ url('/filecabinet') }}/"+key+"/files";
                    window.history.pushState({ key: key }, "", newUrl);
                    $("#filecabinetpatients").html(data.view);
                } else {
                    swal("error!", data.message, "error");
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        });
    }
    function showFolders(){
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        showPreloader("filecabinetpatients");
        $.ajax({
            url: '{{ url("/patients/getfolders") }}',
            type: "post",
            data: {
                'patientID' : patientID,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#filecabinetpatients").html(data.view);
                } else {
                    swal("error!", data.message, "error");
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        });
    }
</script>
@endsection()