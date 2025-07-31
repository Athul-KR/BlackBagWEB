@extends('layouts.app')
@section('title', 'Appointment')
@section('content')
  <?php
    $corefunctions = new \App\customclasses\Corefunctions;
  ?>
  <section id="content-wrapper">
    <div class="container-fluid p-0">
      @include('appointment.appenddetails')
    </div>
  <section>

  <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
  <script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
  <script>
    function toggleVideoCallDetails(id) {
      var detailsDiv = $("#details_" + id);

      // Construct dynamic ID
      var dynamicId = "arrow_btn_rot" + id;

      // Remove 'active' class and reset IDs from all buttons
      $(".arrow_btn").removeClass("active");



      if (detailsDiv.is(":visible")) {
        detailsDiv.slideUp(300);
      } else {
        // Add 'active' class to the current button
        $("#" + dynamicId).addClass("active");

        $(".appointment-details").slideUp(300);
        detailsDiv.slideDown(300);
        if (!detailsDiv.data('loaded')) {
          $.ajax({
            url: '{{ url("/appointments/fetchvideocalldetails") }}',
            type: "post",
            data: {
              'id': id,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                  $("#appendvideocalldetails_" + id).html(data.view);
                  detailsDiv.data('loaded', true);
                }
            },
            error: function(xhr) {
               
              handleError(xhr);
            }
          });
        }
      }
    }
  </script>
@stop