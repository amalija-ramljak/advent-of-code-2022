<?php

namespace App\Controller;

use App\Service\SolutionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SolutionController extends AbstractController
{
    #[Route('/solution/day/{day}/part/{part}', methods: ['POST'])]
    public function __invoke(int $day, int $part, SolutionService $service, Request $request): JsonResponse
    {
        $input = json_decode($request->getContent(), false)->fileContent;

        if ($part === 1) {
            $solution = $service->getPartOneSolutionForDay($day, $input);
        } elseif ($part === 2) {
            $solution = $service->getPartTwoSolutionForDay($day, $input);
        }

        return new JsonResponse(['solution' => $solution->toArray()]);
    }
}
