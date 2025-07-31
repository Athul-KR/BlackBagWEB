
                                                            <div class="row align-row">
                                                                
                                                                <?php
                                                                $corefunctions = new \App\customclasses\Corefunctions;
                                                            ?>
                                                                <div class="col-md-4">
                                                                    <div class="collaspe-info">
                                                                        <small class="fw-light">Order Date</small>                                                                
                                                                        <p class="fw-medium"><?php echo $corefunctions->timezoneChange(orderLists['test_date'],"M d, Y") ?></p>                                                                
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="collaspe-info">
                                                                        <small class="fw-light">Ordered By</small>                                    
                                                                        <p class="fw-medium">@if(isset($orderLists['created_by']) && $orderLists['created_by'] != '' && !empty($userDetails)) {{$userDetails['first_name']}} {{$userDetails['last_name']}} @else -- @endif</p>  
                                                                        <small class="fw-light"><?php echo $corefunctions->timezoneChange($orderLists['created_at'],"m/d/y") ?>, <?php echo $corefunctions->timezoneChange($orderLists['created_at'],'h:i A') ?></small>                                                                
                                                                    </div>
                                                                </div>
                                                                
                                                            </div>
                                                        