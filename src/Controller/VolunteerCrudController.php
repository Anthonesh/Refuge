<?php

namespace App\Controller;

use App\Entity\Volunteer;
use App\Form\VolunteerType;
use App\Repository\VolunteerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/volunteer/crud')]
class VolunteerCrudController extends AbstractController
{
    #[Route('/', name: 'app_volunteer_crud_index', methods: ['GET'])]
    public function index(VolunteerRepository $volunteerRepository): Response
    {
        return $this->render('volunteer_crud/index.html.twig', [
            'volunteers' => $volunteerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_volunteer_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $volunteer = new Volunteer();
        $form = $this->createForm(VolunteerType::class, $volunteer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($volunteer);
            $entityManager->flush();

            return $this->redirectToRoute('app_volunteer_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('volunteer_crud/new.html.twig', [
            'volunteer' => $volunteer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_volunteer_crud_show', methods: ['GET'])]
    public function show(Volunteer $volunteer): Response
    {
        return $this->render('volunteer_crud/show.html.twig', [
            'volunteer' => $volunteer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_volunteer_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Volunteer $volunteer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(VolunteerType::class, $volunteer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_volunteer_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('volunteer_crud/edit.html.twig', [
            'volunteer' => $volunteer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_volunteer_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Volunteer $volunteer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$volunteer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($volunteer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_volunteer_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
