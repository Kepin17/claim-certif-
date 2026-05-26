<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Claim Has Been Re-opened</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
</head>
<body style="margin:0;padding:0;background-color:#EDEAE4;font-family:'DM Sans',Arial,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#EDEAE4;padding:40px 16px;">
<tr><td align="center">

  <table width="600" cellpadding="0" cellspacing="0" border="0" style="max-width:600px;width:100%;">

    <!-- Org label -->
    <tr>
      <td align="center" style="padding-bottom:20px;">
        <span style="font-size:11px;font-weight:500;letter-spacing:0.12em;text-transform:uppercase;color:#7A766E;">&#9679;&nbsp;&nbsp;Your Organization</span>
      </td>
    </tr>

    <!-- Card -->
    <tr>
      <td style="background-color:#FFFFFF;border-radius:16px;overflow:hidden;">

        <!-- Hero -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="background-color:#1A2E14;padding:48px 40px 40px;text-align:center;">

              <!-- Badge -->
              <div style="display:inline-block;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:100px;padding:6px 16px 6px 12px;margin-bottom:28px;">
                <span style="display:inline-block;width:6px;height:6px;background:#7EC86A;border-radius:50%;vertical-align:middle;margin-right:8px;"></span>
                <span style="font-size:11px;font-weight:500;letter-spacing:0.1em;text-transform:uppercase;color:#7EC86A;vertical-align:middle;">Claim Re-opened</span>
              </div>

              <!-- Icon -->
              <div style="margin:0 auto 24px;width:72px;height:72px;">
                <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="36" cy="36" r="35" stroke="rgba(255,255,255,0.07)" stroke-width="1"/>
                  <circle cx="36" cy="36" r="22" fill="rgba(126,200,106,0.10)" stroke="#7EC86A" stroke-width="1.5"/>
                  <path d="M44 30a10 10 0 1 0 2 6" stroke="#7EC86A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  <polyline points="46 26 46 32 40 32" stroke="#7EC86A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </div>

              <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:34px;font-weight:400;color:#FFFFFF;margin:0 0 10px;line-height:1.15;letter-spacing:-0.02em;">Claim Re-opened</h1>
              <p style="font-size:14px;color:rgba(255,255,255,0.38);margin:0;">Your certificate claim has been re-opened for review</p>

            </td>
          </tr>
        </table>

        <!-- Body -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="padding:36px 40px 32px;">

              <!-- Greeting -->
              <p style="font-size:15px;color:#3A3730;margin:0 0 10px;">Dear <strong style="color:#1E1410;font-weight:500;">{{ $name }}</strong>,</p>
              <p style="font-size:15px;color:#6B6760;margin:0 0 28px;line-height:1.6;">
                We have reviewed your previous rejection and decided to <strong style="color:#1E1410;">re-open your certificate claim</strong> for the following event:
              </p>

              <!-- Event Info -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F7F5F0;border-radius:12px;margin-bottom:28px;">
                <tr>
                  <td style="padding:20px 24px;">
                    <p style="font-size:11px;font-weight:500;letter-spacing:0.1em;text-transform:uppercase;color:#9A9690;margin:0 0 6px;">Event</p>
                    <p style="font-size:16px;font-weight:500;color:#1E1410;margin:0;">{{ $event }}</p>
                  </td>
                </tr>
              </table>

              <!-- What to do -->
              <p style="font-size:15px;color:#3A3730;margin:0 0 16px;font-weight:500;">What should you do next?</p>
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                <tr>
                  <td style="padding:12px 0;border-bottom:1px solid #F0EDE8;">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="padding-right:12px;vertical-align:top;padding-top:2px;">
                          <div style="width:24px;height:24px;background:#EBF2E3;border-radius:6px;text-align:center;line-height:24px;">
                            <span style="font-size:13px;color:#2D5016;">1</span>
                          </div>
                        </td>
                        <td>
                          <p style="font-size:14px;color:#3A3730;margin:0;font-weight:500;">Check your attendance proof</p>
                          <p style="font-size:13px;color:#9A9690;margin:4px 0 0;">Make sure you have valid evidence of event attendance if required.</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 0;border-bottom:1px solid #F0EDE8;">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="padding-right:12px;vertical-align:top;padding-top:2px;">
                          <div style="width:24px;height:24px;background:#EBF2E3;border-radius:6px;text-align:center;line-height:24px;">
                            <span style="font-size:13px;color:#2D5016;">2</span>
                          </div>
                        </td>
                        <td>
                          <p style="font-size:14px;color:#3A3730;margin:0;font-weight:500;">Your claim is now pending re-review</p>
                          <p style="font-size:13px;color:#9A9690;margin:4px 0 0;">Our team will review your claim again shortly. No additional action is required unless you are contacted.</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
                <tr>
                  <td style="padding:12px 0;">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td style="padding-right:12px;vertical-align:top;padding-top:2px;">
                          <div style="width:24px;height:24px;background:#EBF2E3;border-radius:6px;text-align:center;line-height:24px;">
                            <span style="font-size:13px;color:#2D5016;">3</span>
                          </div>
                        </td>
                        <td>
                          <p style="font-size:14px;color:#3A3730;margin:0;font-weight:500;">Track your claim status</p>
                          <p style="font-size:13px;color:#9A9690;margin:4px 0 0;">You can monitor your claim status anytime using the link below.</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>

              <!-- CTA -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:32px;">
                <tr>
                  <td align="center">
                    <a href="{{ $trackUrl }}" style="display:inline-block;background:#2D5016;color:#FFFFFF;font-size:14px;font-weight:500;padding:14px 32px;border-radius:8px;text-decoration:none;letter-spacing:0.02em;">
                      Track My Claim Status
                    </a>
                  </td>
                </tr>
              </table>

              <!-- Note -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F7F5F0;border-radius:10px;margin-bottom:28px;">
                <tr>
                  <td style="padding:16px 20px;">
                    <p style="font-size:13px;color:#9A9690;margin:0;line-height:1.6;">
                      <strong style="color:#6B6760;">Note:</strong> If you believe there was an error or have additional information to support your claim, please contact us by replying to this email.
                    </p>
                  </td>
                </tr>
              </table>

              <p style="font-size:14px;color:#9A9690;margin:0;line-height:1.6;">
                Best regards,<br>
                <strong style="color:#3A3730;">The Certificate Team</strong>
              </p>

            </td>
          </tr>
        </table>

      </td>
    </tr>

    <!-- Footer -->
    <tr>
      <td style="padding:24px 0;text-align:center;">
        <p style="font-size:12px;color:#A8A39B;margin:0;">
          This email was sent regarding your certificate claim. If you have questions, please reply to this email.
        </p>
      </td>
    </tr>

  </table>
</td></tr>
</table>

</body>
</html>
