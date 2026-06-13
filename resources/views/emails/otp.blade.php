<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code</title>
</head>
<body style="margin:0;padding:0;background-color:#F5F2EC;font-family:'Helvetica Neue',Helvetica,Arial,sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#F5F2EC;padding:40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:520px;">

                    <!-- Logo / Header -->
                    <tr>
                        <td align="center" style="padding-bottom:24px;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#3478F6 0%,#1A54C4 100%);border-radius:16px;padding:12px 20px;">
                                        <span style="font-size:15px;font-weight:700;color:#fff;letter-spacing:-0.3px;">
                                            Certificate Portal
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Card -->
                    <tr>
                        <td style="background:#FDFCFA;border:1px solid rgba(0,0,0,0.07);border-radius:20px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,0.06);">

                            <!-- Blue top banner -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background:linear-gradient(135deg,#3478F6 0%,#1A54C4 100%);padding:32px 32px 48px;text-align:center;">
                                        <div style="display:inline-block;width:64px;height:64px;background:rgba(255,255,255,0.2);border:2px solid rgba(255,255,255,0.4);border-radius:18px;line-height:64px;text-align:center;margin-bottom:16px;">
                                            <img src="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png" width="38" height="38" alt="Logo" style="vertical-align:middle;border-radius:8px;">
                                        </div>
                                        <p style="margin:0 0 6px;font-size:11px;font-weight:600;letter-spacing:0.14em;text-transform:uppercase;color:rgba(255,255,255,0.75);">
                                            {{ $subject ?? 'Security Verification' }}
                                        </p>
                                        <h1 style="margin:0;font-size:28px;font-weight:800;color:#fff;letter-spacing:-0.5px;">
                                            Verification Code
                                        </h1>
                                    </td>
                                </tr>
                            </table>

                            <!-- Body content -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding:32px 32px 28px;">

                                        <p style="margin:0 0 8px;font-size:15px;color:#131210;line-height:1.5;">
                                            Hi{{ isset($name) ? ', <strong>' . $name . '</strong>' : '' }},
                                        </p>
                                        <p style="margin:0 0 28px;font-size:14px;color:#8A877F;line-height:1.6;">
                                            {{ $message ?? 'Use the code below to complete your sign in. This code will expire in 10 minutes.' }}
                                        </p>

                                        <!-- OTP Code box -->
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td align="center" style="background:#EBF2FF;border:1.5px dashed #3478F6;border-radius:16px;padding:24px 16px;">
                                                    <p style="margin:0 0 6px;font-size:11px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#3478F6;">
                                                        Your Code
                                                    </p>
                                                    <p style="margin:0;font-size:44px;font-weight:800;letter-spacing:12px;color:#131210;font-family:'Courier New',monospace;">
                                                        {{ $otp }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Expiry notice -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top:20px;">
                                            <tr>
                                                <td style="background:#FFF8E6;border-radius:10px;padding:12px 16px;">
                                                    <p style="margin:0;font-size:13px;color:#92681A;line-height:1.5;">
                                                        ⏱ This code expires in <strong>10 minutes</strong>. Do not share it with anyone.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Divider -->
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin:28px 0 0;">
                                            <tr>
                                                <td style="border-top:1px solid rgba(0,0,0,0.06);padding-top:24px;">
                                                    <p style="margin:0;font-size:13px;color:#8A877F;line-height:1.6;">
                                                        If you didn't request this code, you can safely ignore this email. Someone may have entered your email address by mistake.
                                                    </p>
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
