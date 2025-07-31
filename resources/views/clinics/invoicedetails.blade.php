<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title></title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-family: sans-serif;
            font-size: 14px;
            -webkit-print-color-adjust: exact; 
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            width: 21cm;
            min-height: 29.7cm;
            padding: 2cm;
            margin: 1cm auto;
            border: 1px solid #e9e9e9;
            border-radius: 5px;
            background: white;
            box-shadow: rgba(0, 0, 0, 0.10) 2px 5px 15px 0px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        tr{
            width: 100%;
        }
       
        td {
            padding: 10px;
            color: #767676;
        }

        img.logo {
            text-align: center;
            width: 300px;
            margin-bottom: 10px;
            object-fit: contain;
        }
        .text-end {
            text-align: end;
        }
        p {
    margin: 0;
    color: #626262;
    font-weight: 500;
    font-size: 13px;
}
td.dtls {
    border-bottom: 1px solid #E8EDF3;
}
.subcrption-hd {
    background: #fafafa;
    color: #333;
    font-weight: 600;
    font-size: 13px;
   
}
td.dtls {
    border-bottom: 1px solid #E8EDF3;
}



        @page {
            size: A4;
            margin: 0;
        }

        @media print {
            .page {
                margin: 0;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
        }
    </style>

</head>

<body>
    <div class="page">
        <table>
            <thead>
                <tr>
                    <th style="padding-bottom: 10px;" colspan="2" style="text-align: center">
                        <img class="logo" style="width:150px;height:auto;object-fit:contain" src="{{$clinicDetails['logo']}}">
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
             
                    <td colspan="2">
                        <p style="margin-bottom: 10px; color: #333333; font-weight: 600;">
                            Hi  @if(!empty($paymentDetails)) {{$paymentDetails['billing_first_name']}} {{$paymentDetails['billing_last_name']}}, @endif
                        </p>
                        <p style="margin-bottom: 10px; line-height: 20px; color: #a1a1a1; font-weight: 400;">
                        
                            Thank you for subscribing to the BlackBag <br>
                  Please see the details of your subscription below.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"  style="background: #fafafa; border-radius: 8px; padding: 5px 15px 15px;">
                        <table>
                            <tr>
                                <td style="background: #fafafa;" class="subcrption-hd" colspan="2">Plan Details</td>
                            </tr>
                           
                            @if(!empty($paymentDetails))
                               <?php  
                                $Corefunctions = new \App\customclasses\Corefunctions;
                                $start_date =   (isset($paymentDetails['plan_start_date']) && ($paymentDetails['plan_start_date'] != "")) ? $Corefunctions->timezoneChange($paymentDetails['plan_start_date'], "d M Y") : "";
                                $end_date =  (isset($paymentDetails['plan_end_date']) && ($paymentDetails['plan_end_date'] != "")) ? $Corefunctions->timezoneChange($paymentDetails['plan_end_date'], "d M Y") : "";
                                ?>
                                <tr>
                                    <td class="dtls"><p>Invoice No</p></td>
                                    <td class="dtls text-end"><p>INV/{{$paymentDetails['invoice_number']}}</p></td>
                                </tr>
                                @if(!empty($subscriptionDetails))
                                <tr>
                                    <td class="dtls"><p>Plan Name</p></td>

                                    <td class="dtls text-end"><p>{{$subscriptionDetails['plan_name']}} @if( isset( $paymentDetails['isTrial'] ) && ( $paymentDetails['isTrial'] =='1' ) ) Trial @endif</p></td>
                                </tr>
                                @endif
                                <!-- <tr>
                                    <td class="dtls"><p>@if( isset( $paymentDetails['isTrial'] ) && ( $paymentDetails['isTrial'] =='1' ) ) Trial @endif Plan Start Date</p></td>
                                    <td class="dtls text-end"><p>{{$start_date}}</p></td>
                                </tr>
                                <tr>
                                    <td class="dtls"><p>@if( isset( $paymentDetails['isTrial'] ) && ( $paymentDetails['isTrial'] =='1' ) ) Trial @endif Plan End Date</p></td>
                                    <td class="dtls text-end"><p>{{$end_date}}</p></td>
                                </tr> -->
                                @if(!empty($subscriptionDetails))
                                <tr>
                                    <td  class="dtls"><p>Duration</p></td>
                                    <td class="dtls text-end"><p>{{$subscriptionDetails['duration']}}</p></td>
                                </tr>
                                @endif
                            
                                <tr>
                                    <td class="dtls"><p>Amount</p></td>
                                    <td class="dtls text-end"><p style="color: #333333; font-weight: 600;">{{$paymentDetails['amount_label']}}</p></td>
                                </tr>
                                @if( !empty( $paymentInfo ) )
                                <tr>
                                    <td class="dtls"><p>Payment Date</p></td>
                                    <td class="dtls text-end"><p style="color: #333333; font-weight: 600;"><?php echo date('m/d/Y', strtotime($paymentInfo['created_at'])) ?></p></td>
                                </tr>
                                @endif
                            @endif
                        </table>

                    </td>
                </tr>
                <tr><td></td></tr>
                @if( !empty( $paymentInfo ) )
                <tr>
                    <td colspan="2"  style="background: #fafafa; border-radius: 8px; padding: 5px 15px 15px;">
                        <table>
                            <tr>
                                <td style="background-color: #fafafa;" class="subcrption-hd" colspan="2">Card Details</td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>Name on Card</p></td>
                                <td class="dtls text-end"><p>{{$paymentInfo['name_on_card']}}</p></td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>Card Number</p></td>
                                <td class="dtls text-end"><p>**** {{$paymentInfo['card_num']}}</p></td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>Expiry</p></td>
                                <td class="dtls text-end"><p>{{$paymentInfo['exp_month']}}/{{$paymentInfo['exp_year']}}</p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                @endif
                <tr><td></td></tr>
                @if( !empty( $paymentDetails ) && ( ($paymentDetails['payment_id'] !='0')) )
                <tr>
                    <td colspan="2"  style="background: #fafafa; border-radius: 8px; padding: 5px 15px 15px;">
                        <table>
                            <tr>
                                <td style="background-color: #fafafa;" class="subcrption-hd" colspan="2">Billing Details</td>
                            </tr>

                            @if(!empty($paymentDetails))
                            <tr>
                                <td class="dtls"><p>Billing Name/Company Name</p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['billing_first_name']}}</p></td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>Address</p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['billing_address']}}</p></td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>City</p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['billing_city']}}</p></td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>State</p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['billing_state']}} </p></td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>Zip</p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['billing_zip']}}</p></td>
                            </tr>
                            <tr>
                                <td class="dtls"><p>Country</p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['billing_country']}}</p></td>
                            </tr>
                            @if($paymentDetails['billing_phone_number'] !='')
                            <tr>
                                <td class="dtls"><p>Phone </p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['country_code']}}  <?php echo $Corefunctions->formatPhone($paymentDetails['billing_phone_number']);?></p></td>
                            </tr>
                            @endif

                           
                            @if(isset($paymentDetails['tax_id']) && ($paymentDetails['tax_id'] !=''))
                            <tr>
                                <td class="dtls"><p>{{$paymentDetails['tax_label']}}</p></td>
                                <td class="dtls text-end"><p>{{$paymentDetails['tax_id']}}</p></td>
                            </tr> @endif
                           
                            @endif
                           
                        </table>

                    </td>
                </tr>
                @endif
                <tr><td></td></tr>
               
               
                <tr>
                    <td style="padding-top: 20px;"><p style="margin-bottom: 7px;">Thank You,</p>
                        <p style="color: #181818; font-weight: 600; font-size: 15px;">Team BlackBag</p></td>
                </tr>
                
                
            </tbody>
        </table>
    </div>
</body>
</html>