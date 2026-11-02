<?php

declare(strict_types=1);

namespace App\Tasks;

class Worker
{
    public function __construct(
        public readonly float $baseRate,
        public readonly int $productionCount,
        public readonly float $unitPrice
    ) {}

    public function calculateSalary(): float
    {
        return $this->baseRate + ($this->productionCount * 0.05 * $this->unitPrice);
    }
}
