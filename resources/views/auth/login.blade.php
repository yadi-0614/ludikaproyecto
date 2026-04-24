@extends('layouts.app')

@section('title', 'Iniciar sesión — Yadira\'s Store')

@section('content')
    <style>
        body {
            background: #f2f5f0;
        }

        .login-wrapper {
            min-height: calc(100vh - 72px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background:
                radial-gradient(ellipse at 20% 80%, rgba(30, 111, 92, 0.10) 0%, transparent 55%),
                radial-gradient(ellipse at 80% 20%, rgba(44, 44, 44, 0.06) 0%, transparent 55%),
                #f2f5f0;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(30, 111, 92, 0.16), 0 4px 16px rgba(30, 111, 92, 0.08);
            border: 1.5px solid #d6ead8;
            overflow: hidden;
            animation: loginCardIn 0.5s cubic-bezier(.34, 1.4, .64, 1) both;
        }

        @keyframes loginCardIn {
            from {
                opacity: 0;
                transform: translateY(30px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .login-header {
            background: #1E6F5C ;
            padding: 34px 32px 28px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .login-header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 130px;
            height: 130px;
            background: rgba(255, 255, 255, 0.07);
            border-radius: 50%;
        }

        .login-header::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
        }

        .login-icon-wrap {
            width: 62px;
            height: 62px;
            background: rgba(255, 255, 255, 0.18);
            border: 2.5px solid rgba(255, 255, 255, 0.45);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
        }

        .login-header h1 {
            color: #fff;
            font-size: 1.45rem;
            font-weight: 800;
            margin: 0 0 4px;
            letter-spacing: -.01em;
        }

        .login-header p {
            color: rgba(255, 255, 255, 0.72);
            font-size: 0.84rem;
            margin: 0;
        }

        .login-body {
            padding: 30px 32px 32px;
        }

        .form-group {
            margin-bottom: 1.15rem;
        }

        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 700;
            color: #1E6F5C;
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 7px;
        }

        .form-input-wrap {
            position: relative;
        }

        .form-input-icon {
            position: absolute;
            left: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #69B578;
            pointer-events: none;
        }

        .form-input {
            width: 100%;
            padding: 11px 44px 11px 40px;
            border: 1.5px solid #b5d9bc;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f7faf7;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
            color: #2d2d2d;
        }

        .password-toggle {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color .2s;
        }

        .password-toggle:hover {
            color: #1E6F5C;
        }

        .form-input:focus {
            border-color: #1E6F5C;
            box-shadow: 0 0 0 3px rgba(30, 111, 92, 0.10);
            background: #fff;
        }

        .form-input.is-invalid {
            border-color: #dc3545;
            background: #fffafa;
        }

        .form-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.15);
            border-color: #dc3545;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.78rem;
            margin-top: 4px;
            display: block;
            font-weight: 600;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.4rem;
        }

        .remember-row input[type="checkbox"] {
            accent-color: #1E6F5C;
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .remember-row label {
            font-size: 0.87rem;
            color: #666;
            cursor: pointer;
            user-select: none;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: #1E6F5C ;
            color: #fff;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 18px rgba(30, 111, 92, 0.35);
            transition: opacity .2s, transform .15s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            letter-spacing: .01em;
        }

        .btn-login:hover {
            opacity: 0.88;
            transform: scale(1.015);
        }

        .login-footer {
            text-align: center;
            margin-top: 1.3rem;
            font-size: 0.87rem;
            color: #888;
        }

        .login-footer a {
            color: #1E6F5C;
            font-weight: 600;
            text-decoration: none;
        }

        .login-footer a:hover {
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 1.2rem 0;
            color: #ccc;
            font-size: 0.78rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #d6ead8;
        }
    </style>

    <div class="login-wrapper">
        <div class="login-card">

            {{-- Header --}}
            <div class="login-header">
                <div class="login-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                </div>
                <h1>Bienvenida de vuelta</h1>
                <p>Inicia sesión en Lúdika</p>
            </div>

            {{-- Body --}}
            <div class="login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="form-group">
                        <label class="form-label" for="email">Correo electrónico</label>
                        <div class="form-input-wrap">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </span>
                            <input id="email" type="email" name="email"
                                class="form-input {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="tu@correo.com">
                        </div>
                        @error('email')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="form-group">
                        <label class="form-label" for="password">Contraseña</label>
                        <div class="form-input-wrap">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input id="password" type="password" name="password"
                                class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}" required
                                autocomplete="current-password" placeholder="••••••••">
                            <div class="password-toggle" onclick="togglePasswordVisibility('password', this)">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="eye-icon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg>
                            </div>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Captcha --}}
                    <div class="form-group">
                        <label class="form-label" for="captcha">Código de seguridad</label>
                        <div class="form-input-wrap">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </span>
                            <input id="captcha" type="text" name="captcha"
                                class="form-input {{ $errors->has('captcha') ? 'is-invalid' : '' }}" required
                                placeholder="Ingresa el código">
                        </div>
                        <div style="margin-top: 10px; text-align: center;">
                            <img src="{{ captcha_src('ludika') }}" onclick="this.src='/captcha/ludika?'+Math.random()" alt="captcha" style="cursor:pointer; border-radius:12px; border:1.5px solid #b5d9bc; max-width: 100%; box-shadow: 0 4px 10px rgba(30,111,92,0.05); transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            <div style="font-size: 0.75rem; color: #888; margin-top: 6px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="vertical-align: middle; margin-right: 2px;">
                                    <polyline points="23 4 23 10 17 10"></polyline>
                                    <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path>
                                </svg>
                                Haz clic en la imagen para recargar
                            </div>
                        </div>
                        @error('captcha')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Remember + Forgot --}}
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1.4rem;">
                        <div class="remember-row" style="margin:0;">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">Recuérdame</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                style="font-size:0.83rem;color:#1E6F5C;font-weight:600;text-decoration:none;">
                                ¿Olvidaste tu contraseña?
                            </a>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <button type="submit" class="btn-login">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4" />
                            <polyline points="10 17 15 12 10 7" />
                            <line x1="15" y1="12" x2="3" y2="12" />
                        </svg>
                        Iniciar sesión
                    </button>
                </form>

                @if (Route::has('register'))
                    <div class="divider">o</div>
                    <div class="login-footer">
                        ¿Aún no tienes cuenta?
                        <a href="{{ route('register') }}">Regístrate aquí</a>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, toggleBtn) {
            const input = document.getElementById(inputId);
            const icon = toggleBtn.querySelector('svg');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
                toggleBtn.style.color = '#1E6F5C';
            } else {
                input.type = 'password';
                icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
                toggleBtn.style.color = '#888';
            }
        }
    </script>
@endsection
