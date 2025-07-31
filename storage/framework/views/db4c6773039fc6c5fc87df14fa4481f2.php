<?php $__env->startSection('title', 'Patient'); ?>
<?php $__env->startSection('content'); ?>


      <section id="content-wrapper">
                    <div class="container-fluid p-0">
                      <div class="row h-100">
                        <div class="col-lg-12">
                          <div class="row">
                           
                            <div class="col-lg-12 mb-3">
                              <div class="web-card h-100 mb-3">
                                <div class="row">
                                  <div class="col-sm-5 text-center text-sm-start">
                                    <h4 class="mb-md-0">Patient Records</h4>
                                  </div>
                                  <div class="col-sm-7 text-center text-sm-end">
                                    <div class="btn_alignbox justify-content-md-end">
                                      <a onclick="createPatient()" class="btn btn-primary btn-align"  ><span class="material-symbols-outlined">add </span>Add Patient</a>
                                      <a class="btn filter-btn"  onclick="getFilter()" ><span class="material-symbols-outlined">filter_list</span>Filters</a>
                                    </div>

                                      <div <?php if(isset($_GET['searchterm']) && $_GET['searchterm'] !=''): ?> style="display: block;" <?php else: ?> style="display: none;" <?php endif; ?> id="patientfilter" class="collapse-filter">
                                      <form id="search" method="GET">
                                        <div class="row justify-content-end mt-3">
                                          <div class="col-md-6">
                                            <div class="form-group form-outline mb-3">
                                              <label for="input" class="float-label">Search by patient</label>
                                              <i class="fa-solid fa-circle-user"></i>
                                              <input type="text" class="form-control" name="searchterm" <?php if(isset($_GET['searchterm']) && $_GET['searchterm'] !=''): ?> values="<?php echo e($_GET['searchterm']); ?>" <?php endif; ?>>
                                            </div>
                                          </div>
                                        </div>
                                      </form>

                                      </div>
                                  </div>

                                 

                                  
                                

                                  <div class="col-12">
                                    <div class="tab_box">
                                         <a href="<?php echo e(url('patient/list/pending')); ?>" class="btn btn-tab <?php if($status == 'pending'): ?> active <?php endif; ?>">Pending (<?php echo e($pendingcount); ?>)</a>

                                        <a href="<?php echo e(url('patient/list/active')); ?>" class="btn btn-tab <?php if($status == 'active'): ?> active <?php endif; ?>">Active (<?php echo e($activecount); ?>)</a>
                                        <a href="<?php echo e(url('patient/list/inactive')); ?>" class="btn btn-tab <?php if($status == 'inactive'): ?> active <?php endif; ?>">Inactive (<?php echo e($inactiveCount); ?>)</a>
                                    </div>
                                </div>
                               
                                  <div class="col-lg-12 mb-3 mt-4">
                                    <div class="table-responsive">
                                      <table class="table table-hover table-white text-start w-100">
                                      <thead>
                                        <tr>
                                          <th>Patient</th>
                                          <th>Age</th>
                                          <th>Gender</th>
                                          <th>Phone Number</th>
                                          <th>Address</th>
                                          <th>Previous Appointment</th>
                                          <th class="text-end">Actions</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                      
                                      <?php if(!empty($patientList['data'])): ?>
                                      <?php $__currentLoopData = $patientList['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     
                                        <tr>
                        
                                          <td>
                                            <div class="user_inner">
                                              <?php
                                                $corefunctions = new \App\customclasses\Corefunctions;
                                                if($pl['logo_path'] !=''){
                                                  $pl['logo_path'] = ( $pl['logo_path'] != '' ) ? $corefunctions->getAWSFilePath($pl['logo_path']) : '';
                                                }
                                              ?>
                                                <img <?php if($pl['logo_path'] !=''): ?> src="<?php echo e(asset($pl['logo_path'])); ?>" <?php else: ?> src="<?php echo e(asset('images/default_img.png')); ?>" <?php endif; ?>>
                                                <div class="user_info">
                                                  <a  <?php if($pl['deleted_at'] == ''): ?> href="<?php echo e(url('patient/'.$pl['patients_uuid'].'/details')); ?>" <?php endif; ?>>
                                                    <h6 class="primary fw-medium m-0"><?php echo e($pl['name']); ?></h6>
                                                    <p class="m-0"><?php echo e($pl['email']); ?></p>
                                                  </a>
                                                </div>
                                            </div>
                                          </td>
                                        
                                          <td><?php echo e($pl['age']); ?></td>
                                          <td><?php if($pl['gender'] == '1'): ?> Male <?php elseif($pl['gender'] == '2'): ?> Female <?php else: ?> Other <?php endif; ?></td>
                                          <td><?php echo e($pl['phone_number']); ?></td>
                                          <td><?php echo e($pl['address']); ?> <p><?php echo e($pl['city']); ?>, <?php echo e($pl['state']); ?> <?php echo e($pl['zip']); ?> </p> </td>
                                          <td><?php if(isset($pl['last_appointment'])): ?><?php echo e($pl['last_appointment']); ?> <?php else: ?> -- <?php endif; ?></td>
                                          <td class="text-end">
                                            <div class="d-flex align-items-center justify-content-end">
                                              <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="material-symbols-outlined">more_vert</span>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <?php if($pl['deleted_at'] == ''): ?>
                                                  <li><a onclick="editPatients('<?php echo e($pl['patients_uuid']); ?>')" class="dropdown-item fw-medium" ><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                  <li><a onclick="referPatient('<?php echo e($pl['patients_uuid']); ?>')" class="dropdown-item fw-medium"  ><i class="fa-regular fa-rectangle-list me-2"></i></i>Refer Patient</a></li>
                                                <?php endif; ?>
                                                <?php if($pl['deleted_at'] != ''): ?>
                                                  <li><a onclick="removePatient('<?php echo e($pl['patients_uuid']); ?>','activate')" class="dropdown-item fw-medium"><i class="fa-solid fa-user-check me-2"></i>Activate Patient</a></li>
                                                <?php else: ?>
                                                  <?php if($pl['status'] == '-1' || $pl['status'] == '0'): ?>
                                                    <li><a onclick="resendInvitation('<?php echo e($pl['patients_uuid']); ?>')"  class="dropdown-item fw-medium">
                                                    <i class="fa-solid fa-paper-plane  me-2"></i>Resend Invitation
                                                    </a></li>
                                                  <?php endif; ?>

                                                  <li><a onclick="removePatient('<?php echo e($pl['patients_uuid']); ?>','deactivate')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Remove Patient</a></li>
                                                <?php endif; ?>
                                              </ul>
                                            </div>
                                          </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>

                                       
                                         
                                          <tr class="text-center">
                                                <td colspan="8">
                                                    <div class="flex justify-center">
                                                        <div class="text-center  no-records-body">
                                                            <img src="<?php echo e(asset('images/nodata.png')); ?>"
                                                                class=" h-auto">
                                                            <p>No record found</p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                           

                                        <?php endif; ?>
                                       
                                        
                                      </tbody>
                                    </table>
                                  </div>  
                                  </div>
                                  <div class="col-12">
                                    <div class="row">
                                    <?php if(!empty($patientList['data'])): ?>
                                      <div class="col-md-6">
                                      <form method="GET" action="<?php echo e(route('patient.list')); ?>">
                                        <div class="sort-sec">
                                          <p class="me-2 mb-0">Displaying per page :</p>
                                          <select class="form-select" aria-label="Default select example" name="limit" onchange="this.form.submit()">
                                          <option value="10" <?php echo e($limit == 10 ? 'selected' : ''); ?>>10</option>
                                          <option value="15" <?php echo e($limit == 15 ? 'selected' : ''); ?>>15</option>
                                          <option value="20" <?php echo e($limit == 20 ? 'selected' : ''); ?>>20</option>
                                          </select>
                                       </div>
                                      </form>
                                      </div>
                                      <?php endif; ?>
                                      <div class="col-md-6">
                                      <?php echo e($patientData->links('pagination::bootstrap-5')); ?>

                                     
                                      </div>

                                    </div>

                                  </div>
                                </div>
                              </div>
                           </div>
                          </div>
                        </div>
                         
                        </div>
                      </div>
                    </section>



                     <!-- Add New Patient -->

                  <div class="modal login-modal fade" id="addPatientModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                      <div class="modal-content">
                          <div class="modal-header modal-bg p-0 position-relative">
                              <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
                      
                          </div>
                          <div class="modal-body text-center position-relative" id="addPatientform">
                           
                            </div>
                        </div>
                      </div>
                    </div>


                  <!-- Import Data Modal -->
          <div class="modal login-modal fade" id="import_Patient" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
              <div class="modal-content">
                <div class="modal-header modal-bg p-0 position-relative">
                  <!-- <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
                </div>
                <div class="modal-body" id="import_patient_modal"></div>
              </div>
            </div>
          </div>

          <link rel="stylesheet" href="<?php echo e(asset('css/bootstrap-datetimepicker.min.css')); ?>">
<script src="<?php echo e(asset('js/bootstrap-datetimepicker.min.js')); ?>"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->

<style>
    .colorpicker {
        z-index: 9999 !important;
    }
    .icon-add {
    vertical-align: middle; /* Ensures vertical alignment of the icon */
    font-size: 20px; /* Adjust size as needed */
    margin-right: 5px; /* Adds a little space between the icon and text */
}

</style>

<script type="text/javascript">

function resendInvitation(key) {
    
    $.ajax({
      url: '<?php echo e(url("/patient/resend")); ?>',
      type: "post",
      data: {
        'key' :key,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          swal("Success!", data.message, "success");
          
        }else{
          swal("error!", data.message, "error");
      
        }
      }
    });
  }


function importPatient() {
    $("#addPatientModal").modal('hide');
    $("#import_Patient").modal('show');
    showPreloader('import_patient_modal')
    $.ajax({
      url: '<?php echo e(url("/patient/import")); ?>',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#import_patient_modal").html(data.view);
        }
      }
    });
  }
function getFilter() {
                          
    if ($("#patientfilter").hasClass("show")) {
      $("#patientfilter").removeClass('show')
      $("#patientfilter").hide();
    }else{
      
      $("#patientfilter").show();
      $("#patientfilter").addClass('show')
    }
  }
$('#search').keypress(function(event) {
    if (event.which === 13) { // Enter key code is 13
        event.preventDefault(); // Prevent the default form submit
        $("#search").submit();
    }
});

  function referPatient(key){
    $("#referpatientModal").modal('show');
     $.ajax({
       url: '<?php echo e(url("/patient/refer")); ?>',
       type: "post",
       data: {
          'key' : key,
         '_token': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data) {
         if (data.success == 1) {
          $("#referpatient").html(data.view);
         } else {
          swal("error!", data.message, "error");
         
         }
       }
     });

  }
  function removeImage(){

    $("#patientimage").attr("src","<?php echo e(asset('images/default_img.png')); ?>");
    $("#isremove").val('1');
    $("#removelogo").hide();
    $("#upload-img").show();

  }
  function addnotes(type){
    if(type == 'add'){
      $("#addnotes").show();
      $("#remove").show();
      $("#add").hide();
    }else{
      $("#addnotes").hide();
      $("#remove").hide();
      $("#add").show();
    }
   
  }
  function loadColorBox(){
      $(".aupload").colorbox({
          iframe: true,
          width: "650px",
          height: "650px"
      });
  }
  function patientImage(imagekey, imagePath) {
    $("#tempimage").val(imagekey);
    $("#patientimage").attr("src", imagePath);
    $("#patientimage").show();
    $("#upload-img").hide();
    $("#removelogo").show();
  }


function createPatient(){
  
  $("#addPatientModal").modal('show');
 
  showPreloader('addPatientform')
  $.ajax({
      url: '<?php echo e(url("/patient/create")); ?>',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#addPatientform").html(data.view);
           $('#patientform')[0].reset(); // Reset the form
          loadColorBox();
        }
      }
    });
}
  function submitPatient() {
   
    if ($("#patientform").valid()) {
      $("#submitpatient").addClass('disabled');
      $("#submitpatient").text("Submitting...");
      $.ajax({
        url: '<?php echo e(url("/patient/store")); ?>',
        type: "post",
        data: {
          'formdata': $("#patientform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
            swal("success!", data.message, "success");
           
            window.location.reload();
          } else {
            swal("error!", data.message, "success");
            
          }
        }
      });
    }
  }
  function editPatients(key) {
    $("#editpatientModal").modal('show');
     $.ajax({
       url: '<?php echo e(url("/patient/edit")); ?>',
       type: "post",
       data: {
          'key' : key,
         '_token': $('meta[name="csrf-token"]').attr('content')
       },
       success: function(data) {
         if (data.success == 1) {
          $("#editpatient").html(data.view);
         
            // Initialize floating labels for inputs within the modal
            $('#editpatientModal').find('input, textarea').each(function() {
              toggleLabel(this);
            });
         } else {
          swal("error!", data.message, "success");
          
         }
       }
     });
   
 }
  

 function removePatient(key, status) {
    swal({
        title: "Are you sure you want to " + status + " this patient?",
        text: "",
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                closeModal: false
            }
        },
        dangerMode: true
    }).then((willDelete) => {
        if (willDelete) {
            // AJAX call if user confirms
            $.ajax({
                type: "POST",
                url: "<?php echo e(URL::to('/patient/delete')); ?>",
                data: {
                    'key': key,
                    'status': status,
                    "_token": "<?php echo e(csrf_token()); ?>"
                },
                dataType: 'json'
            }).then(response => {
                if (response.success == 1) {
                    swal("Success!", response.message, "success").then(() => {
                        window.location.reload();
                    });
                } else {
                    swal("Error!", "An error occurred", "error");
                }
            }).catch(xhr => {
                if (xhr.status == 419) {
                    window.location.reload(); // Token expired
                } else {
                    swal("Error!", "An error occurred", "error");
                }
            });
        }
    });
}




    </script>

 


              <div class="modal login-modal fade" id="editpatientModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header modal-bg p-0 position-relative">
                        <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
                
                    </div>
                    <div class="modal-body text-center position-relative" id="editpatient">
                      <h4 class="text-center fw-medium mb-0 ">Edit  Patient</h4>
                    
                      
                      
                      
                      </div>
                  </div>
                </div>
              </div>


              <!-- refer a patient  -->
              <div class="modal login-modal fade" id="referpatientModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-bg p-0 position-relative">
                        <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                
                    </div>
                    <div class="modal-body text-center position-relative" id="referpatient">
                   
                    
                      
                      
                      
                      </div>
                  </div>
                </div>
              </div>


              <!-- Import Data Modal -->
            <div class="modal login-modal fade" id="import_preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-xxl">
                <div class="modal-content">
                  <div class="modal-header modal-bg p-0 position-relative">
                    <!-- <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
                  </div>
                  <div class="modal-body" id="import_preview_modal"></div>
                </div>
              </div>
            </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/patient/listing.blade.php ENDPATH**/ ?>