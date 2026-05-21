<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;1,9..144,300&family=Geist:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --ink:        #131210;
            --ink-mid:    #4A4740;
            --ink-muted:  #8A877F;
            --ink-faint:  #C5C2BB;
            --surface:    #F5F2EC;
            --card:       #FDFCFA;
            --accent:     #2D5016;
            --accent-lt:  #EBF2E3;
            --accent-mid: #4A8022;
            --danger:     #8C2C1A;
            --danger-lt:  #F9EDE9;
            --radius-sm:  6px;
            --radius-md:  12px;
            --radius-lg:  18px;
        }

        body {
            font-family: 'Geist', sans-serif;
            background-color: var(--surface);
            color: var(--ink);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .otp-container {
            max-width: 420px;
            width: 100%;
            padding: 20px;
        }

        .card {
            background: var(--card);
            border: 1px solid rgba(0,0,0,0.07);
            border-radius: var(--radius-lg);
            padding: 40px;
        }

        .title {
            font-family: 'Fraunces', serif;
            font-size: 28px;
            font-weight: 300;
            color: var(--ink);
            text-align: center;
            margin-bottom: 16px;
            letter-spacing: -0.01em;
        }

        .subtitle {
            font-size: 14px;
            color: var(--ink-muted);
            text-align: center;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        /* Alert */
        .alert-error {
            background: var(--danger-lt);
            border: 1px solid rgba(140,44,26,0.2);
            border-left: 3px solid var(--danger);
            border-radius: var(--radius-md);
            padding: 14px 18px;
            margin-bottom: 24px;
        }

        .alert-error p {
            font-size: 13px;
            color: var(--danger);
            margin: 0;
        }

        /* Form */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-mid);
            margin-bottom: 8px;
            display: block;
        }

        .form-input {
            font-family: 'Geist', sans-serif;
            font-size: 14px;
            color: var(--ink);
            background: var(--card);
            border: 1px solid rgba(0,0,0,0.12);
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            transition: border-color 0.2s, box-shadow 0.2s;
            width: 100%;
            text-align: center;
            letter-spacing: 4px;
            font-size: 18px;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(45,80,22,0.1);
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: var(--ink);
            color: #FFFFFF;
            font-family: 'Geist', sans-serif;
            font-size: 15px;
            font-weight: 500;
            padding: 14px 24px;
            border-radius: var(--radius-sm);
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            letter-spacing: 0.01em;
        }

        .submit-btn:hover {
            background: #2A2821;
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        /* Resend Link */
        .resend-link {
            text-align: center;
            margin-top: 24px;
        }

        .resend-link a {
            font-size: 13px;
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .resend-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .card { padding: 32px 24px; }
            .title { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="card">
            <h1 class="title">Verify OTP</h1>
            <p class="subtitle">Enter the 6-digit code sent to your email to complete login.</p>

            @if (session('info'))
                <div style="background: #EBF2E3; border: 1px solid #2D5016; border-left: 3px solid #2D5016; border-radius: 12px; padding: 14px 18px; margin-bottom: 24px;">
                    <p style="font-size: 13px; color: #2D5016; margin: 0;">{{ session('info') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-error">
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-error">
                    <ul class="error-list" style="margin: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.otp.verify.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="otp" class="form-label">OTP Code</label>
                    <input type="text" name="otp" id="otp" class="form-input" placeholder="000000" pattern="[0-9]{6}" maxlength="6" required autofocus>
                </div>

                <button type="submit" class="submit-btn">
                    Verify & Login
                </button>
            </form>

            <div class="resend-link">
                <a href="{{ route('admin.otp.resend') }}">Resend OTP Code</a>
            </div>
        </div>
    </div>
</body>
</html>
