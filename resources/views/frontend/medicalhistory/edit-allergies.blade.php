@if(!empty($medicathistoryDetails))

        <form method="POST" id="editallergyform" autocomplete="off">
            @csrf
            <div class="row align-items-start"> 
                <div class="col-md-10"> 
                    <div class="row"> 
                        <div class="col-md-6"> 
                            <div class="history-box mb-md-0 mb-3"> 
                                <div class="form-group form-outline">
                                    <label class="float-label">What Are You Allergic To?</label>
                                    <input type="text" class="form-control valcls" name="allergies[0][allergy]" value="{{$medicathistoryDetails['allergy']}}" placeholder="">
                                </div> 
                            </div>
                        </div>
                        <div class="col-md-6"> 
                            <div class="history-box"> 
                                <div class="form-group form-outline">
                                    <label class="float-label">Reaction / Side Effect</label>
                                    <input type="text" class="form-control valcls" name="allergies[0][reaction]" value="{{$medicathistoryDetails['reaction']}}" placeholder="">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                        <input type="hidden" name="hasallergyvalue" id="hasallergyvalue"/>
                    </div>
                </div>
                <div class="col-md-2"> 
                    <div class="btn_alignbox justify-content-end">
                        <a class="opt-btn" onclick="updateAllergyForm('allergies','{{$medicathistoryDetails['allergies_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('allergies')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endif
<script>
    function hasAllergyFormValue() {
        var hasVal = '';
        
        $(".valcls").each(function() {
            if ($(this).val() != '') {
                hasVal = 1;
            }
        });
        $("#hasallergyvalue").val(hasVal);
    }
    function validateEditAllergyForms() {
        $("#editallergyform").validate({
            ignore: [],
            rules: {
                hasallergyvalue: "required",
            },
            messages: {
                hasallergyvalue: "Please enter any one of the record",
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            },
        });
    }
    function updateAllergyForm(formtype, key) {
     
     validateEditAllergyForms();
     hasAllergyFormValue();
   
     if ($("#editallergyform").valid()) {
       
         let formdata = $("#editallergyform").serialize();
         $.ajax({
             url: '{{ url("/intakeform/allergy/update")}}',
             type: "post",
             data: {
                 'key': key,
                 'formdata': formdata,
                 '_token': $('input[name=_token]').val()
             },
             success: function(data) {
                 if (data.success == 1) {
                     getmedicalhistoryData(formtype);
                 } else {

                 }
             },
             error: function(xhr) {

                 handleError(xhr);
             },
         });
     } else {
         if ($('.error:visible').length > 0) {
             setTimeout(function() {
                 $('html, body').animate({
                     scrollTop: ($('.error:visible').first().offset().top - 100)
                 }, 500);
             }, 500);
         }
     }
 }

    $(document).ready(function () {
        hasFormValue();
    });


    $(document).ready(function () {
    function toggleLabel(input) {
        const $input = $(input);
        const value = $input.val();
        const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
        const isFocused = $input.is(':focus');

        // Ensure .float-label is correctly selected relative to the input
        $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
    }

    // Initialize all inputs on page load
    $('input, textarea').each(function () {
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
});
</script>
