@include('emails.emailheader')
    <!-- <tr>
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
    </table> -->
    <tr>
                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: start; background: #ffffff; border: 1px solid #000;  min-height: 350px;">
                              <tr>
                                 <td style= "text-align: center;">
                                    <table style="width: 100%;">
                                       <tr>
                                          <td colspan="2"><img class="logo" style="height: 100px;width: 100px;border-radius: 50%;border: 1px solid #CBCBCB;" src="{{$cliniclogo}}" alt="clinic logo"></td>
                                       </tr>
                                       <tr>
                                          <td colspan="2" style="padding-bottom: 20px;"><h1 style="margin: 0;font-size: 24px;">You are invited to Join Us</h1></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td style= "text-align: left;">
                                    <h1 style="font-size: 20px; margin: 0;font-weight: 700;padding-bottom: 10px;">Dear {{$name}},</h1>
                                    <p style="color: #6B6B6B; font-size: 16px; line-height: 1.5; margin: 0;">We’d like to invite you to join <strong style="color:#000">{{$clinic}}</strong> on <strong style="color:#000">Blackbag</strong>, the secure platform we use for managing care and internal collaboration.</p>
                                 </td>
                              </tr>
                              
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: start; padding-top: 20px;">
                           <h4 style="font-size: 16px; margin: 0;font-weight: 700;padding-bottom: 10px;">To get started:</h4>
                           <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0;margin-top: 0px; margin-bottom: 0;">Click the button below to accept your invitation and join.</p>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: center; padding-top: 20px;">
                           <a href="{{$link}}" style="padding: 20px 10px; text-align: center; background: #000000; display: block; text-decoration: none; color: #fff; width: 200px; margin: auto; border-radius: 5px;font-weight: 500;">Click to Join Now</a>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: start; padding-top: 20px;">
                           <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0; margin-bottom: 0;margin-top: 0px;">If you have any questions or need help setting up your account, feel free to reach out. Looking forward to working together.</p>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: start; padding-top: 20px;">
                           <table>
                              <tr>
                                 <td style="padding-right: 10px;"><img src="{{$cliniclogo}}" alt="{{$clinic}}" style="height: 50px;width: 50px;border-radius: 50%;border: 1px solid #EEEEEE;object-fit: cover;"></td>
                                 <td style="vertical-align: middle;">
                                    <strong style="color: #000;">{{$clinic}}</strong><br>
                              
                                 </td>
                              </tr>
                           </table>
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
                  
               
     
  



