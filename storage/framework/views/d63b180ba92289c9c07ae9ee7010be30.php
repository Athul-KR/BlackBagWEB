<div class="" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
    <div class="row">
        <div class="col-md-8 border-right pe-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-medium">About</h5>
                <a class="btn opt-btn" data-bs-toggle="modal" data-bs-dismiss="modal"
                    data-bs-target="#appointmentNotes"><span class="material-symbols-outlined">edit</span></a>
            </div>

            <?php if(empty($clinic->about)): ?>

                <div class="text-center">
                    <p>No notes added</p>
                </div>
            <?php else: ?>
                <div class="text-justify">
                    <p><?php echo nl2br($clinic->about); ?></p>
                </div>

            <?php endif; ?>


        </div>
        <div class="col-md-4 ps-4">
            <div class="detailsList cardList">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-medium">Open Hours</h5>
                    <a class="btn opt-btn" onclick="createBusinessHours()" data-bs-toggle="modal"
                        data-bs-dismiss="modal" data-bs-target="#editSlotModal"><span
                            class="material-symbols-outlined">edit</span></a>
                </div>

                <?php $__currentLoopData = $businessHours; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $businessHour): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-medium"><?php echo e($businessHour['day']); ?></h6>
                        <p>
                            <?php echo e($businessHour['start_time'] ? $businessHour['start_time'] . '-' . $businessHour['end_time'] : 'Closed'); ?>

                        </p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>


        </div>

    </div>
</div><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/clinics/about-template.blade.php ENDPATH**/ ?>