
    <div class="row outer-wrapper box-cnt-inner">
        <div class="col-lg-12 my-3">
            <div class="table-responsive">
                <table class="table table-hover table-white text-start w-100">
                    <thead>
                        <tr>
                            <th>Test Date</th>
                            <th>Ordered By</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
        <?php 
            $corefunctions = new \App\customclasses\Corefunctions;
        ?>
                     @if(!empty($imagingLists['data']))
                    @foreach ($imagingLists['data'] as $orderList)
                  
                    <tr>
                       
                        <td>
                           <?php echo $corefunctions->timezoneChange($orderList['test_date'],"M d, Y") ?>
                        </td>
                        <td>                        
                          <p class="fw-medium">{{ $corefunctions -> showClinicanNameUser($userDetails[$orderList['created_by']],'0')}}</p>  
                            <small class="fw-light"><?php echo $corefunctions->timezoneChange($orderList['created_at'],"m/d/Y") ?>, <?php echo $corefunctions->timezoneChange($orderList['created_at'],'h:i A') ?></small>   
                        </td>
                        
                        

                            <td class="text-end">
                                <div class="d-flex align-items-center justify-content-end btn_alignbox">
                                    
                                
                                    <a class="btn opt-btn" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">

                                    
                                            <li>
                                                <a id="view-appointment" onclick="showImaginfPrintView('{{$orderList['imaging_test_uuid']}}')"  class="dropdown-item fw-medium">
                                                    <i class="fa-solid fa-eye me-2"></i>
                                                    View
                                                </a>
                                            </li>
                                            @if($orderList['created_by'] == Session::get('user.userID'))
                                            <li>
                                                <a id="" onclick="deleteImaging('{{$orderList['imaging_test_uuid']}}','list')" class="dropdown-item"><i class="fa-solid fa-trash-can me-2"></i><span>Delete</span></a>
                                            </li>
                                            @endif
                                            

                                    </ul>
                                </div>
                            </td>
                        </tr>

                        @endforeach

                        @else
                        <tr>
                            <td colspan="3" class="text-center">
                                <div class="flex justify-center">
                                    <div class="text-center no-records-body">
                                        <img alt="Blackbag" src="{{asset('images/nodata.png')}}"
                                            class=" h-auto">
                                        <p>No records found!</p>
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
            <div class="row justify-content-end">
                @if(!empty($imagingLists['data']))
                <div class="col-lg-6">
                    <div class="sort-sec">
                        <p class="me-2 mb-0">Displaying per page :</p>
                        <select name="perPage" id="perPage" class="form-select d-inline-block" aria-label="Default select example" onchange="perPage()">
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="15" {{ $perPage == 15 ? 'selected' : '' }}>15</option>
                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        </select>
                    </div>
                </div>
                @endif
                <div class="col-lg-6">
                    <div id="pagination-links">
                        {{ $imagingListsArray->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>   
    <script>
        $(document).ready(function() {
            //Pagination through ajax - pass the url
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                const pageUrl = $(this).attr('href');
                const urlObj = new URL(pageUrl); // Create a URL object
                var page = urlObj.searchParams.get('page');
                getAppointmentMedicalHistory('imaging',page)
            });
        });
    </script>
    

                                                
                                                

