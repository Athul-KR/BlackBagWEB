
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="keywords" content="HTML, CSS, JavaScript">
      <meta name="color-scheme" content="light">
      <meta name="supported-color-schemes" content="light">
      <title>BlackBag Mail</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
   </head>
   <!-- Responsive styles -->
   <style>

    

      @media screen and (max-width: 600px) {
         h1 {
            font-size: 26px;
         }
         p {
            font-size: 14px;
         }
         table {
		border: 0;
	}


	table td.td-res {
		border-bottom: 0;
		display: block;
      margin-top: -1px;
      padding: 10px !important;
		/* text-align: right; */
      width: 100% !important;
	}

	table td.td-res::before {
		content: attr(data-label);
		float: left;
		font-weight: bold;
		text-transform: uppercase;
	}

	table td:last-child {
		border-bottom: 0;
	}
      }
   </style>


   <body style="font-family: 'Raleway', sans-serif; line-height: 1.25; margin: 0; background: #1E1E1E; color: #1D1D1D;">
      <table style="max-width: 640px; margin: 5px auto; padding: 30px; width: 100%; border-collapse: collapse; background-color: #fff; margin: 30px auto; ">
         <tbody>
            <!-- <tr>
               <td colspan="2"><img style="height: 150px; width: 100%;" src="banner-top.png" alt=""></td>
            </tr> -->
            <tr>
               <td style="padding: 0;">
                  <table style="width: 100%; background-color: #ffffff; padding: 0 30px 30px 30px; background-image: url('{{ asset('images/mail/banner-top.png') }}'); background-repeat: no-repeat; background-size: contain;">
                     <tr>
                        <td colspan="2" style="text-align: center; padding: 30px 0 30px 0;">
                           <img class="logo" style="width: 230px;" src="{{url('public/images/mail/logo.png')}}" alt="logo">
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2">
                           <table style="width: 100%; padding: 20px; text-align: start; background: #ffffff; border: 1px solid #000;  min-height: 350px;">
                              <tr>
                                 <td style= "text-align: center;">
                                    <table style="width: 100%;">
                                       <tr>
                                          <td colspan="2"><img class="logo" style="height: 100px;width: 100px;border-radius: 50%;border: 1px solid #CBCBCB;" src="{{$clinicDetails['clinic_logo']}}" alt="clinic logo"></td>
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
                                    <p style="color: #6B6B6B; font-size: 16px; line-height: 1.5; margin: 0;">We’re excited to invite you to connect with <strong style="color:#000">{{$clinicName}}</strong> on <strong style="color:#000">Blackbag</strong>, our secure platform that helps you manage your healthcare with ease.</p>
                                 </td>
                              </tr>
                              <tr>
                                 <td style="text-align: start;">
                                    <table style="width: 100%;">
                                       <tr>
                                          <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Why Join Us On Blackbag</h4></td>
                                       </tr>
                                       <tr>
                                          <td colspan="2" style="padding-top:15px;">
                                             <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;">
                                                <tr>
                                                   <td style="width:10px; vertical-align:middle;">
                                                      <span style="display:block; height:5px; width:5px; background:#6B6B6B; border-radius:50%;"></span>
                                                   </td>
                                                   <td style="padding-left:8px; font-size:15px; font-weight:500; color:#6B6B6B; text-align:left;">
                                                      Book and manage appointments online.
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2" style="padding-top:15px;">
                                             <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;">
                                                <tr>
                                                   <td style="width:10px; vertical-align:middle;">
                                                      <span style="display:block; height:5px; width:5px; background:#6B6B6B; border-radius:50%;"></span>
                                                   </td>
                                                   <td style="padding-left:8px; font-size:15px; font-weight:500; color:#6B6B6B; text-align:left;">
                                                      Access your health records anytime.
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2" style="padding-top:15px;">
                                             <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;">
                                                <tr>
                                                   <td style="width:10px; vertical-align:middle;">
                                                      <span style="display:block; height:5px; width:5px; background:#6B6B6B; border-radius:50%;"></span>
                                                   </td>
                                                   <td style="padding-left:8px; font-size:15px; font-weight:500; color:#6B6B6B; text-align:left;">
                                                      Receive reminders and updates from our clinic.
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td colspan="2" style="padding-top:15px;">
                                             <table role="presentation" cellpadding="0" cellspacing="0" style="width:100%;">
                                                <tr>
                                                   <td style="width:10px; vertical-align:middle;">
                                                      <span style="display:block; height:5px; width:5px; background:#6B6B6B; border-radius:50%;"></span>
                                                   </td>
                                                   <td style="padding-left:8px; font-size:15px; font-weight:500; color:#6B6B6B; text-align:left;">
                                                      Communicate securely with our team.
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <?php $Corefunctions = new \App\customclasses\Corefunctions; ?>
                                 <td style= "text-align: left;">
                                    <table style="width: 100%;">
                                       <tr>
                                          <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Clinic Details:</h4></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Clinic Name</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$clinicName}}</p></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;vertical-align:baseline">Address</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;font-feature-settings: 'lnum' 1 !important;"><?php echo $address ?></p></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Phone</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;font-feature-settings: 'lnum' 1 !important;"><?php echo $Corefunctions->formatPhone($clinicDetails['phone_number']);?></p></td>
                                       </tr>
                                       <tr>
                                          <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Email</td>
                                          <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;color:#1d1d1d;">{{$clinicDetails['email']}}</p></td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: start; padding-top: 20px;">
                           <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0;margin-top: 0px; margin-bottom: 0;">Click the button below to join us on Blackbag. You can also enter our clinic code <strong style="color: #000;font-feature-settings: 'lnum' 1 !important;">{{$clinicUserDets['clinic_code']}}</strong> after logging in to connect with us directly.</p>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: center; padding-top: 20px;">
                           <a href="{{$link}}" style="padding: 20px 10px; text-align: center; background: #000000; display: block; text-decoration: none; color: #fff; width: 200px; margin: auto; border-radius: 5px;font-weight: 500;">Click to Join Now</a>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: start; padding-top: 20px;">
                           <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0; margin-bottom: 0;margin-top: 0px;">Need help or have questions? Our friendly front desk team is there to assist you. Looking forward to seeing you soon.</p>
                        </td>
                     </tr>
                     <tr>
                        <td colspan="2" style="text-align: start; padding-top: 20px;">
                           <table>
                              <tr>
                                 <td style="padding-right: 10px;"><img src="{{$image}}" alt="Dr. Emily Parker" style="height: 50px;width: 50px;border-radius: 50%;border: 1px solid #EEEEEE;object-fit: cover;"></td>
                                 <td style="vertical-align: middle;">
                                    <strong style="color: #000;">{{$clinicianName}}</strong><br>
                                    <p style="font-size: 16px; color: #6B6B6B; line-height: 1.5; padding-top: 0;margin-top: 0px; margin-bottom: 0;">{{$clinicName}}</p>
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
     
   </body>
</html>
