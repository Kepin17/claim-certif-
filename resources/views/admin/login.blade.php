<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,500;1,9..144,300&family=Geist:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Geist', sans-serif;
            background: #F2F3F5;
            color: #1C1C1E;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-container {
            max-width: 480px;
            width: 100%;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 24px;
            padding: 40px 36px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.04);
        }

        .logo-area {
            text-align: center;
            margin-bottom: 28px;
        }

        .logo-area img {
            width: 56px;
            height: 56px;
            object-fit: contain;
            border-radius: 12px;
            margin-bottom: 16px;
        }

        .title {
            font-family: 'Fraunces', serif;
            font-size: 28px;
            font-weight: 500;
            color: #1C1C1E;
            text-align: center;
            margin-bottom: 8px;
            letter-spacing: -0.3px;
        }

        .subtitle {
            font-size: 14px;
            color: #8E8E93;
            text-align: center;
            margin-bottom: 28px;
        }

        /* Alert */
        .alert-error {
            background: #FFEEED;
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 24px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .alert-error svg {
            width: 18px;
            height: 18px;
            color: #FF3B30;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .alert-error p {
            font-size: 13px;
            color: #B02020;
            margin: 0;
            line-height: 1.45;
        }

        /* Form */
        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            color: #8E8E93;
            margin-bottom: 8px;
            display: block;
        }

        .form-input {
            font-family: 'Geist', sans-serif;
            font-size: 15px;
            color: #1C1C1E;
            background: #F2F3F5;
            border: 1.5px solid transparent;
            border-radius: 14px;
            padding: 14px 16px;
            transition: border-color 0.18s, background 0.18s, box-shadow 0.18s;
            width: 100%;
        }

        .form-input:focus {
            outline: none;
            background: #fff;
            border-color: #3478F6;
            box-shadow: 0 0 0 3px rgba(52,120,246,0.12);
        }

        .form-input::placeholder {
            color: #AEAEB2;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 24px;
        }

        .checkbox-group input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #3478F6;
        }

        .checkbox-group label {
            font-size: 14px;
            color: #3C3C43;
            cursor: pointer;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #3478F6;
            color: #fff;
            font-family: 'Geist', sans-serif;
            font-size: 15px;
            font-weight: 600;
            padding: 16px 24px;
            border-radius: 16px;
            border: none;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s;
            box-shadow: 0 2px 10px rgba(52,120,246,0.28);
        }

        .submit-btn:hover {
            background: #2563EB;
        }

        .submit-btn:active {
            transform: scale(0.98);
        }

        /* Back Link */
        .back-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #F2F3F5;
        }

        .back-link a {
            font-size: 13px;
            color: #3478F6;
            text-decoration: none;
            font-weight: 600;
        }

        .back-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 640px) {
            .card { padding: 32px 24px; border-radius: 20px; }
            .title { font-size: 24px; }
            .login-container { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="card">
            <div class="logo-area">
                <img src="https://r2.fivemanage.com/eMY1LhlRUcWrX4POpj5V0/kepin/logo_certif.png" alt="Logo">
                <h1 class="title">Admin Login</h1>
                <p class="subtitle">Sign in to manage certificates</p>
            </div>

            @if (session('error'))
                <div class="alert-error">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <p>{{ session('error') }}</p>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" name="email" id="email" class="form-input" placeholder="admin@example.com" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Remember me</label>
                </div>

                <button type="submit" class="submit-btn">
                    Sign In
                </button>
            </form>

            <div class="back-link">
                <a href="{{ route('certificate.index') }}">← Back to Home</a>
            </div>
        </div>
    </div>
</body>
</html>
