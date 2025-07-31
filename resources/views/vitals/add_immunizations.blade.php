        
                <div class="d-flex justify-content-between mb-4">
                    <h4 class="fw-medium">Add Data</h4>
                    <a href="#" class="cls-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                </div>
                <form method="POST" id="immunizationsform" autocomplete="off">@csrf
                <div class="row align-items-center align-row">
                    <div class="col-md-12">
                        <div class="form-group form-floating no-iconinput unitercls">
                            
                            <select class="form-select weightunitcls${ctCnt} unitformcls" name="immunizations[vaccine]" placeholder=""> 
                                <option value="">Select vaccine</option>
                                @if(!empty($immunizationTypes))
                                @foreach($immunizationTypes as $imt)
                                <option value="{{$imt['id']}}"  @if(!empty($medicathistoryDetails) && isset($medicathistoryDetails['immunizationtype_id']) && $medicathistoryDetails['immunizationtype_id'] == $imt['id']) selected @endif>{{$imt['immunization_type']}}</option> 
                                @endforeach
                                @endif
                            </select> 
                            <label class="select-label">Vaccine</label> 
                        </div>
                    </div>
                   
                    <input type="hidden" class="form-control coucetype"  id="coucetype" name="immunizations[sourcetype]" value="3">
                    @if(isset($medicathistoryDetails) && !empty($medicathistoryDetails) && $medicathistoryDetails['immunization_uuid'])
                    <input type="hidden" class="form-control coucetype" name="immunizations[key]" value="{{$medicathistoryDetails['immunization_uuid']}}">
                    @endif

                </div>
                </form>
                
                <div class="btn_alignbox mt-4">
                    <a type="button" class="btn btn-primary w-100"  id="submitbpbtn" onclick="submitIntakeForm('immunizations','immunizationsform','history')">Add Data</a>
                </div>



    <script>
    $(document).ready(function() {
        $('#immunizationsform').on('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                submitIntakeForm('immunizations','immunizationsform','history');
            }
        });
        $("#immunizationsform").validate({
            ignore: [],
            rules: {
                "immunizations[vaccine]": {
                    required: true,
                
                },
                
            },
            messages: {
                "immunizations[vaccine]": {
                    required :'Please select vaccine.',
                    
                },
              
               
            },
            errorPlacement: function(error, element) {

                if (element.hasClass("unitformcls")) {
                    error.appendTo('.unitercls');
                } else {
                    error.insertAfter(element);
                }
              
            },
        });
    });

    


    </script>