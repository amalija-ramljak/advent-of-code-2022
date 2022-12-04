<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;
use Ds\Set;

class Day03SolutionService implements DaySolutionServiceInterface
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
        $rucksacks = self::parseInput($input);

        $prioritySum = 0;
        foreach ($rucksacks as $rucksack) {
            $sharedItemType = $rucksack['first']->intersect($rucksack['second'])->get(0);
            $prioritySum += self::getItemTypePriority($sharedItemType);
        }

        return $prioritySum;
    }

    private static function calculatePartTwo(string $input): ?int
    {
        $rucksacks = self::parseInput($input);
        $numberOfRucksacks = count($rucksacks);

        $groupPrioritySum = 0;
        for ($i = 0; $i <= $numberOfRucksacks - 3; $i += 3) {
            $rucksacks[$i]['first']->add(...$rucksacks[$i]['second']->toArray());
            $rucksacks[$i + 1]['first']->add(...$rucksacks[$i + 1]['second']->toArray());
            $rucksacks[$i + 2]['first']->add(...$rucksacks[$i + 2]['second']->toArray());

            $sharedItemType = $rucksacks[$i]['first']
                ->intersect($rucksacks[$i + 1]['first'])
                ->intersect($rucksacks[$i + 2]['first']);
            $groupPrioritySum += self::getItemTypePriority($sharedItemType->get(0));
        }

        return $groupPrioritySum;
    }

    private static function parseInput(string $input)
    {
        $rucksacks = explode("\n", $input);

        return array_map(static function (string $rucksack) {
            $halfLength = mb_strlen($rucksack) / 2;
            return [
                'first' => new Set(mb_str_split(mb_substr($rucksack, 0, $halfLength))),
                'second' => new Set(mb_str_split(mb_substr($rucksack, $halfLength))),
            ];
        }, $rucksacks);
    }

    private static function getItemTypePriority(string $itemType)
    {
        $priority = ord($itemType);
        $priority -= 96;
        if ($priority < 1) {
            $priority += 58;
        }

        return $priority;
    }
}
