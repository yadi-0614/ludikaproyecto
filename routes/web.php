<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ConfirmPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\AdminOrderController;

use App\Http\Controllers\UserController;

Route::get("/", [ProductController::class, "welcome"])->name("welcome");
Route::view("/acercade", "acercade")->name("acercade");

// Rutas públicas (accesibles sin autenticación)
Route::get("/producto/{product}", [ProductController::class, "show"])->name("product.show");
Route::get("/categorias", [CategoryController::class, "publicIndex"])->name("categories.public");

// Custom auth routes with better control
Route::get("login", [LoginController::class, "showLoginForm"])->name("login");
Route::post("login", [LoginController::class, "login"]);
Route::match(["get", "post"], "logout", [LoginController::class, "logout"])
    ->name("logout")
    ->middleware(["auth", "security:logout"]);

Route::get("register", [
    RegisterController::class,
    "showRegistrationForm",
])->name("register");
Route::post("register", [RegisterController::class, "register"]);

Route::get("password/reset", [
    ForgotPasswordController::class,
    "showLinkRequestForm",
])->name("password.request");
Route::post("password/email", [
    ForgotPasswordController::class,
    "sendResetLinkEmail",
])->name("password.email");
Route::get("password/reset/{token}", [
    ResetPasswordController::class,
    "showResetForm",
])->name("password.reset");
Route::post("password/reset", [ResetPasswordController::class, "reset"])->name(
    "password.update",
);
Route::get("password/confirm", [
    ConfirmPasswordController::class,
    "showConfirmForm",
])->name("password.confirm");
Route::post("password/confirm", [ConfirmPasswordController::class, "confirm"]);

Route::middleware(["auth", "security:auth"])->group(function () {
    Route::get("/home", [HomeController::class, "index"])->name("home");

    // Rutas del carrito (sesión)
    Route::get("cart", [CartController::class, "index"])->name("cart.index");
    Route::post("cart/add", [CartController::class, "add"])->name("cart.add");
    Route::get("cart/count", [CartController::class, "count"])->name("cart.count");
    Route::get("cart/items", [CartController::class, "items"])->name("cart.items");
    Route::delete("cart/clear", [CartController::class, "clear"])->name("cart.clear");
    Route::delete("cart/{productId}", [CartController::class, "remove"])->name("cart.remove");
    Route::patch("cart/{productId}", [CartController::class, "update"])->name("cart.update");
    Route::post("cart/checkout", [CartController::class, "checkout"])->name("cart.checkout");
    Route::get("cart/checkout/cancel", [CartController::class, "checkoutCancel"])->name("cart.checkout.cancel");
    Route::get("cart/checkout/stripe/success", [CartController::class, "stripeSuccess"])->name("cart.checkout.stripe.success");
    Route::get("cart/checkout/paypal/success", [CartController::class, "paypalSuccess"])->name("cart.checkout.paypal.success");

    // Perfil del usuario
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');

    // Historial de compras
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Rutas de productos
    Route::resource("products", ProductController::class)->except([
        "show",
        "update",
    ]);
    Route::get("productos", [ProductController::class, "index"])->name(
        "productos.index",
    );
    Route::get("productos/agregar", [ProductController::class, "create"])->name(
        "productos.create",
    );
    Route::get("products/data", [ProductController::class, "dataTable"])->name(
        "products.data",
    );
    Route::get("products/{product}/download-image", [
        ProductController::class,
        "downloadImage",
    ])->name("products.download-image");

    // Rutas de empresas
    Route::resource('companies', CompanyController::class)->except(['show', 'update']);
    Route::get('companies/data', [CompanyController::class, 'dataTable'])->name('companies.data');

    // Rutas de usuarios (Solo Admin)
    Route::middleware(["role:admin"])->group(function () {
        Route::get("/home-admin", [HomeController::class, "admin"])->name("home.admin");

        Route::resource("users", UserController::class)->except([
            "show",
            "update",
        ]);
        Route::get("users/data", [UserController::class, "dataTable"])->name(
            "users.data",
        );
        Route::patch("users/{user}/toggle-active", [UserController::class, "toggleActive"])->name(
            "users.toggle-active",
        );
        Route::get("users/{user}/download-avatar", [
            UserController::class,
            "downloadAvatar",
        ])->name("users.download-avatar");

        Route::resource('categories', CategoryController::class);

        Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

        // ── Gestión de pedidos (Admin) ──
        Route::get('admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('admin/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::patch('admin/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    });

    Route::post('/products/{product}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('products.reviews.store');
});
