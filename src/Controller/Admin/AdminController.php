<?php

namespace App\Controller\Admin;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('', name: 'admin_dashboard')]
    public function index(BookingRepository $bookingRepository): Response
    {
        $today = new \DateTimeImmutable();

        $bookingsToday = $bookingRepository->findBookingsForDate($today);
        $dogsPresent = array_filter($bookingsToday, fn($b) => $b->isActive());

        return $this->render('admin/index.html.twig', [
            'bookingsToday' => $bookingsToday,
            'dogsPresent' => $dogsPresent,
        ]);
    }
}
