@extends('emails.emailheader')
@section('content')
<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Your Payment Receipt for {{$subscriptionsDetails['plan_name']}}<br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;"> @if(!empty($userDetails)) {{$userDetails['first_name']}} {{$userDetails['last_name']}}, @endif</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;margin-bottom:0px">Thank you for your payment! Your subscription for {{$subscriptionsDetails['plan_name']}} has been successfully renewed.
                    </span></p>
                </td>
            </tr>
            @if(!empty($subscriptionsDetails))
            <tr>
                <td style= "text-align: left;">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Payment Receipt</h4></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Plan</td>
                            <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$subscriptionsDetails['plan_name']}}</p></td>
                        </tr>
                        <tr>
                            <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Amount Paid</td>
                            <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$amount_label}}</p></td>
                        </tr>
                        @if( isset( $hasAccountBalance) && ( $hasAccountBalance == '1' ) )
                        <tr>
                            <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Account Balance</td>
                            <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$accountBalance}}</p></td>
                        </tr>
                        @endif
                        @if( isset( $receipt_num ) )
                        <tr>
                            <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Receipt Number</td>
                            <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$receipt_num}}</p></td>
                        </tr>
                        @endif
                        <tr>
                            <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Payment Date</td>
                            <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$startDate}}</p></td>
                        </tr>
                        @if( isset( $card_info ) )
                        <tr>
                            <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Card Number</td>
                            <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">**** {{$card_info['card_number']}}</p></td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
            @endif
        </table>
        <tr>
            <td colspan="2" style="text-align: center; padding-top: 30px;">
               <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0;">If you have any questions, feel free to contact our support team.</p>
            </td>
         </tr>
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