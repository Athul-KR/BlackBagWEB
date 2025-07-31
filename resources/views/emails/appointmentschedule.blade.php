@include('emails.emailheader')




                    <tr>
                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000;  min-height: 350px;">

                              <tr>
                                 <td>
                                    <h1 style="font-size: 26px; margin-top: 0;"><img  style="width: 30px; margin-right: 7px;" src="{{asset('image_shedule.png')}}">New Appointment Scheduled</h1>
                                 </td>
                              </tr>

                              <tr>
                                 <td align="left">
                                    <h3 style="margin: 5px 0px;">Dear {{$name}}</h3>
                                    <p style="color: #6B6B6B; font-size: 16px; line-height: 1.5; margin-bottom: 0;margin: 5px 0px">Thank you for scheduling an online appointment with <span style="color: #181818;font-weight: 500;">[Clinic Name]</span>. This email confirms the details of your upcoming consultation.</p>
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
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Doctor</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">Robert Gardner</p></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Appointment Type</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">In-Person Appointment</p></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>

                     @include('emails.emailfooter')