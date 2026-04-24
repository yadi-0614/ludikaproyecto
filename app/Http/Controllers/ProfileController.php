<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario de edición de perfil.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Actualiza el perfil del usuario autenticado.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\á\é\í\ó\ú\Á\É\Í\Ó\Ú\ñ\Ñ]+$/u'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone'    => ['nullable', 'string', 'max:15', 'regex:/^[0-9\s\+\-\(\)]{7,15}$/'],
            'address'  => ['nullable', 'string', 'max:255', 'regex:/^[\w\s\,\.\#\-áéíóúÁÉÍÓÚñÑ]+$/u'],
            'avatar'   => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'new_password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->symbols(),
                'regex:/([^A-Za-z0-9].*){2,}/',
            ],
        ], [
            'name.regex'         => 'El nombre completo no debe contener números ni caracteres especiales.',
            'new_password.regex' => 'La nueva contraseña debe contener al menos 2 caracteres especiales.',
            'phone.regex'        => 'El teléfono solo puede contener dígitos, espacios, +, -, ( y ). Mínimo 7 caracteres.',
            'phone.max'          => 'El teléfono no puede tener más de 15 caracteres.',
            'address.regex'      => 'La dirección contiene caracteres no permitidos.',
        ]);

        // --- Name, email, phone & address ---
        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->phone   = $request->phone;
        $user->address = $request->address;

        // --- Password change ---
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'La contraseña actual no es correcta.'])->withInput();
            }
            $user->password = Hash::make($request->new_password);
        }

        // --- Avatar upload ---
        if ($request->hasFile('avatar')) {
            // Delete old avatar
            if ($user->avatar) {
                app(FileService::class)->delete($user->avatar);
            }
            // Guardar en public/images/users/
            $path = $request->file('avatar')->store('users', 'images');
            $user->avatar = FileService::normalizePath($path);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', '¡Perfil actualizado correctamente!');
    }
}
