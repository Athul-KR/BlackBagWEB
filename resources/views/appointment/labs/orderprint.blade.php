
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
        <meta name="keywords" content="HTML, CSS, JavaScript">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@if(isset($seo['title']) && !empty($seo['title'])){{$seo['title']}}@else BlackBag @endif</title>
        <meta name="keywords" content="{{ isset($seo['keywords'])&& $seo['keywords']!='' ? $seo['keywords'] : '' }}">
        <meta name="description" content="{{ isset($seo['description'])&& $seo['description']!='' ? $seo['description'] : '' }}">
        <meta property="og:type" content="website" />
        <meta property="og:title" content="@if(isset($seo['title'])){{ $seo['title'] }}@else@yield('title')@endif"/>
        <meta property="og:description" content="{{ isset($seo['og_description']) && $seo['og_description']!='' ? $seo['og_description'] : 'Manage your healthcare appointments seamlessly with the Black Bag
                                        dashboard. View upcoming patient details, appointment types, and schedules. Stay
                                        updated with notifications and easily access actions for efficient management' }}" />
        <meta property="og:image" content="{{asset('/images/og-blackbag.png')}}">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- css -->
        <link rel="stylesheet" href="{{ asset('css/style.css')}}">
        <link rel="stylesheet" href="{{ asset('css/tele-med.css')}}">
        <link rel="stylesheet" href="{{ asset('css/navbar.css')}}">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" />
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    </head>
    
    <style>

        body, html {
            margin: 0 !important;
            padding: 0 !important;
            background-color: #fff !important;
            font-family: "Raleway", sans-serif !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color-adjust: exact;
        }


        @page {
            size: 21.59cm 27.94cm; 
            margin: 0;
            padding: 0;
        }

        @media print {
            body, html {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
                background-color: #fff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                color-adjust: exact;
            }

            .page {
                margin: 0 !important;
                padding: 0 !important;
                page-break-after: always;
                background: #fff !important;
                box-shadow: none !important;
                border: 0 !important;
            }

            table, tr, td {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                border: 0 !important;
                border-collapse: collapse !important;
            }
            tr {
            border: 1px solid #fff !important;
            }
            .m-0{margin: 0px !important}

        }

        .page {
            width: 21cm;
            min-height: 27.94cm;
            margin: 0 auto;
            padding: 0 !important; 
            background: white;
            border-radius: 5px;
            box-shadow: none;
            border: none;
        }

        .user_inner {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user_info p {
            font-size: 14px !important;
            font-weight: 400 !important;
            white-space: nowrap;
            line-height: 20px !important;
        }

        p {
            font-size: 0.875rem !important;
            font-feature-settings: 'lnum' 1;
        }

        .primary {
            color: #181818 !important;
        }

        table td {
            color: #626262 !important;
            font-weight: 400 !important;
            border: none;
            font-feature-settings: 'lnum' 1;
        }
        table {
                border-collapse: collapse !important;
            }
            
          
    </style> 
    
    
    <body class="A4 horizontal page" style="width:inherit !important; padding:0px; margin:0px;">


        

    <div class="page">
        <table style="width: 100%;border:0"> 
              <?php
        $corefunctions = new \App\customclasses\Corefunctions;
    ?>
            
            @if(!empty($finalTestArray))
            <tr style="border:1px solid transparent !important;">
                <td colspan="3" style="padding:0px;border:0">
                    <table class="table mb-0" style="border:0;width:100%"> 
                           
                            <tr style="border:1px solid transparent !important;">
                                <td colspan="3" style="padding: 10px;padding-bottom:10px;border-bottom:1px solid #F3F3F3">
                                    <table style="border-collapse: collapse;width:100%">
                                        <tr style="border:1px solid transparent !important;"> 
                                            <td style="vertical-align: top; padding-right: 10px;border-bottom:0px;width:70%">
                                               <table style="border-collapse: collapse;width:100%">
                                                    <tr style="border:1px solid transparent !important;"> 
                                                        <td style="width:15%;border-bottom:0px"> 
                                                            <img src="{{ $clinicDetails['logo']}}" class="logo cliniclogocls" style="max-width:150px;object-fit:cover" alt="Clinic">
                                                        </td>
                                                        <td style="width:85%; border:0;text-align:start"> 
                                                            <h4 class="mb-0" style="color: #181818;">{{$clinicDetails['name']}}</h4>
                                                        </td>
                                                    </tr>
                                               </table>
                                            </td>
                                            <td style="vertical-align: top; padding-right: 10px;border-bottom:0px;width:30%">
                                                <p style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px;color: #181818"><i class="fas fa-envelope" style="margin-right: 5px;"></i>{{$clinicDetails['email']}}</p>
                                                <p style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px;color: #181818"><i class="fas fa-phone" style="margin-right: 5px;"></i>@if(isset($countryCodedetails['country_code'])) {{ $countryCodedetails['country_code'] }} @endif  <?php echo $corefunctions->formatPhone($clinicDetails['phone_number']) ?></p>
                                                <p style="font-size: 14px; font-feature-settings: 'lnum' 1; border-bottom:0; color: #181818; margin: 0;">
                                                    <table style="border-collapse: collapse;width:100%">
                                                        <tr style="border:1px solid transparent !important;">
                                                            <td style="vertical-align: top; padding-right: 5px;border-bottom:0">
                                                                <i class="fas fa-map-marker-alt" style="font-size: 16px;color: #181818"></i>
                                                            </td>
                                                            <td style="vertical-align: top;border-bottom:0;color: #181818">
                                                                <p style="font-size: 14px; font-feature-settings: 'lnum' 1; border-bottom:0; color: #181818; margin: 0;">
                                                                    <?php
                                                                        $corefunctions = new \App\customclasses\Corefunctions;
                                                                        $address = $corefunctions->formatAddress($clinicDetails);
                                                                        echo nl2br($address);
                                                                    ?>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
 
                            <tr style="border:1px solid transparent !important;">
                                <td style="padding:15px 0px;border-bottom:0px;vertical-align:top">
                                    <table style="border-collapse: collapse;width:100%">
                                        <tr style="border:1px solid transparent !important;">
                                            <td width="10%" style="vertical-align: top; padding-right: 10px;border-bottom:0px">
                                                <img src="{{$patientDetails['logo_path']}}" style="width: 43px; height: 43px; object-fit: cover;border-radius: 50%;" alt="Patient">
                                            </td>
                                            <td width="90%" style="vertical-align: middle;border-bottom:0px">
                                                <table style="border-collapse: collapse;width:100%">
                                                    <tr style="border:1px solid transparent !important;">
                                                        <td style="font-weight: 500; font-size: 14px;border-bottom:0px">
                                                           <h6 class="primary fw-medium m-0"> {{$patientDetails['first_name']}} {{$patientDetails['last_name']}}</h6>
                                                        </td>
                                                    </tr>
                                                    <tr style="border:1px solid transparent !important;">
                                                        <td style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px;line-height: 1.425rem">
                                                            <p class="m-0" style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px"> {{$patientDetails['age']}} | 
                                                                @if($patientDetails['gender'] == '1') Male 
                                                                @elseif($patientDetails['gender'] == '2') Female 
                                                                @else Other 
                                                                @endif
                                                            </p>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="padding:15px;border-bottom: 0px">
                                    <h6 class="primary fw-medium m-0">Ordered by</h6>
                                    <p class="m-0" style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px">{{ $corefunctions -> showClinicanNameUser($userDetails,'0')}}</p>

                                    <p class="m-0" style="font-size: 14px; font-feature-settings: 'lnum' 1; color: #181818;">
                                        <i class="fas fa-envelope" style="margin-right: 5px;"></i>
                                        <small>{{ $userDetails['email'] }}</small>
                                    </p>
                                    <p class="m-0" style="font-size: 14px; font-feature-settings: 'lnum' 1; color: #181818;">
                                        <i class="fas fa-phone" style="margin-right: 5px;"></i>
                                        <small>
                                            @if(!empty($userCountryCode)) {{ $userCountryCode['country_code'] }} @endif 
                                            {{ $corefunctions->formatPhone($userDetails['phone_number']) }}
                                        </small>
                                    </p>

                            
                                </td>
                                <td style="padding:15px;border-bottom: 0px;vertical-align:top">
                                    <h6 class="primary fw-medium m-0">Date of test</h6>
                                    <p class="m-0" style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px">@if(!empty($orderLists)) <?php echo $corefunctions->timezoneChange($orderLists['test_date'],"m/d/Y") ?> @else --  @endif</p>
                                </td>
                            </tr>
                            <tr style="border:1px solid transparent !important;">
                                <td colspan="3" align="center" style="border-top: 1px solid #F3F3F3;border-bottom:1px solid #F3F3F3;padding:15px 10px">
                                    <h5 class="primary fwt-bold mb-0">Lab Test Form</h5>
                                </td>
                            </tr>
                            @foreach ($finalTestArray as $labTestId => $items) 
                            <tr style="border:1px solid transparent !important;">
                                <td colspan="3" style="padding:0px;padding-top:10px;border-bottom:0px"> 
                                    <table style="width: 100%"> 
                                        <tr style="border:1px solid transparent !important;">
                                            <td colspan="3" style="background: #F3F3F3;border-radius:8px;padding:10px"> 
                                                <h6 class="mb-0 primary fwt-bold">{{$categoryDetails[$labTestId]['name']}}</h6>
                                            </td>
                                        </tr>
                                        @foreach ($items as $item) 
                                        <tr style="border:1px solid transparent !important;">
                                            <td style="padding-top: 10px;">
                                                <table style="width: 100%">
                                                    <tr style="border:1px solid transparent !important;">
                                                        <td colspan="3" style="padding: 10px;border: 1px solid #F3F3F3">
                                                        @if(isset($item['sub_lab_test_id']) && $item['sub_lab_test_id'] !='')
                                                            <p class="primary fw-medium">{{$categoryDetails[$item['sub_lab_test_id']]['name']}}</p>
                                                            @endif
                                                            @if(isset($item['description']) && $item['description'] !='')
                                                            <span class="gray fw-light" style="font-style:italic">{!! nl2br(e($item['description'])) !!}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    
                                                </table>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                            <tr style="border:1px solid transparent !important;">
                                <td style="padding: 10px;"> 
                                    <table style="width: 100%; text-align: left;">
                                        <tr style="border:1px solid transparent !important;">
                                            <td style="vertical-align: top; width: 50%;">
                                                <p style="font-size: 14px;font-feature-settings: 'lnum' 1;font-weight: 400;">Signed By :</p>
                                                <p style="font-size: 14px;font-feature-settings: 'lnum' 1;font-weight: 500;padding-bottom:10px;color:#181818">{{ $corefunctions -> showClinicanNameUser($userDetails,'0')}}</p>
                                                <p style="font-size: 14px;font-feature-settings: 'lnum' 1;font-weight: 400;">Signed On :</p>
                                                <p style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px;color: #181818;font-weight:500">@if(!empty($orderLists)) <?php echo $corefunctions->timezoneChange($orderLists['test_date'],"m/d/Y") ?> @else --  @endif</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr style="border:1px solid transparent !important;"> 
                                <td style="padding: 10px;border-top:1px solid #F3F3F3" colspan="3"> 
                                    <table style="width: 100%; text-align: center;"> 
                                        <tr style="border:1px solid transparent !important;">
                                            <td style="text-align: center; vertical-align: middle; width: 100%;">
                                                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 100px;"><br>
                                                <p style="font-size: 14px;font-feature-settings: 'lnum' 1;border-bottom:0px;color: #181818;font-weight:400">Copyright © BlackBag  {{date('Y')}}. All rights reserved.</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            @else
                <div class="nopreview-sec">
                    <img src="{{asset('images/nopreview.png')}}" class="img-fluid" frameborder="0" alt="No Preview">
                </div>
            @endif
        </table>

    </div>

    </body>
</html>