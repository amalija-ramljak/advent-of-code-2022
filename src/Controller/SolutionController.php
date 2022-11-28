<?php

namespace App\Controller;

use App\Service\SolutionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/solution/day/{day}')]
class SolutionController extends AbstractController
{
    #[Route('/part/1')]
    public function solutionPartOne(int $day, SolutionService $service): JsonResponse
    {
        $solution = $service->getPartOneSolutionForDay($day);

        return new JsonResponse(['day' => $day, 'part' => 1, 'solution' => $solution->toArray()]);
    }

    #[Route('/part/2')]
    public function solutionPartTwo(int $day, SolutionService $service): JsonResponse
    {
        $solution = $service->getPartTwoSolutionForDay($day);

        return new JsonResponse(['day' => $day, 'part' => 2, 'solution' => $solution->toArray()]);
    }
}
