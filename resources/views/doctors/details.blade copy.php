@extends('layouts.app')
@section('title', 'Doctor')
@section('content')


<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12 mb-3">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="{{route('doctor.list')}}" class="primary">Doctors</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Doctor Details</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-8 col-12  mb-3">
                <div class="web-card h-100 mb-3 overflow-hidden">
                    <div class="profileData doctorData">
                        <div class="row align-items-end h-100">
                            <div class="col-lg-5 col-xl-3">
                                <div class="user_details text-start">
                                    <img @if($doctorDetails['logo_path'] !='') src="{{asset($doctorDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                                    <h5 class="fw-medium dark mb-0">{{$doctorDetails['name']}}</h5>
                                  
                                    <p class="fw-middle mb-0">{{$doctorDetails['email']}}</p>
                                    <p class="fw-middle mb-0">@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif {{$doctorDetails['phone_number']}}</p>
                                </div>
                            </div>
                            <div class="col-lg-7 col-xl-9">
                                <div class="d-flex justify-content-center justify-content-lg-end">

                                    <div class="btn_alignbox">
                                        <a id="emailButton" class="btn btn-outline d-flex align-items-center justify-content-center gap-2"><span class="material-symbols-outlined"> mail </span>Email</a>

                                        <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end mt-1">
                                            <li><a onclick="editDoctor('{{$doctorDetails['clinic_user_uuid']}}')" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                            <li><a onclick="deactivateDoctor('{{$doctorDetails['clinic_user_uuid']}}','deactivate')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Delete</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="detailsList cardList">
                        <h5 class="fw-medium">Details</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Specialties</h6>
                            <p>@if(isset($doctorDetails['doctor_specialty']['specialty_name'])) {{$doctorDetails['doctor_specialty']['specialty_name']}} @else -- @endif</p>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Designation</h6>


                            <p>{{$designation}}</p>


                        </div>
                        <!-- <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Phone Number</h6>
                            <p>(310) 926-7131</p>
                        </div> -->
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Status</h6>
                            @if ($doctorDetails['status'] == 1)
                            <div class="avilable-icon">
                                <span></span>Available
                            </div>
                            @else
                            <div class="notavilable-icon">
                                <span></span>Not Available
                            </div>
                            @endif
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
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link online active" id="pills-home-tab" onclick="getAppointments('online','upcoming','{{$doctorDetails['clinic_user_uuid']}}')"  role="tab" aria-controls="pills-home" aria-selected="true">Online Appointments</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link offline" id="pills-profile-tab" onclick="getAppointments('offline','upcoming','{{$doctorDetails['clinic_user_uuid']}}')"  role="tab" aria-controls="pills-profile" aria-selected="false">In-person Appointments</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="appointments" role="tabpanel" aria-labelledby="pills-home-tab">
                                        <!-- <div class="col-12 my-3">
                                            <div class="tab_box">
                                                <a href="" class="btn btn-tab active">Reception Room</a>
                                                <a href="" class="btn btn-tab">Upcoming</a>
                                                <a href="" class="btn btn-tab">Expired</a>
                                                <a href="" class="btn btn-tab">All</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 my-3">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-white text-start w-100">
                                                    <thead>
                                                        <tr>
                                                            <th>Room ID</th>
                                                            <th>Attending Nurse</th>
                                                            <th>Appointment Date & Time</th>
                                                            <th>Booked On</th>
                                                            <th class="text-end">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                     @if(!empty($appointmentDetails['data']))
                                                     @foreach($appointmentDetails['data'] as $pl)
                                                        <tr>
                                                            <td>DOC-12122</td>
                                                            <td>
                                                                <div class="user_inner">
                                                                    <img src="{{asset('images/patient3.png')}}">
                                                                    <div class="user_info">
                                                                        <a href="patientdetails.html">
                                                                            <h6 class="primary fw-medium m-0">Rudy Macane</h6>
                                                                            <p class="m-0">rudymc@gmail.com</p>
                                                                        </a>

                                                                    </div>
                                                                </div>
                                                            </td>

                                                            <td>Jun 13 2024, 10:30 AM</td>
                                                            <td>Jun 07 2024, 03:34 AM</td>
                                                            <td class="text-end">
                                                                <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                                                    <a class="btn opt-btn border-0" href=""><img src="{{asset('images/vediocam.png')}}"></a>
                                                                    <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="{{asset('images/file_alt.png')}}"></a>
                                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span class="material-symbols-outlined">more_vert</span></a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                     @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="row">
                                             @if(!empty($appointmentDetails['data']))
                                                <div class="col-md-6">
                                                <form method="GET" action="">
                                                    <div class="sort-sec">
                                                        <p class="me-2 mb-0">Displaying per page :</p>
                                                        <select class="form-select" aria-label="Default select example" name="limit" onchange="this.form.submit()">
                                                            <option selected="">10</option>
                                                            <option value="1">9</option>
                                                            <option value="2">8</option>
                                                        </select>
                                                    </div>
                                                    <form>
                                                </div>
                                                @endif
                                                <div class="col-md-6">
                                                        
                                                
                                                   
                                                </div>
                                            </div>
                                        </div> -->
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
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
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
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                                        <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
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
        //     const recipientEmail = '{{$doctorDetails['email']}}';
        //     const subject = 'Your Subject Here';
        //     const body = 'Your message here...';

        //     // Open Gmail with prefilled fields
        //     const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${recipientEmail}&su=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
        //     window.open(gmailUrl, '_blank'); // Opens in a new tab
        // });

        $('#emailButton').click(function() {
            
            const recipientEmail = '{{$doctorDetails['email']}}';
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
                    swal("Success!", response.message, "success").then(() => {
                        window.location.reload();
                    });
                } else {
                    swal("Error!", response.message, "error");
                }
            }).catch(xhr => {
                if (xhr.status == 419) {
                    window.location.reload(); // Token expired
                } else {
                    swal("Error!", "An error occurred. Please try again.", "error");
                }
            });
        }
    });
}

function editDoctor(key) {
    $("#editDoctor_modal").modal('show');
    showPreloader('editDoctor')
    $.ajax({
      url: '{{ url("/doctors/edit") }}',
      type: "post",
      data: {
        'key' : key ,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#editDoctor").html(data.view);
        }
      }
    });
  }
    $(document).ready(function() {
        var key = '{{$doctorDetails['clinic_user_uuid']}}' ;

        // Retrieve `status` and `type` from URL, with defaults if not present
        var status = '{{ request()->get('status', 'reception') }}';
        var type = '{{ request()->get('type', 'online') }}';
    
        getAppointments(type, status,key);

    });
//Function to show the appointments, online and offline in view page
    function getAppointments(type, status,consultantKey, page = 1,) {
        const limit = $('#pagelimit').val(); // Get the selected limit value

        if(type == 'offline'){
            $('.online').removeClass('active');
            $('.offline').addClass('active');
        }else{
            $('.online').addClass('active');
            $('.offline').removeClass('active');
        }
        showPreloader('appointments');
        $.ajax({
            type: "POST",
            url: '{{ url("/doctors/appointmentlist") }}',
            data: {
                "type": type,
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
                        getAppointments(type, status, consultantKey, newPage);
                    });
                }
             
            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.error('AJAX Error: ' + status + ': ' + error);
            },
        })
    }


</script>




@stop