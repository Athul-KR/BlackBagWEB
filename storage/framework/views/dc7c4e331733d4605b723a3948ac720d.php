<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>

<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row align-items-center">
                <div class="col-8 mb-3">
                  <h4 class="mb-0">Support</h4>
                </div>
                <div class="col-12 mb-3 mt-4">
                  <div class="row">
                    <div class="col-xl-7 col-12 mx-auto">
                      <div class="text-center">
                        <img src="<?php echo e(asset('images/active_support.png')); ?>" class="img-fluid supportImg mb-4">
                        <h3>Get the Help You Need</h3>
                        <h6 class="gray">We're Here to Assist You with Any Questions or Issues</h6>
                      </div>
                    </div>
                    <div class="col-xl-5 col-12">
                      <div class="text-center">
                        <form method="post" action="<?php echo e(route('support.store')); ?>" id="support_form">
                          <?php echo csrf_field(); ?>
                          <div class="form-group form-outline mb-3">
                            <i class="material-symbols-outlined">contact_support</i>
                            <select name="support_type" class="form-select">
                              <option selected value="">Tell us about your technical issue</option>
                              <?php $__currentLoopData = $supportTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supportType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <option value="<?php echo e($supportType->id); ?>"><?php echo e($supportType->type); ?></option>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                          </div>
                          <div class="form-group form-outline form-textarea mb-4">
                            <label for="input" class="float-label">Message</label>
                            <i class="fa-solid fa-file-lines"></i>
                            <textarea name="message" class="form-control" rows="4" cols="4" placeholder=""></textarea>
                          </div>
                          <div class="btn_alignbox">
                            <button type="submit" id="support_form_btn" class="btn btn-primary w-100">Submit Your Feedback</button>
                          </div>
                        </form>
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
  </div>
</section>
<script>
  $(document).ready(function() {
    var form = $("#support_form");
    $("#support_form").validate({
      rules: {
        support_type: {
          required: true
        },
        message: {
          required: true,
          minlength: 10
        }
      },
      messages: {
        support_type: {
          required: "Please select a support type"
        },
        message: {
          required: "Please enter your message",
          minlength: "Your message must be at least 10 characters long"
        }
      },
      submitHandler: function(form) {
        $('#support_form_btn').prop('disabled', true);
        $('#support_form_btn').text("Submitting.....");
        form.submit();
      }
    });
  });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/support.blade.php ENDPATH**/ ?>