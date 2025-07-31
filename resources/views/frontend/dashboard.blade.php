@extends('frontend.master')
@section('title', 'Dashboard')
@section('content')

<section class="details_wrapper">
    <div class="container">
        <div class="row g-4">
            <div class="col-12 col-xl-8 order-0 order-xl-0">
                <div class="row g-4"> 
                    <div class="col-12"> 
                        <div class="web-card min-h-auto dashboard-box position-relative overflow-hidden">
                            <div class="row align-items-center"> 
                                <div class="col-12 col-lg-5">
                                    <div class="user_inner user_inner_xl">
                                        <img @if($patientDetails['logo_path'] !='') src="{{$patientDetails['logo_path']}}" @else src="{{asset('images/default_img.png')}}" @endif class="img-fluid">
                                        <div class="user_info">
                                            <h6 class="gray fw-medium m-0">Welcome,</h6>
                                            <h4 class="m-0">{{$patientDetails['first_name']}} @if(($patientDetails['middle_name'] !='')){{ $patientDetails['middle_name'] }} @endif {{ $patientDetails['last_name'] }}</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1 d-lg-block d-none"> 
                                    <div class="vertical-gradient-line"></div>
                                </div>
                                <div class="col-12 col-lg-3 text-lg-start text-center mt-lg-0 mt-2">
                                    <h5 class="fwt-bold mb-1">{{$patientDetails['age']}} | {{ $patientDetails['gender'] == '1' ? 'Male' : ($patientDetails['gender'] == '2' ? 'Female' : 'Other') }}</h5>
                                </div>
                                <div class="col-12 col-lg-3">
                                    <div class="btn_alignbox justify-content-xl-end mt-xl-0 mt-3"> 
                                        <a href="javascript:void(0);" onclick="bookAppointment();" class="btn btn-primary">Book Appointment</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12"> 
                        <div class="web-card min-h-auto h-100">
                            <div class="text-start"> 
                                <h5 class="fw-bold mb-4">Upcoming Appointment</h5>
                            </div>

                            <div class="row g-3 align-items-center"> 
                                @if(!empty($upcomingAppointment))
                                    <div class="col-12 col-xl-4">
                                        <div class="user_inner user_inner_xl flex-column align-items-lg-baseline">
                                            <img src="{{$upcomingAppointment['clinic_logo']}}" class="img-fluid">
                                            <div class="user_info">
                                                <h5 class="fw-bold m-0">{{$upcomingAppointment['name']}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-8 border-l">
                                        <div class="row g-3 ps-xl-3">
                                            <div class="col-12 col-lg-6"> 
                                                <div class="d-flex flex-lg-row flex-column align-items-center gap-3"> 
                                                    <?php     
                                                        $corefunctions = new \App\customclasses\Corefunctions;
                                                        $image = $corefunctions -> resizeImageAWS($upcomingAppointment['consultant_id'],$upcomingAppointment['consultant']['profile_image'],$upcomingAppointment['consultant']['first_name'],180,180,'1');
                                                    ?>
                                                    <div class="text-lg-start text-center image-body">
                                                        <img @if($image !='') src="{{asset($image)}}" @else src="{{asset('images/default_img.png')}}" @endif class="user-img" alt="">
                                                    </div>
                                                    <div class="user_details text-lg-start text-center pe-lg-4">
                                                        <div class="innercard-info justify-content-center justify-content-lg-start flex-column align-items-start gap-1">
                                                            <h6 class="fw-bold m-0">@if(isset($upcomingAppointment['consultant_clinic_user']) && !empty($upcomingAppointment['consultant_clinic_user'])){{ $corefunctions -> showClinicanName($upcomingAppointment['consultant_clinic_user'],'1'); }} @endif</h6>
                                                            <p class="fw-medium mb-0">{{$upcomingAppointment['speciality']}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ( $upcomingAppointment['appointment_type_id'] == '1' && $upcomingAppointment['is_paid'] == '1' )
                                                <div class="col-12 col-lg-6"> 
                                                    <div class="btn_alignbox justify-content-lg-end"> 
                                                        <a target ="_blank" href="{{url('meet/'.$upcomingAppointment['appointment_uuid'])}}" class="btn btn-outline-primary">Join Call</a>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-12"> 
                                                <div class="border rounded-2 p-3"> 
                                                    <div class="row g-3"> 
                                                        <div class="col-12 col-lg-6"> 
                                                            <div class="d-flex align-items-center gap-2"> 
                                                                <div class="appointment-icon">
                                                                    <span class="material-symbols-outlined">calendar_month</span>
                                                                </div>
                                                                <h6 class="mb-0 fw-bold"><?php echo $corefunctions->timezoneChange($upcomingAppointment['appointment_date'],"M d, Y") ?></h6>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-6"> 
                                                            <div class="d-flex align-items-center gap-2">
                                                                <div class="appointment-icon">
                                                                    <span class="material-symbols-outlined">alarm</span>
                                                                </div>
                                                                <h6 class="mb-0 fw-bold"><?php echo $corefunctions->timezoneChange($upcomingAppointment['appointment_time'],'h:i A') ?></h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <div class="text-center"> 
                                            <img src="{{asset('frontend/images/nodata.png')}}" class="no-records-img">
                                            <p class="mb-0">No Appointments Yet</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12"> 
                        <!-- <div class="web-card min-h-auto h-100"> -->
                        <div class="web-card">
                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap"> 
                                <div> 
                                    <p class="mb-0">Blood Pressure</p>
                                    <h3 class="mb-0">@if(!empty($bpReadings)) {{$bpReadings['systolic']}}/{{$bpReadings['diastolic']}} @endif</h3>

                                </div>
                                <div class="border rounded-2 p-2" id="bp_rpm_icon" style="display:none"> 
                                    <img src="{{asset('frontend/images/tool3.png')}}" class="tool-img">
                                </div>
                            </div>
                            <div class="grap-container" style="height: 300px;"> 
                                <div id="bp_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                     <?php 
            $chats = ( isset($finalChats['chats']) ) ? $finalChats['chats'] : array();
            $lastChats = ( isset($finalChats['lastChats']) ) ? $finalChats['lastChats'] : array();
    $count = 1; ?>
                            @if( !empty($chats) )
                <p>Recent Chats</p>
                            @foreach( $chats as $ch)
                            <div class="col-12"> 

                                    <div class="chat-user-box @if( $count == 1) active @endif">
                                        <div class="row align-items-center" onclick="chatDetails('{{$ch['chat_uuid']}}')">
                                            <div class="col-9 col-sm-10">
                                                <div class="d-flex align-items-start gap-2 flex-grow-1">
                                                    <div class="flex-shrink-0 position-relative">
                                                        <img class="img-fluid chat-user" src="{{$ch['profile_image']}}" alt="user img">
                                                        
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h5 class="mb-1 fw-bold">{{$ch['user_name']}}</h5>
                                                     @if( !empty($lastChats) && isset($lastChats[$ch['id']]) )
                                                        <div class="d-flex gap-2">
                                                           
                                                            <p class="chat-text mb-0">{{$lastChats[$ch['id']]['message']}}</p>
                                                            <div class="d-flex align-items-center gap-1 flex-shrink-0">
                                                                <span class="time-dot"></span>
                                                                <p class="mb-0 light-gray">{{$lastChats[$ch['id']]['last_chat_time']}}</p>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            
                                         
                                        </div>
                                    </div>
                               
                            </div>
                            <?php $count++; ?>
                            @endforeach
                            @endif
            </div>
            <div class="col-12 col-xl-4 order-3 order-xl-1">
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
            <div class="col-12 col-xl-6 order-1 order-xl-2">
                <div class="web-card ">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap"> 
                        <div> 
                            <p class="mb-0">SpO2</p>
                            <h3 class="mb-0">@if(!empty($oxygenReadings)) {{$oxygenReadings['saturation']}}% @endif</h3>

                        </div>
                        <div class="border rounded-2 p-2" id="oxygen-saturations_rpm_icon" style="display:none"> 
                            <img src="{{asset('frontend/images/tool1.png')}}" class="tool-img">
                        </div>
                    </div>
                    <div class="grap-container" style="height: 300px;"> 
                        <div id="oxygen-saturations_chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-6 order-2 order-xl-3">
                <div class="web-card ">
                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap"> 
                        <div> 
                            <p class="mb-0">Blood Sugar Level</p>
                            <h3 class="mb-0">@if(!empty($glucoseReadings)) {{$glucoseReadings['bgvalue']}}mg/dL @endif</h3>

                        </div>
                        <div class="border rounded-2 p-2" id="glucose_rpm_icon" style="display:none"> 
                            <img src="{{asset('frontend/images/tool2.png')}}" class="tool-img">
                        </div>
                    </div>
                    <div class="grap-container" style="height: 300px;"> 
                        <div id="glucose_chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- Book appointment --}}

<div class="modal login-modal fade" id="book_appointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="append_appointmentdata">
                                    
            </div>
        </div>
    </div>
</div>

{{-- Book Doctor Appointment --}}

<div class="modal login-modal fade" id="doctor_appointment" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content overflow-visible">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="append_doctor_appointment">
                                          
            </div>
        </div>
    </div>
</div>

{{-- Appointment summary --}}

<div class="modal login-modal fade" id="appointment_summary" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body" id="append_summary">
                                            
            </div>
        </div>
    </div>
</div>

{{-- booking success --}}

<div class="modal login-modal fade" id="bookingSuccess" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center">
                <img src="{{asset('frontend/images/sucess.png')}}" class="img-fluid">
                <h4 class="text-center fw-bold mt-3 mb-1">Booking Confirmed</h4>
                <p class="gray fw-light mb-0">You can now meet the doctor at the allotted time</p>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>

<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>



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
    $(document).ready(function() {
        getGraphData('bp');
        getGraphData('glucose');
        getGraphData('oxygen-saturations');
        getAppointmentCalender();
        
        $('#bookingSuccess').on('hidden.bs.modal', function () {
            window.location.reload();
        });

    });

    function getGraphData(type){
        $.ajax({
            type: "POST",
            url: '{{ url("/getgraphdata") }}',
            data: {
                "type"      : type,
                '_token'    : $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    if(response.isrpm == 1){
                        $("#"+type+"_rpm_icon").show();
                    }
                    loadChart(type,response.labels, response.values);
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        });
    }
    function loadChart(type, labels, datasets) {
        const chartId = type + '_chart';

        setTimeout(() => {
            // Remove any previous chart instance
            if (Highcharts.charts) {
                Highcharts.charts.forEach(chart => {
                    if (chart && chart.renderTo.id === chartId) {
                        chart.destroy();
                    }
                });
            }

            // Reverse data for chronological order
            labels = labels.slice().reverse();
            datasets = datasets.slice().reverse();

            // Custom colors and marker shapes for up to 4 series
            const colors = ['#4285F4', '#EA4335', '#FFEB3B', '#000000'];
            const markerSymbols = ['circle', 'circle', 'square', 'triangle'];

            const legendLabelMap = {
                glucose: {
                    bgvalue: "Glucose",
                    a1c: "A1C"
                }
                // Add more types and field mappings as needed
            };

            // Prepare series for Highcharts
            let series = Object.keys(datasets[0] || {}).map((field, index) => ({
                name: (legendLabelMap[type] && legendLabelMap[type][field]) 
                        ? legendLabelMap[type][field] 
                        : field.charAt(0).toUpperCase() + field.slice(1),
                data: datasets.map(record => record[field] ?? null),
                color: colors[index % colors.length],
                marker: {
                    enabled: true,
                    radius: 4, // smaller marker
                    symbol: markerSymbols[index % markerSymbols.length],
                    lineColor: '#fff',
                    lineWidth: 1 // thinner border
                },
                lineWidth: 2, // thinner line
                states: {
                    hover: {
                        lineWidth: 3
                    }
                }
            }));

            // ✅ Dummy series to keep grid & axes visible when no data
            if (!series.length) {
                series = [{
                    name: 'No Data',
                    data: [null],
                    color: '#ccc',
                    showInLegend: false
                }];
            }

            // ✅ Calculate dynamic Y-axis range
            let yMin = 0;
            let yMax = 100 ;
            let tickInterval = 25;
            // ✅ If there is data, let Highcharts handle it automatically
            let hasData = datasets.length && datasets.some(record =>
                Object.values(record).some(v => v !== null)
            );

            if (hasData) {
                yMin = null;          // Highcharts decides automatically
                yMax = null;          // Highcharts decides automatically
                tickInterval = null;  // Highcharts decides automatically
            }


            // if (datasets.length) {
            //     const allValues = datasets.flatMap(record =>
            //         Object.values(record).filter(v => v !== null)
            //     );
            //     if (allValues.length) {
            //         yMax = Math.ceil(Math.max(...allValues) / 5) * 5 || 10;
            //         tickInterval = Math.max(1, Math.round(yMax / 5));
            //     }
            // }

            // ✅ No data text
            Highcharts.setOptions({
                lang: {
                    noData: "No data to display"
                }
            });

            const chart = Highcharts.chart(chartId, {
                chart: {
                    type: 'spline',
                    spacingLeft: 0,   // ✅ Removes chart left spacing
                    spacingRight: 0,
                    height: 350,
                    zoomType: 'x',
                    spacingBottom: 40,
                    style: { fontFamily: 'inherit' }
                },
                title: { text: null },
                xAxis: {
                    categories: labels,
                    title: { text: '' },
                    labels: {
                        rotation: -45, // already set, good for long dates
                        style: { fontSize: '13px' }, // increase if needed
                        // step: 2 // show every 2nd label, change as needed
                    },
                    tickmarkPlacement: 'on',
                    startOnTick: true,
                    endOnTick: true, 
                    minPadding: 0,           // ✅ Removes left-side padding
                    maxPadding: 0,

                    gridLineWidth: 1,
                    lineWidth: 1, // show X axis line
                    lineColor: '#333'
                },
                yAxis: {
                        title: { text: '' },
                        min: yMin,
                        max: yMax,
                        tickInterval: tickInterval,
                        gridLineWidth: 1,
                        gridLineColor: '#e6e6e6',
                        allowDecimals: false,
                        lineWidth: 1,
                        lineColor: '#333'
                    },
                tooltip: {
                    shared: true,
                    crosshairs: true,
                    valueDecimals: 0
                },
                legend: {
                    enabled: true,
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom',
                    floating: false,
                    backgroundColor: 'white',
                    borderWidth: 0,
                    itemStyle: {
                        fontWeight: 'bold',
                        fontSize: '10px',
                        color: '#333'
                    },
                    symbolHeight: 16,
                    symbolWidth: 24,
                    symbolRadius: 8,
                    itemMarginTop: 8,
                    itemMarginBottom: 8,
                    margin: 20
                },
                plotOptions: {
                    series: {
                        marker: {
                            enabled: true,
                            states: {
                                hover: {
                                    enabled: true,
                                    radius: 6 // slightly larger on hover
                                }
                            }
                        },
                        dataLabels: { enabled: false },
                        lineWidth: 2,
                        turboThreshold: 0 // show all points, even if many
                    },
                    line: {
                        enableMouseTracking: true
                    }
                },
                credits: { enabled: false }, // Remove Highcharts.com label
                series: series
            });

            // ✅ Show no-data message if all data points are null
            if (!datasets.length || series.every(s => !s.data || s.data.every(v => v === null))) {
                chart.showNoData();
            } else {
                chart.hideNoData();
            }

        }, 300);
    }

    function bookAppointment(){
        $("#doctor_appointment").modal('hide');
        $("#appointment_summary").modal('hide');
        $("#book_appointment").modal('show');
        showPreloader('append_appointmentdata');
        $.ajax({
            type: "POST",
            url: '{{ url("/patient/bookappointment") }}',
            data: {
                'formdata' : $("#formdata").val(),
                'clinicuseruuid' : $("#clinicuseruuid").val(),
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    $("#append_appointmentdata").html(response.view);
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

    function showTimeSlots(clinicUserUuid){
        $("#book_appointment").modal('hide');
        $("#doctor_appointment").modal('show');
        showPreloader('append_doctor_appointment');
        $.ajax({
            type: "POST",
            url: '{{ url("/patient/gettimeslots") }}',
            data: {
                'formdata' : $("#formdata").val(),
                'clinicUserUuid' : clinicUserUuid,
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                    $("#append_doctor_appointment").html(response.view);
                    $("#clinicuseruuid").val(clinicUserUuid);
                    initializeDateTimePicker();
                    $('input, textarea, select').each(function () {
                        toggleLabel(this);
                    });
                    $('.slot-btn').removeClass('active');
                    if($(".slot-btn").length > 0){
                        $("#timeslotbtn").removeAttr('disabled');
                    }else{
                        $("#timeslotbtn").prop('disabled',true);
                    }
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
    
    function initializeDateTimePicker(){
        // Initialize the date picker
        $('#appt-date').datetimepicker({
            format: 'MM/DD/YYYY',
            locale: 'en',
            useCurrent: true,
            minDate: moment.tz(userTimeZone).startOf('day'),
        }).on('dp.change', function(e) {
            $(this).trigger('change');
        });
    }
    
    function fetchAvailableSlots(){
        const selectedDate = $('#appt-date').val();
        const clinicuseruuid =  $("#clinicuseruuid").val();
        showPreloader('append_timeslots');
        if($(".slot-btn").length > 0){
            $("#timeslotbtn").prop('disabled',false);
        }else{
            $("#timeslotbtn").prop('disabled',true);
        }
        $.ajax({
            url: '{{ url("fetchavailableslots") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                clinicuseruuid: clinicuseruuid,
                appointmentdate: selectedDate
            },
            success: function(response) {
                if(response.success == 1){
                    $("#append_timeslots").html(response.view);
                    if($(".slot-btn").length > 0){
                        $("#timeslotbtn").removeAttr('disabled');
                    }else{
                        $("#timeslotbtn").prop('disabled',true);
                    }
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
        });
    }
    function confirmBooking(){
        $.ajax({
            url: '{{ url("confirmbooking") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                formdata: $("#formdata").val(),
            },
            success: function(response) {
                if(response.success == 1){
                    $("#appointment_summary").modal('hide');
                    $("#bookingSuccess").modal('show');
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
        });
    }




</script>

@endsection