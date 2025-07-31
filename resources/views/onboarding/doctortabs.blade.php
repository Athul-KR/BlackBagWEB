    <div class="web-card m-h-auto mb-3"> 
        <div class="text-center">
            <h3 class="text-center mb-4 fw-bold">Doctor Onboarding</h3>
            <div class="stepper-wrapper doctor-stepper">
                @php
                    $activate = true;
                    $stepsCount =  1 ;
                    $licensed = session('user.licensed_practitioner') ;
                @endphp
                @if(!empty($onboardingSteps))
                    @foreach($onboardingSteps as $steps)
                            @if($steps['id'] == '1')
                              <?php  $steps['step'] = 'Contact Details' ;
                                $steps['slug'] = 'contact-details'; ?>
                            @endif
                            @php
                           
                            $isStep2 = $steps['id'] == 2;
                            $shouldHide = $isStep2 && !$licensed;
                           
                            $circleClass = '';
                            if ($activate && $steps['slug'] != $latestStep) {
                                $circleClass = 'active';
                            } elseif ($steps['slug'] == $latestStep) {
                                $circleClass = 'on-page';
                                $activate = false; // stop activating further steps
                            } else {
                                $activate = false;
                            }
                            $stepsNumber = ($steps['id'] == 2 && $licensed == 0 ) ? $steps['id'] : $stepsCount++ ;
                          
                        @endphp
                   
                    <div class="stepper steppercls {{ ($isStep2  && !$licensed)  ? 'd-none' : '' }} @if($licensed == 0) hidelinecls @endif" data-step="{{ $steps['id'] }}">
                        <div class="circle {{ $circleClass }}">{{$stepsNumber}}</div>
                        <p class="mt-2 mb-0">{{ $steps['step'] }}</p>
                    </div>

                   
                @endforeach
                @endif
            </div>
        </div>
    </div>