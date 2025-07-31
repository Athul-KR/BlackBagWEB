@extends('emails.emailheader')
@section('content')
<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Backup Card Used<br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hi {{ trim($first_name.' '. $last_name) }},</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;margin-bottom:0px">We are pleased to inform you that your Fileflow subscription has been successfully renewed! We noticed that the primary payment method associated with your account was unsuccessful for the subscription renewal. However, as you had provided a backup payment option, we were able to process the renewal using the details of your backup card.</p>
                </td>
            </tr>

            <tr>
                <td colspan='2'>
                    <p style="font-size: 14px; color: #646161; font-weight: 300; line-height: 24px;">To update your payment details or manage your subscription preferences, you can log in to your account on our website. We are excited to continue serving you and delivering a fulfilling subscription experience.
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