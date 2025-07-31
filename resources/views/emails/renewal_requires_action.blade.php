@extends('emails.emailheader')
@section('content')
<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Subscription Renewal Requires Action<br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hi {{$first_name}} {{$last_name}},</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;margin-bottom:0px">Your subscription renewal requires action to complete the payment. Please login to view the invoices and make the payment.</p>
                </td>
            </tr>

            <tr>
                <td colspan='2' style='padding:30px 10px; text-align:center;'>
                    <a class="btn-primary" style='background-color: #2866eb; font-size:17px;font-weight:400;color: #fff;padding: 10px 35px;border-radius:35px;text-decoration:none' href="{{ $url }}">Login</a>
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