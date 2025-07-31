@extends('frontend.master')
@section('title', 'My Appointments')
@section('content')


<section class="details_wrapper">
    <div class="container">
        <div class="row">
            <div class="col-12 mb-3">
                <div class="web-card h-100 mb-3">
                    <div class="row">
                        <div class="col-sm-5 text-center text-sm-start">
                            <h4 class="mb-md-0">Appointments</h4>
                        </div>
                        <div class="col-sm-7 text-center text-sm-end">
                            <div class="btn_alignbox justify-content-sm-end">

                            </div>
                        </div>

                        <div class="col-lg-12 mb-3 mt-4">
                            <div class="table-responsive">
                                <table class="table table-hover table-white text-start w-100">
                                    <thead>
                                        <tr>

                                            <th>Consulting Doctor</th>
                                            <th>Appointment Date & Time</th>
                                            <th>Booked On</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @foreach ($appointments as $appointment )


                                        <tr>

                                            <td>
                                                <div class="user_inner">
                                                    <!-- <img src="{{ asset('frontend/images/drclark.png')}}"> -->
                                                    <div class="user_info">
                                                        <h6 class="primary fwt-bold m-0">{{$appointment->consultant->name ?? ''}}</h6>
                                                        <p class="m-0">{{$appointment->consultant->email??""}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{date('m/d/Y', strtotime($appointment->appointment_date)). " ,"}}{{date('h:i:A', strtotime($appointment->appointment_time))}} </td>
                                            <td>{{date('m/d/Y', strtotime($appointment->created_at)). " ,"}}{{date('h:i:A', strtotime($appointment->created_ats))}} </td>

                                            <td class="text-end">
                                                <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                                    <a class="opt-btn border-0"><img src="{{ asset('frontend/images/vediocam.png')}}"></a>
                                                    <a class="opt-btn border-0" onclick="notes('{{$appointment->appointment_uuid}}')" data-bs-toggle="modal" data-bs-dismiss="modal" data-bs-target="#appointmentNotes"><img src="{{ asset('frontend/images/file_alt.png')}}"></a>
                                                    <!-- <a class="opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="material-symbols-outlined">more_vert</span></a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a href="#" class="dropdown-item fwt-medium"><i class="fa-solid fa-pen me-2"></i>Edit Details</a></li>
                                                        <li><a href="#" class="dropdown-item fwt-medium"><i class="fa-solid fa-trash-can me-2"></i>Cancel Appointment</a></li>
                                                    </ul> -->
                                                </div>
                                            </td>
                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <!-- <div class="col-md-6">
                                    <div class="sort-sec">
                                        <p class="me-2 mb-0">Displaying per page :</p>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected="">10</option>
                                            <option value="1">9</option>
                                            <option value="2">8</option>
                                        </select>
                                    </div>
                                </div> -->
                                <div class="col-md-6">
                                    {{$appointments->links('pagination::bootstrap-5')}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Notes Modal-->

<div class="modal fade" id="appointmentNotes" tabindex="-1" aria-labelledby="appointmentNotesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="fw-bold mb-4" id="appointmentNotesLabel">Appointment Notes</h4>
                </div>
                <p id="appointmentNotesData">

                </p>
                <div class="btn_alignbox justify-content-end mt-4">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
            
        </div>
    </div>
</div>


<script>
    function notes(uuid) {
        var uuid = uuid;

        var url = "{{route('appointment.note')}}";

        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'uuid': uuid,
                '_token': $('input[name=_token]').val()
            },

            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    if (response.note && response.note.trim() !== '') {
                        $("#appointmentNotesData").html(response.note.replace(/\n/g, '<br>'));

                    } else {
                        $("#appointmentNotesData").text("No notes found!");

                    }
                }
            },
            error: function(xhr) {
                // Handle errors
                var errors = xhr.responseJSON.errors;
                if (errors) {
                    $.each(errors, function(key, value) {
                        console.log(value[0]); // Display first error message
                    });
                }
            },
        });

    }
</script>

@endsection()