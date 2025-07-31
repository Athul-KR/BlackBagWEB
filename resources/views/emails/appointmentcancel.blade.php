@include('emails.emailheader')
   

<tr>

                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000;  min-height: 350px;">
                              <tr>
                                 <td>
                                    <h1 style="font-size: 26px; margin-top: 0;"><img  style="width: 30px; margin-right: 7px; vertical-align: middle;"  src="{{asset('images/mail/imageapp.png')}}">Appointment Cancellation</h1>
                                    <p style="color: #6B6B6B; font-size: 16px; line-height: 1.5; margin-bottom: 0;"> Your appointment at <span style="color: #181818;font-weight: 500;">{{$clinic}}</span> scheduled for <span style="color: #181818;font-weight: 500;"><?php echo  date('M d Y', strtotime($date)) ?> at </span> <span style="color: #181818;font-weight: 500;"><?php echo  date('h:i A', strtotime($time)) ?></span> has been cancelled.
                                    Please see the details below of the cancelled appointment below :</p>
                                 </td>
                              </tr>
                             <tr>
                                 <td style= "text-align: left;">
                                    <table style="width: 100%;">
                                       <tr>
                                          <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Appointment Details</h4></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Clinician's Name</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$doctorName}}</p></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Date & Time</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;"><?php echo  date('M d Y', strtotime($date)) ?> | <?php echo  date('h:i A', strtotime($time)) ?></p></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Appointment Type</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$appType}}</p></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Location</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;"><?php echo nl2br($location) ?></p></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>


                    
                     
                     @include('emails.emailfooter')
                  
               
     
  



