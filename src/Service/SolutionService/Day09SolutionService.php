<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;
use Ds\Set;

class Day09SolutionService implements DaySolutionServiceInterface
{
    private const DIRECTIONS = [
        'U' => ['row' => -1, 'col' => 0],
        'D' => ['row' => 1, 'col' => 0],
        'L' => ['row' => 0, 'col' => -1],
        'R' => ['row' => 0, 'col' => 1],
    ];

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
        return self::findTailVisitedPositions($input)->count();
    }

    private static function calculatePartTwo(string $input): ?string
    {
        return self::findTailVisitedPositions($input, 10)->count();
    }

    private static function parseInput(string $input)
    {
        $commands = explode("\n", $input);
        $commands = array_map(static fn($command) => explode(" ", $command), $commands);

        return $commands;
    }

    private static function findTailVisitedPositions(string $input, int $knotCount = 2): Set
    {
        $commands = self::parseInput($input);

        $visitedPositions = new Set(['0|0']);

        $currentPositions = [];
        for ($i = 0; $i < $knotCount; $i++) {
            $currentPositions[] = ['row' => 0, 'col' => 0];
        }

        foreach ($commands as [$direction, $value]) {
            $value = (int)$value;

            for ($i = 1; $i <= $value; $i++) {
                $movementVector = self::DIRECTIONS[$direction];
                $currentPositions[0]['row'] += $movementVector['row'];
                $currentPositions[0]['col'] += $movementVector['col'];


                for ($j = 1; $j < $knotCount; $j++) {
                    if (self::areAdjacent($currentPositions[$j - 1], $currentPositions[$j])) {
                        continue;
                    }

                    $distances = self::manhattanSplit($currentPositions[$j - 1], $currentPositions[$j]);

                    $movementVector = self::movementVectorFromSignedManhattan($distances);

                    $currentPositions[$j]['row'] += $movementVector['row'];
                    $currentPositions[$j]['col'] += $movementVector['col'];
                }

                $visitedPositions->add(self::positionToString($currentPositions[$knotCount - 1]));
            }
        }

        return $visitedPositions;
    }

    private static function areAdjacent(array $head, array $tail): bool
    {
        $distances = self::manhattanSplit($head, $tail);

        return abs($distances['row']) < 2 && abs($distances['col']) < 2;
    }

    private static function manhattanSplit(array $head, array $tail): array
    {
        $row = $head['row'] - $tail['row'];
        $col = $head['col'] - $tail['col'];

        return compact('row', 'col');
    }

    private static function positionToString(array $position): string
    {
        return "${position['row']}|${position['col']}";
    }

    private static function movementVectorFromSignedManhattan(array $signedDistances): array
    {
        $rowDivisor = $signedDistances['row'] !== 0 ? abs($signedDistances['row']) : 1;
        $colDivisor = $signedDistances['col'] !== 0 ? abs($signedDistances['col']) : 1;

        return [
            'row' => $signedDistances['row'] / $rowDivisor,
            'col' => $signedDistances['col'] / $colDivisor,
        ];
    }
}
