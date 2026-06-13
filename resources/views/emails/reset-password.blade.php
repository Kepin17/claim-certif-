<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="margin:0;padding:0;background-color:#F5F2EC;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F5F2EC;padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;">

                    <!-- Logo -->
                    <tr>
                        <td align="center" style="padding-bottom:24px;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#3478F6 0%,#1A54C4 100%);border-radius:16px;padding:12px 20px;">
                                        <span style="font-size:15px;font-weight:700;color:#fff;letter-spacing:-0.3px;">Certificate Portal</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Card -->
                    <tr>
                        <td style="background:#FDFCFA;border:1px solid rgba(0,0,0,0.07);border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06);">

                            <!-- Blue banner -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#3478F6 0%,#1A54C4 100%);padding:32px 32px 48px;text-align:center;">
                                        <div style="display:inline-block;width:64px;height:64px;background:rgba(255,255,255,0.2);border:2px solid rgba(255,255,255,0.4);border-radius:18px;line-height:64px;text-align:center;margin-bottom:16px;">
                                            <img src="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png" width="38" height="38" alt="Logo" style="vertical-align:middle;border-radius:8px;">
                                        </div>
                                        <p style="margin:0 0 6px;font-size:11px;font-weight:600;letter-spacing:0.14em;text-transform:uppercase;color:rgba(255,255,255,0.75);">
                                            Account Security
                                        </p>
                                        <h1 style="margin:0;font-size:28px;font-weight:800;color:#fff;letter-spacing:-0.5px;">
                                            Reset Your Password
                                        </h1>
                                    </td>
                                </tr>
                            </table>

                            <!-- Body -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:32px 32px 28px;">

                                        <p style="margin:0 0 8px;font-size:15px;color:#131210;line-height:1.5;">
                                            Hi, <strong>{{ $name }}</strong>,
                                        </p>
                                        <p style="margin:0 0 28px;font-size:14px;color:#8A877F;line-height:1.6;">
                                            We received a request to reset the password for your account. Click the button below to create a new password.
                                        </p>

                                        <!-- CTA Button -->
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center">
                                                    <a href="{{ $url }}" style="display:inline-block;background:linear-gradient(135deg,#3478F6 0%,#2563EB 100%);color:#fff;font-size:15px;font-weight:700;text-decoration:none;padding:16px 36px;border-radius:14px;letter-spacing:-0.2px;box-shadow:0 4px 16px rgba(52,120,246,0.4);">
                                                        Reset Password
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Expiry notice -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:24px;">
                                            <tr>
                                                <td style="background:#FFF8E6;border-radius:10px;padding:12px 16px;">
                                                    <p style="margin:0;font-size:13px;color:#92681A;line-height:1.5;">
                                                        ⏱ This link will expire in <strong>60 minutes</strong>. If you didn't request a password reset, no action is needed.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Fallback URL -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
                                            <tr>
                                                <td style="border-top:1px solid rgba(0,0,0,0.06);padding-top:20px;">
                                                    <p style="margin:0 0 6px;font-size:12px;color:#8A877F;">If the button doesn't work, copy and paste this URL into your browser:</p>
                                                    <p style="margin:0;font-size:11px;color:#3478F6;word-break:break-all;">{{ $url }}</p>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding-top:24px;">
                            <p style="margin:0;font-size:12px;color:#AEAEB2;">
                                © {{ date('Y') }} Certificate Portal. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
