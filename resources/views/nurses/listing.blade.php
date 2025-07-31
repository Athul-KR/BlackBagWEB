@extends('layouts.app')
@section('title', 'Nurse List')
@section('content')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-12">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="web-card h-100 mb-3">
                            <div class="row">
                                <div class="col-sm-5 text-center text-sm-start">
                                    <h4 class="mb-md-0">Nurses</h4>
                                </div>
                                <div class="col-sm-7 text-center text-sm-end">
                                    <div class="btn_alignbox justify-content-sm-end">
                                    <?php
                                        $corefunctions = new \App\customclasses\Corefunctions;
                                        $isPermission = $corefunctions->checkPermission() ;
                                                    
                                    ?> 
                                        @if($isPermission == 1)
                                        <a href="#" id="nurse-create" class="btn btn-primary btn-align "
                                            data-bs-toggle="modal" data-nurse-create-url="{{route('nurse.create')}}"
                                            data-bs-dismiss="modal" data-bs-target="#addNurse">
                                            <span class="material-symbols-outlined">add </span>
                                            Add Nurse
                                        </a>
                                        @endif
                                        <div class="dropdown">
                                            <a class="btn filter-btn" href="#" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <span class="material-symbols-outlined">filter_list</span>
                                                Filters
                                            </a>
                                            <ul class="dropdown-menu filter_menu" aria-labelledby="dropdownMenuButton1">
                                                <li class=""><a
                                                        class="dropdown-item" aria-current="true" id="filter-avlble"
                                                        href="{{route('nurse.lists', ['status' => $status,'type'=>'available'])}}">Available</a>
                                                </li>
                                                <li class=""><a
                                                        class="dropdown-item" id="filter-notavlble"
                                                        href="{{route('nurse.lists', ['status' => $status,'type'=>'not-available'])}}">Not
                                                        Available</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="tab_box">

                                        <a href="{{route('nurse.lists', ['status' => 'pending','type'=>$type])}}"
                                            class="btn btn-tab {{ $status == 'pending' ? 'active' : '' }}">
                                            Pending ({{$pendingCount}})
                                        </a>

                                        <a href="{{route('nurse.lists', ['status' => 'active','type'=>$type])}}"
                                            class="btn btn-tab {{ $status == 'active' || $status == null ? 'active' : '' }}">
                                            Active ({{$activeCount}})
                                        </a>

                                        <a href="{{route('nurse.lists', ['status' => 'inactive','type'=>$type])}}"
                                            class="btn btn-tab {{ $status == 'inactive' ? 'active' : '' }}">
                                            Inactive ({{$inactiveCount}})
                                        </a>

                                    </div>
                                </div>



                                <div class="col-12 mb-3 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-white text-start w-100">
                                            <thead>
                                                <tr>
                                                    <th>Nurses</th>
                                                    <th>Specialty</th>
                                                    <th>Qualification</th>
                                                    <th>Department</th>
                                                    <th>Status</th>
<!--                                                    <th>Created By</th>-->
                                                    <!-- <th>Created On</th> -->
                                                    @if($isPermission == 1)
                                                    <th class="text-end">Actions</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>


                                                @forelse($nurses as $nurse)


                                                @php

                                                $corefunctions = new \App\customclasses\Corefunctions;

                                                $nurse['logo_path'] = ($nurse['logo_path'] != '') ? $corefunctions->getAWSFilePath($nurse['logo_path']) : asset('/images/default_img.png');

                                                @endphp


                                                <tr>

                                                    <td>

                                                        <div class="user_inner">
                                                            <!-- <img src="{{asset('images/nurse1.png')}}"> -->
                                                            <img src="{{asset($nurse['logo_path'])}}">

                                                            <div class="user_info">
                                                                <a @if ($status !=='inactive' )
                                                                    href="{{route('nurse.view', [$nurse->clinic_user_uuid,'type'=>'online'])}}">
                                                                    @endif
                                                                    <h6 class="primary fw-medium m-0">
                                                                        {{$nurse->name ?? 'N/A'}}
                                                                    </h6>
                                                                    <p class="m-0">{{$nurse->email ?? 'N/A'}}</p>
                                                                </a>

                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ optional($nurse->doctorSpecialty)->specialty_name ?? 'N/A' }}</td>
                                                    <td>{{$nurse->qualification ?? 'N/A'}}</td>
                                                    <td>{{ $nurse->department ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($nurse->status == -1)
                                                        <div class="pending-icon">
                                                            <span></span>Pending
                                                        </div>
                                                        @elseif($nurse->status == 0)
                                                        <div class="decline-icon">
                                                            <span></span>Declined
                                                        </div>
                                                        @else

                                                        @if ($nurse->login_status == 1)
                                                        <div class="avilable-icon">
                                                            <span></span>Available
                                                        </div>
                                                        @else
                                                        <div class="notavilable-icon">
                                                            <span></span>Not Available
                                                        </div>
                                                        @endif
                                                        @endif

                                                    </td>
<!--
                                                    <td>{{$nurse->creator->first_name . ' ' . $nurse->creator->last_name ?? 'N/A'}}
                                                        <p>
                                                            {{$nurse->created_at ?? 'N/A'}}
                                                        </p>
                                                    </td>
-->
                                                    <!-- <td></td> -->

                                                    <!-- Gear Icon -->
                                                    @if($isPermission == 1)
                                                    <td class="text-end">
                                                        <div class="d-flex align-items-center justify-content-end">
                                                            <a class="btn opt-btn" href="#" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <span class="material-symbols-outlined">more_vert</span>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">

                                                                @if ($status == 'active' || $status == 'pending')

                                                                <li>
                                                                    <a href="#" id="edit-nurse"
                                                                        data-nurseurl="{{route('nurse.edit', [$nurse->clinic_user_uuid, 'type' => $status])}}"
                                                                        data-bs-toggle="modal" data-bs-dismiss="modal"
                                                                        data-bs-target="#addNurse"
                                                                        class=" edit-nurse dropdown-item fw-medium ">
                                                                        <i class="fa-solid fa-pen me-2"></i>
                                                                        Edit
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" id="delete-nurse"
                                                                        data-nurseurl="{{route('nurse.delete', [$nurse->clinic_user_uuid])}}"
                                                                        class="detete-nurse dropdown-item fw-medium">
                                                                        <i class=" fa-solid fa-trash-can me-2"></i>
                                                                        Deactivate
                                                                    </a>
                                                                </li>
                                                                @if ($status == 'pending')
                                                                <li>
                                                                    <a href="#" id="resendInvite-nurse"
                                                                        data-nurseurl="{{route('nurse.resendInvitation', [$nurse->clinic_user_uuid])}}"
                                                                        class="resendInvite-nurse dropdown-item fw-medium">
                                                                        <i class=" fa-solid fa-paper-plane  me-2"></i>
                                                                        Resend Invitation
                                                                    </a>
                                                                </li>
                                                                @endif

                                                                @else
                                                                <li>
                                                                    <a href="#" id="activate-nurse"
                                                                        data-nurseurl="{{route('nurse.activate', [$nurse->clinic_user_uuid])}}"
                                                                        class="activate-nurse dropdown-item fw-medium">
                                                                        <i class="fa-solid fa-check primary me-2"></i>
                                                                        Activate Nurse
                                                                    </a>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </td>
                                                    @endif
                                                    <!-- End Gear Icon -->

                                                </tr>

                                                @empty
                                                <!-- No Data Found -->
                                                <tr class="text-center">
                                                    <td colspan="8">
                                                        <div class="flex justify-center">
                                                            <div class="text-center no-records-body">
                                                                <img src="{{asset('images/nodata.png')}}"
                                                                    class=" h-auto">
                                                                <p>No Nurses Yet</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <!-- End of No Data Found -->
                                                @endforelse

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Pagination -->
                                <div class="col-12">
                                    <div class="row">
                                        @if ($nurses->isNotEmpty())
                                        <div class="col-md-6">

                                            <form method="GET" action="{{ route('nurse.lists', [$status]) }}" autocomplete="off">
                                                <div class="sort-sec">
                                                    <p class="me-2 mb-0">Displaying per page :</p>
                                                    <select name="perPage" id="perPage"
                                                        class="form-select d-inline-block"
                                                        aria-label="Default select example"
                                                        onchange="this.form.submit()">
                                                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10
                                                        </option>
                                                        <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15
                                                        </option>
                                                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20
                                                        </option>
                                                    </select>
                                                </div>
                                            </form>

                                        </div>
                                        @endif
                                        <div class="col-md-6">
                                            {{ $nurses->links('pagination::bootstrap-5') }}
                                        </div>
                                    </div>
                                </div>
                                <!-- Pagination End -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- Nurse Create and Edit Modal -->
<div class="modal login-modal fade" id="addNurse" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">

            </div>
            <div id="add-nurse-modal" class="modal-body text-center">

                <!-- Appends Blade to this section -->

            </div>
        </div>
    </div>
</div>

<!-- Import Nurse Modal -->
<div class="modal login-modal fade" id="import_data" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
            </div>
            <div id="import-nurse-modal" class="modal-body">

                <!-- Appends Blade to this section -->

            </div>
        </div>
    </div>
</div>


<!-- Import Preview Modal -->
<div class="modal login-modal fade" id="import_preview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <!-- <a href="#" data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a> -->
            </div>
            <div class="modal-body" id="import_preview_modal"></div>
        </div>
    </div>
</div>


<script>
    var loaderGifUrl = "{{ asset('images/loader.gif') }}";
</script>
<!-- Creating Nurse -->
<script src="{{asset('js/nurseCreate.js')}}"></script>
<!-- Edit Nurse -->
<script src="{{asset('js/nurseEdit.js')}}"></script>
<!-- Activate and Deactivate Nurse -->
<script src="{{asset('js/nurseDeleteActivate.js')}}"></script>
<script>
    //Import Nurse
    $(document).on("click", "#nurse-import", function() {
        var url = $("#nurse-import").attr("data-nurse-import-url");

        $("#import-nurse-modal").html(
            '<div class="d-flex justify-content-center py-5"><img src="' +
            loaderGifUrl +
            '" width="250px"></div>'
        );


        $.ajax({
            type: "GET",
            url: url,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function(response) {
                // Populate form fields with the logger details

                if (response.status == 1) {
                    $("#import-nurse-modal").html(response.view);
                }
            },
            error: function(xhr) {
               
                handleError(xhr);
            },
        });


        $('#import_preview').on('hidden.bs.modal', function() {
            $('#import_preview_modal').empty(); // Clear the modal content
        });
        $('#import_data').on('hidden.bs.modal', function() {
            $('#import-nurse-modal').empty(); // Clear the modal content
        });

    });

    $(document).ready(function() {

        var status = "{{ ($status) }}";
        var type = "{{($type)}}";
        console.log(status + type);

        if (status && type) {
            online(type, status);

        } else {
            online('online', 'upcoming');
        }

    });
</script>

@endsection()