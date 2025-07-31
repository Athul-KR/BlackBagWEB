<!DOCTYPE html>
<html lang="en">

<head>
  
<link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
<meta name="keywords" content="HTML, CSS, JavaScript">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title> @if(isset($seo['title']) && !empty($seo['title'])) {{$seo['title']  }} @else BlackBag  @endif</title>
<meta name='keywords' content="<?php echo (isset($seo['keywords']) && $seo['keywords']!= '') ? $seo['keywords'] : ''; ?>"/>
<meta name="description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : ''; ?> ">
<meta property="og:title" content="<?php echo (isset($seo['title']) && $seo['title']!= '') ? $seo['title'] : '{{ TITLE }}'; ?> ">
<meta property="og:description" content="<?php echo (isset($seo['description']) && $seo['description']!= '') ? $seo['description'] : '{{ TITLE }}'; ?>">
<meta property="og:image" content="<?php echo (isset($seo['image']) && $seo['image']!= '') ? $seo['image'] : asset('images/og-img.png') ?>">
<meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet" href="{{ asset('css/videochat/index.css')}}?v=10" />
  <link rel="stylesheet" href="{{ asset('css/videochat/join.css')}}?v=10" />
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=medication" />
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
 </head>


<body class="waitingtojoin">
  
  <div class="container">
           <div class="join-page text-center thankyou-sec">
            <div class="join-dtls thank-msg ">
              <div class="text-center ">
                <img class="img-fluid" src="{{asset('images/support.png')}}">
                <h3>Thank you for using</h3>
                <h2>BlackBag</h2>
                <a class="btn btn-primary" href="{{url('appointments')}}" style="color: #fff;margin-top: 15px;">Appointments</a>
              </div>
            </div>
          </div>
    </div>
</body>

</html>

