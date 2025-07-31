<div class="row">
    <div class="col-12">

        <div class="row">
            <div class="col-lg-3">
                {{-- <div class="text-start">
                            <h4 class="fw-medium mb-4">Medical History</h4>
                        </div> --}}
                <div class="nav flex-column nav-pills settings-tab history-tab gap-2 me-xl-3 border-bottom-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link side_menu active" id="tab-blood-pressure" data-bs-toggle="pill" onclick="getmedicalhistoryData('bp')" type="button" role="tab" aria-controls="content-bp" aria-selected="true">
                        <span class="material-symbols-outlined">blood_pressure</span>Blood Pressure
                    </button>
                    <button class="nav-link side_menu" id="tab-glucose-levels" data-bs-toggle="pill" onclick="getmedicalhistoryData('glucose')" type="button" role="tab" aria-controls="content-glucose" aria-selected="false">
                        <span class="material-symbols-outlined">glucose</span>Glucose Levels
                    </button>
                    <button class="nav-link side_menu" id="tab-cholesterol-levels" data-bs-toggle="pill" onclick="getmedicalhistoryData('cholesterol')" type="button" role="tab" aria-controls="content-cholesterol" aria-selected="false">
                        <span class="material-symbols-outlined">cardiology</span>Cholesterol Levels
                    </button>
                    <button class="nav-link side_menu" id="tab-measurements" data-bs-toggle="pill" onclick="getmedicalhistoryData('measurements')" type="button" role="tab" aria-controls="content-measurements" aria-selected="false">
                        <span class="material-symbols-outlined">body_fat</span>Physical Measurements
                    </button>
                    <button class="nav-link" id="tab-measurements" data-bs-toggle="pill" onclick="getmedicalhistoryData('oxygen-saturations')" data-bs-target="#content-oxygen-saturations" type="button" role="tab" aria-controls="content-oxygen-saturations" aria-selected="false">
                        <span class="material-symbols-outlined">monitor_heart</span>Oxygen Saturations 
                    </button>
                    <button class="nav-link" id="tab-temparature" data-bs-toggle="pill" onclick="getmedicalhistoryData('temparature')" data-bs-target="#content-temparature" type="button" role="tab" aria-controls="content-temparature" aria-selected="false">
                    <span class="material-symbols-outlined">thermometer</span>Body Temperature
                    </button>
                    <button class="nav-link side_menu" id="tab-medications" data-bs-toggle="pill" onclick="getmedicalhistoryData('patient-medications')" type="button" role="tab" aria-controls="content-patient-medications" aria-selected="false">
                        <span class="material-symbols-outlined">pill</span>Medications
                    </button>
                    <button class="nav-link side_menu" id="tab-medical-conditions" data-bs-toggle="pill" onclick="getmedicalhistoryData('medical-conditions')" type="button" role="tab" aria-controls="content-medical-conditions" aria-selected="false">
                        <span class="material-symbols-outlined">respiratory_rate</span>Medical Conditions
                    </button>
                    <button class="nav-link side_menu" id="tab-allergies" data-bs-toggle="pill" onclick="getmedicalhistoryData('allergies')" type="button" role="tab" aria-controls="content-allergies" aria-selected="false">
                        <span class="material-symbols-outlined">allergy</span>Allergies
                    </button>
                    <button class="nav-link side_menu" id="tab-immunizations" data-bs-toggle="pill" onclick="getmedicalhistoryData('immunizations')" type="button" role="tab" aria-controls="content-immunizations" aria-selected="false">
                        <span class="material-symbols-outlined">syringe</span>Immunizations
                    </button>
                    <button class="nav-link side_menu" id="tab-family-history" data-bs-toggle="pill" onclick="getmedicalhistoryData('family-history')" type="button" role="tab" aria-controls="content-family-history" aria-selected="false">
                        <span class="material-symbols-outlined">family_home</span>Family Medical History
                    </button>

                 

                </div>
            </div>
            <div class="col-lg-9">
                <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane contenttype fade show active" id="content-bp" role="tabpanel" aria-labelledby="tab-blood-pressure">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-glucose" role="tabpanel" aria-labelledby="tab-glucose-levels">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-cholesterol" role="tabpanel" aria-labelledby="tab-cholesterol-levels">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-measurements" role="tabpanel" aria-labelledby="tab-measurements">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-oxygen-saturations" role="tabpanel" aria-labelledby="tab-oxygen-saturations">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-temparature" role="tabpanel" aria-labelledby="tab-temparature">
                                    
                     </div>
                    <div class="tab-pane contenttype fade" id="content-patient-medications" role="tabpanel" aria-labelledby="tab-medications">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-medical-conditions" role="tabpanel" aria-labelledby="tab-medical-conditions">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-allergies" role="tabpanel" aria-labelledby="tab-allergies">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-immunizations" role="tabpanel" aria-labelledby="tab-immunizations">

                    </div>
                    <div class="tab-pane contenttype fade" id="content-family-history" role="tabpanel" aria-labelledby="tab-family-history">

                    </div>

                  


                </div>
            </div>
        </div>

    </div>
</div>


<div class="modal login-modal fade" id="confirm-data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-center fw-medium mb-0 ">Are You Sure you want to change this data?</h4>
                <div class="btn_alignbox">
                    <a class="btn btn-outline-primary">Cancel</a>
                    <a class="btn btn-outline-primary">Change Data</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        getmedicalhistoryData('bp');
    });

    function remove(type, cnt) {
        $('#' + type + '_' + cnt).remove();
    }

    function validateUserForm(id, cnt) {
     
        var hasValue = $('#' + id + '_' + cnt + ' input')
            .not('.bptime, .bpdate, .coucetype') // Exclude specific fields
            .filter(function() {
                return this.value.trim() !== ""; // Check if any value exists
            }).length > 0;
           
        if (!hasValue) {
            // If no value exists, display error message
            var errorLabel = $('<label class="text-danger">Please enter at least one value to save the record.</label>');

            // Remove any existing error messages
            $('#' + id + '_' + cnt).find('.text-danger').remove();

            if ($('#' + id + '_' + cnt).find('.error').length === 0) {
                // Append the error message
                $('#' + id + '_' + cnt + ' .inner-history').append(errorLabel);
            }

            return false; // Stop further execution
        } else {
            $('#' + id + '_' + cnt).find('.text-danger').remove();
            return true;
        }
    }


    let isLoading = false;
    let debounceTimer;

    function getmedicalhistoryData(type) {
        // Prevent multiple calls
        if (isLoading) return;

        // Clear any pending timeouts
        clearTimeout(debounceTimer);

        debounceTimer = setTimeout(() => {
            isLoading = true;
            showPreloader('content-' + type);

            $.ajax({
                type: "POST",
                url: '{{ url("/medicalhistory/edit") }}',
                data: {
                    "patientID": "{{$patient['user_id']}}",
                    "type": type,
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success == 1) {
                        const contentArea = $("#content-" + type);
                        contentArea.html(response.view);
                        $(".contenttype").removeClass('show active');
                        contentArea.addClass('show active');
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }, 300); // 300ms debounce delay
    }

    $('.side_menu').on('click', function() {
        $('.side_menu').removeClass('show active');
        $(this).addClass('show active');
    });

    // function getmedicalhistoryData(type) {
    //     showPreloader('content-' + type);
    //     $('.contenttype').each(function() {
    //         $(this).removeClass('active');
    //     });
    //     $.ajax({
    //         type: "POST",
    //         url: '{ url("/medicalhistory/edit") }}',
    //         data: {
    //             "patientID": "{$patient['user_id']}}",
    //             "type": type,
    //             '_token': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         success: function(response) {
    //             // Handle the successful response

    //             if (response.success == 1) {

    //                 const contentArea = $("#content-" + type);
    //                 contentArea.html(response.view); // Replace with new content
    //                 $(".contenttype").removeClass('show active'); // Remove active classes
    //                 contentArea.addClass('show active'); // Add classes to the current content
    //             }


    //         },
    //         error: function(xhr) {

    //             console.log(xhr);
    //         },
    //     });

    // }

    function editMHSection(key, type) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        $.ajax({
            url: '{{ url("/medicalhistory/editform")}}',
            type: "post",
            data: {
                'formtype': type,
                'patientID': patientID,
                'key': key,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    $('#' + type + '_' + key).remove();
                    $('.' + type + 'cls_' + key).html(data.view);
                } else {

                }
            },
            error: function(xhr) {
                console.log(xhr);

                // handleError(xhr);
            },
        });
    }

    function deleteMHSection(key, type) {
        if(type == 'patient-medications'){
            var msg = 'Are you sure you want to delete the medication?';
        }else{
            var msg = 'Are you sure you want to delete the medical history?'; 
        }
        swal({
            text: msg,
            icon: "warning",
            buttons: {
                cancel: "Cancel",
                confirm: {
                text: "OK",
                value: true,
                closeModal: false // Keeps the modal open until AJAX is done
                }
            },
            dangerMode: true
        }).then((willConfirm) => {
            if (willConfirm) {

        $.ajax({
            url: '{{ url("/medicalhistory/deleteform")}}',
            type: "post",
            data: {
                'formtype': type,
                'key': key,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    swal.close();
                    $('#' + type + '_' + key).remove();
                    if (type == 'weight' || type == 'height') {

                        getmedicalhistoryDatapm(type);
                    } else {
                        getmedicalhistoryData(type);
                        
                    }

                } else {

                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }
});
    }
</script>