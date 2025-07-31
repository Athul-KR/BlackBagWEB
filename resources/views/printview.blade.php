<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@if(isset($title)) {{TITLE}} - {{$title}} @else {{TITLE}}  @endif</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <link rel="shortcut icon" href="{!! asset('public/img/favicon.png') !!}">
</head>
<body>
    <script>
    $(document).ready(function () {
        var iframe = document.getElementById('pdfdocview');

        iframe.onload = function () {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
        };
    });
</script>

    <div class="container" style="margin:0 auto; text-align:center;">
        <iframe src="{{$printpath}}" width="800px" height="1000px" style="margin:0 auto;" id="pdfdocview"></iframe>
    </div>
</body>
</html>
