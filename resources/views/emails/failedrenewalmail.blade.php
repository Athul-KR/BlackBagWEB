@extends('emails.emailheader')
@section('content')
<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Subscription Renewal Failure<br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hi  @if(!empty($userDetails)) {{$userDetails['first_name']}} {{$userDetails['last_name']}}, @endif</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;margin-bottom:0px">Your account has been locked due to incomplete billing information. To resolve this and regain access, please update your billing information as soon as possible.</p>
                </td>
            </tr>

            <tr>
                <td colspan='2'>
                    <p style="font-size: 14px; color: #646161; font-weight: 300; line-height: 24px;"> Thank you for your understanding and cooperation. We look forward to resolving this matter promptly and continuing to serve you with the high-quality services you deserve.
                    </p>
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