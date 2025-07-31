@if(!empty($medicathistoryDetails))
<?php $corefunctions = new \App\customclasses\Corefunctions; ?>
    <form method="POST" id="editsaturationform" autocomplete="off">
        @csrf
        <div class="row align-items-start"> 
            <div class="col-md-10"> 
                <div class="row"> 
                    <div class="col-md-4"> 
                        <div class="history-box mb-md-0 mb-3"> 
                            <div class="form-group form-outline editsaturationclserr">
                                <label class="float-label">Saturation %</label>
                                <input type="text" class="form-control editsaturationcls" name="editsaturation" value="{{$medicathistoryDetails['saturation']}}" placeholder="">
                            </div> 
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="history-box"> 
                            <div class="form-group form-outline">
                                <label class="float-label">Report Date</label>
                                <input type="text" class="form-control editreportdate" id="editreportdate" name="editreportdate" @if($medicathistoryDetails['reportdate'] != '') value="<?php echo $corefunctions->timezoneChange($medicathistoryDetails['reportdate'], 'm/d/Y'); ?>" @endif>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="history-box"> 
                            <div class="form-group form-outline reporttimeclserr">
                                <label class="float-label">Report Time</label>
                                <input type="text" class="form-control editreporttime editreporttimecls" id="editreporttime" name="editreporttime" @if($medicathistoryDetails['reporttime'] != '') value="{{ $corefunctions->timezoneChange($medicathistoryDetails['reporttime'], 'h:i A') }}" @endif>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="sourcetype" id="sourcetype" @if(Session::get('user.userType') == 'patient') value="2" @else value="3" @endif />
                </div>
            </div>
            <div class="col-md-2"> 
                <div class="btn_alignbox justify-content-end">
                    <a class="opt-btn" onclick="updateSaturationForm('oxygen-saturations','{{$medicathistoryDetails['oxygen_saturation_uuid']}}')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">check</span></a><a class="opt-btn danger-icon" href="#" onclick="getmedicalhistoryData('oxygen-saturations')" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined success">close</span></a>
                </div>
            </div>
        </div>
    </form>
@endif
<script>
          var now = moment(); // Get current time

        // Date Picker
        $('.editreportdate').datetimepicker({
            format: 'MM/DD/YYYY',
            useCurrent: false,
            maxDate: moment().endOf('day') // Ensures today is selectable
        }).on('dp.change', function (e) {

            var selectedDate = e.date; // Get selected date
            var timePicker = $('.editreporttime').data("DateTimePicker");
            if (selectedDate) {
                var isToday = selectedDate.isSame(moment(), 'day'); // Check if selected date is today
                
                if (isToday) {
                timePicker.maxDate(moment()); // Restrict time selection to past & present for today
                    
                    var selectedTime = moment($('.editreporttime').val(), 'hh:mm A'); // Get currently selected time

                    if (selectedTime.isAfter(moment())) {
                        $('.editreporttime').val(''); // Clear time input if it's in the future
                        $('input, textarea').each(function () {
                            // toggleLabel(this);
                        });
                    }
                } else {
                    timePicker.maxDate(false); // Allow all times for past dates
                }
            }
        });

       
        // Time Picker
        $('.editreporttime').datetimepicker({
            format: 'hh:mm A',
            locale: 'en',
            useCurrent: false,
            stepping: 5,
        }).on('dp.show', function () { // Ensure time restriction applies when the picker opens
            var selectedDate = $('.editreportdate').data("DateTimePicker").date();
            var timePicker = $(this).data("DateTimePicker");

            if (selectedDate && selectedDate.isSame(moment(), 'day')) {
                timePicker.maxDate(moment()); // Restrict to past & present times only
            } else {
                timePicker.maxDate(false); // No restrictions for past dates
            }
        });
    // $('.editreportdate').datetimepicker({
    //     format: 'MM/DD/YYYY',
    //     useCurrent: false, 
    //     maxDate: moment().endOf('day'), // Ensures today is selectable
    // });

    // $('.editreporttime').datetimepicker({
    //     format: 'hh:mm A',
    //     locale: 'en',
    //     useCurrent: false, // Prevents setting current time by default
    //     stepping: 5, // Optional: sets the minute interval (5 minutes in this case)
    //     timeZone: userTimeZone
    // });
    $(document).ready(function () {
        function toggleLabel(input) {
            const $input = $(input);
            const value = $input.val();
            const hasValue = value !== null && value.trim() !== ''; // Check for a non-empty value
            const isFocused = $input.is(':focus');

            // Ensure .float-label is correctly selected relative to the input
            $input.siblings('.float-label').toggleClass('active', hasValue || isFocused);
        }

        // Initialize all inputs on page load
        $('input, textarea').each(function () {
            toggleLabel(this);
        });

        // Handle input events
        $(document).on('focus blur input change', 'input, textarea', function () {
            toggleLabel(this);
        });

        // Handle dynamic updates (e.g., Datepicker)
        $(document).on('dp.change', function (e) {
            const input = $(e.target).find('input, textarea');
            if (input.length > 0) {
                toggleLabel(input[0]);
            }
        });
    });
</script>
