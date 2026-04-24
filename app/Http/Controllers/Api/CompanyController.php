<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Services\FileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * Listar todas las empresas
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Company::query();

            // Búsqueda
            if ($request->has("search")) {
                $search = $request->input("search");
                $query->where(function ($q) use ($search) {
                    $q->where("name", "like", "%{$search}%")
                      ->orWhere("description", "like", "%{$search}%");
                });
            }

            // Ordenamiento
            $sortBy = $request->input("sort_by", "created_at");
            $sortDirection = $request->input("sort_direction", "desc");
            $query->orderBy($sortBy, $sortDirection);

            // Paginación
            $perPage = $request->input("per_page", 15);
            $perPage = min($perPage, 100); // Máximo 100 por página

            $companies = $query->paginate($perPage);

            // Formatear respuesta
            $data = $companies->map(function ($company) {
                return [
                    "id" => $company->id,
                    "name" => $company->name,
                    "description" => $company->description,
                    "created_at" => $company->created_at,
                    "updated_at" => $company->updated_at,
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "data" => $data,
                    "pagination" => [
                        "current_page" => $companies->currentPage(),
                        "last_page" => $companies->lastPage(),
                        "per_page" => $companies->perPage(),
                        "total" => $companies->total(),
                        "from" => $companies->firstItem(),
                        "to" => $companies->lastItem(),
                    ],
                    "meta" => [
                        "search" => $request->input("search"),
                        "sort_by" => $sortBy,
                        "sort_direction" => $sortDirection,
                    ],
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al obtener las empresas",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Almacenar una nueva empresa
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "name" => "required|string|max:100",
                "description" => "nullable|string|max:1000",
            ]);

            $company = Company::create([
                "name" => $validated["name"],
                "description" => $validated["description"] ?? null,
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Empresa creada exitosamente",
                    "data" => [
                        "company" => [
                            "id" => $company->id,
                            "name" => $company->name,
                            "description" => $company->description,
                            "created_at" => $company->created_at,
                            "updated_at" => $company->updated_at,
                        ],
                    ],
                ],
                201,
            );
        } catch (ValidationException $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error de validación",
                    "errors" => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al crear la empresa",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Mostrar una empresa específica
     */
    public function show(Company $company): JsonResponse
    {
        try {
            return response()->json(
                [
                    "success" => true,
                    "data" => [
                        "company" => [
                            "id" => $company->id,
                            "name" => $company->name,
                            "description" => $company->description,
                            "created_at" => $company->created_at,
                            "updated_at" => $company->updated_at,
                        ],
                    ],
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Empresa no encontrada",
                    "error" => $e->getMessage(),
                ],
                404,
            );
        }
    }

    /**
     * Actualizar una empresa existente
     */
    public function update(Request $request, Company $company): JsonResponse
    {
        try {
            $validated = $request->validate([
                "name" => "sometimes|required|string|max:100",
                "description" => "nullable|string|max:1000",
            ]);

            $company->update([
                "name" => $validated["name"] ?? $company->name,
                "description" => $validated["description"] ?? $company->description,
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Empresa actualizada exitosamente",
                    "data" => [
                        "company" => [
                            "id" => $company->id,
                            "name" => $company->name,
                            "description" => $company->description,
                            "created_at" => $company->created_at,
                            "updated_at" => $company->updated_at,
                        ],
                    ],
                ],
                200,
            );
        } catch (ValidationException $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error de validación",
                    "errors" => $e->errors(),
                ],
                422,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al actualizar la empresa",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Eliminar una empresa
     */
    public function destroy(Company $company): JsonResponse
    {
        try {
            $company->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Empresa eliminada exitosamente",
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al eliminar la empresa",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
