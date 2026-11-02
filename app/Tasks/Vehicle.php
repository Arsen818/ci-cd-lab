<?php

declare(strict_types=1);

namespace App\Tasks;

abstract class Vehicle
{
    public function __construct(protected float $speed) {}

    abstract public function calculateTravelTime(float $distance): float;
}
