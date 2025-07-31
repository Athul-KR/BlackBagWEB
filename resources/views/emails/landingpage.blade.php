@extends('emails.emailheader')
@section('content')

<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">

            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">BlackBag - Inquiry Submitted<br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hello BlackBag Admin,</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;margin-bottom:0px">{{$name}} has shown interest in BlackBag and sent an inquiry request. Please take necessary actions!</p>
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
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Clinic Name</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$clinicname}}</p></td>
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

</table>
                  <table style="padding: 0 30px 30px 30px ; width: 100%;">
                     <tr>
                        <tr>
                           <td style="text-align: center; border-top: 1px solid #DBDBDB; padding-top: 20px; padding-bottom: 0;">
                              @if(!isset($isFooter))
                              <p style="font-size: 13px; margin:0 0 5px 0; color: #8b8b8b;">This email was sent to you because you are a registered user in BlackBag.</p> 
                              @endif
                              <p style="font-size: 13px; margin: 0; color: #8b8b8b;">Copyright © BlackBag {{date('Y')}}. All rights reserved.</p>
                               <p style="margin: 0px;padding-top: 3px;"><a href="https://myblackbag.com/privacy-policy" style="font-size: 13px; margin:0 0 5px 0; color: #8b8b8b;">Privacy Policy</a><span style="color:#e2e8f0;padding:0 5px">|</span><a href="https://myblackbag.com/terms-and-conditions" style="font-size: 13px; margin:0 0 5px 0; color: #8b8b8b;">Terms &  Conditions</a><span style="color:#e2e8f0;padding:0 5px">|</span><a href="https://myblackbag.com/" style="font-size: 13px; margin:0 0 5px 0; color: #8b8b8b;">Visit Us</a><span style="color:#e2e8f0;padding:0 5px">|</span><a href="https://myblackbag.com/contact-us" style="font-size: 13px; margin:0 0 5px 0; color: #8b8b8b;">Contact </a></p>
                           </td>
                        </tr>
                     </tr>
                  </table>
</td>
</tr>
</tbody>
</table>
@stop