<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

class Day01SolutionService implements DaySolutionServiceInterface
{
    public static function getSolution(mixed $args): Solution
    {
        $solutionObject = new Solution(1);

        return $solutionObject;
    }
}
