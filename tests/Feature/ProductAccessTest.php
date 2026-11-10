<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ProductAccessTest extends TestCase
{
    public function test_request_without_client_header_is_blocked_by_middleware(): void
    {
        $response = $this->postJson('/books', [
            'isbn' => '978-966-00-0000-0',
            'title' => 'Тестова книга',
            'author' => 'Тест Автор',
            'publication_year' => 2024,
        ]);

        $response->assertStatus(403)
            ->assertJson([
                'status' => 'access_denied',
            ]);
    }

    public function test_request_with_valid_header_passes_middleware(): void
    {
        $response = $this->withHeaders([
            'X-App-Client' => 'LibraryLibrarianTerminal',
        ])->postJson('/books', [
            'isbn' => '978-966-00-0000-0',
            'title' => 'Тестова книга',
            'author' => 'Тест Автор',
            'publication_year' => 2024,
        ]);

        $response->assertStatus(201);
        $response->assertHeader('X-Security-Policy', 'Enforced');
    }
}
