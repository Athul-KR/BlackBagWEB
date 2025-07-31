@extends('layouts.app')
@section('title', 'Appointment')
@section('content')


<section id="content-wrapper">
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="appointmentToast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <div class="align_middle">
            <span class="material-symbols-outlined success-toast">info</span><p class="mb-0" id="appointmentToastBody"></p>
          </div>
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        <div class="progress-bar-animated"></div>
      </div>
    </div>
  </div>
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-lg-12">
        <div class="row">

          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row align-items-start">

                <div class="col-sm-5 text-center text-sm-start">
                  <h4 class="mb-md-0">Appointments</h4>
                </div>
                <div class="col-sm-7 text-center text-sm-end">
                  <div class="btn_alignbox justify-content-sm-end">
                    @if(session()->get('user.userType') == 'clinics' || session()->get('user.userType') == 'doctor')
                      <a onclick='createAppointment()' id="appointment_create"  class="btn btn-primary btn-align"><span class="material-symbols-outlined">add </span>Create Appointment</a>
                    @endif
                    <a class="btn filter-btn" onclick="getFilter()" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined">filter_list</span>Filters</a>
                  </div>
                  <div id="appointmentfilter" class="collapse-filter">
                    <form id="search" method="GET" autocomplete="off">
                      <div class="row justify-content-end mt-3 align-items-stretch">
                        <div class="col-md-8 d-flex align-items-center">
                          <div class="align_middle w-100"> 
                            <div class="form-group form-outline select-outline w-100">
                              <i class="fa-solid fa-user-tag"></i>
                              <select name="type" id="type" class="form-select" onchange="submitFilter();">
                                <option value="">Appointment Type</option>
                                <option value="online" @if(isset($_GET['type']) && $_GET['type'] == 'online') selected @endif>Online</option>
                                <option value="in-person" @if(isset($_GET['type']) && $_GET['type'] == 'in-person') selected @endif>In-person</option>
                              </select>
                            </div>
                            <div class="btn_alignbox">
                              <button type="button" class="btn btn-outline-primary" onclick="clearFilter();">Clear All</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-12">
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


<script>
  $(document).ready(function() {
    var status = "{{ $status }}";
    if (status) {
      online(status);
    } else {
      online('open');
    }
    <?php if ((isset($_GET['type']) && $_GET['type'] != '')) { ?>
      $("#appointmentfilter").show();
      $("#appointmentfilter").addClass('show')
    <?php }else{ ?>
      $("#appointmentfilter").hide();
      $("#appointmentfilter").removeClass('show')
    <?php } ?>
  });

  //Pagination through ajax - pass the url
  $(document).on('click', '.pagination a', function(e) {
    var status = $('#online_status').val();
    e.preventDefault();

    const pageUrl = $(this).attr('href');
    const urlObj = new URL(pageUrl); // Create a URL object
    var page = urlObj.searchParams.get('page');

    online(status, page);

  });

  function clearFilter() {
    window.location.href = "{{url('/appointments')}}";
  }

  //Display per page through ajax - pass the url
  function perPage() {
    var status = $('#online_status').val();
    var perPage = $("#perPage").val();
    online(status, page = 1, perPage);

  }
  
  function getFilter() {                  
    if ($("#appointmentfilter").hasClass("show")) {
      $("#appointmentfilter").removeClass('show')
      $("#appointmentfilter").hide();
    }else{
      $("#appointmentfilter").show();
      $("#appointmentfilter").addClass('show')
    }
  }
  function submitFilter(){
    let currentStatus = document.getElementById('online_status').value; // Get the current tab status
    let searchForm = document.getElementById('search');
    
    // Append status as a hidden input field
    let statusInput = document.createElement("input");
    statusInput.type = "hidden";
    statusInput.name = "status";
    statusInput.value = currentStatus;

    searchForm.appendChild(statusInput);
    $("#search").submit();
  }

  function fetchAvailableSlots(){
        const selectedDate = $('#appt-date').val();
        const doctorID =  $("#doctor_input").val();
        // const patientID =  $("#patient_input").val();
    
       if(selectedDate == '' || doctorID == ''){
        return ;
       }
        showPreloader('append_timeslots');
        // if($(".slot-btn").length > 0){
        //     $("#timeslotbtn").prop('disabled',false);
        // }else{
        //     $("#timeslotbtn").prop('disabled',true);
        // }

        $.ajax({
            url: '{{ url("fetchavailableslots") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                // patientID: patientID,
                doctorID: doctorID,
                appointmentdate: selectedDate
            },
            success: function(response) {
                if(response.success == 1){
                    $("#append_timeslots").html(response.view);
                }
            },
            error: function(xhr) {
                if(xhr.status != 403){
                    handleError(xhr);
                }
            },
            complete: function() {
                // Reset the flag to allow the request to be sent again
                isRequestProgress = false;
                console.log('Request complete');
            }
        });
    }


</script>


@endsection()