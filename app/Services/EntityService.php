<?php

declare(strict_types=1);

class EntityService
{
    public static function calculateTotal(float $price, int $quantity): float
    {
        return $price * $quantity;
    }

    public static function applyDiscount(float $price, float $discount): float
    {
        if ($discount < 0 || $discount > 100) {
            throw new Exception('Неприпустиме значення знижки!');
        }

        return $price - ($price * ($discount / 100));
    }
}
