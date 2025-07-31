@extends('layouts.app')
@section('title', 'Doctor')
@section('content')
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>

<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12 mb-3 editprofile"  style="display: none;">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="javascript:void(0)" class="primary">My Account</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)" class="primary">Edit Profile</li>
                    </ol>
                </nav>
            </div>

            <div class="col-12  mb-3" style="display:none">
                <div class="web-card user-card h-auto mb-3 p-0 details-innercard">
                    {{-- <img class="banner-img" src="{{asset('images/doc_bg.png')}}" alt="banner img"> --}}
                    <div class="profileData view_profile">
                        <div class="row row align-items-center">
                            <div class="col-xl-8 col-12">
                                <div class="d-flex flex-xl-row flex-column align-items-center"> 
                                    <div class="text-lg-start text-center pe-3">
                                        <img @if($doctorDetails['logo_path'] !='') src="{{asset($doctorDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="user-img">
                                    </div>
                                    <div class="user_details text-xl-start text-center pe-xl-4">
                                        <div class="innercard-info justify-content-center justify-content-xl-start mb-1"> 
                                            <h5 class="fw-medium dark mb-0">{{$corefunctions -> showClinicanName($doctorDetails,1)}}</h5>
                                        </div>
                                        <div class="innercard-info"> 
                                            <p class="m-0">@if(isset($doctorDetails['doctor_specialty']['specialty_name'])) {{$doctorDetails['doctor_specialty']['specialty_name']}} @else -- @endif</p>
                                        </div>
                                        <div class="innercard-info"> 
                                            <small class="mb-1">
                                                @if ($doctorDetails['status'] == 1)
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
                                            <small>{{$doctorDetails['email']}}</small>
                                        </div>
                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">call</i>
                                            <small>@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif <?php echo $corefunctions->formatPhone($doctorDetails['phone_number']) ?></small>
                                        </div>
                                    </div>
                                </div>

    
                            </div>
                            <div class="col-xl-4 col-12">
                               
                                    <div class="btn_alignbox justify-content-center justify-content-xl-end w-100 mt-xl-0 mt-3">
                                        <a id="emailButton" class="btn btn-icon align_middle"><span class="material-symbols-outlined"> mail </span></a>
                                        <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">more_vert</span>
                                        </a>
                                        <ul class="dropdown-menu dropdown-menu-end mt-1">
                                            <li><a onclick="editDoctor('{{$doctorDetails['clinic_user_uuid']}}')" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                            @if( Session::get('user.clinicuser_uuid') != $doctorDetails['clinic_user_uuid'] )
                                            <li><a onclick="deactivateDoctor('{{$doctorDetails['clinic_user_uuid']}}','deactivate')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Deactivate</a></li>
                                            @endif
                                        </ul>
                                    </div>
                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-xl-5 mb-3 order-1 order-xl-0 ">
                <div class="web-card h-100">
                    <div class="row align-items-center">
                        <div class="col-sm-8 text-center text-sm-start">
                            <h4 class="mb-md-0">My Account</h4>
                        </div>
                        <div class="col-sm-4 text-center text-sm-end">
                            <!-- <a href="" class="btn btn-primary">Create Appointment</a> -->
                        </div>



                        <div class="col-lg-12 my-3">
                            <div class="col-12">
                                <ul class="nav nav-pills mb-4 profiledetails" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link profiledetails navcls" id="pills-profiledetails-tab" onclick="getTabDetails('profiledetails')"  role="tab" aria-controls="pills-home" aria-selected="true">Profile Details</button>
                                    </li>
                                    @if($doctorDetails['is_licensed_practitioner'] == '1')
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link appointments navcls" id="pills-workinghours_details-tab" onclick="tabContent('workinghours_details','{{$doctorDetails['clinic_user_uuid']}}')"  role="tab" aria-controls="pills-home" aria-selected="true">Working Hours</button>
                                    </li>
                                    @endif
                                    @if($doctorDetails['eprescribe_enabled'] == '1')
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link add-ons navcls" id="pills-addons-tab" onclick="getTabDetails('addons')"  role="tab" aria-controls="pills-home" aria-selected="true">Add-ons</button>
                                    </li>
                                    @endif
                                    <!-- <li class="nav-item" role="presentation">
                                        <button class="nav-link appointments navcls" id="pills-home-tab" onclick="getAppointmentsDashboard('open','{{$doctorDetails['clinic_user_uuid']}}')"  role="tab" aria-controls="pills-home" aria-selected="true">Appointments</button>
                                    </li> -->
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade" id="appointments" role="tabpanel" aria-labelledby="pills-home-tab">
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

                                    <div class="tab-pane show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                     
                                       
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

        
    function getTabDetails(type,key='',page=1,userType='',search='') {
       
        $("#pills-profile").show();
        $("#pills-profile").html('<div class="d-flex justify-content-center py-5"><img src="' + '{{ asset('images/loader.gif') }}' + '" width="250px"></div>');
        $.ajax({
            url: '{{ url("/myprofiletabs/") }}/' + type,
            type: "post",
            data: {
                'type': type,
                'key' : key ,
                "page":page,
                "searchterm":search,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    $('.navcls').removeClass('active');
                    $('#pills-'+type+'-tab').addClass('active');
                    $('#pills-profile').html(data.view);
                    if(type == 'workinghours'){
                        // Attach click event to pagination links
                        $("#pagination-links a").on("click", function(e) {
                            e.preventDefault();
                            const newPage = $(this).attr("href").split("page=")[1];
                            tabContent(type, key,newPage);
                        });
                    }
                
                }
            },
            error: function(xhr) {
            
                handleError(xhr);
            }
        });
    }



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
                    swal({
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                        window.location.href = "{{url('users')}}";
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
    showPreloader('editDoctor')
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
        }
      },
      error: function(xhr) {
               
            handleError(xhr);
        }
    });
  }
    $(document).ready(function() {
        var key = '{{$doctorDetails['clinic_user_uuid']}}' ;

        // Retrieve `status` and `type` from URL, with defaults if not present
        var status = '{{ request()->get('status', 'open') }}';
        var type = '{{ request()->get('type', 'online') }}';
        getTabDetails('profiledetails');
        // getAppointmentsDashboard(status,key);

    });
//Function to show the appointments, online and offline in view page
    function getAppointmentsDashboard(status,consultantKey, page = 1,) {
        $("#pills-profile").hide();
        const limit = $('#pagelimit').val(); // Get the selected limit value
        showPreloader('appointments');
        $.ajax({
            type: "POST",
            url: '{{ url("/myprofile/appointmentlist") }}',
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
                    $('.navcls').removeClass('active');
                    $('#pills-home-tab').addClass('active');
                    $("#appointments").html(response.view);
                   
                    $("#pagination-links").html(response.pagination); // Update pagination links

                    // Attach click event to pagination links
                    $("#pagination-links a").on("click", function(e) {
                        e.preventDefault();
                        const newPage = $(this).attr("href").split("page=")[1];
                        getAppointmentsDashboard(status, consultantKey, newPage);
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


    
    function tabContent(type,key='',page=1,userType='',search='') {


        var url = "{{route('clinic.tabContent')}}";
        $("#pills-profile").html('<div class="d-flex justify-content-center py-5"><img src="' + '{{ asset('images/loader.gif') }}' + '" width="250px"></div>');
        $.ajax({
            url: url,
            type: "post",
            data: {
                'pageType' : 'myprofile',
                'type': type,
                'key' : key ,
                "page":page,
                "userType":userType,
                "searchterm":search,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {
                    $('.navcls').removeClass('active');
                    $('#pills-'+type+'-tab').addClass('active');
                    $('#pills-profile').html(data.view);
                    if(type == 'workinghours'){
                    
                        // Attach click event to pagination links
                        $("#pagination-links a").on("click", function(e) {
                            e.preventDefault();
                            const newPage = $(this).attr("href").split("page=")[1];
                            tabContent(type, key,newPage);
                        });
                    }
                
                }
            },
            error: function(xhr) {
            
                handleError(xhr);
            }
        });
        }



</script>




@stop