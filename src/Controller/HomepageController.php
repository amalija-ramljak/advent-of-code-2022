<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    #[Route('/', 'homepage')]
    public function __invoke(): Response
    {
        $finder = new Finder();
        $projectDir = $this->getParameter('kernel.project_dir');
        $solutionServicesCount = $finder->files()->in("${projectDir}/src/Service/SolutionService")->count() - 1;

        return $this->render('routes/homepage.html.twig', ['days' => range(1, $solutionServicesCount)]);
    }
}
