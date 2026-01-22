<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show user profile
     */
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        $recentOrders = $user->orders()->with('items')->latest()->take(5)->get();
        
        return view('profile.index', compact('user', 'addresses', 'recentOrders'));
    }

    /**
     * Show edit profile form
     */
    public function edit()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|regex:/^[\pL\s\-\']+$/u',
            'phone' => 'nullable|string|max:20|regex:/^[\+]?[0-9\s\-\(\)]+$/',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => 'El nombre es obligatorio',
            'name.regex' => 'El nombre solo puede contener letras',
            'phone.regex' => 'Ingresa un número de teléfono válido',
            'birth_date.before' => 'La fecha de nacimiento debe ser anterior a hoy',
            'avatar.image' => 'El archivo debe ser una imagen',
            'avatar.max' => 'La imagen no debe superar los 2MB',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatar = $request->file('avatar');
            $filename = 'avatars/' . $user->id . '_' . time() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('', $filename, 'public');
            $validated['avatar'] = $filename;
        }

        $user->update($validated);

        ActivityLog::log('profile_updated', 'Usuario actualizó su perfil');

        return back()->with('success', 'Perfil actualizado correctamente');
    }

    /**
     * Show change password form
     */
    public function showChangePassword()
    {
        return view('profile.change-password');
    }

    /**
     * Update password
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'confirmed',
                Password::min(8)->mixedCase()->numbers(),
            ],
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria',
            'password.required' => 'La nueva contraseña es obligatoria',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta']);
        }

        $user->update(['password' => Hash::make($request->password)]);

        ActivityLog::log('password_reset', 'Usuario cambió su contraseña');

        return back()->with('success', 'Contraseña actualizada correctamente');
    }

    // =====================
    // ADDRESS MANAGEMENT
    // =====================

    /**
     * List user addresses
     */
    public function addresses()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $addresses = $user->addresses()->orderByDesc('is_default')->get();
        return view('profile.addresses', compact('addresses'));
    }

    /**
     * Store new address
     */
    public function storeAddress(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'address_reference' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'boolean',
        ], [
            'name.required' => 'El nombre de la dirección es obligatorio',
            'recipient_name.required' => 'El nombre del destinatario es obligatorio',
            'phone.required' => 'El teléfono es obligatorio',
            'address.required' => 'La dirección es obligatoria',
            'city.required' => 'La ciudad es obligatoria',
            'province.required' => 'La provincia es obligatoria',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $validated['user_id'] = $user->id;
        $validated['is_default'] = $request->boolean('is_default');

        // If this is the first address or marked as default
        if ($validated['is_default'] || $user->addresses()->count() === 0) {
            $user->addresses()->update(['is_default' => false]);
            $validated['is_default'] = true;
        }

        Address::create($validated);

        return back()->with('success', 'Dirección agregada correctamente');
    }

    /**
     * Update address
     */
    public function updateAddress(Request $request, Address $address)
    {
        // Verify ownership
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'recipient_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'address_reference' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        $address->update($validated);

        return back()->with('success', 'Dirección actualizada correctamente');
    }

    /**
     * Set address as default
     */
    public function setDefaultAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->setAsDefault();

        return back()->with('success', 'Dirección predeterminada actualizada');
    }

    /**
     * Delete address
     */
    public function deleteAddress(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $wasDefault = $address->is_default;
        $address->delete();

        // If deleted was default, set another as default
        if ($wasDefault) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $newDefault = $user->addresses()->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'Dirección eliminada correctamente');
    }
}
