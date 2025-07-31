@include('emails.emailheader')
   
                     <tr>
                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
                             
                              <tr>
                                 <td>
                                    <h1 style="font-size: 26px; margin-top: 0;">
                                       <img style="width: 30px; margin-right: 7px; vertical-align: top;" src="{{url('public/images/mail/paymentsuccess.png')}}">Payment Confirmation</h1>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align:left">
                                       <p style="color: #6B6B6B; font-size: 16px; line-height: 1.5; margin-bottom: 0; text-align: left;">Hi <span style="color: #181818;font-weight: 500;">{{$name}}</span>,<br/></p>
                                       <p>Your payment for the appointment on {{$appointmnetDate}} with {{$doctorname}} has been completed.Please see the details below :</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left;">
                                    <table style="width: 100%;">
                                       <tbody>
                                          <tr>
                                             <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Payment Details</h4></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Receipt No</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$receipt_num}}</p></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Appointment Date</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$appointmnetDate}}</p></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Appointment Time</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$appointmnetTime}}</p></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Payment Method</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$payment_method}}</p></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Card Info</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">****{{$card_number}}</p></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Paid Date</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;"><?php echo date('m/d/Y', strtotime($paymentdate)) ?></p></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Paid Amount</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">${{number_format($amount,2)}}</p></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                    
                     <tr>
                        <td colspan="2" style="text-align: center; padding-top: 30px;">
                           <p style="font-size: 14px; color: #969696; line-height: 1.5; padding-top: 0; width: 90%; margin: auto;">Thank you for choosing <span style="color: #181818;font-weight: 500;">{{$clinicName}}</span>. We look forward to serving you again.</p>
                        </td>
                     </tr>
                     
                     @include('emails.emailfooter')
                  
               
     
  



