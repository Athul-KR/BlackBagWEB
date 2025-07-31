<div class="text-start mb-3">           
    <h4 class="fw-bold mb-1 primary">Add Subscription Plan</h4>
    <small class="gray fw-light">Create flexible subscription plans with custom fees for in-person and virtual visits.</small>
</div>
<form method="POST" id="addplanform" autocomplete="off">
@csrf
    <div class="row g-4"> 
        <div class="col-12"> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Plan Name</label>
                <i class="material-symbols-outlined">workspace_premium</i>
                <input type="text" name="plan_name" class="form-control" id="plan_name">
            </div>
        </div>
        <div class="col-12"> 
            <div class="form-group form-outline form-textarea">
                <label for="" class="float-label">Plan Description</label>
                <i class="fa-solid fa-file-lines"></i>
                <textarea class="form-control" name="description" rows="4" cols="4"></textarea>
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Monthly Subscription Fee</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="monthly_amount" class="form-control" id="monthly_fee">
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Yearly Subscription Fee</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="annual_amount" class="form-control" id="yearly_fee">
            </div>
        </div>
        <div class="col-12">
            <h5 class="fw-medium">Choose Subscription Icon</h5>
            <div class="form-group select-outline">
                    <div class="align_middle justify-content-start flex-wrap">
                    @if(!empty($planIcons))
                        @foreach($planIcons as $pik => $piv)
                            <div id="icon_{{$piv->id}}" onclick="selectIcon('{{$piv->id}}')" class="icon-div">
                                <img src="{{asset('/images/plan_icons/'.$piv->icon_path)}}" alt="{{$piv->name}}" style="width: 40px;">
                            </div>
                        @endforeach
                    @endif
                    <input type="hidden" name="plan_icon_id" id="plan_icon_id" />
                </div>
            </div>
        </div>
    </div>
    <h5 class="fw-medium mt-4">Appointment Fee</h5>
    <div class="form-check my-2">
        <input class="form-check-input appointment-type" type="checkbox" id="appointmnetfee" name="has_per_appointment_fee">
        <small class="primary">Do you have a different per appointment fee for this subscription.</small>
    </div>
    
    <div class="row appoinmentfee mt-3" style="display:none;"> 
        <div class="col-12"> 
            <p class="fw-middle primary mb-2">Enter per appointment fee</p>
        </div>
       
        <div class="col-12 col-lg-6" @if($clinicDetails->appointment_type_id == '1') style="display:none;" @endif> 
            <div class="form-group form-outline">
                <label for="" class="float-label">In Person</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="inperson_fee" class="form-control" id="inperson_fee" @if(isset($clinicDetails) && !empty($clinicDetails)) value="{{$clinicDetails->inperson_fee}}" @endif>
            </div>
        </div>
        <div class="col-12 col-lg-6" @if($clinicDetails->appointment_type_id == '2') style="display:none;" @endif> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Virtual</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="virtual_fee" class="form-control" id="virtual_fee" @if(isset($clinicDetails) && !empty($clinicDetails)) value="{{$clinicDetails->virtual_fee}}" @endif>
            </div>
        </div>
    </div>
    <input type="hidden" name="appointment_type_id" value="{{$clinicDetails->appointment_type_id}}" id="appointment_type_id">

    <div class="btn_alignbox justify-content-end mt-4">
        <a class="btn btn-outline"  data-bs-dismiss="modal">Cancel</a>
        <a onclick="addSubscriptionPlan()" id="addplanbtn" class="btn btn-primary" >Add Plan</a>
    </div>
</form>

<script>
$(document).ready(function () {
        $("#addplanform").validate({
                ignore: [],
                rules: {
                    plan_name : {
                        required: true,
                        remote: {
                            url: "{{ url('/validateplan') }}",
                            data: {
                                'type': 'plan',
                                '_token': $('input[name=_token]').val()
                            },
                            type: "post",
                        }
                    },
                    
                    description: 'required',
                    monthly_amount: {
                        required: true,
                        amountCheck: true,
                    },
                    annual_amount: {
                        required: true,
                        amountCheck: true,
                    },
                    inperson_fee:{
                        required: {
                            depends: function(element) { 
                                return ($('#appointmnetfee').is(':checked') && $('#appointment_type_id').val() != '1');
                            }
                        },
                        amountCheck: {
                            depends: function(element) { 
                                return ($('#appointmnetfee').is(':checked') && $('#appointment_type_id').val() != '1');
                            }
                        },
                        greaterThanTen: {
                            depends: function(element) { 
                                return ($('#appointmnetfee').is(':checked') && $('#appointment_type_id').val() != '1');
                            }
                        },
                    },
                    virtual_fee:{
                        required: {
                            depends: function(element) { 
                                return ($('#appointmnetfee').is(':checked') && $('#appointment_type_id').val() != '2');
                            }
                        },
                        amountCheck: {
                            depends: function(element) { 
                                return ($('#appointmnetfee').is(':checked') && $('#appointment_type_id').val() != '2');
                            }
                        },
                        greaterThanTen: {
                            depends: function(element) { 
                                return ($('#appointmnetfee').is(':checked') && $('#appointment_type_id').val() != '2');
                            }
                        },
                    },
                    plan_icon_id : 'required'
                },

                messages: {
                    plan_name : {
                        required :"Please enter plan name.",
                        remote :"This plan name already added."
                    },
                    description: "Please enter description.",
                    monthly_amount: {
                        required: "Please enter appointment fees.",
                        amountCheck: "Please enter a valid fee.",
                    },
                    annual_amount: {
                        required: "Please enter appointment fees.",
                        amountCheck: "Please enter a valid fee.",
                    },
                    inperson_fee: {
                        required: "Please enter appointment fees.",
                        amountCheck: "Please enter a valid number.",
                        greaterThanTen: "Please enter 0 or an amount greater than or equal to 10.",
                    },
                    virtual_fee: {
                        required: "Please enter appointment fees.",
                        amountCheck: "Please enter a valid number.",
                        greaterThanTen: "Please enter 0 or an amount greater than or equal to 10.",
                    },
                    plan_icon_id : 'Please choose a subscription icon.'
                },
                errorPlacement: function (error, element) {
                    if(element.hasClass("timedurationcls")){
                        error.insertAfter(".timedurationerr");
                    }else if(element.hasClass("appointment_typecls")){
                        error.insertAfter(".appointmenttypeerr");
                    }else{
                        error.insertAfter(element);
                    }

                },
            });
            // Custom method to check for amount check
            $.validator.addMethod(
                "amountCheck", // Custom method name
                function(value, element) {
                    // Regular expression for amount validation
                    var regex = /^(?!0\d)(\d{1,3}(,\d{3})*|\d+)(\.\d{1,10})?$/;

                    // Check if the value is optional or matches the regex
                    return this.optional(element) || regex.test(value);
                },
                "Please enter a valid amount."
            );
            $.validator.addMethod(
                "greaterThanTen",
                function(value, element) {
                    if (this.optional(element)) return true;

                    var amount = parseFloat(value.replace(/,/g, '')); // Remove commas and parse

                    return amount === 0 || amount >= 10;
                },
                "Please enter 0 or an amount greater than or equal to 10."
            );
    });
</script>