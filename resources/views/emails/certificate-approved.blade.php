<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Approved</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
            <h1 style="color: #28a745; text-align: center;">Congratulations!</h1>
            
            <p>Dear <strong>{{ $name }}</strong>,</p>
            
            <p>Your certificate claim for <strong>{{ $event }}</strong> has been approved!</p>
            
            <p><strong>Certificate Number:</strong> {{ $certificateNumber }}</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $downloadUrl }}" style="background: #28a745; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-weight: bold;">
                    Download Your Certificate
                </a>
            </div>
            
            <p>Your certificate is also attached to this email. If the attachment appears incorrect, please use the <strong>Download Your Certificate</strong> button above which always provides the latest version.</p>
            
            <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
            
            <p style="font-size: 12px; color: #666;">
                If you have any questions, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>
