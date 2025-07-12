<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PricesController extends AbstractController
{
   #[Route('/tarifs', name: 'prices')]
   public function index(): Response
   {
      return $this->render('pages/prices/form.html.twig', [
         'controller_name' => 'PricesController',
      ]);
   }
}
