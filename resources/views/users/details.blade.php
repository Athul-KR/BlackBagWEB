@extends('layouts.app')
@section('title', 'Doctor')
@section('content')
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>

<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12 mb-3">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="{{url('/users')}}" class="primary">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12  mb-3">
                <div class="web-card user-card h-auto mb-3 p-0 details-innercard">
                    {{-- <img class="banner-img" src="{{asset('images/doc_bg.png')}}" alt="banner img"> --}}
                    <div class="profileData view_profile">
                        <div class="row row align-items-center">
                            <div class="col-xl-8 col-12">
                                <div class="d-flex flex-xl-row flex-column align-items-center"> 
                                    <div class="text-lg-start text-center pe-3">
                                        <img @if($clinicUserDetails['logo_path'] !='') src="{{asset($clinicUserDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="user-img">
                                    </div>
                                    <div class="user_details text-xl-start text-center pe-xl-4">
                                        <div class="innercard-info justify-content-center justify-content-xl-start mb-1"> 
                                            <h5 class="fw-medium dark mb-0">@if($clinicUserDetails['user_type_id'] == '1' || $clinicUserDetails['user_type_id'] == '2') {{$corefunctions -> showClinicanName($clinicUserDetails,1)}} @else {{$clinicUserDetails['first_name']}} {{$clinicUserDetails['last_name']}} @endif</h5>
                                        </div>
                                        <div class="innercard-info"> 
                                            <p class="m-0">@if(isset($clinicUserDetails['doctor_specialty']['specialty_name'])) {{$clinicUserDetails['doctor_specialty']['specialty_name']}} @else -- @endif</p>
                                        </div>
                                        <div class="innercard-info"> 
                                            @if($clinicUserDetails['user_type_id'] == '3' ) <small class="pe-2 border-right mb-1">{{$clinicUserDetails['department']}}</small> @endif
                                            <small class="mb-1">
                                                @if ($clinicUserDetails['status'] == 1)
                                                <div class="avilable-icon">
                                                    <span></span>Available
                                                </div>
                                                @else
                                                <div class="notavilable-icon">
                                                    <span></span>Not Available
                                                </div>
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    <div class="user_details text-start border-left border-right px-4"> 
                                      
                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">mail</i>
                                            <small>{{$clinicUserDetails['email']}}</small>
                                        </div>
                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">call</i>
                                            <small>@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif <?php echo $corefunctions->formatPhone($clinicUserDetails['phone_number']) ?></small>
                                        </div>

                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">info</i>
                                            <small>{{$clinicUserDetails['clinic_code']}}</small>
                                        </div>

                                    </div>
                                </div>

    
                            </div>
                            <div class="col-xl-4 col-12">
                               
                                    <div class="btn_alignbox justify-content-center justify-content-xl-end w-100 mt-xl-0 mt-3">
                                        <a id="emailButton" class="btn btn-outline d-flex align-items-center justify-content-center gap-2"><span class="material-symbols-outlined"> mail </span>Email</a>
                                        
                                        @if(session()->get('user.userType') != 'nurse')
                                        <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end mt-1">
                                            <li><a onclick="editDoctor('{{$clinicUserDetails['clinic_user_uuid']}}')" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                            @if( Session::get('user.clinicuser_uuid') != $clinicUserDetails['clinic_user_uuid'] )
                                            <li><a onclick="deactivateDoctor('{{$clinicUserDetails['clinic_user_uuid']}}','deactivate')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Deactivate</a></li>
                                            @endif
                                        </ul>
                                        @endif
                                    </div>
                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-xl-5 mb-3 order-1 order-xl-0">
                <div class="web-card h-100">
                    <div class="row align-items-center">
                        <div class="col-sm-8 text-center text-sm-start">
                            <h4 class="mb-md-0">Appointment Records</h4>
                        </div>
                        <div class="col-sm-4 text-center text-sm-end">
                            <!-- <a href="" class="btn btn-primary">Create Appointment</a> -->
                        </div>



                        <div class="col-lg-12 my-3">
                            <div class="col-12">
                                <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link appointments active" id="pills-home-tab" onclick="getDoctorAppointments('open','{{$clinicUserDetails['clinic_user_uuid']}}')"  role="tab" aria-controls="pills-home" aria-selected="true">Appointments</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="pills-home-tab">
                                       
                                    </div>

                                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                        <div class="col-12 my-3">
                                            <div class="tab_box">

                                                <a href="" class="btn btn-tab active">Upcoming</a>
                                                <a href="" class="btn btn-tab">Expired</a>
                                                <a href="" class="btn btn-tab">All</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 my-3">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-white text-start w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Patient</th>
                                                            <th>Age</th>
                                                            <th>Appointment Date & Time</th>
                                                            <th>Booked On</th>
                                                            <th class="text-end">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>



                                                            <td>
                                                                <div class="user_inner">
                                                                    <img src="{{asset('images/johon_doe.png')}}">
                                                                    <div class="user_info">
                                                                        <a href="patientdetails.html">
                                                                            <h6 class="primary fw-medium m-0">John Doe</h6>
                                                                            <p class="m-0">johndoe@gmail.com</p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>32</td>
                                                            <td>Jun 13 2024, 10:30 AM</td>
                                                            <td>Jun 07 2024, 03:34 AM</td>
                                                            <td class="text-end">
                                                                <div class="d-flex align-items-center justify-content-end btn_alignbox">

                                                                    <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="{{asset('images/file_alt.png')}}"></a>
                                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span class="material-symbols-outlined">more_vert</span></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>


                                                            <td>
                                                                <div class="user_inner">
                                                                    <img src="{{asset('images/patient2.png')}}">
                                                                    <div class="user_info">
                                                                        <a href="patientdetails.html">
                                                                            <h6 class="primary fw-medium m-0">Justin Taylor</h6>
                                                                            <p class="m-0">justintay@gmail.com</p>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>41</td>
                                                            <td>Jun 13 2024, 11:30 PM</td>
                                                            <td>Jun 05 2024, 11:12 PM</td>
                                                            <td class="text-end">
                                                                <div class="d-flex align-items-center justify-content-end btn_alignbox">

                                                                    <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="{{asset('images/file_alt.png')}}"></a>
                                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span class="material-symbols-outlined">more_vert</span></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="sort-sec">
                                                        <p class="me-2 mb-0">Displaying per page :</p>
                                                        <select class="form-select" aria-label="Default select example">
                                                            <option selected="">10</option>
                                                            <option value="1">9</option>
                                                            <option value="2">8</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <nav aria-label="Page navigation example">
                                                        <ul class="pagination">
                                                            <li class="page-item">
                                                                <a class="page-link" href="#" aria-label="Previous">
                                                                    <i class="fa-solid fa-angle-left"></i>
                                                                    Previous
                                                                </a>
                                                            </li>
                                                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                                                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                                                            <li class="page-item">
                                                                <a class="page-link" href="#" aria-label="Next">
                                                                    Next
                                                                    <i class="fa-solid fa-angle-right"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </nav>
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

            <!-- <div class="col-xl-4 col-12 mb-xl-5 mb-3 order-0 order-xl-1">
                <div class="web-card h-100 ">
                    <div class="detailsList cardList">
                        <h5 class="fw-medium">Availability</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Sunday</h6>
                            <p>Not Available</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Monday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Tuesday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Wednesday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Thursday</h6>
                            <p>Not Available</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Friday</h6>
                            <p>9:30 AM – 11:30 PM</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Saturday</h6>
                            <p>Not Available</p>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
    </div>
</section>



<!-- edit Doctor Modal -->
<div class="modal login-modal fade" id="editDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editDoctor"></div>
    </div>
  </div>
</div>

<script>
        // $('#emailButton').click(function() {
        //     const recipientEmail = '{{$clinicUserDetails['email']}}';
        //     const subject = 'Your Subject Here';
        //     const body = 'Your message here...';

        //     // Open Gmail with prefilled fields
        //     const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${recipientEmail}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        //     window.open(gmailUrl, '_blank'); // Opens in a new tab
        // });

        $('#emailButton').click(function() {
            
            const recipientEmail = '{{$clinicUserDetails['email']}}';
            const subject = 'Your Subject Here';
            const body = 'Your message here...';

            // Open the email client with mailto link
            window.location.href = `mailto:${recipientEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        });
    
    function deactivateDoctor(key, status) {
        swal({
        text: "Are you sure you want to " + status + " this doctor?",
            // text: status !,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "OK",
                    value: true,
                    closeModal: false // Keeps the modal open until AJAX is done
                }
            },
            dangerMode: true
        }).then((willConfirm) => {
            if (willConfirm) {
                // AJAX call only runs if confirmed
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/doctors/delete') }}",
                    data: {
                        'key': key,
                        'status': status,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).then(response => {
                    if (response.success == 1) {

                        swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            window.location.href = "{{url('users')}}"
                        });

                    
                    } else {
                        swal("Error!", response.message, "error");
                    }
                }).catch(xhr => {
                    handleError(xhr);
                });
            }
        });
    }

    function editDoctor(key) {
        $("#editDoctor_modal").modal('show');
        showPreloader('editDoctor');
        $.ajax({
            url: '{{ url("/users/edit") }}',
            type: "post",
            data: {
                'key' : key ,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#editDoctor").html(data.view);
                    $('input').each(function() {
                        toggleLabel(this);
                    });
                }
            },
            error: function(xhr) {
                handleError(xhr);
            }
        });
    }
    $(document).ready(function() {
        var key = '{{$clinicUserDetails['clinic_user_uuid']}}' ;

        // Retrieve `status` and `type` from URL, with defaults if not present
        var status = '{{ request()->get('status', 'open') }}';
        var type = '{{ request()->get('type', 'online') }}';
    
        getDoctorAppointments(status,key);

    });
//Function to show the appointments, online and offline in view page
    function getDoctorAppointments(status,consultantKey, page = 1,) {
        const limit = $('#pagelimit').val(); // Get the selected limit value
        showPreloader('appointments');
        $.ajax({
            type: "POST",
            url: '{{ url("/doctors/appointmentlist") }}',
            data: {
                'status': status,
                'limit' : limit,
                'page': page,
                'consultantKey' : consultantKey,
                '_token': $('meta[name="csrf-token"]').attr('content')

            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    $("#appointments").html(response.view);

                    $("#pagination-links").html(response.pagination); // Update pagination links

                    // Attach click event to pagination links
                    $("#pagination-links a").on("click", function(e) {
                        e.preventDefault();
                        const newPage = $(this).attr("href").split("page=")[1];
                        getDoctorAppointments(status, consultantKey, newPage);
                    });
                }
             
            },
            error: function(xhr) {
               
               if (xhr.status == 419) {
                   const response = JSON.parse(xhr.responseText);
                   if (response.message) {
                       // Show an error message to the user
                       swal({
                           icon: 'error',
                           title: 'Session Expired',
                           text: 'Your session has expired. Please log in again'
                       }).then(() => {
                           // Redirect to the login page
                           window.location.reload();
                       });
                   }
               } else {
                   // Handle other errors
                   swal({
                       icon: 'error',
                       title: 'Error',
                       text: xhr.responseText
                   });
               }
           },
        })
    }


</script>




@stop