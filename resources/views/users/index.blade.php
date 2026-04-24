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
            .users-page {
                padding: 2rem 0 3rem;
            }

            /* ── Hero header ── */
            .users-hero {
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

            .users-hero::before {
                content: '';
                position: absolute;
                top: -30px;
                right: -30px;
                width: 140px;
                height: 140px;
                background: rgba(255, 255, 255, 0.06);
                border-radius: 50%;
            }

            .users-hero::after {
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
                animation: alertSlideIn 0.4s cubic-bezier(.34, 1.56, .64, 1) both;
            }

            @keyframes alertSlideIn {
                from {
                    opacity: 0;
                    transform: translateY(-10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
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

            /* User avatar */
            .user-thumb {
                width: 44px;
                height: 44px;
                object-fit: cover;
                border-radius: 50%;
                border: 2px solid #d6ead8;
                display: block;
            }

            .user-thumb-placeholder {
                width: 44px;
                height: 44px;
                background: #1E6F5C ;
                border-radius: 50%;
                border: 2px solid #d6ead8;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                font-weight: 700;
                font-size: 1rem;
            }

            /* Status badge */
            .status-badge {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-weight: 700;
                font-size: 0.78rem;
                padding: 4px 12px;
                border-radius: 50px;
                letter-spacing: .02em;
            }

            .status-active {
                background: rgba(30, 111, 92, 0.12);
                color: var(--verde-selva);
                border: 1.5px solid rgba(30, 111, 92, 0.3);
            }

            .status-inactive {
                background: rgba(192, 57, 43, 0.10);
                color: #c0392b;
                border: 1.5px solid rgba(192, 57, 43, 0.25);
            }

            /* Action buttons */
            .action-btns {
                display: flex;
                gap: 6px;
                justify-content: flex-end;
                flex-wrap: wrap;
            }

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

            .btn-toggle-on {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: #27ae60 ;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 7px 14px;
                font-size: 0.82rem;
                font-weight: 600;
                cursor: pointer;
                transition: opacity .2s, transform .15s;
                box-shadow: 0 2px 8px rgba(39, 174, 96, 0.3);
            }

            .btn-toggle-on:hover {
                opacity: .88;
                transform: translateY(-1px);
            }

            .btn-toggle-off {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                background: #e67e22 ;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 7px 14px;
                font-size: 0.82rem;
                font-weight: 600;
                cursor: pointer;
                transition: opacity .2s, transform .15s;
                box-shadow: 0 2px 8px rgba(230, 126, 34, 0.3);
            }

            .btn-toggle-off:hover {
                opacity: .88;
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

            /* Stats cards */
            .stats-row {
                display: flex;
                gap: 16px;
                margin-bottom: 24px;
                flex-wrap: wrap;
            }

            .stat-card {
                flex: 1;
                min-width: 150px;
                background: #fff;
                border-radius: 16px;
                padding: 18px 20px;
                display: flex;
                align-items: center;
                gap: 14px;
                box-shadow: 0 3px 16px rgba(30, 111, 92, 0.08);
                border: 1.5px solid #d6ead8;
                transition: transform .2s, box-shadow .2s;
            }

            .stat-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 6px 24px rgba(30, 111, 92, 0.15);
            }

            .stat-icon {
                width: 44px;
                height: 44px;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .stat-icon--total {
                background: #1E6F5C ;
            }

            .stat-icon--active {
                background: #27ae60 ;
            }

            .stat-icon--inactive {
                background: #e67e22 ;
            }

            .stat-value {
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--negro-bosque);
                line-height: 1;
            }

            .stat-label {
                font-size: 0.78rem;
                color: #888;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: .04em;
            }

            /* Responsive */
            @media (max-width: 600px) {
                .users-hero {
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

                .btn-add span {
                    display: none;
                }

                .stat-card {
                    min-width: 100%;
                }
            }
        </style>
    @endsection

    <div class="container users-page">

        {{-- Hero header --}}
        <div class="users-hero">
            <div class="hero-left">
                <div class="hero-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div>
                    <h1 class="hero-title">Usuarios</h1>
                    <p class="hero-subtitle">Gestión de cuentas de usuario del sistema</p>
                </div>
            </div>
            <div style="display:flex;gap:10px;align-items:center;">
                <a href="{{ route('home') }}" class="btn-add" style="background:rgba(255,255,255,0.08);border-color:rgba(255,255,255,0.2);" title="Ir al inicio">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    <span>Inicio</span>
                </a>
                <button class="btn-add" onclick="execute('/users/create')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="8.5" cy="7" r="4" />
                        <line x1="20" y1="8" x2="20" y2="14" />
                        <line x1="23" y1="11" x2="17" y2="11" />
                    </svg>
                    <span>Agregar usuario</span>
                </button>
            </div>
        </div>

        {{-- Success/Error alert --}}
        @if(session('success'))
            <div class="alert-ludika">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-ludika" style="background: #c0392b ;">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="15" y1="9" x2="9" y2="15" />
                    <line x1="9" y1="9" x2="15" y2="15" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        {{-- Stats --}}
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon stat-icon--total">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                </div>
                <div>
                    <div class="stat-value" id="stat-total">—</div>
                    <div class="stat-label">Total usuarios</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon--active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                </div>
                <div>
                    <div class="stat-value" id="stat-active">—</div>
                    <div class="stat-label">Activos</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon stat-icon--inactive">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                </div>
                <div>
                    <div class="stat-value" id="stat-inactive">—</div>
                    <div class="stat-label">Inactivos</div>
                </div>
            </div>
        </div>

        {{-- Table card --}}
        <div class="table-card">
            <div class="table-responsive">
                <table id="usersTable" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Avatar</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th class="text-center">Rol</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
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
            var table = $('#usersTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route("users.data") }}',
                    type: 'GET',
                    dataSrc: function (json) {
                        // Update stats
                        updateStats();
                        return json.data;
                    }
                },
                columns: [
                    { data: 'avatar', orderable: false, searchable: false, width: '60px' },
                    { data: 'name' },
                    { data: 'email' },
                    { data: 'role', orderable: false, searchable: false, className: 'text-center' },
                    { data: 'status', orderable: true, searchable: false, width: '100px' },
                    { data: 'created_at' },
                    { data: 'actions', orderable: false, searchable: false }
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                language: {
                    search: '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#69B578" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:4px"><circle cx="11" cy="11" r="7"/><line x1="16.5" y1="16.5" x2="22" y2="22"/></svg> Buscar:',
                    lengthMenu: 'Mostrar _MENU_ usuarios',
                    info: 'Mostrando _START_–_END_ de _TOTAL_ usuarios',
                    infoEmpty: 'Mostrando 0 usuarios',
                    infoFiltered: '(filtrado de _MAX_ en total)',
                    paginate: {
                        first: '«', previous: '‹', next: '›', last: '»'
                    },
                    zeroRecords: 'Sin usuarios que mostrar',
                    emptyTable: 'No hay usuarios registrados aún'
                }
            });

            function updateStats() {
                $.get('/api/users/stats', function (data) {
                    $('#stat-total').text(data.total);
                    $('#stat-active').text(data.active);
                    $('#stat-inactive').text(data.inactive);
                }).fail(function () {
                    // Try calculating from current page if API fails
                    $('#stat-total').text('—');
                    $('#stat-active').text('—');
                    $('#stat-inactive').text('—');
                });
            }

            // Load stats on init
            updateStats();

            function execute(url) { window.open(url, '_self'); }

            function toggleStatus(url) {
                if (confirm('¿Está seguro de cambiar el estado de este usuario?')) {
                    $('<form>', { action: url, method: 'POST' })
                        .append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
                        .append($('<input>', { type: 'hidden', name: '_method', value: 'PATCH' }))
                        .appendTo('body').submit().remove();
                }
            }

            function deleteRecord(url) {
                if (confirm('¿Está seguro de eliminar este usuario? Esta acción no se puede deshacer.')) {
                    $('<form>', { action: url, method: 'POST' })
                        .append($('<input>', { type: 'hidden', name: '_token', value: '{{ csrf_token() }}' }))
                        .append($('<input>', { type: 'hidden', name: '_method', value: 'DELETE' }))
                        .appendTo('body').submit().remove();
                }
            }
        </script>
    @endsection

</x-layout>
