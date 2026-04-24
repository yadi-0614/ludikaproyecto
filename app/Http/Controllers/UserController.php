<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    protected FileService $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(Request $request)
    {
        return view("users.index", [
            "users" => collect(),
        ]);
    }

    public function create(Request $request)
    {
        return view("users.form");
    }

    public function store(Request $request)
    {
        $id = $request->input("id", null);
        $loggedId = \Illuminate\Support\Facades\Auth::id();

        // Si no es el administrador principal (ID 2)...
        if ($id && $loggedId !== 2 && $loggedId != $id) {
            $userToEdit = User::find($id);
            // ...solo puede editar a clientes, no a otros administradores
            if ($userToEdit && $userToEdit->hasRole('admin')) {
                return redirect()
                    ->route("users.index")
                    ->with("error", "Solo el administrador principal puede editar a otros administradores.");
            }
        }

        try {
            Log::info("UserController: Store method called");

            $id = $request->input("id", null);

            $rules = [
                "name" => "required|string|max:255|regex:/^[a-zA-Z\s\á\é\í\ó\ú\Á\É\Í\Ó\Ú\ñ\Ñ]+$/u",
                "email" => ["required", "string", "email", "max:255", Rule::unique('users')->ignore($id)],
            ];

            if (!$id) {
                $rules["password"] = [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()
                        ->symbols(),
                    'regex:/([^A-Za-z0-9].*){2,}/',
                ];
            } else {
                $rules["password"] = [
                    'nullable',
                    'string',
                    'min:8',
                    'confirmed',
                    Password::min(8)
                        ->mixedCase()
                        ->symbols(),
                    'regex:/([^A-Za-z0-9].*){2,}/',
                ];
            }

            $validated = $request->validate($rules, [
                'name.regex' => 'El nombre completo no debe contener números ni caracteres especiales.',
                'password.regex' => 'La contraseña debe contener al menos 2 caracteres especiales.',
            ]);

            if ($id) {
                // Actualizar usuario existente
                $user = User::findOrFail($id);
                $oldAvatar = $user->avatar;

                $user->name = $validated['name'];
                $user->email = $validated['email'];

                if (!empty($validated['password'])) {
                    $user->password = Hash::make($validated['password']);
                }

                $user->save();

                // Procesar nuevo avatar si se subió
                if ($request->hasFile("avatar")) {
                    $uploadResult = $this->fileService->upload(
                        $request->file("avatar"),
                        "users"
                    );

                    if ($uploadResult["success"]) {
                        $user->avatar = $uploadResult["path"];
                        $user->save();

                        // Eliminar avatar anterior si existe
                        if ($oldAvatar) {
                            $this->fileService->delete($oldAvatar);
                        }
                    }
                }
            } else {
                // Crear usuario nuevo
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'is_active' => true,
                ]);

                // Procesar avatar para usuario nuevo
                if ($request->hasFile("avatar")) {
                    $uploadResult = $this->fileService->upload(
                        $request->file("avatar"),
                        "users"
                    );

                    if ($uploadResult["success"]) {
                        $user->avatar = $uploadResult["path"];
                        $user->save();
                    }
                }
            }

            return redirect()
                ->route("users.index")
                ->with("success", "Usuario registrado exitosamente.");
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with("error", $e->getMessage());
        }
    }

    public function edit(Request $request, User $user)
    {
        $loggedId = \Illuminate\Support\Facades\Auth::id();

        // Si no es el administrador principal (ID 2)...
        if ($loggedId !== 2 && $loggedId !== $user->id) {
            // ...solo puede editar a clientes, no a otros administradores
            if ($user->hasRole('admin')) {
                return redirect()
                    ->route("users.index")
                    ->with("error", "No tienes permisos para editar este perfil administrativo.");
            }
        }

        return view("users.form", [
            "user" => $user,
        ]);
    }

    public function destroy(Request $request, User $user)
    {
        $loggedId = \Illuminate\Support\Facades\Auth::id();

        // El administrador principal (ID 2) puede eliminar a cualquiera
        // Los otros administradores solo pueden eliminar a clientes
        if ($loggedId !== 2) {
            if ($user->hasRole('admin')) {
                return redirect()
                    ->route("users.index")
                    ->with("error", "Solo el administrador principal puede eliminar a otros administradores.");
            }
        }

        // Prevenir que el usuario se elimine a sí mismo
        if (\Illuminate\Support\Facades\Auth::id() === $user->id) {
            return redirect()
                ->route("users.index")
                ->with("error", "No puedes eliminar tu propia cuenta mientras tienes la sesión iniciada.");
        }

        // Prevenir eliminar al administrador principal
        if ($user->id === 2) {
            return redirect()
                ->route("users.index")
                ->with("error", "El administrador principal no puede ser eliminado.");
        }

        // Prevenir eliminar si tiene compras
        if ($user->has_purchases) {
            return redirect()
                ->route("users.index")
                ->with("error", "El usuario no puede ser eliminado porque ya ha realizado compras.");
        }

        // Eliminar avatar si existe
        if ($user->avatar) {
            $this->fileService->delete($user->avatar);
        }

        $user->delete();

        return redirect()
            ->route("users.index")
            ->with("success", "Usuario eliminado exitosamente!!!");
    }

    /**
     * Toggle user active/inactive status
     */
    public function toggleActive(User $user)
    {
        $loggedId = \Illuminate\Support\Facades\Auth::id();

        // El administrador principal (ID 2) puede cambiar estado a cualquiera
        // Los otros administradores solo pueden cambiar estado a clientes
        if ($loggedId !== 2) {
            if ($user->hasRole('admin')) {
                return redirect()
                    ->route("users.index")
                    ->with("error", "Solo el administrador principal puede cambiar el estado de otros administradores.");
            }
        }

        // Prevenir que el usuario se desactive a sí mismo
        if (\Illuminate\Support\Facades\Auth::id() === $user->id) {
            return redirect()
                ->route("users.index")
                ->with("error", "No puedes desactivar tu propia cuenta mientras tienes la sesión iniciada.");
        }

        // Prevenir desactivar al administrador principal
        if ($user->id === 2) {
            return redirect()
                ->route("users.index")
                ->with("error", "El administrador principal no puede ser desactivado.");
        }

        // Prevenir desactivar si tiene compras
        if ($user->is_active && $user->has_purchases) {
            return redirect()
                ->route("users.index")
                ->with("error", "El usuario no puede ser desactivado porque ya ha realizado compras.");
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $status = $user->is_active ? 'activado' : 'desactivado';

        return redirect()
            ->route("users.index")
            ->with("success", "Usuario {$status} exitosamente.");
    }

    public function dataTable(Request $request)
    {
        $request->validate([
            "draw" => "integer",
            "start" => "integer|min:0",
            "length" => "integer|min:1|max:100",
            "search.value" => "nullable|string|max:255",
        ]);

        $query = User::query();

        $search = $request->input("search.value");
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where("name", "like", "%{$search}%")
                    ->orWhere("email", "like", "%{$search}%");
            });
        }

        $totalRecords = User::count();

        $filteredRecords = clone $query;
        $recordsFiltered = $filteredRecords->count();

        $columns = ["name", "email", "is_active", "created_at", "id"];
        $orderColumn = $request->input("order.0.column", 0);
        $orderDir = $request->input("order.0.dir", "asc");
        $query->orderBy($columns[$orderColumn] ?? "id", $orderDir);

        $start = $request->input("start", 0);
        $length = $request->input("length", 10);
        $data = $query->skip($start)->take($length)->get();

        $data = $data->map(function (User $user) {
            $avatarHtml = "";
            if (
                $user->avatar &&
                Storage::disk("images")->exists($user->avatar)
            ) {
                $avatarHtml =
                    '<img src="' .
                    asset("images/" . $user->avatar) .
                    '" alt="' .
                    e($user->name) .
                    '" class="user-thumb">';
            } else {
                $initial = strtoupper(substr($user->name, 0, 1));
                $avatarHtml =
                    '<div class="user-thumb-placeholder">' . $initial . '</div>';
            }

            // Status badge
            if ($user->is_active) {
                $statusHtml = '<span class="status-badge status-active"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Activo</span>';
            } else {
                $statusHtml = '<span class="status-badge status-inactive"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg> Inactivo</span>';
            }

            // Action buttons
            $isCurrentUser = \Illuminate\Support\Facades\Auth::id() === $user->id;
            $isPrincipalAdmin = $user->id === 2;
            $isLoggedPrincipal = \Illuminate\Support\Facades\Auth::id() === 2;

            $toggleLabel = $user->is_active ? 'Desactivar' : 'Activar';
            $toggleClass = $user->is_active ? 'btn-toggle-off' : 'btn-toggle-on';
            $toggleIcon = $user->is_active
                ? '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
                : '<svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>';
            $isAdminTarget = $user->hasRole('admin');

            if ($isCurrentUser) {
                // Si es el usuario actual, le mostramos solo el botón de editar (perfil)
                $actionsHtml = '<div class="action-btns" style="justify-content: flex-end; opacity: 0.6;">
                    <span style="font-size: 0.8rem; font-weight: 600; color: #888; padding: 7px;">(Tú)</span>
                    <button class="btn-edit" onclick="execute(\'/users/' . $user->id . '/edit\')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <span class="d-none d-sm-inline">Editar</span>
                    </button>
                </div>';
            } elseif (!$isLoggedPrincipal && $isAdminTarget) {
                // Si el logueado NO es el administrador principal y el objetivo es ADMIN, modo solo lectura.
                $actionsHtml = '<div class="action-btns" style="justify-content: flex-end; opacity: 0.8;">
                    <span style="font-size: 0.75rem; font-weight: 500; color: #999; padding: 7px; font-style: italic;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        Admin (Protegido)
                    </span>
                </div>';
            } elseif ($isPrincipalAdmin) {
                // Si es el administrador principal, sólo se puede editar.
                $actionsHtml = '<div class="action-btns" style="justify-content: flex-end; opacity: 0.6;">
                    <span style="font-size: 0.8rem; font-weight: 600; color: #888; padding: 7px;" title="Admin Principal"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></span>
                    <button class="btn-edit" onclick="execute(\'/users/' . $user->id . '/edit\')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <span class="d-none d-sm-inline">Editar</span>
                    </button>
                </div>';
            } elseif ($user->has_purchases) {
                // Si tiene compras, solo permitimos editar.
                $actionsHtml = '<div class="action-btns">
                    <button class="btn-edit" onclick="execute(\'/users/' . $user->id . '/edit\')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <span class="d-none d-sm-inline">Editar</span>
                    </button>
                    <span style="font-size: 0.75rem; color: #888; font-weight: 500; font-style: italic; opacity: 0.8; padding: 7px;" title="No se puede eliminar ni desactivar porque tiene compras realizadas">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        Compras
                    </span>
                </div>';
            } else {
                // Es el administrador principal, tiene control total.
                // O es un administrador secundario editando un cliente sin compras.
                $actionsHtml = '<div class="action-btns">
                    <button class="btn-edit" onclick="execute(\'/users/' . $user->id . '/edit\')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        <span class="d-none d-sm-inline">Editar</span>
                    </button>
                    <button class="' . $toggleClass . '" onclick="toggleStatus(\'/users/' . $user->id . '/toggle-active\')">
                        ' . $toggleIcon . '
                        <span class="d-none d-sm-inline">' . $toggleLabel . '</span>
                    </button>
                    <button class="btn-del" onclick="deleteRecord(\'/users/' . $user->id . '\')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                        <span class="d-none d-sm-inline">Eliminar</span>
                    </button>
                </div>';
            }

            // Role badge
            $isAdmin = $user->hasRole('admin');
            $roleHtml = $isAdmin 
                ? '<span class="status-badge" style="background: rgba(30, 111, 92, 0.12); color: var(--verde-selva); border: 1.5px solid rgba(30, 111, 92, 0.3);"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> Admin</span>'
                : '<span class="status-badge" style="background: #f7faf7; color: #888; border: 1.5px solid #d6ead8;"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="margin-right:2px"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg> Cliente</span>';

            return [
                "avatar" => $avatarHtml,
                "name" => e($user->name),
                "email" => e($user->email),
                "role" => $roleHtml,
                "status" => $statusHtml,
                "created_at" => $user->created_at->format('Y-m-d H:i'),
                "actions" => $actionsHtml,
            ];
        });

        return response()->json([
            "draw" => (int) $request->input("draw"),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $recordsFiltered,
            "data" => $data,
        ]);
    }

    public function downloadAvatar(User $user)
    {
        if (!$user->avatar) {
            abort(404, "Avatar no encontrado");
        }

        try {
            return $this->fileService->download(
                $user->avatar,
                "usuario_" . $user->id . "_" . basename($user->avatar),
            );
        } catch (\Exception $e) {
            abort(404, "Archivo no encontrado");
        }
    }
}
