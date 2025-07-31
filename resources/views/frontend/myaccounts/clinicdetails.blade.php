<div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
    <div class="text-lg-start text-center image-body-xl">
        <img src="{{$logopath}}" class="user-img" alt="">
    </div>
    <div class="user_details text-xl-start text-center pe-xl-4">
        <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
            <h5 class="fw-bold primary text-wrap mb-0">{{$clinic['name']}}</h5>
        </div>
    </div>
</div>
<div class="gray-border my-4"></div>
<div class="row">
    <div class="col-12 col-lg-6">
        <div class="text-start">
            <label class="sm-label mb-1">Email</label>
            <h6 class="mb-0 fw-bold">{{$clinic['email']}}</h6>
        </div>
    </div>
    <div class="col-12 col-lg-6"> 
        <div class="text-start">
            <label class="sm-label mb-1">Phone Number</label>
            <h6 class="mb-0 fw-bold">{{$clinicCountryCode['country_code']}} {{$phonenumber}}</h6>
        </div>
    </div>
    <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
    <?php $address = $corefunctions->formatAddress($clinic); ?>
    <div class="col-12 col-xl-5"> 
        <div class="text-start mb-1"> 
            
            <label class="sm-label mb-1">Address</label>
            <h6 class="mb-0 fw-bold"><?php echo nl2br($address); ?></h6>

        </div>
        
    </div>

</div>