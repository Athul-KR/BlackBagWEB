<div class="tab-pane fade show active" id="pills-patientsubscription" role="tabpanel" aria-labelledby="pills-patientsubscription-tab">
    <div class="border rounded-4 p-4 h-100"> 
        <div class="d-flex justify-content-between flex-lg-row flex-column align-items-center mb-4 flex-wrap gap-3">
            <h5 class="primary fw-medium mb-0">Patient Subscription Plans</h5>
            <div class="btn_alignbox justify-content-lg-end">
                @if(empty($isGeneric))
                <button class="btn btn-outline-primary align_middle" onclick="previewTemplates('subscription_plan','','generic')"  ><span class="material-symbols-outlined">file_save</span> Use a Template </button>
                @endif
                <button class="btn btn-primary align_middle" onclick="addNewPlan()"><span class="material-symbols-outlined">add</span>Add Plan</button>
            </div>
        </div>
        <div class="row g-4 planslist">
            @if( $subscritionList)
                @foreach( $subscritionList as $plans)
                    <div class="col-12">
                        <div class="border rounded-4 p-4 bg-white"> 
                            <div class="row">
                                <div class="col-12 col-lg-8">
                                    <div class="user_inner plan-img mb-1">
                                        <img src="{{asset('images/plan_icons/'.$planIcons[$plans['plan_icon_id']]['icon_path'])}}" >
                                        <h3 class="fw-bold mb-0">{{$plans['plan_name']}}</h3>
                                    </div>
                                    <p class="gray mb-3"><?php echo nl2br(e($plans['description'])) ?></p>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="btn_alignbox d-flex justify-content-lg-end align-items-md-start gap-2 mb-lg-0 mb-3 w-100">
                                        <a class="btn opt-btn" onclick="editPlan('{{$plans['clinic_subscription_uuid']}}')">
                                            <span class="material-symbols-outlined">edit</span>
                                        </a>
                                        <a class="btn opt-btn danger" onclick="deletePlan('{{$plans['clinic_subscription_uuid']}}')">
                                            <span class="material-symbols-outlined">delete</span>
                                        </a>
                                        @if(count($subscritionList) > 1)
                                        <a class="btn opt-btn move-cursor handle">
                                            <span class="material-symbols-outlined">drag_pan</span>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="gray-border"></div>
                            <div class="row text-center mt-3 g-2">
                                <div class="col-md-12 col-lg-5">
                                    <div class="d-lg-flex gap-3 text-start align-items-end"> 
                                        <h2 class="fw-bold mb-0 font-large">${{$plans['monthly_amount']}}</h2>
                                        <small class="gray d-lg-block d-flex align-items-center">Monthly <br class="d-lg-block d-none ">Subscription Fee</small>
                                    </div>
                                </div>
                                <div class="col-lg-1 border-l d-lg-block d-none"></div>           
                                <div class="col-md-12 col-lg-5">
                                    <div class="d-lg-flex gap-3 text-start align-items-end">
                                        <h2 class="fw-bold mb-0 font-large">${{$plans['annual_amount']}}</h2>
                                        <small class="gray d-lg-block d-flex align-items-center">Annual <br class="d-lg-block d-none ">Subscription Fee</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
 

<!-- modal -->
<div class="modal login-modal fade" id="addPlan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="appendplandetails">   
                
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal fade" id="editplan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="editplansubcription">   
               
            </div>
        </div>
    </div>
</div>

<!-- Add Preview Modal -->
<div class="modal login-modal fade" id="previewTemplatesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">   
                <div class="text-start mb-3">           
                    <h4 class="fw-bold mb-0 primary"> Generic Plans</h4>
                    <small class="gray fw-light">Review the generic plans before adding them to your clinic.</small>
                </div>
                <div id="previewPlansContainer">
                    @if(!empty($genericPlans))
                        @foreach($genericPlans as $plan)
                        <div class="border rounded-4 p-3 mb-3">
                            <h5 class="fw-bold mb-2">{{$plan['plan_name']}}</h5>
                            <div class="gray-border my-2"></div>
                            <p class="gray mb-2">{{$plan['description']}}</p>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-0 d-flex justify-content-between min-w-tag fw-light me-2"><span>Monthly Fee</span> <span>: </span> </p>
                                        <p class="mb-0 primary fw-bold"> ${{$plan['monthly_amount']}}</p> 
                                    </div>
                                     <div class="d-flex justify-content-between align-items-center">
                                        <p class="mb-1 d-flex justify-content-between min-w-tag fw-light me-2"><span>Annual Fee</span> <span>: </span> </p>
                                        <p class="mb-0 primary fw-bold"> ${{$plan['annual_amount']}}</p> 
                                     </div>
                                </div>
                              
                            </div>
                        </div>
                        @endforeach
                    @endif
                    <div class="info-box">
                        <p class="gray mb-0 align_middle justify-content-start gap-2">
                            <i class="material-symbols-outlined">info</i>
                            These plans will be automatically added to your clinic when you click "Continue".
                        </p> 
                    </div>
                </div>
                <div class="btn_alignbox justify-content-end mt-4">
                    <a class="btn btn-outline" data-bs-dismiss="modal">Cancel</a>
                    <a onclick="savePlanDetails('generic')" id="savegenericplans" class="btn btn-primary">Continue</a>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    function selectIcon(iconid){
        if( $("#icon_"+iconid).hasClass('active') ){
            $("#plan_icon_id").val('');
            $("#icon_"+iconid).removeClass('active');
        }else{
            $(".icon-div").removeClass('active');
            $("#plan_icon_id").val(iconid);
            $("#icon_"+iconid).addClass('active');
        }
        
        $("#plan_icon_id").valid();
    }

    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== '';
        const isFocused = $input.is(':focus');

        $input.closest('.form-group').find('.float-label').toggleClass('active', hasValue || isFocused);
    }

    $(document).ready(function () {
        
        $('input:visible, textarea:visible').each(function () {
            toggleLabel(this);
        });


        $(document).on('focus blur input change', 'input:visible, textarea:visible', function () {
            toggleLabel(this);
        });

        
        $(document).on('dp.change', function (e) {
            const input = $(e.target).find('input:visible, textarea:visible');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });

        $(document).on('click', '#appointmentfee', function () {
            $('input:visible, textarea:visible').each(function () {
                toggleLabel(this);
            });
        });

        $(".planslist").sortable({
            handle: ".handle",
            update: function (event, ui) {
                let order = [];
                $(".planslist > .col-12").each(function (index) {
                let uuid = $(this).find("[onclick^='editPlan']").attr("onclick").match(/'([^']+)'/)[1];
                    order.push({
                        uuid: uuid,
                        sort_order: index + 1
                    });
                });
                $.ajax({
                    url: "{{url('/update-plan-order')}}",
                    method: "POST",
                    data: {
                        order: order,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {
                        console.log("Sort order updated");
                    },
                    error: function () {
                        alert("Failed to update sort order.");
                    }
                });
            }
        });

    });




function previewTemplates(type, formdata='', plantype='') {
    // Show the preview modal
    $('#previewTemplatesModal').modal('show');
}
    $(document).ready(function() {
        
        $(document).on('change', '.appointment-type[type="checkbox"]', function() {
          
            // Check if the checkbox is checked
            if ($(this).is(':checked')) {
                $('.appoinmentfee').show(); // Show the extra input

                $('input').each(function() {
                    toggleLabel(this);
                });
                
            } else {
                $('.appoinmentfee').hide(); 
            }
        });
    });
    function addNewPlan(){
        $(".icon-div").removeClass('active');
        $("#plan_icon_id").val('');
        $.ajax({
            type: "POST",
            url: '{{ url("/clinic/settings/plans/add") }}' ,
            data: {
                "nextstep": 'subscription_plan',
                "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success == 1){
                    $("#editplan").modal('show');
                    $("#editplansubcription").html(response.view);
                    $('#addplanform')[0].reset();
                    $("#addplanbtn").removeClass('disabled');
                    $('label.error').remove();
                    $('.appoinmentfee').hide();
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }

    function addSubscriptionPlan(plantype=''){
        
        if ($("#addplanform").valid()) {
            $("#addplanbtn").addClass('disabled');
            let formdata = $("#addplanform").serialize() ;
            savePlanDetails(plantype,formdata);

           
        }
    }
    function savePlanDetails(plantype,formdata=''){
            $.ajax({
                type: "POST",
                url: '{{ url("/clinic/settings/subscription_plan") }}' ,
                data: {
                    'formdata': formdata,
                    "currentStepId": 1,
                    'plan_type' : plantype,
                    "nextstep": 'subscription_plan',
                    "_token": "{{ csrf_token() }}"
                },
                success: function(response) {
                    if(response.success == 1){
                        $('#previewTemplatesModal').modal('hide');
                        $('#editplan').modal('hide');
                        tabContent('patientsubscription');
                    }else if(response.error == 0){
                       
                        swal('Warning',response.message,'warning')
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            })
    }
    function editPlan(key){
       
        $("#editplan").modal('show');
        $.ajax({
            type: "POST",
            url: '{{ url("/clinic/settings/plan/edit") }}' ,
            data: {
              
                "key": key,
                "nextstep": 'subscription_plan',
                
                    "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success == 1){
                    $("#editplansubcription").html(response.view);
                    $('#appointmnetfee').on('click', function() {
                        console.log('Checkbox clicked');
                        $('input, textarea').each(function () {
                            toggleLabel(this);
                        });
                    });
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })


    }
    function updatePlan(key){
       if( $("#editplanform").valid() ){
        $.ajax({
            type: "POST",
            url: '{{ url("/clinic/settings/subscription_plan") }}' ,
            data: {
              
                "key": key,
                "currentStepId": 4,
                "nextstep": 'subscription_plan',
                'formdata': $("#editplanform").serialize() ,
                    "_token": "{{ csrf_token() }}"
            },
            success: function(response) {
                if(response.success == 1){
                    $("#editplan").modal('hide');
                    tabContent('patientsubscription');
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
       }
    }

    function deletePlan(key){
        swal({
        text: "Are you sure you want to delete the plan?",
            // text: "This action cannot be undone!",
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
        }).then((Confirm) => {
            if (Confirm) {
                $.ajax({
                    type: "POST",
                    url: '{{ url("/clinic/settings/plan/delete") }}' ,
                    data: {
                    
                        "key": key,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if(response.success == 1){
                            swal.close();
                            swal(response.message, {
                            title: "Success!",
                            text: 'Plan deleted successfully',
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                            tabContent('patientsubscription');
                        });
                        
                        }
                    },
                    error: function(xhr) {
                        handleError(xhr);
                    },
                })
            }
        });
    }    
</script>