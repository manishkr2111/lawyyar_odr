<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Password Reset</title>
</head>

<body style="margin:0; padding:0; background:#f4f4f4; font-family: Arial, sans-serif;">

    <div style="max-width:600px; margin:40px auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.1);">

        <div style="background:#b19604; color:#fff; padding:20px; text-align:center;">
            <h2 style="margin:0; font-size:24px;">Password Reset Request</h2>
        </div>

        <div style="padding:30px; color:#333;">
            <p style="font-size:16px;">Hello <strong>{{ $user->name }}</strong>,</p>

            <p style="font-size:15px; line-height:1.6;">
                We received a request to reset your password.
                Click the button below to choose a new one.
            </p>

            <div style="text-align:center; margin:30px 0;">
                <a href="{{ $resetUrl }}"
                    style="background:#b19604; color:#fff; padding:12px 20px; text-decoration:none; font-size:16px; border-radius:6px; display:inline-block;">
                    Reset Password
                </a>
            </div>

            <p style="font-size:14px; color:#666; line-height:1.6;">
                If you didn't request this, you can safely ignore this email.
                This reset link will expire soon.
            </p>

            <p style="font-size:14px; margin-top:30px;">
                Thanks,<br>
                <strong>Support Team</strong>
            </p>
        </div>

        <div style="background:#b19604; padding:12px; text-align:center; font-size:12px; color:#777;">
            © {{ date('Y') }} Your Company. All rights reserved.
        </div>

    </div>

</body>

</html>