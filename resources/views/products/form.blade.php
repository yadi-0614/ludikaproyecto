<x-layout>

@section('css')
<style>
    :root {
        --verde-profundo: #134E48;
        --verde-selva: #1E6F5C;
        --verde-hoja: #34D399;
        --dorado: #D97706;
        --negro-bosque: #1A202C;
        --slate-50: #F9FAFB;
        --slate-100: #F3F4F6;
        --slate-200: #E5E7EB;
    }

    body {
        background-color: var(--slate-50);
        background-image: 
            radial-gradient(at 0% 0%, rgba(52, 211, 153, 0.08) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(30, 111, 92, 0.08) 0px, transparent 50%);
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .form-page {
        padding: 2.5rem 0 5rem;
    }

    /* ── Hero header ── */
    .form-hero {
        background: #1E6F5C ;
        border-radius: 24px;
        padding: 40px;
        margin-bottom: 35px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        box-shadow: 0 20px 40px -10px rgba(19, 78, 72, 0.4);
        position: relative;
        overflow: hidden;
    }

    .form-hero-icon {
        width: 60px; height: 60px;
        background: rgba(255, 255, 255, 0.12);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        backdrop-filter: blur(10px);
    }

    .form-hero h1 {
        color: #fff;
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
        letter-spacing: -0.03em;
    }

    .form-hero p {
        color: rgba(255, 255, 255, 0.85);
        font-size: 1rem;
        margin: 4px 0 0;
    }

    /* ── Form card ── */
    .form-card {
        background: #fff;
        border-radius: 24px;
        box-shadow: 0 10px 15px -3px rgba(19, 78, 72, 0.05), 0 20px 25px -5px rgba(19, 78, 72, 0.08);
        border: 1px solid var(--slate-200);
        overflow: hidden;
    }

    .form-card-body {
        padding: 45px;
    }

    .lbl {
        display: block;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--verde-profundo);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin-bottom: 10px;
    }

    .ctrl {
        width: 100%;
        padding: 14px 18px;
        border: 2px solid var(--slate-100);
        border-radius: 16px;
        font-size: 1rem;
        background: var(--slate-50);
        color: var(--negro-bosque);
        outline: none;
        transition: all 0.25s ease;
        box-sizing: border-box;
    }

    .ctrl:focus {
        border-color: var(--verde-selva);
        background: #fff;
        box-shadow: 0 0 0 5px rgba(30, 111, 92, 0.08);
    }

    .ctrl.is-invalid {
        border-color: #F87171 !important;
        background-color: #FEF2F2;
    }

    .price-group {
        display: flex;
        border: 2px solid var(--slate-100);
        border-radius: 16px;
        overflow: hidden;
        background: var(--slate-50);
        transition: all 0.25s ease;
    }

    .price-group:focus-within {
        border-color: var(--verde-selva);
        background: #fff;
        box-shadow: 0 0 0 5px rgba(30, 111, 92, 0.08);
    }

    .price-prefix {
        background: var(--slate-100);
        color: var(--verde-selva);
        font-weight: 800;
        padding: 0 20px;
        display: flex;
        align-items: center;
        border-right: 2px solid var(--slate-200);
        font-size: 1.15rem;
    }

    .price-input {
        flex: 1;
        border: none !important;
        background: transparent !important;
        padding: 14px 18px;
        font-size: 1rem;
        font-weight: 600;
        color: var(--negro-bosque);
        outline: none;
    }

    /* ── Divider ── */
    .section-divider {
        border: none;
        border-top: 1.5px solid #d6ead8;
        margin: 28px 0;
    }

    /* ── Buttons ── */
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: #1E6F5C ;
        color: #fff;
        border: none;
        border-radius: 16px;
        padding: 16px 40px;
        font-size: 1.1rem;
        font-weight: 700;
        cursor: pointer;
        box-shadow: 0 10px 25px -5px rgba(19, 78, 72, 0.4);
        transition: all 0.3s ease;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 20px 30px -10px rgba(19, 78, 72, 0.5);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #fff;
        color: var(--slate-500);
        border: 2px solid var(--slate-200);
        border-radius: 16px;
        padding: 15px 35px;
        font-size: 1.05rem;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-cancel:hover {
        background: var(--slate-50);
        border-color: var(--slate-400);
        color: var(--negro-bosque);
    }

    .btn-back {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        padding: 12px 24px;
        border-radius: 14px;
        font-weight: 700;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateX(-5px);
        color: #fff;
    }

    .section-divider {
        border: none;
        border-top: 2px solid var(--slate-100);
        margin: 45px 0;
    }
</style>
@stack('styles')
@endsection

<div class="container form-page">

    {{-- Hero --}}
    <div class="form-hero">
        <div class="form-hero-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none"
                stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                @if(isset($product))
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                @else
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                @endif
            </svg>
        </div>
        <div>
            <h1>{{ isset($product) ? 'Editar producto' : 'Agregar producto' }}</h1>
            <p>{{ isset($product) ? 'Actualiza la información del producto' : 'Registra un nuevo producto en el catálogo' }}</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
            </svg>
            Regresar
        </a>
    </div>

    {{-- Form card --}}
    <div class="form-card">
        <div class="form-card-body">
            <form method="POST" action="{{ url('/products') }}" class="needs-validation" novalidate
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ isset($product) ? $product->id : '' }}">

                <div class="row g-4">

                    {{-- Nombre --}}
                    <div class="col-sm-12 col-md-7 col-lg-5">
                        <label class="lbl">NOMBRE DEL PRODUCTO</label>
                        <input name="name" type="text"
                            class="ctrl {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            value="{{ old('name', $product->name ?? '') }}"
                            placeholder="Ej. Coca-Cola 600ml"
                            required maxlength="40">
                        @error('name')
                            <span class="error-msg">{{ $message }}</span>
                        @else
                            @if($errors->has('name'))
                                <span class="error-msg">Campo requerido, máx. 40 caracteres.</span>
                            @endif
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div class="col-sm-12 col-md-6 col-lg-4">
                        <label class="lbl">CATEGORIA</label>
                        <select name="category_id" id="category_id" 
                            class="ctrl {{ $errors->has('category_id') ? 'is-invalid' : '' }}"
                            onchange="checkCategory(this.value)">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $product->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                            <option value="new" {{ old('category_id') == 'new' ? 'selected' : '' }}>+ Agregar nueva categoría...</option>
                        </select>
                        @error('category_id')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Nueva Categoría (Oculto inicialmente) --}}
                    <div class="col-sm-12 col-md-6 col-lg-3" id="new_category_group" style="{{ old('category_id') == 'new' ? 'display:block;' : 'display:none;' }}">
                        <label class="lbl" style="color:var(--dorado)">Nombre de la nueva categoría</label>
                        <input name="new_category" type="text" id="new_category"
                            class="ctrl {{ $errors->has('new_category') ? 'is-invalid' : '' }}"
                            value="{{ old('new_category') }}"
                            placeholder="Ej. Limpieza, Mascotas..."
                            {{ old('category_id') == 'new' ? 'required' : '' }}>
                        @error('new_category')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Precio --}}
                    <div class="col-sm-6 col-md-5 col-lg-3">
                        <label class="lbl">PRECIO</label>
                        <div class="price-group {{ $errors->has('price') ? 'is-invalid' : '' }}">
                            <span class="price-prefix">$</span>
                            <input name="price" type="number" min="1" step=".01" max="9999999"
                                class="price-input"
                                value="{{ old('price', $product->price ?? '') }}"
                                placeholder="0.00"
                                required>
                        </div>
                        @error('price')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Stock --}}
                    <div class="col-sm-6 col-md-5 col-lg-2">
                        <label class="lbl">STOCK</label>
                        <input name="stock" type="number" min="0" step="1"
                            class="ctrl {{ $errors->has('stock') ? 'is-invalid' : '' }}"
                            value="{{ old('stock', $product->stock ?? 0) }}"
                            placeholder="0"
                            required>
                        @error('stock')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <label class="lbl">DESCRIPCION</label>
                        <textarea name="description" rows="3"
                            class="ctrl {{ $errors->has('description') ? 'is-invalid' : '' }}"
                            style="resize:vertical;min-height:80px;"
                            placeholder="Describe brevemente el producto..."
                            required maxlength="100">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Imagen dropzone --}}
                    <div class="col-12">
                        <label class="lbl">IMAGEN DEL PRODUCTO</label>
                        <x-image-dropzone name="image"
                            :current-image="isset($product) && $product->hasImage() ? $product->image_url : null"
                            :current-image-alt="isset($product) ? $product->name : ''"
                            :error="$errors->first('image')"
                            currentimageclass="col-sm-4 col-md-4 col-lg-3"
                            dropzoneclass="col-sm-8 col-md-8 col-lg-9"
                            title="Arrastra tu imagen aquí"
                            subtitle="o haz clic para seleccionar"
                            help-text="Formatos: JPG, PNG, GIF, SVG, WEBP · Máx. 5 MB"
                            :max-size="5"
                            :show-current-image="true"
                            dropzone-height="180px" />
                    </div>

                </div>

                <hr class="section-divider">

                {{-- Actions --}}
                <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
                    <button type="submit" class="btn-save" id="submitBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        <span id="btnText">{{ isset($product) ? 'Actualizar producto' : 'Guardar producto' }}</span>
                        <span id="btnSpinner" class="d-none" style="display:none">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                style="animation:spin .8s linear infinite">
                                <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                            </svg>
                        </span>
                    </button>
                    <a href="{{ route('products.index') }}" class="btn-cancel">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
                        </svg>
                        Cancelar
                    </a>
                </div>

            </form>
        </div>
    </div>

</div>

@section('js')
<script>
    @keyframes spin { to { transform: rotate(360deg); } }

    (function () {
        'use strict';
        var isSubmitting = false;
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (isSubmitting) { event.preventDefault(); event.stopPropagation(); return; }
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                } else {
                    isSubmitting = true;
                    var btn = document.getElementById('submitBtn');
                    var txt = document.getElementById('btnText');
                    var spn = document.getElementById('btnSpinner');
                    if (btn) { btn.disabled = true; txt.textContent = 'Guardando...'; spn.style.display = 'inline'; }
                }
                form.classList.add('was-validated');
            }, false);
        });

    })();

    // Global function for category toggle
    function checkCategory(val) {
        var group = document.getElementById('new_category_group');
        var input = document.getElementById('new_category');
        if (val === 'new') {
            group.style.display = 'block';
            input.required = true;
            input.focus();
        } else {
            group.style.display = 'none';
            input.required = false;
        }
    }
</script>
@stack('scripts')
@endsection

</x-layout>
