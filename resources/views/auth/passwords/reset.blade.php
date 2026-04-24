@extends('layouts.app')

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
            max-width: 440px;
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
            padding: 11px 12px 11px 40px;
            border: 1.5px solid #b5d9bc;
            border-radius: 12px;
            font-size: 0.95rem;
            background: #f7faf7;
            outline: none;
            transition: border-color .2s, box-shadow .2s;
            box-sizing: border-box;
            color: #2d2d2d;
        }

        .form-input:focus {
            border-color: #1E6F5C;
            box-shadow: 0 0 0 4px rgba(30, 111, 92, 0.12);
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

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #1E6F5C ;
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 0.92rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 6px 20px rgba(30, 111, 92, 0.35);
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(30, 111, 92, 0.45);
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 5px;
            padding-left: 10px;
        }
    </style>

    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="login-icon-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3L15.5 7.5z" />
                    </svg>
                </div>
                <h1>{{ __('Reset Password') }}</h1>
                <p>Establece tu nueva contraseña de acceso</p>
            </div>

            <div class="login-body">
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label class="form-label" for="email">{{ __('Email Address') }}</label>
                        <div class="form-input-wrap">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                            </span>
                            <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="tu@correo.com">
                        </div>
                        @error('email')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">{{ __('Password') }}</label>
                        <div class="form-input-wrap">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                                </svg>
                            </span>
                            <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="••••••••">
                        </div>
                        @error('password')
                            <span class="invalid-feedback">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password-confirm">{{ __('Confirm Password') }}</label>
                        <div class="form-input-wrap">
                            <span class="form-input-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                </svg>
                            </span>
                            <input id="password-confirm" type="password" class="form-input {{ $errors->has('password') ? 'is-invalid' : '' }}" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" class="btn-login" style="margin-top: 10px;">
                        {{ __('Reset Password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
