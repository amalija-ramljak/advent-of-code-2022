<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;
use App\Service\MapService;

class Day08SolutionService implements DaySolutionServiceInterface
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

    private static function calculatePartOne(string $input): ?int
    {
        $trees = self::parseInput($input);

        return self::countVisibleTreesInFourDirections($trees);
    }

    private static function calculatePartTwo(string $input): ?int
    {
        $trees = self::parseInput($input);

        return self::findMostScenicTreeScore($trees);
    }

    private static function countVisibleTreesInFourDirections(array $treeMap): int
    {
        $rowCount = count($treeMap);
        $columnCount = count($treeMap[0]);

        $visibleTreeCount = 2 * ($rowCount - 2) + 2 * $columnCount;
        for ($row = 1; $row < $rowCount - 1; $row++) {
            for ($column = 1; $column < $columnCount - 1; $column++) {
                $isTreeVisible = self::getVisibilityForTree($treeMap, $rowCount, $columnCount, $row, $column);
                if ($isTreeVisible) {
                    $visibleTreeCount++;
                }
            }
        }

        return $visibleTreeCount;
    }

    private static function getVisibilityForTree(array $treeMap, int $rowCount, int $columnCount, int $treeRow, int $treeColumn): bool
    {
        $treeHeight = $treeMap[$treeRow][$treeColumn];

        $visible = true;
        for ($row = 0; $row < $treeRow; $row++) {
            if ($treeMap[$row][$treeColumn] >= $treeHeight) {
                $visible = false;
                break;
            }
        }
        if ($visible) {
            return true;
        }

        $visible = true;
        for ($row = $treeRow + 1; $row < $rowCount; $row++) {
            if ($treeMap[$row][$treeColumn] >= $treeHeight) {
                $visible = false;
                break;
            }
        }
        if ($visible) {
            return true;
        }

        $visible = true;
        for ($col = 0; $col < $treeColumn; $col++) {
            if ($treeMap[$treeRow][$col] >= $treeHeight) {
                $visible = false;
                break;
            }
        }
        if ($visible) {
            return true;
        }

        for ($col = $treeColumn + 1; $col < $columnCount; $col++) {
            if ($treeMap[$treeRow][$col] >= $treeHeight) {
                return false;
            }
        }

        return true;
    }

    private static function findMostScenicTreeScore(array $treeMap): int
    {
        $rowCount = count($treeMap);
        $columnCount = count($treeMap[0]);

        $highestScore = 0;
        for ($row = 0; $row < $rowCount; $row++) {
            for ($column = 0; $column < $columnCount; $column++) {
                $scenicScore = self::getScenicScoreForTree($treeMap, $rowCount, $columnCount, $row, $column);
                if ($scenicScore > $highestScore) {
                    $highestScore = $scenicScore;
                }
            }
        }

        return $highestScore;
    }

    private static function getScenicScoreForTree(array $treeMap, int $rowCount, int $columnCount, int $treeRow, int $treeColumn): int
    {
        $treeHeight = $treeMap[$treeRow][$treeColumn];
        $scenicScore = ['top' => 0, 'bottom' => 0, 'left' => 0, 'right' => 0];

        for ($row = $treeRow - 1; $row > -1; $row--) {
            if ($treeMap[$row][$treeColumn] >= $treeHeight) {
                $scenicScore['top']++;
                break;
            }

            $scenicScore['top']++;
        }

        for ($row = $treeRow + 1; $row < $rowCount; $row++) {
            if ($treeMap[$row][$treeColumn] >= $treeHeight) {
                $scenicScore['bottom']++;
                break;
            }

            $scenicScore['bottom']++;
        }

        for ($col = $treeColumn - 1; $col > -1; $col--) {
            if ($treeMap[$treeRow][$col] >= $treeHeight) {
                $scenicScore['left']++;
                break;
            }

            $scenicScore['left']++;
        }

        for ($col = $treeColumn + 1; $col < $columnCount; $col++) {
            if ($treeMap[$treeRow][$col] >= $treeHeight) {
                $scenicScore['right']++;
                break;
            }

            $scenicScore['right']++;
        }

        return $scenicScore['top'] * $scenicScore['bottom'] * $scenicScore['left'] * $scenicScore['right'];
    }

    private static function parseInput(string $input): array
    {
        $treeRows = explode("\n", $input);
        $trees = array_map([self::class, 'mapTreeRow'], $treeRows);

        return $trees;
    }

    private static function mapTreeRow(string $treeRow): array
    {
        return array_map([MapService::class, 'mapStringToNumber'], mb_str_split($treeRow));
    }
}
