@extends('layouts.app')
@section('title', 'Users')
@section('content')
<section id="content-wrapper">
    <div class="container-fluid p-0">
        <div class="row h-100">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12 mb-3">
                        <div class="web-card h-100 mb-3">
                            <div class="row">
                                <div class="col-md-3 text-center text-md-start">
                                    <h4 class="mb-md-0">Revenue Reports</h4>
                                </div>
                                <?php
                                    $corefunctions = new \App\customclasses\Corefunctions;
                                    $isPermission = $corefunctions->checkPermission() ;
                                ?> 
                                <div class="col-md-9 text-center text-md-end mb-xl-0 mb-md-3">
                                    <div class="btn_alignbox justify-content-md-end flex-wrap">
                                        <a class="btn filter-btn"  onclick="getFilter()" ><span class="material-symbols-outlined">filter_list</span>Filters</a>
                                    </div>
                                </div>
                                <div class="col-12"> 
                                    <div id="patientfilter" class="collapse-filter">
                                        <form id="search" method="GET">
                                            <div class="align_middle w-100 flex-md-row flex-column justify-content-end mt-3 mb-4">
                                                <div class="form-group form-outline">
                                                    <label for="input" class="float-label">Start Date</label>
                                                    <i class="fa-solid fa-calendar"></i>
                                                    <input type="text" class="form-control paymentdate" name="start_date" id="start_date" @if(isset($_GET['start_date']) && $_GET['start_date'] !='') value="{{$_GET['start_date']}}" @endif>
                                                </div>
                                                <div class="form-group form-outline">
                                                    <label for="input" class="float-label">End Date</label>
                                                    <i class="fa-solid fa-calendar"></i>
                                                    <input type="text" class="form-control paymentdate" name="end_date" id="end_date" @if(isset($_GET['end_date']) && $_GET['end_date'] !='') value="{{$_GET['end_date']}}" @endif>
                                                </div>
                                                <div class="btn_alignbox d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary" onclick="submitFilter();">Submit</button>
                                                    <button type="button" class="btn btn-outline-primary" onclick="clearFilter();">Clear All</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3 mt-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-white text-start w-100">
                                            <thead>
                                                <tr>
                                                    <th style="width:15%">Receipt ID</th>
                                                    <th style="width:20%">Patient</th>
                                                    <th style="width:20%">Type</th>
                                                    <th style="width:15%">Amount</th>
                                                    <th style="width:20%">Payment Date & Time</th>
                                                    <th style="width:10%" class="text-end">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($reportData) > 0)
                                                    @foreach($reportData as $rd)
                                                        <?php 
                                                            $name = $rd->user->first_name ?? 'N/A';
                                                            $logo = !empty($rd->user->profile_image) 
                                                                ? $corefunctions->resizeImageAWS($rd->user->id, $rd->user->profile_image, $rd->user->first_name, 180, 180, '1') 
                                                                : asset('images/default_img.png');
                                                            $age = isset($rd->user->dob) ? $corefunctions -> calculateAge($rd->user->dob) : '';
                                                        ?>
                                                        <tr>
                                                            <td style="width:15%">{{ $rd->receipt_num }}</td>
                                                            <td style="width:20%">
                                                                <div class="user_inner">
                                                                    <img alt="Blackbag" @if($logo !='') src="<?php echo $logo ?>" @else src="{{asset('images/default_img.png')}}" @endif>
                                                                    <div class="user_info">
                                                                        <h6 class="primary fw-medium m-0">{{ $name ?? 'N/A' }}</h6>
                                                                        <p class="m-0">{{$age}} | @if( isset($rd->patientUser->gender)) {{ $rd->patientUser->gender == '1' ? 'Male' : ($rd->patientUser->gender == '2' ? 'Female' : 'Other') }} @endif</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td style="width:20%">{{ ucwords(str_replace('_', ' ', $rd->parent_type)) }}</td>
                                                            <td style="width:15%">$<?php echo number_format($rd->amount,2); ?></td>
                                                            <td style="width:20%"><?php echo $corefunctions->timezoneChange($rd->created_at,'M d, Y') ?> | <?php echo $corefunctions->timezoneChange($rd->created_at,'h:i A') ?></td>
                                                            <td class="text-end" style="width:10%">
                                                                <div class="d-flex align-items-center justify-content-end">
                                                                    <a class="btn opt-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                                                        <span class="material-symbols-outlined">more_vert</span>
                                                                    </a>
                                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                                        <li>
                                                                            <a href="{{url('receipt/'.$rd->payment_uuid.'/download')}}" class="dropdown-item fw-medium">
                                                                            <i class="fa-solid fa-download me-2"></i>Download Receipt
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a onclick="viewReceipt('{{$rd->payment_uuid}}')" class="dropdown-item fw-medium">
                                                                            <i class="fa-solid fa-eye me-2"></i>View Receipt
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr class="text-center">
                                                        <td colspan="8">
                                                            <div class="flex justify-center">
                                                                <div class="text-center no-records-body">
                                                                    <img src="{{asset('images/nodata.png')}}"
                                                                        class=" h-auto">
                                                                    <p>No records found</p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="row">
                                    @if(!empty($reportData))
                                        <div class="col-lg-6">
                                            <form method="GET" action="" >
                                                <div class="sort-sec">
                                                    <p class="me-2 mb-0">Displaying per page :</p>
                                                    <select class="form-select" aria-label="Default select example" name="limit" onchange="this.form.submit()">
                                                        <option value="10" {{ $limit == 10 ? 'selected' : '' }}>10</option>
                                                        <option value="15" {{ $limit == 15 ? 'selected' : '' }}>15</option>
                                                        <option value="20" {{ $limit == 20 ? 'selected' : '' }}>20</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="col-lg-6">
                                        {{ $reportData->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- View Receipt Modal -->
<div class="modal login-modal fade" id="viewreceipt_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header modal-bg p-0 position-relative">
                <a data-bs-dismiss="modal" aria-label="Close"><span class="material-symbols-outlined">close</span></a>
            </div>
            <div class="modal-body text-center" id="viewreceipt"></div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css')}}">
<script src="{{ asset('js/bootstrap-datetimepicker.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('.paymentdate').datepicker({
            maxDate:new Date()
        });
        $("#search").validate({
            ignore: [],
            rules: {
                start_date: {
                    required: true,
                },
                end_date: {
                    required: true,
                    greaterThanStart: true,
                },
            },
            messages: {
                start_date: {
                    required: "Please select start date.",
                },
                end_date: {
                    required: "Please select end date.",
                    greaterThanStart: "End date must be greater than or equal to start date.",
                },
            },
        });
    });  
    $.validator.addMethod("greaterThanStart", function (value, element) {
        const start = $('#start_date').val();
        if (!start || !value) return true;
        return new Date(value) >= new Date(start);
    }, "End date must be greater than or equal to start date.");

    function getFilter() {                  
        if ($("#patientfilter").hasClass("show")) {
            $("#patientfilter").removeClass('show')
            $("#patientfilter").hide();
        }else{
            
            $("#patientfilter").show();
            $("#patientfilter").addClass('show')
        }
    }
    function submitFilter(){
        if($("#search").valid()){
            $("#search").submit();
        }
    }
    function clearFilter() {
        window.location.href = "{{url('/reports')}}";
    }
    function viewReceipt(pkey) {
        $("#viewreceipt_modal").modal('show');
        $("#viewreceipt").html('<div class="d-flex justify-content-center py-5"><img src="{{ asset("images/loader.gif") }}" width="250px"  alt="Loader"  alt="Loader"></div>');
        $.ajax({
            type: "POST",
            url: "{{ URL::to('viewreceipt')}}",
            data:{ 
                'key': pkey,
                "_token": "{{ csrf_token() }}"
            },
            dataType : 'json',
            success: function(data) {
                if(data.success==1){
                    $("#viewreceipt").html(data.view);
                }
            },
            error: function(xhr) {  
                handleError(xhr);
            },
        });
    }
</script>

@stop
