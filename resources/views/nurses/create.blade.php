<h4 class="text-center fw-medium mb-0 ">Add New Nurse</h4>
<small class="gray">Please enter the nurse details</small>
<div class="import_section add_img">
    <a href="#" id="nurse-import" data-nurse-import-url="{{route('nurse.import')}}"
        class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal"
        data-bs-target="#import_data">
        <span class="material-symbols-outlined me-1">upload_2</span>
        Import Data
    </a>
</div>

<form id="nurse-create-form" method="post" action="{{route('nurse.store')}}" enctype="multipart/form-data" autocomplete="off">
    @csrf
    <div class="row">

        <div class="create-profile">
            <div class="profile-img position-relative">
                <img id="nurseimage" src="{{asset('images/default_img.png')}}" class="img-fluid">
                <a href="{{ url('crop/nurse')}}" id="upload-img" class="aupload"><img id="doctorimg"
                        src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" style="display:none;"
                    onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

            </div>



            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>

        <div class="col-12 col-lg-6">
            <div class=" form-group form-outline mb-4">
                <label for="input" class="float-label">Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input name="name" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input name="email" id="email" data-uuid="" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline phoneregcls mb-4">
                <!-- <label for="input" class="float-label">Phone</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCode" name="countrycode" value='US'>
                    <input type="hidden" id="countryCodeShort" name="countryCodeShort" value='us'>
                </div>
                <i class="material-symbols-outlined me-2">call</i>
                <input id="phone" name="phone_number" type="text" data-uuid="" class="form-control"
                    placeholder="Phone Number">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Department</label>
                <i class="material-symbols-outlined">id_card</i>
                <input name="department" class="form-control">

            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Qualification</label>
                <i class="material-symbols-outlined">school</i>
                <input name="qualification" class="form-control">
            </div>
        </div>
    

        <div class="col-12 col-lg-6">
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="specialties" id="specialties" class="form-select">
                    <option value="">Select a Specialty</option>
                    @foreach ($specialties as $specialty)
                        <option value="{{$specialty->id}}">{{$specialty->specialty_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

    </div>


    <div class="btn_alignbox justify-content-end mt-2">
        <a href="" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal"
            data-bs-target="#loader">Close</a>
        <button id="btndisable" class="btn btn-primary">Submit</button>
    </div>
</form>

<script>
    //Image Upload
    function nurseImage(imagekey, imagePath) {
        $("#tempimage").val(imagekey);
        $("#nurseimage").attr("src", imagePath);
        $("#nurseimage").show();
        $("#upload-img").hide();
        $("#removelogo").show();
    }

    function removeImage() {

        $("#nurseimage").attr("src", "{{asset('images/default_img.png')}}");
        $("#isremove").val('1');
        $("#removelogo").hide();
        $("#upload-img").show();

    }
    $(".aupload").colorbox({
        iframe: true,
        width: "650px",
        height: "650px"
    });




    var telInput = $("#phone"),
        countryCodeInput = $("#countryCode"),
        countryCodeShort = $("#countryCodeShort"),
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
        preferredCountries: ['us','in'],
        nationalMode: false,
        numberType: "MOBILE",
        separateDialCode: true,
        geoIpLookup: function (callback) {
            $.get("http://ipinfo.io", function () { }, "jsonp").always(function (resp) {
                var countryCode = (resp && resp.country) ? resp.country : "";
                callback(countryCode);
            });
        },
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // Ensure latest version
    });

    var reset = function () {
        telInput.removeClass("error");
        errorMsg.addClass("hide");
        validMsg.addClass("hide");
    };

    telInput.on("countrychange", function (e, countryData) {
        var countryShortCode = countryData.iso2;
        countryCodeInput.val(countryData.iso2);
        countryCodeShort.val(countryShortCode);
    });

    telInput.blur(function () {
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
    
    $(document).ready(function () {
        var form = $("#nurse-create-form");

        $(form).validate({
            rules: {
                name: "required",
                email: {
                    required: true,
                    email: true,
                    // customemail: true,
                   
                    remote: {
                      url: "{{ url('/validateuserphone') }}",

                      data: { 
                          'type': 'clinicUser',
                          'uuid': "",
                          '_token': $('input[name=_token]').val(),
                          'clinic_id': function () {
                              return "{{session('user.clinicID')}}"; 
                              }, 
                          'country_code': function () {
                              return $("#countryCodeShort").val(); 
                              }, 
                          'email': function () {
                              return $("#email").val(); 
                              },  
                              'phone_number': function () {
                            return $("#phone").val(); 
                            },            
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
       

                    // remote: {
                    //     url: "{ url('/validatephonenew') }}",
                    //     data: {
                    //         'type': 'other',
                    //         'country_code': function () {
                    //             return $("#countryCode").val(); // Get the updated value
                    //         },
                    //         'phone_number': function () {
                    //             return $("#phone_number").val(); // Get the updated value
                    //         },
                    //         '_token': $('input[name=_token]').val()
                    //     },
                    //     type: "post",
                    // },
                },
                phone_number: {
                    required: true,
                    minlength: 10,
                    maxlength: 13,
                    number: true,

                    remote: {
                      url: "{{ url('/validateuserphone') }}",

                      data: { 
                          'type': 'clinicUser',
                          '_token': $('input[name=_token]').val(),
                          'clinic_id': function () {
                              return "{{session('user.clinicID')}}"; 
                              }, 
                          'country_code': function () {
                              return $("#countryCodeShort").val(); 
                              }, 
                          'email': function () {
                              return $("#email").val(); 
                              },  
                              'phone_number': function () {
                            return $("#phone").val(); 
                            },            
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



                    // remote: {
                    //     url: "{ url('/validatephonenew') }}",
                    //     type: "post",
                    //     data: {
                    //         'type': 'clinic_user',
                    //         'email': function () {
                    //             return $("#email").val(); // Get the updated value
                    //         },
                    //         'country_code': function () {
                    //             return $("#countryCodeShort").val(); // Get the updated value
                    //         },
                    //         '_token': $('input[name=_token]').val()
                    //     },             
                
                    // },
                },
                department: "required",
                qualification: "required",
                specialties: "required",
            },
            messages: {
                name: "Please enter name",
                email: {
                    required: "Please enter email address",
                    email: "Please enter a valid email address",
                    regex: "Please enter a valid email address",
                    remote: "Email already exist in system",
                },
                phone_number: {
                    required: 'Please enter phone number.',
                    minlength: 'Please enter a valid number.',
                    maxlength: 'Please enter a valid number.',
                    number: 'Please enter a valid number.',
                    remote: "Phone number or email already exists in the system."
                },
                department: "Please enter department",
                qualification: "Please enter qualification",
                specialties: "Please select specialty",
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("phone-number")) {
                    // Remove previous error label to prevent duplication
                    $("#phonenumber-error").remove();
                    // Insert error message after the correct element
                    error.insertAfter(".separate-dial-code");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
 
            // Disable the submit button to prevent multiple submissions
            var submitButton = $(form).find("#btndisable");
            submitButton.prop("disabled", true);
            submitButton.text("Submitting...");

            form.submit(); 
        },
            
            success: function (label) {
                // If the field is valid, remove the error label
                label.remove();
            },
        });
    });

</script>

<script src="{{asset('js/placeholderPosition.js')}}"></script>