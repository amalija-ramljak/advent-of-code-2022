<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;
use Ds\Set;

class Day06SolutionService implements DaySolutionServiceInterface
{
    public static function getSolution(string $input): Solution
    {
        $solutionObject = new Solution(1);

        $result1 = self::calculatePartOne($input);
        $solutionObject->setSolutionForPart1($result1);

        $result2 = self::calculatePartTwo($input);
        $solutionObject->setSolutionForPart2($result2);

        return $solutionObject;
    }

    public static function getSolutionForPartOne(string $input): Solution
    {
        $solutionObject = new Solution(1);

        $result = self::calculatePartOne($input);
        $solutionObject->setSolutionForPart1($result);

        return $solutionObject;
    }

    public static function getSolutionForPartTwo(string $input): Solution
    {
        $solutionObject = new Solution(1);

        $result = self::calculatePartTwo($input);
        $solutionObject->setSolutionForPart2($result);

        return $solutionObject;
    }

    private static function calculatePartOne(string $input): ?string
    {
        return self::getResult($input, 4);
    }

    private static function calculatePartTwo(string $input): ?string
    {
        return self::getResult($input, 14);
    }

    private static function getResult(string $input, int $markerLength)
    {
        $parsedInput = mb_str_split($input);
        $length = count($parsedInput);

        for ($i = 0; $i < $length - ($markerLength - 1); $i++) {
            $chunk = new Set(array_slice($parsedInput, $i, $markerLength));

            if ($chunk->count() === $markerLength) {
                return $i + $markerLength;
            }
        }

        return -1;
    }
}
