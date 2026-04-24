<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('companies.index', [
            'companies' => collect(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Debug: Verificar los datos de la solicitud
            Log::info("Store method called in CompanyController");
            Log::info("All request data:", $request->all());

            // Validar los datos del formulario
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'description' => 'nullable|string',
            ]);

            $id = $request->input('id', null);

            if ($id) {
                // Actualizar empresa existente
                $company = Company::findOrFail($id);
                
                // Actualizar campos básicos
                $company->fill($validated);
                $company->save();
                
                $message = 'Empresa actualizada exitosamente';
            } else {
                // Crear nueva empresa
                $company = Company::create($validated);
                $message = 'Empresa registrada exitosamente';
            }

            Log::info("Company saved successfully. ID: " . $company->id);

            return redirect()
                ->route('companies.index')
                ->with('success', $message);
                
        } catch (ValidationException $e) {
            Log::error('Validation error in CompanyController@store: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error in CompanyController@store: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Error al procesar la solicitud: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $company = Company::findOrFail($id);
            return view('companies.form', compact('company'));
        } catch (\Exception $e) {
            Log::error('Error al cargar la empresa para editar: ' . $e->getMessage());
            return redirect()->route('companies.index')
                ->with('error', 'No se pudo cargar la empresa para editar');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        try {
            $company->delete();
            return redirect()
            ->route("companies.index")
            ->with("success", "Producto eliminado exitosamente!!!");
        } catch (\Exception $e) {
            Log::error('Error al eliminar la empresa: ' . $e->getMessage());
            return redirect()
                ->route("companies.index")
                ->with("error", $e->getMessage());
        }
    }

    /**
     * Obtiene los datos para DataTables
     */
    public function dataTable(Request $request)
    {
        // Validar params de DataTables
        $request->validate([
            'draw' => 'required|integer',
            'start' => 'required|integer|min:0',
            'length' => 'required|integer|min:1|max:100',
            'search.value' => 'nullable|string|max:255',
        ]);

        // Query base
        $query = Company::query();

        // Búsqueda global
        $search = $request->input('search.value');
        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Total de registros sin filtros
        $totalRecords = Company::count();
        
        // Obtener registros filtrados
        $filteredRecords = clone $query;
        $recordsFiltered = $filteredRecords->count();

        // get y set Ordenación (columna y dirección)
        $columns = ["name", "description", "id"]; // Orden de columnas en tabla
        $orderColumn = $request->input("order.0.column", 0);
        $orderDir = $request->input("order.0.dir", "asc");
        $query->orderBy($columns[$orderColumn] ?? "id", $orderDir);

        // Paginación
        $start = $request->input("start", 0);
        $length = $request->input("length", 10);
        $data = $query->skip($start)->take($length)->get();

        // Formatear datos para DataTables
        $data = $data->map(function ($record) {
            return [
                "name" => $record->name,
                "description" => $record->description,
                "actions" =>
                    '
                    <button class="btn btn-primary btn-sm" onclick="execute(\'/companies/' .
                    $record->id .
                    '/edit\')">
                        <i class="bi bi-pencil"></i> <span class="d-none d-sm-inline">Edit</span>
                    </button>
                    <button class="btn btn-danger btn-sm" onclick="deleteRecord(\'/companies/' .
                    $record->id .
                    '\')">
                        <i class="bi bi-trash"></i> <span class="d-none d-sm-inline">Delete</span>
                    </button>
                ',
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data,
        ]);
    }
}
