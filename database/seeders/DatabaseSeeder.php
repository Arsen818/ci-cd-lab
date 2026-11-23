<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\WarehouseProduct;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = Supplier::factory()->count(8)->create();

        Category::factory()
            ->count(5)
            ->has(
                WarehouseProduct::factory()
                    ->count(6)
                    ->afterCreating(function (WarehouseProduct $product) use ($suppliers) {
                        $product->suppliers()->sync(
                            $suppliers->random(2)->pluck('id')->all()
                        );
                    }),
                'products'
            )
            ->create();
    }
}
