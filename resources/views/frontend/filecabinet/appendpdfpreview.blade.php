<?php
$corefunctions = new \App\customclasses\Corefunctions;
?>
<div class="modal-header modal-bg p-0 position-relative">
    <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-8">
            <h4 class="text-start fwt-bold mb-4">View File - {{$fileDets['file_name']}}</h4>
        </div>
        @if($fileDets['file_ext'] == 'pdf')
            <div class="col-md-4">
                <div class="text-end mb-3">
                    <a style="margin-right: 12px;" target="_blank" href="{{url('patients/downloadfile/'.$fileDets['fc_file_uuid'])}}" class="btn btn-primary btn-align"><span class="material-symbols-outlined me-2"> download </span></i>Download</a>
                </div>
            </div>

            <div @if($fileDets['consider_for_ai_generation']=='1' && $fileDets['ai_error'] == '0') class="col-xl-8 col-lg-7 col-12" @else class="col-md-12" @endif id="fileContainer">
                <iframe src="<?php echo $corefunctions->getAWSPathPrivate($fileDets['file_path']); ?>" width="100%" height="600px" frameborder="0"></iframe>
            </div>
            @if($fileDets['consider_for_ai_generation'] == '1' && $fileDets['ai_error'] == '0')
            <div class="col-xl-4 col-lg-5 col-12">
                <h5 class="fw-medium">Summary</h5>
                <hr>
                <div class="pdf-tablelist" id="summaryContainer">
                    @if($fileDets['summarized_data'] != '')
                    {{$fileDets['summarized_data']}}
                    @else
                    <div class="d-flex align-items-center justify-content flex-column h-100">
                        <img class="preldr-img" src="{!! asset('images/summarizepdf.gif') !!}" alt="Loader">
                    </div>
                    @endif
                </div>
            </div>
            @endif
        @elseif($fileDets['file_ext'] == 'doc' || $fileDets['file_ext'] == 'docx')
            <div class="col-md-12">
                <div class="text-end mb-3">
                    <a target="_blank" href="{{url('patients/downloadfile/'.$fileDets['fc_file_uuid'])}}" class="btn btn-primary btn-align"><span class="material-symbols-outlined me-2"> download </span></i>Download</a>
                </div>
            </div>
            <div @if($fileDets['consider_for_ai_generation']=='1' && $fileDets['ai_error'] == '0') class="col-md-6" @else class="col-md-12" @endif id="docfileContainer">
                <div class="nopreview-sec">
                    <img src="{{asset('images/nopreview.png')}}" class="img-fluid" frameborder="0" alt="No Preview">
                </div>
            </div>
            @if($fileDets['consider_for_ai_generation'] == '1' && $fileDets['ai_error'] == '0')
            <div class="col-md-6" id="docsummaryContainer">
                @if($fileDets['summarized_data'] != '')
                {{$fileDets['summarized_data']}}
                @else
                <div class="d-flex align-items-center justify-content-center flex-column h-100">
                    <img class="preldr-img" src="{!! asset('images/summarizepdf.gif') !!}" alt="PDF">
                </div>
                @endif
            </div>
            @endif
        @else
            <div class="col-md-12" id="fileContainer">
                <iframe src="<?php echo $corefunctions->getAWSPathPrivate($fileDets['file_path']); ?>" width="100%" height="600px" frameborder="0"></iframe>
            </div>
        @endif
    </div>
</div>