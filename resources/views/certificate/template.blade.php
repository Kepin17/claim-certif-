<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Times New Roman', serif;
        }
        .certificate {
            width: 210mm;
            height: 297mm;
            padding: 20mm;
            border: 10px solid #1a365d;
            box-sizing: border-box;
            position: relative;
            background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 100%);
        }
        .certificate::before {
            content: '';
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            bottom: 5mm;
            border: 2px solid #1a365d;
            pointer-events: none;
        }
        .header {
            text-align: center;
            margin-bottom: 30mm;
        }
        .header h1 {
            font-size: 48px;
            color: #1a365d;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
        .header p {
            font-size: 18px;
            color: #4a5568;
            margin: 10px 0 0 0;
        }
        .content {
            text-align: center;
            margin: 40mm 0;
        }
        .content h2 {
            font-size: 24px;
            color: #4a5568;
            margin: 0 0 20mm 0;
        }
        .content .name {
            font-size: 42px;
            color: #1a365d;
            font-weight: bold;
            margin: 0 0 20mm 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .content .event {
            font-size: 28px;
            color: #2d3748;
            margin: 0 0 10mm 0;
            font-style: italic;
        }
        .content .date {
            font-size: 18px;
            color: #4a5568;
            margin: 0;
        }
        .footer {
            position: absolute;
            bottom: 20mm;
            left: 20mm;
            right: 20mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .certificate-number {
            font-size: 14px;
            color: #4a5568;
            font-family: monospace;
        }
        .signature {
            text-align: center;
        }
        .signature .line {
            width: 100mm;
            border-top: 2px solid #1a365d;
            margin-bottom: 5px;
        }
        .signature p {
            margin: 0;
            font-size: 14px;
            color: #4a5568;
        }
        .badge {
            position: absolute;
            top: 50%;
            right: 20mm;
            transform: translateY(-50%);
            width: 80mm;
            height: 80mm;
            border: 3px solid #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
        }
        .badge-inner {
            width: 70mm;
            height: 70mm;
            border: 2px solid #d4af37;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }
        .badge-inner span {
            font-size: 16px;
            color: #1a365d;
            font-weight: bold;
        }
        .badge-inner small {
            font-size: 12px;
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="header">
            <h1>Certificate of Completion</h1>
            <p>This certificate is proudly presented to</p>
        </div>
        
        <div class="content">
            <h2>This is to certify that</h2>
            <div class="name">{{ $name }}</div>
            <div class="event">has successfully completed</div>
            <div class="event">{{ $event }}</div>
            <div class="date">on {{ $date }}</div>
        </div>
        
        <div class="badge">
            <div class="badge-inner">
                <span>VERIFIED</span>
                <small>{{ $certificateNumber }}</small>
            </div>
        </div>
        
        <div class="footer">
            <div class="certificate-number">
                Certificate No: {{ $certificateNumber }}
            </div>
            <div class="signature">
                <div class="line"></div>
                <p>Event Organizer</p>
            </div>
        </div>
    </div>
</body>
</html>
