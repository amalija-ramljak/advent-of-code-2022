<?php

namespace App\Service\SolutionService;

interface DaySolutionServiceInterface
{
    public static function getSolution(mixed $args): Solution;
}
