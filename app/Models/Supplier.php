<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'contact_email', 'phone'];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            WarehouseProduct::class,
            'product_supplier',
            'supplier_id',
            'product_id'
        )->withTimestamps();
    }
}
