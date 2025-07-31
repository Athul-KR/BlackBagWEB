<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="keywords" content="HTML, CSS, JavaScript">
      <meta name="color-scheme" content="light">
      <meta name="supported-color-schemes" content="light">
      <title>BlackBag Mail</title>
      <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
   </head>

   <!-- Responsive styles -->
 <style>
      @media screen and (max-width: 600px) {
         h1 {
            font-size: 30px;
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

   @media (prefers-color-scheme: dark) {
    /* body {
        color: #FFFFFF !important;
    }

    table {
        background-color: #222222 !important;
    } */

    a{
      background: #fff !important;
      color: #000 !important;
    }

   
}

   </style>
      <body style="font-family: 'Raleway', sans-serif; line-height: 1.25; margin: 0; background-color: #1E1E1E; color: #1D1D1D;">
      <table style="max-width: 640px; margin: 5px auto; padding: 30px; width: 100%; border-collapse: collapse; background-color: #fff; margin: 30px auto; ">
         <tbody>
         <tr>
               <td style="padding: 0;">
                  <table style="width: 100%; background-color: #ffffff; padding: 0 30px 30px 30px; background-image: url('{{ asset('images/mail/banner-top.png') }}'); background-repeat: no-repeat; background-size: contain;">
                     <tr>
                        <td colspan="2" style="text-align: center; padding: 30px 0 30px 0;">
                           <img class="logo" style="width: 230px;" src="{{url('public/images/mail/logo.png')}}"  alt="BlackBag">
                        </td>
                     </tr>
                     @yield('content')
         