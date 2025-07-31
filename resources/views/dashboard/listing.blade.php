@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<section id="content-wrapper">
  <div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="appointmentToast" class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body">
          <div class="align_middle">
            <span class="material-symbols-outlined success-toast">info</span><p class="mb-0" id="appointmentToastBody"></p>
          </div>
        </div>
        <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        <div class="progress-bar-animated"></div>
      </div>
    </div>
  </div>
  <div class="container-fluid p-0">
    <div class="row">
      <!-- <div class="trialdivappend"> 
                    
      </div> -->
      <div class="col-12"> 
      
      @if($stripe_connected == '0' && $loginUserDetails['user_type_id'] == '1')
        <div class="remainder-container"> 
            <div class="row align-items-center">
                <div class="col-12 col-lg-9"> 
                  <p class="mb-0 white">Your account does not have a payment method connected. You can still create appointments and conduct them.
                    However, to receive automated payouts in your account, please connect your payment method</p>
                </div>
                <div class="col-12 col-lg-3"> 
                    <div class="btn_alignbox justify-content-end"> 
                        <a href="{{url('/profile#paymenttab')}}" class="btn btn-outline-primary">Connect Payment Method</a>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @if($isEprescribeEnabled == '1' && $eprescriberDets['onboarding_completed'] == '0')
        <div class="remainder-container"> 
            <div class="row align-items-center">
                <div class="col-12 col-lg-9"> 
                  <p class="mb-0 white">You’ve successfully enabled ePrescription. Please complete your onboarding steps to start prescribing.</p>
                </div>
                <div class="col-12 col-lg-3"> 
                    <div class="btn_alignbox justify-content-end"> 
                        <a href="javascript:void(0);" onclick="completeOnboarding();" class="btn btn-outline-primary">Complete Onboarding</a>
                    </div>
                </div>
            </div>
        </div>

        @endif

      </div>
      <div class="col-xl-8 col-12">
        <div class="row g-2">
          <div class="col-lg-12 mb-3">
            <div class="web-card threshhold-card p-0">
              <div class="row align-items-center">
                  <div class="col-sm-6 col-md-6 text-center text-sm-start mb-3 mb-sm-0">
                      <div class="welcome-body">
                        <h2>Welcome,</h2>
                        <h3 class="mb-0 primary">{{$userName}}</h3>
                        <h2 class="m-0">You have @if($todayAppointmentsCount == 0) no appointment @else <a href="{{url('appointments')}}" class="primary fw-medium"> {{$todayAppointmentsCount}} appointment(s) @endif</a>today.</h2>
                      </div>
                  </div>
                  <div class="col-sm-6 col-md-6 h-100 d-sm-flex align-items-end justify-content-end">
                     <img src="{{asset('images/Doctors-group.png')}}" class="img-fluid welcome-img">
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
                @if(!empty($appointmentDetails))
                  <a href="{{url('appointments')}}" class="link primary fw-medium text-decoration-underline">See All</a>
                @endif
                </div>
                <div class="col-12 mb-3 mt-4">
                  <div class="table-responsive">
                    <table class="table table-hover table-white text-start w-100">
                    <thead>
                      <tr>
                        <th style="width:30%">Patient</th>
                        <th style="width:20%">Email</th>
                        <th style="width:25%">Date & Time</th>
                        <th style="width:15%">Type</th>
                        <th class="text-end" style="width:10%">Actions</th>
                      </tr>
                    </thead>
                    <tbody id="appointment-tbody"  class="upcomingloader">
                    
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

  <div class="modal fade" id="onboardingModal" tabindex="-1" aria-labelledby="onboardingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-body">
          <div class="text-center">
          </div>
          <h5>Onboarding</h5>
          <iframe src="" width="100%" height="600px" frameborder="0"></iframe>
          <div class="btn_alignbox justify-content-end mt-4">
            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="cancellationmodal" tabindex="-1" aria-labelledby="cancellationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-body text-center p-4">

                <div class="swal-error-icon mb-2">
                   <span class="material-symbols-outlined">error</span>
                </div>

                <h4 class="mb-3 fw-bold">Are you sure you want to mark this appointment as Cancelled?</h4>

                <form id="cancellation_form" method="post" autocomplete="off">
                    @csrf

                    <!-- Checkbox -->
                    <div class="form-check d-flex justify-content-center mb-4">
                        <input class="form-check-input me-2" type="checkbox" value="1" checked id="collectCancellationFeeCheckbox" name="collect_cancellation_fee">
                        <p class="gray fw-light mb-0" for="collectCancellationFeeCheckbox">
                            Collect Cancellation Fee from patient.
                        </p>
                    </div>
                    <input type="hidden" name="appointmentuuid" id="appointmentuuid"/>

                    <!-- Buttons -->
                    <div class="btn_alignbox">
                        <button type="button" class="btn btn-outline-primary equal-width" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary equal-width" id="confirmCancelBtn" onclick="cancelAppointment();">Yes, I'm Sure</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

  <script>
  $(document).ready(function() {
      getAppointmentCalender();
      getAppointments();
  });  
  $('#onboardingModal').on('hidden.bs.modal', function () {
    window.location.reload();
  });
  
  function completeOnboarding(){
    $.ajax({
      type: "POST",
      url: "{{ URL::to('dosespot/completeonboarding') }}",
      data: {
        "_token": "{{ csrf_token() }}"
      },
      dataType: 'json',
      success: function(response) {
        if (response.success == 1) {
          $('#onboardingModal').modal('show');
          $('#onboardingModal iframe').attr('src', response.url);
        } else {
          swal({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred.'
          });
        }
      },
      error: function(xhr) {
        handleError(xhr);
      }
    });
  }
  function showCancellationModal(key){
    $("#cancellationmodal").modal('show');
    $("#appointmentuuid").val(key);
  }
  function cancelAppointment(){
    $("#confirmCancelBtn").text('Submitting....');
    $("#confirmCancelBtn").prop('disabled',true);
    $.ajax({
        type: "POST",
        url: "{{ URL::to('/appointments/cancelappointment') }}",
        data: {
            'formdata': $("#cancellation_form").serialize(),
            "_token": "{{ csrf_token() }}"
        },
        dataType: 'json'
    }).then(response => {
        if (response.success == 1) {
            $("#cancellationmodal").modal('hide');
            $('#appointmentToastBody').text(response.message);
            let toastElement = new bootstrap.Toast(document.getElementById('appointmentToast'));
            toastElement.show();
            setTimeout(() => window.location.reload(), 2000);
        } else {
            swal("Error!", response.errormsg, "error");
            $("#confirmCancelBtn").text("Yes, I'm Sure");
            $("#confirmCancelBtn").prop('disabled',false);
        }
    }).catch(xhr => {
        handleError(xhr);
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

 let isRequestProgress = false;
// Event listener with simplified approach for debugging
document.addEventListener("click", function(event) {
  
    if (event.target.classList.contains("cell--unselectable")) {
      console.log("Unselectable cell clicked:", event.target.innerText); // Debugging
      return; // Ignore the click for unselectable elements
    }
    // Check if a date cell is clicked
    if (event.target.classList.contains("cell") && event.target.innerText !== "") {
        console.log("Date cell clicked:", event.target.innerText);  // Debugging: Check cell click
        // If request is already in progress, ignore the click
        if (isRequestProgress) {
            console.log("Request is in progress, please wait...");
            return; // Exit the function if the request is still in progress
        }

        // Set the flag to true to indicate a request is in progress
        isRequestProgress = true;
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


    function getAppointmentCalender(selectedDate='') {
       console.log(selectedDate)
    // alert(selectedDate);2025-04-02
        showPreloader('calenderappd');
        $.ajax({
            type: "POST",
            url: '{{ url("/dashboard/appointment") }}',
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
            error: function(xhr) {
              if(xhr.status != 403){
                handleError(xhr);
              }
            },
            complete: function() {
                // Reset the flag to allow the request to be sent again
                isRequestProgress = false;
                
                console.log('Request complete');
            }
        })
    }

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
      const todayMonth = today.getMonth()+1;
      const todayDay = today.getDate();
        console.log(today);
        console.log(todayMonth);
        // Highlight today's date
        if (cellText == todayDay && year == todayYear && month == todayMonth) {
            console.log("eneter");
        
          cellNode.classList.add("selected-day");
          cellNode.classList.add("highlight-today"); // Apply highlight class for today
        }

        let currentDate = `${year}-${String(month).padStart(2, '0')}-${String(cellText).padStart(2, '0')}`;
        var appointmentDates = @json($appointmentDates);
        if (appointmentDates.includes(currentDate)) {
          // If the date is an appointment date, add a badge
          let badge = document.createElement("span");
          badge.className = "apt-day";
          cellNode.appendChild(badge);
          cellNode.classList.add("appointment-date");  // Optionally add a class for styling
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


  @stop