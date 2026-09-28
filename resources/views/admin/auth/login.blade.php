<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Arkle Homes</title>
    <link rel="icon" type="image/png" href="{{ asset(setting('site_logo', 'images/logo/arkle-homes-logo.png')) }}">
    <link rel="stylesheet" href="{{ asset('css/arkle-admin.css') }}">
    <style>
        body.login-screen {
            background-color: #0D1C24;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }
        .login-card {
            background: #FFFFFF;
            width: 100%;
            max-width: 440px;
            border-radius: 8px;
            padding: 44px 38px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(229, 169, 60, 0.3);
        }
        .login-logo {
            text-align: center;
            margin-bottom: 28px;
        }
        .login-logo img {
            height: 64px;
            margin: 0 auto 12px auto;
        }
        .login-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            color: #0D1C24;
            text-align: center;
            margin-bottom: 6px;
        }
        .login-subtitle {
            font-size: 0.88rem;
            color: #64748B;
            text-align: center;
            margin-bottom: 28px;
        }
    </style>
</head>
<body class="login-screen">

    <div class="login-card">
        <div class="login-logo">
            <img src="{{ asset(setting('site_logo', 'images/logo/arkle-homes-logo.png')) }}" alt="Arkle Homes">
            <h1 class="login-title">Control Panel Sign In</h1>
            <p class="login-subtitle">Arkle Homes Administration & Content Management</p>
        </div>

        @if(session('success'))
            <div class="admin-alert admin-alert-success" style="margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="admin-alert admin-alert-danger" style="margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="admin-alert admin-alert-danger" style="margin-bottom: 20px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.login.submit') }}" method="POST">
            @csrf

            <div class="admin-form-group">
                <label for="email" class="admin-form-label">Email Address</label>
                <input type="email" id="email" name="email" class="admin-form-control" value="{{ old('email') }}" placeholder="name@arklehomes.com.au" required autofocus autocomplete="email">
            </div>

            <div class="admin-form-group">
                <label for="password" class="admin-form-label">Password</label>
                <input type="password" id="password" name="password" class="admin-form-control" placeholder="••••••••••••" required autocomplete="current-password">
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                <label class="switch-label" style="font-size: 0.85rem; color: #475569;">
                    <input type="checkbox" name="remember" value="1" checked style="accent-color: #E5A93C;">
                    Remember My Session
                </label>
            </div>

            <button type="submit" class="btn-admin btn-admin-gold" style="width: 100%; justify-content: center; padding: 12px; font-size: 0.95rem;">
                Sign In to Dashboard &rarr;
            </button>
        </form>

        <div style="text-align: center; margin-top: 24px;">
            <a href="{{ route('home') }}" style="color: #64748B; font-size: 0.82rem; text-decoration: none;">
                &larr; Return to Public Website
            </a>
        </div>
    </div>

</body>
</html>
