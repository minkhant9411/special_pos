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

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);
        User::factory()->create([
            'name' => 'Casher',
            'email' => 'casher@gmail.com',
            'role' => 'casher'
        ]);
        $categories = [
            "Appetizers",
            "Salads",
            "Soups",
            "Main Courses",
            "Pasta",
            "Pizza",
            "Sandwiches & Burgers",
            "Seafood",
            "Desserts",
            "Beverages"
        ];
        $products = [
            # Appetizers (Category 1)
            "Bruschetta",
            "Mozzarella Sticks",
            "Spinach Artichoke Dip",
            "Calamari",
            "Stuffed Mushrooms",
            "Chicken Wings",
            "Spring Rolls",
            "Shrimp Cocktail",
            "Nachos",
            "Garlic Bread",

            # Salads (Category 2)
            "Caesar Salad",
            "Greek Salad",
            "Caprese Salad",
            "Cobb Salad",
            "House Salad",
            "Spinach Salad",
            "Arugula Salad",
            "Asian Chicken Salad",
            "Quinoa Salad",
            "Waldorf Salad",

            # Soups (Category 3)
            "Tomato Basil Soup",
            "French Onion Soup",
            "Clam Chowder",
            "Minestrone",
            "Lentil Soup",
            "Chicken Noodle Soup",
            "Miso Soup",
            "Potato Leek Soup",
            "Gazpacho",
            "Beef Barley Soup",

            # Main Courses (Category 4)
            "Grilled Salmon",
            "Filet Mignon",
            "Chicken Parmesan",
            "Beef Stroganoff",
            "Lamb Chops",
            "Vegetable Stir Fry",
            "Pork Tenderloin",
            "Duck Confit",
            "Ratatouille",
            "BBQ Ribs",

            # Pasta (Category 5)
            "Spaghetti Carbonara",
            "Fettuccine Alfredo",
            "Penne Arrabbiata",
            "Lasagna",
            "Ravioli",
            "Linguine Clams",
            "Mac & Cheese",
            "Pesto Pasta",
            "Shrimp Scampi",
            "Mushroom Risotto",

            # Pizza (Category 6)
            "Margherita",
            "Pepperoni",
            "Vegetarian",
            "Hawaiian",
            "BBQ Chicken",
            "Mushroom Truffle",
            "Four Cheese",
            "Meat Lovers",
            "Buffalo Chicken",
            "White Pizza",

            # Sandwiches & Burgers (Category 7)
            "Classic Burger",
            "Cheeseburger",
            "Chicken Sandwich",
            "BLT",
            "Philly Cheesesteak",
            "Club Sandwich",
            "Reuben",
            "Grilled Cheese",
            "Veggie Burger",
            "Turkey Avocado Wrap",

            # Seafood (Category 8)
            "Lobster Roll",
            "Fish & Chips",
            "Grilled Shrimp Skewers",
            "Seafood Paella",
            "Crab Cakes",
            "Oysters Rockefeller",
            "Sushi Platter",
            "Cioppino",
            "Tuna Tartare",
            "Mussels Marinara",

            # Desserts (Category 9)
            "Chocolate Lava Cake",
            "Cheesecake",
            "Tiramisu",
            "Crème Brûlée",
            "Apple Pie",
            "Ice Cream Sundae",
            "Key Lime Pie",
            "Chocolate Mousse",
            "Bread Pudding",
            "Strawberry Shortcake",

            # Beverages (Category 10)
            "Soda",
            "Iced Tea",
            "Lemonade",
            "Coffee",
            "Hot Tea",
            "Milkshake",
            "Smoothie",
            "Beer",
            "Wine",
            "Cocktails"
        ];
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
        for ($j = 1; $j < count($categories); $j++) {
            Category::create([
                'name' => $categories[$j],
                'transaction_type' => 'for_both',
                'created_by' => 1

            ]);

        }
        for ($i = 1; $i < count($products); $i++) {
            Product::create([
                'name' => $products[$i],
                "category_id" => mt_rand(1, count($categories) - 1),
                'cost_price' => 5000,
                'price' => 5000,
                'unit' => 'unit',
                'created_by' => 1

            ]);

        }

    }
}
