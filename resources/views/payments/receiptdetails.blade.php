<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>#{{$paymentDetails['receipt_num']}} </title>
    <style>
       body {
            margin: 0;
            padding: 0;
            background-color: #fff;
            font-family: 'Raleway', sans-serif;
            font-size: 14px;
            -webkit-print-color-adjust: exact; 
        }

        * {
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            /* width: 21cm; */
            min-height: 29.7cm;
            padding: 1cm;
            margin: 1cm auto;
            border: 1px solid #fff;
            border-radius: 5px;
            background: white;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        tr{
            width: 100%;
        }
        img.logo {
            text-align: center;
            margin-bottom: 10px;
            width: 150px;
            height: auto;
            object-fit: contain
        }
        .text-end {
            text-align: end;
        }
        p {
            margin: 0;
           
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
    <table style="width:100%">
        <thead>
            <tr >
                <th style="padding-bottom: 30px;" colspan="2">
                    <img class="logo" src="{{$clinicDetails['logo']}}">
                    <h5 class="primary fw-bold" style="font-size:24px">{{$clinicDetails['name']}}</h5>
                    <!-- <img class="logo" src="{{asset('images/logo.png')}}"> -->
                </th>
            </tr>
        </thead>
        <tbody>
            <!-- <tr>
                <td colspan="2">
                    <p style="margin-bottom: 10px; color: #333333; font-weight: 600;">
                        Hi  @if(!empty($userDetails)) {{$userDetails['first_name']}}{{$userDetails['last_name']}}, @endif
                    </p>
                    <p>Please see the details below.</p>
                </td>
            </tr> -->

            @if(!empty($paymentDetails))
            <!-- <tr>
                <td class="dtls" colspan="4" align="center">
                    <p style="text-align: center;font-size:20px; color: #6B6B6B; padding-top: 18px;">Amount</p>
                   
                </td>
            </tr> -->
            <?php $corefunctions = new \App\customclasses\Corefunctions; ?>
            <tr>
                <td style="width:50%">
                    <p style="margin: 0px;padding-bottom: 9px; padding-top: 20px; font-size: 20px; font-weight: bold;">Billed To</p>
                    @if(!empty($paymentDetails))
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">{{$paymentDetails['billing_first_name']}}</p>
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">
                        <?php
                        $address = $corefunctions->formatBillingAddress($paymentDetails); ?>
                        <?php echo nl2br($address); ?>
                    </p>
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">{{$paymentDetails['country_code']}} <?php echo $corefunctions->formatPhone($paymentDetails['billing_phone']);?></p>
                    @endif
                </td>
                <td style="width:50%; padding-top: 20px;    vertical-align: top; text-align: right;">
                    <p style="margin: 0px;padding-bottom: 10px; font-size: 20px; font-weight: bold;"> RECEIPT</p>
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">Receipt No: #{{$paymentDetails['receipt_num']}} </p>
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">Date: <?php echo $corefunctions->timezoneChange($paymentDetails['created_at'],"M d, Y") ?> </p>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="padding-top: 20px; padding-bottom: 10px;">
                    <table class="table">
                        <thead style="border-bottom: 1px solid #dbdbdb;padding: 0 0 10px 0;">
                            <tr>
                                <th scope="col" style="text-align: start;padding:10px;background:#f4f4f4">Payment Date</th>
                                <th scope="col" style="text-align: start;padding:10px;background:#f4f4f4">Payment Time</th>
                                <th scope="col" style="text-align: start;padding:10px;background:#f4f4f4">Clinic</th>
                                @if($paymentDetails['parent_type'] == 'subscription')
                                    <th scope="col" style="text-align: start;padding:10px;background:#f4f4f4">Subscription Plan</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding:10px; padding-top:20px">@if(isset($paymentDetails['created_at']))<?php echo  date('M d, Y', strtotime($paymentDetails['created_at'])) ?> @endif </td>
                                <td style="padding:10px; padding-top:20px">@if(isset($paymentDetails['created_at']))<?php echo  date('h:i A', strtotime($paymentDetails['created_at'])) ?>@endif </td>
                                <td style="padding:10px; padding-top:20px">{{ $clinicName }}</td>
                                @if($paymentDetails['parent_type'] == 'subscription')
                                    <td style="padding:10px; padding-top:20px">{{ $subscriptionName }}</td>
                                @endif
                            </tr>
                            <tr>
                                <td colspan="4">
                                    <p style="border-top: 1px dashed #3e3e3e;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td> 
            </tr>
            @endif

           
            <tr>
                <td class="subcrption-hd" colspan="2">
                    <p style="margin: 0px;padding-bottom: 9px; padding-top: 18px;font-size: 18px;font-weight: normal;">Card Details</p>
                </td>
            </tr>

            <tr>
                <td style="width:50%; padding-bottom: 16px;">
                    <table style="width:100%">
                        <tr>
                            <td style="width:10%"><span style="flot-left">
                              
                                @if(($paymentDetails['card_type'] =='Diners') || ($paymentDetails['card_type'] =='Diners Club') )
                               <img src="{{asset('images/cards/Diners.svg')}}" style="width: 40px;height: 30px; object-fit: contain; margin-right: 10px;">
                               @else
                               <img src="{{asset('images/cards/'.$paymentDetails['card_type'].'.svg')}}" style="width: 40px;height: 30px; object-fit: contain; margin-right: 10px;">
                               @endif
                                 </span>
                            </td>
                            
                          
                            
                            <td style="width:90%"> <p style="text-align: left;">
                                    <span style="font-size: 15px;color: #333333; max-width: 600px;">{{$paymentDetails['name_on_card']}}</span><br>
                                    <span style="font-size: 15px;color: #333333; max-width: 600px;">Card ending with  {{$paymentDetails['card_num']}}</span>
                                    <br>
                                    <span style="font-size: 15px;color: #333333; max-width: 600px;">Expiry {{$paymentDetails['exp_month'].'/'.$paymentDetails['exp_year']}}</span>
                                 </p>
                            </td>
                        </tr>
                    </table>
                </td> 
                <td style="width:50%; text-align: end; vertical-align: bottom; padding-bottom: 16px;">
                    <p style="font-size: 20px; text-align: center; font-weight: 600; margin: 0; text-align: end; vertical-align: bottom;">${{number_format($paymentDetails['amount'],2)}}</p>
                </td>
            </tr> 
            <tr>
                <td colspan="2"><p style="border-top: 1px dashed #3e3e3e;"></p></td>
            </tr>
            <tr>
                <td colspan="2">
                    <p style="margin: 0px;padding-bottom: 9px; padding-top: 20px;font-size: 20px;font-weight: bold;">Billed By</p>
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">{{$clinicDetails['name']}}</p>
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">
                    <?php 
                        $address = $corefunctions->formatBillingAddress($clinicDetails); ?>
                        <?php echo nl2br($address); ?>

                    </p>
                   
                    <p style="color: #333333; padding-bottom:3px;font-size: 15px;">{{$cliniccode}} <?php echo $corefunctions->formatPhone($clinicDetails['phone_number']);?></p>
                </td>
            </tr>  
        </tbody>
    </table>
</div>
</body>
</html>

