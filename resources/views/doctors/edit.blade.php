 
 <h4 class="text-center fw-medium mb-0 ">Edit  Doctor</h4>
  <!-- <small class="gray">Please enter the doctor's details</small> -->
    <div class="import_section add_img">
        <!-- <a onclick="importDoctor()" href="javascript:void(0)" class="btn btn-outline-primary d-flex align-items-center" ><span class="material-symbols-outlined me-1">add</span>Import Data</a> -->
    </div>

    <form method="POST" id="editdoctorform" autocomplete="off">
    @csrf
    <div class="row">

        <div class="create-profile">
            <div class="profile-img position-relative"> 
                <img id="doctorimage" @if($doctorDetails['logo_path'] !='')  src="{{asset($doctorDetails['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                <a  href="{{ url('crop/doctor')}}" id="upload-img" class="aupload"  @if($doctorDetails['logo_path'] !='') style="display:none;" @endif><img id="doctorimg"src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" @if($doctorDetails['logo_path'] !='') style="" @else style="display:none;" @endif onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

            </div>
            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>


        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input type="text" class="form-control" id="doctorname" name ="doctorname" value="{{$doctorDetails['name']}}">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input type="email" class="form-control" id="email" name="email" value="{{$doctorDetails['email']}}">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCodes" name="countrycode" value={{ isset($doctorDetails['short_code'])  ? $doctorDetails['short_code'] : 'us' }} >
                </div>
                <i class="material-symbols-outlined me-2">call</i> 
                <input type="text" class="form-control" id="phone_number_edit" name="phone_number" placeholder="Phone Number" value="<?php echo isset($doctorDetails['country_code'])  ? '+'.$doctorDetails['country_code'] . $doctorDetails['phone_number'] : $doctorDetails['phone_number'] ?>" >
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">id_card</i>
                <select name="designation" id="designation"  class="form-select">
                    <option disabled selected>Select a designation</option>
                    @if(!empty($designation))
                      @foreach($designation as $dgn)
                        <option value="{{$dgn['id']}}" @if($doctorDetails['designation_id'] == $dgn['id']) selected @endif>{{$dgn['name']}}</option>
                      @endforeach
                    @endif
                </select>
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Qualification</label>
                <i class="material-symbols-outlined">school</i>
                <input type="text" class="form-control" id="qualification" name="qualification" value="{{$doctorDetails['qualification']}}">
            </div>
        </div>
        
         <div class="col-12 col-lg-6">
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="speciality" id="speciality" class="form-select">
                    @foreach ($specialties as $specialty)
                        <option value="{{$specialty->id}}" {{$doctorDetails['specialty_id'] == $specialty->id ? 'selected': ''}} >{{$specialty->specialty_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>


        
    </div>


  </form>
  @php

$corefunctions = new \App\customclasses\Corefunctions; 
@endphp
    <div class="btn_alignbox justify-content-end mt-2">
        <a href="javascript:void(0)" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Close</a>
        <a href="javascript:void(0)" id="updatedoctr" onclick="updateDoctor('{{$doctorDetails['clinic_user_uuid']}}')" class="btn btn-primary" >Submit</a>
    </div>


  <script type="text/javascript">
function doctorImage(imagekey, imagePath) {
    console.log(imagePath);
    $("#tempimage").val(imagekey);
    $("#doctorimage").attr("src", imagePath);
    $("#doctorimage").show();
    $("#upload-img").hide();
    $("#removelogo").show();
  }

    function removeImage(){

        $("#doctorimage").attr("src","{{asset('images/default_img.png')}}");
        $("#isremove").val('1');
        $("#removelogo").hide();
        $("#upload-img").show();

    }
    $(".aupload").colorbox({
          iframe: true,
          width: "650px",
          height: "650px"
      });

function updateDoctor(key) {
    if ($("#editdoctorform").valid()) {
      $("#updatedoctr").addClass('disabled');
      $("#updatedoctr").text("Submitting..."); 
      $.ajax({
        url: '{{ url("/doctors/update") }}',
        type: "post",
        data: {
            'key' : key,
          'formdata': $("#editdoctorform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
            swal("success!",data.message, "success");
           
            window.location.reload();
          } else {
            swal("error!",data.message, "error");
          
          }
        },
        error: function(xhr) {
               
            handleError(xhr);
        }
      });
    }
  }
   $(document).ready(function() {
    let onlyCountries = {!! json_encode($corefunctions->getCountry()) !!};
    var telInput = $("#phone_number_edit"),
                countryCodeInput = $("#countryCodes"),
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

            telInput.on("keyup change", reset);



$("#editdoctorform").validate({
            rules: {
              doctorname: {
                    required: true,
                },
                email: {
                    required: true,
                    // customemail: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                            'type' : 'other',
                            "id":"{{$doctorDetails['user_id']}}",
                            'countrycode': function () {
                                return $("#countryCodes").val(); // Get the updated value
                            },
                            'phone_number': function () {
                                return $("#phone_number_edit").val(); // Get the updated value
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
                designation: {
                    required: true,
                },
                speciality: {
                    required: true,
                },
                qualification: {
                    required: true,
                },
                 phone_number: {
                    required: true,
                    minlength: 10,
                    maxlength: 13,
                    number: true,
                    remote: {
                        url: "{{ url('/validateuserphone') }}",
                        data: {
                            "id":"{{$doctorDetails['user_id']}}",
                            'type': 'other', // Replace with actual type if necessary
                            'country_code' : function () {
                              return $("#countryCode").val(); // Get the updated value
                            },  
                            'email': function () {
                                return $("#email").val(); // Get the updated value
                            },
                            '_token': $('input[name="_token"]').val() // CSRF token
                        
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
                
            },
            messages: {
                phone_number: {
                        required: 'Please enter phone number.',
                        minlength: 'Please enter a valid number.',
                        maxlength: 'Please enter a valid number.',
                        number: 'Please enter a valid number.',
                        remote: "Phone number already exists in the system." 
                    },
              doctorname: {
                    required: 'Please enter name.',
                },
                email: {
                    required: 'Please enter email.',
                    // customemail: "Please enter a valid email",
                    remote: "Email id already exists in the system."
                },
                designation: {
                    required: 'Please select designation.',
                },
                speciality: {
                    required: 'Please enter speciality.',
                },
                qualification: {
                    required: 'Please enter qualification.',
                }
            },
            errorPlacement: function(error, element) {
                if (element.hasClass("phone-number")) {
                    // Remove previous error label to prevent duplication
                    $("#phonenumber-error").remove(); 
                    // Insert error message after the correct element
                    error.insertAfter(".separate-dial-code");
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
    </script>

<script>
    
                    // Function to toggle the 'active' class


      function toggleLabel(input) {
        const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
        $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
      }
      // function toggleLabel(input) {
      //         $(input).parent().find('.float-label').toggleClass('active', $.trim(input.value) !== '');
      //       }


      $(document).ready(function() {
        // Initialize label state for each input
        $('input').each(function() {
          toggleLabel(this);
        });

        // Handle label toggle on focus, blur, and input change
        $(document).on('focus blur input change', 'input, textarea', function() {
          toggleLabel(this);
        });

        // Handle the datetime picker widget appearance by re-checking label state
        $(document).on('click', '.bootstrap-datetimepicker-widget', function() {
          const input = $(this).closest('.time').find('input');
          toggleLabel(input[0]);
        });

        // Trigger label toggle when modal opens
        $(document).on('shown.bs.modal', function(event) {
          const modal = $(event.target);
          modal.find('input, textarea').each(function() {
            toggleLabel(this);
            // Force focus briefly to trigger label in case of any timing issues
            $(this).trigger('focus').trigger('blur');
          });
        });

        // Reset label state when modal closes
        $(document).on('hidden.bs.modal', function(event) {
          const modal = $(event.target);
          modal.find('input, textarea').each(function() {
            $(this).parent().find('.float-label').removeClass('active');
          });
        });
      });
      // floating label end

  </script>
