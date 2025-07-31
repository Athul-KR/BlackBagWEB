<h4 class="text-start fwt-bold mb-4">File Cabinet</h4>
<div class="folderData_wrapper">
    <div class="folderDataHead mb-4">
        <a href="javascript:void(0);" onclick="showFolders();" class="primary align_middle fw-medium"><span class="material-symbols-outlined">arrow_back</span>{{$folder['folder_name']}}</a>
        <a href="javascript:void(0);" onclick="addFile();" class="btn btn-primary align_middle"><span class="material-symbols-outlined">post_add</span>Add Files</a>
    </div>
    <div class="row">
        @if(!empty($files))
        @foreach($files as $file)
        <div class="col-xxl-4 col-md-6 col-12">
            <div class="fileBody_inner d-flex justify-content-between align-items-center">
                <div class="fileResult_inner">
                    <?php
                        $view = $docview = 0;
                        $file['file_ext'] = strtolower($file['file_ext']); // Convert to lowercase
                        if ($file['file_ext'] == 'png') {
                            $imagePath = asset('images/png_icon.png');
                            $view = 1;
                        } else if ($file['file_ext'] == 'jpg' || $file['file_ext'] == 'jpeg') {
                            $imagePath = asset('images/jpg_icon.png');
                            $view = 1;
                        } else if ($file['file_ext'] == 'pdf') {
                            $imagePath = asset('images/pdf_img.png');
                            $view = 1;
                        } else if ($file['file_ext'] == 'xls' || $file['file_ext'] == 'xlsx' || $file['file_ext'] == 'csv') {
                            $imagePath = asset('images/excel_icon.png');
                        } else if ($file['file_ext'] == 'mp4') {
                            $imagePath = asset('images/mp4_img.png');
                        } else {
                            $imagePath = asset('images/doc_image.png');
                            $docview = 1;
                        }
                        $corefunctions = new \App\customclasses\Corefunctions;
                    ?>
                    <img src=<?php echo $imagePath; ?> alt="pdf">
                    <div class="folderName">
                        <a class="view-file" @if( $view == 1 || $docview == 1 ) href="#" onclick="previewFile('{{$file['fc_file_uuid']}}');" @endif data-filekey="{{$file['fc_file_uuid']}}">
                            <h6 class="primary m-0">{{$file['file_name']}}</h6>
                        </a>
                        <p class="m-0">@if(isset($file['created_at']) && $file['created_at'] != '') <?php echo $corefunctions->timezoneChange($file['created_at'], "d/m/Y") ?> <?php echo $corefunctions->timezoneChange($file['created_at'], "h:i A") ?> @else -- @endif</p>
                        <p class="m-0">
                            Added by: {{$userDetails[$file['created_by']]['first_name']}} {{$userDetails[$file['created_by']]['last_name']}}
                            @if(isset($clinicUser[$file['created_by']]['designation']['name'])), {{$clinicUser[$file['created_by']]['designation']['name']}}@else {{''}}@endif

                        </p>
                    </div>

                </div>
                <div class="d-flex align-items-center justify-content-end">
                    <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <span class="material-symbols-outlined">more_vert</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <?php if ($view == 1) { ?>
                            <li>
                                <a href="#" class="view-file dropdown-item fw-medium" onclick="previewFile('{{$file['fc_file_uuid']}}');" data-filekey="{{$file['fc_file_uuid']}}">
                                    <i class="fa-solid fa-eye me-2"></i>View
                                </a>
                            </li>
                        <?php }  ?>
                        <?php if ($docview == 1) { ?>
                            <li>
                                <a href="#" class="view-file dropdown-item fw-medium" onclick="previewFile('{{$file['fc_file_uuid']}}');" data-filekey="{{$file['fc_file_uuid']}}">
                                    <i class="fa-solid fa-eye me-2"></i>View Summary
                                </a>
                            </li>
                        <?php }  ?>
                        <li><a target="_blank" href="{{url('patients/downloadfile/'.$file['fc_file_uuid'])}}" class="dropdown-item fw-medium"><i class="fa-solid fa-file-arrow-down me-2"></i>Download</a></li>
                        <li><a onclick="removeFile('{{$file['fc_file_uuid']}}');" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Delete</a></li>
                    </ul>
                </div>
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

<div class="modal login-modal fade" id="addFiles" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content overflow-hidden">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body">
                <h4 class="text-start fwt-bold mb-4">Add Files</h4>
                <div class="row">
                    <div class="col-12">
                        <form id="patientFilesForm" autocomplete="off">
                            @csrf
                            <div class="dropzone-wrapper mb-4 dropzone custom-dropzone" id="patientFiles">
                                <!-- <a href="" class="gray fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add patient files</a> -->
                            </div>
                            <small>Accepted formats: JPG, PNG, JPEG, PDF, DOC, DOCX, MP4</small>
                            <div class="files-container mb-3" id="appendfiles">

                            </div>
                    </div>
                    <div class="btn_alignbox justify-content-end">
                        <a href="javascript:void(0);" onclick="hideFileModal();" class="btn btn-outline-primary">Cancel</a>
                        <button onclick="submitFile();" id="submitfile" class="btn btn-primary" disabled>Upload</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Structure -->
<div class="modal login-modal fade" id="fileSummaryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content overflow-hidden" id="appendpdfpreview">

        </div>
    </div>
</div>

<script>
    var summaryIntervalId; // Global variable to track the interval

    $(document).on("click", ".view-file", function (e) {
        e.preventDefault(); // Prevent default link behavior

        let filekey = $(this).attr("data-filekey"); // Get filekey from button
        console.log("Filekey set in modal:", filekey);

        // Store filekey inside the modal attribute BEFORE showing it
        $('#fileSummaryModal').attr('data-filekey', filekey);
        $('#fileSummaryModal').modal('show');
    });

    // Start checking when the modal is opened
    $('#fileSummaryModal').on('shown.bs.modal', function () {
        let filekey = $(this).attr('data-filekey'); // Get filekey stored in modal
        console.log("Modal opened, starting interval for filekey:", filekey);

        // Clear previous interval before starting a new one
        if (summaryIntervalId) {
            clearInterval(summaryIntervalId);
        }

        summaryIntervalId = setInterval(function () {
            console.log("Checking summary status...");
            checkSummaryStatus(filekey);
        }, 5000); // Runs every 5 seconds

        // Run the first check immediately
        checkSummaryStatus(filekey);
    });

    // Stop checking when the modal is closed
    $('#fileSummaryModal').on('hidden.bs.modal', function () {
        console.log("Modal closed, stopping interval.");
        clearInterval(summaryIntervalId);
    });

    $(document).ready(function() {
        $("#patientFilesForm").validate({
            ignore: [],
            rules: {
                'patient_files[]': "required",
            },
            messages: {
                'patient_files[]': "Please upload at least one file.",
            }

        });

    });
    Dropzone.autoDiscover = false;
    // Dropzone Configurations
    var folder_id = "{{$folder['id']}}";
    var dropzone = new Dropzone('#patientFiles', {
        url: "{{ url('/patients/uploadfile') }}",
        maxFiles: 10,
        addRemoveLinks: true,
        acceptedFiles: '.jpg,.png,.jpeg,.pdf,.doc,.csv,.docx,.mp4',
        dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span> Add patient files', // Add class for styling

        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                formData.append("folder_id", folder_id);
            });
            this.on("removedfile", function(file) {
                $(".remv_" + file.filecnt).remove();
            });
            this.on("maxfilesexceeded", function(file) {
                this.removeFile(file); // Remove the extra file
                swal("You can only upload up to 10 files.");
            });

           
            this.on("error", function(file, message) {
                this.removeFile(file); // Remove the failed file
                console.log("File upload failed: " + message)
                // swal("File upload failed: " + message);
            });

            var filecount = 1;
    
            this.on('success', function(file, response) {
                if (response.success == 1) {

                    this.removeFile(file);
                    file.filecnt = filecount;
                    $("#submitfile").prop('disabled',false);
                    if (response.ext == 'png') {
                        var imagePath = "{{ asset('images/png_icon.png') }}";
                    } else if (response.ext == 'jpg') {
                        var imagePath = "{{ asset('images/jpg_icon.png') }}";
                    } else if (response.ext == 'pdf') {
                        var imagePath = "{{ asset('images/pdf_img.png') }}";
                    } else if (response.ext == 'xlsx') {
                        var imagePath = "{{ asset('images/excel_icon.png') }}";
                    } else if (response.ext == 'mp4') {
                        var imagePath = "{{ asset('images/mp4_img.png') }}";
                    } else {
                        var imagePath = "{{ asset('images/doc_image.png') }}";
                    }
                  
                    console.log(response.ext)
                    var appnd = '<div class="fileBody" id="doc_' + filecount + '"><div class="file_info"><img src="' + imagePath + '"><span>' + response.docname + '</span>' +
                        '</div><a onclick="removeImageDoc(' + filecount + ')"><span class="material-symbols-outlined">close</span></a></div>' +
                        '<input type="hidden" class="file_count" name="patient_files[' + filecount + '][tempdocid]" value="' + response.tempdocid + '" >';
                      
                    $("#appendfiles").append(appnd);
                    filecount++
                    // $("#docuplad").val('1');
                    // $("#docuplad").valid();
                } else {
                    if (typeof response.error !== 'undefined' && response.error !== null && response.error == 1) {
                        swal(response.errormsg);
                        this.removeFile(file);
                    }
                    if (response.error == 1) {
                        console.log(response.errormsg)
                        // swal(response.errormsg);
                        this.removeFile(file);
                    }
                }
                
            });
        },
    });
    function checkSummaryStatus(filekey) {
        if (!filekey) {
            console.log("No filekey found, skipping check.");
            return;
        }

        console.log("AJAX request sent for filekey:", filekey);
        
        $.ajax({
            url: '{{ url("/file/getaisummary")}}',
            type: "post",
            data: {
                'filekey': filekey,
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                console.log("Response received:", data);
                if (data.success == 1) {
                    $('#summaryContainer').html(data.view);
                    if(data.summary != null){
                        clearInterval(summaryIntervalId);
                    }
                }
            },
            error: function (xhr) {
                console.log("AJAX Error:", xhr);
                handleError(xhr);
            },
        });
    }
    function previewFile(filekey) {
        $('#appendpdfpreview').html('');
        showPreloader('appendpdfpreview');

        $.ajax({
            url: '{{ url("/file/getsummary")}}',
            type: "post",
            data: {
                'filekey': filekey,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    $('#appendpdfpreview').html(data.view);
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });

        $('#fileSummaryModal').modal('show');
    }

    function previewDocFile(filekey) {
        $('#appenddocpreview').html('');
        showPreloader('appenddocpreview');

        $.ajax({
            url: '{{ url("/file/getdocsummary")}}',
            type: "post",
            data: {
                'filekey': filekey,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    $('#appenddocpreview').html(data.view);
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });

        $('#docFileSummaryModal').modal('show');
    }

    function previewImageFile(filekey) {
        $('#appendimagepreview').html('');
        showPreloader('appendimagepreview');

        $.ajax({
            url: '{{ url("/file/getimagepreview")}}',
            type: "post",
            data: {
                'filekey': filekey,
                '_token': $('input[name=_token]').val()
            },
            success: function(data) {
                if (data.success == 1) {
                    $('#appendimagepreview').html(data.view);
                }
            },
            error: function(xhr) {

                handleError(xhr);
            },
        });

        $('#imageFileSummaryModal').modal('show');
    }

    function markdownToHtmlTable(summary) {
        var lines = summary.split('\n');
        var table = '<table class="table table-bordered">';
        lines.forEach(function(line, index) {
            var cells = line.split('|').slice(1, -1); // Remove leading and trailing empty elements
            var isSeparatorRow = cells.every(cell => /^[-\s]+$/.test(cell.trim())); // Check for rows with only dashed lines or empty cells

            // Skip the separator rows
            if (isSeparatorRow) {
                return; // Skip processing this row
            }
            if (!isSeparatorRow) {
                if (index === 0) {
                    table += '<thead><tr>';
                    cells.forEach(function(cell) {
                        table += '<th>' + cell.trim() + '</th>';
                    });
                    table += '</tr></thead><tbody>';
                } else {

                    table += '<tr>';
                    cells.forEach(function(cell, cellIndex) {
                        var trimmedCell = cell.trim();
                        var color = 'black'; // Default color
                        // if (cell.trim().toLowerCase() === "result") {
                        // Dynamically check the content to apply color
                        if (trimmedCell.toLowerCase() === 'l' || trimmedCell.toLowerCase().includes('low')) {
                            color = 'blue';
                        } else if (trimmedCell.toLowerCase() === 'h' || trimmedCell.toLowerCase().includes('high')) {
                            color = 'red';
                        } else if (trimmedCell.toLowerCase().includes('borderline')) {
                            color = 'orange';
                        }
                        // }
                        table += '<td style="color:' + color + ' !important;">' + trimmedCell + '</td>';
                    });
                    table += '</tr>';
                }
            }
        });
        table += '</tbody></table>';
        return table;
    }

    function removeImageDoc(count) {
        $("#doc_" + count).remove();
        $("input[name='patient_files[" + count + "][tempdocid]']").remove();
    }

    function addFile() {
        $('#patientFilesForm')[0].reset();
        $('#patientFilesForm').validate().resetForm();
        $("#addFiles").modal('show');
        $("#appendfiles").html('');
    }

    function submitFile() {
        var files = $(".file_count").length;
        if (files === 0) {
            // Show error message
            swal({
                title: "Error!",
                text: "Please upload at least one file",
                icon: "error",
                timer: 2000,
            });
            return false;
        }
        var patientID = "@if(!empty($patient)) {{$patient['user_id']}} @else null @endif";
        var key = "{{$folder['fc_user_folder_uuid']}}";
        if ($("#patientFilesForm").valid()) {
            let formdata = $("#patientFilesForm").serialize();
            $.ajax({
                url: '{{ url("/file/store")}}',
                type: "post",
                data: {
                    'formdata': formdata,
                    'key': key,
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
                            $("#addFiles").modal('hide');
                            
                            showFiles(key);
                        });
                    }
                },
                error: function(xhr) {
                    handleError(xhr);
                },
            });
        }
    }

    function hideFileModal() {
        $("#addFiles").modal('hide');
    }

    function removeFile(uuid) {
        var url = "{{route('patient.removefile')}}";
        var key = "{{$folder['fc_user_folder_uuid']}}";
        swal("Are you sure you want to remove this file?", {
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
                                showFiles(key);
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