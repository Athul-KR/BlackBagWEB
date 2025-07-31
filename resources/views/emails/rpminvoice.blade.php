@extends('emails.emailheader')
@section('content')
<tr>
    <td colspan="2">
        <table style="width: 100%; padding: 20px; text-align: center; background: #ffffff; border: 1px solid #000; min-height: 350px;">

            <tr>
                <td>
                    <h1 style="font-size: 26px; margin-top: 0;"><img style="width: 30px; margin-right: 7px;" src="{{url('public/images/mail/nurse.png')}}" alt="Logo">Rpm Invoice<br></h1>
                </td>
            </tr>

            <tr>
                <td style="text-align: left;">
                    <h5 style="margin-bottom: 5px; font-size: 17px; margin-top: 0; color: #333;">Hello {{$name}},</h5>
                    <p style="color: #6B6B6B; font-size: 14px; line-height: 1.5; font-weight: 300;margin-bottom:0px">{{$notes}}</p>
                </td>
            </tr>
          
            <tr>
                <td style= "text-align: left;">
                   <table style="width: 100%;">
                      <tr>
                         <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Invoice Details</h4></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Invoice #</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$invoiceNumber}}</p></td>
                      </tr>
                      <tr>
                         <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Billing Information</h4></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Name</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$billingInfo['billing_company_name']}}</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Email</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">@if(isset($billingInfo['billing_email']) && $billingInfo['billing_email'] != '') {{$billingInfo['billing_email']}} @else -- @endif</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Phone Number</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">@if(isset($billingInfo['billing_phone']) && $billingInfo['billing_phone'] != '') {{$countryCode['country_code']}} {{$billingInfo['billing_phone']}} @else -- @endif</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Address</td>
                         <td style="padding-top: 15px;">
                            <p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">
                                <?php $corefunctions = new \App\customclasses\Corefunctions;
                                $address = $corefunctions->formatBillingAddress($billingInfo); ?>
                                <?php echo nl2br($address); ?>
                            </p>
                         </td>
                      </tr>
                      <tr>
                         <td colspan="2" style="border-bottom: 1px solid #000000;"><h4 style="padding: 0 0 10px 0; margin-bottom: 0;font-size: 15px;">Primary Debit Source</h4></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Source</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">Card</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Name On Card</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$cardInfo['name_on_card']}}</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Card Number</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">****{{$cardInfo['card_num']}}</p></td>
                      </tr>
                      <tr>
                         <td style="font-size: 14px; color: #6B6B6B; padding-top: 15px;">Card Expiry</td>
                         <td style="padding-top: 15px;"><p style="text-align: end; font-size: 16px; font-weight: 600; margin: 0;font-size: 15px;">{{$cardInfo['exp_month']}}/{{$cardInfo['exp_year']}}</p></td>
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

@include('emails.emailfooter')
@stop