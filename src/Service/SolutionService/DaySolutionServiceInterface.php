<?php

namespace App\Service\SolutionService;

use App\Entity\Solution;

interface DaySolutionServiceInterface
{
    public static function getSolution(mixed $args): Solution;
}
