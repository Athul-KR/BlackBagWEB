<?php $__env->startSection('title', 'Doctors'); ?>
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
                  <h4 class="mb-md-0">Doctors</h4>
                </div>
                <div class="col-sm-7 text-center text-sm-end">
                  <div class="btn_alignbox justify-content-sm-end">
                    <a onclick="addDoctor()" href="javascript:void(0)" class="btn btn-primary btn-align">
                      <span class="material-symbols-outlined">add</span>Add Doctor
                    </a>
                    <a class="btn filter-btn" onclick="getFilter()" href="javascript:void(0)" data-bs-toggle="dropdown" aria-expanded="false">
                      <span class="material-symbols-outlined">filter_list</span>Filters
                    </a>
                    
                  </div>
               
                    <div id="filterlist" <?php if( (isset($_GET['designation']) ) || (isset($_GET['status']))  ): ?> style="display: block;" <?php else: ?> style="display: none;" <?php endif; ?>>
                      <form id="search" method="GET">
                        <div id="fliteritems"  class="row collapse-filter mt-2 justify-content-end text-start <?php if( (isset($_GET['designation']) ) || (isset($_GET['status']))  ): ?> show <?php endif; ?>">
                          <div class="col-xl-3 col-6"> 
                            <label for="input">Designation</label>
                            <select name="designation" id="designation" class="form-select" onchange="filterBy()">
                              <option value="all">Select</option>
                              <?php if(!empty($designations)): ?>
                                <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dgn): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(isset($dgn)): ?>
                                  <option value="<?php echo e($dgn['designation_uuid']); ?>" <?php if(  (isset($_GET['designation']))  && ( $_GET['designation'] == $dgn['designation_uuid'] ) ): ?> selected <?php endif; ?>><?php echo e($dgn['name']); ?></option>
                                 <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>
                            </select>
                          </div>
                          <div class="col-xl-3 col-6"> 
                            <label for="input">Status</label>
                            <select name="status" id="status" class="form-select" onchange="filterBy()">
                              <option value="all">Select</option>
                              <option value="online" <?php if( (isset($_GET['status']) ) && $_GET['status']==  'online' ): ?> selected <?php endif; ?>>Available</option>
                              <option value="offline" <?php if( (isset($_GET['status']) ) && $_GET['status']==  'offline' ): ?> selected <?php endif; ?> >Not Available</option>
                            </select>
                          </div>
                        </div>
                      </form>
                    </div>

                  
                </div>
                <div class="col-12">
                  <div class="tab_box">
                  
                      <a href="<?php echo e(url('doctors/list/pending')); ?><?php echo e($filterParams); ?>" class="btn btn-tab <?php if($status == 'pending'): ?> active <?php endif; ?>">Pending (<?php echo e($pendingCount); ?>)</a>
                      <a href="<?php echo e(url('doctors/list/active')); ?><?php echo e($filterParams); ?>" class="btn btn-tab <?php if($status == 'active'): ?> active <?php endif; ?>">Active (<?php echo e($activecount); ?>)</a>
                      <a href="<?php echo e(url('doctors/list/inactive')); ?><?php echo e($filterParams); ?>" class="btn btn-tab <?php if($status == 'inactive'): ?> active <?php endif; ?>">Inactive (<?php echo e($innactiveCount); ?>)</a>
                  </div>
              </div>
                <div class="col-lg-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                      <thead>
                        <tr>
                          <th style="width:25%">Doctor</th>
                          <th style="width:10%">Designation</th>
                          <th style="width:20%">Specialties</th>
                          <th style="width:20%">Qualifications</th>
                          <th style="width:20%">Status</th>
                          <th class="text-end" style="width:5%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                      
                        <?php if($doctorData['data']): ?>
                          <?php $__currentLoopData = $doctorData['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      
                            <tr>
                              <td style="width:25%">
                              <?php
                                $corefunctions = new \App\customclasses\Corefunctions;
                                if($doct['logo_path'] !=''){
                                  $doct['logo_path'] = ( $doct['logo_path'] != '' ) ? $corefunctions->getAWSFilePath($doct['logo_path']) : '';
                                }
                              ?>
                              
                                <a class="primary"  <?php if($doct['deleted_at'] == ''): ?> href="<?php echo e(url('doctors/'.$doct['clinic_user_uuid'].'/details')); ?>" <?php endif; ?>>
                                <div class="user_inner">
                                  <img <?php if($doct['logo_path'] !=''): ?> src="<?php echo e(($doct['logo_path'])); ?>" <?php else: ?> src="<?php echo e(asset('images/default_img.png')); ?>" <?php endif; ?> >
                                  <div class="user_info">
                                    <h6 class="primary fw-medium m-0"><?php echo e($doct['name']); ?></h6>
                                    <p class="m-0"><?php echo e($doct['email']); ?></p>
                                  </div>
                                 
                                </div>
                                <a>
                              </td>
                              <td style="width:10%">
                              <a class="primary" <?php if($doct['deleted_at'] == ''): ?> href="<?php echo e(url('doctors/'.$doct['clinic_user_uuid'].'/details')); ?>" <?php endif; ?> >
                                <?php if(isset($designations[$doct['designation_id']]['name'])): ?>
                                  <?php echo e($designations[$doct['designation_id']]['name']); ?>

                                <?php endif; ?>
                                <a>
                              </td>
                              <td style="width:20%"><a class="primary"  <?php if($doct['deleted_at'] == ''): ?> href="<?php echo e(url('doctors/'.$doct['clinic_user_uuid'].'/details')); ?>" <?php endif; ?>> <?php echo e(optional($doct['doctor_specialty'])['specialty_name'] ?? 'No Specialty'); ?> <a></td>
                              <td style="width:20%"><a class="primary" <?php if($doct['deleted_at'] == ''): ?> href="<?php echo e(url('doctors/'.$doct['clinic_user_uuid'].'/details')); ?>" <?php endif; ?>> <?php echo e($doct['qualification']); ?><a></td>
                              <td style="width:20%">
                                <?php if($doct['login_status'] == '1'): ?>
                                  <div class="avilable-icon">
                                    <span></span> Available
                                  </div>
                                <?php else: ?>
                                <?php if($doct['status'] == '-1'): ?>
                                <div class="pending-icon">
                                    <span></span>Pending
                                  </div>
                                <?php elseif($doct['status'] == '0'): ?>
                                <div class="decline-icon">
                                    <span></span> Decline 
                                  </div>
                                <?php else: ?>
                                  <div class="notavilable-icon">
                                    <span></span>Not Available
                                  </div>
                                  <?php endif; ?>
                                <?php endif; ?>
                              </td>
                              <td class="text-end" style="width:5%">
                                <div class="d-flex align-items-center justify-content-end">
                                  <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="material-symbols-outlined">more_vert</span>
                                  </a>
                                  <ul class="dropdown-menu dropdown-menu-end">
                                   <?php if($doct['deleted_at'] == ''): ?>
                                    <li>
                                      <a onclick="editDoctor('<?php echo e($doct['clinic_user_uuid']); ?>')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-pen me-2"></i>Edit Details
                                      </a>
                                    </li>
                                    <?php if($doct['status'] == '-1' || $doct['status'] == '0'): ?>
                                    <li>
                                      <a onclick="resendInvitation('<?php echo e($doct['clinic_user_uuid']); ?>')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-paper-plane  me-2"></i>Resend Invitation
                                      </a>
                                    </li>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php if($doct['deleted_at'] != ''): ?>
                                    <li>
                                      <a onclick="deactivateDoctor('<?php echo e($doct['clinic_user_uuid']); ?>','activate')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-user-check me-2"></i>Activate Doctor
                                      </a>
                                    </li>
                                    <?php else: ?>
                                    <li>
                                      <a onclick="deactivateDoctor('<?php echo e($doct['clinic_user_uuid']); ?>','deactivate')" class="dropdown-item fw-medium">
                                        <i class="fa-solid fa-trash-can me-2"></i>Delete Doctor
                                      </a>
                                    </li>
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
                                    <div class="text-center no-records-body">
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

                  <?php if(!empty($doctorData['data'])): ?>
                    <div class="col-md-6">
                    <form method="GET" action="<?php echo e(url('doctors/list/'.$status)); ?>" >
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
                        <?php echo e($doctorList->links('pagination::bootstrap-5')); ?>

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

<!-- Import Data Modal -->
<div class="modal login-modal fade" id="import_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
      </div>
      <div class="modal-body" id="import_data_modal"></div>
    </div>
  </div>
</div>


<!-- Import Data Modal -->
<div class="modal login-modal fade" id="import_preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body" id="import_preview_modal"></div>
    </div>
  </div>
</div>

<!-- Add Doctor Modal -->
<div class="modal login-modal fade" id="addDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="addDoctor"></div>
    </div>
  </div>
</div>


<!-- edit Doctor Modal -->
<div class="modal login-modal fade" id="editDoctor_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header modal-bg p-0 position-relative">
        <!-- <a  data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
      </div>
      <div class="modal-body text-center" id="editDoctor"></div>
    </div>
  </div>
</div>

<script>
function deactivateDoctor(key, status) {
    swal({
      text: "Are you sure you want to " + status + " this doctor?",
        // text: status !,
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                value: true,
                closeModal: false // Keeps the modal open until AJAX is done
            }
        },
        dangerMode: true
    }).then((willConfirm) => {
        if (willConfirm) {
            // AJAX call only runs if confirmed
            $.ajax({
                type: "POST",
                url: "<?php echo e(URL::to('/doctors/delete')); ?>",
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
                    swal("Error!", response.message, "error");
                }
            }).catch(xhr => {
                if (xhr.status == 419) {
                    window.location.reload(); // Token expired
                } else {
                    swal("Error!", "An error occurred. Please try again.", "error");
                }
            });
        }
    });
}

  function resendInvitation(key) {
    swal({
      text: "Are you sure you want to resend the invitation?",
        // text: "This action cannot be undone!",
        icon: "warning",
        buttons: {
            cancel: "Cancel",
            confirm: {
                text: "OK",
                value: true,
                closeModal: false // Keeps the modal open until AJAX is done
            }
        },
        dangerMode: true
    }).then((Confirm) => {
        if (Confirm) {

            $.ajax({
              url: '<?php echo e(url("/doctors/resend")); ?>',
              type: "post",
              data: {
                'key' :key,
                '_token': $('meta[name="csrf-token"]').attr('content')
              },
              success: function(data) {
                console.log('1')
                if (data.success == 1) {

                  swal("success!", data.message, "success");
                
                }else{
                  swal("error!", data.message, "error");
                
                }
              }
            });
      }
    });
  }

  function editDoctor(key) {
    $("#editDoctor_modal").modal('show');
    showPreloader('editDoctor')
    $.ajax({
      url: '<?php echo e(url("/doctors/edit")); ?>',
      type: "post",
      data: {
        'key' : key ,
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#editDoctor").html(data.view);
        }
      }
    });
  }
  function addDoctor() {
    $("#addDoctor_modal").modal('show');
    $.ajax({
      url: '<?php echo e(url("/doctors/create")); ?>',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#addDoctor").html(data.view);
        }
      }
    });
  }

  function filterBy() {
    $("#search").submit();
  }

  function getFilter() {
   
    if ($("#fliteritems").hasClass("show")) {
      $("#fliteritems").removeClass('show')
      $("#filterlist").hide();
    }else{
      
      $("#filterlist").show();
      $("#fliteritems").addClass('show')
    }
  }

  function submitDoctor() {
    if ($("#doctorform").valid()) {
      $("#submitdoctr").addClass('disabled');
      $("#submitdoctr").text("Submitting..."); // Optionally change button text
      $.ajax({
        url: '<?php echo e(url("/doctors/store")); ?>',
        type: "post",
        data: {
          'formdata': $("#doctorform").serialize(),
          '_token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
          if (data.success == 1) {
            swal("success!", data.message, "success");
          setTimeout(function(){ window.location.reload(); },1000);
            
          } else {
            swal("error!", data.message, "error");
            
          }
        }
      });
    }
  }

  function importDoctor() {
    $("#addDoctor_modal").modal('hide');
    $("#import_data").modal('show');
    showPreloader('import_data_modal')
    $.ajax({
      url: '<?php echo e(url("/doctors/import")); ?>',
      type: "post",
      data: {
        '_token': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(data) {
        if (data.success == 1) {
          $("#import_data_modal").html(data.view);
        }
      }
    });
  }
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/doctors/listing.blade.php ENDPATH**/ ?>