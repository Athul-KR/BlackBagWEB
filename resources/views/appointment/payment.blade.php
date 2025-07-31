<div class="modal-header modal-bg p-0 position-relative">
    <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<div class="modal-body">
    <div class="text-center amount_body">
        <h4 class="text-center fwt-bold mb-1">Appointment Fee</h4>
        <small class="gray">Please pay the appointment fee to continue with your appointment. </small>
        <h5 class="mt-3 mb-2 fwt-bold">Total Amount</h5>
        <h3 class="mb-4"><span class="gray">$</span>{{number_format($amount,2)}}</h3>
    </div>
    <form method="POST" action="" id="feechange" autocomplete="off">
    @csrf
        <div class="row" id="carddiv" @if(!empty($userCards)) style="display:block;" @else style="display:none;" @endif>
            <div class="border rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h6 class="primary fw-bold mb-0">Card Information</h6>
                    <a onclick="addCard()" id="addcard" class="d-flex align-items-center gap-2">
                        <span class="material-symbols-outlined primary fwt-medium">add</span> 
                        <p class="text-decoration-underline fwt-medium primary mb-0">Add Card</p>
                    </a>
                </div>

                @include('frontend.cards')

            </div>

            <div class="btn_alignbox mt-5">
                <button type="button" id="submitbtn" class="btn btn-primary w-100" onclick="submitPayment()">Pay Now</button>
            </div>
        </div>

        <div class="row addcarddiv" @if(!empty($userCards)) style="display:none;" @else style="display:block;" @endif>
            <div class="col-12">
                <div class="form-group form-outline mb-4">
                    <i class="material-symbols-outlined">id_card</i>
                    <label for="input" class="float-label">Cardholder Name</label>
                    <input type="name" class="form-control" id="name_on_card" name="name_on_card">
                </div>
            </div>
            <div class="col-12">
                <div id="card-element">

                </div>
            </div>
            <div class="btn_alignbox mt-5">
                <button type="submit" id="submitcardbtn" class="btn btn-primary w-100" >Add Card</button>
            </div>
        </div>
    </form>
</div>

<div id="modal" class="modal" style="display: none;">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <iframe id="modalIframe" src="" style="width: 100%; height: 80vh; border: none;"></iframe>
    </div>
</div>

@php
$corefunctions = new \App\customclasses\Corefunctions; 
@endphp
<script>
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
    cardElement.mount('#card-element');
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('add-card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    var cardholderName = document.getElementById('name_on_card');
    var clientSecret = '<?php echo $clientSecret;?>'
    var form = document.getElementById("feechange");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/getstripeclientsecret')}}",
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
    $(document).ready(function() {
        $('#feechange').validate({
            ignore: [],
            rules: {
                selected_card: {
                    required: {
                        depends: function(element) {
                            return $(element).is(':visible');
                        }
                    }
                },
                name_on_card: {
                    required: {
                        depends: function(element) {
                            return $(element).is(':visible');
                        }
                    }
                },
            },
            messages: {
                selected_card: {
                    required: "Please select a card",
                },
                name_on_card: {
                    required: "Please enter cardholder name",
                },
            },
        });
    });
        
    // Submit the form with the token ID.
    function stripeTokenHandler(token,setupIntentID) {
        var form = document.getElementById('feechange');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'stripeToken');
        hiddenInput.setAttribute('value', token);
        form.appendChild(hiddenInput);
        var hiddenInput1 = document.createElement('input');
        hiddenInput1.setAttribute('type', 'hidden');
        hiddenInput1.setAttribute('name', 'setupintentid');
        hiddenInput1.setAttribute('id', 'setupintentid');
        hiddenInput1.setAttribute('value', setupIntentID);
        form.appendChild(hiddenInput1);

        if($("#feechange").valid()){
            submitCard();
        }
    }
    function continuePayment(setupIntentID){
        var appoinmentuuid = '<?php echo $appoinmentuuid;?>';
        $('#videomeet_modal').modal('show');
        $('#videomeet').html('<div class="d-flex justify-content-center py-5">Processing Payment....</div>');
        $.ajax({
            type: "POST",
            url: "{{url('payment/submitpayment')}}",
            data: {
                'formdata': $('#feechange').serialize(),
                'appoinment_uuid': appoinmentuuid,
                'setupIntentID': setupIntentID,
                "_token": "{{ csrf_token() }}",
            },
            headers: {
              "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.status == 1) {
                    $('#videomeet').html(response.html);
                }
            },
            error: function(xhr) {
               
              handleError(xhr);
            },
        });

    }    
    function addCard(){
        $('#carddiv').hide();
        $('.addcarddiv').show();
    }
    function markAsDefault(key) {
        $.ajax({
            type: "POST",
            url: "{{ URL::to('/markasdefault')}}",
            data: {
                'key': key,
                'type': 'patient',
                "_token": "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
                if (data.success == 1) {
                    tabContent('billings');
                }else{
                    swal(data.message, '', 'error');
                    window.location.reload();
                }
            }
        });          
    }
    function removeCard(key) {
        swal({
            title: '',
            text: 'Are you sure you want to remove this card?',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "POST",
                    url: "{{ URL::to('/removecard')}}",
                    data: {
                        'key': key,
                        'type': 'patient',
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success == 1) {
                            swal("Success!", data.message, "success").then(() => {
                                tabContent('billings'); // Reloads the billing section
                            });
                        } else {
                            swal("Error!", data.message, "error");
                        }
                    }
                });
            }
        });
    }
    function submitPayment(){
        var appoinmentuuid = '{{ $appoinmentuuid }}';
        if($('#feechange').valid()){
            $("#submitbtn").addClass('disabled');
            $("#submitbtn").prop('disabled',true);
            $.ajax({
                type: "POST",
                url: "{{ url('patient/submitpayment') }}",
                data: {
                    'appoinment_uuid': appoinmentuuid,
                    'formdata': $('#feechange').serialize(),
                    "_token": "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function (response) {
                    if (response.status == 1) {
                        $('#videomeet').html(response.html);
                    }else{
                        swal(response.message, {
                            icon: "error",
                            text: response.message,
                            button: "OK",
                        });
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
                        
            });
        }
    }
    function submitCard(){
        var appoinmentuuid = '{{ $appoinmentuuid }}';
        if($('#feechange').valid()){
            $("#submitcardbtn").addClass('disabled');
            $("#submitcardbtn").prop('disabled',true);
            $.ajax({
                url: '{{ url("/addcard") }}',
                type: "post",
                data: {
                    'formdata': $("#feechange").serialize(),
                    'type': 'patient',
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            joinMeet(appoinmentuuid);
                            setTimeout(function(){
                                var radio = $("#selected_card_" + data.key);
                                if (radio.length) {
                                    radio.prop("checked", true).trigger("change");
                                    console.log("Radio checked successfully");
                                    $("#cardadded").val('1');
                                } else {
                                    console.error("Radio button not found");
                                }
                            }, 1000);
                        });
                    } else {
                        swal(data.errormsg, {
                            icon: "error",
                            text: data.errormsg,
                            button: "OK",
                        });
                        $("#submitcardbtn").removeClass('disabled');
                        $("#submitcardbtn").prop('disabled',false);
                    }
                },
                error: function(xhr) {
                    
                    handleError(xhr);
                }
            });
        }
    }
</script>


            