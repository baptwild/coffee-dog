<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


#[Route(path: '/admin', name: 'app_admin_')]
final class AdminController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function adminIndex(): Response
    {
        return $this->render('admin/form.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(): Response
    {
        // Logic for creating a new admin resource can be added here
        return $this->render('admin/form.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
