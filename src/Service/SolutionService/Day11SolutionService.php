<?php

namespace App\Service\SolutionService;

use App\Entity\Monkey;
use App\Entity\Solution;
use App\Service\MapService;

class Day11SolutionService implements DaySolutionServiceInterface
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
        $monkeys = self::parseInput($input);

        for ($i = 0; $i < 20; $i++) {
            self::runRound($monkeys);
        }

        $inspections = array_map(static fn(Monkey $monkey) => $monkey->getInspections(), $monkeys);
        rsort($inspections);

        return $inspections[0] * $inspections[1];
    }

    private static function calculatePartTwo(string $input): ?int
    {
        $monkeys = self::parseInput($input, false);

        for ($i = 0; $i < 10_000; $i++) {
            self::runRound($monkeys);
        }

        $inspections = array_map(static fn(Monkey $monkey) => $monkey->getInspections(), $monkeys);
        rsort($inspections);

        return $inspections[0] * $inspections[1];
    }

    /**
     * @param Monkey[] $monkeys
     * @return void
     */
    private static function runRound(array $monkeys): void
    {
        foreach ($monkeys as $monkey) {
            $throwActions = $monkey->takeTurn();

            foreach ($throwActions as $throwAction) {
                $monkeys[$throwAction['monkey']]->catchItem($throwAction['item']);
            }
        }
    }

    /** @return Monkey[] */
    private static function parseInput(string $input, bool $lessenWorry = true): array
    {
        $monkeyData = explode("\n\n", $input);
        $monkeys = [];

        $specialMod = 1;
        foreach ($monkeyData as $monkeyDatum) {
            $monkeyDatum = explode("\n", $monkeyDatum);

            $items = array_map(
                [MapService::class, 'mapStringToNumber'],
                explode(
                    ", ",
                    explode(": ", $monkeyDatum[1])[1]
                )
            );

            $divisibleBy = (int)array_slice(explode(" ", $monkeyDatum[3]), -1)[0];
            $specialMod *= $divisibleBy;

            $ifTrue = (int)array_slice(explode(" ", $monkeyDatum[4]), -1)[0];
            $ifFalse = (int)array_slice(explode(" ", $monkeyDatum[5]), -1)[0];

            $monkeys[] = new Monkey($items, $monkeyDatum[2], $divisibleBy, $ifTrue, $ifFalse, $lessenWorry);
        }

        foreach ($monkeys as $monkey) {
            $monkey->setSpecialMod($specialMod);
        }

        return $monkeys;
    }
}
