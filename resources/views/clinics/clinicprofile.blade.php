<div class="tab-pane fade show active" id="pills-clinicprofile" role="tabpanel" aria-labelledby="pills-clinicprofile-tab">
    <div class="row g-3"> 
        <div class="col-12 col-lg-6"> 
            <div class="border rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="primary fw-medium mb-0">Clinic Details</h5>
                    @if(session()->get('user.isClinicAdmin') == '1')
                    <a class="btn opt-btn align_middle" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editProfileInfo">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    @endif
                </div>
                <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                    <div class="text-lg-start text-center image-body">
                        <img src="{{$clinic['logo'] ?? asset('images/default_clinic.png')}}"  class="user-img" alt="">
                    </div>
                    <div class="user_details text-xl-start text-center pe-xl-4">
                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                            <h5 class="fw-medium dark text-wrap mb-0">{{$clinic->name ?? "N/A"}}</h5>
                            <p class="gray mb-0">{{$clinic->email ?? "N/A"}}</p>
                            @if(!empty($clinic->website_link))
                            <div class="mb-2">
                            <span class="material-symbols-outlined">web_traffic</span>


                                <a class="clinic-web" href="{{ $clinic->website_link }}" target="_blank" >
                                    {{ $clinic->website_link }}
                                </a>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>  <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
                <div class="gray-border my-4"></div>
                <div class="row g-2">

                    <?php $address = $corefunctions->formatAddress($clinic); ?>
                   
                    <div class="col-12"> 
                        <div class="text-start mb-1"> 
                            <p class="primary fw-medium mb-0">Address</p>
                        </div>
                        <div class="text-start"> 
                            <p class="gray mb-0"> <?php echo nl2br($address); ?></p>
                        </div>
                    </div>
                    
                    
                    <div class="col-12 col-xl-6"> 
                        <div class="text-start mb-1"> 
                            <p class="primary fw-medium mb-0">Phone Number</p>
                        </div>
                        <div class="text-start"> 
                          <?php $formattedphone = $corefunctions->formatPhone($clinic['phone_number']) ;?>
                            <p class="gray mb-0">{{$clinicCountryCode['country_code'] ?? "N/A"}} {{' '}}  {{$formattedphone ?? "N/A"}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6"> 
                        <div class="text-start mb-1"> 
                            <p class="primary fw-medium mb-0">Timezone</p>
                        </div>
                        <div class="text-start"> 
                            <p class="gray mb-0">@if(!empty($timezoneDetails) &&  isset($timezoneDetails[$clinic->timezone_id])) {{$timezoneDetails[$clinic->timezone_id]['timezone'] }} @endif</p>
                        </div>
                    </div>
                </div>

                @if($clinic->appointment_type_id != '')
                @endif
                    <div class="gray-border my-4"></div>
                    <div class="row g-2">
                        
                        <h5 class="primary fw-medium mb-0">Appointment Fee</h5>
                        <p> Appointment types that you offer.</p>

                        <div class="d-flex justify-content-start gap-5">
                            <div @if($clinic->appointment_type_id == '1') style="display:none;" @endif>
                                <p class="mb-1 text-muted">In Person</p>
                                <strong>@if($clinic->inperson_fee !='') ${{$clinic->inperson_fee}}  @endif</strong>
                            </div>
                            <div  @if($clinic->appointment_type_id == '2') style="display:none;" @endif>
                                <p class="mb-1 text-muted">Virtual</p>
                                <strong>@if($clinic->virtual_fee !='') ${{$clinic->virtual_fee}}  @endif</strong>
                            </div>
                        </div>

                        <small class="primary fw-middle mb-0"><span class="asterisk">*</span> These are the appointment types that will be available for patients to book.</small>

                    </div>
            

            </div>
        </div>
        @if(!empty($clinicUser))
        <div class="col-12 col-lg-6"> 
            <div class="border rounded-4 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="primary fw-medium mb-0">Primary Contact Details</h5>
                    @if($clinicUser['user_id'] == session()->get('user.userID'))
                    <a class="btn opt-btn align_middle" onclick="editDoctor('{{$clinicUser['clinic_user_uuid']}}')">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                    @endif
                </div>
                <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                    <div class="text-lg-start text-center image-body">
                        <img @if($clinicUser['logo_path'] !='') src="{{asset($clinicUser['logo_path'])}}" @else src="{{asset('images/default_img.png')}}" @endif class="user-img" alt="">
                    </div>
                    <div class="user_details text-xl-start text-center pe-xl-4">
                        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                            <h5 class="fw-medium dark text-wrap mb-0">{{$corefunctions -> showClinicanName($clinicUser,'1')}}</h5>
                            <p class="gray mb-0">{{$clinicUser['email']}}</p>
                        </div>
                    </div>
                </div>
                <div class="gray-border my-4"></div>
                <div class="row g-2"> 
                    <div class="col-7"> 
                        <div class="text-start"> 
                            <p class="primary fw-medium mb-0">Phone Number </p>
                        </div>
                    </div>
                    <div class="col-5"> 
                        <div class="text-end"> 
                            <p class="gray mb-0">@if(!empty($countryCodeDetails)){{$countryCodeDetails['country_code']}} @endif <?php echo $corefunctions->formatPhone($clinicUser['phone_number']) ?></p>
                        </div>
                    </div>
                    <div class="col-7"> 
                        <div class="text-start"> 
                            <p class="primary fw-medium mb-0">NPI</p>
                        </div>
                    </div>
                    <div class="col-5"> 
                        <div class="text-end"> 
                            <p class="gray mb-0">{{$clinicUser['npi_number'] ?? "--"}}</p>
                        </div>
                    </div>
                    <div class="col-7"> 
                        <div class="text-start"> 
                            <p class="primary fw-medium mb-0">Designation</p>
                        </div>
                    </div>
                    <div class="col-5"> 
                        <div class="text-end"> 
                            <p class="gray mb-0">{{$clinicUser['designation']}}</p>
                        </div>
                    </div>
                    <div class="col-7"> 
                        <div class="text-start"> 
                            <p class="primary fw-medium mb-0">Speciality</p>
                        </div>
                    </div>
                    <div class="col-5"> 
                        <div class="text-end"> 
                            <p class="gray mb-0">@if(isset($clinicUser['doctor_specialty']['specialty_name'])) {{$clinicUser['doctor_specialty']['specialty_name']}} @else -- @endif</p>
                        </div>
                    </div>
                </div>


           


            </div>
        </div>
        @endif
    </div>
</div>


<!-- edit Doctor Modal -->
<div class="modal login-modal fade" id="editDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editDoctor"></div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>

    $('#dobedit').datetimepicker({
      format: 'MM/DD/YYYY',
            useCurrent: false, 
            // todayHighlight: true,
            // autoclose: true,
            maxDate: new Date() ,                                
    });
  // Function to toggle the 'active' class
  function toggleLabel(input) {
        const hasValueOrFocus = $.trim(input.value) !== '' || $(input).is(':focus');
        $(input).parent().find('.float-label').toggleClass('active', hasValueOrFocus);
    }
    $(document).ready(function() {
        initializeAutocomplete(); 
        $('#phone').mask('(ZZZ) ZZZ-ZZZZ', {
              translation: {
                'Z': {
                  pattern: /[0-9]/,
                  optional: false
                }
              }
            })

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



function editDoctor(key) {
    $("#editDoctor_modal").modal('show');
    showPreloader('editDoctor')
    $.ajax({
      url: '{{ url("/users/edit") }}',
      type: "post",
      data: {
        'key' : key ,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#editDoctor").html(data.view);
            // Initialize label state for each input
            $('input').each(function() {
            toggleLabel(this);
            });
        }
      },
      error: function(xhr) {
               
            handleError(xhr);
        }
    });
  }
  </script>
