<div class="col-12">

    <section>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>User Details</h4>
            <a class="btn opt-btn" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#editUserInfo">
                <span class="material-symbols-outlined">edit</span>
            </a>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-medium mb-0">Name</h6>
                    <p class="mb-0"><?php echo e($clinic->clinicUsers->name); ?></p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-medium mb-0">Email</h6>
                    <p class="mb-0"><?php echo e($clinic->clinicUsers->email); ?></p>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-medium mb-0">Phone</h6>
                    <p class="mb-0">
                        <?php echo e(optional($countryCode)->country_code . " " . optional($clinic->clinicUsers)->phone_number); ?>

                    </p>
                </div>
            </div>
        </div>

    </section>

</div><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/clinics/user-info.blade.php ENDPATH**/ ?>