<div class="tab-pane fade show active" id="medicationtab" role="tabpanel" aria-labelledby="medication-tab">
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
        <form method="POST" id="medicationform" autocomplete="off">
            @csrf
            <div class="col-12 mb-4">
                <h6 class="fwt-bold">Medications</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-7">

                                <p class="mb-2">Are you currently taking any medications?</p>
                            </div>
                            <div class="col-md-5">
                                <div class="checkbox-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_medication" id="has_medication_yes" value="yes" onclick="showMedicationQuestion('yes')" @if(!empty($intakeData) && isset($intakeData['has_medication']) && $intakeData['has_medication']=='yes' ) checked @endif>
                                        <label class="form-check-label" for="has_medication_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_medication" id="has_medication_no" value="no" onclick="showMedicationQuestion('no')" @if(!empty($intakeData) && isset($intakeData['has_medication']) && $intakeData['has_medication']=='no' ) checked @endif>
                                        <label class="form-check-label" for="has_medication_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div id="medicationsHiddenBox" class="col-12 hidden-checkbox" @if(!empty($intakeData) && isset($intakeData['has_medication']) && $intakeData['has_medication']=='yes' ) style="display:block;" @else style="display:none;" @endif>
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you take medication for blood pressure?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="bp_medication" id="bp_medication_yes" value="yes" onclick="toggleCheckbox('bp_medication_yes', 'bp_medication_no')" @if(!empty($intakeData) && isset($intakeData['bp_medication']) && $intakeData['bp_medication']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="bp_medication_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="bp_medication" id="bp_medication_no" value="no" onclick="toggleCheckbox('bp_medication_no', 'bp_medication_yes')" @if(!empty($intakeData) && isset($intakeData['bp_medication']) && $intakeData['bp_medication']=='no' ) checked @endif>
                                                <label class="form-check-label" for="bp_medication_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you take medication for diabetes medications?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="diabetes_medication" id="diabetes_medication_yes" value="yes" onclick="toggleCheckbox('diabetes_medication_yes', 'diabetes_medication_no')" @if(!empty($intakeData) && isset($intakeData['diabetes_medication']) && $intakeData['diabetes_medication']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="diabetes_medication_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="diabetes_medication" id="diabetes_medication_no" value="no" onclick="toggleCheckbox('diabetes_medication_no', 'diabetes_medication_yes')" @if(!empty($intakeData) && isset($intakeData['diabetes_medication']) && $intakeData['diabetes_medication']=='no' ) checked @endif>
                                                <label class="form-check-label" for="diabetes_medication_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you take medication for cholesterol medications?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="cholesterol_medication" id="cholesterol_medication_yes" value="yes" onclick="toggleCheckbox('cholesterol_medication_yes', 'cholesterol_medication_no')" @if(!empty($intakeData) && isset($intakeData['cholesterol_medication']) && $intakeData['cholesterol_medication']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="cholesterol_medication_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="cholesterol_medication" id="cholesterol_medication_no" value="no" onclick="toggleCheckbox('cholesterol_medication_no', 'cholesterol_medication_yes')" @if(!empty($intakeData) && isset($intakeData['cholesterol_medication']) && $intakeData['cholesterol_medication']=='no' ) checked @endif>
                                                <label class="form-check-label" for="cholesterol_medication_no">No</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <p class="mb-2">Are you taking any medication for another reason?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="other_medications" id="other_medications_yes" value="yes" onclick="toggleCheckbox('other_medications_yes', 'other_medications_no')" @if(!empty($intakeData) && isset($intakeData['other_medications']) && $intakeData['other_medications']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="other_medications_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="other_medications" id="other_medications_no" value="no" onclick="toggleCheckbox('other_medications_no', 'other_medications_yes')" @if(!empty($intakeData) && isset($intakeData['other_medications']) && $intakeData['other_medications']=='no' ) checked @endif>
                                                <label class="form-check-label" for="other_medications_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" style="{{ !empty($intakeData) && isset($intakeData['other_medications']) && $intakeData['other_medications'] == 'yes' ? '' : 'display: none;' }}" id="medication_reason_section">
                                        <input type="text" class="form-control" id="other_medication" value="{{ $intakeData['other_medication_data']??'' }}" name="other_medication_data" placeholder="Enter other medication">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <h6 class="fwt-bold">Medical Conditions</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-7">
                                <p class="mb-2">Do you have any known medical conditions?</p>
                            </div>
                            <div class="col-md-5">
                                <div class="checkbox-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_condition" id="has_condition_yes" value="yes" onclick="showConditionQuestion('yes')" @if(!empty($intakeData) && isset($intakeData['has_condition']) && $intakeData['has_condition']=='yes' ) checked @endif>
                                        <label class="form-check-label" for="has_condition_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_condition" id="has_condition_no" value="no" onclick="showConditionQuestion('no')" @if(!empty($intakeData) && isset($intakeData['has_condition']) && $intakeData['has_condition']=='no' ) checked @endif>
                                        <label class="form-check-label" for="has_condition_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div id="conditionsHiddenBox" class="col-12 hidden-checkbox" @if(!empty($intakeData) && isset($intakeData['has_condition']) && $intakeData['has_condition']=='yes' ) style="display:block;" @else style="display:none;" @endif>
                                <div class="row">
                                    <!-- Cardiovascular Conditions -->
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you have any cardiovascular conditions?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="cardiovascular_condition" id="cardiovascular_condition_yes" value="yes" onclick="toggleCheckbox('cardiovascular_condition_yes', 'cardiovascular_condition_no')" @if(!empty($intakeData) && isset($intakeData['cardiovascular_condition']) && $intakeData['cardiovascular_condition']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="cardiovascular_condition_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="cardiovascular_condition" id="cardiovascular_condition_no" value="no" onclick="toggleCheckbox('cardiovascular_condition_no', 'cardiovascular_condition_yes')" @if(!empty($intakeData) && isset($intakeData['cardiovascular_condition']) && $intakeData['cardiovascular_condition']=='no' ) checked @endif>
                                                <label class="form-check-label" for="cardiovascular_condition_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Respiratory Conditions -->
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you have any respiratory conditions?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="respiratory_condition" id="respiratory_condition_yes" value="yes" onclick="toggleCheckbox('respiratory_condition_yes', 'respiratory_condition_no')" @if(!empty($intakeData) && isset($intakeData['respiratory_condition']) && $intakeData['respiratory_condition']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="respiratory_condition_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="respiratory_condition" id="respiratory_condition_no" value="no" onclick="toggleCheckbox('respiratory_condition_no', 'respiratory_condition_yes')" @if(!empty($intakeData) && isset($intakeData['respiratory_condition']) && $intakeData['respiratory_condition']=='no' ) checked @endif>
                                                <label class="form-check-label" for="respiratory_condition_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Neurological Conditions -->
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you have any neurological conditions?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="neurological_condition" id="neurological_condition_yes" value="yes" onclick="toggleCheckbox('neurological_condition_yes', 'neurological_condition_no')" @if(!empty($intakeData) && isset($intakeData['neurological_condition']) && $intakeData['neurological_condition']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="neurological_condition_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="neurological_condition" id="neurological_condition_no" value="no" onclick="toggleCheckbox('neurological_condition_no', 'neurological_condition_yes')" @if(!empty($intakeData) && isset($intakeData['neurological_condition']) && $intakeData['neurological_condition']=='no' ) checked @endif>
                                                <label class="form-check-label" for="neurological_condition_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <h6 class="fwt-bold">Immunizations</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-7">
                                <p class="mb-2">Are your immunizations up to date?</p>
                            </div>
                            <div class="col-md-5">
                                <div class="checkbox-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_immunization" id="has_immunization_yes" value="yes" onclick="showImmunizationQuestion('yes')" @if(!empty($intakeData) && isset($intakeData['has_immunization']) && $intakeData['has_immunization']=='yes' ) checked @endif>
                                        <label class="form-check-label" for="has_immunization_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_immunization" id="has_immunization_no" value="no" onclick="showImmunizationQuestion('no')" @if(!empty($intakeData) && isset($intakeData['has_immunization']) && $intakeData['has_immunization']=='no' ) checked @endif>
                                        <label class="form-check-label" for="has_immunization_no">No</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_immunization" id="has_immunization_donotknow" value="donotknow" onclick="showImmunizationQuestion('donotknow')" @if(!empty($intakeData) && isset($intakeData['has_immunization']) && $intakeData['has_immunization']=='donotknow' ) checked @endif>
                                        <label class="form-check-label" for="has_immunization_donotknow">I don't know</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-4">
                <h6 class="fwt-bold">Allergies</h6>
                <div class="row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-7">
                                <p class="mb-2">Do you have any allergies?</p>
                            </div>
                            <div class="col-md-5">
                                <div class="checkbox-wrapper">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_allergy" id="has_allergy_yes" value="yes" onclick="showAllergyQuestion('yes')" @if(!empty($intakeData) && isset($intakeData['has_allergy']) && $intakeData['has_allergy']=='yes' ) checked @endif>
                                        <label class="form-check-label" for="has_allergy_yes">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="has_allergy" id="has_allergy_no" value="no" onclick="showAllergyQuestion('no')" @if(!empty($intakeData) && isset($intakeData['has_allergy']) && $intakeData['has_allergy']=='no' ) checked @endif>
                                        <label class="form-check-label" for="has_allergy_no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div id="allergiesHiddenBox" class="col-12 hidden-checkbox" @if(!empty($intakeData) && isset($intakeData['has_allergy']) && $intakeData['has_allergy']=='yes' ) style="display:block;" @else style="display:none;" @endif>
                                <div class="row">
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you have any food allergies?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="is_allergic_to_food" id="is_allergic_to_food_yes" value="yes" onclick="toggleFoodAllergyCheckbox('is_allergic_to_food_yes', 'is_allergic_to_food_no', 'yes')" @if(!empty($intakeData) && isset($intakeData['is_allergic_to_food']) && $intakeData['is_allergic_to_food']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="is_allergic_to_food_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="is_allergic_to_food" id="is_allergic_to_food_no" value="no" onclick="toggleFoodAllergyCheckbox('is_allergic_to_food_no', 'is_allergic_to_food_yes', 'no')" @if(!empty($intakeData) && isset($intakeData['is_allergic_to_food']) && $intakeData['is_allergic_to_food']=='no' ) checked @endif>
                                                <label class="form-check-label" for="is_allergic_to_food_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="foodAllergyHiddenBox" @if(!empty($intakeData) && isset($intakeData['is_allergic_to_food']) && $intakeData['is_allergic_to_food']=='yes' ) style="display:block;" @else style="display:none;" @endif>
                                        <div class="foodallergy-append">
                                            @if(!empty($intakeData['foodallergy']))
                                            @foreach($intakeData['foodallergy'] as $key => $value)
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <label class="float-label">What Are You Allergic To?</label>
                                                                <input type="text" class="form-control" name="foodallergy[$key][title]" value="{{$value['title']}}" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <label class="float-label">Reaction / Side Effect</label>
                                                                <input type="text" class="form-control" name="foodallergy[$key][reaction]" value="{{$value['reaction']}}" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn_alignbox justify-content-end mb-3">
                                                    <a class="primary d-flex align-items-center gap-2" onclick="addFoodAllergy();"><span class="material-symbols-outlined">add</span>Add</a>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <?php $foodallergyCount = (!empty($intakeData['foodallergy'])) ? count($intakeData['foodallergy']) : '0'; ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <input type="text" class="form-control" name="foodallergy[$foodallergyCount][title]" placeholder="What Are You Allergic To?">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <input type="text" class="form-control" name="foodallergy[$foodallergyCount][reaction]" placeholder="Reaction / Side Effect">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn_alignbox justify-content-end mb-3">
                                                    <a class="primary d-flex align-items-center gap-2" onclick="addFoodAllergy();"><span class="material-symbols-outlined">add</span>Add</a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <p class="mb-2">Do you have any drug allergies?</p>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="checkbox-wrapper">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="is_allergic_to_drug" id="is_allergic_to_drug_yes" value="yes" onclick="toggleDrugAllergyCheckbox('is_allergic_to_drug_yes', 'is_allergic_to_drug_no', 'yes')" @if(!empty($intakeData) && isset($intakeData['is_allergic_to_drug']) && $intakeData['is_allergic_to_drug']=='yes' ) checked @endif>
                                                <label class="form-check-label" for="is_allergic_to_drug_yes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" name="is_allergic_to_drug" id="is_allergic_to_drug_no" value="no" onclick="toggleDrugAllergyCheckbox('is_allergic_to_drug_no', 'is_allergic_to_drug_yes', 'no')" @if(!empty($intakeData) && isset($intakeData['is_allergic_to_drug']) && $intakeData['is_allergic_to_drug']=='no' ) checked @endif>
                                                <label class="form-check-label" for="is_allergic_to_drug_no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12" id="drugAllergyHiddenBox" @if(!empty($intakeData) && isset($intakeData['is_allergic_to_drug']) && $intakeData['is_allergic_to_drug']=='yes' ) style="display:block;" @else style="display:none;" @endif>
                                        <div class="drugallergy-append">
                                            @if(!empty($intakeData['drugallergy']))
                                            @foreach($intakeData['drugallergy'] as $key => $value)
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <label class="float-label">What Are You Allergic To?</label>
                                                                <input type="text" class="form-control" name="drugallergy[$key][title]" value="{{$value['title']}}" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <label class="float-label">Reaction / Side Effect</label>
                                                                <input type="text" class="form-control" name="drugallergy[$key][reaction]" value="{{$value['reaction']}}" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn_alignbox justify-content-end mb-3">
                                                    <a class="primary d-flex align-items-center gap-2"><span class="material-symbols-outlined" onclick="addDrugAllergy();">add</span>Add</a>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <?php $drugallergyCount = (!empty($intakeData['drugallergy'])) ? count($intakeData['drugallergy']) : '0'; ?>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <label class="float-label">What Are You Allergic To?</label>
                                                                <input type="text" class="form-control" name="drugallergy[$drugallergyCount][title]" placeholder="">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-outline mb-3">
                                                                <label class="float-label">Reaction / Side Effect</label>
                                                                <input type="text" class="form-control" name="drugallergy[$drugallergyCount][reaction]" placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="btn_alignbox justify-content-end">
                                                    <a class="primary d-flex align-items-center gap-2" onclick="addDrugAllergy();"><span class="material-symbols-outlined">add</span>Add</a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" name="sourcetype" id="sourcetype" value="1">
            <input type="hidden" class="form-control" name="key" @if(!empty($medications) && isset($medications->patient_intakeform_uuid) && $medications->patient_intakeform_uuid != '') value="{{$medications->patient_intakeform_uuid}}" @endif>
            <div class="col-12">
                <div class="subt-btn btn_alignbox justify-content-end my-5">
                    <a class="btn text-decoration-underline skip_btn" onclick="getNextIntakeForm('success','1')">Skip</a>
                    <a class="btn btn-outline-primary" onclick="getNextIntakeForm('healthmetrics')">Previous</a>
                    <button class="btn btn-primary" id="medicationbutton" onclick="submitMedicationForm('medicalhistory')">Next</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    function toggleCheckbox(checkedId, uncheckedId) {
        const checkedBox = document.getElementById(checkedId);
        const uncheckedBox = document.getElementById(uncheckedId);
        const reasonSection = document.getElementById('medication_reason_section');
        const medicationInput = document.getElementById('other_medication');

        if (checkedBox.checked) {
            uncheckedBox.checked = false;
        }

        // Show/hide the textarea section based on "Yes"
        if (document.getElementById('other_medications_yes').checked) {
            reasonSection.style.display = 'block';
        } else {
            reasonSection.style.display = 'none';
            medicationInput.value = '';
        }
    }

    function toggleFoodAllergyCheckbox(checkedId, uncheckedId, type) {
        if (type == 'yes') {
            if ($("#is_allergic_to_food_yes").is(':checked')) {
                $("#foodAllergyHiddenBox").show();
            } else {
                $("#foodAllergyHiddenBox input[type='text']").val('');
                $("#foodAllergyHiddenBox").hide();
            }
        } else {
            $("#foodAllergyHiddenBox input[type='text']").val('');
            $("#foodAllergyHiddenBox").hide();
        }
        const checkedBox = document.getElementById(checkedId);
        const uncheckedBox = document.getElementById(uncheckedId);

        if (checkedBox.checked) {
            uncheckedBox.checked = false;
        }
    }

    function toggleDrugAllergyCheckbox(checkedId, uncheckedId, type) {
        if (type == 'yes') {
            if ($("#is_allergic_to_drug_yes").is(':checked')) {
                $("#drugAllergyHiddenBox").show();
            } else {
                $("#drugAllergyHiddenBox input[type='text']").val('');
                $("#drugAllergyHiddenBox").hide();
            }
        } else {
            $("#drugAllergyHiddenBox input[type='text']").val('');
            $("#drugAllergyHiddenBox").hide();
        }
        const checkedBox = document.getElementById(checkedId);
        const uncheckedBox = document.getElementById(uncheckedId);

        if (checkedBox.checked) {
            uncheckedBox.checked = false;
        }
    }

    function showMedicationQuestion(type) {
        if (type == 'yes') {
            if ($("#has_medication_yes").is(':checked')) {
                $("#medicationsHiddenBox").show();
            } else {
                $("#medicationsHiddenBox input[type='checkbox']").prop('checked', false);
                $("#medicationsHiddenBox").hide();
            }
            $("#has_medication_no").prop('checked', false);
        } else {
            $("#medicationsHiddenBox").hide();
            $("#medicationsHiddenBox input[type='checkbox']").prop('checked', false);
            $("#has_medication_yes").prop('checked', false);
        }
    }

    function showConditionQuestion(type) {
        if (type == 'yes') {
            if ($("#has_condition_yes").is(':checked')) {
                $("#conditionsHiddenBox").show();
            } else {
                $("#conditionsHiddenBox input[type='checkbox']").prop('checked', false);
                $("#conditionsHiddenBox").hide();
            }
            $("#has_condition_no").prop('checked', false);
        } else {
            $("#conditionsHiddenBox").hide();
            $("#conditionsHiddenBox input[type='checkbox']").prop('checked', false);
            $("#has_condition_yes").prop('checked', false);
        }
    }

    function showImmunizationQuestion(type) {
        if (type == 'yes') {
            $("#has_immunization_no").prop('checked', false);
            $("#has_immunization_donotknow").prop('checked', false);
        } else if (type == 'no') {
            $("#has_immunization_yes").prop('checked', false);
            $("#has_immunization_donotknow").prop('checked', false);
        } else {
            $("#has_immunization_yes").prop('checked', false);
            $("#has_immunization_no").prop('checked', false);
        }
    }

    function showAllergyQuestion(type) {
        if (type == 'yes') {
            if ($("#has_allergy_yes").is(':checked')) {
                $("#allergiesHiddenBox").show();
            } else {
                $("#allergiesHiddenBox input[type='checkbox']").prop('checked', false);
                $("#allergiesHiddenBox").hide();
            }
            $("#has_allergy_no").prop('checked', false);
        } else {
            $("#allergiesHiddenBox").hide();
            $("#allergiesHiddenBox input[type='checkbox']").prop('checked', false);
            $("#has_allergy_yes").prop('checked', false);
        }
    }

    function addFoodAllergy() {
        const foodallergyCount = document.querySelectorAll('div.foodallergy-append .row').length - 1;
        const foodallergyHtml = `
            <div class="col-12 foodallergy-item"> 
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group form-outline mb-3">
                            <label class="float-label">What Are You Allergic To?</label>
                            <input type="text" class="form-control" name="foodallergy[${foodallergyCount}][title]" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-outline mb-3">
                            <label class="float-label">Reaction / Side Effect</label>
                            <input type="text" class="form-control" name="foodallergy[${foodallergyCount}][reaction]" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-1"> 
                        <div class="btn_alignbox justify-content-end">
                            <a class="danger"><span class="material-symbols-outlined fwt-medium" onclick="removeFoodAllergy(this);">delete</span></a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('.foodallergy-append').append(foodallergyHtml);
    }

    function removeFoodAllergy(element) {
        $(element).closest('.foodallergy-item').remove();
    }

    function addDrugAllergy() {
        const drugallergyCount = document.querySelectorAll('div.drugallergy-append .row').length - 1;
        const drugallergyHtml = `
            <div class="col-12 drugallergy-item"> 
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="form-group form-outline mb-3">
                            <label class="float-label">What Are You Allergic To?</label>
                            <input type="text" class="form-control" name="drugallergy[${drugallergyCount}][title]" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group form-outline mb-3">
                             <label class="float-label">Reaction / Side Effect</label>
                            <input type="text" class="form-control" name="drugallergy[${drugallergyCount}][reaction]" placeholder="">
                        </div>
                    </div>
                    <div class="col-md-1"> 
                        <div class="btn_alignbox justify-content-end">
                            <a class="danger"><span class="material-symbols-outlined fwt-medium" onclick="removeDrugAllergy(this);">delete</span></a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('.drugallergy-append').append(drugallergyHtml);
    }

    function removeDrugAllergy(element) {
        $(element).closest('.drugallergy-item').remove();
    }
</script>

<script>
    $(document).ready(function() {
        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');

            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }

        // Initialize all inputs on page load
        $('input, textarea').each(function() {
            toggleLabel(this);
        });

        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function() {
            toggleLabel(this);
        });

        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function(e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });
    });
</script>