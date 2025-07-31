<?php $__env->startSection('title', 'Find Doctors & Clinics'); ?>
<?php $__env->startSection('content'); ?>

<section class="banner-container">

    <div class="container">
        <div class="row">
            <div class="col-10 mx-auto">
                <div class="content_box text-center">
                    <h1>Find Your Specialist</h1>
                    <p>Easily locate the right healthcare professional for your needs with our comprehensive search feature.</p>
                </div>
            </div>
            <div class="col-10 mx-auto">
                <div class="row justify-content-center">
                    <div class="col-xl-2 col-lg-4">
                        <div class="form-group form-outline form-textarea mb-4">
                            <label for="input">Location</label>
                            <i class="material-symbols-outlined">location_on</i>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="col-xl-2 col-lg-4">
                        <div class="form-group form-outline form-textarea mb-4">
                            <label for="input">Category</label>
                            <i class="material-symbols-outlined">medication</i>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="col-xl-6 col-12">
                        <div class="form-group form-outline form-textarea mb-4">
                            <label for="input">Search doctors or specialities</label>
                            <i class="material-symbols-outlined">search</i>
                            <input type="email" class="form-control" id="exampleFormControlInput1">
                        </div>
                    </div>
                    <div class="col-xl-2 col-12 text-center">
                        <a href="<?php echo e(route('frontend.searchResults')); ?>" class="btn btn-primary mb-xl-0 mb-4">Search</a>
                    </div>
                    <div class="col-12">
                        <ul class="flex-row justify-content-center flex-wrap">
                            <li class="me-4">Popular searches: </li>
                            <li class="primary text-decoration-underline">General Practitioner (GP)</li>
                            <li class="primary text-decoration-underline">Pediatrician</li>
                            <li class="primary text-decoration-underline">Cardiologist</li>
                            <li class="primary text-decoration-underline">Neurologist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between flex-sm-row flex-column align-items-center">
                    <div class="content_box">
                        <h3>Our Specialities</h3>
                        <p class="mb-0">Comprehensive Care Across a Wide Range of Medical Fields</p>
                    </div>
                    <div class="mt-sm-0 mt-3">
                        <a class="btn btn-outline-primary">View All</a>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div id="doctor-slider" class="owl-carousel">
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="<?php echo e(asset('frontend/images/slide1.png')); ?>" alt="">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>General Physician</h4>
                           <a href="" class="primary d-flex justify-content-center align-items-center text-decoration-underline">Consult Now<span class="material-symbols-outlined">chevron_right </span></a>
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="<?php echo e(asset('frontend/images/slide2.png')); ?>" alt="">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Dermatology</h4>
                           <a href="" class="primary d-flex justify-content-center align-items-center text-decoration-underline">Consult Now<span class="material-symbols-outlined">chevron_right </span></a>
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="<?php echo e(asset('frontend/images/slide3.png')); ?>" alt="">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Paediatrics</h4>
                           <a href="" class="primary d-flex justify-content-center align-items-center text-decoration-underline">Consult Now<span class="material-symbols-outlined">chevron_right </span></a>
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="<?php echo e(asset('frontend/images/slide4.png')); ?>" alt="">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Urology</h4>
                           <a href="" class="primary d-flex justify-content-center align-items-center text-decoration-underline">Consult Now<span class="material-symbols-outlined">chevron_right </span></a>
                        </div>
                    </div>
                    <div class="post-slide">
                        <div class="post-img">
                            <img src="<?php echo e(asset('frontend/images/slide5.png')); ?>" alt="">
                        </div>
                        <div class="content_box text-center mt-3">
                            <h4>Gynaecology</h4>
                           <a href="" class="primary d-flex justify-content-center align-items-center text-decoration-underline">Consult Now<span class="material-symbols-outlined">chevron_right </span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <div class="row align-items-center mb-4">
            <div class="col-lg-6 col-12 order-1 order-lg-0">
                <div class="content_box">
                    <small>Join Our Doctors Community</small>
                    <h3 class="pe-3">Be a Part of a Network of Medical Excellence</h3>
                    <p class="my-3">Are you a dedicated healthcare professional looking to collaborate with peers and provide exceptional care to patients? Our doctors' community is the perfect place for you. Join today and be a part of a vibrant community committed to advancing the field of medicine and improving patient outcomes.</p>
                    <a class="btn btn-primary">Join Our Community</a>
                </div>
            </div>
            <div class="col-lg-6 col-12 order-0 order-lg-1">
                <div class="image-container">
                    <img src="<?php echo e(asset('frontend/images/nos.png')); ?>" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/frontend/find-doctors-and-clinics.blade.php ENDPATH**/ ?>