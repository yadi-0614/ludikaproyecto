<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Listar todos los usuarios
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = User::query();

            // Búsqueda
            if ($request->has("search")) {
                $search = $request->input("search");
                $query->where(function ($q) use ($search) {
                    $q->where("name", "like", "%{$search}%")
                        ->orWhere("email", "like", "%{$search}%");
                });
            }

            // Ordenamiento
            $sortBy = $request->input("sort_by", "created_at");
            $sortDirection = $request->input("sort_direction", "desc");
            $query->orderBy($sortBy, $sortDirection);

            // Paginación
            $perPage = $request->input("per_page", 15);
            $perPage = min($perPage, 100); // Máximo 100 por página

            $users = $query->paginate($perPage);

            // Formatear respuesta
            $data = $users->map(function ($user) {
                return [
                    "id" => $user->id,
                    "name" => $user->name,
                    "email" => $user->email,
                    "avatar" => FileService::publicUrl($user->avatar),
                    "has_avatar" => $user->hasAvatar(),
                    "created_at" => $user->created_at,
                    "updated_at" => $user->updated_at,
                ];
            });

            return response()->json(
                [
                    "success" => true,
                    "data" => $data,
                    "pagination" => [
                        "current_page" => $users->currentPage(),
                        "last_page" => $users->lastPage(),
                        "per_page" => $users->perPage(),
                        "total" => $users->total(),
                        "from" => $users->firstItem(),
                        "to" => $users->lastItem(),
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
                    "message" => "Error al obtener usuarios",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Crear un nuevo usuario
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                "name" => "required|string|max:255",
                "email" => "required|string|email|max:255|unique:users",
                "password" => "required|string|min:8|confirmed",
                "avatar" => "nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120",
            ]);

            // Crear usuario
            $user = User::create([
                "name" => $validated["name"],
                "email" => $validated["email"],
                "password" => Hash::make($validated["password"]),
            ]);

            // Procesar avatar si se subió
            if ($request->hasFile("avatar")) {
                $uploadResult = $this->fileService->upload(
                    $request->file("avatar"),
                    "users",
                );

                if ($uploadResult["success"]) {
                    $user->avatar = $uploadResult["path"];
                    $user->save();
                }
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Usuario creado exitosamente",
                    "data" => [
                        "user" => [
                            "id" => $user->id,
                            "name" => $user->name,
                            "email" => $user->email,
                            "avatar" => FileService::publicUrl($user->avatar),
                            "has_avatar" => $user->hasAvatar(),
                            "created_at" => $user->created_at,
                            "updated_at" => $user->updated_at,
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
                    "message" => "Error al crear usuario",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Mostrar un usuario específico
     */
    public function show(User $user): JsonResponse
    {
        try {
            return response()->json(
                [
                    "success" => true,
                    "data" => [
                        "user" => [
                            "id" => $user->id,
                            "name" => $user->name,
                            "email" => $user->email,
                            "avatar" => FileService::publicUrl($user->avatar),
                            "has_avatar" => $user->hasAvatar(),
                            "created_at" => $user->created_at,
                            "updated_at" => $user->updated_at,
                        ],
                    ],
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al obtener usuario",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Actualizar un usuario
     */
    public function update(Request $request, User $user): JsonResponse
    {
        try {
            $validated = $request->validate([
                "name" => "required|string|max:255",
                "email" => ["required", "string", "email", "max:255", Rule::unique('users')->ignore($user->id)],
                "password" => "nullable|string|min:8|confirmed",
                "avatar" => "nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120",
                "remove_avatar" => "sometimes|boolean",
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (!empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();

            // Manejar avatar
            if ($request->input("remove_avatar", false)) {
                // Eliminar avatar actual
                if ($user->avatar) {
                    $this->fileService->delete($user->avatar);
                    $user->avatar = null;
                    $user->save();
                }
            } elseif ($request->hasFile("avatar")) {
                // Subir nuevo avatar
                $oldAvatar = $user->avatar;

                $uploadResult = $this->fileService->upload(
                    $request->file("avatar"),
                    "users",
                );

                if ($uploadResult["success"]) {
                    $user->avatar = $uploadResult["path"];
                    $user->save();

                    // Eliminar avatar anterior
                    if ($oldAvatar) {
                        $this->fileService->delete($oldAvatar);
                    }
                }
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Usuario actualizado exitosamente",
                    "data" => [
                        "user" => [
                            "id" => $user->id,
                            "name" => $user->name,
                            "email" => $user->email,
                            "avatar" => FileService::publicUrl($user->avatar),
                            "has_avatar" => $user->hasAvatar(),
                            "created_at" => $user->created_at,
                            "updated_at" => $user->updated_at,
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
                    "message" => "Error al actualizar usuario",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Eliminar un usuario
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            // Eliminar avatar si existe
            if ($user->avatar) {
                $this->fileService->delete($user->avatar);
            }

            $user->delete();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Usuario eliminado exitosamente",
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al eliminar usuario",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Subir avatar para un usuario (endpoint específico)
     */
    public function uploadAvatar(
        Request $request,
        User $user,
    ): JsonResponse {
        try {
            $validated = $request->validate([
                "avatar" =>
                    "required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120",
            ]);

            $oldAvatar = $user->avatar;

            $uploadResult = $this->fileService->upload(
                $request->file("avatar"),
                "users",
            );

            if (!$uploadResult["success"]) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error al subir avatar",
                        "error" => $uploadResult["message"],
                    ],
                    400,
                );
            }

            $user->avatar = $uploadResult["path"];
            $user->save();

            // Eliminar avatar anterior
            if ($oldAvatar) {
                $this->fileService->delete($oldAvatar);
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Avatar subido exitosamente",
                    "data" => [
                        "avatar_url" => FileService::publicUrl($user->avatar),
                        "avatar_path" => $user->avatar,
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
                    "message" => "Error al subir avatar",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Eliminar avatar de un usuario
     */
    public function deleteAvatar(User $user): JsonResponse
    {
        try {
            if (!$user->avatar) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "El usuario no tiene avatar",
                    ],
                    400,
                );
            }

            $this->fileService->delete($user->avatar);
            $user->avatar = null;
            $user->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Avatar eliminado exitosamente",
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al eliminar avatar",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Obtener estadísticas de usuarios
     */
    public function stats(): JsonResponse
    {
        try {
            $total = User::count();
            $withAvatars = User::whereNotNull("avatar")->count();
            $withoutAvatars = $total - $withAvatars;

            return response()->json(
                [
                    "success" => true,
                    "data" => [
                        "total_users" => $total,
                        "users_with_avatars" => $withAvatars,
                        "users_without_avatars" => $withoutAvatars,
                        "percentage_with_avatars" =>
                            $total > 0
                            ? round(($withAvatars / $total) * 100, 2)
                            : 0,
                    ],
                ],
                200,
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error al obtener estadísticas",
                    "error" => $e->getMessage(),
                ],
                500,
            );
        }
    }
}
