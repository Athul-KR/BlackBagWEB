<div class="text-center mb-3 px-lg-5 px-3">
    <h4 class="text-center fw-medium mb-0 ">Import Nurse Data</h4>
    <small class="gray">Download the sample file provided below. This file contains the required format and structure that your data must adhere to.</small>
</div>

<div class="files-container justify-content-center mb-3">
    <div class="fileBody">
        <div class="file_info">
            <img src="{{asset ('images/excel_icon.png')}}">
            <span>Sample Excel</span>
        </div>
        <a href="{{ route('nurse.downloadSampleDoc')}}" class="dwld-btn"><span class="material-symbols-outlined me-1 primary">download</span></a>
    </div>
</div>

<hr>

<label class="mb-2">Nurse</label>

<form action="{{ url('/import-nurse') }}" class="dropzone mb-3" id="docupload" enctype="multipart/form-data">
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
            <span>Sample Document</span>
        </div>
        <a href="#" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
    </div>


</div>


<div class="btn_alignbox justify-content-end mt-4">
    <a class="btn btn-outline" data-bs-dismiss="modal">Close</a>
    <!-- <a class="btn btn-primary" id="submit-btn">Submit</a> -->
</div>


<script>
    var loaderGifUrl = "{{ asset('images/loader.gif') }}";
</script>
<script>
    $(document).ready(function() {
        var uplodURL = '{{ url("nurse/import-nurse") }}';
        var metaToken = $('meta[name="csrf-token"]').attr('content');

        // Initialize Dropzone
        Dropzone.autoDiscover = false; // Disable auto discover to avoid conflicts

        var docupload = new Dropzone("#docupload", {
            url: uplodURL,
            acceptedFiles: ".xls,.xlsx,.csv", // Limit to Excel and CSV formats
            headers: {
                'X-CSRF-TOKEN': metaToken // CSRF token for Laravel
            },
            maxFilesize: 5, // Maximum file size (in MB)
            addRemoveLinks: true, // Add remove file link

            init: function() {
                var isValidFile = true; // Flag to track invalid file status

                // this.on("removedfile", function(file) {
                this.on("addedfile", function(file) {
                    if (!isValidFile) {
                        this.removeFile(file); // Ensure invalid file is removed once
                        return; // Prevent further processing
                    }
                    var ext = file.name.split('.').pop().toLowerCase();
                    if ($.inArray(ext, ['xls', 'xlsx', 'csv']) == -1) {
                        this.removeFile(file); // Remove invalid file
                        isValidFile = false; // Set flag to avoid recursion
                        swal({
                            icon: 'error',
                            title: 'Invalid file format',
                            text: 'Only .xls, .xlsx, and .csv files are allowed.'
                        });
                    }


                });
                this.on('success', function(file, response) {
                    // Clear any previous preview
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
                this.on('error', function(file, response) {
                    // console.log("Error uploading file: ", response);
                    // alert("File upload failed!");
                    if (isValidFile) { // Check to avoid unnecessary recursion
                        swal({
                            icon: 'error',
                            title: 'Upload failed',
                            text: 'An error occurred while uploading the file.'
                        });
                        this.removeFile(file); // Remove file on error
                    }

                    isValidFile = true; // Reset flag after error

                });
            }
        });
    });

    // Function to generate preview
    function generatePreview(import_key) {
        window.location.href = "{{url('nurse/excelpreview/')}}" +'/'+ import_key ;

        // $("#import_preview_modal").html(
        //     '<div class="d-flex justify-content-center py-5"><img src="' +
        //     loaderGifUrl +
        //     '" width="250px"></div>'
        // );
        // $('#import_preview').modal('show');
        // // showPreloader('import_preview_modal') //new

        // $.ajax({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     url: '{{ url("/nurse/import-preview") }}',
        //     type: "post",
        //     data: {
        //         'validRecords': validRecords,
        //         'errorRecords': errorRecords,
        //         'importDocIDs': importDocIDs,
        //         // '_token': $('meta[name="csrf-token"]').attr('content')
        //     },
        //     success: function(data) {
        //         if (data.success == 1) {

        //             $("#import_preview_modal").html(data.view);
        //         } else {

        //         }
        //     }
        // });

    }
</script>