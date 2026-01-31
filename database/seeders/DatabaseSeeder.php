<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin HMart',
            'email' => 'admin@hmart.com',
            'password' => Hash::make('password'),
        ]);

        // Create cashier user
        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@hmart.com',
            'password' => Hash::make('password'),
        ]);

        // Create categories
        $categories = [
            ['name' => 'Makanan', 'slug' => 'makanan'],
            ['name' => 'Minuman', 'slug' => 'minuman'],
            ['name' => 'Snack', 'slug' => 'snack'],
            ['name' => 'Perlengkapan Rumah', 'slug' => 'perlengkapan-rumah'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample products
        $products = [
            [
                'name' => 'Indomie Goreng',
                'barcode' => '8998866100106',
                'description' => 'Mie instan goreng',
                'price' => 3500,
                'stock' => 100,
                'unit' => 'pcs',
                'category_id' => 1,
            ],
            [
                'name' => 'Aqua 600ml',
                'barcode' => '8999999030016',
                'description' => 'Air mineral',
                'price' => 3000,
                'stock' => 50,
                'unit' => 'botol',
                'category_id' => 2,
            ],
            [
                'name' => 'Chitato 65gr',
                'barcode' => '8992771022103',
                'description' => 'Keripik kentang',
                'price' => 12000,
                'stock' => 30,
                'unit' => 'pcs',
                'category_id' => 3,
            ],
            [
                'name' => 'Lifebuoy Sabun',
                'barcode' => '8999999523523',
                'description' => 'Sabun mandi',
                'price' => 8000,
                'stock' => 25,
                'unit' => 'pcs',
                'category_id' => 4,
            ],
            [
                'name' => 'Minyak Goreng 1L',
                'barcode' => '8996001600448',
                'description' => 'Minyak goreng sawit',
                'price' => 25000,
                'stock' => 40,
                'unit' => 'botol',
                'category_id' => 4,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}