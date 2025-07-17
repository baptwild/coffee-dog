<?php

namespace App\Controller;

use App\Form\UserProfileFormType;
use App\Repository\BookingRepository;
use App\Repository\DogRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/profile', name: 'profile')]
class ProfileController extends AbstractController
{
    #[Route('', name: '_dashboard')]
    public function profile(
        Request $request,
        EntityManagerInterface $em,
        DogRepository $dogRepository,
        BookingRepository $bookingRepository
    ): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à votre profil.');
            return $this->redirectToRoute('app_login');
        }

        $dogs = $dogRepository->findOneBy(['owner' => $user]);

        $startOfMonth = (new \DateTime())->modify('first day of this month');
        $endOfMonth = (new \DateTime())->modify('last day of this month');

        $bookings = $bookingRepository->createQueryBuilder('b')
            ->where('b.user = :user')
            ->andWhere('b.effectiveDate BETWEEN :start AND :end')
            ->setParameter('user', $user)
            ->setParameter('start', $startOfMonth)
            ->setParameter('end', $endOfMonth)
            ->getQuery()
            ->getResult();

        $totalCost = array_reduce($bookings, function ($carry, $booking) {
            $rate = $booking->getRate()?->getRate();
            return $carry + ($rate ? (float)$rate : 0);
        }, 0);

        $totalBookings = count($bookings);

        return $this->render('profile/dashboard.html.twig', [
            'user' => $user,
            'dogs' => $dogs,
            'bookings' => $bookings,
            'totalCost' => $totalCost,
            'totalBookings' => $totalBookings,
        ]);
    }

    #[Route('/infos', name: '_infos')]

    public function infos(
        Request $request,
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('error', 'Vous devez être connecté pour accéder à votre profil.');
            return $this->redirectToRoute('app_login');
        }

        $form = $this->createForm(UserProfileFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUpdatedAt(new \DateTime());
            $em->flush();
            $this->addFlash('success', 'Profil mis à jour');
            return $this->redirectToRoute('profile_infos');
        }

        return $this->render('profile/form.html.twig', [
            'form' => $form,
        ]);
    }
}
