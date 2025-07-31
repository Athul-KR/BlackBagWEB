<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/favicon.png') }}" sizes="64x64" type="image/png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success | BlackBag</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-container {
            max-width: 500px;
            background: white;
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .success-img {
            max-width: 120px;
        }
    </style>
</head>
<body>

    <div class="success-container">
        <img src="{{ asset('frontend/images/sucess.png') }}" alt="Success" class="success-img mb-4">
        <h3 class="fw-bold">Welcome to BlackBag</h3>
        <p class="text-muted">Account created successfully! Start your premium trial now.</p>
        <a href="javascript:void(0);" onclick="submitTrialPlan();" class="btn btn-primary btn-lg w-100">Start Premium Trial</a>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function submitTrialPlan() {
        $.ajax({
            type: "POST",
            url: "{{ URL::to('subscriptions/storetrialplan')}}",
            data: {
                "_token": "{{ csrf_token() }}"
            },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
            dataType: 'json',
            success: function(data) {
                if (data.success == '1') {
                    window.location.href = "{{url('/dashboard')}}";
                } else {
                    swal(data.message, '', 'error');
                }
            }
        });
    }
</script>
</body>
</html>