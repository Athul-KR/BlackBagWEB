<form id="uploadfile" action="<?php echo e(url('file/upload')); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?> <!-- Include CSRF token -->
    <input type="file" name="file" required accept=".xls,.xlsx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"> <!-- Add the required attribute for better UX -->
    <input type="hidden" name="type" value="<?php echo e($type); ?>">
    <button type="submit">Upload</button>
</form><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/upload.blade.php ENDPATH**/ ?>