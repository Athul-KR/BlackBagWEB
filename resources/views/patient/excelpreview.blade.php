@extends('layouts.app')
@section('title', 'Patient')
@section('content')
   
<section id="content-wrapper">
                        <div class="container-fluid p-0">
                          <div class="row h-100">
                            <div class="col-12 mb-3">
                                <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                                    <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
                                      <li class="breadcrumb-item"><a href="patientrecords.html" class="primary">Import Patient</a></li>
                                    </ol>
                                  </nav>
                            </div>

                            <div class="col-xl-12 col-12 " id="appendpreview" >
                               
                            </div>
                            
                            <input type="hidden" id="last_fileid" name="last_fileid" value="">
                            
                      </div>
                    </div>
                  </section>






<script>

$(document).ready(function() {
        var importKey = '{{$importKey}}' ;

        getPreviewForm(importKey);

        $(window).on('scroll', function() {
          if(parseInt($(window).scrollTop() + $(window).height() + 1) >= parseInt($(document).height())) {
              lastFileID = ( $("#last_fileid").length > 0 ) ? $("#last_fileid").val() : 0;
              // getPreviewForm(importKey,lastFileID);
          }
      });



  });

    // Function to generate preview
    function getPreviewForm(import_key,isloadmore='') {

      var lastFileID = ( $("#last_fileid").length > 0 && isloadmore == 1 ) ? $("#last_fileid").val() : 0;

          showPreloader('appendpreview')
          $.ajax({
              url: '{{ url("/patients/importpreview") }}',
              type: "post",
              data: {
               'importKey' : import_key,
               'lastExportID' : lastFileID,
                '_token': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                if (data.success == 1) {
                  if( isloadmore == 1){
                    $("#appendpreview").append(data.view);
                  }else{
                    $("#appendpreview").html(data.view);
                  }
                  
                  $("#last_fileid").val(data.lastExportID);
                }else{

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
        url: '{{ url("/patients/previewdetails") }}',
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