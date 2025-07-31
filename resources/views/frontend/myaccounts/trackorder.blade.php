
  <div class="track-order-container border rounded-4 p-4 text-start">
    <div class="row">
      <!-- Left Column -->
      <div class="col-md-12 mb-3">
        <span class="label fw-semibold">Tracking Details:</span><br>
          <span>{{$tracking_number}}</span>
</div>
        <div class="col-md-12 mb-3">
          <span class="label fw-semibold">Devices:</span><br>
          <span><?php echo nl2br($devices);?></span>
        </div>

        <div class="col-md-6 mb-3">
          <span class="label fw-semibold">Ordered By:</span>
          <div class="user_inner mt-2 d-flex align-items-center">
            @if(isset($created_image))
              <img src="{{ $created_image }}" alt="User Image" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
            @endif
            <div class="user_info">
              @if(isset($created_by))
                <h6 class="fw-bold m-0">{{ $created_by }}</h6>
              @endif
            </div>
          </div>
        </div>
      

      <!-- Right Column -->
      <div class="col-md-6">
        <span class="label fw-semibold">Ordered On:</span>
        <div class="d-flex mt-2 align-items-center">
            <h6 class="fw-bold mb-0">{{ $ordered_date }}</h6>
                <span class="px-1">|</span>
            <h6 class="fw-bold mb-0">{{ $ordered_time }}</h6>
              </div>
      </div>
    </div>
  </div>
