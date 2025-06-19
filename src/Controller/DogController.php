<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\DogType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dog', name: 'app_dog_')]
final class DogController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('dog/index.html.twig', [
            'controller_name' => 'DogController',
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dog = new Dog();

        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dog->setOwner($this->getUser());
            $dog->setCreatedAt(new \DateTime());
            $dog->setUpdatedAt(new \DateTime());

            $entityManager->persist($dog);
            $entityManager->flush();

            $this->addFlash('success', 'Chien ajouté avec succès !');
            return $this->redirectToRoute('app_dog_index');
        }

        return $this->render('dog/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $entityManager, Dog $dog): Response
    {
        if (!$dog || $dog->getOwner() !== $this->getUser()) {
            throw $this->createNotFoundException('Chien non trouvé ou accès non autorisé.');
        }

        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dog->setUpdatedAt(new \DateTime());

            $entityManager->flush();

            $this->addFlash('success', 'Chien modifié avec succès !');
            return $this->redirectToRoute('app_dog_index');
        }

        return $this->render('dog/edit.html.twig', [
            'form' => $form->createView(),
            'dog' => $dog,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Request $request, EntityManagerInterface $entityManager, Dog $dog): Response
    {
        if (!$dog || $dog->getOwner() !== $this->getUser()) {
            throw $this->createNotFoundException('Chien non trouvé ou accès non autorisé.');
        }

        if ($request->isMethod('POST')) {
            $entityManager->remove($dog);
            $entityManager->flush();

            $this->addFlash('success', 'Chien supprimé avec succès !');
            return $this->redirectToRoute('app_dog_index');
        }

        return $this->render('dog/delete.html.twig', [
            'dog' => $dog,
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Dog $dog): Response
    {
        if (!$dog || $dog->getOwner() !== $this->getUser()) {
            throw $this->createNotFoundException('Chien non trouvé ou accès non autorisé.');
        }

        return $this->render('dog/show.html.twig', [
            'dog' => $dog,
        ]);
    }
}
