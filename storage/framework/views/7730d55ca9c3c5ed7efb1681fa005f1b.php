<h4 class="text-center fw-medium mb-0 ">Add New Patient</h4>
                            <small class="gray">Please enter the patient’s details</small>
                            
                            <div class="import_section">
                                <a onclick="importPatient()" class="btn btn-outline-primary d-flex align-items-center" ><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a>
                            </div>
                              <form id="patientform" method="POST" > 
                              <?php echo csrf_field(); ?>

                              <div class="create-profile">
                                <div class="profile-img position-relative"> 
                                  <img id="patientimage" src="<?php echo e(asset('images/default_img.png')); ?>" class="img-fluid">
                                  <a  href="<?php echo e(url('crop/patient')); ?>" id="upload-img" class="aupload"><img id="patientimg"src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid" data-toggle="modal"></a>
                                  <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" style="display:none;"  onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

                                </div>

                                

                                <input type="hidden" id="tempimage" name="tempimage" value="">
                                <input type="hidden" name="isremove" id="isremove" value="0">
                              </div>

                                <div class="row"> 
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="input" class="float-label">Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text"  name="name" class="form-control" id="exampleFormControlInput1">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    
                                    <div class="form-group form-outline select-outline mb-4">
                                        <i class="material-symbols-outlined">id_card</i>
                                        <select name="gender" id="gender"  class="form-select">
                                            <option value="">Select Gender</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                                <option value="3">Other</option>
                                            
                                        </select>
                                    </div>

                                     
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="email" class="float-label">Email</label>
                                      <i class="fa-solid fa-envelope"></i>
                                      <input type="email" name="email" id="email"class="form-control" >
                                    </div>
                                  </div>
                                  
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="dob" class="float-label">Date of Birth</label>
                                      <i class="material-symbols-outlined">date_range</i>
                                      <input type="text" name="dob" id="dob" class="form-control">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline phoneregcls mb-4">
                                      <div class="country_code phone">
                                          <input type="hidden" id="countryCode" name="countrycode" value='+1'>
                                      </div>
                                      <!-- <label for="phone" class="float-label">Phone Number</label> -->
                                      <i class="material-symbols-outlined me-2">call</i> 
                                      <input type="text" placeholder="Phone Number" name="phone_number" class="form-control phone-number" id="phone">
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                    <div class="country_code phone">
                                          <input type="hidden" id="whatsappcountryCode" name="whatsappcountryCode" value='+1'>
                                      </div>
                                      <!-- <label for="whatsapp" id="whatapplabel" class="float-label">Whatsapp</label> -->
                                      <i class="fa-brands fa-whatsapp me-2"></i>
                                      <input type="text" name="whatsapp_num"  placeholder="Whatsapp Number" class="form-control" id="whatsapp">
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="d-flex justify-content-end align-items-center mb-3">
                                      <input class="form-check-input btn-outline-checkbox m-0 me-2" name="iswhatsapp" id="iswhatsapp" type="checkbox" value="">
                                      <samll class="primary fw-medium">Same as phone number</samll>
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="form-group form-outline mb-4">
                                      <label for="address" class="float-label">Address</label>
                                      <i class="material-symbols-outlined">home</i>
                                      <input type="text" name="address" id="address" class="form-control" >
                                    </div>
                                  </div>
                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="city" class="float-label">City</label>
                                      <i class="material-symbols-outlined">location_city</i>
                                      <input type="text" name="city" class="form-control" id="city">
                                    </div>
                                  </div>
                                  <div id="statesel" class="col-md-4" style="display:none;">
                                    <div class="form-group form-outline mb-4">
                                      <label for="state" class="float-label">State</label>
                                      <i class="material-symbols-outlined">map</i>
                                      <input type="text" name="state" class="form-control" id="state">
                                    </div>
                                  </div>

                                  <div id="statelist" class="col-md-4" style="display:block;" > 
                                      <div class="form-group form-outline select-outline mb-4">
                                          <i class="material-symbols-outlined">id_card</i>
                                          <select name ="state_id" id="state_id"  class="form-select">
                                              <option value=''>Select a state</option>
                                              <?php if(!empty($state)): ?>
                                                <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                  <option value="<?php echo e($sts['id']); ?>" ><?php echo e($sts['state_prefix']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                              <?php endif; ?>
                                          </select>
                                      </div>
                                  </div>


                                  <div class="col-md-4">
                                    <div class="form-group form-outline mb-4">
                                      <label for="zip" class="float-label">Zip</label>
                                      <i class="material-symbols-outlined">home_pin</i>
                                      <input type="text" name="zip" class="form-control" id="zip">
                                    </div>
                                  </div>

                                    <div class="col-12">
                                      <div class="d-flex justify-content-end align-items-center mb-3">
                                        <a onclick="addnotes('add')" class="primary fw-medium btn_inline" id="add"><span class="material-symbols-outlined"> add </span>Add Notes</a>
                                        <a onclick="addnotes('rmv')" class="danger fw-medium btn_inline" style="display:none;" id="remove"><span class="material-symbols-outlined">delete</span>Remove Notes</a>
                                      </div>
                                      <div class="form-group form-outline form-textarea mb-4"  style="display:none;" id="addnotes">
                                        <label for="note" class="float-label">Notes</label>
                                        <i class="fa-solid fa-file-lines"></i>
                                        <textarea class="form-control" name="note" id="note" rows="4" cols="4"></textarea>
                                      </div>
                                    </div>

                                    <div class="col-12">
                                      <div class="dropzone-wrapper mb-4 dropzone custom-dropzone" id="patientDocs">
                                        <!-- <a href="" class="gray fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add patient files</a> -->
                                      </div>
                                      <div class="files-container mb-3" id="appenddocs" >
                                        
                                     

                                      </div>
                                    </div>
                         
                                  <div class="col-12">
                                    <div class="btn_alignbox justify-content-end">
                                      <a href="" class="btn btn-outline-primary">Close</a>
                                      <a onclick="submitPatient()" id="submitpatient" class="btn btn-primary">Submit</a>
                                    </div>
                                    
                                  </div>
                                </div>

                            </form>


<script>
  Dropzone.autoDiscover = false;
    // Dropzone Configurations
    var dropzone = new Dropzone('#patientDocs', {
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
                console.log(response.ext)
                var appnd = '<div class="fileBody" id="doc_'+filecount+ '"><div class="file_info"><img src="'+imagePath+ '"><span>'+ response.docname +'</span>' +
                            '</div><a onclick="removeImageDoc('+filecount+')"><span class="material-symbols-outlined">close</span></a></div>'+
                            '<input type="hidden" name="patient_docs[' + filecount +'][tempdocid]" value="' + response.tempdocid + '" >';

                $("#appenddocs").append(appnd);
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

    function removeImageDoc(count){
      $("#doc_"+count).remove();
    }
   $(document).ready(function() {
    var telInput = $("#phone"),
    countryCodeInput = $("#countryCode"),
    errorMsg = $("#error-msg"),
    validMsg = $("#valid-msg"),
    whatsappInput = $("#whatsapp"),
    whatsappCountryCodeInput = $("#whatsappcountryCode");

// Initialise plugin for phone number
telInput.intlTelInput({
    autoPlaceholder: "polite",
    initialCountry: "us",
    formatOnDisplay: true,
    autoHideDialCode: true,
    defaultCountry: "auto",
    preferredCountries: ['us', 'in'],
    nationalMode: false,
    separateDialCode: true,
    geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

// Handle country change event
telInput.on("countrychange", function(e, countryData) {
 

    countryCodeInput.val(countryData.dialCode);
    if($('#countryCode').val() == 1 ){
        $("#statelist").show();
        $("#statesel").hide();
      }else{
        $("#statelist").hide();
        $("#statesel").show();
      }
    // If checkbox is checked, update WhatsApp country code too
    if ($("#iswhatsapp").is(':checked')) {
        whatsappCountryCodeInput.val(countryData.dialCode);
    }
});

// Reset error messages
var reset = function() {
    telInput.removeClass("error");
    errorMsg.addClass("hide");
    validMsg.addClass("hide");
};

// Validate phone number
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

telInput.on("keyup change", reset);

// Similar setup for WhatsApp input
whatsappInput.intlTelInput({
    autoPlaceholder: "polite",
    initialCountry: "us",
    formatOnDisplay: true,
    autoHideDialCode: true,
    defaultCountry: "auto",
    preferredCountries: ['us', 'in'],
    nationalMode: false,
    separateDialCode: true,
    geoIpLookup: function(callback) {
        $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
            var countryCode = (resp && resp.country) ? resp.country : "";
            callback(countryCode);
        });
    },
    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
});

whatsappInput.on("countrychange", function(e, countryData) {
    whatsappCountryCodeInput.val(countryData.dialCode);
});

$('#iswhatsapp').change(function() {
        if ($(this).is(':checked')) {
          var fullPhoneNumber = $('#phone').val();
          
            whatsappInput.val(fullPhoneNumber); // Set WhatsApp number
            var selectedCountryData = telInput.intlTelInput("getSelectedCountryData");
            whatsappInput.intlTelInput("setCountry", selectedCountryData.iso2); // Sync WhatsApp flag
        } else {
            whatsappInput.val(''); // Clear WhatsApp input if unchecked
            whatsappCountryCodeInput.val('+1'); // Reset WhatsApp country code (optional default)
            whatsappInput.intlTelInput("setCountry", "us"); // Reset to a default country if needed
        }
    });



    $("#patientform").validate({
            rules: {
              name: {
                    required: true,
                },
                email: {
                    required: true,
                    // customemail: true,
                    remote: {
                        url: "<?php echo e(url('/validateemail')); ?>",
                        data: {
                          'type' : 'patient',
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
                    remote: {
                        url: "<?php echo e(url('/validatephone')); ?>",
                        data: {
                            'type' : 'patient',
                            '_token': $('input[name=_token]').val()
                        },
                        type: "post",
                    },
                },
                address: {
                    required: true,
                },
                city: {
                    required: true,
                },
                state: {
                  required: {
                            depends: function(element) {
                              console.log($("#countryCode").val())
                                return (($("#countryCode").val() != '+1'));
                             
                            }
                    },
                },
             
                state_id: {
                    required: {
                        depends: function(element) {
                            // Trim and check the country code value
                            const countryCode = $.trim($("#countryCode").val());
                            console.log("Country Code:", countryCode);  // Log for verification
                            return (countryCode === '1' || countryCode === '+1');
                        }
                    }
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
                    required: 'Please enter your date of birth.',
                },
                phone_number: {
                    required: 'Please enter your phone number.',
                    number : 'Please enter valid phone number.',
                    remote: "Phone number already exists in the system."
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
                state_id: {
                    required: 'Please select your state.',
                },
                zip: {
                    required: 'Please enter your zip code.',
                    number :  'Please enter valid zip code.',
                },
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-number")) {
                    // Remove previous error label to prevent duplication
                    $("#phonenumber-error").remove(); 
                    // Insert error message after the correct element
                    error.insertAfter(".phone-number");
                } else {
                    error.insertAfter(element);
                }
            },
            success: function(label) {
                // If the field is valid, remove the error label
                label.remove();
            }
        });
        $('#dob').datetimepicker({
          format: 'MM/DD/YYYY',
            useCurrent: false, 
            // todayHighlight: true,
            // autoclose: true,
            maxDate: new Date() , // This will allow only past dates and block future dates
            // onSelect : function() {
            //    $('#dob').valid();
            // }
           
        });
        

        $("#dob").on("change", function() {
          $('#dob').valid();
        });

      });
  </script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/patient/create.blade.php ENDPATH**/ ?>