<h4 class="text-center fw-medium mb-0 ">Refer  Patient</h4>
                            <small class="gray">Choose the hospital details and department for a smooth referral process.</small>
                            <div class="import_section">
                                <!-- <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a> -->
                            </div>
                          
                              <form id="referpatient" method="POST" autocomplete="off"> 
                              @csrf

                           

                                <div class="row mt-4"> 
                                  <div class="col-md-12">
                                    <div class="form-group form-outline mb-3">
                                      <label for="input" class="float-label">Organization Name</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text"  name="orgname" class="form-control" id="orgname" value="" >
                                    </div>
                                  </div>
                               
                                  <div class="col-md-12">
                                    <div class="form-group form-outline mb-3">
                                      <label for="input" class="float-label">Department</label>
                                      <i class="fa-solid fa-circle-user"></i>
                                      <input type="text"  name="department" class="form-control" id="department" value="" >
                                    </div>
                                  </div>
                                  
                                 
                                 
                         
                                  <div class="col-12">
                                    <div class="btn_alignbox justify-content-end">
                                      <a href="" class="btn btn-outline-primary">Close</a>
                                      <a onclick="updatePatient()" id="updatepatient" class="btn btn-primary">Submit</a>
                                    </div>
                                    
                                  </div>
                                </div>

                            </form>

        <script>

          </script>