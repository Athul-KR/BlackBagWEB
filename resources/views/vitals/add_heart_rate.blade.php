        
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Add Data</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <form method="POST" id="bloodpressureform" autocomplete="off">@csrf
                <div class="row align-items-center align-row">
                   
                    <div class="col-md-12">
                        <div class="form-group form-outline no-iconinput formmedicalhiscls">
                            <label for="input" class="float-label">Pulse (mmHg)</label>
                            <input type="text" class="form-control medicalhiscls " name="blood_pressure[pulse]"  @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails)) value="{{$medicathistoryDetails['pulse']}}" @endif >
                        </div>
                    </div>
                    <input type="hidden" class="form-control coucetype"  id="coucetype" name="blood_pressure[sourcetype]" value="3">
                    @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['bp_tracker_uuid'])
                    <input type="hidden" class="form-control coucetype"  id="coucetype" name="glucose[key]" value="{{$medicathistoryDetails['bp_tracker_uuid']}}">
                    @endif

                </div>
                </form>
                
                <div class="btn_alignbox mt-4">
                    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('bp','bloodpressureform','{{$formType}}')">Add Data</a>
                </div>



    <script>
    $(document).ready(function() {
$("#bloodpressureform").validate({
            ignore: [],
            rules: {
                "blood_pressure[pulse]": {
                    required: true,
                    number: true,
                    min:1,
                },
               
               
            },
            messages: {
                "blood_pressure[pulse]": {
                    required :'Please enter pulse value.',
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