<?php $__env->startSection('title', 'Notification'); ?>
<?php $__env->startSection('content'); ?>


<section id="content-wrapper">
                    <div class="container-fluid p-0">
                      <div class="row h-100">
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-lg-12 mb-3">
                              <div class="web-card h-100 mb-3">
                                <div class="row align-items-center">
                                    <div class="row align-items-center">
                                        <div class="col-lg-8 text-lg-start text-center mb-3">
                                          <h4 class="mb-0">Notifications</h4>
                                        </div>
                                        <div class="col-lg-4 text-lg-end text-center mb-3">
                                          <div class="btn_alignbox justify-content-lg-end">
                                            <a class="btn filter-btn" href="#" data-bs-toggle="dropdown" aria-expanded="false"><span class="material-symbols-outlined">filter_list</span>Filters</a>
                                            <div class="form-group filter_Box">
                                              <span class="material-symbols-outlined">keyboard_arrow_down</span>
                                              <select name="sort_filter" id="sort_filter" data-tabid="basic" class="form-select">
                                                <option value="all">Last 30 days</option>
                                              </select>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-12 mb-3 mt-4">
                                          <ul class="p-0">
                                            <li>
                                              <div class="or-divider"><p>Today</p></div>
                                            </li>
                                            <li> 
                                              <div class="ntfctn-dtls">
                                                <div class="d-flex">
                                                  <img src="<?php echo e(asset('images/patient1.png')); ?>" class="img-fluid">
                                                  <div class="ntfcn_inner ms-2">
                                                      <div>
                                                          <p><a class="primary">John Doe</a> is waiting in the reception room for 5 mins</p>
                                                            <div class="text-start pt-2">
                                                                <p class="light-gray">1 min</p>
                                                            </div>
                                                      </div>
                                                      <a href="" class="btn btn-primary"><span class="material-symbols-outlined"> videocam</span>Join Call</a>
                                                  </div>
                                              </div>
                                            </div>
                                            </li>
                                            <li> 
                                              <div class="ntfctn-dtls">
                                                <div class="d-flex">
                                                  <img src="<?php echo e(asset('images/patient2.png')); ?>" class="img-fluid">
                                                  <div class="ntfcn_inner ms-2">
                                                      <div>
                                                          <p><a class="primary">Alejandro González</a> has cancelled their appointment </p>
                                                            <div class="text-start pt-2">
                                                                <p class="light-gray">23 min</p>
                                                            </div>
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                            </li>
                                            <li>
                                              <div class="or-divider"><p>Yesterday</p></div>
                                            </li>
                                            <li> 
                                              <div class="ntfctn-dtls">
                                                <div class="d-flex">
                                                  <img src="<?php echo e(asset('images/patient3.png')); ?>" class="img-fluid">
                                                  <div class="ntfcn_inner ms-2">
                                                      <div>
                                                          <p><a class="primary">Luciana Suárez</a> has marked as unavailable for her time slots today</p>
                                                            <div class="text-start pt-2">
                                                                <p class="light-gray">23 Aug 2024</p>
                                                            </div>
                                                      </div>
                                                  </div>
                                              </div>
                                            </div>
                                            </li>
                                          </ul>
                                         
                                          
                                         
                                         
                                         
                                        </div>
                                      </div>

                                  
                               
                                  
                                  <div class="col-12">
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="sort-sec">
                                          <p class="me-2 mb-0">Displaying per page :</p>
                                          <select class="form-select" aria-label="Default select example">
                                             <option selected="">10</option>
                                             <option value="1">9</option>
                                             <option value="2">8</option>
                                          </select>
                                       </div>
                                      </div>
                                      <div class="col-md-6">
                                      <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                          <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Previous">
                                              <i class="fa-solid fa-angle-left"></i>
                                              Previous
                                            </a>
                                          </li>
                                          <li class="page-item active" aria-current="page"><a class="page-link" href="#">1</a></li>
                                          <li class="page-item"><a class="page-link" href="#">2</a></li>
                                          <li class="page-item"><a class="page-link" href="#">3</a></li>
                                          <li class="page-item">
                                            <a class="page-link" href="#" aria-label="Next">
                                              Next
                                              <i class="fa-solid fa-angle-right"></i>
                                            </a>
                                          </li>
                                        </ul>
                                      </nav>
                                      </div>

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


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\Xampp\htdocs\blackbag\resources\views/notification/listing.blade.php ENDPATH**/ ?>