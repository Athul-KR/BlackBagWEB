<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
<style>
    td {
        color: #828282 !important;
        padding: 10px !important;
        font-size: 0.875rem;
    }
    .active>.page-link, .page-link.active {
        background: #181818 !important;
        border-color: #181818 !important;
        color: #fff !important;
    }
    .page-link {
        color: #181818 !important;
    }
    th {
        background: #181818 !important;
        color: #fff !important;
        padding:10px !important
    }
    pre {
        white-space: break-spaces;
        word-break: break-word;
    }
</style>



<div class="container my-5">
<div class="d-flex justify-content-end mb-3">
    <form method="GET" action="{{ url()->current() }}" id="filterForm" class="d-flex">
        <label for="filterType" class="me-2 align-self-center">Filter:</label>
        <select name="type" onchange="document.getElementById('filterForm').submit()" class="form-select" style="width: 180px;">
            <option value="" {{ $type == '' ? 'selected' : '' }}>All</option>
            <option value="e" {{ $type == 'e' ? 'selected' : '' }}>ePrescribe</option>
            <option value="r" {{ $type == 'r' ? 'selected' : '' }}>RPM</option>
        </select>
    </form>
</div>
    <div class="row">
        <div class="col-12">
               <h3 class="mb-3">Webhooks</h3>
    <table class="table table-hover" border="1" cellspacing="0">
 
    <thead>
        <tr>
            <th width="10%">ID</th>
            <th width="15%">Webhook Type</th>
            <th width="40%">Event Details</th>
            <th width="20%">Event Type</th>
            <th width="15%">Created At</th>
        </tr>
    </thead>
    <tbody>
       @foreach ($webhooks as $wb)
        <?php 
        
       
        
        ?>
            <tr>
                <td>{{$wb->id}}</td>
              <td>
                  <?php if($wb->type !='' ){
                    $typeName  = ( $wb->type  == 'e' ) ? 'ePrescribe' : 'RPM';
                        echo $typeName;
                        
                    }?></td>
                <td>
                    <p>
                    <?php
                    $unserialized = '';
                    if (!empty($wb->inputdata) && is_string($wb->inputdata)) {
                        $unserialized = @unserialize($wb->inputdata);
                        if ($unserialized !== false || $wb->inputdata === 'b:0;') {
                            echo '<pre>';
                            print_r($unserialized);
                            echo '</pre>';
                        } else {
                            //echo "Invalid serialized data.";
                        }
                    } ?>
                        </p>
                </td>
                <td>
                <?php 
                    if( $unserialized != '' && $unserialized !== false || $wb->inputdata === 'b:0;'){
                        if(  $wb->type  == 'e' ){
                            $eventType = ( isset($unserialized['EventType']) ) ? $unserialized['EventType'] : '';
                        }else{
                            $eventType = ( isset($unserialized['status']) ) ? $unserialized['status'] :  '';
                        }
                    }?>
                    {{$eventType}}
                </td>
                <td>@if( $wb->created_at !='' ) {{date('m/d/y H:i:s',strtotime($wb->created_at))}} @endif</td>
            </tr>
        <?php endforeach; ?>
        
          @if ($webhooks->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center">
                           <p>No Records Found</p>
                        </td>
                    </tr>
                    @endif
    </tbody>
</table>

  <div class="col-md-12 mt-3"  id="pagination-links">
            {{ $webhooks->links('pagination::bootstrap-5') }}
        </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>