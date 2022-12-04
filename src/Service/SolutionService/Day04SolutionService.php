<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day04SolutionService implements DaySolutionServiceInterface
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
        $pairs = self::parseInput($input);

        $wrapPairs = 0;
        foreach ($pairs as $pair) {
            if (self::eitherRangeFullyContainsOther($pair[0], $pair[1])) {
                ++$wrapPairs;
            }
        }

        return $wrapPairs;
    }

    private static function calculatePartTwo(string $input): ?int
    {
        $pairs = self::parseInput($input);

        $overlapPairs = 0;
        foreach ($pairs as $pair) {
            if (self::noOverlap($pair[0], $pair[1])) {
                continue;
            }

            ++$overlapPairs;
        }

        return $overlapPairs;
    }

    private static function eitherRangeFullyContainsOther(array $rangeA, array $rangeB): bool
    {
        return self::firstRangeWrapsSecondRange($rangeA, $rangeB)
            || self::firstRangeWrapsSecondRange($rangeB, $rangeA);
    }

    private static function firstRangeWrapsSecondRange(array $rangeA, array $rangeB): bool
    {
        return $rangeA[0] <= $rangeB[0] && $rangeA[1] >= $rangeB[1];
    }

    private static function noOverlap(array $rangeA, array $rangeB): bool
    {
        return $rangeA[1] < $rangeB[0] || $rangeA[0] > $rangeB[1];
    }

    private static function parseInput(string $input): array
    {
        $pairs = explode("\n", $input);

        return array_map([self::class, 'mapPairsToPartners'], $pairs);
    }

    private static function mapPairsToPartners(string $pair): array
    {
        $partners = explode(",", $pair);

        return array_map([self::class, 'mapPartnerToRange'], $partners);
    }

    private static function mapPartnerToRange(string $partner): array
    {
        $partnerRange = explode("-", $partner);

        return array_map([self::class, 'mapRangeElementToNumber'], $partnerRange);
    }

    private static function mapRangeElementToNumber(string $rangeElement): int
    {
        return (int)$rangeElement;
    }
}
