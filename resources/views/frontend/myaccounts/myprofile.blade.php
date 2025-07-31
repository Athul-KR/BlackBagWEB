<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
    <div class="border rounded rounded-3-3 p-3 h-100">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                <div class="text-lg-start text-center image-body-xl">
                    <img @if($patientDetails['logo_path'] !='' ) src="{{$patientDetails['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif  class="user-img" alt="">
                </div>
                <div class="user_details text-xl-start text-center pe-xl-4">
                    <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                        <h5 class="fw-bold primary text-wrap mb-0">
                            @if(isset($patientDetails['user']) && !empty($patientDetails['user']))
                            {{ $patientDetails['user']['first_name'] }} {{ $patientDetails['user']['middle_name'] }} {{ $patientDetails['user']['last_name'] }}
                            @else
                            {{ $patientDetails['first_name'] }}
                            @if(!empty($patientDetails['middle_name']))
                                {{ $patientDetails['middle_name'] }}
                            @endif
                            {{ $patientDetails['last_name'] }}
                            @endif
                        </h5>
                        <p class="gray mb-0"> @if(isset($patientDetails['user']['email']) ) {{ $patientDetails['user']['email']}} @else {{$patientDetails['email']}} @endif</p>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-3">
                <!-- Edit Button -->
                <button type="button" class="btn btn-outline-secondary d-flex align-items-center"
                    onclick="editSettingsModal()">
                    <span class="material-symbols-outlined">edit</span>
                </button>

                <!-- Delete Account Button -->
                <button onclick="deleteuser()" type="button"
                    class="btn btn-outline-danger d-flex align-items-center">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </div>
        </div>
        <div class="profile-section border-top pt-4">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6 col-6">
                    <small class="d-block gray mb-1">Gender</small>
                    <h6 class="fw-bold mb-0">@if($patientDetails['gender'] == '1') Male @elseif($patientDetails['gender'] == '2') Female @else Other @endif</h6>
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <small class="d-block gray mb-1">Date of Birth</small>
                    <h6 class="fw-bold mb-0"><?php echo $corefunctions->timezoneChange($patientDetails['dob'],"m/d/Y") ?></h6>
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <small class="d-block gray mb-1">Phone Number</small>
                    <h6 class="fw-bold mb-0">@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif  @if(isset($patientDetails['user']['phone_number']) ) <?php echo $corefunctions->formatPhone($patientDetails['user']['phone_number']) ?> @else <?php echo $corefunctions->formatPhone($patientDetails['phone_number']) ?> @endif</h6>
                </div>
                <div class="col-lg-3 col-md-6 col-6">
                    <small class="d-block gray mb-1">WhatsApp Number</small>
                    <h6 class="fw-bold mb-0">@if(!empty($whatsappCountryCode && $patientDetails['whatsapp_number'] !='')){{$whatsappCountryCode['country_code']}} @else -- @endif <?php echo $corefunctions->formatPhone($patientDetails['whatsapp_number']) ?></h6>
                </div>
                <div class="col-12">
                    <small class="d-block gray mb-1">Address</small>
                    <h6 class="fw-bold mb-0"><?php echo nl2br($patientDetails['formattedAddress']) ?></h6>
                </div>
            </div>
        </div>
    </div>

    <script>
         function editSettingsModal(){
            $("#settingsModalProfile").modal('show');
            $('#v-pills-home').html('');
            $('#settingsModalProfile').on('shown.bs.modal', function () {
                profileUpdatemyaccount();
            });
        }

        function profileUpdatemyaccount() {
           
           var url = "{{route('frontend.profileUpdate')}}";
           var key = "{{session()->get('user.user_uuid')}}";
           $('#v-pills-home-profile').html('');
           $('#loaderset').html('<div id="settingsloader" class="justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"  alt="Loader"></div>');
           // $("#v-pills-home").html(
           //     '<div class="d-flex justify-content-center py-5">' + '<img src="{{ asset('images/loader.gif') }}" width="250px">' + '</div>');

           $.ajax({
               url: url,
               type: "post",
               data: {
                   'key': key,
                   '_token': $('meta[name="csrf-token"]').attr('content')
               },
               success: function (data) {
                   console.log('test')
                   if (data.success == 1) {
                      
                    
                       $('#settingsloader').hide();
                       $('#v-pills-home-profile').addClass('show');
                       $('#v-pills-home-profile').addClass('active');
                       $('#v-pills-home-profile').html('');
                       $('#v-pills-home-profile').html(data.view);

                       $('input, textarea').each(function () {
                           toggleLabel(this);
                       });
                       initializeAutocompleteSettings();
                       phonenumberEdit();
                   } else {

                   }
               },
               error: function(xhr) {
              
                   handleError(xhr);
               }
           });

       }
       
    </script>


@if (session()->has('user') && session()->get('user.userType') == 'patient')

    <div class="modal login-modal fade" id="settingsModalProfile" data-bs-backdrop="static" data-bs-keyboard="false"tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span
                            class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body text-center settings_wrapper_modal">
                    <div class="row">

                     
                        <div class="col-xl-12">
                            <div class="tab-content mt-xl-0 mt-3" id="v-pills-tabContent-profile">
                                <div id="loaderset"> </div>
                                <div class="tab-pane fade" id="v-pills-home-profile" role="tabpanel"
                                    aria-labelledby="v-pills-home-tab">

                                </div>
                               
                                <div class="tab-pane " id="v-pills-profile" role="tabpanel"
                                    aria-labelledby="v-pills-profile-tab">
                                    <div class="text-start">
                                        <h5 class="fwt-bold">Change Phone Number</h5>
                                    </div>
                                    <div class="row mt-4" id="change_phone_modal">
                                        <!-- Modal Content -->
                                    </div>
                                </div>

                            
                            </div>
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

@endif

