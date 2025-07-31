<h5 class="text-start fwt-bold mb-0 ">Edit Patient</h5>
<!-- <small class="gray">Please enter the patient’s details</small> -->

<div class="import_section">
  <!-- <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a> -->
</div>
<form id="editform" method="POST">
  <?php echo csrf_field(); ?>

  <div class="create-profile">
    <div class="profile-img position-relative">
      <img id="editpatientimage" <?php if($patientDetails['logo_path'] !='' ): ?> src="<?php echo e($patientDetails['logo_path']); ?>" <?php else: ?> src="<?php echo e(asset('images/default_img.png')); ?>" <?php endif; ?> class="img-fluid">
      <a href="<?php echo e(url('crop/patient')); ?>" id="upload-imgedit" class="aupload" <?php if($patientDetails['logo_path'] !='' ): ?> style="display:none;" <?php endif; ?>><img src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid" data-toggle="modal"></a>
      <a class="profile-remove-btn" href="javascript:void(0);" id="removelogoedit" <?php if($patientDetails['logo_path'] !='' ): ?> style="" <?php else: ?> style="display:none;" <?php endif; ?> onclick="removeProfileImage()"><span class="material-symbols-outlined">delete</span></a>

    </div>
    <input type="hidden" id="tempimageedit" name="tempimage" value="">
    <input type="hidden" name="isremove" id="isremoveedit" value="0">
  </div>

  <div class="row">
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="input" class="float-label">Name</label>
        <i class="fa-solid fa-circle-user"></i>
        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" value="<?php echo e($patientDetails['name']); ?>">
      </div>
    </div>
    <div class="col-lg-4">


      <div class="form-group form-outline select-outline mb-4">
        <i class="material-symbols-outlined">id_card</i>
        <select name="gender" id="gender" class="form-select">
          <option value="">Select Gender</option>
          <option value="1" <?php if($patientDetails['gender']=='1' ): ?> selected <?php endif; ?>>Male</option>
          <option value="2" <?php if($patientDetails['gender']=='2' ): ?> selected <?php endif; ?>>Female</option>
          <option value="3" <?php if($patientDetails['gender']=='3' ): ?> selected <?php endif; ?>>Other</option>

        </select>
      </div>


    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="email" class="float-label">Email</label>
        <i class="fa-solid fa-envelope"></i>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo e($patientDetails['email']); ?>">
      </div>
    </div>


    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="dob" class="float-label active">Date of Birth</label>
        <i class="material-symbols-outlined">date_range</i>
        <input type="text" name="dob" id="dobedit" class="form-control" placeholder="" value="<?php if( $patientDetails['dob'] != ''): ?> <?php echo e(date('m/d/Y', strtotime($patientDetails['dob']))); ?> <?php endif; ?>">
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline phoneregcls mb-3">
        <div class="country_code phone">

          <input type="hidden" id="clinicID" value="<?php echo e($patientDetails['clinic_id']?? ''); ?>">
          <input type="hidden" id="countryCodeedit" name="countrycode" value="<?php echo e($countryCode->country_code ??  '+1'); ?>">
          <input type="hidden" name="countryCodeShort" class="form-control" id="countrycodeShort" value="<?php echo e($countryCode->short_code ?? 'US'); ?>">

        </div>
        <!-- <label for="phone" class="float-label ">Phone Number</label> -->
        <i class="material-symbols-outlined me-2">call</i>
        <input type="tel" name="phone_number" placeholder="Phone Number" class="form-control" id="phoneedit" value="<?php echo e(optional($countryCode)->country_code. ($patientDetails['phone_number'] ?? $patientDetails['phone_number'])); ?>">
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <div class="country_code phone">
          <input type="hidden" id="whatsappeditcountryCode" name="whatscountrycode" value="<?php echo e($whatsappCountryCode->country_code ??  '+1'); ?>">
          <input type="hidden" id="whatsappcountryCodeShorts" name="whatsappcountryCodeShorts" value="<?php echo e($whatsappCountryCode->short_code ?? 'us'); ?>">
        </div>
        <!-- <label for="whatsapp" class="float-label ">Whatsapp</label> -->
        <i class="fa-brands fa-whatsapp me-2"></i>
        <input type="tel" name="whatsapp_num" placeholder="Whatsapp Number" class="form-control" id="whatsappedit" value="<?php echo e(optional($whatsappCountryCode)->country_code . ($patientDetails['whatsapp_number'] ?? $patientDetails['whatsapp_number'])); ?>">
      </div>
    </div>
   
    <div class="col-12">
      <div class="form-group form-outline mb-4">
        <label for="address" class="float-label">Address</label>
        <i class="material-symbols-outlined">home</i>
        <input type="text" name="address" id="address" class="form-control" value="<?php echo e($patientDetails['address']); ?>">
      </div>
    </div>
    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="city" class="float-label">City</label>
        <i class="material-symbols-outlined">location_city</i>
        <input type="text" name="city" class="form-control" id="city" value="<?php echo e($patientDetails['city']); ?>">
      </div>
    </div>
    <div id="statesel" class="col-lg-4" <?php if(isset($patientDetails['country_code']) && ($patientDetails['country_code']=='185' ) ): ?> style="display:none;" <?php else: ?> style="display:block;" <?php endif; ?>>
      <div class="form-group form-outline mb-4">
        <label for="state" class="float-label ">State</label>
        <i class="material-symbols-outlined">map</i>
        <input type="text" name="state" class="form-control" id="state" value="<?php echo e($patientDetails['state']); ?>">
      </div>
    </div>

    <div id="statelist" class="col-lg-4" <?php if(isset($patientDetails['country_code']) && ($patientDetails['country_code']=='185') ): ?> style="display:block;" <?php else: ?> style="display:none;" <?php endif; ?>>
      <div class="form-group form-outline select-outline mb-4">
        <i class="material-symbols-outlined">id_card</i>
        <select name="state_id" id="state_id" class="form-select">
          <option value=''>Select a state</option>
          <?php if(!empty($state)): ?>
          <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <option value="<?php echo e($sts['id']); ?>" <?php if($patientDetails['state_id']==$sts['id']): ?> selected <?php endif; ?>><?php echo e($sts['state_prefix']); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </select>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="form-group form-outline mb-4">
        <label for="zip" class="float-label ">Zip</label>
        <i class="material-symbols-outlined">home_pin</i>
        <input type="text" name="zip" class="form-control" id="zip" value="<?php echo e($patientDetails['zip']); ?>">
      </div>
    </div>


    <div class="col-12">
      <div class="btn_alignbox justify-content-end">
        <a onclick="updatePatient('<?php echo e($patientDetails['patients_uuid']); ?>')" id="updatepatient" class="btn btn-primary">Update</a>
      </div>

    </div>
  </div>

</form>

<link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>">
<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>
<script>
  function editnotes(type) {
    if (type == 'add') {
      $("#editnotes").show();
      $("#editremove").show();
      $("#edit").hide();
    } else {
      $("#editnotes").hide();
      $("#editremove").hide();
      $("#edit").show();
      $("#noteedit").val('');

    }

  }

  function removeProfileImage() {
    console.log('remove')
    $("#editpatientimage").attr("src", "<?php echo e(asset('images/default_img.png')); ?>");
    $("#isremoveedit").val('1');
    $("#isremoveedit").hide();
    $("#upload-imgedit").show();
    $("#removelogoedit").hide();

  }

  function removeDocs(key) {

    swal({
      text: "Are you sure you want to remove this document?",
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


  $('#dobedit').datetimepicker({
    format: 'MM/DD/YYYY',
    useCurrent: false,
    maxDate: new Date(),  // Disables future dates
    ignoreReadonly: true,  // Prevents readonly input if necessary
    // todayHighlight: true,  // Optional to highlight today's date
    // autoclose: true,  // Optional to close picker after selecting
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
            url: "<?php echo e(url('/frontend/checkEmailExist')); ?>",
            data: {
              'type': 'patient',
              'uuid': "<?php echo e($patientDetails['patients_uuid']); ?>",
              '_token': $('input[name=_token]').val(),
              'clinic_id': function () {
                    return $("#clinicID").val(); 
                    }, 
              'phone_number': function () {
                    return $("#phoneedit").val(); 
                    }, 
                'country_code': function () {
                return $("#countrycodeShort").val(); 
                }, 
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
          number: true,
          remote: {
            url: "<?php echo e(url('/frontend/checkPhoneExist')); ?>",

            data: { 
                  'type': 'patient',
                  'uuid': "<?php echo e($patientDetails['patients_uuid']); ?>",
                  '_token': $('input[name=_token]').val(),
                  'clinic_id': function () {
                    return $("#clinicID").val(); 
                    }, 
                  'country_code': function () {
                    return $("#countrycodeShort").val(); 
                    }, 
                  'email': function () {
                    return $("#email").val(); 
                    },             
                },

            type: "post",
          },
        },
        whatsapp_num: {
          // required: true,
          number: true,
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
        state: {
          required: {
            depends: function(element) {

              return (($("#countryCodeedit").val() != '+1'));

            }
          },
        },

        state_id: {
          required: {
            depends: function(element) {
              return (($("#countryCodeedit").val() == '+1'));

            }
          },
        },

        zip: {
          required: true,
          number: true,
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
          number: 'Please enter valid phone number.',
          remote: "Phone number already exist"

        },
        whatsapp_num: {
          required: 'Please enter your phone number.',
          number: 'Please enter valid phone number.',
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
          required: 'Please enter your zip code..',
          number: 'Please enter valid zip code.',
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

  // $(document).on('change', '#clinic', function() {
  //     var phoneNumber = $('#phoneedit').val();
  //     var clinicID=$('#clinic').val();
  //     $('#clinicID').val(clinicID);
  //     $('#editform').validate().element("#email"); 
  //     $('#editform').validate().element("#phoneedit");

  // });


  function updatePatient(key) {

    if ($("#editform").valid()) {
      $("#updatepatient").addClass('disabled');
      $.ajax({
        url: '<?php echo e(url("/frontend/update-patient")); ?>',
        type: "post",
        data: {
          'key': key,
          'formdata': $("#editform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
            swal({ icon: 'success', text: data.message, }).then(() => { window.location.reload(); });
          } else {
            swal({
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
      countryCodeShort = $("#countrycodeShort"),
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
        console.log(countryData);
      var countryShortCode = countryData.iso2;
      countryCodeShort.val(countryShortCode);
      countryCodeInput.val(countryData.dialCode);

      if (countryData.dialCode == 1) {
        $("#statelist").show();
        $("#statesel").hide();
      } else {
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


    var whatsappInput = $("#whatsappedit"),
        whatsappCountryCodeInput = $("#whatsappeditcountryCode"),
        whatsappCodeShort = $("#whatsappcountryCodeShorts"),
        errorMsg = $("#error-msg"),
        validMsg = $("#valid-msg");

      // initialise plugin
      whatsappInput.intlTelInput({
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
      whatsappInput.removeClass("error");
      errorMsg.addClass("hide");
      validMsg.addClass("hide");
    };

    whatsappInput.on("countrychange", function(e, countryData) {
      var countryShortCode = countryData.iso2;
      whatsappCodeShort.val(countryShortCode);
      whatsappCountryCodeInput.val(countryData.dialCode);

    });

    whatsappInput.blur(function() {
      reset();
      if ($.trim(whatsappInput.val())) {
        if (whatsappInput.intlTelInput("isValidNumber")) {
          validMsg.removeClass("hide");
        } else {
          whatsappInput.addClass("error");
          errorMsg.removeClass("hide");
        }
      }
    });



  });
</script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/patient-edit.blade.php ENDPATH**/ ?>