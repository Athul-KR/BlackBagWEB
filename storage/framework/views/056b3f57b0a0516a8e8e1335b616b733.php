<?php $__env->startSection('content'); ?>

<tr>
   <td colspan="2">
      <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">

         <tr>
            <td>
               <h1 style="font-size: 25px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="<?php echo e(url('public/images/mail/nurse.png')); ?>">Welcome to BlackBag <br>Your Account is Ready!</h1>
            </td>
         </tr>

         <tr>
            <td style="text-align: left;">
               <h5 style="margin-bottom: 5px; font-size: 17px">Hi <?php echo e($name); ?>,</h5>
               <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;">We are pleased to inform you that your account has been successfully created on Blackbag, our online platform designed to support seamless collaboration between healthcare professionals and their patients.</p>
               <p style="margin-bottom:0; color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;"> We are excited to have you on board and look forward to working together to enhance patient care through BlackBag.</p>
            </td>
         </tr>
      </table>
   </td>
</tr>
<tr>
   <td colspan="2" style="text-align: left; padding-top: 30px;">
      <p style="margin:0;">Thank You,</p>
      <h4 style="margin:0;">Black Bag</h4>
   </td>
</tr>
<?php
/*
<tr>
   <td colspan="2" style="text-align: center; padding-top: 30px;">
      <p style="font-size: 16px; color: #969696; line-height: 1.5; padding-top: 0; margin-top: 0;">To view your dashboard and begin <br>consulting, click below:</p>
      <a href="{{route('nurse.invitation',[$nurse_uuid])}}" style="padding: 20px 10px; text-align: center; background: #000000; display: block; text-decoration: none; color: #fff; width: 200px; margin: auto; border-radius: 5px;">Click Here</a>
      <a href="{{$link}}" style="padding: 20px 10px; text-align: center; background: #000000; display: block; text-decoration: none; color: #fff; width: 200px; margin: auto; border-radius: 5px;">Click Here</a>
   </td>
</tr>
*/
?>

<?php echo $__env->make('emails.emailfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.emailheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/emails//nurse-invitation.blade.php ENDPATH**/ ?>