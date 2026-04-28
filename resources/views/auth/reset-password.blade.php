<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setel Ulang Password — ASAK Agency</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Space+Grotesk:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { background: #080c18; color: #e8e4d5; font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .input-field { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); color: #e8e4d5; width: 100%; border-radius: 10px; height: 44px; padding: 0 12px; font-size: 14px; outline: none; transition: border-color 0.2s; }
        .input-field:focus { border-color: #b8960c; }
        .input-field::placeholder { color: #4b5563; }
    </style>
</head>
<body>
    <div style="width: 100%; max-width: 440px; padding: 24px;">
        <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 24px; padding: 40px;">
            <!-- Logo -->
            <div style="text-align: center; margin-bottom: 32px;">
                <div style="width: 48px; height: 48px; background: #b8960c; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-weight: 800; font-size: 20px; color: white;">A</div>
                <h1 style="font-family: 'Space Grotesk', sans-serif; font-size: 20px; font-weight: 700; margin: 0 0 4px;">asak<span style="color: #b8960c">digital</span></h1>
                <p style="color: #9ca3af; font-size: 14px; margin-top: 8px;">Setel Ulang Password</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 6px;">Email</label>
                    <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus
                           class="input-field" placeholder="admin@asak.agency">
                    @error('email')
                    <p style="color: #f87171; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 16px;">
                    <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 6px;">Password Baru</label>
                    <input type="password" name="password" required
                           class="input-field" placeholder="••••••••">
                    @error('password')
                    <p style="color: #f87171; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-size: 12px; color: #9ca3af; margin-bottom: 6px;">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="input-field" placeholder="••••••••">
                    @error('password_confirmation')
                    <p style="color: #f87171; font-size: 12px; margin-top: 4px;">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                        style="width: 100%; height: 44px; background: #b8960c; color: white; border: none; border-radius: 10px; font-weight: 600; font-size: 14px; cursor: pointer; transition: opacity 0.2s;"
                        onmouseover="this.style.opacity='0.85'" onmouseout="this.style.opacity='1'">
                    Simpan Password Baru
                </button>
            </form>
        </div>
    </div>
</body>
</html>
