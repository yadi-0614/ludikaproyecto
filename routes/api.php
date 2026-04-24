<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CompanyController;

use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes. Todas las rutas aquí serán prefijadas con /api
|--------------------------------------------------------------------------
*/

// RUTAS PUBLICAS
// -----------------------------------------------------------------
Route::prefix("auth")->group(function () {
    // /api/auth/register
    Route::post("/register", [AuthController::class, "register"]);
    Route::post("/login", [AuthController::class, "login"]);
});

// Ruta para verificar el estado de la API
Route::get("/status", function () {
    return response()->json([
        "success" => true,
        "message" => "API funcionando correctamente",
        "timestamp" => now(),
        "version" => "1.0.0",
    ]);
});

// Stats endpoint for admin panel (public, used by admin views)
Route::get("/users/stats", function () {
    $total = \App\Models\User::count();
    $active = \App\Models\User::where('is_active', true)->count();
    $inactive = \App\Models\User::where('is_active', false)->count();
    return response()->json([
        'total' => $total,
        'active' => $active,
        'inactive' => $inactive,
    ]);
});

// RUTAS PROTEGIDAS (requieren autenticación)
// -----------------------------------------------------------------
Route::middleware("auth:sanctum")->group(function () {
    Route::prefix("auth")->group(function () {
        // Rutas de autenticación para usuarios autenticados
        // por ejemplo: POST /api/auth/logout
        Route::post("/logout", [AuthController::class, "logout"]);
        Route::post("/logout-all", [AuthController::class, "logoutAll"]);
        Route::get("/me", [AuthController::class, "me"]);
        Route::put("/profile", [AuthController::class, "updateProfile"]);
        Route::get("/tokens", [AuthController::class, "tokens"]);
        Route::delete("/tokens", [AuthController::class, "revokeToken"]);
    });

    // Rutas de productos (CRUD completo)
    Route::name('api.products.')->prefix('products')->group(function () {
        // Rutas adicionales primero para evitar colisiones con {product}
        Route::get('/statistics', [ProductController::class, 'stats'])
            ->name('stats');

        Route::post('/{product}/upload-image', [
            ProductController::class,
            'uploadImage',
        ])->name('upload-image');

        Route::delete('/{product}/image', [
            ProductController::class,
            'deleteImage',
        ])->name('delete-image');

        Route::apiResource('/', ProductController::class)->parameters([
            '' => 'product',
        ]);
    });

    // Rutas de empresas (CRUD completo)
    Route::name('api.companies.')->prefix('companies')->group(function () {
        Route::apiResource('/', CompanyController::class)->parameters([
            '' => 'company',
        ]);
    });

    // Rutas de usuarios (CRUD completo)
    Route::name('api.users.')->prefix('users')->group(function () {
        // Rutas adicionales primero para evitar colisiones con {user}
        Route::get('/statistics', [UserController::class, 'stats'])
            ->name('stats');

        Route::post('/{user}/upload-avatar', [
            UserController::class,
            'uploadAvatar',
        ])->name('upload-avatar');

        Route::delete('/{user}/avatar', [
            UserController::class,
            'deleteAvatar',
        ])->name('delete-avatar');

        Route::apiResource('/', UserController::class)->parameters([
            '' => 'user',
        ]);
    });

});

// Manejo de rutas no encontradas
Route::fallback(function () {
    return response()->json(
        [
            "success" => false,
            "message" => "Endpoint no encontrado",
            "error" => "La ruta solicitada no existe",
        ],
        404,
    );
});
