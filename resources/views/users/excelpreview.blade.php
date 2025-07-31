@extends('layouts.app')
@section('title', 'Appointment')
@section('content')
   
<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-12 mb-3">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
          <li class="breadcrumb-item"><a href="{{url('/users')}}" class="primary">Users</a></li>
          <li class="breadcrumb-item active" aria-current="page">Import</li>
           


          </ol>
        </nav>
      </div>
      <div class="col-12 mb-3">
          <div class="web-card threshhold-card mb-3"> 
              <form action="{{ url('users/importusers/'.$type) }}" class="dropzone mb-3" id="importdoc" enctype="multipart/form-data" autocomplete="off">
              @csrf
                <div class="dz-default dz-message" data-dz-message="">
                  <i class="fa fa-upload"></i>
                  <span>Drop files here to upload</span>
                </div>
                <input type="hidden" value="" name="doctype" id="uploaddoctype">
              </form>
          </div>
      </div>
      <div class="col-xl-12 col-12 " id="appendpreview" >
          
      </div>
      
      <input type="hidden" id="last_fileid" name="last_fileid" value="">
      <input type="hidden" id="hasdata" name="hasdata" value="">
    </div>
  </div>
</section>
<script>
  Dropzone.autoDiscover = false;
  $(document).ready(function() {
    var importKey = '{{$importKey}}';
    getPreviewForm(importKey);
    $(window).on('scroll', function() {
      if(parseInt($(window).scrollTop() + $(window).height() + 1) >= parseInt($(document).height())) {
        lastFileID = ( $("#last_fileid").length > 0 ) ? $("#last_fileid").val() : 0;
        if( $('#hasdata').val() == 1 && lastFileID !=0){
          console.log('3')
          getPreviewForm(importKey,lastFileID,isloadmore=1);
        } 
      }
    });
    var userType = "{{$type}}";
    var uplodURL = '{{ url("users/importusers") }}/'+userType;
    var metaToken = $('meta[name="csrf-token"]').attr('content');
    var isUploading = false; // Flag to track upload status

    var importdoc = new Dropzone("#importdoc", {
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
            $('#importdoc').addClass('disabled-dropzone'); // Add a disabled class
            dzInstance.options.clickable = false; // Disable file input click
        }

        // Enable Dropzone area after upload
        function enableDropzone() {
            $('#importdoc').removeClass('disabled-dropzone'); // Remove the disabled class
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
  function getPreviewForm(import_key,isloadmore='') {
    var lastFileID = ( $("#last_fileid").length > 0 && isloadmore == 1 ) ? $("#last_fileid").val() : 0;
    var userType = "{{$type}}";
    if(isloadmore != 1){
      showPreloader('appendpreview')
    }
    $.ajax({
      url: '{{ url("/users/importpreview") }}',
      type: "post",
      data: {
        'importKey' : import_key,
        'lastExportID' : lastFileID,
        'userType' : userType,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          console.log(data.hasdata)

          if( isloadmore == 1 && (data.hasdata != 0 ) && lastFileID != 0){
            
            $("#appendpreview").append(data.view);
          }else{
            $("#appendpreview").html(data.view);
          }
            $("#hasdata").val(data.hasdata);
          $("#last_fileid").val(data.lastExportID);
        }else{

        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      },
    }); 
  }
  function importUsers() {
    var importKey = '{{$importKey}}' ;
    var userType = '{{$type}}' ;
    let iserrorRecords = $('.is_error').val();
    if(iserrorRecords !='1'){
      $("#submit-btn").addClass('disabled');
      $.ajax({
        url: '{{ url("/users/import/store") }}',
        type: "post",
        data: {
          'userType' : userType,
          'importKey' : importKey,
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
                    swal({
                        title: "Success!",
                        text: data.message,
                        icon: "success",
                        buttons: false,
                        timer: 2000 // Closes after 2 seconds
                    }).then(() => {
                      window.location.href = "{{url('users/list/pending')}}" ;
                    });

            
          } else {
            swal({
              icon: 'error',
              text: data.message,
            });
          }
        },
        error: function(xhr) {
               
          handleError(xhr);
        },
      });
    }else{
      swal({
        icon: 'error',
        text: 'To proceed, please remove the row entries with invalid details',
      });
    }
  }
  function removeDocument(importKey) {
    $.ajax({
      url: '{{ url("/users/import/delete") }}',
      type: "post",
      data: {
        'importKey' : importKey,
        '_token'    : $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $('.rmv_doc_'+importKey).remove();
          console.log($('.rmv_doc_'+importKey).length);
          if ($('.remvdoccls').length == 0) {
            $('.no-records-body').show();
            $('#submit-btn').hide();
          }
          if( $('.is_error').length == 0){
            $('.is_error').val(0);
          }
          swal({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    buttons: false,
                    timer: 2000 // Closes after 2 seconds
                }).then(() => {
                    // window.location.reload();
                });

        
        } else {
          swal({
            icon: 'error',
            text: data.message,
          });
        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      },
    });
  }
  // Function to generate preview
  function viewDetails(importKey) {
    $("#viewDetails_modal").modal('show');
    showPreloader('viewDetails')
    $.ajax({
      url: '{{ url("/doctors/previewdetails") }}',
      type: "post",
      data: {
        'importKey' : importKey,
      
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#viewDetails").html(data.view);
        }else{
        }
      },
      error: function(xhr) {
               
        handleError(xhr);
      },
    });
  }
  function generatePreview(import_key) {
    var userType = "{{$type}}";
    window.location.href = "{{url('users/excelpreview/')}}" +'/'+ import_key  +'/'+ userType;       
  }
</script>

<div class="modal login-modal fade" id="viewDetails_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
      </div>
      <div class="modal-body text-center" id="viewDetails"></div>
    </div>
  </div>
</div>


@stop