<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use App\Service\BookingMailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/booking')]
class AdminBookingController extends AbstractController
{
    #[Route('/', name: 'admin_booking_index')]
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_booking_edit')]
    public function edit(
        Booking $booking,
        Request $request,
        EntityManagerInterface $em,
        BookingMailer $bookingMailer // ✅ Injection du service mailer
    ): Response {
        $form = $this->createForm(BookingType::class, $booking, [
            'is_admin' => true,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            // Envoi de l’email via le service
//            $bookingMailer->sendStatusUpdate($booking);

            $this->addFlash('success', 'Réservation mise à jour avec succès et email envoyé.');
            return $this->redirectToRoute('admin_booking_index');
        }

        return $this->render('booking/form.html.twig', [
            'form' => $form->createView(),
            'booking' => $booking,
            'is_edit' => true,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_booking_delete', methods: ['POST'])]
    public function delete(Booking $booking, Request $request, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete-booking-' . $booking->getId(), $request->request->get('_token'))) {
            $em->remove($booking);
            $em->flush();
            $this->addFlash('success', 'Réservation supprimée avec succès.');
        }

        return $this->redirectToRoute('admin_booking_index');
    }
 }
