<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UpcomingProjectsController extends AbstractController
{
    #[Route('/upcoming/projects', name: 'app_upcoming_projects')]
    public function index(): Response
    {
        return $this->render('upcoming_projects/index.html.twig', [
            'controller_name' => 'UpcomingProjectsController',
        ]);
    }
}
