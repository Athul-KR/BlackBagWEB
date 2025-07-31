@extends('emails.emailheader')
@section('content')
    <tr>
        <td colspan="2">
            <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
                <tr>
                    <td>
                        <?php if( $has_card == 1 && $subscription_plan_id == $renewal_plan_id){ ?>
                            <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Renewal Reminder – Your BlackBag Subscription<br></h1>
                        <?php }elseif( $has_card == 1 && $subscription_plan_id != $renewal_plan_id){ ?>
                            <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Renewal Reminder – Subscription Plan Update<br></h1>
                        <?php }else{ ?>
                            <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Action Required – BlackBag Trial Expiring Soon<br></h1>
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td style="text-align: left;">
                        <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">
                            Hi {{ trim($first_name.' '. $last_name) }},
                        </h5>
                        
                        <?php
                            $message1 = $message2 = $message3 = '';
                        
                            if ($has_card == 1) {
                                $message1 = ($subscription_plan_id == $renewal_plan_id) ? 
                                    "Your BlackBag trial plan is ending on $renewal_date. Your card will be automatically charged $amount for the Premium subscription plan on $renewal_date." : "Your trial plan is ending on $renewal_date. Your card will be automatically charged $amount for the $renewal_planname subscription plan on $renewal_date";
                                $message2 = ($subscription_plan_id == $renewal_plan_id) ? 
                                    "If you do not wish to continue with this plan, you can downgrade to another plan or switch to the Basic Plan before the renewal date." : "If you would like to select a different subscription, please log in to BlackBag and update your plan before the renewal.";
                            } else {
                                $message1 = "Your BlackBag trial plan is set to expire on $renewal_date. After this date, your account will be locked, and you will no longer have access to BlackBag.";
                                $message2 = "To continue using BlackBag without interruption, please add your billing details and complete your payment.";
                                $message3 = "Let us know if you need any assistance!";
                            }
                        ?>

                        <p style="color:#7b7b7b; font-size:15px; line-height: 29px; margin-top: 20px; margin-bottom: 20px;">{{$message1}}</p>
                        <p style="color:#7b7b7b; font-size:15px; line-height: 29px;">{{$message2}}</p>
                        @if($message3 != '')
                        <p style="color:#7b7b7b; font-size:15px; line-height: 29px;">{{$message3}}</p>
                        @endif
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: left; padding-top: 30px;">
            <p style="margin:0;">Thank You,</p>
            <h4 style="margin:0;">BlackBag</h4>
        </td>
    </tr>
@include('emails.emailfooter')
@stop