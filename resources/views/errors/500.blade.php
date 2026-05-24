<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Server Error">
    <title>500 - Server Error</title>
    <link rel="icon" type="image/png" href="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png">
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .error-container {
            text-align: center;
            max-width: 500px;
        }

        .error-code {
            font-family: 'Fraunces', serif;
            font-size: 120px;
            font-weight: 300;
            color: var(--danger);
            line-height: 1;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .error-title {
            font-family: 'Fraunces', serif;
            font-size: 32px;
            font-weight: 300;
            color: var(--ink);
            margin-bottom: 12px;
            letter-spacing: -0.01em;
        }

        .error-message {
            font-size: 15px;
            color: var(--ink-muted);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .error-icon {
            width: 80px;
            height: 80px;
            background: var(--danger-lt);
            border-radius: var(--radius-lg);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }

        .error-icon svg {
            width: 40px;
            height: 40px;
            color: var(--danger);
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--ink);
            color: #FFFFFF;
            font-family: 'Geist', sans-serif;
            font-size: 14px;
            font-weight: 500;
            padding: 12px 24px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            transition: background 0.2s, transform 0.1s;
            letter-spacing: 0.01em;
        }

        .action-btn:hover {
            background: #2A2821;
        }

        .action-btn:active {
            transform: scale(0.98);
        }

        .action-btn.danger {
            background: var(--danger);
        }

        .action-btn.danger:hover {
            background: #6D2213;
        }

        .links {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        @media (max-width: 640px) {
            .error-code { font-size: 80px; }
            .error-title { font-size: 24px; }
            .error-icon { width: 64px; height: 64px; }
            .error-icon svg { width: 32px; height: 32px; }
        }
    </style>
</head>
<body>

    <div class="error-container">
        <div class="error-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="error-code">500</div>
        <h1 class="error-title">Server Error</h1>
        <p class="error-message">
            Something went wrong on our end. Our team has been notified and is working to fix the issue. Please try again later.
        </p>
        <div class="links">
            <a href="{{ url('/') }}" class="action-btn danger">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Go Home
            </a>
            <a href="javascript:location.reload()" class="action-btn">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M23 4v6h-6"/>
                    <path d="M1 20v-6h6"/>
                    <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/>
                </svg>
                Try Again
            </a>
        </div>
    </div>

</body>
</html>
