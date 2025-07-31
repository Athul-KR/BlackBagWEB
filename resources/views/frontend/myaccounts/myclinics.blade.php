<?php $corefunctions = new \App\customclasses\Corefunctions; ?>  
                                <div class="btn_alignbox justify-content-end">
                                    <button type="button" class="btn btn-primary align_middle" onclick="addNewClinic()"><span class="material-symbols-outlined">add</span>Add New Clinic</button> 
                                </div>
                                <div class="table-container my-4">
                                    <table class="table align-middle mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" style="width:30%">Clinic</th>
                                                <th scope="col" style="width:20%">Email</th>
                                                <th scope="col" style="width:20%">Phone number</th>
                                                <th scope="col" class="text-end" style="width:30%">Clinicians</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        @if(!empty($clinicsList))
                                            @foreach($clinicsList as $clinic )
                                                <tr>
                                                    <td data-label="Clinic" style="width:30%">
                                                        <div class="user_inner mt-1">
                                                            <img src="{{$clinic['logo_path'] ?? asset('images/default_clinic.png')}}" alt="user">
                                                            <div class="user_info">
                                                                 <h6 class="primary fw-bold m-0">{{$clinic['name']}}</h6>
                                                              
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td data-label="Email" style="width:20%">{{$clinic['email']}}</td>
                                                    <?php $formattedphone = $corefunctions->formatPhone($clinic['phone_number']) ;?>
                                                    <td data-label="Phone number" style="width:20%">{{$countryCodeDetails[$clinic['country_code']]['country_code'] ?? "N/A"}} {{' '}}  {{$formattedphone ?? "N/A"}}</td>
                                                    <td data-label="Clinicians" style="width:30%">
                                                        <div class="expand-wrapper justify-content-end">
                                                          
                                                            @php
                                                                $clinicians = $clinic['clinicians'];
                                                                $displayedClinicians = array_slice($clinicians, 0, 3);
                                                                $remainingCount = count($clinicians) - count($displayedClinicians);
                                                            @endphp

                                                            @if(!empty($displayedClinicians))
                                                                @foreach($displayedClinicians as $clinician)
                                                                    <div class="expand-inner tooltip-container">
                                                                        <img data-bs-toggle="" data-bs-placement="" title="" src="{{ $clinician['image'] }}" class="user">
                                                                        <span class="tooltip">{{ $clinician['name'] }}</span>
                                                                    </div>
                                                                @endforeach
                                                            @endif

                                                            @if($remainingCount > 0)
                                                                <div class="expand-inner more-members" id="viewAllClinicians" data-clinicians='@json($clinicians)'>
                                                                    <span>+{{ $remainingCount }}</span>
                                                                </div>
                                                            @endif


                                                        </div>
                                                    </td>
                                                    <td data-label="Actions">
                                                        <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="material-symbols-outlined">more_vert</span>
                                                        </a>
                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                            <li><a onclick="leaveClinic('{{$clinic['clinic_uuid']}}')" class="dropdown-item fw-medium"><i class="fa-solid fa-right-from-bracket me-2"></i>Leave Clinic</a></li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                        <tr class="text-center">
                                            <td colspan="5">
                                                <div class="flex justify-center">
                                                    <div class="text-center no-records-body">
                                                        <img src="{{asset('images/nodata.png')}}"
                                                            class=" h-auto" alt="no records">
                                                        <p>No records found</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-12">
                                <div class="row">
                                @if(!empty($clinicsList))
                                    <div class="col-lg-6">
                                    <form method="GET"  >
                                        <div class="sort-sec">
                                        <p class="me-2 mb-0">Displaying per page :</p>
                                        <select class="form-select" aria-label="Default select example" name="limit"">
                                            <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                                            <option value="15" {{ $limit == 15 ? 'selected' : '' }}>15</option>
                                            <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                                        </select>
                                        </div>
                                    </form>
                                    </div>
                                @endif
                                <div class="col-lg-6" id="pagination-myclinic">
                                    {{ $clinicsListDetails->links('pagination::bootstrap-5') }}
                                </div>
                                </div>
                            </div>



                        <div class="modal fade" id="allCliniciansModal" tabindex="-1" aria-labelledby="allCliniciansLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header modal-bg p-0 position-relative">
                                        <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center mb-3">
                                            <h4 class="fw-bold">All Clinicians</h4>
                                        </div>
                                        <div class="border rounded-4 p-4 h-100">
                                            <div class="row justify-content-center g-3" id="allClinicianImages">
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



        <script>


            $(document).ready(function () {
                $('#viewAllClinicians').on('click', function () {
                    let clinicians = $(this).data('clinicians');
                    let $container = $('#allClinicianImages');
                    $container.empty(); // Clear old content

                    $.each(clinicians, function (index, clinician) {
                        let name = clinician.name ?? '';
                        let image = clinician.image ?? '{{ asset("images/default_user.png") }}';

                        let html = `
                            
                                <div class="col-6 col-sm-5 col-md-4 col-lg-3">
                                    <div class="clinic-card">
                                        <div class="clinic-img-box tooltip-container">
                                            <img src="${image}" alt="clinician" class="clinic-img">
                                            <span class="tooltip">${name}</span>
                                        </div>
                                        <p class="mt-2 mb-0 small">${name}</p>
                                    </div>
                                </div>
                            
                        `;
                        $container.append(html);
                    });

                    $('#allCliniciansModal').modal('show');
                });
            });


            function addNewClinic(){
              
                $("#addClinic").modal('show');
                $("#clinic_code").val('');
                $("#clinicdetails").hide();
                $("#clinicbtn").addClass('disabled');
                
            }

            $(document).ready(function() {
                $('#clinic_code').on('blur', function() {
                    var clinicCode = $(this).val();
                    getClinicDetails(clinicCode);
                });
                $('#clinic_code').on('keypress', function(event) {
                    if (event.which === 13 || event.key === 'Enter') {
                        event.preventDefault();
                        var clinicCode = $(this).val();
                        getClinicDetails(clinicCode);
                    }
                });
            });
            function getClinicDetails(clinicCode){
                if(clinicCode) {
                    $("#clinicdetails").show();
                    showPreloader('clinicdetails');
                    $.ajax({
                        url: '{{ url("/myaccounts/getclinic") }}',
                        type: "post",
                        data: {
                        'clinicCode': clinicCode,
                        '_token': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            if (data.success == 1) {
                                $("#clinicdetails").show();
                                $("#clinicdetails").html(data.html); 
                                $("#clinicbtn").removeClass('disabled');
                                $('#clinicLogoPreview').attr('src', data.logo);
                                $('#clinicNamePreview').text(data.ClinicName);
                                $('#addressclinic').html(data.address);
                                $('#clinic_user_code').val(clinicCode);
                            }else{
                                if(data.error == 1){
                                    swal('Warning',data.errormsg,'warning');
                                    $(".loaderImg").hide();
                                    $("#clinicdetails").hide();
                                }else{
                                    swal('Error',data.errormsg,'error');
                                    $(".loaderImg").hide();
                                    $("#clinicdetails").hide();
                                }
                            }
                        },
                        error: function(xhr) {
                            handleError(xhr);
                        }
                    });
                }
            }

            function submitClinic(){
                $('#confirmAddClinic').modal('hide');
                $('#loader').modal('show');
               var clinicCode = $('#clinic_user_code').val();
                $.ajax({
                    url: '{{ url("/myaccounts/addtoclinic") }}',
                    type: "post",
                    data: {
                    'clinicCode': clinicCode,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            $('#SuccessLoader').modal('show');
                            // Call changeTab after 2 seconds (2000 milliseconds)
                            setTimeout(function() {
                                $('#SuccessLoader').modal('hide');
                                changeTab('myclinics');
                            }, 2000);  
                        }else{           
                            swal('Error',data.errormsg,'error' )
                        }
                    },
                    error: function(xhr) {
                    
                    handleError(xhr);
                    }
                });

            }


            

            function leaveClinic(clinicKey,type='') {
                swal("Are you sure you want to leave from this clinic?", {
                title: "Warning!",
                icon: "warning",
                buttons: true,
                }   ).then((willDelete) => {
                if (willDelete) {
                        $.ajax({
                            url: '{{ url("/myaccounts/leaveclinic") }}',
                            type: "post",
                            data: {
                                'clinicKey' :clinicKey,
                                'type' : type,
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(data) {
                            
                                if(data.success == 1){
                                    swal("success!", data.message, "success");
                                    changeTab('myclinics');
                                }else if(data.success == 0){
                                    swal("warning!", data.errormsg, "warning");
                                }else{
                                    swal("error!", data.errormsg, "error");
                                }
                            },
                            error: function(xhr) {
                                handleError(xhr);
                            }
                        });

                    }
                });


        }


            
        </script>


    <div class="modal login-modal fade" id="confirmAddClinic" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <div class="modal-body">
                    <div class="text-center px-lg-5 mx-xl-5">
                        <h4 class="fw-bold mb-4 px-lg-5">Are you sure you want to connect with this clinic?</h4>
                    </div>
                
                    <div class="border rounded rounded-3 p-4 h-100"> 
                        <div class="d-flex flex-column justify-content-end text-center gap-3"> 
                            <div class="text-lg-start text-center image-body-xl">
                                <img id="clinicLogoPreview" src="{{asset('frontend/images/search4.png')}}" class="user-img" alt="">
                            </div>
                            <div class="user_details text-xl-start text-center">
                                <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                    <h5 class="fw-bold primary text-wrap mb-0" id="clinicNamePreview"></h5>
                                </div>
                                <div class="text-start mb-1"> 
                                    <label class="sm-label mb-1">Address</label>
                                    <h6 class="mb-0 fw-bold" id="addressclinic"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="clinic_user_code" id="clinic_user_code">
                    <div class="btn_alignbox justify-content-end mt-4"> 
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="submitClinic()">Yes, I’m Sure</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
