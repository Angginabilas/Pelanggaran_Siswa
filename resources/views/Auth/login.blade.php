<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>login-bimbingan konseling</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to bottom, #ffffff, #e6e6e6);
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container-login {
            display: flex;
            flex-wrap: wrap;
            background: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
        }

        .left-side, .right-side {
            flex: 1;
            padding: 40px;
        }

        .left-side {
            background: #f9f9f9;
            text-align: center;
        }

        .left-side img {
            width: 100px;
            margin-bottom: 20px;
        }

        .left-side h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .left-side p {
            font-size: 14px;
            color: #555;
            max-width: 400px;
            margin: auto;
        }

        .right-side {
            background: #fff;
        }

        .form-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-control {
            padding-left: 40px;
            height: 45px;
        }

        .form-check-label {
            margin-left: 5px;
            font-size: 0.9rem;
        }

        .login-btn {
            background-color: #006d77;
            color: white;
            font-weight: bold;
        }

        .forgot-link {
            font-size: 0.9rem;
            color: orange;
            text-decoration: none;
        }

        .login-header {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 25px;
        }

        .login-header i {
            margin-right: 10px;
            font-size: 1.4rem;
        }

        @media (max-width: 768px) {
            .container-login {
                flex-direction: column;
            }

            .left-side, .right-side {
                padding: 30px;
            }
        }
    </style>
</head>
<body>

<div class="container-login">
    <div class="left-side">
        <img src="https://cdn-icons-png.flaticon.com/512/561/561127.png" alt="Mail Icon">
        <h2>Aplikasi Pelanggaran Siswa Berbasis WEB</h2>
        <p>
            Selamat Datang Di Sistem Informasi Pelanggaran Siswa Di Sekolah SMA Koperasi Pontianak Berbasis WEB
        </p>
    </div>

    <div class="right-side">
        <div class="login-header">
            <i class="fas fa-user-lock"></i> Halaman Login
        </div>

                {{-- Notifikasi error login --}}
                @if ($errors->any())
                    <div class="alert alert-danger text-center mt-2 mb-3 p-2">
                        {{ $errors->first() }}
                    </div>
                @endif
                
        <form method="POST" action="{{ route('Auth.login') }}">
            @csrf

            <div class="form-group">
                <i class="fas fa-user form-icon"></i>
                <input type="email" name="email" class="form-control" placeholder="Email / Username" required autofocus>
            </div>

            <div class="form-group">
                <i class="fas fa-lock form-icon"></i>
                <input type="password" name="password" id="password-field" class="form-control" placeholder="Password" required>
                <i class="far fa-eye" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor: pointer; color: #aaa;"></i>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>
                <a class="register" href="{{ route('password.request') }}">Lupa Password?</a>
            </div>

            <button type="submit" class="btn login-btn w-100">
                <i class="fas fa-sign-in-alt me-2"></i> Login
            </button>
        </form>
    </div>
</div>
        <script>
document.getElementById("togglePassword").addEventListener("click", function () {
    const password = document.getElementById("password-field");
    const icon = this;
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    icon.classList.toggle("fa-eye");
    icon.classList.toggle("fa-eye-slash");
});
</script>

</body>
</html>