<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Claim Update</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background:#F2F3F5;font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:40px 16px;background:#F2F3F5;">
<tr><td align="center">

  <table width="560" cellpadding="0" cellspacing="0" border="0" style="max-width:560px;width:100%;">

    <!-- Brand -->
    <tr>
      <td align="center" style="padding-bottom:18px;">
        <span style="font-size:11px;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:#8E8E93;">KEVIENSTUDIO.MY.ID</span>
      </td>
    </tr>

    <!-- Card -->
    <tr>
      <td style="background:#FFFFFF;border-radius:24px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08),0 1px 4px rgba(0,0,0,0.04);">

        <!-- Hero -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="background:linear-gradient(135deg,#FF3B30 0%,#C41E3A 100%);padding:40px 36px 36px;text-align:center;">

              <!-- Badge -->
              <div style="display:inline-block;background:rgba(255,255,255,0.15);border-radius:50px;padding:6px 14px;margin-bottom:20px;">
                <span style="display:inline-block;width:6px;height:6px;background:#FF9F0A;border-radius:50%;vertical-align:middle;margin-right:8px;"></span>
                <span style="font-size:11px;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:#FFFFFF;vertical-align:middle;">Claim Not Approved</span>
              </div>

              <!-- Icon -->
              <div style="margin:0 auto 20px;width:64px;height:64px;background:rgba(255,255,255,0.15);border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                </svg>
              </div>

              <h1 style="font-family:'Inter',sans-serif;font-size:28px;font-weight:700;color:#FFFFFF;margin:0 0 8px;line-height:1.2;letter-spacing:-0.5px;">Claim Not Approved</h1>
              <p style="font-size:14px;color:rgba(255,255,255,0.85);margin:0;">We reviewed your submission and couldn't approve it</p>

            </td>
          </tr>
        </table>

        <!-- Body -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="padding:32px 36px 28px;">

              <!-- Greeting -->
              <p style="font-size:15px;color:#1C1C1E;margin:0 0 12px;">Dear <strong style="color:#1C1C1E;font-weight:600;">{{ $name }}</strong>,</p>
              <p style="font-size:14px;color:#8E8E93;line-height:1.7;margin:0 0 24px;">
                Thank you for submitting your certificate claim for <strong style="color:#1C1C1E;font-weight:600;">{{ $event }}</strong>. After reviewing your submission, we're unable to approve it at this time. Please see the reason below.
              </p>

              <!-- Rejection reason block -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:24px;">
                <tr>
                  <td style="background:#FFEEED;border:1px solid #F5D4CA;border-left:3px solid #FF3B30;border-radius:12px;padding:18px 20px;">
                    <p style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:#B02020;margin:0 0 8px;">Reason for Rejection</p>
                    <p style="font-size:14px;color:#5C2E1E;line-height:1.6;margin:0;">{{ $rejectionReason }}</p>
                  </td>
                </tr>
              </table>

              <!-- What to do block -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F2F3F5;border-radius:16px;margin-bottom:24px;">
                <tr>
                  <td style="padding:18px 20px 6px;">
                    <p style="font-size:11px;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:#8E8E93;margin:0 0 12px;">What You Can Do</p>
                  </td>
                </tr>

                <!-- Step 1 -->
                <tr>
                  <td style="padding:0 20px 14px;">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td valign="top" width="32">
                          <div style="width:24px;height:24px;background:#E5E5EA;border-radius:50%;text-align:center;line-height:24px;font-size:12px;font-weight:600;color:#8E8E93;">1</div>
                        </td>
                        <td style="padding-left:12px;">
                          <p style="font-size:14px;color:#1C1C1E;line-height:1.6;margin:0;">Review the reason above and ensure your submission meets all requirements.</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <tr><td style="padding:0 20px 14px;"><div style="height:1px;background:#E5E5EA;"></div></td></tr>

                <!-- Step 2 -->
                <tr>
                  <td style="padding:0 20px 18px;">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td valign="top" width="32">
                          <div style="width:24px;height:24px;background:#E5E5EA;border-radius:50%;text-align:center;line-height:24px;font-size:12px;font-weight:600;color:#8E8E93;">2</div>
                        </td>
                        <td style="padding-left:12px;">
                          <p style="font-size:14px;color:#1C1C1E;line-height:1.6;margin:0;">If you believe this is an error, contact our support team with your <strong style="font-weight:600;">participant number</strong> and any supporting documents.</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

              </table>

              <!-- Divider -->
              <div style="height:1px;background:#E5E5EA;margin-bottom:20px;"></div>

              <!-- Footer note -->
              <p style="font-size:13px;color:#8E8E93;line-height:1.6;margin:0;">
                We apologize for any inconvenience. Our support team is available to help clarify the decision or assist you with a new submission.
              </p>

            </td>
          </tr>
        </table>

        <!-- Bottom strip -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="background:#F2F3F5;border-top:1px solid #E5E5EA;border-radius:0 0 24px 24px;padding:16px 30px;text-align:center;">
              <p style="font-size:11px;color:#AEAEB2;line-height:1.7;margin:0;">
                You received this email because a certificate was claimed under your account.<br>
                &copy; {{ date('Y') }} kevienstudio.my.id &middot; All rights reserved.
              </p>
            </td>
          </tr>
        </table>

      </td>
    </tr>

  </table>
</td></tr>
</table>

</body>
</html>