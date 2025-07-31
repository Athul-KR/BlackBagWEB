@include('emails.emailheader')
   
         <tr>
            <td colspan="2">
               <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000;  min-height: 350px;">

                  <tr>
                     <td>
                        <h1 style="font-size: 26px; margin-top: 0;"><img  style="width: 30px; margin-right: 7px;" src="{{asset('images/mail/image_shedule.png')}}">New Appointment Scheduled</h1>
                     </td>
                  </tr>

                  <tr>
                     <td align="left">
                        <h3 style="margin: 5px 0px;">Dear {{$name}}</h3>
                        <p style="color: #6B6B6B; font-size: 16px; line-height: 1.5; margin-bottom: 0;margin: 5px 0px">An appointment is scheduled for you with <span style="color: #181818;font-weight: 500;">{{$clinic}}</span>. This email confirms the details of your upcoming consultation.</p>
                     </td>
                  </tr>
                  
                  <tr>
                     <td style= "text-align: left;">
                        <table style="width: 100%;">
                           <tr>
                              <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Appointment Details</h4></td>
                           </tr>
                           <tr>
                              <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Date</td>
                              <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$date}}</p></td>
                           </tr>
                           <tr>
                              <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Time</td>
                              <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$time}}</p></td>
                           </tr>
                           <tr>
                              <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">{{ $userType == 'patient' ? 'Clinician' : 'Patient' }}</td>
                              <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{ $userType == 'patient' ? $doctor : $patient }}</p></td>
                           </tr>
                           <tr>
                              <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Appointment Type</td>
                              <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$appointment_type}}</p></td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
         <tr>
            <td colspan="2" style="text-align: center; padding-top: 30px;">
               <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0;">Use the following button to access the online session. Please ensure you log in at least 10 minutes before your scheduled time.</p>
               <a href="{{$link}}" style="padding: 20px 10px; text-align: center; background: #000000; display: block; text-decoration: none; color: #fff; width: 200px; margin: auto; border-radius: 5px;">Join Now</a>
               <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0; margin-bottom: 0;">Ensure your device has a camera, microphone, and a stable internet connection. Find a quiet, well-lit space for your consultation. Have your medical records, prescriptions, and any questions ready to discuss with the doctor.</p>
            </td>
         </tr>
                     
@include('emails.emailfooter')
                  
               
     
  



