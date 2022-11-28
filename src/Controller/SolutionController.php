<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/solution/day/{day}')]
class SolutionController extends AbstractController
{
    #[Route('/part/1')]
    public function solutionPartOne(int $day): JsonResponse
    {
        return new JsonResponse(['day' => $day, 'part' => 1]);
    }

    #[Route('/part/2')]
    public function solutionPartTwo(int $day): JsonResponse
    {
        return new JsonResponse(['day' => $day, 'part' => 2]);
    }
}
