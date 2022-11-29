<?php

namespace App\Service;

use App\Entity\Solution;

class SolutionService
{
    public function getSolutionForDay(int $day, string $input): array|Solution
    {
        $solutionServiceName = self::getSolutionServiceName($day);

        try {
            return call_user_func([$solutionServiceName, 'getSolution'], $input);
        } catch (\TypeError $error) {
            return [
                'error' => $error->getMessage()
            ];
        }
    }

    public function getPartOneSolutionForDay(int $day, string $input): array|Solution
    {
        $solutionServiceName = self::getSolutionServiceName($day);

        try {
            return call_user_func([$solutionServiceName, 'getSolutionForPartOne'], $input);
        } catch (\TypeError $error) {
            return [
                'error' => $error->getMessage()
            ];
        }
    }

    public function getPartTwoSolutionForDay(int $day, string $input): array|Solution
    {
        $solutionServiceName = self::getSolutionServiceName($day);

        try {
            return call_user_func([$solutionServiceName, 'getSolutionForPartTwo'], $input);
        } catch (\TypeError $error) {
            return [
                'error' => $error->getMessage()
            ];
        }
    }


    private static function getSolutionServiceName(int $day)
    {
        $paddedDay = str_pad((string)$day, 2, "0", STR_PAD_LEFT);
        $dayServiceName = "Day${paddedDay}SolutionService";

        return "App\Service\SolutionService\\${dayServiceName}";
    }
}
