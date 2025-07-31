
<div class="d-flex justify-content-between align-items-center mt-5 mb-4">
    <h5 class="fwt-bold">{{$title}}</h5>
</div>


<div class="col-12 mb-3" id="datefilter"> 
    <div class="btn_alignbox justify-content-end position-relative"> 
        <div class="filter-box" >
            <input type="text" name="daterange" id="daterange" class="form-control daterange" style="width: 300px;" />
        </div>
    </div>
</div>



@include('appointment.charts.vitals-chart')



