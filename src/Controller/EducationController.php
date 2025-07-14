<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EducationController extends AbstractController
{
   #[Route('/education-canine', name: 'education')]
   public function index(): Response
   {
      return $this->render('pages/education/form.html.twig', [
         'controller_name' => 'EducationController',
      ]);
   }
}
