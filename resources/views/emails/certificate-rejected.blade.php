<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Rejected</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
            <h1 style="color: #dc3545; text-align: center;">Certificate Claim Rejected</h1>
            
            <p>Dear <strong>{{ $name }}</strong>,</p>
            
            <p>We regret to inform you that your certificate claim for <strong>{{ $event }}</strong> has been rejected.</p>
            
            <div style="background: #f8d7da; border: 1px solid #f5c6cb; padding: 15px; border-radius: 5px; margin: 20px 0;">
                <strong>Reason for rejection:</strong>
                <p>{{ $rejectionReason }}</p>
            </div>
            
            <p>If you believe this is an error, please contact our support team with your participant number.</p>
            
            <hr style="margin: 30px 0; border: none; border-top: 1px solid #ddd;">
            
            <p style="font-size: 12px; color: #666;">
                If you have any questions, please contact our support team.
            </p>
        </div>
    </div>
</body>
</html>
