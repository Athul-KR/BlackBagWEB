

                          
            <div class="web-card h-100 mb-3 overflow-hidden">
                <div class="profileData patientProfile">
                    <div class="row align-items-end h-100">
                        
                              
                      <h3> Change in data</h3>
                      <p> This user already exists in the database; we noticed changes in the following data. </p>

                      <p>  Name : Current data     {{$clinicUser['name']}}            - >  Updated to  {{$excelDetails['name']}} </p>
                      <p>  Email : Current data    {{$clinicUser['email']}}            - >  Updated to  {{$excelDetails['email']}} </p>
                      <p>  Phone Number : Current data    {{$clinicUser['phone_number']}}            - >  Updated to  {{$excelDetails['phone_number']}}  </p>
                      <p>  Designation : Current data  @if(isset($designation[$clinicUser['designation_id']]))  {{$designation[$clinicUser['designation_id']]['name']}} @endif          
                        - >  Updated to  @if(isset($designation[$excelDetails['designation_id']]['name'])) {{$designation[$excelDetails['designation_id']]['name']}} @endif   </p>
                       
                     
                      <p>    Specialty : Current data     {{$clinicUser['specialty']}}            - >  Updated to  {{$excelDetails['specialty']}} </p>

                     
                    </div>

                    

                    </div>
                </div>
            </div>
      


