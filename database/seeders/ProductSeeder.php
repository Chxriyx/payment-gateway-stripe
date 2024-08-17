<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            ['name' => 'Product 1', 'description' => 'Description 1', 'price' => 10.00],
            ['name' => 'Product 2', 'description' => 'Description 2', 'price' => 20.00],
            ['name' => 'Product 3', 'description' => 'Description 3', 'price' => 30.00],
            ['name' => 'Product 4', 'description' => 'Description 4', 'price' => 40.00],
            ['name' => 'Product 5', 'description' => 'Description 5', 'price' => 50.00],
            ['name' => 'Product 6', 'description' => 'Description 6', 'price' => 60.00],
            ['name' => 'Product 7', 'description' => 'Description 7', 'price' => 70.00],
            ['name' => 'Product 8', 'description' => 'Description 8', 'price' => 80.00],
            ['name' => 'Product 9', 'description' => 'Description 9', 'price' => 90.00],
            ['name' => 'Product 10', 'description' => 'Description 10', 'price' => 100.00]
        ]);
    }
}
