<?php

namespace App\Service;

class SolutionService
{
    public function getSolutionForDay(int $day): array
    {
        $paddedDayNumber = str_pad((string)$day, 2, "0", STR_PAD_LEFT);
        $dayServiceName = "Day${paddedDayNumber}SolutionService";

        try {
            return [
                'solution' => call_user_func(["App\Service\SolutionService\\${dayServiceName}", 'getSolution'], ['args' => $dayServiceName])
            ];
        } catch (\TypeError $error) {
            return [
                'error' => $error->getMessage()
            ];
        }
    }
}
