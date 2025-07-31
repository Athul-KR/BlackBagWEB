
<?php $__env->startSection('content'); ?>

<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">

            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="<?php echo e(url('public/images/mail/nurse.png')); ?>">Welcome to BlackBag <br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hello! BlackBag Admin,</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;">We are reaching out to inform you that, someone has shown interest in BlackBag
                        and sent an inquiry request. Please take necessary actions!</p>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">The Inquiry Details</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;"><?php echo e($name); ?></p>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;"><?php echo e($userEmail); ?></p>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;"><?php echo e($phone); ?></p>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;"><?php echo e($userMessage); ?></p>
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

<?php echo $__env->make('emails.emailfooter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('emails.emailheader', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/emails/inquiry.blade.php ENDPATH**/ ?>