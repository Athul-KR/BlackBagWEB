<div class="text-start mb-3">           
    <h4 class="fw-bold mb-0 primary">Edit Subscription Plan</h4>
    <small class="gray fw-light">Update your subscription plan and customize fees for in-person and virtual visits.</small>
</div>
<form method="POST" id="editplanform" autocomplete="off">
    @csrf
    <div class="row g-4"> 
        <div class="col-12"> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Plan Name</label>
                <i class="material-symbols-outlined">workspace_premium</i>
                <input type="text" name="plan_name" class="form-control" id="plan_name" value="{{$subscritionDetails['plan_name']}}">
            </div>
        </div>
        <div class="col-12"> 
            <div class="form-group form-outline form-textarea">
                <label for="" class="float-label">Plan Description</label>
                <i class="fa-solid fa-file-lines"></i>
                <textarea class="form-control" name="description" rows="4" cols="4">{{$subscritionDetails['description']}}</textarea>
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Monthly Subscription Fee</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="monthly_amount" class="form-control" id="monthly_fee" value="{{$subscritionDetails['monthly_amount']}}" > 
            </div>
        </div>
        <div class="col-12 col-lg-6"> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Yearly Subscription Fee</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="annual_amount" class="form-control" id="yearly_fee"  value="{{$subscritionDetails['annual_amount']}}">
            </div>
        </div>
        <div class="col-12">
            <h5 class="fw-medium">Choose Subscription Icon</h5>
            <div class="form-group select-outline">
                    <div class="align_middle justify-content-start">
                    @if(!empty($planIcons))
                        @foreach($planIcons as $pik => $piv)
                          <div id="icon_{{$piv->id}}" onclick="selectIcon('{{$piv->id}}')" class="icon-div @if( $subscritionDetails['plan_icon_id'] == $piv->id) active @endif">
                            <img src="{{asset('/images/plan_icons/'.$piv->icon_path)}}" alt="{{$piv->name}}" style="width: 40px;">
                          </div>
                        @endforeach
                    @endif
                    <input type="hidden" name="plan_icon_id" id="plan_icon_id" value="{{$subscritionDetails['plan_icon_id']}}"/>
                </div>
            </div>
        </div>
    </div>
    <h5 class="fw-medium mt-4">Appointment Fee</h5>
    <div class="form-check my-2">
        <input class="form-check-input appointment-type" type="checkbox" id="appointmentfee" name="has_per_appointment_fee" @if($subscritionDetails['has_per_appointment_fee'] == 1) checked @endif>
        <small class="primary">Do you have a different per appointment fee for this subscription.</small>
    </div>
    <div class="row appoinmentfee mt-3" @if($subscritionDetails['has_per_appointment_fee'] == 0) style="display:none;" @endif> 
        <div class="col-12"> 
            <p class="fw-middle primary mb-2">Enter per appointment fee</p>
        </div>
        <div class="col-12 col-lg-6"  @if(isset($clinicDetails) && !empty($clinicDetails) && $clinicDetails['appointment_type_id'] == '1') style="display:none" @endif > 
            <div class="form-group form-outline">
                <label for="" class="float-label">In Person</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="inperson_fee" class="form-control" id="inperson_fee" @if($subscritionDetails['has_per_appointment_fee'] == 1) value="{{$subscritionDetails['inperson_fee']}}" @else value="{{$clinicDetails['inperson_fee']}}" @endif>
            </div>
        </div>
        <div class="col-12 col-lg-6" @if(isset($clinicDetails) && !empty($clinicDetails) && $clinicDetails['appointment_type_id'] == '2') style="display:none" @endif> 
            <div class="form-group form-outline">
                <label for="" class="float-label">Virtual</label>
                <i class="material-symbols-outlined">local_atm</i>
                <input type="text" name="virtual_fee" class="form-control" id="virtual_fee" @if($subscritionDetails['has_per_appointment_fee'] == 1) value="{{$subscritionDetails['virtual_fee']}}" @else value="{{$clinicDetails['virtual_fee']}}" @endif>
            </div>
        </div>
    </div>
    <input type="hidden" name="subscription_uuid" id="subscription_uuid"  value="{{$subscritionDetails['clinic_subscription_uuid']}}" >
</form>


<div class="btn_alignbox justify-content-end mt-4">
    <a class="btn btn-outline" data-bs-dismiss="modal">Cancel</a>
    <a onclick="updatePlan()" class="btn btn-primary" >Update Plan</a>
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
    });

    
    $(document).ready(function () {
        $("#editplanform").validate({
            ignore: [],
            rules: {
                plan_name : {
                    required: true,
                    remote: {
                        url: "{{ url('/validateplan') }}",
                        data: {
                            'type': 'plan',
                            'id'  : '{{$subscritionDetails['id']}}',
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
                            return $('#inperson_fee').is(':visible');
                        }
                    },
                    amountCheck: {
                        depends: function(element) { 
                            return $('#inperson_fee').is(':visible');
                        }
                    },
                    greaterThanTen: {
                        depends: function(element) { 
                            return $('#inperson_fee').is(':visible');
                        }
                    },
                },
                virtual_fee:{
                    required: {
                        depends: function(element) { 
                            return $('#virtual_fee').is(':visible');
                        }
                    },
                    amountCheck: {
                        depends: function(element) { 
                            return $('#virtual_fee').is(':visible');
                        }
                    },
                    greaterThanTen: {
                        depends: function(element) { 
                            return $('#virtual_fee').is(':visible');
                        }
                    },
                },
                plan_icon_id : 'required'
            },

            messages: {
                plan_name : {
                    required  :"Please enter plan name.", 
                    remote :"This plan name already added.", 
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