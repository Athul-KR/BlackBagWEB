        <div class="col-lg-2">
            <div class="dropdown @if(isset($type) && $type != 'videocall') d-flex justify-content-end @endif">
                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Order
                    <span class="material-symbols-outlined arrow-btn"> keyboard_arrow_down</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" onclick="addLabtests()"  data-bs-toggle="modal" data-bs-dismiss="modal" ><span class="material-symbols-outlined">experiment</span>Lab Tests</a>
                    @if( isset($showPrescription) && $showPrescription == 1)
                    <a class="dropdown-item" onclick="showPrescription()"><span class="material-symbols-outlined">prescriptions</span>Prescription</a>
                    @endif
                    
                    <a class="dropdown-item" onclick="addImagings()"><span class="material-symbols-outlined">hand_bones</span>Imaging</a>
                    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#orderservices"><span class="material-symbols-outlined">medical_services</span>Services</a>
                 
                    @if( ( session()->get('user.userType') == 'doctor' ) || ( session()->get('user.userType') == 'clinics' && session()->get('user.licensed_practitioner') == '1'  )  )
                    <a class="dropdown-item" onclick="openOrderDevices()" ><span class="material-symbols-outlined">add_shopping_cart</span>Devices</a>
                    @endif
                </div>
            </div>
        </div>