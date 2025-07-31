@extends('emails.emailheader')
@section('content')

<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">

            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">BlackBag Inquiry <br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hello {{$name}},</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;margin-bottom:0px">Thank you for reaching out to us! We have received your inquiry and will get back to you shortly.</p>
                </td>
            </tr>
          
            <tr>
                <td style= "text-align: left;">
                   <table style="width: 100%;">
                      <tr>
                         <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Inquiry Details</h4></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Name</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$name}}</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Email</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$userEmail}}</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Phone Number</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$phone}}</p></td>
                      </tr>
                      <tr>
                         <td colspan="2" style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Message</td>
                      </tr>
                      <?php
                        $cleanMessage = preg_replace([
                            '#<\/?p[^>]*>#i',
                            '#<\/?span[^>]*>#i'
                        ], '', $userMessage);

                        // Convert \n to <br> for HTML display
                        $trimmedMessage = nl2br($cleanMessage);
                      ?>
                      <tr>
                        <td colspan="2" style="padding-top: 10px;"><p style="text-align: start; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{!! $trimmedMessage !!}</p></td>
                     </tr>
                   </table>
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