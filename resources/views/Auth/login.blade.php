<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BK App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; }
        body {
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 50%, #c7d2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            display: flex;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(79,70,229,0.15);
            overflow: hidden;
            width: 100%;
            max-width: 960px;
            min-height: 540px;
        }

        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #4f46e5, #3730a3);
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .login-left .brand-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .login-left h2 {
            font-weight: 800;
            font-size: 1.8rem;
            margin-bottom: 12px;
            position: relative;
        }

        .login-left p {
            opacity: 0.8;
            font-size: 0.95rem;
            line-height: 1.6;
            position: relative;
        }

        .login-left .quote {
            margin-top: 30px;
            padding: 16px 20px;
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            font-style: italic;
            font-size: 0.85rem;
            position: relative;
        }

        .login-right {
            flex: 1;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right .header {
            margin-bottom: 28px;
        }

        .login-right .header h3 {
            font-weight: 800;
            color: #1e293b;
            font-size: 1.4rem;
        }

        .login-right .header p {
            color: #64748b;
            font-size: 0.9rem;
            margin: 4px 0 0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 0.85rem;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .input-group-custom {
            position: relative;
        }

        .input-group-custom i.input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
        }

        .input-group-custom input {
            width: 100%;
            padding: 12px 14px 12px 44px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.9rem;
            transition: all 0.2s;
            outline: none;
            background: #f8fafc;
        }

        .input-group-custom input:focus {
            border-color: #4f46e5;
            box-shadow: 0 0 0 3px rgba(79,70,229,0.1);
            background: #fff;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            cursor: pointer;
            background: none;
            border: none;
            font-size: 1.1rem;
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .form-check-label {
            font-size: 0.85rem;
            color: #64748b;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(79,70,229,0.3);
        }

        .btn-login:active { transform: translateY(0); }

        @media (max-width: 768px) {
            .login-container { flex-direction: column; max-width: 440px; }
            .login-left { padding: 32px; }
            .login-left .brand-icon { font-size: 3rem; }
            .login-left h2 { font-size: 1.4rem; }
            .login-right { padding: 32px; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-left">
            <div style="font-size:3rem;margin-bottom:20px;color:#fff;"><i class="bi bi-shield-check"></i></div>
            <h2>Aplikasi Pelanggaran Siswa</h2>
            <p>Sistem Informasi Pelanggaran Siswa di Sekolah SMA Koperasi Pontianak Berbasis Web</p>
            <div class="quote">
                <i class="bi bi-quote me-1"></i> Mendidik bukan hanya mengisi pikiran, tetapi juga membentuk karakter.
            </div>
        </div>

        <div class="login-right">
            <div class="header">
                <h3><i class="bi bi-lock"></i> Halaman Login</h3>
                <p>Masukkan email dan password untuk melanjutkan</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger py-2" style="border-radius:12px;font-size:0.85rem;">
                    <i class="bi bi-exclamation-circle me-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('Auth.login') }}">
                @csrf

                <div class="form-group">
                    <label>Email</label>
                    <div class="input-group-custom">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@admin.com" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <div class="input-group-custom">
                        <i class="bi bi-lock input-icon"></i>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                        <button type="button" class="toggle-password" onclick="togglePass()">
                            <i class="bi bi-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-options">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                </button>
            </form>
        </div>
    </div>

    <script>
        function togglePass() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pwd.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>
