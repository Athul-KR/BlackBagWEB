@extends('frontend.master')
@section('title', 'File Cabinet')
@section('content')
<section class="details_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="web-card h-100 mb-3" id="appointmentspatients">
                    
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function() {
        showFolders();
    });
    function showFolders(){
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        showPreloader("appointmentspatients");
        $.ajax({
            url: '{{ url("/patients/getfolders") }}',
            type: "post",
            data: {
                'patientID' : patientID,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#appointmentspatients").html(data.view);
                } else {
                    swal("error!", data.message, "error");
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            }
        });
    }
</script>
@endsection()