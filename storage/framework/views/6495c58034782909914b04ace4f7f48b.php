


                <div class="row">
                  <div class="col-sm-9 text-center text-sm-start">
                    <h4 class="mb-md-0">Appointments</h4>
                  </div>
                  <div class="col-sm-3 text-center text-sm-end">
                  <?php if(!empty($appointmentDetails)): ?>
                    <a href="<?php echo e(url('appointment/list')); ?>" class="link primary fw-medium text-decoration-underline">See All</a>
                    <?php endif; ?>
                  </div>
                  <div class="col-12 mb-3 mt-4">
                    <?php if($appointmentDetails): ?>
                    <?php $__currentLoopData = $appointmentDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="contributors-sec">
                        <div class="user_inner">
                            <?php  $logo_path = '';
                                $corefunctions = new \App\customclasses\Corefunctions;
                                if(isset($finalPatient[$aps['patient_id']]['logo_path']) && ($finalPatient[$aps['patient_id']]['logo_path'] !='') ){
                                  $logo_path = $corefunctions->getAWSFilePath($finalPatient[$aps['patient_id']]['logo_path']) ;
                                }
                              ?>
                          <img <?php if($logo_path !=''): ?> src="<?php echo e($logo_path); ?>" <?php else: ?> src="<?php echo e(asset('images/default_img.png')); ?>" <?php endif; ?>>
                          <div class="user_info">
                            <a <?php if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['patients_uuid']) ): ?> href="<?php echo e(url('patient/'.$patientDetails[$aps['patient_id']]['patients_uuid'].'/details')); ?>" <?php endif; ?>>
                              <h6 class="primary fw-medium m-0"><?php if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['name']) ): ?> <?php echo e($patientDetails[$aps['patient_id']]['name']); ?> <?php else: ?> -- <?php endif; ?></h6>
                              <p class="m-0"><?php if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['email']) ): ?> <?php echo e($patientDetails[$aps['patient_id']]['email']); ?> <?php else: ?> -- <?php endif; ?></p>
                            </a>
                          </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end">
                            <p class="m-0"><?php echo  date('h:i A', strtotime($aps['appointment_time'])) ?></p>
                            <a class="btn opt-btn border-0" <?php if(isset($patientDetails[$aps['patient_id']]) && isset($patientDetails[$aps['patient_id']]['patients_uuid']) ): ?> href="<?php echo e(url('patient/'.$patientDetails[$aps['patient_id']]['patients_uuid'].'/details')); ?>" <?php endif; ?> data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy"><i class="fa-solid fa-chevron-right"></i></a>
                        </div>
                      </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                    <div class="text-center no-records-body">
                        <img src="<?php echo e(asset('images/nodata.png')); ?>"
                            class=" h-auto">
                        <p>No record found</p>
                    </div>

                    <?php endif; ?>


                  </div>
                  <div class="col-12">
                    <a class=" btn btn-primary px-5 mb-2 py-2 w-100 btn-align" onclick='createAppointment()'><span class="material-symbols-outlined">add</span>Add New Appointment</a>
                  </div>
                </div>

             

<?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/dashboard/appointment.blade.php ENDPATH**/ ?>