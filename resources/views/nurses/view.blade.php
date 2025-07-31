@extends('layouts.app')
@section('title', 'Nurse List')
@section('content')

<?php $Corefunctions = new \App\customclasses\Corefunctions; ?>
<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12 mb-3">
                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                        <li class="breadcrumb-item"><a href="{{route('nurse.list')}}" class="primary">Users</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Details</li>
                    </ol>
                </nav>
            </div>

            <div class="col-lg-12 col-12  mb-3">
                <div class="web-card user-card h-auto mb-3 p-0 details-innercard">

                    <!-- <img class="banner-img" src="{{asset('images/nurse_bg.png')}}" alt="banner img"> -->

                    <div class="profileData view_profile">
                        <div class="row align-items-end h-100">
                            <div class="col-12 mb-3"> 
                                <div class="row align-items-center">
                                    <div class="col-xl-8 col-12">
                                        <div class="d-flex flex-xl-row flex-column align-items-center">
                                            <div class="text-lg-start text-center pe-3">
                                                <img src="{{asset($nurse['logo_path'])}}" class="user-img" alt="Nurse img">
                                            </div>
                                            <div class="user_details text-xl-start text-center pe-xl-4">
                                                <div class="innercard-info justify-content-center justify-content-xl-start mb-1">
                                                    <h5 class="fw-medium dark mb-0">{{$nurse->name}}</h5>
                                                </div>
                                                <div class="innercard-info">
                                                    <div class="d-flex justify-content-xl-between justify-content-center w-100">
                                                        <p class="m-0">{{ optional($nurse->doctorSpecialty)->specialty_name ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                <div class="innercard-info">
                                                    <small class="pe-2 border-right mb-1">{{$nurse->department}}</small>
                                                    <small class="mb-1">
                                                        @if ($nurse->status == 1)
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
                                                    <small>{{$nurse->email}}</small>
                                                </div>
                                                <div class="innercard-info mb-2">
                                                    <i class="material-symbols-outlined">call</i>
                                                    <small>{{$countryCode->country_code}} <?php echo $Corefunctions->formatPhone($nurse->phone_number) ?></small>
                                                </div>
                                                <!-- <div class="innercard-info align-items-start">
                                                    <div class="d-flex justify-content-between">
                                                        <h6 class="fw-medium">Specialities</h6>
                                                        <p>{{ optional($nurse->doctorSpecialty)->specialty_name ?? 'N/A' }}</p>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-12">
                                    
                                            <div class="btn_alignbox justify-content-center justify-content-lg-end w-100 mt-xl-0 mt-3">
                                                <a href="{{'mailto:'. $nurse['email'] }}" class="btn btn-icon align_middle"><span class="material-symbols-outlined"> mail </span>Email</a>
                                               
                                                @if(session()->get('user.userType') != 'nurse')
                                                <a class="btn opt-btn"  data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">more_vert</span>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end mt-1">
                                                    <li>
                                                        <a  id="edit-nurse" data-nurseurl="{{route('nurse.edit',[$nurse->clinic_user_uuid,'type'=>'active'])}}" data-bs-toggle="modal"
                                                            data-bs-dismiss="modal" data-bs-target="#addNurse" class=" edit-nurse dropdown-item fw-medium ">
                                                            <i class="fa-solid fa-pen me-2"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                    @if( Session::get('user.clinicuser_uuid') != $nurse->clinic_user_uuid )
                                                    <li>
                                                        <a href="#" id="delete-nurse" data-nurseurl="{{route('nurse.delete',[$nurse->clinic_user_uuid,'type'=>'active'])}}" class="detete-nurse dropdown-item fw-medium">
                                                            <i class=" fa-solid fa-trash-can me-2"></i>
                                                            Deactivate
                                                        </a>
                                                    </li>
                                                    @endif
                                                </ul>
                                                @endif
                                            </div>
                                      
                                    </div>
                                </div>

                                <!-- <div class="text-lg-start text-center">
                                    <img src="{{asset($nurse['logo_path'])}}" class="user-img" alt="Nurse img">
                                </div> -->
                            </div>
                            <!-- <div class="col-lg-4 col-12">
                                <div class="user_details text-start">
                                    <h5 class="fw-medium dark">{{$nurse->name}}</h5>
                                    <p class="fw-middle mb-0">{{$nurse->qualification}}</p>
                                    <p class="fw-middle mb-0">{{$nurse->email}}</p>
                                    <p class="fw-middle mb-0">{{$countryCode->country_code}} {{$nurse->phone_number}}</p>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-4 col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="detailsList cardList">
                        <h5 class="fw-medium">Details</h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Specialities</h6>
                            <p>{{ optional($nurse->doctorSpecialty)->specialty_name ?? 'N/A' }}</p>

                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Department</h6>


                            <p>{{$nurse->department}}</p>


                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Status</h6>
                            @if ($nurse->status == 1)
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
            </div> -->
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
                                        <button class="nav-link active" id="pills-home-tab" onclick="online('open')" data-url="{{route('nurse.appointmentList',[$nurse->clinic_user_uuid])}}" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Appointments</button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="pills-tabContent">
                                    <div id="table-appointments">


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            @php
            
           /* 
            <div class="col-xl-4 col-12 mb-xl-5 mb-3 order-0 order-xl-1">
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
            </div>
            */
            @endphp


        </div>
    </div>
    <!-- </div> -->
</section>



<!-- Nurse Create and Edit Modal -->
<div class="modal login-modal fade" id="addNurse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <!-- <a href="#" class="close-modal" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
            </div>
            <div id="add-nurse-modal" class="modal-body text-center">

                <!-- Appends Blade to this section -->

            </div>
        </div>
    </div>
</div>


<!-- Appointment Edit Modal -->

<div class="modal login-modal fade" id="editAppointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="text-center fw-medium mb-0">Edit Appointment</h4>
                    <small class="gray">Please enter patient details and create an appointment.</small>
                </div>
                <div id="appointment_edit_modal">

                    <!-- Include the Modal Form here -->

                </div>
            </div>
        </div>
    </div>
</div>




<script>
    var loaderGifUrl = "{{ asset('images/loader.gif') }}";
</script>
<!-- Edit Nurse -->
<script src="{{asset('js/nurseEdit.js')}}"></script>
<!-- Nurse Delete -->
<script src="{{asset('js/nurseDeleteActivate.js')}}"></script>
<script>
    $(document).ready(function() {

        var status = "{{ ($status) }}";

        if (status) {
            online(status);

        } else {
            online('open');
        }

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


    //Function to show the appointments, online and offline in view page
    function online(status, page = 1) {

        var url = $('#pills-home-tab').attr('data-url');
        console.log(status);
        console.log(url);
        $('#table-appointments').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');
        $.ajax({
            type: "get",
            url: url,
            data: {
                'status': status,
                'page': page

            },
            success: function(response) {
                // Handle the successful response
                $("#table-appointments").html(response.html);

            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        })
    }
</script>

@endsection