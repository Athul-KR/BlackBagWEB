@include('emails.emailheader')
    <tr>
        <td colspan="2">
            <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
                <tr>
                    <td>
                    <h1 style="font-size: 25px; margin-top: 0; margin-top: 0;"><span><img style="width: 30px; margin-right: 7px; vertical-align: bottom;" src="{{url('public/images/mail/doctor.png')}}" alt="Logo"></span>Your Account is Ready!</h1>  
                    </td>
                </tr>
                <tr>
                    <td style="text-align: left;">
                        <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hi {{$name}},</h5>
                        <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;">{{$clinicianname}} from {{$clinic}} has sent you an invitation to join BlackBag designed to support seamless collaboration between healthcare professionals and their patients.</p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: center; padding-top: 30px;">
            <p style="font-size: 14px; color: #969696; line-height: 1.5; padding-top: 0; width: 90%; margin: auto;">Please take a moment to review the invitation and accept it. We appreciate your attention to this matter.</p>
            <a href="{{$link}}" style="padding: 20px 10px; text-align: center; background: #000000; display: block; text-decoration: none; color: #fff; width: 200px; margin: auto; border-radius: 5px; margin-top: 15px;">Accept Invitation</a>
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
                  
               
     
  



