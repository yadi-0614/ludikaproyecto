<x-layout>
    <style>
        .form-hero-simple {
            background: #1E6F5C ;
            border-radius: 20px;
            padding: 24px 30px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 8px 30px rgba(30,111,92,0.25);
        }
        .form-hero-simple h1 {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
        }
        .form-hero-simple p {
            color: rgba(255,255,255,0.72);
            font-size: 0.84rem;
            margin: 2px 0 0;
        }
        .btn-back-simple {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,0.18);
            border: 1.5px solid rgba(255,255,255,0.4);
            color: #fff;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            transition: background .2s, transform .15s;
            flex-shrink: 0;
        }
        .btn-back-simple:hover { background: rgba(255,255,255,0.28); color: #fff; transform: scale(1.04); }
    </style>

    <div class="container" style="padding-top: 2rem; padding-bottom: 3rem;">

        {{-- Hero header --}}
        <div class="form-hero-simple">
            <div>
                <h1>{{ isset($company) ? 'Editar' : 'Agregar' }} Empresa</h1>
                <p>{{ isset($company) ? 'Modifica la información de la empresa' : 'Registra una nueva empresa en el sistema' }}</p>
            </div>
            <a href="javascript:history.back()" class="btn-back-simple">
                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                </svg>
                Regresar
            </a>
        </div>

        <form method="POST" action={{ url('/companies') }} 
            class="row g-3 needs-validation" novalidate>
            @csrf
            <input type="hidden" name="id" value="{{ isset($company) ? $company->id : '' }}">
            
            <div class="col-sm-8 col-md-8 col-lg-5">
                <label for="validationCustom01" class="form-label">Nombre</label>
                <input name="name" type="text"
                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="validationCustom01"
                    value="{{ old('name', $company->name ?? '') }}" required maxlength="100">
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('name') ? $errors->first('name') : 'Campo requerido, máx. 100 caracteres.' }}
                </div>
            </div>

            <div class="col-sm-12 col-md-8 col-lg-5">
                <label for="validationCustom02" class="form-label">Descripción</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" 
                    name="description" id="validationCustom02" rows="3"
                    maxlength="255">{{ old('description', $company->description ?? '') }}</textarea>
                <div class="invalid-feedback">
                    {{ isset($errors) && $errors->has('description') ? $errors->first('description') : 'Máximo 255 caracteres.' }}
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">
                    <i class="bi bi-save"></i> {{ isset($company) ? 'Actualizar' : 'Guardar' }} Empresa
                </button>
                <a href="{{ route('companies.index') }}" class="btn btn-secondary ms-2">
                    <i class="bi bi-x-lg"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    @section('styles')
        {{-- Estilos de componentes --}}
        @stack('styles')
    @endsection()

    @section('js')
        <script>
            // Validación de formulario Bootstrap
            (function() {
                'use strict';

                // Obtener todos los formularios que requieren validación
                var forms = document.querySelectorAll('.needs-validation');

                // Iterar y prevenir envío si hay campos inválidos
                Array.prototype.slice.call(forms).forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        }

                        form.classList.add('was-validated');
                    }, false);
                });
            })();

            // Validaciones adicionales en tiempo real con jquery
            // --------------------------------------------------
            // $("#validationCustom01").keyup(function() {
            //     let length = $(this).val().length;
            //     if (length > 0 && length <= 100) {
            //         $(this).removeClass("is-invalid");
            //     } else {
            //         $(this).addClass("is-invalid");
            //     }
            // });

            // $("#validationCustom02").keyup(function() {
            //     let length = $(this).val().length;
            //     if (length <= 255) {
            //         $(this).removeClass("is-invalid");
            //     } else {
            //         $(this).addClass("is-invalid");
            //     }
            // });
        </script>
        {{-- Scripts de componentes --}}
        @stack('scripts')
    @endsection
</x-layout>
