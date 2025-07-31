@extends('layouts.app')
@section('title', 'Appointment')
@section('content')
  <?php
    $corefunctions = new \App\customclasses\Corefunctions;
  ?>
  <section id="content-wrapper">
    <div class="container-fluid p-0">
          <div class="col-12 mb-3">
              <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                  <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                      <li class="breadcrumb-item"><a href="{{url('appointments')}}" class="primary">Appointments</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Appointment Details</li>
                  </ol>
                  </nav>
          </div>


      @include('appointment.appenddetails_clinic')
    </div>
  </section>

  <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
  <script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
  <script>
    function appendVideoCallDetails(id) {
        var contentId = "#appendvideocalldetails_" + id;
        var dynamicId = "#arrow_btn_rot" + id;

        // Close all other accordions except the clicked one
        $(".accordion-collapse").not(contentId).collapse('hide');

        // Toggle the clicked accordion
        $(contentId).collapse('toggle');

        // Remove "active" class from all dropdown buttons except the clicked one
        $(".drop-down-btn").not(dynamicId).removeClass("active");

        // Toggle the active class on the clicked button
        if ($(contentId).hasClass("show")) {
            $(dynamicId).removeClass("active");
        } else {
            $(dynamicId).addClass("active");
        }

        // AJAX request to fetch video call details
        $.ajax({
            url: '{{ url("/appointments/getvideocalldetails") }}',
            type: "post",
            data: {
                'id': id,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $(contentId).html(data.view);
                }
            },
            error: function(xhr) {
                handleError(xhr);
            }
        });
    }
  </script>
@stop