<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DonationsController extends AbstractController
{
    #[Route('/donations', name: 'app_donations')]
    public function index(): Response
    {
        return $this->render('donations/index.html.twig', [
            'controller_name' => 'DonationsController',
        ]);
    }
}
