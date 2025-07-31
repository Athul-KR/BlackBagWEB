<h4 class="text-center fw-medium mb-0 ">Edit Nurse</h4>
<small class="gray">Please enter the nurse details</small>
<div class="import_section add_img">
    <!-- <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">add</span>Import Data</a> -->
</div>

<form id="nurse-edit-form" method="post" action="{{route('nurse.update',[$nurse->clinic_user_uuid,'type'=> $type])}}" enctype="multipart/form-data">
    @csrf
    <div class="row">

        <div class="create-profile">
            <div class="profile-img position-relative">

                <img id="nurseimage" src="{{asset($nurse['logo_path'])}}" class="img-fluid">
                <a href="{{ url('crop/nurse')}}" id="upload-img" class="aupload" @if($nurse['logo_path'] !=asset("images/default_img.png") ) style="display:none;" @endif><img id="doctorimg" src="{{asset('images/img_select.png')}}" class="img-fluid" data-toggle="modal"></a>
                <a class="profile-remove-btn" href="javascript:void(0);" id="removelogo" @if($nurse['logo_path'] !=asset("images/default_img.png") ) style="" @else style="display:none;" @endif onclick="removeImage()"><span class="material-symbols-outlined">delete</span></a>

            </div>
            <input type="hidden" id="tempimage" name="tempimage" value="">
            <input type="hidden" name="isremove" id="isremove" value="0">
        </div>


        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Name</label>
                <i class="fa-solid fa-circle-user"></i>
                <input name="name" value="{{$nurse->name}}" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Email</label>
                <i class="fa-solid fa-envelope"></i>
                <input name="email" id="email" value="{{$nurse->email}}" data-url="{{route('nurse.checkEmailExist')}}" data-uuid="{{$nurse->clinic_user_uuid}}" class="form-control">
            </div>

            @error('email')
            <span class=" text-danger error">{{ $message }}</span>
            @enderror
        </div>
        <!-- 
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Phone</label>
                <i class="fa-solid fa-envelope"></i>
                <input name="phone" id="phone2" data-url="{{route('nurse.checkPhoneExist')}}" type="text" value="{{$nurse->phone}}" class="form-control">
            </div>
        </div> -->

        <div class="col-12 col-lg-6">
            <div class="form-group form-outline phoneregcls mb-4">
                <!-- <label for="input" class="float-label">Phone Number</label> -->
                <div class="country_code phone">
                    <input type="hidden" id="countryCodes" name="countrycode" value={{ isset($countryCode['short_code'])  ? $countryCode['short_code'] : 'US' }}>
                    <input type="hidden" id="countryCodeShort" name="countryCodeShort" value={{ isset($countryCode['short_code'])  ? $countryCode['short_code'] : 'us' }}>
                </div>
                <i class="material-symbols-outlined me-2">call</i>
                <input type="text" class="form-control"  id="phone" name="phone_number" placeholder="Phone Number" value="<?php echo isset($countryCode['country_code'])  ? '+' . $countryCode['country_code'] . $nurse['phone_number'] : $nurse['phone_number'] ?>">
            </div>
        </div>

        <div class="col-12 col-lg-6">

            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Department</label>
                <i class="material-symbols-outlined">id_card</i>
                <input name="department" value="{{$nurse->department}}" class="form-control">
            </div>
        </div>
        <div class="col-12 col-lg-6">
            <div class="form-group form-outline mb-4">
                <label for="input" class="float-label">Qualification</label>
                <i class="material-symbols-outlined">school</i>
                <input name="qualification" value="{{$nurse->qualification}}" class="form-control">
            </div>
        </div>
         <div class="col-12 col-lg-6">
            <div class="form-group form-outline select-outline mb-4">
                <i class="material-symbols-outlined">workspace_premium</i>
                <select name="specialties" id="specialties" class="form-select">
                    @foreach ($specialties as $specialty)
                        <option value="{{$specialty->id}}" {{$nurse->specialty_id == $specialty->id ? 'selected': ''}} >{{$specialty->specialty_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>


    <div class="btn_alignbox justify-content-end mt-2">
        <a href="" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#loader">Close</a>
        <a href="javascript:void(0)" id="btndisable" onclick="updateNurse()" class="btn btn-primary" >Submit</a>
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
    
function updateNurse() {
    if ($("#nurse-edit-form").valid()) {
       console.log("hi");
      $("#btndisable").addClass('disabled');
      $("#btndisable").text("Submitting..."); 
     $("#nurse-edit-form").submit();
    }
  }
    $(document).ready(function() {

        var telInput = $("#phone"),
            countryCodeInput = $("#countryCodes"),
            countryCodeShort = $("#countryCodeShort"),
            errorMsg = $("#error-msg"),
            validMsg = $("#valid-msg");

        // Get the initial country code from the hidden input
        var initialCountryCode = $("#countryCodes").val();




        // initialise plugin
        telInput.intlTelInput({
            autoPlaceholder: "polite",
            // initialCountry: initialCountryCode.replace('+', ''), // Strip the '+' for the initialCountry
            initialCountry: "us",

            formatOnDisplay: false, // Enable auto-formatting on display
            autoHideDialCode: true,
            defaultCountry: "auto",
            ipinfoToken: "yolo",
            preferredCountries: ['us'],
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
            var countryShortCode = countryData.iso2;
                countryCodeInput.val(countryData.iso2);
                countryCodeShort.val(countryShortCode);
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

    });
    $(document).ready(function() { 
$("#nurse-edit-form").validate({
            rules: {
            name: "required",
            email: {
                    required: true,
                    email: true,
                    // customemail: true,
                    remote: {
                        // url: "{{ url('/validatephone') }}",
                        // data: {
                        //     'type' : 'other',
                        //     "id":"{{$nurse->id}}",
                        //     'country_code' : function () {
                        //       return $("#countryCode").val(); // Get the updated value
                        //     },
                        //     '_token': $('input[name=_token]').val()
                        // },
                        // type: "post",

                        url: "{{ url('/validateuserphone') }}",

                        data: { 
                            'type': 'clinicUser',
                            "id":"{{$nurse->user_id}}",
                            '_token': $('input[name=_token]').val(),
                            'clinic_id': function () {
                                return "{{session('user.clinicID')}}"; 
                                }, 
                            'country_code': function () {
                                return $("#countryCodeShort").val(); 
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
                },
             phone_number: {
                    required: true,
                    minlength: 10,
                    maxlength: 13,
                    number: true,
                    remote: {
                        // url: "{{ url('/validatephone') }}",
                        // data: {
                        //     'type' : 'other',
                        //     "id":"{{$nurse->id}}",
                        //     'country_code' : function () {
                        //       return $("#countryCode").val(); // Get the updated value
                        //     },
                        //     '_token': $('input[name=_token]').val()
                        // },
                        // type: "post",

                        url: "{{ url('/validateuserphone') }}",

                        data: { 
                            'type': 'clinicUser',
                            "id":"{{$nurse->user_id}}",
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
                remote: "Email already exist",
            },
            phone_number: {
                        required: 'Please enter phone number.',
                        minlength: 'Please enter a valid number.',
                        maxlength: 'Please enter a valid number.',
                        number: 'Please enter a valid number.',
                        remote: "Phone number already exists in the system." 
                    },
            department: "Please enter department",
            qualification: "Please enter qualification",
            specialties: "Please enter specialty",
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

<script src="{{asset('js/placeholderPosition.js')}}"></script>