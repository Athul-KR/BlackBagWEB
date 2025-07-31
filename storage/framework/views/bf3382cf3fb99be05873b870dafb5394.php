

                          
            <div class="web-card h-100 mb-3 overflow-hidden">
                <div class="profileData patientProfile">
                    <div class="row align-items-end h-100">
                        
                              
                    
                    <div class="table-responsive">
                    <table class="table table-white text-start w-100">
                      <thead>
                          <tr>
                          <th style="width:10%">Name</th>
                          <th style="width:10%">Email</th>
                          <!-- <th style="width:15%">Designation</th> -->
                          <th style="width:10%">Specialty</th>
                          <th style="width:10%">Qualification</th>
                          <th style="width:10%">Country Code</th>
                          <th style="width:10%">Phone</th>
                          <th style="width:25%">Status</th>

                          <th class="text-end"></th>  
                              
                          </tr>
                      </thead>
                      <tbody>
                          
                          <?php if($excelDetails): ?>
                          <?php $__currentLoopData = $excelDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index =>  $doct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            <tr id="rmv_doc_<?php echo e($doct['import_doc_uuid']); ?>" class="rmv_doc_<?php echo e($doct['import_doc_uuid']); ?>">  
                            
                              <td><?php echo e($doct['name']); ?></td>
                              <td ><?php echo e($doct['email']); ?></td>
                              <td><?php echo e($doct['phone_number']); ?></td>
                              <td style="width:15%"><?php echo e($doct['department']); ?></td>
                              <td style="width:10%"><?php if(isset($specialtyDetails[$doct['specialty_id']]) && (!empty($specialtyDetails[$doct['specialty_id']])) ): ?> <?php echo e($specialtyDetails[$doct['specialty_id']]['specialty_name']); ?> <?php else: ?> -- <?php endif; ?></td>
                              <td style="width:10%"><?php echo e($doct['qualification']); ?></td>
                              <?php if(isset($doct['error']) && $doct['error'] !=''): ?>
                                <td class="error-info">  Error </td> 
                              <?php else: ?>
                                <td class="success-info ">  Success </td> 
                              <?php endif; ?>
                              <td class="text-end"><a class="danger" href="javascript:void(0);" id="removedoc"  onclick="removeDocument('<?php echo e($doct['import_doc_uuid']); ?>')"><span class="material-symbols-outlined">delete</span></a></td>
                                
                            </tr>
                            <?php if(isset($doct['is_exists']) && $doct['is_exists'] =='1'): ?>
                            <tr>
                                <td colspan="8" class="table-note p-0">
                                  <p> Some of the fields seem to be different from already existing data </p> <a onclick="viewDetails('<?php echo e($doct['import_doc_uuid']); ?>')" href="javascript:void(0);">View</a>
                                </td>
                            </tr>
                            <?php endif; ?>
                            <?php if(isset($doct['error']) && $doct['error'] !=''): ?>
                            <tr class="rmv_doc_<?php echo e($doct['import_doc_uuid']); ?>">
                              <td colspan="8" class="table-note p-0">
                                 <p> <?php echo $doct['error'] ?></p> <input type="hidden" class="is_error" name="is_error" value="1">
                              </td>
                            </tr>
                            <?php endif; ?>   
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          <?php endif; ?>

                        
                        </tbody>
                      </table>
                    </div>

                    <div class="btn_alignbox justify-content-end mt-4">
                      <?php if(!empty($excelDetails)): ?>
                        <a class="btn btn-primary" id="submit-btn" onclick="importDoctors()" >Continue</a>
                      <?php endif; ?>
                    </div>

                    </div>
                </div>
            </div>
      


<?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/nurses/preview.blade.php ENDPATH**/ ?>