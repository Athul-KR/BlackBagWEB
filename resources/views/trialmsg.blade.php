
@if( isset( $trialPlanInfo ) && isset( $trialPlanInfo['showTrialPlanMessage'] ) && ($trialPlanInfo['showTrialPlanMessage'] == '1') && isset($trialPlanInfo['trial_day_msg']))
<div class="col-12">
    <div class="subscription-exp trialdivappend">
        <p class="white mb-0">{{$trialPlanInfo['trial_day_msg']}}</p>
        <a href="{{url('subscriptions')}}" class="btn white-btn">Purchase subscription</a>
    </div>
</div>
@endif

