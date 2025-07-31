@extends('layouts.app')
@section('title', 'Appointment')
@section('content')
   
<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-12 mb-3">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
          <ol class="breadcrumb d-inline-flex justify-content-center justify-content-sm-start">
            <li class="breadcrumb-item"><a href="patientrecords.html" class="primary">Import Doctors</a></li>
          </ol>
        </nav>
      </div>
      <div class="col-xl-12 col-12 " id="appendpreview" >
          
      </div>
      <input type="hidden" id="last_fileid" name="last_fileid" value="">
      <input type="hidden" id="hasdata" name="hasdata" value=""> 
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
              if( $('#hasdata').val() == 1 && lastFileID !=0){
                console.log('3')
                getPreviewForm(importKey,lastFileID,isloadmore=1);
              }
             
          }
      });



  });

    // Function to generate preview
    function getPreviewForm(import_key,isloadmore='') {

      var lastFileID = ( $("#last_fileid").length > 0 && isloadmore == 1 ) ? $("#last_fileid").val() : 0;
        if(isloadmore != 1){
          showPreloader('appendpreview')
        }
          
          $.ajax({
              url: '{{ url("/doctors/importpreview") }}',
              type: "post",
              data: {
               'importKey' : import_key,
               'lastExportID' : lastFileID,
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
            }
        });
       
    }

  function importDoctors() {
    var importKey = '{{$importKey}}' ;
    let iserrorRecords = $('.is_error').val();

    if(iserrorRecords !='1'){
      
      $("#submit-btn").addClass('disabled');
        $.ajax({
            url: '{{ url("/doctors/import/store") }}',
            type: "post",
            data: {
              'importKey' : importKey,
              '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                swal({
                  icon: 'success',
                  text: data.message,
                });
                window.location.href = "{{url('doctors/list/pending')}}" ;
              } else {
                swal({
                  icon: 'error',
                  text: data.message,
                });
              }
            },
            error: function(xhr) {
               
              handleError(xhr);
             }
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
            url: '{{ url("/doctors/import/delete") }}',
            type: "post",
            data: {
              'importKey' : importKey,
              '_token'    : $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
              if (data.success == 1) {
                $('.rmv_doc_'+importKey).remove();
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
           }
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
        }
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