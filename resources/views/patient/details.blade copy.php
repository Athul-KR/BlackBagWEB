@extends('layouts.app')
@section('title', 'Patient')
@section('content')
   
<section id="content-wrapper">
                        <div class="container-fluid p-0">
                          <div class="row h-100">
                            <div class="col-12 mb-3">
                                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                                      <li class="breadcrumb-item"><a href="{{url('patients')}}" class="primary">Patient Records</a></li>
                                      <li class="breadcrumb-item active" aria-current="page">Patient Details</li>
                                    </ol>
                                  </nav>
                            </div>

                            <div class="col-xl-8 col-12  mb-3">
                                <div class="web-card h-100 mb-3 overflow-hidden">
                                    <div class="profileData patientProfile">
                                        <div class="row align-items-end h-100">
                                            <div class="col-lg-5 col-xl-3">
                                                <div class="user_details text-start">
                                                <img @if($patientDetails['logo_path'] != '') src="{{$patientDetails['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                                                <h5 class="fw-medium dark mb-0">{{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h5>
                                                <p class="fw-middle mb-0"> {{ $patientDetails['email']}}</p>
                                                    <p  class="fw-middle mb-0">{{ $patientDetails['age']}}</p>

                                                   

                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-xl-9">
                                                <div class="d-flex justify-content-center justify-content-xl-end">

                                                    <div class="btn_alignbox">
                                                        <a class="btn btn-outline d-flex align-items-center justify-content-center gap-2" id="emailButton"><span class="material-symbols-outlined">mail</span>Email</a>
                                                        <a class="btn-icon" id="whatsapp"><img src="{{asset('images/Whatsapp.png')}}" class="img-fluid"></a>
                                                        <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="material-symbols-outlined">more_vert</span>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a onclick="editPatients('{{$patientDetails['patients_uuid']}}')"  class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                            <li><a onclick="removePatient('{{$patientDetails['patients_uuid']}}','deactivate')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Deactivate</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>                                     
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-12 mb-3">
                              <div class="web-card h-100 mb-3">
                                <div class="detailsList cardList">
                                  <h5 class="fw-medium">Patient Details</h5>
                                      <hr>
                                        <div class="d-flex justify-content-between">
                                            <h6 class="fw-medium">Gender</h6>
                                            <p>@if($patientDetails['gender'] == '1') Male @elseif($patientDetails['gender'] == '2') Female @else Other @endif</p>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                              <h6 class="fw-medium">Phone Number</h6>
                                              <p>{{$patientDetails['phone_number']}}</p>
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
                                            <p> @if(!empty($appointmentRecords))<?php echo  date('M d Y', strtotime($appointmentRecords['appointment_date'])) ?> ,<?php echo  date('h:i A', strtotime($appointmentRecords['appointment_time'])) ?> @endif</p>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-12 mb-xl-5 mb-3 order-1 order-xl-0">

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
                                              <button class="nav-link online active" id="pills-home-tab" onclick="getAppointments('online','upcoming','{{$patientDetails['patients_uuid']}}')"  role="tab" aria-controls="pills-home" aria-selected="true">Online Appointments</button>
                                              </li>
                                              <li class="nav-item" role="presentation">
                                              <button class="nav-link medical offline" id="pills-home-tab" onclick="getAppointments('medical','upcoming','{{$patientDetails['patients_uuid']}}')"  role="tab" aria-controls="pills-home" aria-selected="true">Medical History</button>
                                              </li>
                                              <li class="nav-item" role="presentation">
                                                  <button class="nav-link offline" id="pills-profile-tab" onclick="getAppointments('offline','upcoming','{{$patientDetails['patients_uuid']}}')"  role="tab" aria-controls="pills-profile" aria-selected="false">In-person Appointments</button>
                                              </li>
                                            </ul>
                                              <div class="tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade show active" id="appointmentspatients" role="tabpanel" aria-labelledby="pills-home-tab">  
                                                
                                                
                                              </div>

                                              <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                              </div>
                                             
                                               
                                              </div>
                                            </div>
                                          </div> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-12 mb-xl-5 mb-3 order-0 order-xl-1">
                                <div class="web-card h-100 ">
                                    <div class="detailsList">
                                        <h5 class="fw-medium">Medical History</h5>
                                        <hr>
                                      
                                        <div class="d-flex flex-column">
                                          @if($patientDetails['notes'] !='')
                                            <h6 class="fw-medium">Notes</h6>
                                            <p><?php echo $patientDetails['notes'] ?></p>
                                        @endif
                                          </div>
                                        <div class="d-flex flex-column">
                                          <h6 class="fw-medium">Patient Files</h6>
                                          <div class="files-container fileoptions-container mb-3">
                                            @if(!empty($patientDocument))
                                              <?php  $i=1; ?>
                                              @foreach($patientDocument as $docsdata)

                                              <div class="fileBody" id="doc_{{$docsdata['patient_doc_uuid']}}">
                                                <div class="file_info">
                                                <?php 
                                                    if($docsdata['doc_ext'] == 'png'){
                                                    $imagePath = "png_icon.png";
                                                    }else if($docsdata['doc_ext']  == 'jpg'){
                                                    $imagePath = "jpg_icon.png}";
                                                    }else if($docsdata['doc_ext']  == 'pdf'){
                                                    $imagePath = "pdf_img.png";
                                                    }else if($docsdata['doc_ext']  == 'xlsx'){
                                                    $imagePath = "excel_icon.png";
                                                    }else{
                                                    $imagePath = "doc_image.png";
                                                    }
                                            ?>
                                              <?php 
                                                $allowed_extensions = array('jpg', 'jpeg', 'png');
                                                if (in_array(strtolower($docsdata['doc_ext']), $allowed_extensions)) { ?>
                                                    <img src="{{url($docsdata['temdocppath'])}}">
                                               <?php }else {?>
                                                 <img src="{{asset('images/'.$imagePath)}}">
                                                <?php }?>
                                              
                                                  <span>{{$docsdata['orginal_name']}}</span>
                                                </div>
                                                <div class="btn_alignbox">
                                                    <?php 
                                                    $viewdoces = array('jpg', 'jpeg', 'png','pdf');
                                                    if (in_array(strtolower($docsdata['doc_ext']), $viewdoces)) { ?>
                                                    <a class="hvr-btn-view primary" href="javascript:void(0)" onclick="viewDocument('{{$docsdata['patient_doc_uuid']}}','{{$docsdata['doc_ext']}}')"><i class="fa fa-eye"></i></a>
                                                    <?php }?> 
                                                    <a class="hvr-btn-dwnld primary" href="{{url('/patients/downloadtempdocs/'.$docsdata['patient_doc_uuid'])}}"><i class="fas fa-download"></i></a>

                                                    <a onclick="removePatientDocs('{{$docsdata['patient_doc_uuid']}}')" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                                                </div>
                                            </div>
                                              <input type="hidden" id="document_{{$docsdata['patient_doc_uuid']}}" name="{{$docsdata['patient_doc_uuid']}}.{{$docsdata['doc_ext']}}" value="{{url($docsdata['temdocppath'])}}">


                                              <?php  $i++ ; ?>
                                              @endforeach
                                            @endif
    

                                          


                                          </div>
                                      </div>
                                    </div>
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
 
    
   
    // link.attr('href',appURL)
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
        var status = '{{ request()->get('status', 'reception') }}';
        var type = '{{ request()->get('type', 'online') }}';
    
        getAppointments(type, status,key);

    });
       function getAppointments(type, status,patientKey, page = 1,) {
        const limit = $('#pagelimit').val(); // Get the selected limit value

        if(type == 'offline'){
            $('.online').removeClass('active');
            $('.offline').addClass('active');
        }else if(type == 'online'){
            $('.online').addClass('active');
            $('.offline').removeClass('active');
        }else{
            $('.medical').addClass('active');
            $('.offline').removeClass('active');
            $('.online').removeClass('active');
        }
        showPreloader('appointments');
        $.ajax({
            type: "POST",
            url: '{{ url("/patients/appointmentlist") }}',
            data: {
                "type": type,
                'status': status,
                'limit' : limit,
                'page': page,
                'patientKey' : patientKey,
                '_token': $('meta[name="csrf-token"]').attr('content')

            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    $("#appointmentspatients").html(response.view);

                    $("#pagination-links").html(response.pagination); // Update pagination links

                    // Attach click event to pagination links
                    $("#pagination-links a").on("click", function(e) {
                        e.preventDefault();
                        const newPage = $(this).attr("href").split("page=")[1];
                        getAppointments(type, status, patientKey, newPage);
                    });
                }
             
            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.error('AJAX Error: ' + status + ': ' + error);
            },
        })
    }

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
            });
         } else {
          swal("error!", data.message, "success");
          
         }
       }
     });
   
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
                    swal('Success', 'Document has been removed.', 'success');
                } else {
                    swal("Error!", "An error occurred", "error");
                }
            }).catch(xhr => {
                if (xhr.status == 419) {
                    window.location.reload(); // Token expired
                } else {
                    swal("Error!", "An error occurred", "error");
                }
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
            // AJAX call if user confirms
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
                    swal("Success!", response.message, "success").then(() => {
                        window.location.reload();
                    });
                } else {
                    swal("Error!", "An error occurred", "error");
                }
            }).catch(xhr => {
                if (xhr.status == 419) {
                    window.location.reload(); // Token expired
                } else {
                    swal("Error!", "An error occurred", "error");
                }
            });
        }
    });
}

  </script>
@stop