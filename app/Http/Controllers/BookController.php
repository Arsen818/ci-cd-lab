<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    private array $items = [
        ['id' => 1, 'isbn' => '978-5-17-090956-2', 'title' => 'Алгоритми та структури даних', 'author' => 'Дональд Кнут', 'publication_year' => 2020],
        ['id' => 2, 'isbn' => '978-617-12-0000-1', 'title' => 'Clean Code: Посібник з чистого написання коду', 'author' => 'Роберт Мартін', 'publication_year' => 2018],
        ['id' => 3, 'isbn' => '978-966-938-000-2', 'title' => 'Програмування на PHP 8', 'author' => 'Кевін Тетлоу', 'publication_year' => 2022],
    ];

    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->items,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'isbn' => ['required', 'string', 'min:10', 'max:20'],
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'author' => ['required', 'string', 'min:2', 'max:255'],
            'publication_year' => ['required', 'integer', 'min:1900', 'max:2026'],
        ]);

        $newItem = [
            'id' => count($this->items) + 1,
            'isbn' => $validated['isbn'],
            'title' => $validated['title'],
            'author' => $validated['author'],
            'publication_year' => (int) $validated['publication_year'],
        ];

        $this->items[] = $newItem;

        return response()->json([
            'status' => 'created',
            'data' => $newItem,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $itemId = (int) $id;
        foreach ($this->items as $item) {
            if ($item['id'] === $itemId) {
                return response()->json([
                    'status' => 'success',
                    'data' => $item,
                ], 200);
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Ресурс із зазначеним ідентифікатором не знайдено.',
        ], 404);
    }
}
