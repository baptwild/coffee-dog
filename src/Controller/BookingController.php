<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/booking', name: 'app_booking_')]

final class BookingController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('booking/index.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManager $entityManager): Response
    {
        $booking = new Booking();

        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

        }
        return $this->render('booking/new.html.twig', [
            'controller_name' => 'BookingController',
        ]);
    }
}
