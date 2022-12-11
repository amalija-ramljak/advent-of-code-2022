<?php

namespace App\Service;

class MapService
{
    public static function mapArrayToSum(array $array): int
    {
        return array_reduce(
            $array,
            static fn($total, $value) => $total + $value,
            0
        );
    }

    public static function mapStringToNumber(string $number)
    {
        return (int)$number;
    }
}
