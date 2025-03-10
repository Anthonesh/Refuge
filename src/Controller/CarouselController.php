<?php

namespace App\Controller;

use App\Repository\ResidentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CarouselController extends AbstractController
{
    #[Route('/components/carousel', name: 'app_carousel')]
    public function index(ResidentsRepository $residentsRepository): Response
    {
        $residents = $residentsRepository->findAll();

        return $this->render('components/carousel.html.twig', [
            'controller_name' => 'CarouselController',
            'residents' => $residents,
        ]);
    }
}
