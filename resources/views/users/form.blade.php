<x-layout>

    @section('css')
        <style>
            :root {
                --verde-selva: #1E6F5C;
                --verde-hoja: #69B578;
                --dorado: #C9A227;
                --negro-bosque: #2C2C2C;
                --bg-page: #f2f5f0;
            }

            body {
                background: var(--bg-page);
                font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            }

            .form-page {
                padding: 2rem 0 3rem;
            }

            /* ── Hero header ── */
            .form-hero {
                background: #1E6F5C ;
                border-radius: 20px;
                padding: 28px 32px;
                margin-bottom: 28px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                box-shadow: 0 8px 30px rgba(30, 111, 92, 0.25);
                position: relative;
                overflow: hidden;
            }

            .form-hero::before {
                content: '';
                position: absolute;
                top: -30px;
                right: -30px;
                width: 140px;
                height: 140px;
                background: rgba(255, 255, 255, 0.06);
                border-radius: 50%;
            }

            .hero-left {
                display: flex;
                align-items: center;
                gap: 16px;
                position: relative;
                z-index: 1;
            }

            .hero-icon {
                width: 52px;
                height: 52px;
                background: rgba(255, 255, 255, 0.15);
                border: 2px solid rgba(255, 255, 255, 0.3);
                border-radius: 14px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .hero-title {
                color: #fff;
                font-size: 1.7rem;
                font-weight: 800;
                margin: 0;
                letter-spacing: -.02em;
            }

            .hero-subtitle {
                color: rgba(255, 255, 255, 0.72);
                font-size: 0.85rem;
                margin: 2px 0 0;
            }

            .btn-back {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(255, 255, 255, 0.18);
                border: 1.5px solid rgba(255, 255, 255, 0.4);
                color: #fff;
                font-weight: 700;
                font-size: 0.92rem;
                padding: 10px 22px;
                border-radius: 50px;
                cursor: pointer;
                text-decoration: none;
                transition: background .2s, transform .15s;
                position: relative;
                z-index: 1;
                backdrop-filter: blur(4px);
            }

            .btn-back:hover {
                background: rgba(255, 255, 255, 0.28);
                color: #fff;
                transform: scale(1.04);
            }

            /* ── Form card ── */
            .form-card {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 4px 24px rgba(30, 111, 92, 0.10);
                border: 1.5px solid #d6ead8;
                overflow: hidden;
                padding: 32px;
            }

            .form-card .form-label {
                font-weight: 700;
                font-size: 0.88rem;
                color: var(--verde-selva);
                margin-bottom: 6px;
                text-transform: uppercase;
                letter-spacing: .03em;
            }

            .form-card .form-control {
                border: 1.5px solid #b5d9bc;
                border-radius: 12px;
                padding: 10px 14px;
                font-size: 0.95rem;
                background: #f7faf7;
                color: var(--negro-bosque);
                transition: border-color .2s, box-shadow .2s;
            }

            .form-card .form-control:focus {
                border-color: var(--verde-selva);
                box-shadow: 0 0 0 3px rgba(30, 111, 92, 0.12);
                background: #fff;
            }

            .form-card .form-control.is-invalid {
                border-color: #c0392b;
            }

            .form-card .invalid-feedback {
                font-size: 0.82rem;
                font-weight: 600;
                color: #c0392b;
            }

            .btn-submit {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: #1E6F5C ;
                color: #fff;
                font-weight: 700;
                font-size: 0.95rem;
                padding: 12px 28px;
                border-radius: 50px;
                border: none;
                cursor: pointer;
                transition: opacity .2s, transform .15s;
                box-shadow: 0 4px 16px rgba(30, 111, 92, 0.35);
            }

            .btn-submit:hover {
                opacity: .88;
                transform: scale(1.02);
            }

            .btn-cancel {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: #eef6ef;
                color: var(--verde-selva);
                font-weight: 700;
                font-size: 0.95rem;
                padding: 12px 28px;
                border-radius: 50px;
                border: 1.5px solid #d6ead8;
                cursor: pointer;
                text-decoration: none;
                transition: background .2s, transform .15s;
            }

            .btn-cancel:hover {
                background: #d6ead8;
                color: var(--verde-selva);
                transform: scale(1.02);
            }

            .pw-wrap {
                position: relative;
            }

            .pw-wrap .form-control {
                padding-right: 44px;
            }

            .pw-toggle {
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                color: #888;
                cursor: pointer;
                padding: 4px;
                display: flex;
                align-items: center;
                transition: color .2s;
            }

            .pw-toggle:hover { color: #1E6F5C; }

            .form-actions {
                display: flex;
                gap: 12px;
                margin-top: 28px;
                padding-top: 24px;
                border-top: 1.5px solid #eef6ef;
            }

            .section-label {
                font-size: 0.82rem;
                font-weight: 700;
                color: var(--verde-selva);
                text-transform: uppercase;
                letter-spacing: .06em;
                margin-bottom: 16px;
                padding-bottom: 8px;
                border-bottom: 2px solid #eef6ef;
                display: flex;
                align-items: center;
                gap: 8px;
            }

            @media (max-width: 600px) {
                .form-hero {
                    padding: 20px 18px;
                    flex-direction: column;
                    gap: 16px;
                    text-align: center;
                }

                .hero-left {
                    flex-direction: column;
                }

                .hero-title {
                    font-size: 1.3rem;
                }

                .form-card {
                    padding: 20px;
                }
            }
        </style>
    @endsection

    <div class="container form-page">

        {{-- Hero header --}}
        <div class="form-hero">
            <div class="hero-left">
                <div class="hero-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        @if(isset($user))
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        @else
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="8.5" cy="7" r="4"/>
                            <line x1="20" y1="8" x2="20" y2="14"/>
                            <line x1="23" y1="11" x2="17" y2="11"/>
                        @endif
                    </svg>
                </div>
                <div>
                    <h1 class="hero-title">{{ isset($user) ? 'Editar' : 'Agregar' }} usuario</h1>
                    <p class="hero-subtitle">{{ isset($user) ? 'Modifica la información del usuario' : 'Registra un nuevo usuario en el sistema' }}</p>
                </div>
            </div>
            <a href="{{ route('users.index') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/>
                    <polyline points="12 19 5 12 12 5"/>
                </svg>
                <span>Volver</span>
            </a>
        </div>

        {{-- Form card --}}
        <div class="form-card">
            <form method='POST' action={{ isset($user) ? route('users.store') : route('users.store') }}
                class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ isset($user) ? $user->id : '' }}">

                {{-- Personal Info Section --}}
                <div class="col-12">
                    <div class="section-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                        Información personal
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="name" class="form-label">Nombre</label>
                    <input name="name" type="text"
                        class="form-control {{ $errors->has('name')? 'is-invalid' : ''}}" id="name"
                        value="{{ old('name', $user->name ?? '') }}" required maxlength="255"
                        placeholder="Nombre completo"
                        pattern="^[a-zA-Z\s\á\é\í\ó\ú\Á\É\Í\Ó\Ú\ñ\Ñ]+$"
                        title="El nombre no debe contener números ni caracteres especiales">
                    <div class="invalid-feedback">
                        {{ isset($errors) && $errors->has('name') ? $errors->first('name') : 'Campo requerido.' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email"
                        class="form-control {{ $errors->has('email')? 'is-invalid' : ''}}" id="email"
                        value="{{ old('email', $user->email ?? '') }}" required maxlength="255"
                        placeholder="correo@ejemplo.com">
                    <div class="invalid-feedback">
                        {{ isset($errors) && $errors->has('email') ? $errors->first('email') : 'Campo requerido y debe ser un email válido.' }}
                    </div>
                </div>

                {{-- Security Section --}}
                <div class="col-12 mt-4">
                    <div class="section-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        Seguridad
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password" class="form-label">Contraseña {{ isset($user) ? '(Dejar en blanco para mantener actual)' : '' }}</label>
                    <div class="pw-wrap">
                        <input name="password" type="password"
                            class="form-control {{ $errors->has('password')? 'is-invalid' : ''}}" id="password"
                            {{ !isset($user) ? 'required' : '' }} minlength="8"
                            placeholder="Mínimo 8 caracteres, 1 mayúscula y 2 símbolos">
                        <button type="button" class="pw-toggle" onclick="togglePw('password', this)" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    <div class="invalid-feedback">
                        {{ isset($errors) && $errors->has('password') ? $errors->first('password') : 'Mínimo 8 caracteres.' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <div class="pw-wrap">
                        <input name="password_confirmation" type="password"
                            class="form-control" id="password_confirmation"
                            {{ !isset($user) ? 'required' : '' }} minlength="8"
                            placeholder="Repetir contraseña">
                        <button type="button" class="pw-toggle" onclick="togglePw('password_confirmation', this)" tabindex="-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Avatar Section --}}
                <div class="col-12 mt-4">
                    <div class="section-label">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                            <circle cx="8.5" cy="8.5" r="1.5"/>
                            <polyline points="21 15 16 10 5 21"/>
                        </svg>
                        Avatar
                    </div>
                </div>

                <x-image-dropzone
                    name="avatar"
                    :current-image="isset($user) && $user->hasAvatar() ? $user->avatar_url : null"
                    :current-image-alt="isset($user) ? $user->name : ''"
                    :error="$errors->first('avatar')"
                    currentimageclass="col-sm-4 col-md-5 col-lg-4"
                    dropzoneclass="col-sm-8 col-md-7 col-lg-8"
                    title="Arrastra tu avatar aquí"
                    subtitle="o haz clic para seleccionar"
                    help-text="Formatos: JPG, PNG, GIF, SVG, WEBP"
                    :max-size="5"
                    :show-current-image="true"
                    dropzone-height="200px"
                />

                {{-- Action Buttons --}}
                <div class="col-12">
                    <div class="form-actions">
                        <button class="btn-submit" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                            Guardar Usuario
                        </button>
                        <a href="{{ route('users.index') }}" class="btn-cancel">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="18" y1="6" x2="6" y2="18"/>
                                <line x1="6" y1="6" x2="18" y2="18"/>
                            </svg>
                            Cancelar
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @section('styles')
        @stack('styles')
    @endsection()

    @section('js')
        <script>
            function togglePw(inputId, btn) {
                var input = document.getElementById(inputId);
                var svg = btn.querySelector('svg');
                if (input.type === 'password') {
                    input.type = 'text';
                    svg.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
                    btn.style.color = '#1E6F5C';
                } else {
                    input.type = 'password';
                    svg.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
                    btn.style.color = '#888';
                }
            }

            (function() {
                'use strict';
                var forms = document.querySelectorAll('.needs-validation');
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
            })();

            // Filtro para evitar números en el campo de nombre
            document.getElementById('name').addEventListener('input', function() {
                this.value = this.value.replace(/[0-9]/g, '');
            });
        </script>
        @stack('scripts')
    @endsection
</x-layout>
