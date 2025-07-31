<h4 class="text-center fw-medium mb-0 ">Edit  Patient</h4>
                            <!-- <small class="gray">Please enter the patient’s details</small> -->
                            
                            <div class="import_section">
                                <!-- <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a> -->
                            </div>
                              <form id="editform" method="POST" > 
                              <?php echo csrf_field(); ?>

                              <div class="create-profile">
                                <div class="profile-img position-relative"> 
                                  <img id="editpatientimage" <?php if($patientDetails['logo_path'] !=''): ?> src="<?php echo e($patientDetails['logo_path']); ?>" <?php else: ?> src="<?php echo e(asset('images/default_img.png')); ?>" <?php endif; ?> class="img-fluid">
                                  <a  href="<?php echo e(url('crop/patient')); ?>" id="upload-imgedit" class="aupload"><img src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid" data-toggle="modal"></a>
                                  <a class="profile-remove-btn" href="javascript:void(0);" id="removelogoedit"  <?php if($patientDetails['logo_path'] !=''): ?> style="display:block;" <?php else: ?>  style="display:none;" <?php endif; ?> onclick="removeProfileImage()"><span class="material-symbols-outlined">delete</span></a>

                                </div>
                                <input type="hidden" id="tempimageedit" name="tempimage" value="">
                                <input type="hidden" name="isremove" id="isremoveedit" value="0">
                              </div>

                                <div class="row"> 
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-3">
                                      <label for="input" class="float-label">Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text"  name="name" class="form-control" id="exampleFormControlInput1" value="<?php echo e($patientDetails['name']); ?>" >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    

                                    <div class="form-group form-outline select-outline mb-4">
                                        <i class="material-symbols-outlined">id_card</i>
                                        <select name="gender" id="gender"  class="form-select">
                                            <option value="">Select Gender</option>
                                                <option value="1" <?php if($patientDetails['gender'] == '1'): ?> selected <?php endif; ?>>Male</option> 
                                                <option value="2"  <?php if($patientDetails['gender'] == '2'): ?> selected <?php endif; ?>>Female</option>
                                                <option value="3"  <?php if($patientDetails['gender'] == '3'): ?> selected <?php endif; ?>>Other</option>
                                            
                                        </select>
                                    </div>

                                    
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-3">
                                      <label for="email" class="float-label">Email</label>
                                      <i class="fa-solid fa-envelope"></i>
                                      <input type="email" name="email" id="email"class="form-control" value="<?php echo e($patientDetails['email']); ?>">
                                    </div>
                                  </div>
                                 

                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-3">
                                      <label for="dob" class="float-label active">Date of Birth</label>
                                      <i class="material-symbols-outlined">date_range</i>
                                      <input type="text" name="dob" id="dobedit" class="form-control" placeholder="" value="<?php if( $patientDetails['dob'] != ''): ?> <?php echo e(date('m/d/Y', strtotime($patientDetails['dob']))); ?> <?php endif; ?>" >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline phoneregcls mb-3">
                                    <div class="country_code phone">
                                     
                                          <input type="hidden" id="countryCodeedit" name="countrycode" value=<?php echo e(isset($patientDetails['country_code'])  ? $patientDetails['country_code'] : '+1'); ?> >
                                      </div>
                                      <!-- <label for="phone" class="float-label ">Phone Number</label> -->
                                      <!-- <i class="material-symbols-outlined">call</i> -->
                                      <input type="tel" name="phone_number" class="form-control" id="phoneedit"  value="<?php echo isset($patientDetails['country_code'])  ? '+'.$patientDetails['country_code'] . $patientDetails['phone_number'] : $patientDetails['phone_number'] ?>" >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-3">
                                    <div class="country_code phone">
                                          <input type="hidden" id="whatsappeditcountryCode" name="whatscountrycode" value=<?php echo e(isset($patientDetails['whatsapp_country_code'])  ? $patientDetails['whatsapp_country_code'] : '+1'); ?> >
                                      </div>
                                      <!-- <label for="whatsapp" class="float-label ">Whatsapp</label>
                                      <i class="fa-brands fa-whatsapp"></i> -->
                                      <input type="tel" name="whatsapp_num"  class="form-control" id="whatsappedit" value="<?php echo isset($patientDetails['whatsapp_country_code'])  ? '+'.$patientDetails['whatsapp_country_code'] . $patientDetails['whatsapp_number'] : $patientDetails['whatsapp_number'] ?>" >
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="d-flex justify-content-end align-items-center mb-3">
                                      <input class="form-check-input btn-outline-checkbox m-0 me-2" name="iswhatsapp" id="iswhatsapp" type="checkbox" <?php if($patientDetails['whatsapp_number'] == $patientDetails['phone_number'] ): ?> checked <?php endif; ?> value="">
                                      <samll class="primary fw-medium">Same as phone number</samll> 
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="form-group form-outline mb-3">
                                      <label for="address" class="float-label">Address</label>
                                      <i class="material-symbols-outlined">home</i>
                                      <input type="text" name="address" id="address" class="form-control" value="<?php echo e($patientDetails['address']); ?>"  >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-3">
                                      <label for="city"class="float-label">City</label>
                                      <i class="material-symbols-outlined">location_city</i>
                                      <input type="text" name="city" class="form-control" id="city" value="<?php echo e($patientDetails['city']); ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-3">
                                      <label for="state" class="float-label ">State</label>
                                      <i class="material-symbols-outlined">map</i>
                                      <input type="text" name="state" class="form-control" id="state" value="<?php echo e($patientDetails['state']); ?>">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-3">
                                      <label for="zip" class="float-label ">Zip</label>
                                      <i class="material-symbols-outlined">home_pin</i>
                                      <input type="text" name="zip" class="form-control" id="zip" value="<?php echo e($patientDetails['zip']); ?>">
                                    </div>
                                  </div>
                                    <div class="col-12">
                                      <div class="d-flex justify-content-end align-items-center mb-3">
                                      <a onclick="editnotes('add')" <?php if($patientDetails['notes'] != ''): ?>  style="display:none;" <?php endif; ?> class="primary fw-medium btn_inline" id="edit"><span class="material-symbols-outlined"> add </span>Add Notes</a>
                                      <a onclick="editnotes('rmv')"  <?php if($patientDetails['notes'] != ''): ?>  style="" <?php endif; ?> class="danger fw-medium btn_inline" style="display:none;" id="editremove"><span class="material-symbols-outlined">delete</span>Remove Notes</a>
                                        <!-- <a href="" class="primary fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add Notes</a> -->
                                      </div>
                                      <div class="form-group form-outline form-textarea mb-3" <?php if($patientDetails['notes'] !=''): ?>  style="" <?php else: ?>  style="display:none;" <?php endif; ?> id="editnotes">
                                        <label for="note" class="float-label">Notes</label>
                                        <i class="fa-solid fa-file-lines"></i>
                                        <textarea class="form-control" name="note" id="noteedit" rows="4" cols="4"><?php echo e($patientDetails['notes']); ?></textarea>
                                      </div>
                                    </div>
                                    
                                    <div class="col-12">
                                      <div class="dropzone-wrapper mb-3 dropzone" id="patientDocsedit">
                                        <!-- <a  class="gray fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add patient files</a> -->
                                      </div>
                                      <div class="files-container mb-3" id="appenddocsedit" >
                                        <?php if(!empty($patientDocument)): ?>
                                        <?php  $i=1; ?>
                                        <?php $__currentLoopData = $patientDocument; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $docsdata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                          <div class="fileBody" id="doc_<?php echo e($docsdata['patient_doc_uuid']); ?>">
                                            <div class="file_info">
                                              <img src="<?php echo e(asset('images/pdf_img.png')); ?>">
                                              <span><?php echo e($docsdata['orginal_name']); ?></span>
                                            </div>
                                            <a onclick="removeDocs('<?php echo e($docsdata['patient_doc_uuid']); ?>')" class="close-btn"><span class="material-symbols-outlined">close</span></a>

                                          </div>
                                          <input type="hidden" id="patient_doc_exists<?php echo e($docsdata['patient_doc_uuid']); ?>" name="existdoc['<?php echo $i;?> ']" value="<?php echo e($docsdata['patient_doc_uuid']); ?>"> 

                                        <?php  $i++ ; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>

                                      </div>
                                    </div>
                         
                                  <div class="col-12">
                                    <div class="btn_alignbox justify-content-end">
                                      <a href="" class="btn btn-outline-primary">Close</a>
                                      <a onclick="updatePatient('<?php echo e($patientDetails['patients_uuid']); ?>')" id="updatepatient" class="btn btn-primary">Update</a>
                                    </div>
                                    
                                  </div>
                                </div>

                            </form>

        <script>

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
      $("#editpatientimage").attr("src","<?php echo e(asset('images/default_img.png')); ?>");
      $("#isremoveedit").val('1');
      $("#isremoveedit").hide();
      $("#upload-imgedit").show();
      $("#removelogoedit").hide();
      
  }

  function removeDocs(key){
   
    Swal.fire({
        title: "Are you sure you want to remove this document?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger",
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        showLoaderOnConfirm: false,
        preConfirm: () => {
          $("#doc_" + key).remove();
          $("#patient_doc_exists" + key).val('');
          
        }
    });


  }

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
Dropzone.autoDiscover = false;
    // Dropzone Configurations
    var dropzone = new Dropzone('#patientDocsedit', {
        url: '<?php echo e(url('/patient/uploaddocument')); ?>',
        addRemoveLinks: true,
        dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span> Add patient files', // Add class for styling
        headers: {
            'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
        },
        init: function() {
         this.on("sending", function(file, xhr, formData) {
                  // Extra data to be sent with the file
                  formData.append("formdata", $('#createinquiry').serialize());
                });
            this.on("removedfile", function(file) {
                $(".remv_" + file.filecnt).remove();
            });
            var filecount = 1;
            this.on('success', function(file, response) {
                if( response.success == 1){
                
                this.removeFile(file);
                file.filecnt = filecount;

                if(response.ext == 'png'){
                  var imagePath = "<?php echo e(asset('images/png_icon.png')); ?>";
                }else if(response.ext == 'jpg'){
                  var imagePath = "<?php echo e(asset('images/jpg_icon.png')); ?>";
                }else if(response.ext == 'pdf'){
                  var imagePath = "<?php echo e(asset('images/pdf_img.png')); ?>";
                }else if(response.ext == 'xlsx'){
                  var imagePath = "<?php echo e(asset('images/excel_icon.png')); ?>";
                }else{
                  var imagePath = "<?php echo e(asset('images/doc_image.png')); ?>";
                }
                var appnd = '<div class="fileBody"><div class="file_info"><img src="'+imagePath+ '"><span>'+ response.docname +'</span>' +
                            '</div><a onclick="removeImage()" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a></div>'+
                            '<input type="hidden" name="patient_docs[' + filecount +'][tempdocid]" value="' + response.tempdocid + '" >';

                $("#appenddocsedit").append(appnd);
                filecount++
                // $("#docuplad").val('1');
                // $("#docuplad").valid();
             }else{
                if (typeof response.error !== 'undefined' && response.error !== null && response.error == 1 ) {
                    swal(response.errormsg);
                     this.removeFile(file);
                }
            }
            });
        },
    });
    $('#dobedit').datetimepicker({
      format: 'MM/DD/YYYY',
            useCurrent: false, 
            // todayHighlight: true,
            // autoclose: true,
            maxDate: new Date() ,                                
    });


        
                     

             $(document).ready(function() {
             
            $("#editform").validate({
            rules: {
              name: {
                    required: true,
                },
                email: {
                    required: true,
                    remote: {
                        url: "<?php echo e(url('/validateemail')); ?>",
                        data: {
                          'type' : 'patient',
                          "id":"<?php echo e($patientDetails['id']); ?>",
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                   
                },
                gender: {
                    required: true,
                },
                dob: {
                    required: true,
                },
                phone_number: {
                    required: true,
                    number : true,
                },
                whatsapp_num: {
                    // required: true,
                    number : true,
                },
                address: {
                    required: true,
                },
                city: {
                    required: true,
                },
                state: {
                    required: true,
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
                    required: 'Please enter your name.',
                },
                email: {
                    required: 'Please enter your email.',
                    customemail: "Please enter a valid email",
                    remote: "Email id already exists in the system."
                },
                gender: {
                    required: 'Please select your gender.',
                },
                dob: {
                    required: 'Please enter your date if birth.',
                },
                phone_number: {
                    required: 'Please enter your phone number.',
                    number : 'Please enter valid phone number.',
                },
                whatsapp_num: {
                    required: 'Please enter your phone number.',
                    number : 'Please enter valid phone number.',
                },
                
                address: {
                    required: 'Please enter your address.',
                },
                city: {
                    required: 'Please enter your city.',
                },
                state: {
                    required: 'Please enter your state.',
                },
                zip: {
                    required: 'Please enter your zip code..',
                    number :  'Please enter valid zip code.',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-number")) {
                   
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

  function updatePatient(key) {
   
   if ($("#editform").valid()) {
     $("#updatepatient").addClass('disabled');
     $.ajax({
       url: '<?php echo e(url("/patient/update")); ?>',
       type: "post",
       data: {
        'key' :key ,
         'formdata': $("#editform").serialize(),
         '_token': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data) {
         if (data.success == 1) {
           Swal.fire({
             icon: 'success',
             text: data.message,
           });
           window.location.reload();
         } else {
           Swal.fire({
             icon: 'error',
             text: data.message,
           });
         }
       }
     });
   }
 }
 $(document).ready(function() {
            var telInput = $("#phoneedit"),
              countryCodeInput = $("#countryCodeedit"),
              errorMsg = $("#error-msg"),
              validMsg = $("#valid-msg");

            // initialise plugin
            telInput.intlTelInput({
                autoPlaceholder: "polite",
                initialCountry: "us",
                formatOnDisplay: false, // Enable auto-formatting on display
                autoHideDialCode: true,
                defaultCountry: "auto",
                ipinfoToken: "yolo",
                preferredCountries: ['us', 'in'],
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
                countryCodeInput.val(countryData.dialCode);
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


            var telInput = $("#whatsappedit"),
              countryCodeInput = $("#whatsappeditcountryCode"),
              errorMsg = $("#error-msg"),
              validMsg = $("#valid-msg");

            // initialise plugin
            telInput.intlTelInput({
                autoPlaceholder: "polite",
                initialCountry: "us",
                formatOnDisplay: false, // Enable auto-formatting on display
                autoHideDialCode: true,
                defaultCountry: "auto",
                ipinfoToken: "yolo",
                preferredCountries: ['us', 'in'],
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
                countryCodeInput.val(countryData.dialCode);
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



    });
          </script>


<?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/patient/edit.blade.php ENDPATH**/ ?>