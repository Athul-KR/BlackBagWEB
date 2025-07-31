@extends('layouts.app')
@section('title', 'Doctors')
@section('content')

<section id="content-wrapper">
  <div class="container-fluid p-0">
    <div class="row h-100">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12 mb-3">
            <div class="web-card h-100 mb-3">
              <div class="row">
                <div class="col-sm-5 text-center text-sm-start">
                  <h4 class="mb-md-0">Global Search</h4>
                </div>
                <div class="col-lg-12 mb-3 mt-4">
                  <div class="table-responsive global-list-wrapper">
                    <table class="table table-hover table-white text-start w-100">
                      <thead>
                        <tr>
                          <th style="width:20%">Name</th>
                          <th style="width:10%">Type</th>
                          <th style="width:15%">Phone Number</th>
                          <th style="width:10%">Department</th>
                          <th style="width:10%">Designation</th>
                          <th style="width:20%">Specialty</th>
                        </tr>
                      </thead>
                      <tbody class="append_admin_global_search">
                      </tbody>
                    </table>
                  </div>
                </div>
               
              </div>
            </div>
          </div>
          <input type="hidden" name="send_ajax_search" id="send_ajax_search" value="1">
          <input type="hidden" name="last_searchid" id="last_searchid" value="0">
        </div>
      </div>
    </div>
  </div>
</section>
<script>

$(document).ready(function(){

    var searchterm = "{{$searchValue}}";
    globalSearchAjax(searchterm);

    $(window).on('scroll', function() {
               
        if(parseInt($(window).scrollTop() + $(window).height() + 1) >= parseInt($(document).height())) {
                //if ($.trim($("#hasData").val()) == 1) {
            var sendAJAX =$("#send_ajax_search").val();
            globalSearchAjax(searchterm,sendAJAX,'1');
                //}
            }
               
               
       });
});

</script>

@stop
