<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Engine Parts',
                'description' => 'Parts related to motorcycle engines',
                'status' => 'active'
            ],
            [
                'name' => 'Brake Systems',
                'description' => 'Brake pads, discs, and other brake components',
                'status' => 'active'
            ],
            [
                'name' => 'Electrical',
                'description' => 'Electrical components including batteries, lights, and wiring',
                'status' => 'active'
            ],
            [
                'name' => 'Tires & Wheels',
                'description' => 'Tires, tubes, and wheel components',
                'status' => 'active'
            ],
            [
                'name' => 'Oils & Fluids',
                'description' => 'Engine oils, brake fluids, and coolants',
                'status' => 'active'
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}