<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    private array $items = [
        ['id' => 1, 'sku' => 'SKU-001-A', 'title' => 'Промисловий стелаж', 'quantity' => 15, 'location_zone' => 'Zone-A1'],
        ['id' => 2, 'sku' => 'SKU-002-B', 'title' => 'Гідравлічний візок', 'quantity' => 5, 'location_zone' => 'Zone-B2'],
        ['id' => 3, 'sku' => 'SKU-003-C', 'title' => 'Сканер штрихкодів', 'quantity' => 25, 'location_zone' => 'Zone-C3'],
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
            'sku' => ['required', 'string', 'min:3', 'max:50'],
            'title' => ['required', 'string', 'min:2', 'max:255'],
            'quantity' => ['required', 'integer', 'min:0'],
            'location_zone' => ['required', 'string', 'min:2', 'max:50'],
        ]);

        $newItem = [
            'id' => count($this->items) + 1,
            'sku' => $validated['sku'],
            'title' => $validated['title'],
            'quantity' => (int) $validated['quantity'],
            'location_zone' => $validated['location_zone'],
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