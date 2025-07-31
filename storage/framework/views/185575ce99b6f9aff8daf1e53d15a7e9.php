<?php echo $__env->make('emails.emailheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
   
                     <tr>
                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
                              <tr>
                                 <td>
                                    <h1 style="font-size: 25px; margin-top: 0; margin-top: 0;"><span><img style="width: 30px; margin-right: 7px; vertical-align: bottom;" src="<?php echo e(url('public/images/mail/doctor.png')); ?>"></span>Welcome to BlackBag <br>Your Account is Ready!</h1>  
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left;">
                                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hi <?php echo e($name); ?>,</h5>
                                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;">We are reaching out to inform you that BlackBag has sent you an invitation to join us as a patient user. Blackbag is our online platform designed to support seamless collaboration between healthcare professionals and their patients.</p>
                                    
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <!-- <tr>
                        <td colspan="2" style="text-align: left; padding-top: 30px;">
                           <p style="margin:0;">Thank You,</p>
                           <h4 style="margin:0;">Black Bag</h4>
                        </td>
                     </tr> -->
                     <tr>
                        <td colspan="2" style="text-align: center; padding-top: 30px;">
                           <p style="font-size: 14px; color: #969696; line-height: 1.5; padding-top: 0; width: 90%; margin: auto;">Please take a moment to review the invitation and approve it at your earliest convenience. We appreciate your attention to this matter</p>
                           <a href="<?php echo e($link); ?>" style="padding: 20px 10px; text-align: center; background: #000000; display: block; text-decoration: none; color: #fff; width: 200px; margin: auto; border-radius: 5px; margin-top: 15px;">Accept Invitation</a>
                        </td>
                     </tr>
                     
                     <?php echo $__env->make('emails.emailfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                  
               
     
  



<?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/emails/patientinvitation.blade.php ENDPATH**/ ?>