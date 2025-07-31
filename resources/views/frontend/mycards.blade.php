<div class="border rounded-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h6 class="primary fw-bold mb-0">Card Information</h6>
        <a data-bs-dismiss="modal" onclick="addCard()" id="addcard" class="d-flex align-items-center gap-2">
            <span class="material-symbols-outlined primary fwt-medium">add</span> 
            <p class="text-decoration-underline fwt-medium primary mb-0">Add Card</p>
        </a>
    </div>

    @include('frontend.cards')

</div>

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
    var clientSecret = '<?php echo $clientSecret;?>'
    var form = document.getElementById("addcardsform");
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
                            if (result.error.code === 'expired_card') {
                                console.error(' Card has expired:', result.error.message);
                                swal('Warning','Your card has expired. Please use a valid card.','warning');
                            
                            } else {
                                console.error(' Payment error:', result.error.message);
                                swal('Warning',result.error.message,'warning');
                            
                            }
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
        
    // Submit the form with the token ID.
    function stripeTokenHandler(token,setupIntentID) {
        var form = document.getElementById('addcardsform');
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

        if($("#addcardsform").valid()){
            submitCard();
        }
    }
    $(document).ready(function() {    
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
    });
    function addCard(){
        $("#settingsModal").modal('hide');
        $("#addcard_modal").modal('show');
    }
    function submitCard(){
        if($('#addcardsform').valid()){
            $("#submitbtn").addClass('disabled');
            $("#submitbtn").prop('disabled',true);
            $.ajax({
                url: '{{ url("/addcard") }}',
                type: "post",
                data: {
                    'formdata': $("#addcardsform").serialize(),
                    'type': 'patient',
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        $("#addcard_modal").modal('hide');
                        swal(data.message, {
                            icon: "success",
                            text: data.message,
                            buttons: false,
                            timer: 2000
                        }).then(() => {
                            $("#settingsModal").modal('show');
                            getCards();
                        });
                    } else {
                        swal(data.errormsg, {
                            icon: "error",
                            text: data.errormsg,
                            button: "OK",
                        });
                        $("#submitbtn").removeClass('disabled');
                        $("#submitbtn").prop('disabled',false);

                        $("#settingsModal").modal('hide');

                    }
                },
                error: function(xhr) {
                    
                    handleError(xhr);
                }
            });
        }
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
                    getCards();
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
                                getCards();
                            });
                        } else {
                            swal("Error!", data.message, "error");
                        }
                    }
                });
            }
        });
    }
</script>