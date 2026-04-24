<x-layout>

    @section('css')
        <style>
            /* ===== LÚDIKA PALETTE ===== */
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

            /* ── Page wrapper ── */
            .products-page {
                padding: 2rem 0 3rem;
            }

            /* ── Hero header ── */
            .products-hero {
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

            .products-hero::before {
                content: '';
                position: absolute;
                top: -30px;
                right: -30px;
                width: 140px;
                height: 140px;
                background: rgba(255, 255, 255, 0.06);
                border-radius: 50%;
            }

            .products-hero::after {
                content: '';
                position: absolute;
                bottom: -50px;
                left: 20px;
                width: 180px;
                height: 180px;
                background: rgba(255, 255, 255, 0.04);
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

            .btn-add {
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

            .btn-add:hover {
                background: rgba(255, 255, 255, 0.28);
                color: #fff;
                transform: scale(1.04);
            }

            /* ── Alert ── */
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
                box-shadow: 0 4px 16px rgba(30, 111, 92, 0.3);
            }

            /* ── Table card ── */
            .table-card {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 4px 24px rgba(30, 111, 92, 0.10);
                border: 1.5px solid #d6ead8;
                overflow: hidden;
            }

            /* ── DataTables overrides ── */
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                padding: 14px 20px;
            }

            .dataTables_wrapper .dataTables_length select,
            .dataTables_wrapper .dataTables_filter input {
                border: 1.5px solid #b5d9bc !important;
                border-radius: 10px !important;
                padding: 6px 10px !important;
                outline: none !important;
                background: #f7faf7 !important;
                font-size: 0.9rem;
                color: var(--negro-bosque);
                transition: border-color .2s;
            }

            .dataTables_wrapper .dataTables_filter input:focus,
            .dataTables_wrapper .dataTables_length select:focus {
                border-color: var(--verde-selva) !important;
                box-shadow: 0 0 0 2px rgba(30, 111, 92, 0.12) !important;
            }

            .dataTables_wrapper .dataTables_filter label,
            .dataTables_wrapper .dataTables_length label {
                font-size: 0.85rem;
                color: #666;
                gap: 8px;
                display: flex;
                align-items: center;
            }

            table.dataTable thead th {
                background: #eef6ef !important;
                color: var(--verde-selva) !important;
                font-weight: 700 !important;
                font-size: 0.78rem !important;
                text-transform: uppercase !important;
                letter-spacing: .05em !important;
                border-bottom: 2px solid #d6ead8 !important;
                padding: 14px 16px !important;
                white-space: nowrap;
            }

            table.dataTable thead th.sorting:after,
            table.dataTable thead th.sorting_asc:after,
            table.dataTable thead th.sorting_desc:after {
                color: var(--verde-hoja) !important;
            }

            table.dataTable tbody tr {
                transition: background .15s;
            }

            table.dataTable tbody tr:hover>td {
                background: #f7faf7 !important;
            }

            table.dataTable tbody tr td {
                padding: 13px 16px !important;
                border-bottom: 1px solid #eef6ef !important;
                vertical-align: middle !important;
                font-size: 0.92rem;
                color: var(--negro-bosque);
            }

            table.dataTable tbody tr:last-child td {
                border-bottom: none !important;
            }

            /* Row image */
            .product-thumb {
                width: 54px;
                height: 54px;
                object-fit: cover;
                border-radius: 10px;
                border: 2px solid #d6ead8;
                display: block;
            }

            .product-thumb-placeholder {
                width: 54px;
                height: 54px;
                background: #FAF6ED ;
                border-radius: 10px;
                border: 2px solid #d6ead8;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Price badge */
            .price-badge {
                display: inline-flex;
                align-items: center;
                background: #1E6F5C ;
                color: #fff;
                font-weight: 700;
                font-size: 0.82rem;
                padding: 4px 12px;
                border-radius: 50px;
                box-shadow: 0 2px 8px rgba(30, 111, 92, 0.25);
            }

            /* Action buttons */
            .btn-edit {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: #1E6F5C ;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 7px 14px;
                font-size: 0.82rem;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                transition: opacity .2s, transform .15s;
                box-shadow: 0 2px 8px rgba(30, 111, 92, 0.3);
            }

            .btn-edit:hover {
                opacity: .88;
                color: #fff;
                transform: translateY(-1px);
            }

            .btn-del {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: #c0392b ;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 7px 14px;
                font-size: 0.82rem;
                font-weight: 600;
                cursor: pointer;
                transition: opacity .2s, transform .15s;
                box-shadow: 0 2px 8px rgba(192, 57, 43, 0.3);
            }

            .btn-del:hover {
                opacity: .88;
                transform: translateY(-1px);
            }

            /* Pagination */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                border-radius: 8px !important;
                padding: 6px 12px !important;
                font-size: 0.87rem !important;
                font-weight: 500 !important;
                color: var(--verde-selva) !important;
                border: 1.5px solid #d6ead8 !important;
                margin: 0 2px !important;
                transition: all .2s !important;
                background: #fff !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background: var(--verde-selva) !important;
                border-color: var(--verde-selva) !important;
                color: #fff !important;
                transform: translateY(-1px);
                box-shadow: 0 3px 10px rgba(30, 111, 92, 0.25) !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current,
            .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
                background: #1E6F5C !important;
                border-color: var(--negro-bosque) !important;
                color: #fff !important;
                font-weight: 700 !important;
                box-shadow: 0 4px 12px rgba(30, 111, 92, 0.3) !important;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
            .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
                color: #ccc !important;
                border-color: #eee !important;
                background: #fafafa !important;
                cursor: not-allowed !important;
                transform: none !important;
                box-shadow: none !important;
            }

            .dataTables_wrapper .dataTables_info {
                font-size: 0.84rem;
                color: #888;
            }

            /* Responsive */
            @media (max-width: 600px) {
                .products-hero {
                    padding: 20px 18px;
                }

                .hero-title {
                    font-size: 1.3rem;
                }

                .btn-add span {
                    display: none;
                }
            }
        </style>
    @endsection

    <div class="container products-page">

        {{-- Hero header --}}
        <div class="products-hero">
            <div class="hero-left">
                <div class="hero-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 0 1-8 0" />
                    </svg>
                </div>
                <div>
                    <h1 class="hero-title">Productos</h1>
                    <p class="hero-subtitle">Gestión del catálogo de la tienda</p>
                </div>
            </div>
            <div style="display:flex;gap:10px;">
                <a href="{{ route('home') }}" class="btn-add" style="background:rgba(255,255,255,0.08);border-color:rgba(255,255,255,0.2);" title="Ir al inicio">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Inicio</span>
                </a>
                <a href="{{ route('categories.index') }}" class="btn-add" style="background:rgba(255,255,255,0.08);border-color:rgba(255,255,255,0.2);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                    <span>Categorías</span>
                </a>
                <button class="btn-add" onclick="execute('/productos/agregar')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                    <span>Agregar producto</span>
                </button>
            </div>
        </div>

        {{-- Success alert --}}
        @if(session('success'))
            <div class="alert-ludika">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Table card --}}
        <div class="table-card">
            <div class="table-responsive">
                <table id="myTable" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th class="text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>

    @section('js')
        <script>
            $('#myTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: { url: '{{ route("products.data") }}', type: 'GET' },
                columns: [
                    { data: 'image', orderable: false, searchable: false, width: '70px' },
                    { data: 'name' },
                    { data: 'category' },
                    { data: 'description' },
                    { data: 'price' },
                    { data: 'stock' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    search: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#69B578" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="22" y2="22"/></svg> Buscar:',
                    lengthMenu: 'Mostrar _MENU_ productos',
                    info: 'Mostrando _START_–_END_ de _TOTAL_ productos',
                    infoEmpty: 'Mostrando 0 productos',
                    infoFiltered: '(filtrado de _MAX_ en total)',
                    paginate: {
                        first: '«', previous: '‹', next: '›', last: '»'
                    },
                    zeroRecords: 'Sin productos que mostrar',
                    emptyTable: 'No hay productos en el catálogo aún'
                }
            });

            function execute(url) { window.open(url, '_self'); }

            function deleteRecord(url) {
                if (confirm('¿Está seguro de eliminar este producto?')) {
                    $('<form>', { action: url, method: 'POST' })
                        .append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
                        .append($('<input>', { type: 'hidden', name: '_method', value: 'DELETE' }))
                        .appendTo('body').submit().remove();
                }
            }
        </script>
    @endsection

</x-layout>
