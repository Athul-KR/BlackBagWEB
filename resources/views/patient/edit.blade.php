<h4 class="text-center fw-medium mb-0 ">Edit  Patient</h4>
                            <!-- <small class="gray">Please enter the patient’s details</small> -->
                            
                            <div class="import_section">
                                <!-- <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a> -->
                            </div>
                              <form id="editform" method="POST" > 
                              @csrf

                              <!-- <div class="create-profile">
                                <div class="profile-img position-relative"> 
                                  <img id="editpatientimage" @if($patientDetails['logo_path'] !='') src="{{$patientDetails['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                                  <a  href="{{ url('crop/patient')}}" id="upload-imgedit" class="aupload" @if($patientDetails['logo_path'] !='') style="display:none;" @endif><img src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                                  <a class="profile-remove-btn" href="javascript:void(0);" id="removelogoedit"  @if($patientDetails['logo_path'] !='') style="" @else  style="display:none;" @endif onclick="removeProfileImage()"><span class="material-symbols-outlined">delete</span></a>

                                </div>
                                <input type="hidden" id="tempimageedit" name="tempimage" value="">
                                <input type="hidden" name="isremove" id="isremoveedit" value="0">
                              </div> -->

                                <div class="row mt-5"> 
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="input" class="float-label">First Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text"  name="name" class="form-control" id="exampleFormControlInput1" value="@if(isset($patientDetails['user'])){{$patientDetails['user']['first_name']}}@else{{$patientDetails['first_name']}}@endif" >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="input" class="float-label">Middle Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text" name="middle_name" class="form-control" id="exampleFormControlInput1" value="@if(isset($patientDetails['user'])){{$patientDetails['user']['middle_name']}}@else{{$patientDetails['middle_name']}}@endif" >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="input" class="float-label">Last Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text" name="last_name" class="form-control" id="last_name" value="@if(isset($patientDetails['user'])){{$patientDetails['user']['last_name']}}@else{{$patientDetails['last_name']}}@endif" >
                                    </div>
                                  </div>


                                  <div class="col-md-6">
                                    

                                    <div class="form-group form-floating mb-4">
                                        <i class="material-symbols-outlined">id_card</i>
                                        <select name="gender" id="gender" class="form-select">
                                            <option value="">Select Gender</option>
                                                <option value="1" @if($patientDetails['gender'] == '1') selected @endif>Male</option> 
                                                <option value="2"  @if($patientDetails['gender'] == '2') selected @endif>Female</option>
                                                <option value="3"  @if($patientDetails['gender'] == '3') selected @endif>Other</option>
                                        </select>
                                        <label class="select-label">Gender</label>
                                    </div>

                                    
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group form-outline mb-4">
                                      <label for="email" class="float-label">Email</label>
                                      <i class="fa-solid fa-envelope"></i>
                                      <input type="email" name="email" id="email"class="form-control" value="{{$patientDetails['email']}}">
                                    </div>
                                  </div>
                                  <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                                  <div class="col-12">
                                    <div class="form-group form-outline form-dropdown mb-4">
                                        <label for="input" id="select_doctor_label">Tag A Clinician</label>
                                        <i class="material-symbols-outlined">stethoscope</i>
                                        <input id="doctor_input" type="hidden" name="doctor">
                                        <div class="dropdownBody">
                                            <div class="dropdown">
                                                <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                                </a>

                                                <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                                    <li class="dropdown-item">
                                                        <div class="form-outline input-group ps-1">
                                                            <div class="input-group-append">
                                                                <button class="btn border-0" type="button">
                                                                    <i class="fas fa-search fa-sm"></i>
                                                                </button>
                                                            </div>
                                                            <input id="search_doctor" name="search_doctor" class="form-control border-0 small" type="text" placeholder="Search Clinician" aria-label="Search" aria-describedby="basic-addon2">
                                                        </div>
                                                    </li>

                                                    <div id="search_li_doctor">

                                                        @foreach ($doctors as $doctor)
                                                        <li id="{{$doctor['user_uuid']}}" class="dropdown-item  select_doctor_list" style="cursor:pointer">

                                                            <div class="dropview_body profileList">
                                                                <!-- <img src="{{asset('images/patient1.png')}}" class="img-fluid"> -->

                                                                <p class="select_doctor_item" data-id="{{$doctor['userID']}}">{{ $corefunctions -> showClinicanNameUser($doctor,'1');}}</p>

                                                                @if ($patientDetails['assigned_clinic_user_id'] == $doctor['userID'])
                                                                <input id="doctor-id" type="hidden" value="{{$doctor['userID']}}" data-content="{{ $corefunctions -> showClinicanNameUser($doctor,'1');}}">
                                                                @endif

                                                            </div>

                                                        </li>
                                                        @endforeach

                                                        @if (empty($doctors))
                                                        <li class="dropdown-item">

                                                            <div class="dropview_body profileList justify-content-center">

                                                                <p>No doctors found</p>

                                                            </div>

                                                        </li>
                                                        @endif

                                                    </div>


                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                  </div>

                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4 mb-md-2">
                                      <label for="dob" class="float-label active">Date of Birth</label>
                                      <i class="material-symbols-outlined">date_range</i>
                                      <input type="text" name="dob" id="dobedit" class="form-control" placeholder="" value="@if( $patientDetails['dob'] != '') {{date('m/d/Y', strtotime($patientDetails['dob']))}} @endif" >
                                    </div>
                                  </div>
                                  <?php
                                    $Corefunctions = new \App\customclasses\Corefunctions;
                                  ?>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline phoneregcls mb-4 mb-md-2">
                                        <div class="country_code phone">
                                          <input type="hidden" class="autofillcountry" id="countryCodeedit" name="countrycode" value={{ isset($countryCodedetails['short_code'])  ? $countryCodedetails['short_code'] : 'US' }} >
                                        </div>
                                      <!-- <label for="phone" class="float-label ">Phone Number</label> -->
                                      <i class="material-symbols-outlined me-2">call</i> 
                                      <input type="tel" name="phone_number" placeholder="Phone Number" class="form-control phone-number" id="phoneedit"  value="<?php echo isset($patientDetails['country_code'])  ? '+'.$patientDetails['country_code'] . $Corefunctions->formatPhone($patientDetails['phone_number']) : $Corefunctions->formatPhone($patientDetails['phone_number']) ?>" >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-2">
                                    <div class="country_code phone">
                                          <input type="hidden" id="whatsappeditcountryCode" name="whatscountrycode" value={{ isset($patientDetails['whatsapp_short_code'])  ? $patientDetails['whatsapp_short_code'] : 'US' }} >
                                      </div>
                                      <!-- <label for="whatsapp" class="float-label ">Whatsapp</label> -->
                                      <i class="fa-brands fa-whatsapp me-2"></i> 
                                      <input type="tel" name="whatsapp_num" placeholder="Whatsapp Number" class="form-control whatsapp-phone-number" id="whatsappedit" value="<?php echo isset($patientDetails['whatsapp_country_code'])  ? '+'.$patientDetails['whatsapp_country_code'] . $Corefunctions->formatPhone($patientDetails['whatsapp_number']) : $Corefunctions->formatPhone($patientDetails['whatsapp_number']) ?>" >
                                    </div>
                                  </div>

                                  <div class="col-12">
                                    <div class="d-flex justify-content-end align-items-center mb-4">
                                      <input class="form-check-input btn-outline-checkbox m-0 me-2" name="iswhatsapp" id="iswhatsapp" type="checkbox" @if($patientDetails['whatsapp_number'] == $patientDetails['phone_number'] ) checked @endif value="">
                                      <samll class="primary fw-medium">Same as phone number</samll> 
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="form-group form-outline textarea-align mb-4">
                                      <label for="address" class="float-label">Address</label>
                                      <i class="material-symbols-outlined">home</i>
                                      <textarea name="address" id="address" class="form-control" rows="1">@if(isset($patientDetails['user']['address']) && $patientDetails['user']['address']!=''){{$patientDetails['user']['address']}} @else{{$patientDetails['address']}}@endif</textarea>
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="city"class="float-label">City</label>
                                      <i class="material-symbols-outlined">location_city</i>
                                      <input type="text" name="city" class="form-control" id="city" value="@if(isset($patientDetails['user']['city']) && $patientDetails['user']['city']!=''){{$patientDetails['user']['city']}} @else{{$patientDetails['city']}}@endif">
                                    </div>
                                  </div>
                                  <div  id="statesel" class="col-md-4" @if(isset($patientDetails['country_code']) && ($patientDetails['country_code'] == '+1' || $patientDetails['country_code'] == '1') ) style="display:none;" @else style="display:block;" @endif>
                                    <div class="form-group form-outline mb-4">
                                      <label for="state" class="float-label ">State</label>
                                      <i class="material-symbols-outlined">map</i>
                                      <input type="text" name="state" class="form-control" id="state" value="@if(isset($patientDetails['user']['state']) && $patientDetails['user']['state']!=''){{$patientDetails['user']['state']}} @else{{$patientDetails['state']}} @endif">
                                    </div>
                                  </div>

                                  <div id="statelist" class="col-md-4" @if(isset($patientDetails['country_code']) && ($patientDetails['country_code'] == '+1' || $patientDetails['country_code'] == '1') ) style="display:block;" @else style="display:none;" @endif> 
                                      <div class="form-group form-floating mb-4">
                                          <i class="material-symbols-outlined">id_card</i>
                                          <select name="state_id" id="state_id"  class="form-select">
                                              <option value="">Select a state</option>
                                              @if(!empty($state))
                                                @foreach($state as $sts)
                                                  <option data-shortcode="{{$sts['state_name']}}" value="{{$sts['id']}}" @if(isset($patientDetails['user']['state_id']) && $patientDetails['user']['state_id']!='' && $patientDetails['user']['state_id'] == $sts['id']) selected @elseif($patientDetails['state_id'] == $sts['id']) selected @endif>{{$sts['state_name']}}</option>
                                                @endforeach
                                              @endif
                                          </select>
                                          <label class="select-label">State</label>
                                      </div>
                                  </div>

                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="zip" class="float-label ">Zip</label>
                                      <i class="material-symbols-outlined">home_pin</i>
                                      <input type="text" name="zip" class="form-control" id="zip" value="@if(isset($patientDetails['user']['zip_code']) && $patientDetails['user']['zip_code']!=''){{$patientDetails['user']['zip_code']}}@else{{$patientDetails['zip']}}@endif">
                                    </div>
                                  </div>
                                    <?php /* <div class="col-12">
                                      <div class="d-flex justify-content-end align-items-center mb-3">
                                      <a onclick="editnotes('add')" <?php $note= trim($patientDetails['notes']);?> @if($note != '')  style="display:none;" @endif class="primary fw-medium btn_inline" id="edit"><span class="material-symbols-outlined"> add </span>Add Notes</a>
                                      <a onclick="editnotes('rmv')" <?php $note= trim($patientDetails['notes']);?>  @if($note != '')  style="" @endif class="danger fw-medium btn_inline" style="display:none;" id="editremove"><span class="material-symbols-outlined">delete</span>Remove Notes</a>
                                        <!-- <a href="" class="primary fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add Notes</a> -->
                                      </div>
                                      <div class="form-group form-outline form-textarea mb-3" <?php $note= trim($patientDetails['notes']);?> @if($note !='')  style="" @else  style="display:none;" @endif id="editnotes">
                                        <label for="note" class="float-label">Notes</label>
                                        <i class="fa-solid fa-file-lines"></i>
                                        <textarea class="form-control" name="note" id="noteedit" rows="4" cols="4"><?php echo  $patientDetails['notes'] ?> </textarea>
                                      </div>
                                    </div> */ ?>
                                    
                                    <?php /* <div class="col-12">
                                      <div class="dropzone-wrapper mb-3 dropzone" id="patientDocsedit">
                                        <!-- <a  class="gray fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add patient files</a> -->
                                      </div>
                                      <div class="files-container mb-3" id="appenddocsedit" >
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
                                               <img src="{{asset('images/'.$imagePath)}}">
                                              <span>{{$docsdata['orginal_name']}}</span>
                                            </div>
                                            <a onclick="removeDocs('{{$docsdata['patient_doc_uuid']}}')" class="close-btn"><span class="material-symbols-outlined">close</span></a>

                                          </div>
                                          <input type="hidden" id="patient_doc_exists{{$docsdata['patient_doc_uuid']}}" name="existdoc['<?php echo $i;?> ']" value="{{$docsdata['patient_doc_uuid']}}"> 

                                        <?php  $i++ ; ?>
                                        @endforeach
                                        @endif

                                      </div>
                                    </div> */ ?>
                         
                                  <div class="col-12">
                                    <div class="btn_alignbox justify-content-end">
                                      <a href="" class="btn btn-outline-primary">Close</a>
                                      <a onclick="updatePatient('{{$patientDetails['patients_uuid']}}')" id="updatepatient" class="btn btn-primary">Update</a>
                                    </div>
                                    
                                  </div>
                                </div>

                            </form>
                            @php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp               
        <script>
        jQuery.browser = {};
          (function() {
            jQuery.browser.msie = false;
            jQuery.browser.version = 0;
            if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
              jQuery.browser.msie = true;
              jQuery.browser.version = RegExp.$1;
            }
          })();
  function editnotes(type){
    if(type == 'add'){
      $("#editnotes").show();
      $("#editremove").show();
      $("#edit").hide();
    }else{
      $("#editnotes").hide();
      $("#editremove").hide();
      $("#edit").show();
      $("#noteedit").val('');
      
    }
   
  }
  function removeProfileImage(){
   console.log('remove')
      $("#editpatientimage").attr("src","{{asset('images/default_img.png')}}");
      $("#isremoveedit").val('1');
      $("#isremoveedit").hide();
      $("#upload-imgedit").show();
      $("#removelogoedit").hide();
      
  }

  function removeDocs(key) {
    swal({
        text: "Are you sure you want to remove this document?",
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                closeModal: true // It will automatically close after the action
            }
        },
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            // Remove the document from the DOM and clear the corresponding value
            $("#doc_" + key).remove();
            $("#patient_doc_exists" + key).val('');

            // Show success message after removal
            swal('Success', 'Document has been removed.', 'success');
        } else {
            // Optionally, show a cancellation message
            swal('Cancelled', 'Document removal has been cancelled.', 'info');
        }
    });
}

//     swal({
//         text: "Are you sure you want to remove this document?",
//         icon: "warning",
//         showCancelButton: true,
//         confirmButtonClass: "btn-danger",
//         confirmButtonText: "OK",
//         cancelButtonText: "Cancel",
//         showLoaderOnConfirm: false,
//         preConfirm: () => {
//             return new Promise((resolve, reject) => {
//                 // Remove document elements
//                 $("#doc_" + key).remove();
//                 $("#patient_doc_exists" + key).val('');
                
//                 resolve(); // Resolve the promise since no async action is needed here
//             });
//         }
//     }).then((result) => {
//         if (result.isConfirmed) {
//             swal('Success', 'Document has been removed.', 'success');
//         } else {
//             swal('Cancelled', 'Document removal has been cancelled.', 'info');
//         }
//     }).catch((error) => {
//         swal('Error', 'An error occurred: ' + error, 'error');
//     });
// }


  function patientImage(imagekey, imagePath) {
    $("#tempimageedit").val(imagekey);
    $("#editpatientimage").attr("src", imagePath);
    $("#editpatientimage").show();
    $("#upload-imgedit").hide();
    $("#removelogoedit").show();
  }
      $(".aupload").colorbox({
          iframe: true,
          width: "650px",
          height: "650px"
      });
// Dropzone.autoDiscover = false;
//     // Dropzone Configurations
//     var dropzone = new Dropzone('#patientDocsedit', {
//         url: '{{ url('/patients/uploaddocument') }}',
//         addRemoveLinks: true,
//         dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span> Add patient files', // Add class for styling
//         headers: {
//             'X-CSRF-TOKEN': "{{ csrf_token() }}"
//         },
//         init: function() {
//          this.on("sending", function(file, xhr, formData) {
//                   // Extra data to be sent with the file
//                   formData.append("formdata", $('#createinquiry').serialize());
//                 });
//             this.on("removedfile", function(file) {
//                 $(".remv_" + file.filecnt).remove();
//             });
//             var filecount = 1;
//             this.on('success', function(file, response) {
//                 if( response.success == 1){
                
//                 this.removeFile(file);
//                 file.filecnt = filecount;

//                 if(response.ext == 'png'){
//                   var imagePath = "{{ asset('images/png_icon.png') }}";
//                 }else if(response.ext == 'jpg'){
//                   var imagePath = "{{ asset('images/jpg_icon.png') }}";
//                 }else if(response.ext == 'pdf'){
//                   var imagePath = "{{ asset('images/pdf_img.png') }}";
//                 }else if(response.ext == 'xlsx'){
//                   var imagePath = "{{ asset('images/excel_icon.png') }}";
//                 }else{
//                   var imagePath = "{{ asset('images/doc_image.png') }}";
//                 }
//                 var appnd = '<div class="fileBody"><div class="file_info"><img src="'+imagePath+ '"><span>'+ response.docname +'</span>' +
//                             '</div><a onclick="removeImage()" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a></div>'+
//                             '<input type="hidden" name="patient_docs[' + filecount +'][tempdocid]" value="' + response.tempdocid + '" >';

//                 $("#appenddocsedit").append(appnd);
//                 filecount++
//                 // $("#docuplad").val('1');
//                 // $("#docuplad").valid();
//              }else{
//                 if (typeof response.error !== 'undefined' && response.error !== null && response.error == 1 ) {
//                     swal(response.errormsg);
//                      this.removeFile(file);
//                 }
//             }
//             });
//         },
//     });
    $('#dobedit').datetimepicker({
      format: 'MM/DD/YYYY',
            useCurrent: false, 
            // todayHighlight: true,
            // autoclose: true,
            maxDate: new Date() ,                                
    });
    //Doctor Search Section
    $('#search_doctor').on('keyup', function() {

        var type = 'doctor';
        var searchData = $('#search_doctor').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "post",
            url: "{{url('/appointments/search')}}" + "/" + type,
            data: {
                'search': searchData
            },
            success: function(response) {
                console.log(response);
                // Replace the dropdown items with the new HTML
                $('#search_li_doctor').html(response.view);
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        })

    })
    $(document).on('click', '.select_doctor_list', function() {

        var doctorItem = $(this).find('.select_doctor_item').text();
        var doctorId = $(this).find('.select_doctor_item').data('id');
        $('#select_doctor_label').text(doctorItem);
        $('#doctor_input').val(doctorId);

    })


        
                     

          $(document).ready(function() {
            //setting doctor on document loads
            var doctorId = $('#doctor-id').val();
            var doctorName = $('#doctor-id').data('content');
            $('#select_doctor_label').text(doctorName);
            $('#doctor_input').val(doctorId);

            $("#editform").validate({
              ignore: [],
              rules: {
                name: {
                  required: true,
                },
                last_name: {
                  required: true,
                },
                
                email: {
                    required: true,
                    remote: {
                      
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                            'type' : 'patient',
                            "id":"{{$patientDetails['user_id']}}",

                            'country_code': function () {

                                return $("#countryCodes").val(); // Get the updated value
                            },
                            'phone_number': function () {
                                return $("#phoneedit").val(); // Get the updated value
                            },
                            
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                        dataFilter: function (response) {
                            // Parse the server's response
                            const res = JSON.parse(response);
                            if (res.valid) {
                                return true; // Validation passed
                            } else {
                                // Dynamically return the error message
                                return "\"" + res.message + "\"";
                            }
                        }


                    },
                   
                },
                doctor: "required",
                gender: {
                    required: true,
                },
                dob: {
                    required: true,
                },
                phone_number: {
                    required: true,
                    NumberValids: true,
                    remote: {
                      
                      url: "{{ url('/validateuserphone') }}",
                      data: {
                          'type' : 'patient',
                          "id":"{{$patientDetails['user_id']}}",
                         'email': function () {
                              return $("#email").val(); // Get the updated value
                          },
                          'country_code': function () {
                              return $("#countryCodeShort").val(); // Get the updated value
                          },
                          
                          '_token': $('input[name=_token]').val()
                      },
                      type: "post",
                      dataFilter: function (response) {
                          // Parse the server's response
                          const res = JSON.parse(response);
                          if (res.valid) {
                              return true; // Validation passed
                          } else {
                              // Dynamically return the error message
                              return "\"" + res.message + "\"";
                          }
                      }


                  },
                 


                },
                whatsapp_num: {
                    // required: true,
                    NumberValids: true,
                },
                address: {
                    required: true,
                },
                city: {
                    required: true,
                },
                // state: {
                //     required: true,
                // },
                state : {
                    required: {
                            depends: function(element) {
                         
                                return ( ($("#countryCodeedit").val() !='+1'));
                               
                            }
                    },
                },

                state_id : {
                    required: {
                            depends: function(element) {
                                return (($("#countryCodeedit").val() == '+1'));
                             
                            }
                    },
                },

                zip: {
                    required: true,
                    number : true,
                },
                // note: {
                //     required: true,
                // },
                
            },
            messages: {
              name: {
                    required: 'Please enter first name.',
                },
                last_name: {
                    required: 'Please enter last name.',
                },
                
                email: {
                    required: 'Please enter email.',
                    customemail: "Please enter a valid email",
                    remote: "Email id already exists in the system."
                },
                doctor: "Please select a clinician.",
                gender: {
                    required: 'Please select gender.',
                },
                dob: {
                    required: 'Please enter date if birth.',
                },
                phone_number: {
                    required: 'Please enter phone number.',
                    NumberValids: 'Please enter a valid phone number.',
                },
                whatsapp_num: {
                  NumberValids: 'Please enter a valid phone number.',
                },
                
                address: {
                    required: 'Please enter address.',
                },
                city: {
                    required: 'Please enter city.',
                },
                state: {
                    required: 'Please enter state.',
                },
                state_id: {
                    required: 'Please select state.',
                },
                
                zip: {
                    required: 'Please enter zip code.',
                    number :  'Please enter valid zip code.',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-number")) {
                  $("#phonenumber-error").remove(); 
                  // Insert error message after the correct element
                  error.insertAfter(".phone-number");
                }else if (element.hasClass("whatsapp-phone-number")) {
                  error.insertAfter(".whatsapp-phone-number");
                } else {
                    error.insertAfter(element);
                }
            },
            success: function(label) {
                // If the field is valid, remove the error label
                label.remove();
            }
        });
      });
      jQuery.validator.addMethod("NumberValids", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, ""); // Remove spaces
        return this.optional(element) || phone_number.length < 14 &&
            phone_number.match(/^(1-?)?(\()?([0-9]\d{2})(\))?(-|\s)?[0-9]\d{2}(-|\s)?\d{4}$/);
      });

  function updatePatient(key) {
   
   if ($("#editform").valid()) {
     $("#updatepatient").addClass('disabled');
     $.ajax({
       url: '{{ url("/patients/update") }}',
       type: "post",
       data: {
        'key' :key ,
         'formdata': $("#editform").serialize(),
         '_token': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data) {
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

        
         } else {
           swal({
             icon: 'error',
             text: data.errormsg,
           });
         }
       },
       error: function(xhr) {
        handleError(xhr);
        },
     });
   }
 }
 $(document).ready(function() {
            var telInput = $("#phoneedit"),
              countryCodeInput = $("#countryCodeedit"),
              errorMsg = $("#error-msg"),
              validMsg = $("#valid-msg");
              let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
            // initialise plugin
            telInput.intlTelInput({
                autoPlaceholder: "polite",
                initialCountry: "us",
                formatOnDisplay: false, // Enable auto-formatting on display
                autoHideDialCode: true,
                defaultCountry: "auto",
                ipinfoToken: "yolo",
                onlyCountries: onlyCountries,
                nationalMode: false,
                numberType: "MOBILE",
                separateDialCode: true,
                geoIpLookup: function(callback) {
                    $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "";
                        callback(countryCode);
                    });
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Ensure latest version
            });

            var reset = function() {
                telInput.removeClass("error");
                errorMsg.addClass("hide");
                validMsg.addClass("hide");
            };

            telInput.on("countrychange", function(e, countryData) {
                countryCodeInput.val(countryData.iso2);
                updateAutocompleteCountry()
                if(countryData.dialCode == 1 ){
                  $("#statelist").show();
                  $("#statesel").hide();
                }else{
                  $("#statelist").hide();
                  $("#statesel").show();
                }

            });

            telInput.blur(function() {
                reset();
                if ($.trim(telInput.val())) {
                    if (telInput.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                        telInput.addClass("error");
                        errorMsg.removeClass("hide");
                    }
                }
            });


            var telInput2 = $("#whatsappedit"),
              countryCodeInput2 = $("#whatsappeditcountryCode"),
              errorMsg = $("#error-msg"),
              validMsg = $("#valid-msg");

            // initialise plugin
            telInput2.intlTelInput({
                autoPlaceholder: "polite",
                initialCountry: "us",
                formatOnDisplay: false, // Enable auto-formatting on display
                autoHideDialCode: true,
                defaultCountry: "auto",
                ipinfoToken: "yolo",
                onlyCountries: onlyCountries,
                nationalMode: false,
                numberType: "MOBILE",
                separateDialCode: true,
                geoIpLookup: function(callback) {
                    $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                        var countryCode = (resp && resp.country) ? resp.country : "";
                        callback(countryCode);
                    });
                },
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Ensure latest version
            });

            var reset = function() {
              telInput2.removeClass("error");
                errorMsg.addClass("hide");
                validMsg.addClass("hide");
            };

            telInput2.on("countrychange", function(e, countryData) {
              countryCodeInput2.val(countryData.iso2);

            });
          
            telInput2.blur(function() {
                reset();
                if ($.trim(telInput2.val())) {
                    if (telInput2.intlTelInput("isValidNumber")) {
                        validMsg.removeClass("hide");
                    } else {
                      telInput2.addClass("error");
                        errorMsg.removeClass("hide");
                    }
                }
            });

            $('#iswhatsapp').change(function () {
              if ($(this).is(':checked')) {
                var fullPhoneNumber = $('#phoneedit').val();

                telInput2.val(fullPhoneNumber); // Set WhatsApp number
                var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
                telInput2.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
              } else {
                telInput2.val(''); // Clear WhatsApp input if unchecked
                countryCodeInput2.val('+1'); // Reset WhatsApp country code (optional default)
                telInput2.intlTelInput("setCountry", "us"); // Reset to a default country if needed
              }
            });
            $('#phone').on('keyup', function () {
              if ($(this).val != '' && $('#iswhatsapp').is(':checked')) {

                var fullPhoneNumber = $('#phoneedit').val();
                telInput2.val(fullPhoneNumber); // Set WhatsApp number
                var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
                telInput2.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
              } else {
                telInput2.val(''); // Clear WhatsApp input if unchecked
                whatsappCountryCodeInput.val('US'); // Reset WhatsApp country code (optional default)
                telInput2.intlTelInput("setCountry", "us"); // Reset to a default country if needed
              }
            });
            $('#phoneedit, #whatsappedit').mask('(ZZZ) ZZZ-ZZZZ', {
              translation: {
                'Z': {
                  pattern: /[0-9]/,
                  optional: false
                }
              }
            });
          });
          </script>


