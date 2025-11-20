<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Actions\Fortify\UpdateUserProfileInformation;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('admin.profile.show', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'biography' => ['nullable', 'string', 'max:1000'],
            'company' => ['nullable', 'string', 'max:255'],
            'position' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        // Preparar datos para UpdateUserProfileInformation (solo nombre y email)
        $profileData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // Actualizar información del perfil (nombre y email) usando la acción de Fortify
        $updateAction = new UpdateUserProfileInformation();
        $updateAction->update($user, $profileData);

        // Actualizar campos adicionales
        $user->phone = $validated['phone'] ?? null;
        $user->biography = $validated['biography'] ?? null;
        $user->company = $validated['company'] ?? null;
        $user->position = $validated['position'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->save();

        // Refrescar el usuario para asegurar que todos los cambios estén cargados
        $user->refresh();

        return redirect()->route('profile.show')->with('success', 'Perfil actualizado correctamente.');
    }
}

