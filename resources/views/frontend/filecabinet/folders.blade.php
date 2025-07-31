<?php
$corefunctions = new \App\customclasses\Corefunctions;
?>
<div class="filecabinet_wrapper">
    <div class="d-flex justify-content-between mb-4 p-0">
        <h4 class="text-start fwt-bold mb-4">File Cabinet</h4>
        <a href="javascript:void(0);" onclick="addFolder();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">post_add</span>Add Folder</a>
    </div>
    <div class="row">
        @if(count($folders) > 0)
        @foreach($folders as $folder)
        <div class="col-xxl-3 col-md-4 col-sm-6 col-12 mb-4">
            <div class="fileBody_inner file-cabinet-inner">
                @if($folder['created_by'] == Session::get('user.userID') && $folder['is_default'] == '0')
                <div class="btn_alignbox mt-auto d-flex justify-content-end">
                    <a href="javascript:void(0);" onclick="editFolder('{{$folder['fc_user_folder_uuid']}}');" class="opt-btn"><span class="material-symbols-outlined">edit</span></a>
                    <a href="javascript:void(0);" onclick="removeFolder('{{$folder['fc_user_folder_uuid']}}');" class="opt-btn danger-icon"><span class="material-symbols-outlined">delete</span></a>
                </div>
                @endif
                <a href="javascript:void(0);" onclick="showFiles('{{$folder['fc_user_folder_uuid']}}');">
                    <div class="folderType">
                        <img src="{{asset('images/dummy_folder.png')}}" alt="files" alt="Folder">
                    </div>
                    <div class="folderName">
                        <h6 class="mb-0 fw-medium primary">{{$folder['folder_name']}}</h6>
                        <small>@if(isset($folder['updated_at']) && $folder['updated_at'] != '') Last updated: <?php echo $corefunctions->timezoneChange($folder['updated_at'], 'M d, Y | h:i A') ?> @else Created at: <?php echo $corefunctions->timezoneChange($folder['created_at'], 'd/m/Y h:i A') ?> @endif</small></br>
                        @if($folder['is_default'] == '0')
                        <small>Created by: {{$userDetails[$folder['created_by']]['first_name']}} {{$userDetails[$folder['created_by']]['last_name']}}
                            @if(isset($clinicUser[$folder['created_by']]['designation']['name'])), {{$clinicUser[$folder['created_by']]['designation']['name']}}@else{{''}}@endif
                        </small>
                        @endif
                    </div>
                </a>
            </div>
        </div>
        @endforeach
        @else
        <div class="flex justify-center">
            <div class="text-center  no-records-body">
                <img src="{{asset('images/nodata.png')}}"
                    class=" h-auto" alt="No records">
                <p>No records found</p>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal login-modal fade" id="addfoldermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content overflow-hidden">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <h4 class="text-start fw-medium mb-4">Add Folder</h4>
                <div class="row">
                    <div class="col-12">
                        <form id="addfolderform" method="post" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-lg-12 col-12">
                                    <div class="form-group form-outline mb-3">
                                        <label for="folder_name" class="float-label">Folder Name</label>
                                        <i class="fa-solid fa-folder-open"></i>
                                        <input type="text" name="folder_name" class="form-control" id="folder_name">
                                    </div>
                                </div>
                                <div class="btn_alignbox justify-content-end">
                                    <a href="javascript:void(0);" onclick="hideFolderModal();" class="btn btn-outline-primary">Cancel</a>
                                    <button type="button" onclick="submitFolder();" class="btn btn-primary" id="submitfolderbtn">Submit</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal login-modal fade" id="editfoldermodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content overflow-hidden">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="append_editfolder">

            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#addfolderform").validate({
            rules: {
                folder_name: "required",
            },
            messages: {
                folder_name: "Please enter folder name",
            }
        });

        // Add prevent default for enter key
        $("#addfolderform").on('keypress', function(e) {
            if (e.which === 13) { // Enter key code
                e.preventDefault();
                submitFolder();
                // return false;
            }
        });
    });

    function showFolders() {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        showPreloader("filecabinetpatients");
        $.ajax({
            url: '{{ url("/patients/getfolders") }}',
            type: "post",
            data: {
                'patientID': patientID,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#filecabinetpatients").html(data.view);
                } else {
                    swal("error!", data.message, "error");
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }

    function addFolder() {
        $("#addfoldermodal").modal('show');
    }

    function editFolder(key) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        $.ajax({
            url: '{{ url("/folder/edit") }}',
            type: "post",
            data: {
                'key': key,
                'patientID': patientID,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    $("#editfoldermodal").modal('show');
                    $("#append_editfolder").html(data.view);
                } else {
                    swal("error!", data.message, "error");
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }

    function hideFolderModal() {
        $("#addfoldermodal").modal('hide');
    }

    function submitFolder() {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        if ($("#addfolderform").valid()) {
            $("#submitfolderbtn").prop('disabled', true);
            let formdata = $("#addfolderform").serialize();
            $.ajax({
                url: '{{ url("/folder/store")}}',
                type: "post",
                data: {
                    'formdata': formdata,
                    'patientID': patientID,
                    '_token': $('input[name=_token]').val()
                },
                success: function(data) {
                    if (data.success == 1) {
                        swal({
                            title: "Success!",
                            text: data.message,
                            icon: "success",
                            timer: 1000,
                            buttons: false
                        }).then(() => {
                            $("#addfoldermodal").modal('hide');
                            showFolders();
                        });
                    } else {
                        swal("Error!", data.message, "error");
                    }
                },
                error: function(xhr) {

                    handleError(xhr);
                },
            });
        }
    }

    function showFiles(key) {
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        var userType = "{{ Session::get('user.userType') }}";
        showPreloader("filecabinetpatients");
        $.ajax({
            url: '{{ url("/patients/getfiles") }}',
            type: "post",
            data: {
                'key': key,
                'patientID': patientID,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                if (data.success == 1) {
                    if (userType == 'patient') {
                        const newUrl = "{{ url('/filecabinet') }}/" + key + "/files";
                        window.history.pushState({
                            key: key
                        }, "", newUrl);
                    }
                    $("#filecabinetpatients").html(data.view);
                } else {
                    swal("error!", data.message, "error");
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });
    }

    function removeFolder(uuid) {
        var url = "{{route('patient.removefolder')}}";
        swal("Are you sure you want to remove this folder?", {
            title: "Remove!",
            icon: "warning",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        'uuid': uuid,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function(data) {
                        if (data.success == 1) {
                            swal({
                                title: "Success!",
                                text: data.message,
                                icon: "success",
                                timer: 1000,
                                buttons: false
                            }).then(() => {
                                showFolders();
                            });
                        } else {
                            swal(data.errormsg);
                        }
                    },
                    error: function(xhr) {

                        handleError(xhr);
                    },
                });
            }
        });
    }
</script>