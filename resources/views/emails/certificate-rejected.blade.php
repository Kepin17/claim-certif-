<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Claim Update</title>
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
            <td style="background-color:#1E1410;padding:48px 40px 40px;text-align:center;">

              <!-- Badge -->
              <div style="display:inline-block;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:100px;padding:6px 16px 6px 12px;margin-bottom:28px;">
                <span style="display:inline-block;width:6px;height:6px;background:#F0836A;border-radius:50%;vertical-align:middle;margin-right:8px;"></span>
                <span style="font-size:11px;font-weight:500;letter-spacing:0.1em;text-transform:uppercase;color:#F0836A;vertical-align:middle;">Claim Not Approved</span>
              </div>

              <!-- Icon -->
              <div style="margin:0 auto 24px;width:72px;height:72px;">
                <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <circle cx="36" cy="36" r="35" stroke="rgba(255,255,255,0.07)" stroke-width="1"/>
                  <circle cx="36" cy="36" r="22" fill="rgba(240,131,106,0.10)" stroke="#F0836A" stroke-width="1.5"/>
                  <path d="M29 29l14 14M43 29L29 43" stroke="#F0836A" stroke-width="2" stroke-linecap="round"/>
                </svg>
              </div>

              <h1 style="font-family:'DM Serif Display',Georgia,serif;font-size:34px;font-weight:400;color:#FFFFFF;margin:0 0 10px;line-height:1.15;letter-spacing:-0.02em;">Claim Not Approved</h1>
              <p style="font-size:14px;color:rgba(255,255,255,0.38);margin:0;">We reviewed your submission and couldn't approve it</p>

            </td>
          </tr>
        </table>

        <!-- Body -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="padding:36px 40px 32px;">

              <!-- Greeting -->
              <p style="font-size:15px;color:#3A3730;margin:0 0 10px;">Dear <strong style="color:#1E1410;font-weight:500;">{{ $name }}</strong>,</p>
              <p style="font-size:14px;color:#7A766E;line-height:1.75;margin:0 0 28px;">
                Thank you for submitting your certificate claim for <strong style="color:#3A3730;font-weight:500;">{{ $event }}</strong>. After reviewing your submission, we're unable to approve it at this time. Please see the reason below.
              </p>

              <!-- Rejection reason block -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:28px;">
                <tr>
                  <td style="background:#FDF2EF;border:1px solid #F5D4CA;border-left:3px solid #D95F3F;border-radius:10px;padding:20px 22px;">
                    <p style="font-size:10px;font-weight:500;letter-spacing:0.1em;text-transform:uppercase;color:#B86550;margin:0 0 10px;">Reason for Rejection</p>
                    <p style="font-size:14px;color:#5C2E1E;line-height:1.7;margin:0;">{{ $rejectionReason }}</p>
                  </td>
                </tr>
              </table>

              <!-- What to do block -->
              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#F7F4EF;border-radius:12px;margin-bottom:28px;">
                <tr>
                  <td style="padding:18px 20px 6px;">
                    <p style="font-size:10px;font-weight:500;letter-spacing:0.1em;text-transform:uppercase;color:#A8A49D;margin:0 0 12px;">What You Can Do</p>
                  </td>
                </tr>

                <!-- Step 1 -->
                <tr>
                  <td style="padding:0 20px 14px;">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td valign="top" width="32">
                          <div style="width:24px;height:24px;background:#EDEBE6;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:500;color:#7A766E;">1</div>
                        </td>
                        <td style="padding-left:12px;">
                          <p style="font-size:13px;color:#3A3730;line-height:1.6;margin:0;">Review the reason above and ensure your submission meets all requirements.</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

                <tr><td style="padding:0 20px 14px;"><div style="height:1px;background:#E8E4DE;"></div></td></tr>

                <!-- Step 2 -->
                <tr>
                  <td style="padding:0 20px 18px;">
                    <table cellpadding="0" cellspacing="0" border="0">
                      <tr>
                        <td valign="top" width="32">
                          <div style="width:24px;height:24px;background:#EDEBE6;border-radius:50%;text-align:center;line-height:24px;font-size:11px;font-weight:500;color:#7A766E;">2</div>
                        </td>
                        <td style="padding-left:12px;">
                          <p style="font-size:13px;color:#3A3730;line-height:1.6;margin:0;">If you believe this is an error, contact our support team with your <strong style="font-weight:500;">participant number</strong> and any supporting documents.</p>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>

              </table>

              <!-- Divider -->
              <div style="height:1px;background:#EBE8E3;margin-bottom:24px;"></div>

              <!-- Footer note -->
              <p style="font-size:13px;color:#A8A49D;line-height:1.65;margin:0;">
                We apologize for any inconvenience. Our support team is available to help clarify the decision or assist you with a new submission.
              </p>

            </td>
          </tr>
        </table>

        <!-- Bottom strip -->
        <table width="100%" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td style="background:#F7F4EF;border-top:1px solid #EBE8E3;border-radius:0 0 16px 16px;padding:18px 40px;text-align:center;">
              <p style="font-size:11px;color:#B0ACA5;line-height:1.7;margin:0;">
                You received this email because a certificate was claimed under your account.<br>
                &copy; {{ date('Y') }} Your Organization &middot; All rights reserved.
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