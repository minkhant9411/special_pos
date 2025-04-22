<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Supplier::create([
        //     'name' => 'supplier1',
        //     'description' => 'yangon 19th street, 09797797797'
        // ]);
        // Customer::create([
        //     'name' => 'customer1',
        //     'description' => 'yangon 19th street, 09797797797'
        // ]);
        // Category::create([
        //     'name' => 'Drinks',
        //     'transaction_type' => 'for_both',
        //     'created_by' => 1
        // ]);
        // Category::create([
        //     'name' => 'Breakfast',
        //     'transaction_type' => 'for_sale',
        //     'created_by' => 1
        // ]);
        // Category::create([
        //     'name' => 'Kitchen',
        //     'transaction_type' => 'for_purchase',
        //     'created_by' => 1
        // ]);
        // Product::create([
        //     'name' => 'Shark',
        //     "category_id" => 1,
        //     'cost_price' => 2000,
        //     'price' => 2500,
        //     'unit' => 'can',
        //     'created_by' => 1

        // ]);
        // Product::create([
        //     'name' => 'Pa la tar',
        //     "category_id" => 2,
        //     'cost_price' => 1500,
        //     'price' => 2000,
        //     'unit' => 'pwal',
        //     'created_by' => 1

        // ]);
        for ($i = 1; $i < 20; $i++) {
            Product::create([
                'name' => fake()->firstName(),
                "category_id" => mt_rand(1, 3),
                'cost_price' => 5000,
                'price' => 5000,
                'unit' => 'unit',
                'created_by' => 1

            ]);

        }

    }
}
