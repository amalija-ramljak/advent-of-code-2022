<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day05SolutionService implements DaySolutionServiceInterface
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
        $data = self::parseInput($input);

        foreach ($data['moves'] as $move) {
            for ($i = 0; $i < $move[0]; $i++) {
                $crate = array_pop($data['stacks'][$move[1]]);
                $data['stacks'][$move[2]][] = $crate;
            }
        }

        return self::getResult($data['stacks'], $data['maxStackNumber']);
    }

    private static function calculatePartTwo(string $input): ?string
    {
        $data = self::parseInput($input);

        foreach ($data['moves'] as $move) {
            $source = $data['stacks'][$move[1]];
            $movedCrates = array_splice($data['stacks'][$move[1]], count($source) - $move[0]);

            $data['stacks'][$move[2]] = array_merge(
                $data['stacks'][$move[2]],
                $movedCrates
            );
        }

        return self::getResult($data['stacks'], $data['maxStackNumber']);
    }

    private static function getResult(array $stacks, int $maxStackNumber): string
    {
        $stackTops = [];
        for ($i = 1; $i <= $maxStackNumber; $i++) {
            $stackTops[] = array_pop($stacks[$i]);
        }

        return implode("", $stackTops);
    }

    private static function parseInput(string $input)
    {
        $sections = explode("\n\n", $input);

        $moves = explode("\n", $sections[1]);
        $moves = array_map(static function ($move) {
            $matches = [];
            preg_match_all("/\d+/", $move, $matches);

            return array_map(static fn($match) => (int)$match, $matches[0]);
        }, $moves);

        $stacks = [];
        $stacksUnparsed = explode("\n", $sections[0]);

        $numbers = explode("   ", array_pop($stacksUnparsed));
        $maxStackNumber = 0;
        foreach ($numbers as $number) {
            $maxStackNumber = (int)$number;
            $stacks[$maxStackNumber] = [];
        }

        foreach (array_reverse($stacksUnparsed) as $stackLine) {
            $stackLineArray = mb_str_split($stackLine);

            for ($i = 0; $i < $maxStackNumber; $i++) {
                $value = $stackLineArray[1 + $i * 4];
                if ($value !== " ") {
                    $stacks[$i + 1][] = $value;
                }
            }
        }

        return compact('moves', 'stacks', 'maxStackNumber');
    }
}
