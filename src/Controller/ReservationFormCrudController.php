<?php

namespace App\Controller;

use App\Entity\ReservationForm;
use App\Form\ReservationFormType;
use App\Repository\CalendarRepository;
use App\Repository\ReservationFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/reservation/form/crud')]
class ReservationFormCrudController extends AbstractController
{
    #[Route('/', name: 'app_reservation_form_crud_index', methods: ['GET'])]
    public function index(ReservationFormRepository $reservationFormRepository): Response
    {
        return $this->render('reservation_form_crud/index.html.twig', [
            'reservation_forms' => $reservationFormRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_form_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,CalendarRepository $calendarRepo): Response
    {
        $reservationForm = new ReservationForm();
        $form = $this->createForm(ReservationFormType::class, $reservationForm);
        $form->handleRequest($request);
    
        $eventId = $request->query->get('eventId');
        if ($eventId) {
            $calendar = $calendarRepo->find($eventId);
            if ($calendar) {
                $reservationForm->setCalendar($calendar);
            } else {
                $this->addFlash('error', 'Calendrier non trouvé.');
                return $this->redirectToRoute('app_event_planning');
            }
        }
    
        if ($form->isSubmitted() && $form->isValid()) {
            $calendar = $reservationForm->getCalendar();
            if ($calendar) {
                $reservations = $reservationForm->getReservation();
                $places = $calendar->getPlaces();
    
                if ($places >= $reservations) {
                    $calendar->setPlaces($places - $reservations);
    
                    $entityManager->persist($reservationForm);
                    $entityManager->persist($calendar);
                    $entityManager->flush();
    
                    $this->addFlash('success', 'Votre réservation a été enregistrée avec succès.');
                    return $this->redirectToRoute('app_event_planning');
                } else {
                    $this->addFlash('error', 'Il n’y a pas assez de places disponibles pour cette réservation.');
                }
            } else {
                $this->addFlash('error', 'Calendrier non associé.');
            }
        }
    
        return $this->render('reservation_form_crud/new.html.twig', [
            'reservation_form' => $reservationForm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_form_crud_show', methods: ['GET'])]
    public function show(ReservationForm $reservationForm): Response
    {
        return $this->render('reservation_form_crud/show.html.twig', [
            'reservation_form' => $reservationForm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_form_crud_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservationForm $reservationForm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationFormType::class, $reservationForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_form_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation_form_crud/edit.html.twig', [
            'reservation_form' => $reservationForm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_form_crud_delete', methods: ['POST'])]
    public function delete(Request $request, ReservationForm $reservationForm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservationForm->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($reservationForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_form_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
