<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Supplier;
use App\Models\WarehouseProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_products_with_relations(): void
    {
        $category = Category::factory()->create(['name' => 'Складське обладнання']);
        WarehouseProduct::factory()->create([
            'category_id' => $category->id,
            'name' => 'Палетний візок',
            'is_active' => true,
        ]);

        $response = $this->getJson('/warehouse');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Палетний візок'])
            ->assertJsonFragment(['name' => 'Складське обладнання']);
    }

    public function test_can_create_product_with_category_and_suppliers_in_database(): void
    {
        $category = Category::factory()->create();
        $suppliers = Supplier::factory()->count(2)->create();

        $payload = [
            'category_id' => $category->id,
            'name' => 'Сканер штрихкодів Pro',
            'sku' => 'SCAN-0099',
            'price' => 3200.50,
            'stock_quantity' => 10,
            'location_zone' => 'Zone-B2',
            'is_active' => true,
            'suppliers' => $suppliers->pluck('id')->toArray(),
        ];

        $response = $this->withHeaders([
            'X-App-Client' => 'warehouse-scanner',
            'X-Scanner-Token' => 'VALID_KEY',
        ])->postJson('/warehouse', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'sku' => 'SCAN-0099',
            'name' => 'Сканер штрихкодів Pro',
            'category_id' => $category->id,
        ]);

        $productId = $response->json('data.id');
        foreach ($suppliers as $supplier) {
            $this->assertDatabaseHas('product_supplier', [
                'product_id' => $productId,
                'supplier_id' => $supplier->id,
            ]);
        }
    }
}
