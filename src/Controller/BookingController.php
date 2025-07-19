<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/booking', name: 'app_booking_')]
final class BookingController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(BookingRepository $bookingRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour voir vos réservations.');
        }

        $bookings = $this->isGranted('ROLE_ADMIN')
            ? $bookingRepository->findBy([], ['createdAt' => 'DESC']) // Admin : tout
            : $bookingRepository->findBy(['user' => $user], ['createdAt' => 'DESC']); // User : que les siennes


        return $this->render('booking/index.html.twig', [
            'bookings' => $bookings,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        if (count($user->getDogs()) === 0) {
            $this->addFlash('warning', 'Vous devez enregistrer un chien avant de réserver.');
            return $this->redirectToRoute('app_dog_new');
        }

        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $date = $form->get('effectiveDate')->getData();
            $arrivalTime = $form->get('arrivalDatetime')->getData();
            $departureTime = $form->get('departureDatetime')->getData();

            // Fusion date + heure
            $arrival = (new \DateTime())->setTimestamp($date->getTimestamp())->setTime(
                $arrivalTime->format('H'),
                $arrivalTime->format('i')
            );
            $departure = (new \DateTime())->setTimestamp($date->getTimestamp())->setTime(
                $departureTime->format('H'),
                $departureTime->format('i')
            );

            // Règle 1 : Mardi à vendredi (2 à 5)
            if ((int) $date->format('N') < 2 || (int) $date->format('N') > 5) {
                $this->addFlash('danger', 'Les réservations sont possibles uniquement du mardi au vendredi.');
                return $this->redirectToRoute('app_booking_new');
            }

            // Règle 2 & 3 : Heures valides
            $validArrivalHours = range(8, 13); // 8h00 à 13h30
            $validDepartureHours = range(11, 18); // 11h00 à 18h30
            $validMinutes = [0, 30];

            if (
                !in_array((int) $arrivalTime->format('H'), $validArrivalHours) ||
                !in_array((int) $arrivalTime->format('i'), $validMinutes)
            ) {
                $this->addFlash('danger', 'Heure d\'arrivée invalide (08h00 à 13h30, par 30 min).');
                return $this->redirectToRoute('app_booking_new');
            }

            if (
                !in_array((int) $departureTime->format('H'), $validDepartureHours) ||
                !in_array((int) $departureTime->format('i'), $validMinutes)
            ) {
                $this->addFlash('danger', 'Heure de départ invalide (11h00 à 18h30, par 30 min).');
                return $this->redirectToRoute('app_booking_new');
            }

            //  Règle 4 : Arrivée avant départ
            if ($arrival >= $departure) {
                $this->addFlash('danger', 'L\'heure d\'arrivée doit être avant l\'heure de départ.');
                return $this->redirectToRoute('app_booking_new');
            }

            // Règle 5 : Le chien appartient à l'utilisateur connecté
            $dog = $form->get('dog')->getData();
            if ($dog->getOwner() !== $user) {
                $this->addFlash('danger', 'Vous ne pouvez réserver qu\'avec vos propres chiens.');
                return $this->redirectToRoute('app_booking_new');
            }

            //  Tout est OK → on enregistre
            $booking->setCreatedAt(new \DateTimeImmutable());
            $booking->setUpdatedAt(new \DateTimeImmutable());
            $booking->setStatus(Booking::STATUS_EN_ATTENTE);
            $booking->setIsActive(false);
            $booking->setArrivalDatetime($arrival);
            $booking->setDepartureDatetime($departure);
            $booking->setUser($user);

            $entityManager->persist($booking);
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index');
        }

        return $this->render('booking/form.html.twig', [
            'form' => $form->createView(),
            'is_edit' => false,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Request $request, Booking $booking, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$this->isGranted('ROLE_ADMIN') && $booking->getUser() !== $user) {
            throw $this->createAccessDeniedException("Vous ne pouvez modifier que vos propres réservations.");
        }

        $form = $this->createForm(BookingType::class, $booking, [
            'is_admin' => $this->isGranted('ROLE_ADMIN'),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booking->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            return $this->redirectToRoute('app_booking_index');
        }

        return $this->render('booking/form.html.twig', [
            'form' => $form->createView(),
            'is_edit' => true,
        ]);
    }
}
