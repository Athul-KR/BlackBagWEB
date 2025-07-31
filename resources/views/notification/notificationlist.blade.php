<div class="d-flex align-items-center justify-content-between py-2 px-2 mx-2 mb-2">
  <h4 class="fw-medium primary">Notifications </h4>
     @if(!empty($notificationDetails))
      <a onclick="clearNotification();" class="gray" data-bs-dismiss="modal" aria-label="Close"><small>Clear All</small></a>@endif
</div>
                        
@if(!empty($notificationDetails))
@foreach($notificationDetails as $ntls => $ntd )
@if(isset($ntd['notificationMessage']) && $ntd['notificationMessage'] !='')
  <li @if($ntd['is_read'] =='0') class="unread"  @else class="notftn-read"  @endif>
    <a onclick="markAsRead('{{$ntd['notificationkey']}}')" >
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex w-99">
          <img src="{{ $ntd['notify_user_img']}}" class="img-fluid rounded-circle">
            <div class="ntfcn_inner ms-2">
              <div class=""> 
                <small><?php echo $ntd['notificationMessage'] ?>@if(isset($ntd['username']) && $ntd['username'] !='') <span class="primary">({{$ntd['username']}})</span>  @endif </small>
                <div class="text-start pt-2">
                  <span data-time="{{($ntd['notificationdate'])}}" data-time-format="MMMM DD YYYY hh:mm A" class="gray"></span>
                </div>
              </div>
            </div>
        </div>
        <span class="unread-icon"></span>
        <span class="read-icon"></span>
      </div>

    </a>
  </li>
@endif
@endforeach
@else
  <div class="flex justify-center">
      <div class="text-center no-records-body notfction-norecord">
          <img src="{{asset('images/nodata.png')}}"class=" h-auto"><p>No records found</p>
      </div>
    </div>
@endif
@if($notificationCount > 10)
  <li class="py-0 border-bottom-0">
    <div class="text-center w-100" id="view-notf" style="display: block;">
      <a class="view-more-btn primary fw-medium" href="{{url('notifications')}}">View All</a>
    </div>
  </li>
@endif

      <script>

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

                      swal({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            buttons: false,
                            timer: 2000 // Closes after 2 seconds
                        }).then(() => {
                          window.location.reload();
                        });


                      // swal("Success!", response.message, "success");
                      // setTimeout(function(){ window.location.reload(); },1000);
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