<?php

use App\Models\Product;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('images:normalize-db {--write : Persiste los cambios en la base de datos}', function () {
    $normalize = fn (?string $path) => FileService::normalizePath($path);

    $userUpdates = [];
    User::query()
        ->whereNotNull('avatar')
        ->select(['id', 'avatar'])
        ->chunkById(100, function ($users) use (&$userUpdates, $normalize) {
            foreach ($users as $user) {
                $normalized = $normalize($user->avatar);
                if ($normalized !== $user->avatar) {
                    $userUpdates[] = [
                        'id' => $user->id,
                        'from' => $user->avatar,
                        'to' => $normalized,
                    ];
                }
            }
        });

    $productUpdates = [];
    Product::query()
        ->whereNotNull('image')
        ->select(['id', 'image'])
        ->chunkById(100, function ($products) use (&$productUpdates, $normalize) {
            foreach ($products as $product) {
                $normalized = $normalize($product->image);
                if ($normalized !== $product->image) {
                    $productUpdates[] = [
                        'id' => $product->id,
                        'from' => $product->image,
                        'to' => $normalized,
                    ];
                }
            }
        });

    $this->info('Usuarios con avatar a normalizar: ' . count($userUpdates));
    foreach (array_slice($userUpdates, 0, 10) as $update) {
        $this->line("User #{$update['id']}: {$update['from']} -> {$update['to']}");
    }
    if (count($userUpdates) > 10) {
        $this->line('...');
    }

    $this->newLine();
    $this->info('Productos con imagen a normalizar: ' . count($productUpdates));
    foreach (array_slice($productUpdates, 0, 10) as $update) {
        $this->line("Product #{$update['id']}: {$update['from']} -> {$update['to']}");
    }
    if (count($productUpdates) > 10) {
        $this->line('...');
    }

    if (!$this->option('write')) {
        $this->newLine();
        $this->warn('Vista previa únicamente. Ejecuta `php artisan images:normalize-db --write` para guardar los cambios.');
        return;
    }

    foreach ($userUpdates as $update) {
        User::query()->whereKey($update['id'])->update(['avatar' => $update['to']]);
    }

    foreach ($productUpdates as $update) {
        Product::query()->whereKey($update['id'])->update(['image' => $update['to']]);
    }

    $this->newLine();
    $this->info('Normalización completada.');
})->purpose('Normaliza rutas de imágenes y avatares a formato relativo para public/images');
