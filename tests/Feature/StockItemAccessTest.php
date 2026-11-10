<?php
declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class StockItemAccessTest extends TestCase
{
    public function test_request_without_scanner_token_is_blocked_by_middleware(): void
    {
        $response = $this->postJson('/warehouse', [
            'sku' => 'SKU-TEST-999',
            'title' => 'Тестова позиція',
            'quantity' => 10,
            'location_zone' => 'Zone-Z9',
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'access_denied',
            ]);
    }

    public function test_request_with_valid_scanner_token_passes_middleware(): void
    {
        $response = $this->withHeaders([
            'X-Scanner-Token' => 'VALID_SCANNER_KEY',
        ])->postJson('/warehouse', [
            'sku' => 'SKU-TEST-999',
            'title' => 'Тестова позиція',
            'quantity' => 10,
            'location_zone' => 'Zone-Z9',
        ]);

        $response->assertStatus(201);
        $response->assertHeader('X-Security-Policy', 'Enforced');
    }
}
