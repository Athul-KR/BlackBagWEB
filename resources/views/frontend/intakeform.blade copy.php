@extends('frontend.master')
@section('content')


<section class="login-container mb-0">
    <div class="container-fluid">
        <div class="row p-xl-5 p-md-4 py-md-0 py-5">
            <div class="col-3 col-lg-4">
                <div class="sideTabWrapper">
                    <div class="image-container mb-5"> 
                        <img src="{{ asset('frontend/images/logo.png')}}" class="logo-main h-auto" alt="Logo">
                    </div>
                    <ul class="nav nav-tabs intake-wrapper-tab" id="customTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active highlighted" id="tab1-tab" data-bs-toggle="tab" data-bs-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">
                                <div class="tab-icon">
                                    <span class="material-symbols-outlined"> monitor_heart</span>
                                </div>
                                <div class="intaketab-text text-start">
                                    <h5 class="primary fwt-bold">Health Metrics</h5>
                                    <small>Share your key health metrics for better personalized care.</small>
                                </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab2-tab" data-bs-toggle="tab" data-bs-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">
                            <div class="tab-icon">
                                <span class="material-symbols-outlined">pill</span>
                            </div>
                            <div class="intaketab-text text-start">
                                <h5 class="primary fwt-bold">Medication Details</h5>
                                <small>Provide details on your medications, vaccines, medical conditions and allergies.</small>
                            </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab3-tab" data-bs-toggle="tab" data-bs-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">
                            <div class="tab-icon">
                                <span class="material-symbols-outlined">clinical_notes</span>
                            </div>
                            <div class="intaketab-text text-start">
                                <h5 class="primary fwt-bold">Medical History</h5>
                                <small>Share information on your families medical history.</small>
                            </div>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation"> 
                            <button class="nav-link"  id="tab4-tab" data-bs-toggle="tab" data-bs-target="#tab4" type="button" role="tab" aria-controls="tab4" aria-selected="false">
                            <div class="tab-icon">
                                <span class="material-symbols-outlined">award_star</span>
                            </div>
                            <div class="intaketab-text text-start">
                                <h5 class="primary fwt-bold">Welcome to BlackBag</h5>
                                <small>Your account is now up and running.</small>
                            </div>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-9 col-lg-8">
                <div class="tab-content h-100" id="customTabsContent">
                    <div class="tab-pane fade show active" id="tab1" role="tabpanel" aria-labelledby="tab1-tab">
                       <div class="row"> 
                            <div class="col-12"> 
                                <div class="btn_alignbox justify-content-end mb-4"> 
                                    <a class="primary d-flex align-items-center gap-1"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-lg-10 col-xxl-8 mx-auto"> 
                                <div class="content-box text-center mb-4"> 
                                    <h3 class="mb-2">Let’s Begin Your Health Journey</h3>
                                    <p class="px-lg-5 mx-lg-5">Your health metrics to help us provide better care tailored to your needs.</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <form action="" class="">
                                    <div class="row h-100 justify-content-between">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-12 mb-4"> 
                                                    <h6 class="fwt-bold">Blood Pressure</h6>
                                            
                                                        <div class="inputBox-divider"> 
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Systolic (mmHg)">
                                                            </div>
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Diastolic (mmHg)">
                                                            </div>
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Pulse (bpm)">
                                                            </div>
                                                        </div>
                                            
                                                </div>
                                                <div class="col-12 mb-4"> 
                                                    <h6 class="fwt-bold">Glucose Levels</h6>
                                                  
                                                        <div class="inputBox-divider">
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Glucose Value (mg/dL)">
                                                            </div>
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="HbA1C (%)">
                                                            </div>
                                                        </div>
                                                   
                                                </div>
                                                <div class="col-12 mb-4"> 
                                                    <h6 class="fwt-bold">Cholesterol Levels</h6>
                                                    
                                                        <div class="inputBox-divider"> 
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Total Cholesterol (mg/dL)">
                                                            </div>
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="HDL (mg/dL)">
                                                            </div>
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="LDL (mg/dL)">
                                                            </div>
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Triglycerides (mg/dL)">
                                                            </div>
                                                        </div>
                                                   
                                                </div>
                                                <div class="col-12 mb-4"> 
                                                    <h6 class="fwt-bold">Physical Measurements</h6>
                                                   
                                                        <div class="inputBox-divider"> 
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="wights" placeholder="Weight (kg or lbs)">
                                                            </div>
                                                            <div class="form-group form-outline">
                                                                <input type="text" class="form-control" id="Heights" placeholder="Height (cm or inches)">
                                                            </div>
                                                        </div>
                                                   
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12"> 
                                            <div class="btn_alignbox justify-content-end mt-5"> 
                                                <a class="btn text-decoration-underline" href="">Skip</a>
                                                <a class="btn btn-primary" href="">Next</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                       </div>
                    </div>
                    <div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab2-tab">
                        <div class="row"> 
                            <div class="col-12"> 
                                <div class="btn_alignbox justify-content-end mb-4"> 
                                    <a class="primary d-flex align-items-center gap-1"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-lg-10 col-xxl-8 mx-auto"> 
                                <div class="content-box text-center mb-4"> 
                                    <h3 class="mb-2">Monitor your medications</h3>
                                    <p class="px-lg-5 mx-lg-5">Information on your medical conditions and medications helps us to ensure accurate and safe treatment.</p>
                                </div>
                            </div>
                            <div class="col-12 mb-4"> 
                                <h6 class="fwt-bold">Medications</h6>
                                <form action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-7"> 
                                                    <p class="mb-2">Are you currently taking any medications?</p>
                                                </div>
                                                <div class="col-md-5"> 
                                                    <div class="checkbox-wrapper"> 
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="medicationYes" data-target="#medicationsHiddenBox" value="yes">
                                                            <label class="form-check-label" for="medicationYes">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="medicationNo" value="no">
                                                            <label class="form-check-label" for="medicationNo">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="medicationsHiddenBox" class="col-12 hidden-checkbox"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <p class="mb-2">Do you take medication for blood pressure?</p>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper"> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                                    <label class="form-check-label" for="inlineCheckbox2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <p class="mb-2">Do you take medication for diabetes medications?</p>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper"> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                                    <label class="form-check-label" for="inlineCheckbox2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <p class="mb-2">Do you take medication for cholesterol medications?</p>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper"> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                                    <label class="form-check-label" for="inlineCheckbox2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 mb-4"> 
                                <h6 class="fwt-bold">Medical Conditions</h6>
                                <form action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-7"> 
                                                    <p class="mb-2">Do you have any known medical conditions?</p>
                                                </div>
                                                <div class="col-md-5"> 
                                                    <div class="checkbox-wrapper"> 
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="conditionsYes" data-target="#conditionsHiddenBox" value="yes">
                                                            <label class="form-check-label" for="conditionsYes">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="conditionsNo" value="no">
                                                            <label class="form-check-label" for="conditionsNo">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="conditionsHiddenBox" class="col-12 hidden-checkbox"> 
                                                    <div class="row"> 
                                                        <div class="col-md-7"> 
                                                            <p class="mb-2">Do you take have any cardiovascular conditions?</p>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper"> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                                    <label class="form-check-label" for="inlineCheckbox2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <p class="mb-2">Do you take have any respiratory conditions?</p>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper"> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                                    <label class="form-check-label" for="inlineCheckbox2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7"> 
                                                            <p class="mb-2">Do you take have any neurological conditions?</p>
                                                        </div>
                                                        <div class="col-md-5"> 
                                                            <div class="checkbox-wrapper"> 
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                                    <label class="form-check-label" for="inlineCheckbox2">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 mb-4"> 
                                <h6 class="fwt-bold">Immunizations</h6>
                                <form action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-7"> 
                                                    <p class="mb-2">Are your immunizations up to date?</p>
                                                </div>
                                                <div class="col-md-5"> 
                                                    <div class="checkbox-wrapper"> 
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                            <label class="form-check-label" for="inlineCheckbox1">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                            <label class="form-check-label" for="inlineCheckbox2">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12"> 
                                                    <div class="vaccine-append"> 
                                                        <div class="row">
                                                            <div class="col-12"> 
                                                                <div class="form-group form-outline">
                                                                    <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Pending Vaccine Name">
                                                                </div>
                                                            </div>
                                                            <div class="col-12"> 
                                                                <div class="d-flex align-items-center gap-3 mt-3">
                                                                    <div class="form-group form-outline flex-grow-1">
                                                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Pending Vaccine Name">
                                                                    </div>
                                                                    <a href="" class="danger"><span class="material-symbols-outlined fwt-medium">delete</span></a>
                                                                </div>
                                                            </div>
                                                            <div class="btn_alignbox justify-content-end mt-3"> 
                                                                <a class="primary d-flex align-items-center gap-2"><span class="material-symbols-outlined">add</span>Add vaccine</a>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 mb-4"> 
                                <h6 class="fwt-bold">Allergies</h6>
                                <form action="">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <p class="mb-2">Do you have any allergies?</p>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="checkbox-wrapper">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="allergiesYes" data-target="#allergiesHiddenBox" value="yes">
                                                            <label class="form-check-label" for="allergiesYes">Yes</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="allergiesNo" value="no">
                                                            <label class="form-check-label" for="allergiesNo">No</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="allergiesHiddenBox" class="col-12 hidden-checkbox" style="display: none;">
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <p class="mb-2">Do you have any food allergies?</p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="checkbox-wrapper">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="foodAllergiesYes" value="yes">
                                                                    <label class="form-check-label" for="foodAllergiesYes">Yes</label>
                                                                </div>
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="foodAllergiesNo" value="no">
                                                                    <label class="form-check-label" for="foodAllergiesNo">No</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <p class="mb-2">Do you have any drug allergies?</p>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="col-12"> 
                                <div class="btn_alignbox justify-content-end mt-5"> 
                                    <a class="btn text-decoration-underline" href="">Skip</a>
                                    <a class="btn btn-outline-primary" href="">Previous</a>
                                    <a class="btn btn-primary" href="">Next</a>
                                </div>
                            </div>
                       </div>
                    </div>
                    <div class="tab-pane fade"  id="tab3" role="tabpanel" aria-labelledby="tab3-tab">
                        <div class="row"> 
                            <div class="col-12"> 
                                <div class="btn_alignbox justify-content-end mb-4"> 
                                    <a class="primary d-flex align-items-center gap-1"><span class="material-symbols-outlined">arrow_left_alt</span>Back to Website</a>
                                </div>
                            </div>
                            <div class="col-lg-10 col-xxl-8 mx-auto"> 
                                <div class="content-box text-center mb-4"> 
                                    <h3 class="mb-2">Record Medical History</h3>
                                    <p class="px-lg-5 mx-lg-5">Your family’s health history help us better understand your health and provide the best care possible.</p>
                                </div>
                            </div>
                            <div class="col-12"> 
                                <div class="row">
                                    <div class="col-12">
                                        <h6 class="fwt-bold">Medical Conditions</h6>
                                        <div class="row"> 
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <div class="col-md-4"> 
                                                        <div class="form-group form-outline">
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Relation">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8"> 
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="form-group form-outline flex-grow-1 my-md-0 my-3">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Condition(s)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <div class="col-md-4"> 
                                                        <div class="form-group form-outline">
                                                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Relation">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8"> 
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="form-group form-outline flex-grow-1 my-md-0 my-3">
                                                                <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Condition(s)">
                                                            </div>
                                                            <a href="" class="danger"><span class="material-symbols-outlined fwt-medium">delete</span></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12"> 
                                                <div class="btn_alignbox justify-content-end "> 
                                                    <a class="primary d-flex align-items-center gap-2"><span class="material-symbols-outlined">add</span>Add Relation</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12"> 
                                        <div class="btn_alignbox justify-content-end mt-5"> 
                                            <a class="btn text-decoration-underline" href="">Skip</a>
                                            <a class="btn btn-outline-primary" href="">Previous</a>
                                            <a class="btn btn-primary" href="">Next</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade h-100"  id="tab4" role="tabpanel" aria-labelledby="tab4-tab">
                        <div class="row h-100 align-items-center"> 
                            <div class="col-lg-10 col-xxl-8 mx-auto"> 
                                <div class="content-box text-center mb-4"> 
                                    <img src="{{ asset("frontend/images/sucess.png") }}" alt="success" class="success-img mb-4">
                                    <h3 class="mb-2">Welcome to BlackBag</h3>
                                    <p class="px-lg-5 mx-lg-5">Your account has been successfully created.</p>
                                    <div class="btn_alignbox"> 
                                        <a class="btn btn-primary">Continue</a>
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




<script>


    const tabs = document.querySelectorAll('.nav-link');

    tabs.forEach((tab, index) => {
      tab.addEventListener('click', () => {
        tabs.forEach((t, i) => {
          if (i <= index) {
            t.classList.add('highlighted');
          } else {
            t.classList.remove('highlighted');
          }
        });
      });
    });



    document.querySelectorAll('.form-check-input[data-target]').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      const target = document.querySelector(this.dataset.target);
      if (this.checked) {
        target.style.display = 'block';
      } else {
        target.style.display = 'none';
      }
    });
  });

</script>


@endsection()