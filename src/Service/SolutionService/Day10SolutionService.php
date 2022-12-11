<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day10SolutionService implements DaySolutionServiceInterface
{
    private const CYCLES = [
        'addx' => 2,
        'noop' => 1,
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
        $instructions = self::parseInput($input);
        $signalStrengths = self::getSignalStrengthForCycles($instructions, [20, 60, 100, 140, 180, 220]);

        return array_sum($signalStrengths);
    }

    private static function calculatePartTwo(string $input): ?string
    {
        $instructions = self::parseInput($input);

        return self::drawOnCRT($instructions);
    }

    private static function parseInput(string $input): array
    {
        $instructions = explode("\n", $input);

        return array_map(static function (string $instruction) {
            $instructionArray = explode(" ", $instruction);

            if (count($instructionArray) === 1) {
                return [$instructionArray[0], null];
            }

            return [$instructionArray[0], (int)$instructionArray[1]];
        }, $instructions);
    }

    private static function getSignalStrengthForCycles(array $instructions, array $cycles)
    {
        $registerX = 1;
        $cycle = 0;
        $signalStrengths = [];

        foreach ($instructions as $instruction) {
            $cycleCount = self::CYCLES[$instruction[0]];

            for ($i = 0; $i < $cycleCount; $i++) {
                $cycle++;

                if (in_array($cycle, $cycles, true)) {
                    $signalStrengths[] = $cycle * $registerX;
                }
            }

            if ($instruction[0] === 'addx') {
                $registerX += $instruction[1];
            }
        }

        return $signalStrengths;
    }

    private static function drawOnCRT(array $instructions)
    {
        $registerX = 1;
        $cycle = 0;
        $crt = [];

        foreach ($instructions as $instruction) {
            $cycleCount = self::CYCLES[$instruction[0]];

            for ($i = 0; $i < $cycleCount; $i++) {
                $pixel = $cycle % 40;

                if ($pixel === $registerX || $pixel === $registerX - 1 || $pixel === $registerX + 1) {
                    $crt[] = '#';
                } else {
                    $crt[] = '.';
                }

                    $cycle++;
                if ($cycle % 40 === 0) {
                    $crt[] = '\n';
                }
            }

            if ($instruction[0] === 'addx') {
                $registerX += $instruction[1];
            }
        }

        return implode("", $crt);
    }
}
