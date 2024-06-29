<?php

namespace App\Controller;

use App\Repository\ResidentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ResidentsController extends AbstractController
{
    #[Route('/residents', name: 'app_residents')]
    public function index( ResidentsRepository $ResidentsRepository ): Response
    {

        $residents = $ResidentsRepository->findAll();

        return $this->render('residents/index.html.twig', [
            'controller_name' => 'ResidentsController',
            'residents' => $residents,
        ]);
    }
}
