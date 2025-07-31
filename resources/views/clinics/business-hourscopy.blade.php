<form method="post" id="business_hours_form" autocomplete="off">

    <div class="col-12">

        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Sunday</h6>
                <div class="form-check form-switch">
                    <input class="form-check-input isopen" type="checkbox" data-day="" value="1" id="" name="">
                </div>
            </div>
            <div class="col-5">

                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" value="" class="form-control start_time" id="" name="">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" value="" class="form-control end_time" id="" name="">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Monday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="mndy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="mndy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="mndy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Tuesday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="tuesdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="tuesdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="tuesdy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Wednesday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="wednsdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="wednsdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="wednsdy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Thursday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="thrsdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="thrsdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="thrsdy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Friday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="fridy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="fridy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="fridy_close">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Saturday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="satrdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="satrdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="satrdy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="btn_alignbox justify-content-end">
        <a data-bs-dismiss="modal" class="btn btn-outline-primary">Close</a>
        <button type="button" id="avail_submit" onclick="updateHours()" class="btn btn-primary">Save Changes</u>
    </div>


</form>

<script>
    $(document).ready(function () {

        $('#datepickerr').datetimepicker({
            format: 'hh:mm A',
            useCurrent: false, // Prevents setting current time by default
            stepping: 10
        });
        $('.isopen').each(function () {
            var checkbox = $(this);
            var day = checkbox.attr('data-day'); // Extract the day from the checkbox id
            var startTimeInput = $('#' + day + '_open'); // Find the related opening time input
            var endTimeInput = $('#' + day + '_close'); // Find the related closing time input

            // If the checkbox is checked on page load, enable the time inputs
            if (checkbox.prop('checked')) {

                startTimeInput.prop('disabled', false);
                endTimeInput.prop('disabled', false);

                // // Initialize time picker on change if checkbox is checked
                startTimeInput.datetimepicker({
                    format: 'hh:mm A',
                    useCurrent: false,
                    stepping: 10
                });

                endTimeInput.datetimepicker({
                    format: 'hh:mm A',
                    useCurrent: false,
                    stepping: 10
                });


            } else {
                startTimeInput.prop('disabled', true);
                endTimeInput.prop('disabled', true);
            }

            // Attach a change event to the checkbox
            checkbox.change(function () {
                if ($(this).prop('checked')) {
                    startTimeInput.prop('disabled', false);
                    endTimeInput.prop('disabled', false);


                    // Initialize time picker for start and end time inputs
                    startTimeInput.datetimepicker({
                        format: 'hh:mm A',
                        useCurrent: false, // Prevents setting current time by default
                        stepping: 10
                    });

                    endTimeInput.datetimepicker({
                        format: 'hh:mm A',
                        useCurrent: false,
                        stepping: 10
                    });



                } else {
                    startTimeInput.prop('disabled', true);
                    endTimeInput.prop('disabled', true);

                    //  // Destroy time picker if checkbox is unchecked
                    //  startTimeInput.datetimepicker('destroy');
                    // endTimeInput.datetimepicker('destroy');
                }
            });
        });







    })


    function updateHours() {
        var url = "{{route('clinic.businessHoursUpdate')}}";

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'formData': $('#business_hours_form').serialize(),
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);
                swal(
                    "Success!",
                    response.message,
                    response.status,
                ).then((e) => {
                    event.preventDefault();
                    // Refresh the page when the appointment clicks OK or closes the alert
                    console.log(response);
                    window.location.href = response.redirect;

                });
            },
            error: function (xhr, status, error) {
                if (xhr.status === 0) {
                    // Request was cancelled
                    console.log("Request was cancelled");
                } else {
                    swal(
                        "Error!",
                        "Error something went wrong",
                        "error"
                    );
                }
            },
        });
    }
</script>

<!-- <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Monday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="mndy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="mndy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="mndy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Tuesday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="tuesdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="tuesdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="tuesdy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Wednesday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="wednsdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="wednsdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="wednsdy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Thursday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="thrsdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="thrsdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="thrsdy_close">
                </div>
            </div>
        </div>
    </div>


    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Friday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="fridy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="fridy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="fridy_close">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="row align-items-center mb-3">
            <div class="col-2">
                <h6>Saturday</h6>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="satrdy_toggle">
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Opening TIme</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="satrdy_open">
                </div>
            </div>
            <div class="col-5">
                <div class="form-group form-outline">
                    <label for="input">Closing Time</label>
                    <i class="material-symbols-outlined">alarm</i>
                    <input type="text" class="form-control" id="satrdy_close">
                </div>
            </div>
        </div>
    </div> -->