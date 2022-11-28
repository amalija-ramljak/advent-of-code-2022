<?php

namespace App\Controller;

use App\Service\SolutionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DayController extends AbstractController
{
    #[Route('/day/{day}', 'day')]
    public function __invoke(int $day, SolutionService $service): Response
    {
        return $this->render('routes/day.html.twig', ['day' => $day]);
    }
}
