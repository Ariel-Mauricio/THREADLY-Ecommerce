<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Solo crea el usuario administrador.
     * 
     * Para datos de ejemplo, usar: php artisan db:seed --class=DemoSeeder
     */
    public function run(): void
    {
        // Solo crear admin si no existe
        if (!User::where('email', 'admin@threadly.com')->exists()) {
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
        } else {
            $this->command->info('El usuario administrador ya existe.');
        }
    }
}
            ['category_id' => 1, 'name' => 'Camiseta Básica Blanca', 'description' => 'Camiseta básica de algodón 100% en color blanco. Perfecta para el día a día.', 'price' => 15.99, 'stock' => 50, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#FFFFFF'], 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500'],
            ['category_id' => 1, 'name' => 'Camiseta Básica Negra', 'description' => 'Camiseta básica de algodón 100% en color negro. Un clásico que no puede faltar.', 'price' => 15.99, 'stock' => 45, 'sizes' => ['S', 'M', 'L', 'XL', 'XXL'], 'colors' => ['#000000'], 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1503341504253-dff4815485f1?w=500'],
            ['category_id' => 1, 'name' => 'Camiseta Básica Azul', 'description' => 'Camiseta básica de algodón en azul marino.', 'price' => 15.99, 'stock' => 30, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#1E3A5F'], 'image' => 'https://images.unsplash.com/photo-1618354691373-d851c5c3a990?w=500'],
            ['category_id' => 1, 'name' => 'Camiseta Básica Gris', 'description' => 'Camiseta básica de algodón en color gris melange.', 'price' => 15.99, 'stock' => 35, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#808080'], 'image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=500'],
            
            // Estampadas
            ['category_id' => 2, 'name' => 'Camiseta Ecuador Tricolor', 'description' => 'Camiseta con diseño de la bandera de Ecuador. ¡Muestra tu orgullo ecuatoriano!', 'price' => 24.99, 'sale_price' => 19.99, 'stock' => 25, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#FFD100', '#0072CE', '#EF3340'], 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?w=500'],
            ['category_id' => 2, 'name' => 'Camiseta Galápagos', 'description' => 'Camiseta con estampado de las Islas Galápagos y su fauna única.', 'price' => 29.99, 'stock' => 20, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#2E86AB'], 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=500'],
            ['category_id' => 2, 'name' => 'Camiseta Quito Colonial', 'description' => 'Diseño artístico del centro histórico de Quito.', 'price' => 27.99, 'stock' => 18, 'sizes' => ['S', 'M', 'L'], 'colors' => ['#F2E8CF'], 'image' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=500'],
            ['category_id' => 2, 'name' => 'Camiseta Volcán Cotopaxi', 'description' => 'Hermoso diseño del majestuoso Volcán Cotopaxi.', 'price' => 26.99, 'stock' => 22, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#87CEEB', '#228B22'], 'image' => 'https://images.unsplash.com/photo-1622445275463-afa2ab738c34?w=500'],
            
            // Deportivas
            ['category_id' => 3, 'name' => 'Camiseta Dry-Fit Negra', 'description' => 'Camiseta deportiva con tecnología dry-fit para máximo rendimiento.', 'price' => 34.99, 'stock' => 40, 'sizes' => ['S', 'M', 'L', 'XL', 'XXL'], 'colors' => ['#000000'], 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1556906781-9a412961c28c?w=500'],
            ['category_id' => 3, 'name' => 'Camiseta Running Reflectiva', 'description' => 'Camiseta para correr con detalles reflectivos para mayor seguridad.', 'price' => 39.99, 'sale_price' => 32.99, 'stock' => 15, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#FF6B35'], 'image' => 'https://images.unsplash.com/photo-1571945153237-4929e783af4a?w=500'],
            ['category_id' => 3, 'name' => 'Camiseta Gym Pro', 'description' => 'Camiseta ideal para gimnasio con corte ajustado.', 'price' => 29.99, 'stock' => 28, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#2D3436', '#636E72'], 'image' => 'https://images.unsplash.com/photo-1581655353564-df123a1eb820?w=500'],
            
            // Polo
            ['category_id' => 4, 'name' => 'Polo Clásica Blanca', 'description' => 'Camiseta polo clásica en algodón piqué de alta calidad.', 'price' => 45.99, 'stock' => 25, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#FFFFFF'], 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1625910513413-5fc42f18b35d?w=500'],
            ['category_id' => 4, 'name' => 'Polo Clásica Azul', 'description' => 'Polo elegante en color azul marino perfecto para la oficina.', 'price' => 45.99, 'stock' => 20, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#1E3A5F'], 'image' => 'https://images.unsplash.com/photo-1598033129183-c4f50c736c73?w=500'],
            ['category_id' => 4, 'name' => 'Polo Premium Negra', 'description' => 'Polo premium con bordado discreto de alta gama.', 'price' => 54.99, 'sale_price' => 44.99, 'stock' => 12, 'sizes' => ['M', 'L', 'XL'], 'colors' => ['#000000'], 'image' => 'https://images.unsplash.com/photo-1586363104862-3a5e2ab60d99?w=500'],
            
            // Manga Larga
            ['category_id' => 5, 'name' => 'Camiseta Manga Larga Básica', 'description' => 'Camiseta de manga larga perfecta para el clima frío de la sierra.', 'price' => 29.99, 'stock' => 35, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#2D3436', '#FFFFFF', '#1E3A5F'], 'image' => 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500'],
            ['category_id' => 5, 'name' => 'Camiseta Térmica', 'description' => 'Camiseta térmica ideal para actividades en la montaña.', 'price' => 49.99, 'stock' => 18, 'sizes' => ['S', 'M', 'L', 'XL'], 'colors' => ['#000000', '#2E86AB'], 'is_featured' => true, 'image' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?w=500'],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
