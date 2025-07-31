@extends('layouts.app')
@section('title', 'Notification')
@section('content')


<section id="content-wrapper">
                    <div class="container-fluid p-0">
                      <div class="row h-100">
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-lg-12 mb-lg-5 mb-4">
                              <div class="web-card h-100">
                          
                                    <div class="row align-items-start">
                                        <div class="col-lg-8 text-lg-start text-center mb-3">
                                          <h4 class="mb-0">Notifications</h4>
                                        </div>
                                       
                                        <div class="col-lg-4 text-lg-end text-center mb-3">
                                          <div class="btn_alignbox justify-content-lg-end">
                                            <button type="button" class="btn btn-outline-primary ms-2" onclick="clearNotification();">Clear All</button>
                                            <div class="form-group filter_Box">
                                              <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                              <form id="search" method="GET">
                                              <select name="filterby" id="sort_filter" data-tabid="basic" class="form-select" onchange="filterBy()">
                                                <option value="all"  @if( (isset($_GET['filterby']) ) && $_GET['filterby']==  'all' ) selected @endif>Last 30 days</option>
                                                <option value="week"  @if( (isset($_GET['filterby']) ) && $_GET['filterby']==  'week' ) selected @endif>Last Week</option>
                                                <option value="today"  @if( (isset($_GET['filterby']) ) && $_GET['filterby']==  'today' ) selected @endif>Today</option>
                                              </select>
                                              <form>
                                            </div>
                                          </div>
                                        </div>
                                        <?php
                                          $corefunctions = new \App\customclasses\Corefunctions;
                                        ?>
                                        <div class="col-12 my-3">
                                          <ul class="notfcn-listing p-0">
                                            @foreach(['Today', 'Yesterday', 'Older'] as $section)
                                            @if(!empty($groupedNotifications[$section]))
                                            <li>
                                              <div class="or-divider"><p>{{ $section }}</p></div>
                                            </li>
                                            @foreach($groupedNotifications[$section] as $notification)
                                            @if(isset($notification['notificationMessage']) && $notification['notificationMessage'] !='')
                                            <li @if($notification['is_read'] =='0') class="unread" @else class="notftn-read" @endif> 
                                              <a onclick="markAsRead('{{$notification['notificationkey']}}')" >
                                                <div class="ntfctn-dtls d-flex justify-content-between align-items-center">
                                                    <div class="user_inner">
                                                      <img src="{{$notification['notify_user_img']}}" class="img-fluid">
                                                      <div class="user_info notifs-label">
                                                        <p class="primary mb-0"><?php echo $notification['notificationMessage'] ?> </p> @if(isset($notification['username']) && $notification['username'] !='')<p class="primary mb-0">{{$notification['username']}}</p>@endif
                                                        <small class="light-gray mb-0"> 
                                                        <?php echo $corefunctions->timezoneChange($notification['created_at'],"M d, Y") ?> | <?php echo $corefunctions->timezoneChange($notification['created_at'],"h:i A") ?>
                                                        </small>
                                                      </div>
                                                  </div>
                                                  <span class="unread-icon"></span>
                                                  <span class="read-icon"></span>
                                              </div>
                                              </a>
                                            </li>
                                            @endif
                                            @endforeach
                                            @endif
                                          @endforeach

                                          @if(empty($groupedNotifications))
                                          <tr class="text-center">
                                              <td colspan="8">
                                                  <div class="flex justify-center">
                                                      <div class="text-center no-records-body">
                                                          <img class="" src="{{asset('images/nodata.png')}}"
                                                              class=" h-auto">
                                                          <p>No records found</p>
                                                      </div>
                                                  </div>
                                              </td>
                                          </tr>
                                          @endif

                                           


                                          </ul>
                                         
                                          
                                         
                                         
                                         
                                        </div>
                                      </div>

                                  
                               
                                  
                                  <div class="col-12">
                                    <div class="row">
                                    @if(!empty($groupedNotifications))
                                      <div class="col-xl-3">
                                      <form method="GET" action="{{url('notifications/')}}" >
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
                                      <div class="col-xl-9">
                                          {{ $notificationDetails->links('pagination::bootstrap-5') }}
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

<script>
  
  function filterBy() {
    $("#search").submit();
  }
  function clearNotification(){
    swal("Are you sure you want to clear all notifications ?", {
      title: "",
      icon: "warning",
      buttons: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          type: "POST",
          url: '{{ url("/notifications/clearall") }}',
          data: {
            '_token': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            // Handle the successful response
            if(response.success == 1){
              swal("Success!", response.message, "success");
              setTimeout(function(){ window.location.reload(); },1000);
            }
          },
          error: function(xhr) {
               
            handleError(xhr);
            },
        })
      }
    });
  }

  </script>
@stop