<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Crea el usuario administrador por defecto.
     * Ejecutar con: php artisan db:seed --class=AdminSeeder
     */
    public function run(): void
    {
        // Verificar si ya existe un admin
        $adminExists = User::where('is_admin', true)->exists();
        
        if ($adminExists) {
            $this->command->info('Ya existe un usuario administrador.');
            return;
        }

        User::create([
            'name' => 'Administrador',
            'email' => 'admin@threadly.com',
            'password' => Hash::make('Admin123!'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        $this->command->info('✅ Usuario administrador creado:');
        $this->command->info('   Email: admin@threadly.com');
        $this->command->info('   Password: Admin123!');
    }
}
