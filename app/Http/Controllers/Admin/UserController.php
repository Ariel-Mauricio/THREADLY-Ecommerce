<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->has('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'customer') {
                $query->where('is_admin', false);
            }
        }

        // Status filter
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->whereNull('suspended_at');
            } elseif ($request->status === 'suspended') {
                $query->whereNotNull('suspended_at');
            }
        }

        $users = $query->withCount('orders')
            ->orderByDesc('created_at')
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\+]?[0-9\s\-\(\)]+$/'],
            'is_admin' => ['boolean'],
        ], [
            'phone.regex' => 'El teléfono solo puede contener números, espacios, guiones y paréntesis',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = $request->boolean('is_admin');

        $user = User::create($validated);

        ActivityLog::log('user_created', $user, null, $user->only(['name', 'email', 'is_admin']));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function show(User $user)
    {
        $user->load(['orders' => function ($query) {
            $query->latest()->take(10);
        }, 'addresses', 'reviews']);

        $totalSpent = $user->orders()
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->sum('total');

        $activityLogs = ActivityLog::where('user_id', $user->id)
            ->orWhere(function ($query) use ($user) {
                $query->where('loggable_type', User::class)
                    ->where('loggable_id', $user->id);
            })
            ->latest()
            ->take(20)
            ->get();

        return view('admin.users.show', compact('user', 'totalSpent', 'activityLogs'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20', 'regex:/^[\+]?[0-9\s\-\(\)]+$/'],
            'is_admin' => ['boolean'],
        ], [
            'phone.regex' => 'El teléfono solo puede contener números, espacios, guiones y paréntesis',
        ]);

        $oldData = $user->only(['name', 'email', 'phone', 'is_admin']);
        $validated['is_admin'] = $request->boolean('is_admin');

        $user->update($validated);

        ActivityLog::log('user_updated', $user, $oldData, $user->only(['name', 'email', 'phone', 'is_admin']));

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function resetPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        ActivityLog::log('password_reset_admin', $user);

        return back()->with('success', 'Contraseña restablecida exitosamente.');
    }

    public function suspend(User $user)
    {
        if ($user->is_admin && $user->id === Auth::id()) {
            return back()->with('error', 'No puedes suspender tu propia cuenta.');
        }

        $user->update(['suspended_at' => now()]);

        ActivityLog::log('user_suspended', $user);

        return back()->with('success', 'Usuario suspendido exitosamente.');
    }

    public function restore(User $user)
    {
        $user->update(['suspended_at' => null]);

        ActivityLog::log('user_restored', $user);

        return back()->with('success', 'Usuario restaurado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'No puedes eliminar el único administrador.');
        }

        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        $userData = $user->only(['id', 'name', 'email']);
        
        // Soft delete or anonymize orders
        $user->orders()->update(['user_id' => null]);
        
        $user->delete();

        ActivityLog::log('user_deleted', null, $userData, null);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'No puedes modificar tu propio rol.');
        }

        if ($user->is_admin && User::where('is_admin', true)->count() <= 1) {
            return back()->with('error', 'Debe haber al menos un administrador.');
        }

        $oldRole = $user->is_admin;
        $user->update(['is_admin' => !$user->is_admin]);

        ActivityLog::log(
            $user->is_admin ? 'user_promoted' : 'user_demoted',
            $user,
            ['is_admin' => $oldRole],
            ['is_admin' => $user->is_admin]
        );

        $message = $user->is_admin 
            ? 'Usuario promovido a administrador.'
            : 'Se han removido los permisos de administrador.';

        return back()->with('success', $message);
    }
}
