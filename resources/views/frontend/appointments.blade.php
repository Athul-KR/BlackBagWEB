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

                        <div class="col-12">
                            <ul class="nav nav-pills mt-3 mb-3" id="pills-tab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="pills-home-tab"
                                        onclick="online('open')"
                                        data-url="{{route('frontend.myAppointments')}}" data-bs-toggle="pill"
                                        data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                                        aria-selected="true">
                                        Appointments</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" id="pills-notes-tab"
                                        onclick="getAppointmentMedicalHistory('notes')"
                                       data-bs-toggle="pill"
                                        data-bs-target="#pills-notes" type="button" role="tab" aria-controls="pills-notes"
                                        aria-selected="true">
                                        Notes</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="pills-tabContent">
                                <!-- Content here Online -->
                                <div id="online-content">

                                </div>

                            </div>
                            <div class="tab-content" id="pills-notes">
                                <!-- Content here Online -->
                                <div id="online-content">

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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center">
                    <h4 class="modal-title mb-3" id="appointmentNotesLabel">Appointment Notes</h4>
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
    function openSoapNotes(medicalnotekey) {
        if ($('.soapnotecls_'+medicalnotekey).hasClass('collapsed')) {
          return ;
        }
       showPreloader('appendsoapnotes_'+medicalnotekey);
     
       $.ajax({
           type: "POST",
           url: '{{ url("/notes/details") }}',
           data: {
               "medicalnotekey" : medicalnotekey,
               '_token'         : $('meta[name="csrf-token"]').attr('content')

           },
           success: function(response) {
               // Handle the successful response
               if(response.success == 1){
                    $("#listappendsoapnotes_"+medicalnotekey).html(response.view);
               }
               
           },
           error: function(xhr) {
               
               handleError(xhr);
           },
       })
   }


    
    function getAppointmentMedicalHistory(type,page=1) {
        $(".tab-content").hide();
        $("#pills-"+type).show();
       
        $('#pills-'+type).html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');
        $.ajax({
            type: "POST",
            url: '{{ url("/appointment/medicalhistory") }}',
            data: {
                "type": type,
                "view" :'patinet',
                "page":page,
               
                '_token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if(response.success == 1){
                  
                    $("#pills-"+type).html(response.view); 
                    $("#pagination-note a").on("click", function(e) {
                            e.preventDefault();
                            const newPage = $(this).attr("href").split("page=")[1];
                            getAppointmentMedicalHistory(type,newPage);
                        });
                }
            },
            error: function(xhr) {
                handleError(xhr);
            },
        })
    }

    $(document).ready(function () {
        var status = "{{ ($status) }}";
        console.log(status);

        if (status) {
            online(status);

        } else {
            online('open');
        }

    });


    //Listing the appointments based on the  type online and offline
    function online(status, page = 1, perPage = 10) {
       
    
        var clinickey = $('#clinic').val();
        var url = $('#pills-home-tab').attr('data-url');
        console.log('clinic'+clinickey);
        $('#online-content').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"></div>');

        $.ajax({
            type: "post",
            url: url,
            data: {
                'status': status,
                'page': page,
                'perPage': perPage,
                'clinickey' : clinickey,
                '_token': $('input[name=_token]').val()
            },
            success: function (response) {

                if (response.success == 1) {
                    $("#pills-"+type).show();
                    // Handle the successful response
                    $("#online-content").html(response.html);
                    $("#pagination-links").html(response.pagination); // Update pagination links

                    // Attach click event to pagination links
                    $("#pagination-links a").on("click", function(e) {
                        e.preventDefault();
                        const newPage = $(this).attr("href").split("page=")[1];
                        online(status, newPage);
                    });

                } else {
                    
                    swal(
                        "Error!",
                        response.message,
                        "success",
                    ).then(() => {
                        console.log(response);
                        window.location.href(response.redirect);

                    });
                }


            },
            error: function(xhr) {
            
                handleError(xhr);
            }
        })
    }
</script>



<script>
    function notes(uuid) {
        var uuid = uuid;

        var url = "{{route('appointment.note')}}";

        $('#appointmentNotesData').html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px" alt="Loader"></div>');

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

            success: function (response) {
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
               
                handleError(xhr);
            }
        });

    }
</script>

@endsection()