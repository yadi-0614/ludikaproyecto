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
    }

    .cat-page { padding: 2rem 0; }

    /* ── Hero ── */
    .cat-hero {
        background: #1E6F5C ;
        border-radius: 20px;
        padding: 28px;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 8px 30px rgba(30,111,92,0.25);
    }
    .hero-icon {
        width: 50px; height: 50px;
        background: rgba(255,255,255,0.15);
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 13px;
        display: flex; align-items: center; justify-content: center;
    }
    .cat-hero h1 { color: #fff; font-size: 1.6rem; font-weight: 800; margin: 0; }
    .cat-hero p { color: rgba(255,255,255,0.7); font-size: 0.85rem; margin: 2px 0 0; }

    /* ── Cards ── */
    .cat-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(30,111,92,0.1);
        border: 1.5px solid #d6ead8;
        overflow: hidden;
    }
    .cat-card-header {
        background: #eef6ef;
        padding: 16px 20px;
        border-bottom: 1.5px solid #d6ead8;
        font-weight: 700;
        color: var(--verde-selva);
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: .05em;
    }
    .cat-card-body { padding: 24px; }

    /* ── Form components ── */
    .lbl { display: block; font-size: 0.78rem; font-weight: 700; color: var(--verde-selva); margin-bottom: 6px; text-transform: uppercase; }
    .ctrl {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid #b5d9bc;
        border-radius: 12px;
        background: #f7faf7;
        font-size: 0.92rem;
        outline: none;
        transition: all .2s;
    }
    .ctrl:focus { border-color: var(--verde-selva); background: #fff; box-shadow: 0 0 0 3px rgba(30,111,92,0.1); }

    .btn-save {
        background: var(--verde-selva);
        color: #fff;
        border: none;
        border-radius: 50px;
        padding: 10px 24px;
        font-weight: 700;
        font-size: 0.88rem;
        box-shadow: 0 4px 14px rgba(30,111,92,0.3);
        transition: transform .15s;
        width: 100%;
    }
    .btn-save:hover { transform: scale(1.02); color: #fff; opacity: 0.9; }

    /* ── Table ── */
    .cat-table th { font-weight: 700; color: #666; font-size: 0.75rem; text-transform: uppercase; }
    .cat-table td { vertical-align: middle; padding: 14px 8px; color: var(--negro-bosque); }
    .badge-count {
        background: #eef6ef;
        color: var(--verde-selva);
        font-weight: 700;
        font-size: 0.75rem;
        padding: 3px 9px;
        border-radius: 50px;
    }
    .btn-action {
        width: 32px; height: 32px;
        border-radius: 8px;
        display: inline-flex; align-items: center; justify-content: center;
        border: none;
        transition: all .2s;
        text-decoration: none;
    }
    .btn-edit { background: #eef6ef; color: var(--verde-selva); }
    .btn-edit:hover { background: var(--verde-selva); color: #fff; }
    .btn-del { background: #fdf2f2; color: #c0392b; }
    .btn-del:hover { background: #c0392b ; color: #fff; }

    .alert-ludika {
        background: #1E6F5C ;
        color: #fff;
        border: none;
        border-radius: 14px;
        padding: 14px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
    }
</style>
@endsection

<div class="container cat-page">

    {{-- Hero --}}
    <div class="cat-hero">
        <div class="hero-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                <line x1="7" y1="7" x2="7.01" y2="7"/>
            </svg>
        </div>
        <div>
            <h1>Categorías</h1>
            <p>Organiza tus productos por tipos para facilitar la búsqueda</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert-ludika">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger" style="border-radius:14px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        {{-- Sidebar: Add/Edit --}}
        <div class="col-lg-4">
            <div class="cat-card">
                <div class="cat-card-header" id="formTitle">Nueva Categoría</div>
                <div class="cat-card-body">
                    <form action="{{ route('categories.store') }}" method="POST" id="catForm">
                        @csrf
                        <div id="methodField"></div>
                        <div class="mb-3">
                            <label class="lbl">Nombre de la categoría</label>
                            <input type="text" name="name" id="catName" class="ctrl @error('name') is-invalid @enderror" placeholder="Ej. Bebidas, Botanas..." value="{{ old('name') }}" required>
                            @error('name')
                                <span class="text-danger small">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn-save" id="btnSubmit">
                            <span id="labelSubmit">Guardar Categoría</span>
                        </button>
                        <button type="button" class="btn btn-link btn-sm mt-2 w-100 text-muted" id="btnCancel" style="display:none;" onclick="resetForm()">Cancelar edición</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Main Table --}}
        <div class="col-lg-8">
            <div class="cat-card">
                <div class="cat-card-header">Categorías Registradas</div>
                <div class="cat-card-body p-0">
                    <div class="table-responsive">
                        <table class="table cat-table mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Nombre</th>
                                    <th class="text-center">Productos</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $category->name }}</td>
                                        <td class="text-center">
                                            <span class="badge-count">{{ $category->products_count }}</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <div style="display:flex;gap:6px;justify-content:flex-end;">
                                                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}')" class="btn-action btn-edit" title="Editar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                                </button>
                                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn-action btn-del" title="Eliminar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">No hay categorías registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@section('js')
<script>
    function editCategory(id, name) {
        document.getElementById('formTitle').innerText = 'Editar Categoría';
        document.getElementById('catName').value = name;
        document.getElementById('catName').focus();
        document.getElementById('labelSubmit').innerText = 'Actualizar Categoría';
        
        let form = document.getElementById('catForm');
        form.action = '/categories/' + id;
        
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PATCH">';
        document.getElementById('btnCancel').style.display = 'block';
    }

    function resetForm() {
        document.getElementById('formTitle').innerText = 'Nueva Categoría';
        document.getElementById('catName').value = '';
        document.getElementById('labelSubmit').innerText = 'Guardar Categoría';
        
        let form = document.getElementById('catForm');
        form.action = "{{ route('categories.store') }}";
        
        document.getElementById('methodField').innerHTML = '';
        document.getElementById('btnCancel').style.display = 'none';
    }
</script>
@endsection

</x-layout>
