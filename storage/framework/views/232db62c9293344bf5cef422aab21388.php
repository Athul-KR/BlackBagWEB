<div class="" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-medium">Gallery</h5>
        <a class="btn opt-btn" href="#" data-bs-toggle="modal" data-bs-dismiss="modal"
            data-bs-target="#appointmentDoc"><span class="material-symbols-outlined">add</span></a>
    </div>

    <div class="gallery_wrapper">
        <div class="row">
            <?php if($galleryImages->isEmpty()): ?>
                <div class="col-12 text-center">
                    <p>No Images Found</p>
                </div>
            <?php else: ?>

                <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $galleryImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <div class="col-xl-2 col-lg-4 col-md-6 col-12 position-relative gallery-img">
                        <a href="<?php echo e($galleryImage->image); ?>" data-toggle="lightbox" data-gallery="example-gallery">
                            <div class="item"><img class="transition img-responsive" src="<?php echo e($galleryImage->image); ?>"></div>
                        </a>
                        <a class="remove-img" onclick="removeGalleryImage('<?php echo e($galleryImage->gallery_uuid); ?>', event)"> <span
                                class="material-symbols-outlined">delete</span></a>
                    </div>
                    <!-- <div class="col-xl-2 col-lg-4 col-md-6 col-12">
                                        <a href="<?php echo e($galleryImage->image); ?>" data-toggle="lightbox" data-gallery="<?php echo e($galleryImage->gallery_uuid); ?>">
                                            <div class="item"><img class="transition img-responsive" src="<?php echo e($galleryImage->image); ?>"><span onclick="removeGalleryImage('<?php echo e($galleryImage->gallery_uuid); ?>', event)"
                                                    class="material-symbols-outlined">delete</span>
                                            </div>
                                        </a>
                                    </div> -->
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php endif; ?>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/clinics/gallery-template.blade.php ENDPATH**/ ?>