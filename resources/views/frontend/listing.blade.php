@extends('layouts.app')
@section('title', 'Appointment')
@section('content')


<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-lg-12">
        <div class="row">

          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row align-items-center">

                <div class="col-sm-5 text-center text-sm-start">
                  <h4 class="mb-md-0">Appointments</h4>
                </div>
                <div class="col-sm-7 text-center text-sm-end">
                  <div class="btn_alignbox justify-content-sm-end">
                    <a href="#" id="appointment_create" data-appointment-create-url="{{route('appointment.create')}}" class="btn btn-primary btn-align" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#addAppointment"><span class="material-symbols-outlined">add </span>Create Appointment</a>
                    <!-- <a class="btn filter-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined">filter_list</span>Filters</a> -->
                  </div>
                </div>
                <div class="col-12">
                  <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                      <a class="nav-link {{session()->get('type')=='online' || $type=='online' ? 'active': ''}}" id="pills-home-tab" onclick="online('online','upcoming')" data-url="{{route('appointment.appointmentList')}}" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Online Appointments</a>
                    </li>
                    <li class="nav-item" role="presentation">
                      <a class="nav-link {{session()->get('type')=='offline' || $type=='offline' ? 'active': ''}}" id="pills-profile-tab" onclick="online('offline','upcoming')" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">In-person Appointments</a>
                    </li>
                  </ul>
                  <div class="tab-content" id="pills-tabContent">


                    <!-- Content here Online -->
                    <div id="online-content">

                    </div>



                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


<!-- Appointment Create Modal -->

<div class="modal login-modal fade" id="addAppointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body">
        <div class="text-center">
          <h4 class="text-center fw-medium mb-0">Add New Appointment</h4>
          <small class="gray">Please enter patient details and create an appointment.</small>
        </div>
        <div id="appointment_create_modal">

          <!-- Include the Modal Form here -->

        </div>
      </div>
    </div>
  </div>
</div>







<script>
  $(document).ready(function() {

    var status = "{{ ($status) }}";
    var type = "{{($type)}}";
    console.log(status + type);

    if (status && type) {
      online(type, status);

    } else {
      online('online', 'upcoming');
    }


  });


  //Create appointment Blade View function
  $(document).on("click", "#appointment_create", function() {
    var url = $("#appointment_create").attr("data-appointment-create-url");


    $('#appointment_create_modal').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"  alt="Loader"></div>');

    $.ajax({
      type: "GET",
      url: url,
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },

      success: function(response) {
        // Populate form fields with the details

        if (response.status == 1) {
          $("#appointment_create_modal").html(response.view);
        }
      },
      error: function(xhr) {
        handleError(xhr);
      },
    });
  });



  //Pagination through ajax - pass the url
  $(document).on('click', '.pagination a', function(e) {
    var type = $('#online_type').val();
    var status = $('#online_status').val();
    e.preventDefault();

    const pageUrl = $(this).attr('href');
    const urlObj = new URL(pageUrl); // Create a URL object
    var page = urlObj.searchParams.get('page');

    online(type, status, page);

  });

  //Display per page through ajax - pass the url
  function perPage() {
    var type = $('#online_type').val();
    var status = $('#online_status').val();
    var perPage = $("#perPage").val();
    online(type, status, page = 1, perPage);

  }


  //Listing the appointments based on the  type online and offline
  function online(type, status, page = 1, perPage = 10) {

    var url = $('#pills-home-tab').attr('data-url');

    $('#online-content').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px" alt="Loader"></div>');

    $.ajax({
      type: "get",
      url: url,
      data: {
        "type": type,
        'status': status,
        'page': page,
        'perPage': perPage,

      },
      success: function(response) {
        // Handle the successful response
        $("#online-content").html(response.html);

      },
      error: function(xhr) {
               
        handleError(xhr);
      },
    })
  }
</script>


@endsection()