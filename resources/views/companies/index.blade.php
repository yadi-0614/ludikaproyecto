<x-layout>

    <?php
// $companies = [
//     ['id' => 1, 'name' => 'Empresa 1', 'description' => 'Descripción de la empresa 1'],
//     ['id' => 2, 'name' => 'Empresa 2', 'description' => 'Descripción de la empresa 2'],
// ];
?>
    <div class="container">
        <div class="row my-4 mx-1">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Empresas</h1>
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('home') }}" class="btn btn-secondary btn-sm" title="Ir al inicio">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        <span class="d-none d-sm-inline ms-1">Inicio</span>
                    </a>
                    <button class="btn btn-primary btn-sm" onclick="window.location.href='{{ route('companies.create') }}'">
                        <i class="bi bi-plus"></i>
                        <span class="d-none d-sm-inline">Agregar</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th class="text-end text-nowrap w-auto">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    @section('js')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: '{{ route("companies.data") }}',
                    type: 'GET'
                },
                columns: [
                    { data: 'name' },
                    { data: 'description' },
                    {
                        data: 'actions',
                        orderable: false,
                        searchable: false,
                        className: 'text-end'
                    }
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                //language: {
                //    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
                //}
            });
        });

        function execute(url) {
            window.open(url, '_self');
        }
        function deleteRecord(url) {
            if (confirm('¿Está seguro de eliminar esta empresa?')) {
                $('<form>', {'action': url, 'method': 'POST'})
                .append($('<input>', {type: 'hidden', name: '_token', value: '{{ csrf_token() }}'}))
                .append($('<input>', {type: 'hidden', name: '_method', value: 'DELETE'}))
                .appendTo('body')
                .submit()
                .remove();
            }
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    </script>
    @endsection
</x-layout>
