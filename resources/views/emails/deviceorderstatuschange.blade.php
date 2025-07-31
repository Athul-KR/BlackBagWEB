@include('emails.emailheader')
   
                     <tr>
                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">
                             
                              <tr>
                                 <td>
                                    <h1 style="font-size: 26px; margin-top: 0;">
                                       <img style="width: 30px; margin-right: 7px; vertical-align: top;" src="{{url('public/images/mail/paymentsuccess.png')}}">Device Order Accepted</h1>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align:left">
                                       <p style="color: #6B6B6B; font-size: 16px; line-height: 1.5; margin-bottom: 0; text-align: left;">Hi <span style="color: #181818;font-weight: 500;">{{$clinicianName}}</span>,<br/></p>
                                       <p>Medical device has been {{$statusText}} by {{$username}}. Please see the details below :</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: left;">
                                    <table style="width: 100%;">
                                       <tbody>
                                          <tr>
                                             <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Device Details</h4></td>
                                          </tr>
                                          <tr>
                                             <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Order ID</td>
                                             <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$orderInfo['order_code']}}</p></td>
                                          </tr>
                                           
                                        
                                       @if(!empty($rpmDevices))
                                        <tr>
                                           <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px; vertical-align: top;">Device(s)</td>
                                           <td style="padding-top: 15px;">
                                              <table style="width: 100%;">
                                                 @foreach($rpmDevices as $device)
                                                
                                                 <tr>
                                                    <td style="text-align: right; font-size: 15px; font-weight: 600; padding: 4px 0;">
                                                       {{ $device['device'] }}
                                                          <br><span style="font-size: 13px; color: #999;">{{ $device['category'] }}</span>
                                                   
                                                     
                                                    </td>
                                                 </tr>
                                                  
                                                 @endforeach
                                              </table>
                                           </td>
                                        </tr>
                                        @endif
                                         
                                       </tbody>
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
                  
               
     
  



