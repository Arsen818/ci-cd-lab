<?php

declare(strict_types=1);

class DataProcessor
{
    // Варіант 3.2: Впорядкувати масив за спаданням
    public static function sortDescending(array $numbers): array
    {
        rsort($numbers);

        return $numbers;
    }

    public static function getLastThreeWords(string $text): string
    {
        $words = explode(' ', trim($text));
        if (count($words) <= 3) {
            return $text;
        }

        return implode(' ', array_slice($words, -3));
    }

    public static function shuffleMiddleWords(string $text): string
    {
        $words = explode(' ', trim($text));
        $count = count($words);

        if ($count <= 2) {
            return $text;
        }

        $result = [];
        foreach ($words as $index => $word) {
            if ($index === 0 || $index === $count - 1) {
                $result[] = $word;
            } else {
                $result[] = str_shuffle($word);
            }
        }

        return implode(' ', $result);
    }
}
