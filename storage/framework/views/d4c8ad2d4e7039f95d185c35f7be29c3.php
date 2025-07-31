<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row">
      <div class="col-xl-8 col-12">
        <div class="row h-100">
          <div class="col-lg-12 mb-3">
            <div class="web-card threshhold-card h-100 p-0">
              <div class="row align-items-center">
                  <div class="col-sm-6 col-md-6 text-center text-sm-start mb-3 mb-sm-0">
                      <div class="welcome-body">
                        <h2>Good Morning,</h2>
                        <h3><?php echo e(Session::get('user.clinicName')); ?></h3>
                        <h2 class="m-0">You have <a href="" class="primary fw-medium"><?php echo e($todayAppointmentsCount); ?></a> appointments today</h2>
                      </div>
                  </div>
                  <div class="col-sm-6 col-md-6 text-center text-sm-end">
                     <img src="<?php echo e(asset('images/Doctors-group.png')); ?>" class="img-fluid">
                  </div>
                 
                </div>
            </div>
          </div>
          <div class="col-lg-12 mb-xl-5 mb-3">
            <div class="web-card h-100">
              <div class="row align-items-center">
                <div class="col-sm-10 text-center text-sm-start">
                  <h4 class="mb-md-0">Upcoming Appointments</h4>
                </div>
                <div class="col-sm-2 text-center text-sm-end">
                <?php if(!empty($appointmentRecords)): ?>
                  <a href="<?php echo e(url('appointment/list')); ?>" class="link primary fw-medium text-decoration-underline">See all</a>
                  <?php endif; ?>
                </div>
                <div class="col-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                    <thead>
                      <tr>
                        <th>Patient</th>
                        <th>Age</th>
                        <th>Date & Time</th>
                        <th>Type</th>
                        <th class="text-end">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php if(!empty($appointmentRecords)): ?>
                    <?php $__currentLoopData = $appointmentRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <td>
                          <div class="user_inner">
                          <?php
                             $logo_path = '';
                                $corefunctions = new \App\customclasses\Corefunctions;
                                if(isset($finalPatient[$aps['patient_id']]['logo_path']) && ($finalPatient[$aps['patient_id']]['logo_path'] !='') ){
                                  $logo_path = $corefunctions->getAWSFilePath($finalPatient[$aps['patient_id']]['logo_path']) ;
                                }
                              ?>
                              
                              <img <?php if($logo_path !=''): ?> src="<?php echo e($logo_path); ?>" <?php else: ?> src="<?php echo e(asset('images/default_img.png')); ?>" <?php endif; ?>>
                              <div class="user_info">
                                  <h6 class="primary fw-medium m-0"><?php if(isset($finalPatient[$aps['patient_id']]) && isset($finalPatient[$aps['patient_id']]['name']) ): ?> <?php echo e($finalPatient[$aps['patient_id']]['name']); ?> <?php else: ?> -- <?php endif; ?></h6>
                                  <p class="m-0"><?php if(isset($finalPatient[$aps['patient_id']]) && isset($finalPatient[$aps['patient_id']]['email']) ): ?> <?php echo e($finalPatient[$aps['patient_id']]['email']); ?> <?php else: ?> -- <?php endif; ?></p>
                              </div>
                          </div>
                        </td>
                        <td><?php if(isset($finalPatient[$aps['patient_id']]) && isset($finalPatient[$aps['patient_id']]['age']) ): ?> <?php echo e($finalPatient[$aps['patient_id']]['age']); ?> <?php else: ?> -- <?php endif; ?></td>
                        <td><?php echo  date('M d Y', strtotime($aps['appointment_date'])) ?> ,<?php echo  date('h:iA', strtotime($aps['appointment_time'])) ?> </td>
                        <td><?php if($aps['appointment_type_id'] == '1'): ?> Online <?php else: ?> In-person <?php endif; ?> </td>
                        <td class="text-end">
                          <div class="d-flex align-items-center justify-content-end btn_alignbox">
                            <a class="btn opt-btn border-0" onclick="notes('<?php echo e($aps['appointment_uuid']); ?>')"><img src="<?php echo e(asset('images/file_alt.png')); ?>"></a>
                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false" >
                              <span class="material-symbols-outlined">more_vert</span>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end">
                              <li><a onclick="editAppointment('<?php echo e($aps['appointment_uuid']); ?>','upcoming','online','dashboard')" class="dropdown-item fw-medium"  data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#EditAppointment"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                              <li><a onclick="cancelAppointment('<?php echo e($aps['appointment_uuid']); ?>','upcoming','online','cancel')" class="dropdown-item fw-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                          </ul>
                          </div>
                        </td>
                      </tr>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <?php else: ?>
                        <tr class="text-center">
                            <td colspan="8">
                                <div class="flex justify-center">
                                    <div class="text-center no-records-body">
                                        <img src="<?php echo e(asset('images/nodata.png')); ?>"
                                            class=" h-auto">
                                        <p>No record found</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?>
                      
                    </tbody>
                  </table>
                </div>  
                </div>
              </div>
            </div>
         </div>
        </div>
      </div>
        
      <div class="col-xl-4 mb-xl-5 mb-3">

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
            <div class="col-12" id="calenderappd">

            </div>

          </div>
        </div>
      </div>


      </div>
    </div>
  </section>

  <script>

  $(document).ready(function() {
      getAppointmentCalender()
  });   

    function getAppointmentCalender(selectedDate='') {
       console.log(selectedDate)
       
        showPreloader('calenderappd');
        $.ajax({
            type: "POST",
            url: '<?php echo e(url("/dashboard/appointment")); ?>',
            data: {
              'date': selectedDate,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // Handle the successful response
                if(response.success == 1){
                    $("#calenderappd").html(response.view);
                }
             
            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.error('AJAX Error: ' + status + ': ' + error);
            },
        })
    }

    function cancelAppointment(key, type, status, apptype) {
    swal({
        text: "Are you sure you want to " + apptype + " this appointment?",
        icon: "warning",
        buttons: {
            cancel: {
                text: "Cancel",
                visible: true,
            },
            confirm: {
                text: "OK",
                closeModal: false // Keeps the modal open until we handle the AJAX response
            }
        }
    }).then((willCancel) => {
        if (willCancel) {
            $.ajax({
                type: "POST",
                url: "<?php echo e(URL::to('appointment/cancel')); ?>",
                data: {
                    'key': key,
                    'apptype': apptype,
                    "_token": "<?php echo e(csrf_token()); ?>"
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success == 1) {
                        swal({
                            icon: 'success',
                            title: '',
                            text: response.message,
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred.'
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status == 419) {
                        window.location.reload(); // Token expired
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseText
                        });
                    }
                }
            });
        }
    });
}


    </script>


<script>
  
  //-------- date picker ---------- //
// Get the initial reference for the calendar container
var calendarNode = document.querySelector("#calendar");

// Current date for initial selection
var currDate = new Date();
var currYear = currDate.getFullYear();
var currMonth = currDate.getMonth() + 1;
var currDay = currDate.getDate();

// Set the selected date to today's date initially
var selectedYear = currYear;
var selectedMonth = currMonth;
var selectedDay = currDay;


// Render the calendar on first load
renderDOM(selectedYear, selectedMonth, selectedDay);


// Event listener with simplified approach for debugging
document.addEventListener("click", function(event) {
  
    // Check if a date cell is clicked
    if (event.target.classList.contains("cell") && event.target.innerText !== "") {
        console.log("Date cell clicked:", event.target.innerText);  // Debugging: Check cell click

        // Extract clicked day
        let clickedDay = parseInt(event.target.innerText);
        
        // Update selected date
        selectedDay = clickedDay;
        let selectedDate = `${selectedYear}-${String(selectedMonth).padStart(2, '0')}-${String(selectedDay).padStart(2, '0')}`;
        
        // Log selected date for debugging
        console.log("Selected date:", selectedDate);

        // Call appointment function for selected date
        getAppointmentCalender(selectedDate);

        // Re-render the calendar to highlight selected day
        renderDOM(selectedYear, selectedMonth, selectedDay);
    }
});

// Function to get the full month name
function getMonthName(year, month) {
    let selectedDate = new Date(year, month - 1, 1);
    return selectedDate.toLocaleString('default', { month: 'long' });
}

// Function to get the month and year text
function getMonthText() {
    if (selectedYear === currYear) return getMonthName(selectedYear, selectedMonth);
    return getMonthName(selectedYear, selectedMonth) + ", " + selectedYear;
}

// Function to get the weekday name
function getDayName(year, month, day) {
    let selectedDate = new Date(year, month - 1, day);
    return selectedDate.toLocaleDateString('en-US', { weekday: 'long' });
}

// Function to get the number of days in the selected month
function getDayCount(year, month) {
    return 32 - new Date(year, month - 1, 32).getDate();
}

// Function to create the array of days, accounting for empty spaces in the calendar
function getDaysArray(year, month) {
    let emptyFieldsCount = 0;
    let emptyFields = [];
    let days = [];

    // Adjust based on which day the 1st of the month falls on
    switch (getDayName(year, month, 1)) {
        case "Tuesday": emptyFieldsCount = 1; break;
        case "Wednesday": emptyFieldsCount = 2; break;
        case "Thursday": emptyFieldsCount = 3; break;
        case "Friday": emptyFieldsCount = 4; break;
        case "Saturday": emptyFieldsCount = 5; break;
        case "Sunday": emptyFieldsCount = 6; break;
    }

    emptyFields = Array(emptyFieldsCount).fill("");
    days = Array.from(Array(getDayCount(year, month) + 1).keys()).slice(1);
    
    return emptyFields.concat(days);
}

// Function to render the calendar DOM
function renderDOM(year, month, day) {

let newCalendarNode = document.createElement("div");
newCalendarNode.id = "calendar";
newCalendarNode.className = "calendar";

// Display the current month and year at the top
let dateText = document.createElement("div");
dateText.className = "date-text";
dateText.innerText = getMonthText();
newCalendarNode.append(dateText);


// Left and Right arrows for navigation
let leftArrow = document.createElement("div");
leftArrow.className = "button";
leftArrow.innerHTML = "<i class='fa-solid fa-chevron-left'></i>";
leftArrow.addEventListener("click", goToPrevMonth);
newCalendarNode.appendChild(leftArrow);

// Container for the "Today" button or Day label
let dayLabelContainer = document.createElement("div");
dayLabelContainer.className = "button";

// Check if the calendar is on today's date
if (year === currYear && month === currMonth && day === currDay) {
    // Show "Today" button
    let todayButton = document.createElement("div");
    todayButton.innerText = "Today";
    todayButton.addEventListener("click", goToCurrDate);
    dayLabelContainer.appendChild(todayButton);
} else {
    // Show the name of the day (e.g., Monday, Tuesday)
    let dayNameLabel = document.createElement("div");
    const dayIndex = new Date(year, month - 1, day).getDay(); // Get the day index (0=Sun, 6=Sat)
    const dayNamesFull = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    dayNameLabel.innerText = dayNamesFull[dayIndex]; // Get full day name
    dayLabelContainer.appendChild(dayNameLabel);
}

newCalendarNode.appendChild(dayLabelContainer);

// Right arrow for navigation
let rightArrow = document.createElement("div");
rightArrow.className = "button";
rightArrow.innerHTML = "<i class='fa-solid fa-chevron-right'></i>";
rightArrow.addEventListener("click", goToNextMonth);
newCalendarNode.appendChild(rightArrow);

// Days of the week (Mon, Tue, etc.)
const dayNames = ["M", "T", "W", "T", "F", "S", "S"];
dayNames.forEach((cellText) => {
    let cellNode = document.createElement("div");
    cellNode.className = "cell cell--unselectable";
    cellNode.innerText = cellText;
    newCalendarNode.appendChild(cellNode);
});

// Loop through the days of the month and render them
let days = getDaysArray(year, month);
days.forEach((cellText) => {
    let cellNode = document.createElement("div");
    cellNode.className = "cell";
    cellNode.innerText = cellText;

    if (cellText !== "") {
        // Clear any existing selected highlight
        if (cellText == day && year == selectedYear && month == selectedMonth) {
            cellNode.classList.add("selected-day");
            cellNode.classList.add("highlight"); // Apply highlight class
        }
        // Get today's date
      const today = new Date();
      const todayYear = today.getFullYear();
      const todayMonth = today.getMonth();
      const todayDay = today.getDate();

        // Highlight today's date
        if (cellText == todayDay && year == todayYear && month == todayMonth) {
          cellNode.classList.add("selected-day");
                cellNode.classList.add("highlight"); // Apply highlight class for today
            }

        // Add click listener for each day cell
        cellNode.addEventListener("click", () => {
            selectedDay = cellText;
            selectedMonth = month;
            selectedYear = year;

            // Format selected date as YYYY-MM-DD
            let selectedDate = `${year}-${String(month).padStart(2, '0')}-${String(cellText).padStart(2, '0')}`;
            console.log("Date clicked:", selectedDate);  // Debugging: Check if the date is correct

            // Fetch appointment data for the selected date
            getAppointmentCalender(selectedDate);

            // Re-render the calendar to update the highlighted date
            // renderDOM(selectedYear, selectedMonth, selectedDay);
        });
    }

    newCalendarNode.append(cellNode);
});

// Replace the existing calendar DOM with the new one
calendarNode.replaceWith(newCalendarNode);
calendarNode = document.querySelector("#calendar");
}


// Go to the previous month
function goToPrevMonth() {
    selectedMonth--;
    if (selectedMonth === 0) { // Move to the previous year if the month goes below 1
        selectedMonth = 12;
        selectedYear--;
    }
    console.log(`Navigating to: Year=${selectedYear}, Month=${selectedMonth}`);

    renderDOM(selectedYear, selectedMonth, selectedDay);
}

// Go to the next month
function goToNextMonth() {
    selectedMonth++;
    if (selectedMonth === 13) { // Move to the next year if the month exceeds 12
        selectedMonth = 1;
        selectedYear++;
    }
    console.log(`Navigating to: Year=${selectedYear}, Month=${selectedMonth}`);
    renderDOM(selectedYear, selectedMonth, selectedDay);
}



// Go to the current date
function goToCurrDate() {
    selectedYear = currYear;
    selectedMonth = currMonth;
    selectedDay = currDay;
    renderDOM(selectedYear, selectedMonth, selectedDay);
}
  </script>


  <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/dashboard/listing.blade.php ENDPATH**/ ?>