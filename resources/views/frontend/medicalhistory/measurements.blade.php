<div class="col-12">
    <div class="my-3">
        <h5 class="fwt-bold mt-md-0 mt-3">Physical Measurements</h5>
        <p>Note : Update height first to keep your BMI and chart accurate.</p>
        
    </div>

    <ul class="nav nav-pills mt-3 mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link measurementtype" onclick="getmedicalhistoryDatapm('height')" id="height" data-bs-toggle="pill"
                data-bs-target="#pills-height" type="button" role="tab"
                aria-controls="pills-height" aria-selected="false">Height</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link measurementtype" onclick="getmedicalhistoryDatapm('weight')"
                data-bs-toggle="pill"
                data-bs-target="#pills-home" type="button" role="tab" id="weight" aria-controls="pills-home"
                aria-selected="true">Weight</a>
        </li>
     
    </ul>
    <div class="tab-content" id="pills-tabContent">

        <!-- Content here Online -->
        <div id="height-content">

        </div>
    </div>
</div>





<script>
    $(document).ready(function() {

        var formtype = ($("#formType").is(":visible") && typeof $("#formType").val() !== 'undefined' && $("#formType").val().trim() !== '') ? $("#formType").val() : 'height';
        getmedicalhistoryDatapm(formtype);
    })

    function getmedicalhistoryDatapm(type,page=1) {
      
        showPreloader('height-content');
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        let start = $('#selectedStartDate').val();
        let end = $('#selectedEndDate').val();
        let label = $('#selectedLabel').val();

        $.ajax({
            type: "POST",
            url: '{{ url("/medicalhistory/edit") }}',
            data: {
                "patientID": patientID,
                "startDate" : start ,
                "endDate"   : end ,
                "label"     : label ,
                "page"      : page ,
                "type": type,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if (response.success == 1) {

                    $('.tab-pane-pm').hide();
                    $("#" + type).show();
                    $("#height-content").html(response.view);

                    $('.measurementtype').removeClass('show');
                    $('.measurementtype').removeClass('active');
                    $("#" + type).addClass('show');
                    $("#" + type).addClass('active');

                    $("#tab-measurements").addClass('show');
                    $("#tab-measurements").addClass('active');

                    const contentArea = $("#content-measurements");
                    contentArea.addClass('show active');
                    initDateRangePicker(type);
                    loadChart(response.labels, response.values);

                    $('#selectedStartDate').val(response.startDate);
                    $('#selectedEndDate').val(response.endDate);
                    $('#selectedLabel').val(response.label);
                    dateRandeLabel(response.startDate,response.endDate,response.label);
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        })
    }

    var ctCnt = 1;

    function addWeight() {
        var type = 'weight';
        var bphtml =
            '<div class="col-12" id="weight_' + ctCnt + '"> <div class="inner-history"> <div class="row align-items-center"> <div class="col-md-10"> <div class="row"> ' +
            '<div class="col-md-3"><div class="history-box"> <div class="form-group form-outline"><label class="float-label">Weight(kg)</label><input type="text" class="form-control" id="weight' + ctCnt + '" name="weight[weight]"   placeholder=""></div></div></div>' +
            '<input type="hidden" class="form-control coucetype"  id="coucetype' + ctCnt + '" name="weight[sourcetype]" @if(Session::get('
        user.userType ') == '
        patient ') value="2" @else value="3" @endif></div></div><div class="col-md-2"> <div class="btn_alignbox justify-content-end">' +
            '<a class="opt-btn" onclick="submitIntakeForm(\'' + type + '\')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>' +
            '</div></div></div></div></div>';

        var idcn = ctCnt - 1;
        $('#weight_' + idcn).after(bphtml);
        var scrollTo = $("#weight_" + ctCnt).offset().top;
        $('html, body').animate({
            scrollTop: scrollTo
        }, 500);
        ctCnt++;
    }

    function submitIntakeForm(formtype) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        if ($("#intakeformweight").valid()) {
            let formdata = $("#intakeformweight").serialize();
            $.ajax({
                url: '{{ url("/intakeform/store")}}',
                type: "post",
                data: {
                    'formtype': formtype,
                    'formdata': formdata,
                    'patientID': patientID,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        getmedicalhistoryDatapm(formtype);
                    } else {

                    }
                },
                error: function(xhr) {

                    handleError(xhr);
                }
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
</script>