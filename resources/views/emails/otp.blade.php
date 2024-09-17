<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP untuk Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #3572EF;
            padding: 20px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 30px;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.6;
            margin: 20px 0;
        }
        .otp-code {
            display: inline-block;
            background-color: #3572EF;
            color: #ffffff;
            font-weight: bold;
            padding: 10px 20px;
            font-size: 24px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            font-size: 14px;
            background-color: #f4f4f7;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Reset Password</h1>
        </div>
        <div class="email-body">
            <p>Berikut adalah OTP untuk mereset password Anda:</p>
            <p class="otp-code">{{ $otp }}</p>
            <p>OTP ini akan kedaluwarsa dalam waktu <strong>10 menit</strong>.</p>
            <p>Jika Anda tidak melakukan permintaan reset password, abaikan email ini. Akun Anda akan tetap aman.</p>
        </div>
        <div class="email-footer">
            Copyright &copy; 2024 <div class="bullet">SchoolTech Indonesia</div>
        </div>
    </div>
</body>
</html>
