@if(!empty($clinicUsers))
    @foreach($clinicUsers as $clinicUser)
        <div class="col-12 col-xl-6"> 
            <div class="border rounded-4 p-3 @if((!empty($input) && $input['clinicuseruuid'] == $clinicUser['clinic_user_uuid']) || (isset($clinicuseruuid) && $clinicuseruuid != '' && $clinicuseruuid == $clinicUser['clinic_user_uuid'])) selected-doctor @endif">
                <a href="javascript:void(0);" onclick="showTimeSlots('{{$clinicUser['clinic_user_uuid']}}')">
                    <div class="user_inner user_inner_xl">
                        <?php     
                            $corefunctions = new \App\customclasses\Corefunctions;
                            $image = $corefunctions -> resizeImageAWS($clinicUser['user_id'],$clinicUser['user']['profile_image'],$clinicUser['first_name'],180,180,'1');
                        ?>
                        <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                        <div class="user_info">
                            <h5 class="fw-bold m-0 primary">{{ $corefunctions -> showClinicanName($clinicUser,'1'); }}</h5>
                            <p class="m-0">{{$clinicUser['speciality']}}</p>
                        </div>
                    </div>
                    <div class="gray-border my-3"></div>
                    <div class="d-flex flex-xl-row flex-column align-items-center gap-3"> 
                        <div class="text-xl-start text-center image-body">
                            <img src="{{$clinicUser['clinic_logo']}}"  class="user-img" alt="">
                        </div>
                        <div class="user_details text-xl-start text-center pe-xl-4">
                            <div class="innercard-info justify-content-center justify-content-xl-start flex-column align-items-start gap-1">
                                    <h6 class="fw-bold primary text-wrap mb-0">{{$clinicUser['name']}}</h6>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    @endforeach
@else
    <div class="text-center"> 
        <img src="{{asset('frontend/images/nodata.png')}}" class="no-records-img">
        <p class="fwt-bold primary mb-0">No Doctors Yet</p>
    </div>
@endif