@extends('layouts.app')
@section('title', 'Patient')
@section('content')
  <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore-min.js' type='text/javascript'></script>
<script src="https://cdn.jsdelivr.net/gh/podio/jquery-mentions-input/lib/jquery.elastic.js"></script>
  <link rel="stylesheet" href="{{ asset('css/mentionsInput.css')}}">
    <script src="{{ asset('js/mentionsInput.js') }}"></script>






   
<section id="content-wrapper">
    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
    <div class="container-fluid p-0">
        <div class="row h-100">
        <div class="col-12 mb-3">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                    <li class="breadcrumb-item"><a href="{{url('patients')}}" class="primary">Patients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Patient Details</li>
                </ol>
                </nav>
        </div>

        <div class="col-12 mb-3">
            <div class="web-card user-card h-auto p-0 details-innercard">
                {{-- <img class="banner-img" src="{{asset('images/patient_bg.png')}}" alt="banner img"> --}}
                <div class="profileData view_profile">
                    <div class="row align-items-end h-100">
                        <div class="col-12">
                            <div class="row align-items-center">
                                <div class="col-xl-4 col-12"> 
                                    <div class="d-flex flex-xl-row flex-column align-items-center"> 
                                        <div class="text-lg-start text-center pe-3">
                                            <img src="{{$patientDetails['logo_path']}}" class="user-img" alt="patient img">
                                        </div>
                                        <div class="user_details text-xl-start text-center pe-xl-4">
                                            <div class="innercard-info justify-content-center justify-content-xl-start mb-xl-1 my-xl-0 my-3">
                                                <div class="d-flex align-items-center flex-wrap gap-2">
                                                    <?php $name = $patientDetails['first_name']. (isset($patientDetails['middle_name']) && !empty($patientDetails['middle_name']) ? ' ' . $patientDetails['middle_name'] : ''). ' ' . $patientDetails['last_name']; ?>
                                                    <h5 class="fw-medium dark mb-0">{{ $name }}</h5>
                                                    @if($patientDetails['is_priority_patient'] == '0')
                                                        <a href="javascript:void(0);" onclick="setAsPriority('{{$patientDetails['patients_uuid']}}','setaspriority');" class="profile-tag align_middle gap-1"><span class="material-symbols-outlined">award_star</span><span>Set As Priority</span></a>
                                                    @else
                                                        <p class="priority-tag-dtl m-0"><span class="material-symbols-outlined">award_star</span>Priority Patient</p>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="innercard-info justify-content-center justify-content-xl-start">
                                                <small class="pe-2 border-right mb-1">{{ $patientDetails['age']}}</small>
                                                <small class="mb-1">@if($patientDetails['gender'] == '1') Male @elseif($patientDetails['gender'] == '2') Female @else Other @endif</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-12 border-left border-right">
                                    <div class="user_details text-start">
                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">mail</i>
                                            <small> {{ $patientDetails['email']}}</small>
                                        </div>
                                        <div class="innercard-info mb-2">
                                            <i class="material-symbols-outlined">call</i>
                                            <small>@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif <?php echo $corefunctions->formatPhone($patientDetails['phone_number']) ?></small>
                                        </div>
                                        {{-- <div class="innercard-info mb-2">
                                            <div class="d-flex justify-content-between"> 
                                                <a class="btn btn-icon align_middle" id="emailButton"><span class="material-symbols-outlined primary">mail</span></a> 
                                                <span>|</span>
                                                <a class="btn-icon" id="whatsapp"><img src="{{asset('images/Whatsapp.png')}}" class="img-fluid"></a>
                                            </div>
                                        </div> --}}
                                       
                                    </div>
                                </div>
                                <div class="col-xl-2 col-12">
                                    <div class="user_details text-start">
                                        <div class="innercard-info align-items-start">
                                            <i class="material-symbols-outlined">home</i>
                                            <div class="d-flex flex-column text-start gap-0">
                                                <small class="mb-1"><?php echo nl2br($patientDetails['formattedAddress']) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-xl-3 col-12"> 
                                        <div class="btn_alignbox justify-content-center justify-content-xl-end w-100 mt-xl-0 mt-3">
                                        
                                            <button type="button" class="btn btn-primary align_middle position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="chatDetails('{{$patientDetails['patients_uuid']}}')"><span class="material-symbols-outlined">chat_bubble</span>Chat @if( isset($hasUnReadChat) && $hasUnReadChat == 1)<span class="chat-alert"></span>@endif</button>
                                            <a class="btn opt-btn border-0" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a onclick="editPatients('{{$patientDetails['patients_uuid']}}')"  class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                @if($patientDetails['is_priority_patient'] == '0')
                                                  <li><a href="javascript:void(0);" onclick="setAsPriority('{{$patientDetails['patients_uuid']}}','setaspriority');" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">award_star</i><span>Set As Priority</span></a></li>
                                                @else
                                                  <li><a href="javascript:void(0);" onclick="setAsPriority('{{$patientDetails['patients_uuid']}}','unsetaspriority');" class="dropdown-item fw-medium"><i class="material-symbols-outlined me-2">award_star</i><span>Remove Priority</span></a></li>
                                                @endif
                                                <li><a onclick="removePatient('{{$patientDetails['patients_uuid']}}','deactivate')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Deactivate</a></li>
                                            </ul>
                                        </div>

                                    

                                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                                           <div class="chat-container p-3" id="patient_chatdetails">
                                              
                                             
                                        </div>
                                    </div>
                                    <input type="hidden" name="hasloadmore" id="hasloadmore" value="">
                                    <input type="hidden" name="first_chat_id" id="first_chat_id" value="">
                                </div>
                            </div>
                        </div>                                                      
                    </div>
                </div>
            </div>
        </div>
        @if(!empty($appointmentRecords) )
        <div class="col-12 mb-3">
            <div class="web-card user-card h-auto mb-3 p-2 details-innercard">
                <div class="d-lg-flex justify-content-between align-items-center">  
                    @if($nextAppointment)
                    <!-- <div class="innercard-info mb-xl-0 mb-2">
                        <div class="appointmnt_inner">
                            <small class="align_middle gap-1 fw-medium"><span class="material-symbols-outlined">event_upcoming</span>Next Appointment: </small>
                            <small class="mb-0 text-start"><?php echo $corefunctions->timezoneChange($nextAppointment['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($nextAppointment['appointment_time'],"h:i A") ?></small>
                        </div>
                    </div>  -->
                    @endif
                    @if(!empty($appointmentRecords))
                    <div class="innercard-info mb-xl-0 mb-2">
                        <div class="appointmnt_inner">
                            <small class="align_middle gap-1 fw-medium"><span class="material-symbols-outlined">pending_actions </span>Previous Appointment: </small>
                            <small class="mb-0 text-start"><?php echo $corefunctions->timezoneChange($appointmentRecords['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointmentRecords['appointment_time'],"h:i A") ?></small>
                        </div>
                    </div>  @endif
                </div>
            </div>
        </div>
        @endif
        {{-- <div class="col-xl-12 col-12 mb-3">
            <div class="web-card h-100 mb-3">
            <div class="detailsList cardList">
                <h5 class="fw-medium">Patient Details</h5>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-medium">Gender</h6>
                        <p>@if($patientDetails['gender'] == '1') Male @elseif($patientDetails['gender'] == '2') Female @else Other @endif</p>
                    </div>
                    <div class="d-flex justify-content-between">
                            <h6 class="fw-medium">Age</h6>
                            <p>{{ $patientDetails['age']}}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-medium">Address</h6>
                        <div class="d-flex flex-column">
                        <p>@if(isset($patientDetails['address'])) {{$patientDetails['address']}} @endif </p>
                            <p> @if(isset($patientDetails['city'])) {{$patientDetails['city']}} @endif, @if(isset($patientDetails['state'])) {{$patientDetails['state']}} @endif {{$patientDetails['zip']}}</p>
                           
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-medium">Previous Appointment</h6>
                        <p> @if(!empty($appointmentRecords))<?php echo $corefunctions->timezoneChange($appointmentRecords['appointment_date'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($appointmentRecords['appointment_time'],"h:iA") ?> @endif</p>
                    </div>
                    
                </div>
            </div>
        </div> --}}
        <div class="col-12 mb-xl-5 mb-3">

            <div class="web-card h-100 mb-5">
                <div class="row align-items-center">
                    {{-- <div class="col-sm-8 text-center text-sm-start">
                        <h4 class="mb-md-0">Appointment Records</h4>
                    </div> --}}
                    {{-- <div class="col-sm-4 text-center text-sm-end">

                        <a href="" class="btn btn-primary">Create Appointment</a>

                    </div> --}}

            
                    @include('appointment.headermenus', ['patientId' => $patientDetails['user_id'],'key' => ''])

                </div>
            </div>
        
        </div>

        
        </div>
    </div>
</section>

<div class="modal login-modal fade" id="viewdocument" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <div class="modal-header modal-bg p-0 position-relative">
            <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
        </div>
        <div class="modal-body" id="viewdocs">
        <img src="" alt="Image Preview" id="img-show" class="img-fluid">
        </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>

function showFiles(key) {
  const isVisible = $('.patientFiles').is(':visible');
  if (isVisible) {
    $('.patientFiles').hide();
    $('.message-area').show();
    $('.offcanvas-footer').show();
  } else {
      
      $.ajax({
            url: '{{ url("chat/documents") }}',
            type: "post",
            data: {
                'key' : key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $('.patientFiles').show();
                    $('.message-area').hide();
                    $('.offcanvas-footer').hide();
                    $(".patientFiles").html(data.view);
                       
                } else {
                swal("error!", data.message, "success");
                
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    
  }
}

    $(document).ready(function() {
        $('#startDate').datepicker({
            maxDate:new Date()
        });
    });

    function setAsPriority(key,type){
        var msg = (type == 'setaspriority') ? 'Are you sure you want to mark this patient as priority patient?' : 'Are you sure you want to remove this patient from priority?'
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                text: "OK",
                value: true,
                closeModal: false
                }
            },
            dangerMode: true
        }).then((Confirm) => {
            if (Confirm) {
                $.ajax({
                    url: '{{ url("/patients/markaspriority") }}',
                    type: "post",
                    data: {
                        'key' :key,
                        'type' : type,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        console.log('1')
                        if (data.success == 1) {
                        swal(data.message, {
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            window.location.reload();
                        });
                        }else{
                            swal("error!", data.errormsg, "error");
                        }
                    },
                    error: function(xhr) {
                        handleError(xhr);
                    },
                });
            }
        });
    }

    function viewDocument(dockey,ext){
        var file = $("#document_" + dockey).val();
        var img = $("#img-show");
        if(ext == 'pdf'){
            var frame = '<iframe  style="width: 100%; height: 500px;" src="'+file+'"></iframe>';
            $('#viewdocument').modal('show');
            $('#viewdocs').html(frame);

        }else{
            $('#viewdocument').modal('show');
            img.attr('src', file);
        }
    }

    $(document).ready(function() {
        $('#whatsapp').click(function() {
            var country_code = '{{$patientDetails['whatsapp_country_code']}}';
            var number = '{{$patientDetails['whatsapp_number']}}';
            var whatsappNumber = country_code+number; // Replace with the desired number
            var whatsappURL = 'https://wa.me/' + whatsappNumber;
            // window.location.href = whatsappURL; // Redirect to WhatsApp
            window.open(whatsappURL, '_blank'); // Open WhatsApp chat in a new tab
        });
    });
    $('#emailButton').click(function() {
        const recipientEmail = '{{$patientDetails['email']}}';
        const subject = 'Your Subject Here';
        const body = 'Your message here...';
        // Open the email client with mailto link
        window.location.href = `mailto:${recipientEmail}?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    });
    $(document).ready(function() {
        var key = '{{$patientDetails['patients_uuid']}}' ;
        // Retrieve `status` and `type` from URL, with defaults if not present
        var status = '{{ request()->get('status', 'open') }}';
        var type = '{{ request()->get('type', 'appointments') }}';
        getPatientAppointments(type,status,key);
    });
    function editPatients(key) {
        $("#editpatientModal").modal('show');
        $.ajax({
            url: '{{ url("/patients/edit") }}',
            type: "post",
            data: {
                'key' : key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                $("#editpatient").html(data.view);
                
                    // Initialize floating labels for inputs within the modal
                    $('#editpatientModal').find('input, textarea').each(function() {
                    toggleLabel(this);
                    initializeAutocomplete();
                    });
                } else {
                swal("error!", data.message, "success");
                
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }
    function online(status, page = 1, perPage = 10) {
        var url = "{{route('appointment.appointmentList')}}";
        $('#appointmentspatients').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');
        $.ajax({
            type: "get",
            url: url,
            data: {
                'status': status,
                'page': page,
                'perPage': perPage,
            },
            success: function(response) {
                // Handle the successful response
                $("#appointmentspatients").html(response.html);
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }
    function removePatientDocs(key) {
        swal({
            text: "Are you sure you want to remove this document?",
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "OK",
                    closeModal: false
                }
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $("#doc_" + key).remove();
                $("#patient_doc_exists" + key).val('');
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/patients/removedoc') }}",
                    data: {
                        'key': key,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).then(response => {
                    if (response.success == 1) {

                        swal(response.success, {
                        title: "Success!",
                        text: 'Document has been removed.',
                        icon: "success",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                        //   window.location.reload();
                        });

                        // swal('Success', 'Document has been removed.', 'success');
                    } else {
                        swal("Error!", "An error occurred", "error");
                    }
                }).catch(xhr => {
                    handleError(xhr);
                });
            }
        });
    }
    function removePatient(key, status) {
        swal({
            text: "Are you sure you want to " + status + " this patient?",
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                    text: "OK",
                    closeModal: false
                }
            },
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/patients/delete') }}",
                    data: {
                        'key': key,
                        'status': status,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json'
                }).then(response => {
                    if (response.success == 1) {
                        swal(response.message, {
                        title: "Success!",
                        text: response.message,
                        icon: "success",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                        window.location.reload();
                        });
                        
                        // swal("Success!", response.message, "success").then(() => {
                        //     window.location.reload();
                        // });
                    } else {
                        swal("Warning!", response.message, "warning");
                    }
                }).catch(xhr => {
                    handleError(xhr);
                });
            }
        });
    }
    function chatDetails(key){
        var loaderimgPath = "{{ asset('images/loader.gif') }}";
        $("#patient_chatdetails").html('<div class="loader_box"><img src="' + loaderimgPath + '" class="loaderImg"></div>');
        $.ajax({
            url: '{{ url("clinic/chat/details") }}',
            type: "post",
            data: {
                'key' : key,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#patient_chatdetails").html(data.view);
                    $("#hasloadmore").val(data.hasLoadMore);
                    $("#first_chat_id").val(data.firstChatID);
                    chatScrolls();
                    initializeMentionInputs();
                       
                } else {
                swal("error!", data.message, "success");
                
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }
    function chatScrolls(){
        console.log("scrolls");
        
        $('.chatboxscroll').on('scroll', function () {
            if ($(this).scrollTop() === 0 ) {
                isLoading = true;
                var patientkey = "{{$patientDetails['patients_uuid']}}";
                chatDetailsLoadMore(patientkey);
            }
        });
    }
    function initializeMentionInputs(){
        setTimeout(function() {
            if ($.fn.mentionsInput) {
                $('textarea.mention').mentionsInput({
                    onDataRequest: function (mode, query, callback) {

                        $.ajax({
                            url: '{{ url("chat/getmentions") }}',
                            type: "post",
                            data: { query: query },
                            success: function(response) {

                                const users = response.users.map(function(user) {
                                    return {
                                        id: user.user_id, 
                                        name: user.user_name,
                                        avatar: user.image,
                                        type: 'note',                             
                                        value: `@[note:${user.user_id}]` 
                                    };
                                });
                                const results = _.filter(users, function(item) {
                                    return item.name.toLowerCase().includes(query.toLowerCase());
                                });

                                callback.call(this, results);
                            },
                            error: function(xhr) {
                                console.error('Mention fetch failed', xhr);
                                callback.call(this, []); // Return empty list on error
                            }
                        });
                    },

                });
            } else {
                console.warn('mentionsInput plugin not loaded');
            }
        }, 100)
  }
    
    function chatDetailsLoadMore(key){
        console.log("load more");
        $.ajax({
            url: '{{ url("clinic/chat/details") }}',
            type: "post",
            data: {
                'key' : key,
                'loadmore' : '1',
                'first_chat_id' : $("#first_chat_id").val(),
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#append_chatmessages").prepend(data.view);
                    $("#hasloadmore").val(data.hasLoadMore);
                    $("#first_chat_id").val(data.firstChatID);
                    chatScrolls();
                } else {
                swal("error!", data.message, "success");
                
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }
</script>
@stop