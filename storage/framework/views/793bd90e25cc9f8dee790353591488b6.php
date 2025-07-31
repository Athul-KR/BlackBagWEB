<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-xl-8 col-12">
        <div class="row">
          <div class="col-lg-12 mb-3">
            <div class="web-card threshhold-card h-100 p-0">
              <div class="row align-items-center">
                  <div class="col-sm-6 col-md-6 text-center text-sm-start mb-3 mb-sm-0">
                      <div class="welcome-body">
                        <h2>Good Morning,</h2>
                        <h3>HealthCrest Clinic</h3>
                        <h2 class="m-0">You have <a href="" class="primary fw-medium">5</a> appointments today</h2>
                      </div>
                  </div>
                  <div class="col-sm-6 col-md-6 text-center text-sm-end">
                     <img src="<?php echo e(asset('images/Doctors-group.png')); ?>" class="img-fluid">
                  </div>
                 
                </div>
            </div>
          </div>
          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row align-items-center">
                <div class="col-sm-10 text-center text-sm-start">
                  <h4 class="mb-md-0">Upcoming Appointments</h4>
                </div>
                <div class="col-sm-2 text-center text-sm-end">
                  <a href="" class="link primary fw-medium text-decoration-underline">See all</a>
                </div>
                <div class="col-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                    <thead>
                      <tr>
                        <th>Patient</th>
                        <th>Age</th>
                        <th>Appointment Date & Time</th>
                        <th>Appointment Type</th>
                        <th class="text-end">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="user_inner">
                              <img src="<?php echo e(asset('images/patient1.png')); ?>">
                              <div class="user_info">
                                  <h6 class="primary fw-medium m-0">John Doe</h6>
                                  <p class="m-0">johndoe@gmail.com</p>
                              </div>
                          </div>
                        </td>
                        <td>32</td>
                        <td>Jun 13 2024, 10:30 AM</td>
                        <td>Online</td>
                        <td class="text-end">
                          <div class="d-flex align-items-center justify-content-end btn_alignbox">
                            <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="<?php echo e(asset('images/file_alt.png')); ?>"></a>
                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                              <span class="material-symbols-outlined">more_vert</span>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end">
                              <li><a href="#" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                              <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                          </ul>
                          </div>
                        </td>
                      </tr>
                      <tr>
                          
                          <td>
                            <div class="user_inner">
                                <img src="<?php echo e(asset('images/patient2.png')); ?>">
                                <div class="user_info">
                                    <h6 class="primary fw-medium m-0">Justin Taylor</h6>
                                    <p class="m-0">justintay@gmail.com</p>
                                </div>
                            </div>
                          </td>
                          <td>41</td>
                          <td>Jun 13 2024, 11:30 PM</td>
                          <td>In-person</td>
                          <td class="text-end">
                            <div class="d-flex align-items-center justify-content-end btn_alignbox">
                              <a class="btn opt-btn border-0" href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes">
                                  <img src="<?php echo e(asset('images/file_alt.png')); ?>" alt="Download">
                              </a>
                              <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                  <span class="material-symbols-outlined">more_vert</span>
                              </a>
                              <ul class="dropdown-menu dropdown-menu-end">
                                  <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                  <li><a href="#" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                              </ul>
                          </div>
                          </td>
                        </tr>
                      
                    </tbody>
                  </table>
                </div>  
                </div>
              </div>
            </div>
         </div>
        </div>
      </div>
         <div class="col-xl-4 mb-3">
          <div class="web-card h-100 justify-content-center pb-0 mb-xl-3 mb-5 position-relative overflow-hidden">
            <div class="row align-items-center">
            
              <div class="col-12 mb-3">
                <div id="calendar" class="calendar">
                  <span>Add something here</span>
                </div>
              </div>
              <div class="">
                <hr>
              </div>
             
              <div class="col-12">
                <div class="row">
                  <div class="col-sm-9 text-center text-sm-start">
                    <h4 class="mb-md-0">Appointments</h4>
                  </div>
                  <div class="col-sm-3 text-center text-sm-end">
                    <a href="" class="link primary fw-medium text-decoration-underline">See All</a>
                  </div>
                  <div class="col-12 mb-3 mt-4">
                    <div class="contributors-sec">
                      <div class="user_inner">
                        <img src="<?php echo e(asset('images/record1.png')); ?>">
                        <div class="user_info">
                          <a href="patientdetails.html">
                            <h6 class="primary fw-medium m-0">Rudy Macane</h6>
                            <p class="m-0">rudymc@gmail.com</p>
                          </a>
                        </div>
                    </div>
                      <div class="d-flex align-items-center justify-content-end">
                          <p class="m-0">10:30 AM</p>
                          <a class="btn opt-btn border-0" href="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy"><i class="fa-solid fa-chevron-right"></i></a>
                      </div>
                    </div>
                    <div class="contributors-sec">
                      <div class="user_inner">
                          <img src="<?php echo e(asset('images/patient4.png')); ?>">
                          <div class="user_info">
                              <h6 class="primary fw-medium m-0">Alejandro González</h6>
                              <p class="m-0">alexgonzalez@gmail.com</p>
                          </div>
                      </div>
                      <div class="d-flex align-items-center justify-content-end">
                          <p class="m-0">12:30 PM</p>
                          <a class="btn opt-btn border-0" href="" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Copy"><i class="fa-solid fa-chevron-right"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-12">
                    <a class=" btn btn-primary px-5 mb-2 py-2 w-100 btn-align" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#addAppointment"><span class="material-symbols-outlined">add</span>Add New Appointment</a>
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

    
//-------- date picker ---------- //

var calendarNode = document.querySelector("#calendar");

var currDate = new Date();
var currYear = currDate.getFullYear();
var currMonth = currDate.getMonth() + 1;

var selectedYear = currYear;
var selectedMonth = currMonth;
var selectedMonthName = getMonthName(selectedYear, selectedMonth);
var selectedMonthDays = getDayCount(selectedYear, selectedMonth);

renderDOM(selectedYear, selectedMonth);

function getMonthName (year, month) {
    let selectedDate = new Date(year, month-1, 1);
    return selectedDate.toLocaleString('default', { month: 'long' });
}

function getMonthText () {
    if (selectedYear === currYear)
        return selectedMonthName;
    else
        return selectedMonthName + ", " + selectedYear;
}

function getDayName (year, month, day) {
    let selectedDate = new Date(year, month-1, day);
    return selectedDate.toLocaleDateString('en-US',{weekday: 'long'});
}

function getDayCount (year, month) {
    return 32 - new Date(year, month-1, 32).getDate();
}

function getDaysArray () {
    let emptyFieldsCount = 0;
    let emptyFields = [];
    let days = [];

    switch(getDayName(selectedYear, selectedMonth, 1))
    {
        case "Tuesday":
            emptyFieldsCount = 1;
            break;
        case "Wednesday":
            emptyFieldsCount = 2;
            break;
        case "Thursday":
            emptyFieldsCount = 3;
            break;
        case "Friday":
            emptyFieldsCount = 4;
            break;
        case "Saturday":
            emptyFieldsCount = 5;
            break;
        case "Sunday":
            emptyFieldsCount = 6;
            break;
    }
  
    emptyFields = Array(emptyFieldsCount).fill("");
    days = Array.from(Array(selectedMonthDays + 1).keys());
    days.splice(0, 1);
    
    return emptyFields.concat(days);
}

function renderDOM (year, month) {
  let newCalendarNode = document.createElement("div");
  newCalendarNode.id = "calendar";
  newCalendarNode.className = "calendar";
  
  let dateText = document.createElement("div");
  dateText.append(getMonthText());
  dateText.className = "date-text";
  newCalendarNode.append(dateText);
  
  let leftArrow = document.createElement("div");
  let leftIcon = document.createElement("i");
  leftIcon.className = "fa-solid fa-chevron-left";
  leftArrow.appendChild(leftIcon);
  leftArrow.className = "button";
  leftArrow.addEventListener("click", goToPrevMonth);
  newCalendarNode.appendChild(leftArrow);
  
  let curr = document.createElement("div");
  curr.append("");
  curr.className = "button";
  curr.addEventListener("click", goToCurrDate);
  newCalendarNode.append(curr);
  
  let rightArrow = document.createElement("div");
  let icon = document.createElement("i");
  icon.className = "fa-solid fa-chevron-right";
  rightArrow.appendChild(icon);
  rightArrow.className = "button";
  rightArrow.addEventListener("click", goToNextMonth);
  newCalendarNode.appendChild(rightArrow);
  
  let dayNames = ["M", "T", "W", "T", "F", "S", "S"];
  
  dayNames.forEach((cellText) => {
    let cellNode = document.createElement("div");
    cellNode.className = "cell cell--unselectable";
    cellNode.append(cellText);
    newCalendarNode.append(cellNode);
  });
  
  let days = getDaysArray(year, month);
  
  days.forEach((cellText) => {
    let cellNode = document.createElement("div");
    cellNode.className = "cell";
    cellNode.append(cellText);
    newCalendarNode.append(cellNode);
  });
  
  calendarNode.replaceWith(newCalendarNode);
  calendarNode = document.querySelector("#calendar");
}

function goToPrevMonth () {
    selectedMonth--;
    if (selectedMonth === 0) {
        selectedMonth = 12;
        selectedYear--;
    }
    selectedMonthDays = getDayCount(selectedYear, selectedMonth);
    selectedMonthName = getMonthName(selectedYear, selectedMonth);
  
    renderDOM(selectedYear, selectedMonth);
}

function goToNextMonth () {
    selectedMonth++;
    if (selectedMonth === 13) {
        selectedMonth = 0;
        selectedYear++;
    }
    selectedMonthDays = getDayCount(selectedYear, selectedMonth);
    selectedMonthName = getMonthName(selectedYear, selectedMonth);
  
    renderDOM(selectedYear, selectedMonth);
}

function goToCurrDate () {
    selectedYear = currYear;
    selectedMonth = currMonth;

    selectedMonthDays = getDayCount(selectedYear, selectedMonth);
    selectedMonthName = getMonthName(selectedYear, selectedMonth);
  
    renderDOM(selectedYear, selectedMonth);
}



    </script>

    
            <!-- Appointment Modal -->

            <div class="modal login-modal fade" id="addAppointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header modal-bg p-0 position-relative">
                        <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="text-center fw-medium mb-0">Add New Appointment</h4>
                      <small class="gray">Please enter patient details and create an appointment.</small>
                      <form>
                        <div class="row mt-4">
                          <div class="col-12">
                            <div class="form-group form-outline mb-3">
                              <label for="input">Select Patient</label>
                              <i class="fa-solid fa-circle-user"></i>
                                <div class="dropdownBody">
                                  <div class="dropdown">
                                    <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                    </a>
                                      <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                        <li class="dropdown-item">
                                          <div class="form-outline input-group ps-1">
                                              <div class="input-group-append">
                                                <button class="btn border-0" type="button">
                                                  <i class="fas fa-search fa-sm"></i>
                                                </button>
                                              </div>
                                                <input type="text" class="form-control border-0 small" placeholder="Search Patient" aria-label="Search" aria-describedby="basic-addon2">
                                          </div>
                                        </li>
                                        <li class="dropdown-item">
                                          <a href="" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#assignNurse">
                                            <div class="dropview_body profileList">
                                              <img src="<?php echo e(asset('images/patient1.png')); ?>" class="img-fluid">
                                              <p class="m-0">John Doe</p>
                                            </div>
                                          </a>
                                        </li>
                                        <li class="dropdown-item">
                                          <div class="dropview_body profileList">
                                            <img src="<?php echo e(asset('images/patient2.png')); ?>" class="img-fluid">
                                            <p class="m-0">Justin Taylor</p>
                                          </div>
                                        </li>
                                      </ul>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="mb-4">
                              <a href="" class="primary fw-medium d-flex justify-content-end" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#addPatientModal"><span class="material-symbols-outlined"> add </span>Add New Patient</a>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-outline mb-3">
                              <label for="input">Appointment Date</label>
                              <i class="material-symbols-outlined">calendar_clock</i>
                              <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-outline mb-3">
                              <label for="input">Appointment Time</label>
                              <i class="material-symbols-outlined">alarm</i>
                              <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-outline mb-3">
                              <label for="input">Appointment Type</label>
                              <i class="material-symbols-outlined">assignment_turned_in</i>
                                <div class="dropdownBody">
                                  <div class="dropdown">
                                    <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                    </a>
                                      <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                        <li class="dropdown-item">
                                          <div class="dropview_body">
                                            <p class="m-0">Online Consultation</p>
                                          </div>
                                        </li>
                                        <li class="dropdown-item">
                                          <div class="dropview_body">
                                            <p class="m-0">In-person Appointments</p>
                                          </div>
                                        </li>
                                       
                                      </ul>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group form-outline mb-3">
                              <label for="input">Appointment Fee</label>
                              <i class="material-symbols-outlined">payments</i>
                              <input type="email" class="form-control" id="exampleFormControlInput1">
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group form-outline mb-3">
                              <label for="input">Assign Doctor</label>
                              <i class="material-symbols-outlined">stethoscope</i>
                                <div class="dropdownBody">
                                  <div class="dropdown">
                                    <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                    </a>
                                    
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group form-outline mb-3">
                              <label for="input">Assign Nurse</label>
                              <i class="material-symbols-outlined">clinical_notes</i>
                                <div class="dropdownBody">
                                  <div class="dropdown">
                                    <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                      <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                    </a>
                                      <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                        <li class="dropdown-item">
                                          <div class="form-outline input-group ps-1">
                                              <div class="input-group-append">
                                                <button class="btn border-0" type="button">
                                                  <i class="fas fa-search fa-sm"></i>
                                                </button>
                                              </div>
                                                <input type="text" class="form-control border-0 small" placeholder="Search nurses" aria-label="Search" aria-describedby="basic-addon2">
                                          </div>
                                        </li>
                                        <li class="dropdown-item">
                                          <a href="">
                                            <div class="dropview_body profileList">
                                              <img src="<?php echo e(asset('images/nurse1.png')); ?>" class="img-fluid">
                                              <p class="m-0">Alia Fadel</p>
                                            </div>
                                          </a>
                                        </li>
                                        <li class="dropdown-item">
                                          <div class="dropview_body profileList">
                                            <img src="<?php echo e(asset('images/nurse2.png')); ?>" class="img-fluid">
                                            <p class="m-0">Luciana Álvarez</p>
                                          </div>
                                        </li>
                                      </ul>
                                  </div>
                                </div>
                            </div>
                          </div>
                          <div class="col-12">
                            <div class="form-group form-outline form-textarea mb-4">
                              <label for="input">Notes</label>
                              <i class="fa-solid fa-file-lines"></i>
                              <textarea class="form-control" id="exampleFormControlInput1" rows="4" cols="4"></textarea>
                            </div>

                          </div>
                          <div class="btn_alignbox justify-content-lg-end ">
                            <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#assignNurse">Submit</a>

                          </div>

                        </div>

                      </form>
                    </div>
                  </div>
                </div>
              </div>     

                 <!-- End Appointment Modal -->

 
 
 
                    <!-- Add New Patient -->

                    <div class="modal login-modal fade" id="addPatientModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header modal-bg p-0 position-relative">
                            <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                    
                        </div>
                        <div class="modal-body text-center position-relative">
                          <div class="text-center d-lg-block d-none">
                            <h4 class="text-center fw-medium mb-0 ">Add New Patient</h4>
                            <small class="gray">Please enter the patient’s details</small>
                            <div class="create-profile">
                              <div class="profile-img position-relative"> 
                                <img src="<?php echo e(asset('images/default_img.png')); ?>" class="img-fluid">
                                <a><img src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid"></a>
                              </div>
                            </div>
                            <div class="import_section">
                                <a href="" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a>
                            </div>
                          </div>
                            <form> 
                              <div class="row"> 
                                <div class="col-12">
                                  <div class="row d-lg-none d-block mb-4">
                                    <div class="col-12">
                                      <div class="text-center position-relative">
                                        <h4 class="text-center fw-medium mb-0 ">Add New Patient</h4>
                                        <small class="gray">Please enter the patient’s details</small>
                                        <div class="create-profile">
                                          <div class="profile-img position-relative"> 
                                            <img src="<?php echo e(asset('images/default_img.png')); ?>" class="img-fluid">
                                            <a><img src="<?php echo e(asset('images/img_select.png')); ?>" class="img-fluid"></a>
                                          </div>
                                        </div>

                                      </div>

                                    </div>
                                    <div class="col-md-5 col-sm-6 col-12 mx-auto">
                                      <a href="" class="btn btn-outline-primary d-flex align-items-center justify-content-center" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#import_data"><span class="material-symbols-outlined me-1">upload_2</span>Import Patients</a>
                                    </div>

                                  </div>

                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">Name</label>
                                    <i class="fa-solid fa-circle-user"></i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">Gender</label>
                                    <i class="material-symbols-outlined">wc</i>
                                      <div class="dropdownBody">
                                        <div class="dropdown">
                                          <a class="btn dropdown-toggle w-100" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                          </a>
                                            <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuLink">
                                            
                                              <li class="dropdown-item">
                                                  <div class="dropview_body">
                                                    <p class="m-0">Male</p>
                                                  </div>
                                              </li>
                                              <li class="dropdown-item">
                                                <div class="dropview_body">
                                                  <p class="m-0">Female</p>
                                                </div>
                                              </li>
                                             
                                            </ul>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">Email</label>
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">Date of Birth</label>
                                    <i class="material-symbols-outlined">date_range</i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">Phone Number</label>
                                    <i class="material-symbols-outlined">call</i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">Whatsapp</label>
                                    <i class="fa-brands fa-whatsapp"></i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="d-flex justify-content-end align-items-center mb-3">
                                    <input class="form-check-input btn-outline-checkbox m-0 me-2" type="checkbox" value="">
                                    <samll class="primary fw-medium">Same as phone number</samll>
                                  </div>
                                </div>
                                <div class="col-12">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">Address</label>
                                    <i class="material-symbols-outlined">home</i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">City</label>
                                    <i class="material-symbols-outlined">location_city</i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">State</label>
                                    <i class="material-symbols-outlined">map</i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                <div class="col-md-4">
                                  <div class="form-group form-outline mb-3">
                                    <label for="input">ZIP</label>
                                    <i class="material-symbols-outlined">home_pin</i>
                                    <input type="email" class="form-control" id="exampleFormControlInput1">
                                  </div>
                                </div>
                                  <div class="col-12">
                                    <div class="d-flex justify-content-end align-items-center mb-3">
                                      <a href="" class="primary fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add Notes</a>
                                    </div>
                                    <div class="form-group form-outline form-textarea mb-3">
                                      <label for="input">Notes</label>
                                      <i class="fa-solid fa-file-lines"></i>
                                      <textarea class="form-control" id="exampleFormControlInput1" rows="4" cols="4"></textarea>
                                    </div>
                                  </div>
                                  <div class="col-12">
                                    <div class="dropzone-wrapper mb-3">
                                      <a href="" class="gray fw-medium d-flex justify-content-end"><span class="material-symbols-outlined"> add </span>Add patient files</a>
                                    </div>
                                    <div class="files-container mb-3">
                                      <div class="fileBody">
                                        <div class="file_info">
                                          <img src="<?php echo e(asset('images/pdf_img.png')); ?>">
                                          <span>patient_files.pdf</span>
                                        </div>
                                        <a href="#" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                                      </div>
                                      <div class="fileBody">
                                        <div class="file_info">
                                          <img src="<?php echo e(asset('images/pdf_img.png')); ?>">
                                          <span>medical history.pdf</span>
                                        </div>
                                        <a href="#" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
                                      </div>

                                    </div>
                                  </div>
                       
                                <div class="col-12">
                                  <div class="btn_alignbox justify-content-end">
                                    <a href="" class="btn btn-outline-primary">Close</a>
                                    <a href="" class="btn btn-primary">Submit</a>
                                  </div>
                                  
                                </div>
                              </div>
                          </div>
                      </div>
                    </div>
                  </div>


                 <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/dashboard.blade.php ENDPATH**/ ?>