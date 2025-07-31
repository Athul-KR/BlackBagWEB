    <div class="web-card m-h-auto mb-3"> 
        <div class="text-center">
            <h3 class="text-center mb-4 fw-bold">  @if(Session::has('user') && session()->get('user.userType') == 'doctor') Doctor @else Clinic @endif Onboarding</h3>
            <div class="stepper-wrapper">
                @php
                    $activate = true;
                    $stepsCount =  1 ;
                    $licensed = session('user.licensed_practitioner') ;
                @endphp
                @if(!empty($onboardingSteps))
                    @foreach($onboardingSteps as $steps)
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
                       
                    <div class="stepper {{ ($isStep2  && !$licensed)  ? 'd-none' : '' }}" data-step="{{ $steps['id'] }}">
                        <div class="circle {{ $circleClass }}">{{$stepsNumber}}</div>
                        <p class="mt-2 mb-0">{{ $steps['step'] }}</p>
                    </div>

                   
                @endforeach
                @endif
            </div>
        </div>
    </div>