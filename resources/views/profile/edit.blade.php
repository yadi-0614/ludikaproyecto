@extends('layouts.app')

@section('title', 'Mi Perfil — Yadira\'s Store')

@section('content')
    <div class="container" style="max-width:640px;padding-top:2rem;padding-bottom:3rem;">

        {{-- Header --}}
        <div style="text-align:center;margin-bottom:2rem;">
            <div style="display:inline-flex;align-items:center;justify-content:center;
                                    width:64px;height:64px;background: #1E6F5C ;
                                    border-radius:50%;margin-bottom:14px;
                                    box-shadow:0 6px 20px rgba(30,111,92,0.35);">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                    <circle cx="12" cy="7" r="4" />
                </svg>
            </div>
            <h1 style="font-size:1.6rem;font-weight:800;color:#2C2C2C;margin:0;">Mi Perfil</h1>
            <p style="color:#888;font-size:0.9rem;margin:4px 0 0;">Actualiza tu información personal</p>
        </div>

        {{-- Alert de éxito --}}
        @if(session('success'))
            <div style="background: #1E6F5C ;color:#fff;
                                                border-radius:14px;padding:14px 20px;margin-bottom:1.5rem;
                                                display:flex;align-items:center;gap:12px;
                                                box-shadow:0 4px 16px rgba(30,111,92,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                <span style="font-weight:600;font-size:0.92rem;">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background: #f59e0b ;color:#fff;
                        border-radius:14px;padding:14px 20px;margin-bottom:1.5rem;
                        display:flex;align-items:flex-start;gap:12px;
                        box-shadow:0 4px 16px rgba(245,158,11,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px;">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
                <span style="font-weight:600;font-size:0.92rem;">{{ session('error') }}</span>
            </div>
        @endif


        {{-- Card principal --}}
        <div style="background:#fff;border-radius:20px;box-shadow:0 8px 32px rgba(30,111,92,0.12);
                                border:1.5px solid #d6ead8;overflow:hidden;">

            {{-- Avatar header --}}
            <div
                style="background: #1E6F5C ;padding:28px;text-align:center;position:relative;">
                @if(Auth::user()->hasAvatar())
                    <img src="{{ Auth::user()->avatar_url }}" alt="Avatar" style="width:90px;height:90px;border-radius:50%;object-fit:cover;
                                                            border:4px solid rgba(255,255,255,0.6);
                                                            box-shadow:0 4px 18px rgba(0,0,0,0.25);">
                @else
                    <div style="width:90px;height:90px;border-radius:50%;background:rgba(255,255,255,0.2);
                                                            border:4px solid rgba(255,255,255,0.5);display:inline-flex;
                                                            align-items:center;justify-content:center;
                                                            font-size:2.4rem;font-weight:800;color:#fff;
                                                            box-shadow:0 4px 18px rgba(0,0,0,0.2);">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
                <p style="color:rgba(255,255,255,0.9);margin:12px 0 0;font-size:1rem;font-weight:700;">
                    {{ Auth::user()->name }}
                </p>
                <p style="color:rgba(255,255,255,0.65);margin:2px 0 0;font-size:0.82rem;">
                    {{ Auth::user()->email }}
                </p>
            </div>

            {{-- Form --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                style="padding:28px 32px;">
                @csrf
                @method('PATCH')

                {{-- Nombre --}}
                <div style="margin-bottom:1.2rem;">
                    <label
                        style="display:block;font-size:0.82rem;font-weight:700;color:#1E6F5C;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                        Nombre completo
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('name') ? '#1E6F5C' : '#b5d9bc' }};
                                              border-radius:12px;font-size:0.95rem;outline:none;
                                              background:#f7faf7;transition:border-color .2s;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1E6F5C'" onblur="this.style.borderColor='#b5d9bc'"
                        pattern="^[a-zA-Z\s\á\é\í\ó\ú\Á\É\Í\Ó\Ú\ñ\Ñ]+$"
                        title="El nombre no debe contener números ni caracteres especiales">
                    @error('name')
                        <p style="color:#1E6F5C;font-size:0.78rem;margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div style="margin-bottom:1.2rem;">
                    <label
                        style="display:block;font-size:0.82rem;font-weight:700;color:#1E6F5C;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                        Correo electrónico
                    </label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('email') ? '#1E6F5C' : '#b5d9bc' }};
                                              border-radius:12px;font-size:0.95rem;outline:none;
                                              background:#f7faf7;transition:border-color .2s;box-sizing:border-box;"
                        onfocus="this.style.borderColor='#1E6F5C'" onblur="this.style.borderColor='#b5d9bc'">
                    @error('email')
                        <p style="color:#1E6F5C;font-size:0.78rem;margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div style="margin-bottom:1.2rem;">
                    <label style="display:block;font-size:0.82rem;font-weight:700;color:#1E6F5C;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                        Teléfono <span style="font-weight:400;color:#aaa;text-transform:none;">(opcional)</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#69B578;pointer-events:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.62 3.38 2 2 0 0 1 3.6 1.18h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6.13 6.13l.96-.96a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                            </svg>
                        </span>
                        <input type="tel" name="phone" value="{{ old('phone', Auth::user()->phone) }}"
                            style="width:100%;padding:11px 14px 11px 40px;border:1.5px solid {{ $errors->has('phone') ? '#dc3545' : '#b5d9bc' }};
                                border-radius:12px;font-size:0.95rem;outline:none;
                                background:#f7faf7;transition:border-color .2s;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1E6F5C'" onblur="this.style.borderColor='#b5d9bc'"
                            placeholder="+52 123 456 7890"
                            maxlength="15"
                            inputmode="tel"
                            pattern="[0-9\s\+\-\(\)]{7,15}"
                            oninput="this.value=this.value.replace(/[^0-9\s\+\-\(\)]/g,'').substring(0,15);">
                    </div>
                    @error('phone')
                        <p style="color:#dc3545;font-size:0.78rem;margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Dirección --}}
                <div style="margin-bottom:1.2rem;">
                    <label style="display:block;font-size:0.82rem;font-weight:700;color:#1E6F5C;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                        Dirección <span style="font-weight:400;color:#aaa;text-transform:none;">(opcional)</span>
                    </label>
                    <div style="position:relative;">
                        <span style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#69B578;pointer-events:none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                <circle cx="12" cy="10" r="3"/>
                            </svg>
                        </span>
                        <input type="text" name="address" value="{{ old('address', Auth::user()->address) }}"
                            style="width:100%;padding:11px 14px 11px 40px;border:1.5px solid {{ $errors->has('address') ? '#dc3545' : '#b5d9bc' }};
                                border-radius:12px;font-size:0.95rem;outline:none;
                                background:#f7faf7;transition:border-color .2s;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1E6F5C'" onblur="this.style.borderColor='#b5d9bc'"
                            placeholder="Calle, colonia, ciudad...">
                    </div>
                    @error('address')
                        <p style="color:#dc3545;font-size:0.78rem;margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Avatar --}}
                <div style="margin-bottom:1.6rem;">
                    <label
                        style="display:block;font-size:0.82rem;font-weight:700;color:#1E6F5C;margin-bottom:6px;text-transform:uppercase;letter-spacing:.04em;">
                        Foto de perfil
                    </label>
                    <label for="avatar-input" style="display:inline-flex;align-items:center;gap:9px;cursor:pointer;
                                              padding:10px 18px;border:1.5px dashed #69B578;border-radius:12px;
                                              background:#eef6ef;color:#1E6F5C;font-size:0.88rem;font-weight:600;
                                              transition:background .2s;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                            <polyline points="17 8 12 3 7 8" />
                            <line x1="12" y1="3" x2="12" y2="15" />
                        </svg>
                        <span id="avatar-label">Seleccionar imagen</span>
                    </label>
                    <input type="file" id="avatar-input" name="avatar" accept="image/*" style="display:none;"
                        onchange="document.getElementById('avatar-label').textContent = this.files[0]?.name || 'Seleccionar imagen'">
                    <p style="font-size:0.76rem;color:#aaa;margin:5px 0 0;">JPG, PNG o WEBP · máx. 2 MB</p>
                    @error('avatar')
                        <p style="color:#1E6F5C;font-size:0.78rem;margin:4px 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Separador contraseña --}}
                <div
                    style="border-top:1.5px solid #d6ead8;margin:0 -32px 1.6rem;padding-top:1.4rem;padding-left:32px;padding-right:32px;">
                    <p
                        style="font-size:0.82rem;font-weight:700;color:#1E6F5C;text-transform:uppercase;letter-spacing:.04em;margin:0 0 1rem;">
                        Cambiar contraseña
                        <span style="font-weight:400;color:#aaa;text-transform:none;font-size:0.78rem;">(opcional)</span>
                    </p>

                    {{-- Contraseña actual --}}
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.82rem;font-weight:600;color:#555;margin-bottom:6px;">
                            Contraseña actual
                        </label>
                        <input type="password" name="current_password" style="width:100%;padding:11px 14px;border:1.5px solid {{ $errors->has('current_password') ? '#1E6F5C' : '#b5d9bc' }};
                                                  border-radius:12px;font-size:0.95rem;outline:none;
                                                  background:#f7faf7;transition:border-color .2s;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1E6F5C'" onblur="this.style.borderColor='#b5d9bc'"
                            placeholder="••••••••">
                        @error('current_password')
                            <p style="color:#1E6F5C;font-size:0.78rem;margin:4px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nueva contraseña --}}
                    <div style="margin-bottom:1rem;">
                        <label style="display:block;font-size:0.82rem;font-weight:600;color:#555;margin-bottom:6px;">
                            Nueva contraseña
                        </label>
                        <input type="password" name="new_password" style="width:100%;padding:11px 14px;border:1.5px solid #b5d9bc;
                                                  border-radius:12px;font-size:0.95rem;outline:none;
                                                  background:#f7faf7;transition:border-color .2s;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1E6F5C'" onblur="this.style.borderColor='#b5d9bc'"
                            placeholder="Mínimo 8 caracteres, 1 mayúscula y 2 símbolos">
                        @error('new_password')
                            <p style="color:#1E6F5C;font-size:0.78rem;margin:4px 0 0;">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <label style="display:block;font-size:0.82rem;font-weight:600;color:#555;margin-bottom:6px;">
                            Confirmar nueva contraseña
                        </label>
                        <input type="password" name="new_password_confirmation" style="width:100%;padding:11px 14px;border:1.5px solid #b5d9bc;
                                                  border-radius:12px;font-size:0.95rem;outline:none;
                                                  background:#f7faf7;transition:border-color .2s;box-sizing:border-box;"
                            onfocus="this.style.borderColor='#1E6F5C'" onblur="this.style.borderColor='#b5d9bc'"
                            placeholder="Repite la nueva contraseña">
                    </div>
                </div>

                {{-- Botón guardar --}}
                <button type="submit" style="width:100%;padding:13px;background: #1E6F5C ;
                                           color:#fff;border:none;border-radius:50px;font-size:1rem;font-weight:700;
                                           cursor:pointer;box-shadow:0 4px 18px rgba(30,111,92,0.35);
                                           transition:opacity .2s,transform .15s;display:flex;align-items:center;
                                           justify-content:center;gap:9px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <polyline points="17 21 17 13 7 13 7 21" />
                        <polyline points="7 3 7 8 15 8" />
                    </svg>
                    Guardar cambios
                </button>
            </form>
        </div>

        {{-- Enlace volver --}}
        <div style="text-align:center;margin-top:1.4rem;">
            <a href="{{ route('home') }}" style="color:#1E6F5C;font-size:0.88rem;text-decoration:none;font-weight:600;
                                  display:inline-flex;align-items:center;gap:5px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6" />
                </svg>
                Volver a la tienda
            </a>
        </div>
    </div>
    <script>
        // Filtro para evitar números en el campo de nombre
        document.getElementById('name').addEventListener('input', function() {
            this.value = this.value.replace(/[0-9]/g, '');
        });
    </script>
@endsection
