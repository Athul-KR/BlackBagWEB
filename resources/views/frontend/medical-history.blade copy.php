@extends('frontend.master')
@section('title', 'Medical History')
@section('content')

<section class="details_wrapper">
    {{-- <div class="container">
        <div class="row">
            <div class="col=12 mb-3">
                <div class="web-card h-100 mb-3">

                    <h4>Medical History</h4>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fwt-medium">Note</h5>
                                <div class="btn_alignbox">
                                    <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal"
                                        data-bs-target="#appointmentNotes">Edit Note</a>
                                </div>
                            </div>
                        </div>
                        @if (empty($patient->notes))
                            <div class="nofiles_body text-center w-100">
                                <img src="{{ asset('frontend/images/no_files.png')}}" class="">
                                <p>No Notes Added</p>
                            </div>
                        @endif
                        <div class="col-12">
                            <p>{!! nl2br($patient->notes ?? "") !!}</p>
                        </div>
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <h5 class="fwt-medium">Files</h5>
                                <div class="btn_alignbox justify-content-end">
                                    <a class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-dismiss="modal"
                                        data-bs-target="#appointmentDoc">
                                        Add Files
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="files-container mt-3">
                                @if (empty($patientDocument))
                                    <div class="nofiles_body text-center w-100">
                                        <img src="{{ asset('frontend/images/no_files.png')}}" class="">
                                        <p>No Files Added</p>
                                    </div>
                                @endif
                                @foreach ($patientDocument as $patientDoc)
                                                                @php
                                                                    // Determine the image path based on the file extension
                                                                    $imagePath = '';
                                                                    if ($patientDoc['doc_ext'] == 'png') {
                                                                        $imagePath = asset('images/png_icon.png');
                                                                    } elseif ($patientDoc['doc_ext'] == 'jpg') {
                                                                        $imagePath = asset('images/jpg_icon.png');
                                                                    } elseif ($patientDoc['doc_ext'] == 'pdf') {
                                                                        $imagePath = asset('images/pdf_img.png');
                                                                    } elseif ($patientDoc['doc_ext'] == 'xlsx') {
                                                                        $imagePath = asset('images/excel_icon.png');
                                                                    } else {
                                                                        $imagePath = asset('images/doc_image.png');
                                                                    }
                                                                @endphp

                                                                <div id="img_div" class="fileBody">
                                                                    <div class="file_info" id="appenddocs">
                                                                        <img id="editpatientimage" src="{{ $imagePath }}">
                                                                        <span>{{ $patientDoc['orginal_name'] }}</span>
                                                                    </div>
                                                                    <a onclick="removeDoc('{{$patientDoc['patient_doc_uuid']}}')"><span
                                                                            class="material-symbols-outlined">close</span></a>
                                                                </div>

                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}



    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="web-card h-100 mb-3">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="text-start">
                                <h4 class="fwt-bold mb-4">Medical History</h4>
                            </div>
                            <div class="nav flex-column nav-pills settings-tab history-tab gap-2 me-xl-3 border-bottom-0" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="tab-blood-pressure" data-bs-toggle="pill" data-bs-target="#content-blood-pressure" type="button" role="tab" aria-controls="content-blood-pressure" aria-selected="true">
                                    <span class="material-symbols-outlined">blood_pressure</span>Blood Pressure
                                </button>
                                <button class="nav-link" id="tab-glucose-levels" data-bs-toggle="pill" data-bs-target="#content-glucose-levels" type="button" role="tab" aria-controls="content-glucose-levels" aria-selected="false">
                                    <span class="material-symbols-outlined">glucose</span>Glucose Levels
                                </button>
                                <button class="nav-link" id="tab-cholesterol-levels" data-bs-toggle="pill" data-bs-target="#content-cholesterol-levels" type="button" role="tab" aria-controls="content-cholesterol-levels" aria-selected="false">
                                    <span class="material-symbols-outlined">cardiology</span>Cholesterol Levels
                                </button>
                                <button class="nav-link" id="tab-physical-measurements" data-bs-toggle="pill" data-bs-target="#content-physical-measurements" type="button" role="tab" aria-controls="content-physical-measurements" aria-selected="false">
                                    <span class="material-symbols-outlined">body_fat</span>Physical Measurements
                                </button>
                                <button class="nav-link" id="tab-medications" data-bs-toggle="pill" data-bs-target="#content-medications" type="button" role="tab" aria-controls="content-medications" aria-selected="false">
                                    <span class="material-symbols-outlined">pill</span>Medications
                                </button>
                                <button class="nav-link" id="tab-medical-conditions" data-bs-toggle="pill" data-bs-target="#content-medical-conditions" type="button" role="tab" aria-controls="content-medical-conditions" aria-selected="false">
                                    <span class="material-symbols-outlined">respiratory_rate</span>Medical Conditions
                                </button>
                                <button class="nav-link" id="tab-allergies" data-bs-toggle="pill" data-bs-target="#content-allergies" type="button" role="tab" aria-controls="content-allergies" aria-selected="false">
                                    <span class="material-symbols-outlined">allergy</span>Allergies
                                </button>
                                <button class="nav-link" id="tab-immunizations" data-bs-toggle="pill" data-bs-target="#content-immunizations" type="button" role="tab" aria-controls="content-immunizations" aria-selected="false">
                                    <span class="material-symbols-outlined">syringe</span>Immunizations
                                </button>
                                <button class="nav-link" id="tab-family-history" data-bs-toggle="pill" data-bs-target="#content-family-history" type="button" role="tab" aria-controls="content-family-history" aria-selected="false">
                                    <span class="material-symbols-outlined">family_home</span>Family Medical History
                                </button>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="content-blood-pressure" role="tabpanel" aria-labelledby="tab-blood-pressure">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Blood Pressure</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-sm-10 col-9"> 
                                                            <div class="row"> 
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Systolic (mmHg)</h6>
                                                                        <p>130</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Diastolic (mmHg)</h6>
                                                                        <p>85</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Pulse (bpm)</h6>
                                                                        <p>72</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-3"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                                                                    <span class="material-symbols-outlined">more_vert</span>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                    <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row align-items-center"> 
                                                        <div class="col-md-10"> 
                                                            <div class="row"> 
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Total Cholesterol (mg/dL)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="HDL (mg/dL)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="LDL (mg/dL)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Triglycerides (mg/dL)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">check</span>
                                                                </a>
                                                                <a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">delete</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content-glucose-levels" role="tabpanel" aria-labelledby="tab-glucose-levels">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Glucose Levels</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-sm-10 col-9"> 
                                                            <div class="row"> 
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Glucose Value (mg/dL)</h6>
                                                                        <p>110</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <h6>HbA1C (%)</h6>
                                                                        <p>5.8</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-3"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined">more_vert</span>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                    <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row align-items-center"> 
                                                        <div class="col-md-10"> 
                                                            <div class="row"> 
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Systolic(mmHg)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Diastolic(mmHg)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">check</span>
                                                                </a>
                                                                <a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">delete</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content-cholesterol-levels" role="tabpanel" aria-labelledby="tab-cholesterol-levels">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Cholesterol Levels</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-sm-10 col-9"> 
                                                            <div class="row"> 
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Total Cholesterol (mg/dL)</h6>
                                                                        <p>190</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <h6>HDL (mg/dL)</h6>
                                                                        <p>50</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <h6>LDL (mg/dL)</h6>
                                                                        <p>120</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Triglycerides (mg/dL)</h6>
                                                                        <p>140</p>
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-3"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                                                                    <span class="material-symbols-outlined">more_vert</span>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                    <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row align-items-center"> 
                                                        <div class="col-md-10"> 
                                                            <div class="row"> 
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Systolic(mmHg)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Diastolic(mmHg)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Pulse(bpm)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">check</span>
                                                                </a>
                                                                <a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">delete</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content-physical-measurements" role="tabpanel" aria-labelledby="tab-physical-measurements">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Physical Measurements</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-sm-10 col-9"> 
                                                            <div class="row"> 
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Weight(kg)</h6>
                                                                        <p>67kg</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Height(cm)</h6>
                                                                        <p>168cm</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2 col-3"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                                                                    <span class="material-symbols-outlined">more_vert</span>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                    <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row align-items-center"> 
                                                        <div class="col-md-10"> 
                                                            <div class="row"> 
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Weight(kg)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Height(cm)">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">check</span>
                                                                </a>
                                                                <a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">delete</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content-medications" role="tabpanel" aria-labelledby="tab-medications">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Medications</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Are you currently taking any medications?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="yesCheckbox" value="yes">
                                                                    <label class="form-check-label" for="yesCheckbox">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="noCheckbox" value="no">
                                                                    <label class="form-check-label" for="noCheckbox">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take medication for blood pressure?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="yes">
                                                                    <label class="form-check-label" for="">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="no">
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take medication for diabetes medications?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take medication for cholesterol medications?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content-medical-conditions" role="tabpanel" aria-labelledby="tab-medical-conditions">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Medical Conditions</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you have any known medical conditions?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="yesCheckbox" value="yes">
                                                                    <label class="form-check-label" for="yesCheckbox">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="noCheckbox" value="no">
                                                                    <label class="form-check-label" for="noCheckbox">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take have any cardiovascular conditions?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="yes">
                                                                    <label class="form-check-label" for="">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="no">
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take have any respiratory conditions?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take have any neurological conditions?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content-allergies" role="tabpanel" aria-labelledby="tab-allergies">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Medical Conditions</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you have any known medical conditions?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="yesCheckbox" value="yes">
                                                                    <label class="form-check-label" for="yesCheckbox">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="noCheckbox" value="no">
                                                                    <label class="form-check-label" for="noCheckbox">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take have any cardiovascular conditions?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="yes">
                                                                    <label class="form-check-label" for="">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="" value="no">
                                                                    <label class="form-check-label" for="">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row align-items-baseline"> 
                                                        <div class="col-md-7"> 
                                                            <div class="history-box"> 
                                                                <h6 class="mb-3">Do you take have any respiratory conditions?</h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="row"> 
                                                                <div class="col-12">
                                                                    <div class="d-flex justify-content-between align-items-center border-top pt-3"> 
                                                                        <div class="history-box"> 
                                                                            <h6>Do you have any known medical conditions?</h6>
                                                                        </div>
                                                                        <div class="btn_alignbox justify-content-end">
                                                                            <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                                                                                <span class="material-symbols-outlined">more_vert</span>
                                                                            </a>
                                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                                <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                                <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12"> 
                                                                    <div class="row align-items-center mt-3"> 
                                                                        <div class="col-md-10"> 
                                                                            <div class="row"> 
                                                                                <div class="col-md-12"> 
                                                                             
                                                                                    <div class="form-group form-outline">
                                                                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Drug Name">
                                                                                    </div>
                                                                                    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-2"> 
                                                                            <div class="btn_alignbox justify-content-end mt-md-0 mt-3">
                                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <span class="material-symbols-outlined success">check</span>
                                                                                </a>
                                                                                <a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                    <span class="material-symbols-outlined success">delete</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12"> 
                                                                    <div class="btn_alignbox justify-content-end my-3"> 
                                                                        <a href="" class="primary align_middle"><span class="material-symbols-outlined">add</span>Add Drug</a>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12"> 
                                                                    <div class="history-info"> 
                                                                        <h6 class="mb-0">John Doe</h6>
                                                                        <span class="update-info"></span>
                                                                        <small>Last updated: 12 Nov,2024</small>
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
                                <div class="tab-pane fade" id="content-immunizations" role="tabpanel" aria-labelledby="tab-immunizations">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Immunizations</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12"> 
                                            <div class="inner-history"> 
                                                <div class="row align-items-baseline"> 
                                                    <div class="col-md-7"> 
                                                        <div class="history-box"> 
                                                            <h6 class="mb-3">Are your immunizations up to date?</h6>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5"> 
                                                        <div class="checkbox-wrapper">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" id="drugAllergiesYes" value="yes">
                                                                <label class="form-check-label" for="drugAllergiesYes">Yes</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" id="drugAllergiesNo" value="no">
                                                                <label class="form-check-label" for="drugAllergiesNo">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12"> 
                                                        <div class="row"> 
                                                            <div class="col-12">
                                                                <div class="d-flex justify-content-between align-items-center border-top pt-3"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Pending Vaccine Name</h6>
                                                                        <small>Pfizer–BioNTech</small>
                                                                    </div>
                                                                    <div class="btn_alignbox justify-content-end">
                                                                        <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                                                                            <span class="material-symbols-outlined">more_vert</span>
                                                                        </a>
                                                                        <ul class="dropdown-menu dropdown-menu-end">
                                                                            <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                            <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12"> 
                                                                <div class="row align-items-center mt-3"> 
                                                                    <div class="col-md-10"> 
                                                                        <div class="row"> 
                                                                            <div class="col-md-12"> 
                                                                         
                                                                                <div class="form-group form-outline">
                                                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Vaccine Name">
                                                                                </div>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-2"> 
                                                                        <div class="btn_alignbox justify-content-end mt-md-0 mt-3">
                                                                            <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <span class="material-symbols-outlined success">check</span>
                                                                            </a>
                                                                            <a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                                <span class="material-symbols-outlined success">delete</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12"> 
                                                                <div class="btn_alignbox justify-content-end my-3"> 
                                                                    <a href="" class="primary align_middle"><span class="material-symbols-outlined">add</span>Add Vaccine Name</a>
                                                                </div>
                                                            </div>
                                                            <div class="col-12"> 
                                                                <div class="history-info"> 
                                                                    <h6 class="mb-0">John Doe</h6>
                                                                    <span class="update-info"></span>
                                                                    <small>Last updated: 12 Nov,2024</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>        
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="content-family-history" role="tabpanel" aria-labelledby="tab-family-history">
                                    <div class="d-flex justify-content-between align-items-center mt-5 mb-4">
                                        <h5 class="fwt-bold">Family Medical History</h5>
                                        <div class="btn_alignbox"> 
                                            <a href="" class="btn btn-primary align_middle"><span class="material-symbols-outlined">add</span>Add</a>
                                        </div>
                                    </div>
                                    <div class="history-wrapperBody">
                                        <div class="row">
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row"> 
                                                        <div class="col-9"> 
                                                            <div class="row"> 
                                                                <div class="col-md-6"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Relation</h6>
                                                                        <p>Father</p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6"> 
                                                                    <div class="history-box"> 
                                                                        <h6>Condition(s)</h6>
                                                                        <p>High Cholesterol</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-3"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                                                                    <span class="material-symbols-outlined">more_vert</span>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit</a></li>
                                                                    <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2 danger"></i>Delete</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-12"> 
                                                            <div class="history-info"> 
                                                                <h6 class="mb-0">John Doe</h6>
                                                                <span class="update-info"></span>
                                                                <small>Last updated: 12 Nov,2024</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>        
                                            </div>
                                            <div class="col-12"> 
                                                <div class="inner-history"> 
                                                    <div class="row align-items-center"> 
                                                        <div class="col-md-10"> 
                                                            <div class="row"> 
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Systolic(mmHg)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4"> 
                                                                    <div class="history-box"> 
                                                                        <div class="form-group form-outline">
                                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Diastolic(mmHg)">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2"> 
                                                            <div class="btn_alignbox justify-content-end">
                                                                <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">check</span>
                                                                </a>
                                                                <a class="opt-btn danger-icon" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <span class="material-symbols-outlined success">delete</span>
                                                                </a>
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
                </div>
            </div> 
        </div>
    </div>

</section>

<div class="modal login-modal fade" id="confirm-data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <h4 class="text-center fw-medium mb-0 ">Are You Sure you want to change this data?</h4>
                <div class="btn_alignbox"> 
                    <a class="btn btn-outline-primary">Cancel</a>
                    <a class="btn btn-outline-primary">Change Data</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dropzone -->
<div class="modal fade" id="appointmentDoc" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <h4 class="modal-title" id="appointmentNotesLabel">Upload Documents</h4>
                <form method="post" id="doc_form" autocomplete="off">
                    <div class="dropzone-wrapper mt-3 dropzone custom-dropzone" id="patientDocs">

                    </div>
                    <div id="img_div">
                        <div class="files-container mb-3" id="appenddocsmodal">

                        </div>
                    </div>

                    <div class="btn_alignbox justify-content-end mt-4">

                        <button type="button" id="close_doc_modal" onclick="closeDocsModal()"
                            class="btn btn-primary">Close</button>
                        <button type="button" id="save_doc_btn" onclick="saveDocs()"
                            class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<!-- Notes Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="modal-title mb-3" id="appointmentNotesLabel">Appointment Notes</h4>
                </div>
                <form method="post" action="{{route('frontend.noteUpdate')}}" id="appoinmentnote" autocomplete="off">
                    @csrf

                    <textarea name="notes" id="notes"
                        class="form-control  tinymce-editor tinymce_notes">{{$patient->notes}}</textarea>
                    <input type="hidden" id="has_notes" name="has_notes" value="@if($patient->notes!=NULL) 1 @endif">

                    <div class="btn_alignbox justify-content-end mt-4">
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
label.error {
    color: var(--danger);
    font-size: 0.75rem !important;
    bottom: -22px !important;
    top: auto;
    left: 0;
    font-weight: 500;
}
</style>

<script>
    $(document).ready(function () {
        initiateEditorwithSomeMainPlugin('notes');
        
        $('#appoinmentnote').validate({
            ignore:[],
            rules: {
                has_notes: "required",
            },
            messages: {
                has_notes: "Please enter note",
            },
            submitHandler: function (form) {
                // Disable the submit button to prevent multiple clicks
                var submitButton = $("#update_btn");
                submitButton.prop("disabled", true);
                submitButton.text("Submitting..."); //change button text
                $('#edit_profile_form').submit(); // Use native form submission
                // Submit the form
                if (form.valid()) {
                    // alert("hh");
                    form.submit(); // Use native form submission
                }
            },
            errorPlacement: function (error, element) {
                if (element.attr("name") == "phone") {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            }


        });

    });

    Dropzone.autoDiscover = false;
    // Dropzone Configurations
    var dropzone = new Dropzone('#patientDocs', {
        url: '{{ url('/patients/uploaddocument') }}',
        addRemoveLinks: true,
        dictDefaultMessage: '<span class="material-symbols-outlined icon-add">add</span> Add patient files', // Add class for styling
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        init: function () {
            this.on("sending", function (file, xhr, formData) {
                // Extra data to be sent with the file
                formData.append("formdata", $('#createinquiry').serialize());
            });
            this.on("removedfile", function (file) {
                $(".remv_" + file.filecnt).remove();
            });
            var filecount = 1;
            this.on('success', function (file, response) {
                if (response.success == 1) {

                    this.removeFile(file);
                    file.filecnt = filecount;
                    if (response.ext == 'png') {
                        var imagePath = "{{ asset('images/png_icon.png') }}";
                    } else if (response.ext == 'jpg') {
                        var imagePath = "{{ asset('images/jpg_icon.png') }}";
                    } else if (response.ext == 'pdf') {
                        var imagePath = "{{ asset('images/pdf_img.png') }}";
                    } else if (response.ext == 'xlsx') {
                        var imagePath = "{{ asset('images/excel_icon.png') }}";
                    } else {
                        var imagePath = "{{ asset('images/doc_image.png') }}";
                    }
                    console.log(response.ext)
                    var appnd = '<div class="fileBody" id="doc_' + filecount + '"><div class="file_info"><img src="' + imagePath + '"><span>' + response.docname + '</span>' +
                        '</div><a onclick="removeImageDoc(' + filecount + ')"><span class="material-symbols-outlined">close</span></a></div>' +
                        '<input type="hidden" name="patient_docs[' + filecount + '][tempdocid]" value="' + response.tempdocid + '" >';

                    $("#appenddocsmodal").append(appnd);
                    filecount++
                    // $("#docuplad").val('1');
                    // $("#docuplad").valid();
                } else {
                    if (typeof response.error !== 'undefined' && response.error !== null && response.error == 1) {
                        swal(response.errormsg);
                        this.removeFile(file);
                    }
                }
            });
        },
    });

    function removeImageDoc(count) {
        $("#doc_" + count).remove();
    }


    function saveDocs() {

        var url = "{{route('frontend.storeDocs')}}";
        var docLength = $('#doc_form').find('.fileBody').length;

        // if (docLength > 0) {

        $.ajax({
            url: url,
            type: "post",
            data: {
                'formdata': $("#doc_form").serialize(),
                '_token': $('input[name=_token]').val()
            },
            success: function (data) {
                if (data.success == 1) {


                    swal(
                    "Success!",
                    data.message,
                    "success",
                );
                 setTimeout(function(){ window.location.reload(); }, 2000);
                } else {

                }
            }
        });
        // } else {
        //     $('#save_doc_btn').prop('disabled', true);
        // }
    }

    function closeDocsModal() {
        $("#appointmentDoc").modal('hide');
        // Reset the form fields
        $("#doc_form")[0].reset();

        // Clear the Dropzone
        var dropzone = Dropzone.forElement("#patientDocs");
        if (dropzone) {
            dropzone.removeAllFiles(true);
        }

        // Clear the image preview container
        $("#appenddocsmodal").empty();

    }

    function removeDoc(uuid) {

        var url = "{{route('frontend.removeDocs')}}";

        swal("Are you sure you want to remove this document?", {
            title: "Remove!",
            icon: "warning",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: url,
                    type: "post",
                    data: {
                        'uuid': uuid,
                        '_token': $('input[name=_token]').val()
                    },
                    success: function (data) {
                        if (data.success == 1) {
                            setTimeout(function(){ window.location.reload(); }, 2000);
                        } else {

                        }
                    }
                });
            }
        });

    }


    function removeDocs(key) {

        swal({
            title: "Are you sure you want to remove this document?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "OK",
            cancelButtonText: "Cancel",
            showLoaderOnConfirm: false,
            preConfirm: () => {
                $("#doc_" + key).remove();
                $("#patient_doc_exists" + key).val('');

            }
        });


    }



    function initiateEditorwithSomeMainPlugin(editorID) {
        //tinymce.remove('.tinymce_' + editorID);
        tinymce.init({
            selector: '.tinymce_' + editorID,
            height: 250,
            menubar: false,
            plugins: 'image code',
            paste_as_text: true,
            entity_encoding: "raw",
            relative_urls: false,
            remove_script_host: false,
            // verify_html:false,

            images_upload_handler: function (blobInfo, success, failure) {
                // var input = document.createElement('input');
                // input.setAttribute('type', 'file');
                // input.setAttribute('accept', 'image/*');
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ URL::to("/editorupload")}}');
                var token = '{{ csrf_token() }}';
                xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.onload = function () {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
                //alert(formData);
            },
            plugins: [

                'advlist', 'autolink', 'lists',

                'anchor', 'searchreplace', 'visualblocks', 'fullscreen',
                'insertdatetime', 'media', 'table', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic | alignleft aligncenter ' +

                'alignright alignjustify ',

            setup: function (ed) {
                ed.on('init', function (args) {
                    $('#pretxt_' + editorID).hide();
                    $('.editordiv_' + editorID).show();
                });
                ed.on('change', function (e) {
                    calculateEditorCount(editorID);

                    $("#" + editorID).val(ed.getContent());
                });
                ed.on('keyup', function (e) {
                    calculateEditorCount(editorID);

                    $("#" + editorID).val(ed.getContent());
                    console.log(ed.getContent());
                });
            }
        });
    }
    function calculateEditorCount(editorid) {

        var editorwordcount = getStats(editorid).words;

        editorwordcount = editorwordcount - 1;
        //alert(editorwordcount);
        $("#has_" + editorid).val('');

        if (editorwordcount > 0) {

            $("#has_" + editorid).val(1);
            $("#has_" + editorid).valid();
        }

        //$("#hascontent").valid();
    }

    function getStats(id) {

        var body = tinymce.get(id).getBody(),
            text = tinymce.trim(body.innerText || body.textContent);

        return {
            chars: text.length,
            words: text.split(/[\w\u2019\'-]+/).length
        };
    }

    $(document).ready(function () {
    $('#yesCheckbox').on('click', function () {
        console.log('Checkbox clicked');
        if ($(this).is(':checked')) {
            console.log('Checkbox is checked');
            $('#confirm-data').modal('show');
        }
    });
});


</script>


@endsection()