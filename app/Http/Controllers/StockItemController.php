<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\WarehouseProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StockItemController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = WarehouseProduct::query()
            ->with(['category:id,name,slug', 'suppliers:id,name'])
            ->where('is_active', true)
            ->paginate(15);

        return response()->json([
            'status' => 'success',
            'data' => $products,
        ], 200);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'sku' => ['required', 'string', 'max:50', 'unique:products,sku'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock_quantity' => ['nullable', 'integer', 'min:0'],
            'location_zone' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'suppliers' => ['nullable', 'array'],
            'suppliers.*' => ['integer', 'exists:suppliers,id'],
        ]);

        $product = WarehouseProduct::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'price' => (float) $validated['price'],
            'stock_quantity' => (int) ($validated['stock_quantity'] ?? 0),
            'location_zone' => $validated['location_zone'] ?? 'Zone-A1',
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        if (!empty($validated['suppliers'])) {
            $product->suppliers()->sync($validated['suppliers']);
        }

        $product->load(['category:id,name,slug', 'suppliers:id,name']);

        return response()->json([
            'status' => 'created',
            'data' => $product,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $product = WarehouseProduct::with(['category', 'suppliers'])->findOrFail((int) $id);

        return response()->json([
            'status' => 'success',
            'data' => $product,
        ], 200);
    }
}