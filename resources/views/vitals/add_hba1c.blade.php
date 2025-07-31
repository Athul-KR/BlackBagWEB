        
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Add Data</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <form method="POST" id="glucoseform" autocomplete="off">@csrf
                <div class="row align-items-center align-row">
                    <div class="col-md-12">
                        <div class="form-group form-outline no-iconinput formmedicalhiscls">
                            <label for="input" class="float-label">Glucose Value (mg/dL)</label>
                            <input type="text" class="form-control medicalhiscls" name="glucose[hba1c]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['hba1c']}}" @endif >
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[sourcetype]" value="3">
                    @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['glucose_tracker_uuid'])
                    <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[key]" value="{{$medicathistoryDetails['glucose_tracker_uuid']}}">
                    @endif

                </div>
                </form>
                
                <div class="btn_alignbox mt-4">
                    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('glucose','glucoseform','{{$formType}}')">Add Data</a>
                </div>



    <script>
    $(document).ready(function() {
        $("#glucoseform").validate({
                ignore: [],
                rules: {
                    "glucose[hba1c]": {
                        required: true,
                        number: true,
                        min:1,
                    },
                
                },
                messages: {
                    "glucose[hba1c]": {
                        required :'Please enter glucose value.',
                        number: 'Please enter a numeric value.',
                        min: 'Please enter a value greater than 0',
                    },
                
                
                },
                errorPlacement: function(error, element) {
                    if (element.hasClass("medicalhiscls")) {
                        error.appendTo('.formmedicalhiscls');
                    }else{
                        error.insertAfter(element);
                    }
                },
            });
    });




    </script>