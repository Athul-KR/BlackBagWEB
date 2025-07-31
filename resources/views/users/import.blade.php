<div class="text-center mb-3 px-lg-5 px-3">
    <h4 class="text-center fw-medium mb-0 ">Import User Data</h4>
    <small class="gray">Download the sample file provided below. This file contains the required format and structure that your data must add here to.</small>
</div>                                                                 
<div class="files-container justify-content-center mb-3">
    <div class="fileBody">
        <div class="file_info">
            <img src="{{asset ('/images/excel_icon.png')}}">
            <span>Sample Excel</span>
        </div>
        <a href="{{ url('/users/download/'.$userType)}}" class="dwld-btn" ><span class="material-symbols-outlined me-1 primary">download</span></a>
    </div>
</div>
<hr>
<label class="mb-2">User</label>
<form action="{{ url('/importuser') }}" class="dropzone mb-3" id="docupload" enctype="multipart/form-data" autocomplete="off">
    <div class="dz-default dz-message" data-dz-message="">
        <i class="fa fa-upload"></i>
        <span>Drop files here to upload</span>
    </div>
    <input type="hidden" value="" name="doctype" id="uploaddoctype">
</form>
<div class="files-container mb-3" style="display: none;">
    <div class="fileBody">
        <div class="file_info">
            <img src="{{ asset('images/pdf_img.png')}}">
            <span>patient_files.pdf</span>
        </div>
        <a href="#" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
    </div>
</div>    
<div class="btn_alignbox justify-content-end mt-4">
    <a class="btn btn-outline" data-bs-dismiss="modal">Close</a>
    <!-- <a class="btn btn-primary" id="submit-btn">Submit</a> -->
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<script>
    $(document).ready(function () {
        var userType = "{{$userType}}";
        var uplodURL = '{{ url("users/importusers") }}/'+userType;
        var metaToken = $('meta[name="csrf-token"]').attr('content');
        var isUploading = false; // Flag to track upload status

        // Initialize Dropzone
        Dropzone.autoDiscover = false;

        var docupload = new Dropzone("#docupload", {
            url: uplodURL,
            acceptedFiles: ".xls,.xlsx,.csv", // Limit to Excel and CSV formats
            headers: {
                'X-CSRF-TOKEN': metaToken, // CSRF token for Laravel
            },
            autoProcessQueue: true, // Automatically start processing the file once it's added
            maxFiles: 1, // Allow only one file at a time
            addRemoveLinks: true, // Add remove file link
            maxFilesize: 1, // Maximum file size (in MB)
            init: function() {
                var dzInstance = this;

                // Disable Dropzone area when file is uploading
                function disableDropzone() {
                    $('#docupload').addClass('disabled-dropzone'); // Add a disabled class
                    dzInstance.options.clickable = false; // Disable file input click
                }

                // Enable Dropzone area after upload
                function enableDropzone() {
                    $('#docupload').removeClass('disabled-dropzone'); // Remove the disabled class
                    dzInstance.options.clickable = true; // Re-enable file input click
                }

                // Event listener for when a file is added
                this.on("addedfile", function(file) {
                    if (isUploading) {
                        dzInstance.removeFile(file); // Remove the new file if one is already uploading
                        swal({
                            icon: 'warning',
                            title: 'Upload in progress',
                            text: 'Please wait until the current file is uploaded.'
                        });
                        return;
                    }
                    
                    var ext = file.name.split('.').pop().toLowerCase();
                    if ($.inArray(ext, ['xls', 'xlsx', 'csv']) == -1) {
                        dzInstance.removeFile(file);  // Remove invalid file
                        swal({
                            icon: 'error',
                            title: 'Invalid file format',
                            text: 'Only .xls, .xlsx, and .csv files are allowed.'
                        });
                    } else {
                        isUploading = true; // Set the uploading flag to true
                        disableDropzone(); // Disable dropzone area while uploading
                    }
                });
            
                // Event listener for when a file is successfully uploaded
                this.on('success', function(file, response) {
                    $('#preview-section').html('');
                    $('#import_data').modal('hide');

                    if (response.success) {
                        // Create a preview of valid and error records
                        generatePreview(response.import_key);
                    } else {
                        swal({
                            icon: 'error',
                            title: '',
                            text: response.message
                        });
                    }
                });

                // Event listener for any error during file upload
                this.on('error', function(file, response) {
                    swal({
                        icon: 'error',
                        title: 'Upload failed',
                        text: 'An error occurred while uploading the file.'
                    });
                    dzInstance.removeFile(file); // Remove the file on error
                    isUploading = false; // Reset upload flag
                    enableDropzone(); // Re-enable dropzone area
                });

                // Event listener for when file upload is complete
                this.on("complete", function(file) {
                    dzInstance.removeFile(file); // Remove the file from Dropzone once the upload is complete
                    isUploading = false; // Reset the uploading flag
                    enableDropzone(); // Re-enable the dropzone area after completion
                });
            }
        });
        // Optional: Add some basic CSS to visually indicate the dropzone is disabled
        $('<style>.disabled-dropzone { pointer-events: none; opacity: 0.5; }</style>').appendTo('head');
    });

    // Function to generate preview
    function generatePreview(import_key) {
        var userType = "{{$userType}}";
        window.location.href = "{{url('users/excelpreview/')}}" +'/'+ import_key  +'/'+ userType;       
    }
    
</script>

