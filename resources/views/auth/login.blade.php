<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — ASAK Agency</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { 
            background: #0A1520; 
            color: #F5EDD8; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }
        .login-card {
            background: rgba(255, 255, 255, 0.03); 
            border: 1px solid rgba(255, 255, 255, 0.08); 
            backdrop-filter: blur(20px);
            border-radius: 24px; 
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }
        .input-field { 
            background: rgba(255, 255, 255, 0.05); 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            color: #F5EDD8; 
            width: 100%; 
            border-radius: 12px; 
            height: 48px; 
            padding: 0 16px; 
            font-size: 14px; 
            outline: none; 
            transition: all 0.3s ease; 
        }
        .input-field:focus { 
            border-color: #FBC246; 
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(251, 194, 70, 0.1);
        }
        .input-field::placeholder { color: #64748b; }
        .btn-primary {
            width: 100%; 
            height: 48px; 
            background: #FBC246; 
            color: #0A1520; 
            border: none; 
            border-radius: 12px; 
            font-weight: 700; 
            font-size: 14px; 
            cursor: pointer; 
            transition: all 0.3s ease;
            font-family: 'Space Grotesk', sans-serif;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }
        .btn-primary:hover {
            background: #e5b13d;
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -10px rgba(251, 194, 70, 0.5);
        }
    </style>
</head>
<body>
    <div style="width: 100%; max-width: 440px; padding: 24px;">
        <div class="login-card">
            <!-- Logo -->
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 48px; height: 48px; background: #FBC246; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-weight: 800; font-size: 20px; color: #0A1520; font-family: 'Space Grotesk', sans-serif;">A</div>
                <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 20px; font-weight: 700; margin: 0 0 4px; letter-spacing: -0.02em;">asak<span style="color: #FBC246">digital</span></h1>
                <p style="color: #8FA8BF; font-size: 11px; text-transform: uppercase; letter-spacing: 0.2em; font-weight: 600;">Admin Access</p>
            </div>

            @if(session('status'))
            <div style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.2); color: #86efac; padding: 12px 16px; border-radius: 10px; font-size: 14px; margin-bottom: 20px;">
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #8FA8BF; margin-bottom: 8px;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="input-field" placeholder="admin@asak.agency">
                    @error('email')
                    <p style="color: #f87171; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #8FA8BF; margin-bottom: 8px;">Password</label>
                    <input type="password" name="password" required
                           class="input-field" placeholder="••••••••">
                    @error('password')
                    <p style="color: #f87171; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-size: 13px; color: #8FA8BF; font-weight: 500;">
                        <input type="checkbox" name="remember" style="accent-color: #FBC246; width: 16px; height: 16px;">
                        Remember session
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size: 12px; color: #FBC246; text-decoration: none; font-weight: 600;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <button type="submit" class="btn-primary">
                    Login to System
                </button>
            </form>

            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ route('home') }}" style="font-size: 12px; color: #64748b; text-decoration: none; font-weight: 500; transition: color 0.3s;" onmouseover="this.style.color='#FBC246'" onmouseout="this.style.color='#64748b'">
                    ← Back to website
                </a>
            </div>
        </div>
    </div>
</body>
</html>
