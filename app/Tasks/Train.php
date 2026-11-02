<?php

declare(strict_types=1);

namespace App\Tasks;

class Train extends Vehicle
{
    public function calculateTravelTime(float $distance): float
    {
        return ($distance / $this->speed) + 0.5; // Додаємо півгодини на зупинки
    }
}
