<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day01SolutionService implements DaySolutionServiceInterface
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

    private static function calculatePartOne(string $input): ?int
    {
        $caloriesPerElf = self::getTotalCaloriesPerElf($input);

        return max($caloriesPerElf);
    }

    public static function getSolutionForPartTwo(string $input): Solution
    {
        $solutionObject = new Solution(1);

        $result = self::calculatePartTwo($input);
        $solutionObject->setSolutionForPart2($result);

        return $solutionObject;
    }

    private static function calculatePartTwo(string $input): ?int
    {
        $caloriesPerElf = self::getTotalCaloriesPerElf($input);

        rsort($caloriesPerElf);
        $caloriesPerElf = array_slice($caloriesPerElf, 0, 3);

        return self::mapArrayToSum($caloriesPerElf);
    }

    private static function getTotalCaloriesPerElf(string $input): array
    {
        $caloriesPerElf = explode("\n\n", $input);
        foreach ($caloriesPerElf as $index => $elfCalories) {
            $caloriesPerElf[$index] = array_map(
                static fn($calorie) => (int)$calorie,
                explode("\n", $elfCalories)
            );
        }

        return array_map(
            [self::class, 'mapArrayToSum'],
            $caloriesPerElf
        );
    }

    private static function mapArrayToSum(array $array): int
    {
        return array_reduce(
            $array,
            static fn($total, $calorieCount) => $total + $calorieCount,
            0
        );
    }
}
