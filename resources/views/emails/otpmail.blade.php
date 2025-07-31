@include('emails.emailheader')
   
                     <tr>
                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
                              <tr>
                                 <td>
                                    <h1 style="font-size: 25px; margin-top: 0; margin-bottom: 0;"><span><img style="width: 50px; margin-right: 7px; vertical-align: bottom;" src="{{url('public/images/mail/otpimage.png')}}" alt="Logo"></span>OTP</h1>  
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: center;">
                                    <!-- <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hi {{$name}},</h5> -->
                                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;">Thank you for choosing BlackBag. Please use the One-Time Password (OTP) below to securely log in to your account.</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: center;">
                                    <h1 style="font-size: 40px; margin-top: 0; margin-bottom: 0;font-feature-settings: 'lnum' 1;">{{$otp}}</h1>  
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                    
                     <tr>
                        <td colspan="2" style="text-align: center; padding-top: 30px;">
                           <p style="font-size: 14px; color: #969696; line-height: 1.5; padding-top: 0; width: 90%; margin: auto;">For your safety, please do not share this OTP with anyone</p>
                        </td>
                     </tr>
                     
                     @include('emails.emailfooter')
                  
               
     
  



