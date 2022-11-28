<?php

namespace App\Controller;

use App\Service\SolutionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/solution/day/{day}')]
class SolutionController extends AbstractController
{
    #[Route('/part/1', methods: ['POST'])]
    public function solutionPartOne(int $day, SolutionService $service, Request $request): JsonResponse
    {
        $input = json_decode($request->getContent(), false)->fileContent;
        $solution = $service->getPartOneSolutionForDay($day, $input);

        return new JsonResponse(['day' => $day, 'part' => 1, 'solution' => $solution->toArray()]);
    }

    #[Route('/part/2', methods: ['POST'])]
    public function solutionPartTwo(int $day, SolutionService $service, Request $request): JsonResponse
    {
        $input = json_decode($request->getContent(), false)->fileContent;
        $solution = $service->getPartTwoSolutionForDay($day, $input);

        return new JsonResponse(['day' => $day, 'part' => 2, 'solution' => $solution->toArray()]);
    }
}
