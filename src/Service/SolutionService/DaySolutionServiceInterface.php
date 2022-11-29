<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

interface DaySolutionServiceInterface
{
    public static function getSolution(string $input): Solution;
    public static function getSolutionForPartOne(string $input): Solution;
    public static function getSolutionForPartTwo(string $input): Solution;
}
