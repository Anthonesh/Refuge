<?php

namespace App\Controller;

use App\Repository\ResidentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index( ResidentsRepository $ResidentsRepository ): Response
    {

        $residents = $ResidentsRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'residents' => $residents,
        ]);
    }
}
