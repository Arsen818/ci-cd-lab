<?php

declare(strict_types=1);

namespace App\Tasks;

class Genre
{
    private array $artists = [];

    public function __construct(
        public readonly int $genre_id,
        public readonly string $name
    ) {}

    public function addArtist(Artist $artist): void
    {
        $this->artists[] = $artist;
    }

    public function getArtists(): array
    {
        return $this->artists;
    }
}
