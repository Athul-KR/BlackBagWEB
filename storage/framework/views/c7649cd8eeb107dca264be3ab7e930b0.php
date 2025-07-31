<?php $__env->startSection('title', 'Appointment'); ?>
<?php $__env->startSection('content'); ?>
   
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
                            
                      </div>
                    </div>
                  </section>






<script>

$(document).ready(function() {
        var importKey = '<?php echo e($importKey); ?>' ;

        getPreviewForm(importKey);

        $(window).on('scroll', function() {
          if(parseInt($(window).scrollTop() + $(window).height() + 1) >= parseInt($(document).height())) {
              lastFileID = ( $("#last_fileid").length > 0 ) ? $("#last_fileid").val() : 0;
              getPreviewForm(importKey,lastFileID);
          }
      });



  });

    // Function to generate preview
    function getPreviewForm(import_key,isloadmore='') {

      var lastFileID = ( $("#last_fileid").length > 0 && isloadmore == 1 ) ? $("#last_fileid").val() : 0;

          showPreloader('appendpreview')
          $.ajax({
              url: '<?php echo e(url("/nurse/importpreview")); ?>',
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
              }
        });
       
    }

  function importDoctors() {
    var importKey = '<?php echo e($importKey); ?>' ;
    let iserrorRecords = $('.is_error').val();

    if(iserrorRecords !='1'){
      
      $("#submit-btn").addClass('disabled');
        $.ajax({
            url: '<?php echo e(url("/nurse/import/store")); ?>',
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
                window.location.href = "<?php echo e(url('nurse/list')); ?>" ;
              } else {
                swal({
                  icon: 'error',
                  text: data.message,
                });
              }
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
            url: '<?php echo e(url("/nurse/import/delete")); ?>',
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
                  icon: 'success',
                  text: data.message,
                });
              } else {
                swal({
                  icon: 'error',
                  text: data.message,
                });
              }
            }
      });
  }


   // Function to generate preview
   function viewDetails(importKey) {

    $("#viewDetails_modal").modal('show');
    showPreloader('viewDetails')
    $.ajax({
        url: '<?php echo e(url("/nurse/previewdetails")); ?>',
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


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/nurses/excelpreview.blade.php ENDPATH**/ ?>