<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WarehouseProduct extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'price',
        'stock_quantity',
        'location_zone',
        'is_active',
    ];

    protected $casts = [
        'price' => 'float',
        'stock_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function suppliers(): BelongsToMany
    {
        return $this->belongsToMany(
            Supplier::class,
            'product_supplier',
            'product_id',
            'supplier_id'
        )->withTimestamps();
    }
}
