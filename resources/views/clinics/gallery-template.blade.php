<div class="" id="pills-gallery" role="tabpanel" aria-labelledby="pills-gallery-tab">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-medium">Gallery</h5>
        <a class="btn opt-btn" href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentDoc"><span class="material-symbols-outlined">add</span></a>
    </div>
    <div class="gallery_wrapper">
        @if($galleryImages->isEmpty())
            <div class="text-center">
                <p>No images found</p>
            </div>
        @else
            <div class="row">
                @foreach ($galleryImages->take(5) as $galleryImage)
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="item">
                            <a href="{{ $galleryImage->image }}" data-toggle="lightbox" data-gallery="example-gallery">
                                <img class="d-block w-100 transition img-responsive" src="{{ $galleryImage->image }}">
                            </a>
                            <a onclick="removeGalleryImage('{{ $galleryImage->gallery_uuid }}', event)">
                                <span class="material-symbols-outlined">delete</span>
                            </a>
                        </div>
                    </div>
                @endforeach

                @if ($galleryImages->count() > 5)
                    <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="item more_imgs" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#galleryModal">
                            <img class="transition img-responsive" src="{{asset('images/default banner.png')}}" alt="More Images">
                            <span>+{{ $galleryImages->count() - 5 }} photos</span>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>


<div class="modal fade" id="galleryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <div class="d-lg-block d-none">
                    <h4 class="text-center fw-medium mt-3">Location</h4>
                    <div class="import_section add_img">
                        <a href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentDoc" class="btn btn-primary d-flex align-items-center"><span class="material-symbols-outlined me-1">add</span>Add Images</a>
                    </div>
                </div>
                <div class="gallery_wrapper">
                    <div class="row modal-gallery">
                        <div class="col-12">
                            <div class="row d-lg-none d-block">
                                <div class="col-12">
                                    <h4 class="text-center fw-medium mt-3">Location</h4>
                                </div>
                                <div class="col-md-4 mx-auto">
                                    <a href="" class="btn btn-primary d-flex align-items-center justify-content-center mb-lg-0 mb-3" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">add</span>Add Images</a>
                                </div>
                            </div>
                        </div>
                        @if(!empty($galleryImagesAfterFive))
                        @foreach($galleryImagesAfterFive as $galleryImageAfterFive)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                            <div class="item">
                                <a href="{{ $galleryImageAfterFive->image }}" data-toggle="lightbox" data-gallery="example-gallery">
                                    <img class="transition img-responsive" src="{{ $galleryImageAfterFive->image }}">
                                </a>
                                <a onclick="removeGalleryImage('{{ $galleryImageAfterFive->gallery_uuid }}', event)">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>