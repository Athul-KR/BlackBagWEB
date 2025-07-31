<div class="row">
    <div class="col-lg-6">
        <div class="subscription-box">
    <div>
        <h4>Subscribe to Blackbag ePrescribe</h4>
        <div class="amount align-items-start gap-2">
            <div class="d-flex flex-column">
                <div class="align_middle align-items-start">
                    <h1 class="display-5 fw-bold mb-0">$79.00</h1>
                    <p class="fw-light mb-0">per doctor</p>
                </div>
                <p>ePrescription Monthly Fee</p>
            </div>
        </div>

        <div class="feature-box d-flex  gap-3">
        <img src="{{asset('images/bb-eprescribe.png')}}" class="escribe-icon">
        <div>
        <strong>Blackbag ePrescribe</strong><br />
        <small>
        BlackBag ePrescribe unlocks fast, accurate, and secure digital prescribing — helping you save time, reduce errors, and deliver a seamless experience for your patients.
        </small>
        </div>
        </div>
        <div class="amount-list mb-4">
        @if($isEprescribeEnabled == '0')
        <div class="d-flex justify-content-between mb-2">
        <p>One Time Setup Fee</p>
        <span><strong>$250.00</strong></span>
        </div>
        @endif
        <div style="display:none;" id="presamountdiv">
        <div class="d-flex justify-content-between mb-2">
        <p>Amount Per Prescriber <small @if($is_prorated == '0') style="display:none;" @endif>(Pro-rated Amount)</small></p>
        <span class="amount-detail">($<span id="prescriber-amount">79.00</span> × <span id="prescriber-count">1 </span>) <strong class="ms-1">$<span id="amount-total">79.00</span></strong></span>
        </div>
        </div>

        <hr />
        <div class="d-sm-flex  justify-content-between total-price text-end  ">
        <span>Total Due Today</span>
        <span class="ms-2">$<span id="total-due">@if($isEprescribeEnabled == '1') 0.00 @else 250.00 @endif</span></span>
        </div>
        </div>
    </div>
    <div class="Powered">
        <p class="p-0">Powered by <img src="{{asset('images/dosespot.png')}}" class=""></p>
    </div>

    </div>

</div>

    <!-- Subscription Form -->
    <div class="col-lg-6">
        <div class="form-container ">
            <form id="enableaddonform" method="post" autocomplete="off">
                <!-- Prescriber Selection -->
                <div class="mb-4">
                    @if(count($users) == 1 && session('user.licensed_practitioner') != '1' )
                    <h4 class="fw-bold mb-3">Primary Contact of the Clinic - {{Session::get('user.clinicName')}}</h4>
                    @else
                    <h4 class="fw-bold mb-3">Prescribers</h4>
                    @endif
                    <div class="row selecteduserclserror">
                        @if(count($users) > 1)
                        <div class="col-12">
                            <div class="form-group form-outline no-iconinput">
                                <label for="input" id="appendusers">Select Users</label>
                                <div class="dropdownBody">
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                            <li class="dropdown-item">
                                                <div class="form-outline input-group ps-1">
                                                    <div class="input-group-append">
                                                    <button class="btn border-0" type="button">
                                                        <i class="fas fa-search fa-sm"></i>
                                                    </button>
                                                    </div>
                                                    <input type="text" class="form-control border-0 small" placeholder="Search Patient" aria-label="Search" aria-describedby="basic-addon2">
                                                </div>
                                            </li>
                                            @if(!empty($users))
                                                @foreach($users as $user)
                                                    <li class="dropdown-item">
                                                        <div class="dropview_body profileList d-flex align-items-center">
                                                            <?php 
                                                                $corefunctions = new \App\customclasses\Corefunctions;
                                                                if(isset($user['user_type_id']) && ($user['user_type_id'] == '1' || $user['user_type_id'] == '2')){
                                                                    $image = $corefunctions -> resizeImageAWS($user['id'],$user['logo_path'],$user['name'],180,180,'1');
                                                                    $name = $corefunctions -> showClinicanNameUser($user,'0');
                                                                }else{
                                                                    $image = $corefunctions -> resizeImageAWS($user['id'],$user['logo_path'],$user['name'],180,180,'1');
                                                                    $name = $user['name'];
                                                                }
                                                            ?>
                                                            <input class="form-check-input user-checkbox me-2" type="checkbox" id="user_{{ $user['clinic_user_uuid'] }}" name="users[]" data-name="{{ $name }}" value="{{ $user['clinic_user_uuid'] }}" onclick="updateSelectedUsers('{{$user['clinic_user_uuid']}}')" @if($user['eprescribe_enabled'] == '1') checked disabled @endif>
                                                            <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                                            <p class="m-0">{{ $name }}</p>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else                                           
                            <div class="col-12">
                                @if(!empty($users))
                                    @foreach($users as $user)
                                        <div class="slt-prescribers">
                                            <div class="user_inner">
                                                <?php 
                                                    $corefunctions = new \App\customclasses\Corefunctions;
                                                    if($user['user_type_id'] == '1' || $user['user_type_id'] == '2'){
                                                        $image = $corefunctions -> resizeImageAWS($user['id'],$user['logo_path'],$user['name'],180,180,'1');
                                                        $name = $corefunctions -> showClinicanNameUser($user,'0');
                                                    }else{
                                                        $image = $corefunctions -> resizeImageAWS($user['id'],$user['logo_path'],$user['name'],180,180,'1');
                                                        $name = $user['name'];
                                                    }
                                                ?>
                                                <img src="{{$image}}" class="img-fluid">
                                                <div class="user_info">
                                                    <h6 class="primary fw-medium m-0">{{$name}}</h6>
                                                    <p class="m-0">{{$user['email']}}</p>
                                                </div>
                                            </div>
                                            @if(session('user.licensed_practitioner') == '1')
                                            <div class="gray-borde mt-3 mb-3"></div>
                                          
                                            <div class="prescribers">
                                            <p class="m-0">Would you like to enable Blackbag ePrescribe for this prescriber?</p>
                                                <div class="d-flex">
                                                    <div class="form-check me-3">
                                                        <input class="form-check-input select-user"  name="select_user_{{ $user['clinic_user_uuid'] }}" type="checkbox" data-name="{{ $name }}" data-uuid="{{ $user['clinic_user_uuid'] }}" id="yesCheck_{{ $user['clinic_user_uuid'] }}" onclick="selectUser(this);">
                                                        <label class="form-check-label" for="yesCheck_{{ $user['clinic_user_uuid'] }}">YES</label>
                                                    </div>

                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        <input type="hidden" class="selectedusercls" name="selected_user_ids" id="selectedUserIds">
                    </div>
                </div>
                <!-- Card Info -->
                <div class="payment_method">
                    <h5 class="fw-bold mb-2">Payment Method</h5>
                    <h6 class="sub-h mb-3">Card Information</h6>
                    <div class="row mt-2 selectedcardclserror justify-content-end">
                        <div class="col-auto mb-3">
                            <a  onclick="addCard()" id="addcard" class="d-flex align-items-center gap-2">
                                <span class="material-symbols-outlined primary fw-middle">add</span> 
                                <p class="text-decoration-underline fw-bold primary mb-0">Add Card</p>
                            </a>
                        </div>
                    
                        @if(!empty($userCards))
                            @include('frontend.cards')
                        @else
                            <div class="flex justify-center">
                                <div class="text-center no-records-body">
                                    <img src="{{asset('images/nodata.png')}}"
                                        class="">
                                    <p>No Cards Added Yet</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <input type="hidden" id="cardadded" name="cardadded" @if(!empty($userCards)) value="1" @endif>
                    
                    
                </div>

                <!-- Billing Address -->
                <h5 class="fw-bold my-3">Billing Address</h5>
                <div class="row g-4 mb-4">
                    <div class="col-md-12">
                        <div class="form-group form-outline no-iconinput textarea-align">
                            <label for="billingaddress" class="float-label">Address</label>
                            <textarea name="address" id="billingaddress" class="form-control" rows="1">@if(!empty($addressdata)){{trim($addressdata['billing_address'])}}@endif</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-outline no-iconinput">
                            <label for="billingcity" class="float-label">City</label>
                            <input type="text" class="form-control" id="billingcity" name="city" @if(!empty($addressdata)) value="{{$addressdata['billing_city']}}" @endif>
                        </div>
                    </div>
                
                    <div class="col-md-6">
                        <div class="form-group form-floating no-iconinput">
                            <select name="country_id" id="billingcountry_id" data-tabid="basic" class="form-select autofillcountry">
                                <option value="">Select Country</option>
                                @if(!empty($countries))
                                    @foreach($countries as $cds => $cd)
                                        <option value="{{ $cd['id']}}" data-shortcode="{{$cd['short_code']}}" @if(!empty($addressdata) && ($cd['id'] == $addressdata['billing_country_id']) || $cd['id'] == 185)  selected @endif>{{ $cd['country_name']}}</option>
                                    @endforeach
                                @endif
                            </select>
                            <label for="billingcountry_id" class="select-label">Country</label>
                        </div>
                    </div>
                            
                    <div class="col-md-6" id="billingstates">
                        <div class="form-group form-floating no-iconinput">
                            <select name="state_id" id="billingstate_id" data-tabid="basic" class="form-select">
                                <option value="">Select State</option>
                                @if(!empty($states))
                                @foreach($states as $sds)
                                <option value="{{ $sds['id']}}" data-shortcode="{{$sds['state_name']}}" @if(isset($addressdata['billing_state_id']) && $addressdata['billing_state_id'] !='' && $addressdata['billing_state_id'] == $sds['id']) selected @endif>{{ $sds['state_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                            <label for="billingstate_id" class="select-label">State</label>
                        </div>
                    </div>

                    <div class="col-md-6" style="display: none;" id="billingstateOther">
                        <div class="form-group form-outline mb-4">
                            <label for="billingstate" class="float-label">State</label>
                            <i class="material-symbols-outlined">map</i>
                            <input type="text" name="state" class="form-control" id="billingstate"  @if(!empty($addressdata)) value="{{$addressdata['billing_state_other']}}" @endif>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group form-outline no-iconinput">
                            <label for="billingzip" class="float-label">ZIP</label>
                            <input type="text" class="form-control" id="billingzip" name="zip" @if(!empty($addressdata)) value="{{$addressdata['billing_zip']}}" @endif>
                        </div>
                    </div>
                                        
                </div>

                <!-- Disclaimer -->
                <small class="gray d-block mb-3">
                    <span class="text-danger">*</span> By confirming your subscription, you agree to an annual commitment and authorize BlackBag to charge you monthly in accordance with our terms. You may cancel anytime, and your subscription will remain active until the end of the billing period.
                </small>

                <!-- Submit Button -->
                <div class="btn_alignbox justify-content-end mt-3">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-outline-primary">Cancel</button>
                    <button type="button" class="btn btn-primary btn-align" id="subsrptnbtn" onclick="confirmSubscription();">Confirm Subscription</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function addCard(){
        // Save current form data
        var formData = $("#enableaddonform").serializeArray();
        localStorage.setItem('enableAddonFormData', JSON.stringify(formData));
        $("#enableAddon").modal('hide');
        $('#addcardsform')[0].reset();
        $('#addcardsform').validate().resetForm();
        if (typeof cardElement !== 'undefined') {
            cardElement.clear();
        }
        $("#addCard").modal('show');
        initializeAddCard();
        $("#submitbtn").removeClass('disabled');
       
    }
    function initializeAddCard(){
        var stripe = Stripe('{{ env("STRIPE_KEY") }}');
        // Create an instance of Elements.
        var elements = stripe.elements();
        var style = {
            hidePostalCode: true,
            base: {
                color: '#32325d',
                lineHeight: '18px',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                fontSmoothing: 'antialiased',
                fontSize: '16px',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        };

        var elements = stripe.elements();
        var cardElement = elements.create('card', {hidePostalCode: true,style: style});
        cardElement.mount('#add-card-element');
        cardElement.addEventListener('change', function(event) {
            var displayError = document.getElementById('add-card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
        var cardholderName = document.getElementById('name_on_card');
        var clientSecret = '';
        var form = document.getElementById("addcardsform");
        form.addEventListener("submit", function(event) {
            event.preventDefault();
            $.ajax({
            type: "POST",
            url: "{{ URL::to('/getclinicstripeclientsecret')}}",
            data: 
            {"_token": "{{ csrf_token() }}"},
            dataType : 'json',
            success: function(data) {
                if(data.success==1){
                var clientSecret = data.clientSecret;
                stripe.confirmCardSetup(
                    clientSecret,
                    {
                    payment_method: {
                        card: cardElement
                    },
                    }
                ).then(function(result) {
                    console.log(result);
                    if (result.error) {
                    var errorElement = document.getElementById('new-card-errors');
                    errorElement.textContent = result.error.message;
                    $("#add-card-errors").show();
                    $("#cardvalid").val('');
                    } else {
                    $("#cardvalid").val('1');
                    stripeTokenHandler(result.setupIntent.payment_method,result.setupIntent.id);
                    }
                });
                }
                }
            });
        });
    }
    $(document).ready(function() {
        var useruuid = "{{$useruuid}}";
        updateSelectedUsers(useruuid);
        if (useruuid && useruuid !== 'null') {
            $('#dropdownMenuLink').prop('disabled', true);

            $('.dropdown-menu').css({
                'pointer-events': 'none',
                'opacity': '0.6'
            });
        }
        $('#billingcountry_id').on('change', function() {
            stateUSBilling();
        });
      
        stateUSBilling("1");
        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');

            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }

        // Initialize all inputs on page load
        $('input, textarea, select').each(function () {
            toggleLabel(this);
        });

        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function () {
            toggleLabel(this);
        });

        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function (e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });

        $('#addcardsform').validate({
            ignore: [],
            rules: {
                name_on_card: {
                    required: true,
                    letterswithspaces: true
                },
                card_number: {
                    required: true,
                },
                expiry_month: {
                    required: true,
                },
                expiry_year: {
                    required: true,
                },
                ccv: {
                    required: true,
                    minlength: 3,
                    number: true
                },
            },
            messages: {
                name_on_card: {
                    required: "Please enter your name",
                    letterswithspaces: "Please enter valid name."
                },
                card_number: {
                    required: "Please enter card number",
                    minlength:"Please enter valid card number",
                    number:"Please enter valid card number",
                },
                expiry_month: {
                    required: "Please select a month",
                    max: "Please enter valid month ",
                    min:"Please enter valid monthr ",
                    number:"Please enter valid month",
                },
                ccv: {
                    required: "Please enter cvv",
                    minlength:"Please enter valid cvv ",
                    number:"Please enter valid cvv",
                },
                expiry_year: {
                    required: "Please select a year",
                    min:"Please enter valid year",
                    number:"Please enter valid year",
                }
            },
        });

        $.validator.addMethod("letterswithspaces", function(value, element) {
            return this.optional(element) || /^[A-Za-z\s]+$/i.test(value);
        }, "Please enter only letters and spaces");

        var isEprescribeEnabled = "{{$isEprescribeEnabled}}";
        $("#enableaddonform").validate({
            ignore: [],
            rules: {
                selected_user_ids: {
                    required: {
                        depends: function (element) {
                            return (
                                isEprescribeEnabled === "1"
                            );
                        }
                    },
                },
                cardadded: 'required',
                selected_card: 'required',
                address: 'required',
                city: 'required',
                country_id: 'required',
                state: {
                    required: {
                        depends: function (element) {
                            return (($("#billingcountry_id").val() != '185'));
                        },
                    },
                },
                state_id: {
                    required: {
                        depends: function (element) {
                        return (($("#billingcountry_id").val() == '185'));
                        }
                    },
                },
                zip: {
                    required: true,
                    zipmaxlength: {
                        depends: function (element) {
                        return (($("#billingcountry_id").val() != '236') && $("#country").val() != '235');
                        }
                    },
                    regex: {
                        depends: function (element) {
                        return ($("#billingcountry_id").val() == '236');
                        }
                    },
                    zipRegex: {
                        depends: function (element) {
                        return ($("#billingcountry_id").val() == '235');
                        }
                    },
                },
            },

            messages: {
                selected_user_ids: "Please select atleast one user.",
                cardadded: 'Please add atleast one card',
                selected_card: {
                    required: "Please select a card",
                },
                country_id: "Please select country.",
                address: "Please enter address.",
                city: "Please enter city.",
                state: "Please enter state.",
                state_id: 'Please enter state',
                zip: {
                    required: 'Please enter zip',
                    zipmaxlength: 'Please enter a valid zip.',
                    digits: 'Please enter a valid zip.',
                    regex: 'Please enter a valid zip.',
                    zipRegex: 'Please enter a valid zip.',
                },
            },
            errorPlacement: function (error, element) {
                if (element.hasClass("selectedusercls")) {
                    error.insertAfter(".selecteduserclserror");
                }else if (element.hasClass("selectedcardcls")) {
                    error.insertAfter(".selectedcardclserror");
                }else {
                    error.insertAfter(element);
                }
            },
        });
        $.validator.addMethod("regex", function (value, element) {
            return /^[0-9]{5}$/.test(value);
        }, "Please enter a valid ZIP code.");
        $.validator.addMethod("zipRegex", function (value, element) {
            return /^[a-zA-Z0-9]{5,7}$/.test(value);
        }, "Please enter a valid ZIP code.");
        $.validator.addMethod("zipmaxlength", function (value, element) {
            return /^\d{1,6}$/.test(value);
        }, "Please enter a valid ZIP code.");
    });
    function selectUser(element){
        if(element.checked) {
            $("#presamountdiv").show();
            <?php
                $Corefunctions = new \App\customclasses\Corefunctions;
            ?>
            var isEprescribeEnabled = "{{$isEprescribeEnabled}}";
            var selectedNames = [];
            let pricePerPrescriber = parseFloat("{{$Corefunctions->getAddOnAmount()}}");
            let eprescribeFee = 250.00;
            let count = 1;

            let selectedIds = [];
            $('.select-user:checked').each(function () {
                const uuid = $(this).data('uuid');
                if (!selectedIds.includes(uuid)) {
                    selectedIds.push(uuid);
                }
            });

            let prescriberTotal = count * pricePerPrescriber;
            let total = prescriberTotal;
            if (isEprescribeEnabled === "0") {
                total += eprescribeFee;
            }
            let label = ( count == 1) ? 'Prescriber' : 'Prescribers';
            $('#prescriber-count').html(`${count} <small>${label}</small>`);
            $('#prescriber-amount').text(pricePerPrescriber.toFixed(2));
            $('#amount-total').text(prescriberTotal.toFixed(2));
            $('#total-due').text(total.toFixed(2));
          
            $('#selectedUserIds').val(selectedIds);
            $('#selectedUserIds').valid();


        } else {
            $("#presamountdiv").hide();
            let totalamount = '250.00';
            $('#total-due').text(totalamount);
            $('#selectedUserIds').val('');
            $('#selectedUserIds').valid();
        }
    }
    function updateSelectedUsers(userKey){
        var useruuid = "{{$useruuid}}";
        $("#user_"+useruuid).prop('checked',true);
        /* check the selected user is valid or not  */
        $.ajax({
            url: '{{ url("users/checkaddon") }}',
            type: "post",
            data: {
                'userKey' : userKey ,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    if( data.isUsUser == 0 ){
                        swal('warning','ePrescirption can only be enabled for US based clinicians/admins.','warning');
                        $('#user_'+userKey).prop('checked', false);
                        return ;
                    }else{
                        if (data.isShow == 1) {
                            swal('warning','Some required profile details are missing. Please complete them to proceed.','warning');
                            $('#user_'+userKey).prop('checked', false);
                            return ;
                        }else{
                            <?php
                                $Corefunctions = new \App\customclasses\Corefunctions;
                            ?>
                            var isEprescribeEnabled = "{{$isEprescribeEnabled}}";
                            var selectedNames = [];
                            var selectedIds = [];
                            let pricePerPrescriber = parseFloat("{{$Corefunctions->getAddOnAmount()}}");
                            let eprescribeFee = 250.00;

                            let count = $('.user-checkbox:checked:not(:disabled)').length;

                            $('.user-checkbox:checked:not(:disabled)').each(function () {
                                selectedNames.push($(this).data('name'));
                                let userId = $(this).val(); 
                                if (!selectedIds.includes(userId)) {
                                    selectedIds.push(userId);
                                }
                            });

                            let prescriberTotal = count * pricePerPrescriber;
                            let total = prescriberTotal;
                            if (isEprescribeEnabled === "0") {
                                total += eprescribeFee;
                            }
                            // Update the button text
                            if (selectedNames.length > 0) {
                                $('#appendusers').text(selectedNames.join(', '));
                                $("#presamountdiv").show();
                                // $('#prescriber-count').text(count);
                                let label = ( count == 1) ? 'Prescriber' : 'Prescribers';
                                $('#prescriber-count').html(`${count} <small>${label}</small>`);
                                $('#prescriber-amount').text(pricePerPrescriber.toFixed(2));
                                $('#amount-total').text(prescriberTotal.toFixed(2));
                                $('#total-due').text(total.toFixed(2));
                            } else {
                                $('#appendusers').text('Select Users');
                                $("#presamountdiv").hide();
                                $('#prescriber-count').text('0');
                                $('#prescriber-amount').text('0');
                                $('#amount-total').text('0.00');
                                $('#total-due').text(isEprescribeEnabled === "0" ? eprescribeFee.toFixed(2) : '0.00');
                            }

                            // Store the selected IDs in hidden input
                            $('#selectedUserIds').val(selectedIds);
                            $('#selectedUserIds').valid();
                        }
                }
                }
            },
            error: function(xhr) {
                
                handleError(xhr);
            }
        });
    }
    function stateUSBilling(initial='') {
      
        if ($("#billingcountry_id").val() == 185) {
            $("#billingstates").show();
            $("#billingstateOther").hide();
            $("#billingstate").val('');
        } else {
            $("#billingstates").hide();
            $("#billingstate_id").val('');
            $("#billingstateOther").show();
        }
        updateAutocompleteCountryBilling(initial);
    }
    var autocompletebilling;
    function updateAutocompleteCountryBilling(initial='') {
      
        let countryElement = document.getElementById("billingcountry_id");
        if (!countryElement) {
            console.error("Country select element not found.");
            return;
        }
        // Get the selected option's dataset shortcode
        let selectedOption = countryElement.options[countryElement.selectedIndex];
        let selectedCountry = selectedOption ? selectedOption.dataset.shortcode : 'US';
        // Validate the country code
        if (!selectedCountry || selectedCountry.length !== 2) {
            console.warn('Invalid country code, defaulting to US');
            selectedCountry = 'US';
        }
        console.log('Selected Country Code:', selectedCountry);
        var countrynew = $('#billingcountry_id').val(); 
        if (autocompletebilling) {
            autocompletebilling.setComponentRestrictions({ country: selectedCountry });
        }
        $("#billingaddress, #billingcity, #billingzip, #billingstate_id,#billingstate").each(function () {
            if( initial != '1'){
               console.log(' address null')
                $(this).val('');
            }
            toggleLabel(this);
        });
    }
    function initializeAutocompleteBilling() {
        // First check if Google API is loaded
        if (typeof google === "undefined" || !google.maps || !google.maps.places) {
            console.error("Google Maps API is not loaded yet. Please check your API key and connection.");
            return;
        }

        // Get the billing address input element
        const billingInput = document.getElementById('billingaddress');
        
        // Check if the element exists
        if (!billingInput) {
            console.error("Billing address input element not found with ID 'billingaddress'");
            return;
        }

        // Clear any placeholder
        billingInput.setAttribute("placeholder", "");

        // Get the country value
        const countrynew = $('#billingcountry_id').val();
        const defaultCountry = (countrynew == '185') ? 'US' : 'IN';

        try {
            // Initialize the autocomplete with error handling
            autocompletebilling = new google.maps.places.Autocomplete(billingInput, {
                types: ['geocode', 'establishment'],
                componentRestrictions: { country: defaultCountry }
            });

            if (!autocompletebilling) {
                console.error("Failed to initialize Google Places Autocomplete");
                return;
            }

            console.log("Google Places Autocomplete initialized successfully");

            // Add the place_changed listener
            autocompletebilling.addListener('place_changed', function() {
                const place = autocompletebilling.getPlace();
                console.log(place);
                if (!place || !place.address_components) {
                    console.error("Invalid place selected - no address components found");
                    return;
                }

                // Rest of your existing place_changed handler code
                var addressComponents = {
                    street_number: "",
                    street: "",
                    city: "",
                    state: "",
                    zip: ""
                };

                place.address_components.forEach(component => {
                    const types = component.types;
                    if (!addressComponents.street_number) {
                        addressComponents.street_number = '';
                    }

                    if (place.types.includes("establishment")) {
                        if (!addressComponents.street_number.includes(place.name)) {
                            addressComponents.street_number += (addressComponents.street_number ? ", " : "") + place.name;
                        }
                    }

                    if (types.includes("street_number")) {
                        if (!addressComponents.street_number.includes(component.long_name)) {
                            addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                        }
                    }

                    if (types.includes("route")) {
                        if (!addressComponents.street_number.includes(component.long_name)) {
                            addressComponents.street_number += (addressComponents.street_number ? ", " : "") + component.long_name;
                        }
                    }

                    if (types.includes("locality")) addressComponents.city = component.long_name;
                    if (types.includes("administrative_area_level_1")) addressComponents.state = component.short_name;
                    if (types.includes("postal_code")) addressComponents.zip = component.long_name;

                    if (!addressComponents.city && types.includes("sublocality_level_1")) {
                        addressComponents.city = component.long_name;
                    }

                });

                // Safe function to prevent errors
                function safeSetValue(id, value) {
                    const element = document.getElementById(id);
                    if (element) {
                        element.value = value;
                        const label = element.closest(".form-group")?.querySelector(".float-label");
                        if (label && value.trim() !== "") {
                            label.classList.add("active");
                        }
                    }
                }

                // Set the values safely
               
                safeSetValue('billingaddress', `${addressComponents.street_number || ''} ${addressComponents.street || ''}`.trim());
                safeSetValue('billingcity', addressComponents.city || '');
                safeSetValue('billingzip', addressComponents.zip || '');
                safeSetValue('billingstate', addressComponents.state || '');

                  // Select the state in the dropdown
                let stateDropdown = document.getElementById('billingstate_id');
                console.log(stateDropdown);
                if (stateDropdown) {
                    for (let option of stateDropdown.options) {
                    // console.log('op'+option.text)
                    //   console.log('optt'+addressComponents.state)

                        if (option.dataset.shortcode === addressComponents.state) {
                            option.selected = true;
                            break;
                        }
                    }
                }

                // Validate the fields
                $("#billingaddress, #billingcity, #billingzip, #billingstate_id").each(function() {
                    $(this).valid();
                });
            });

        } catch (error) {
            console.error("Error initializing Google Places Autocomplete:", error);
        }
    }
    function confirmSubscription(){
        if($("#enableaddonform").valid()){
            $("#subsrptnbtn").addClass('disabled');
            $("#subsrptnbtn").prop('disabled',true);
            $.ajax({
                url: '{{ url("/users/submitaddon") }}',
                type: "post",
                data: {
                    'formdata': $("#enableaddonform").serialize(),
                    '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#enableAddon").modal('hide');
                        $("#successSubscription").modal('show');
                        setTimeout(function() {
                            if (window.location.href.includes('onboarding')) {
                                getOnboardingDetails('eprescribe');
                            }
                        }, 2000);
                        $('#successSubscription').on('hidden.bs.modal', function () {
                            if (window.location.href.includes('onboarding')) {
                                getOnboardingDetails('eprescribe');
                            } else if (window.location.href.includes('myprofile')) {
                                getTabDetails('addons');
                            } else if (window.location.href.includes('profile')) {
                                tabContent('addons');
                            } else {
                                window.location.reload();
                            }
                        });
                    }else{

                    swal({
                        title: "Error!",
                        text: data.errormsg,
                        icon: "error",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                        
                    });
                    $("#subsrptnbtn").removeClass('disabled');
                    $("#subsrptnbtn").prop('disabled',false);

                        // swal("error!",data.errormsg, "error");
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            });
        }
    }
</script>