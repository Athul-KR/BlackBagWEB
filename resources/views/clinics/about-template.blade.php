<div class="" id="pills-about" role="tabpanel" aria-labelledby="pills-about-tab">
    {{-- <div class="row">
        <div class="col-md-8 border-right pe-lg-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-medium">About</h5>
                <a class="btn opt-btn" data-bs-toggle="modal" data-bs-dismiss="modal"
                    data-bs-target="#appointmentNotes"><span class="material-symbols-outlined">edit</span></a>
            </div>

            @if(empty($clinic->about))

                <div class="text-center">
                    <p>No notes added</p>
                </div>
            @else
                <div class="text-justify">
                    <p>{!! nl2br($clinic->about) !!}</p>
                </div>

            @endif


        </div>
        <div class="col-md-4 ps-lg-4">
            <div class="detailsList cardList">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-medium">Open Hours</h5>
                    <a class="btn opt-btn" onclick="createBusinessHours()" data-bs-toggle="modal"
                        data-bs-dismiss="modal" data-bs-target="#editSlotModal"><span
                            class="material-symbols-outlined">edit</span></a>
                </div>

                @foreach ($businessHours as $businessHour)
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-medium">{{$businessHour['day']}}</h6>
                        <p>
                            {{ $businessHour['start_time'] ? $businessHour['start_time'] . '-' . $businessHour['end_time'] : 'Closed' }}
                        </p>
                    </div>
                @endforeach

            </div>


        </div>

    </div> --}}

    <div class="row g-4">
        <div class="col-lg-6 d-flex flex-column gap-4">
           
            <div class="border rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="primary fw-medium mb-0">Standard Appointment Duration</h5>
                    <a class="btn opt-btn align_middle">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                </div>
                <div class="text-start"> 
                    <p class="gray mb-2">How long do you typically need for each consultation?</p>
                    <h6 class="fw-bold mb-0">60 mins</h6>
                </div>
            </div>

            <div class="border rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="primary fw-medium mb-0">Appointment Fee</h5>
                    <a class="btn opt-btn align_middle">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                </div>
                <div class="text-start"> 
                    <p class="gray mb-2">Appointment types that you offer:</p>
                </div>
                <div class="row mb-3"> 
                    <div class="col-6"> 
                        <div class="text-start"> 
                            <p class="gray mb-1">In Person</p>
                            <h5 class="primary fw-bold mb-0">₹80</h5>
                        </div>
                    </div>
                    <div class="col-6"> 
                        <div class="text-start"> 
                            <p class="gray mb-1">Virtual</p>
                            <h5 class="primary fw-bold mb-0">₹100</h5>
                        </div>
                    </div>
                </div>
                <small class="primary fw-middle mb-0"><span class="asterisk">*</span>These are the appointment types that will be available for patients to book.</small>
            </div>
        </div>


        <div class="col-lg-6">
            <div class="border rounded-4 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                    <h5 class="primary fw-medium mb-0">Business Hours</h5>
                    <a class="btn opt-btn align_middle">
                        <span class="material-symbols-outlined">edit</span>
                    </a>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="text-start"> 
                            <p class="gray mb-0">Sunday</p>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="text-start"> 
                            <p class="primary fw-bold mb-0">Closed</p>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="text-start"> 
                            <p class="gray mb-0">Monday</p>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row"> 
                            <div class="col-lg-6"> 
                                <div class="text-start"> 
                                    <p class="primary fw-bold mb-0">9:00 AM - 01:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6"> 
                                <div class="text-end"> 
                                    <p class="fst-italic primary mb-1">4 slots available</p>
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-lg-6"> 
                                <div class="text-start"> 
                                    <p class="primary fw-bold mb-0">2:00 PM - 8:00 PM </p>
                                </div>
                            </div>
                            <div class="col-lg-6"> 
                                <div class="text-end"> 
                                    <p class="fst-italic primary mb-1">6 slots available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="text-start">
                            <p class="gray mb-0">Tuesday</p>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">9:00 AM - 01:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">4 slots available</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">2:00 PM - 8:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">6 slots available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="text-start">
                            <p class="gray mb-0">Wednesday</p>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">9:00 AM - 01:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">4 slots available</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">2:00 PM - 8:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">6 slots available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="text-start">
                            <p class="gray mb-0">Thursday</p>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">9:00 AM - 01:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">4 slots available</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">2:00 PM - 8:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">6 slots available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="text-start">
                            <p class="gray mb-0">Friday</p>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">9:00 AM - 01:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">4 slots available</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">2:00 PM - 8:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">6 slots available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-5">
                        <div class="text-start">
                        <p class="gray mb-0">Saturday</p>
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">9:00 AM - 01:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">4 slots available</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="text-start">
                                    <p class="primary fw-bold mb-0">2:00 PM - 8:00 PM</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="text-end">
                                    <p class="fst-italic primary mb-1">6 slots available</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="gray-border my-4"></div>
                <div class="text-end">
                    <p class="gray mb-1">Total Available Slots</p>
                    <h2 class="font-large fw-bold">40 Slots</h2>
                </div>
            </div>
        </div>
    </div>
</div>