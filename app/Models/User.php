<?php

declare(strict_types=1);

namespace App\Models;

class User extends AbstractEntity
{
    public function __construct(
        string $id,
        string $createdAt,
        public string $username
    ) {
        parent::__construct($id, $createdAt);
    }

    public function getDetails(): string
    {
        return "Користувач: {$this->username}";
    }
}
