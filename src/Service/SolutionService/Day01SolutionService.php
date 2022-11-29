<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day01SolutionService implements DaySolutionServiceInterface
{
    public static function getSolution(mixed $args): Solution
    {
        $solutionObject = new Solution(1);

        $result1 = self::calculatePartOne($args);
        $solutionObject->setSolutionForPart1($result1);

        $result2 = self::calculatePartTwo($args);
        $solutionObject->setSolutionForPart2($result2);

        return $solutionObject;
    }

    public static function getSolutionForPartOne(mixed $args): Solution
    {
        $solutionObject = new Solution(1);

        $result = self::calculatePartOne($args);
        $solutionObject->setSolutionForPart1($result);

        return $solutionObject;
    }

    private static function calculatePartOne(mixed $args): int
    {
        return 12;
    }

    public static function getSolutionForPartTwo(mixed $args): Solution
    {
        $solutionObject = new Solution(1);

        $result = self::calculatePartTwo($args);
        $solutionObject->setSolutionForPart2($result);

        return $solutionObject;
    }

    private static function calculatePartTwo(mixed $args): int
    {
        return 12;
    }
}
