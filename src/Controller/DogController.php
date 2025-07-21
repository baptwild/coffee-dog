<?php

namespace App\Controller;

use App\Entity\Dog;
use App\Form\DogType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/dog', name: 'app_dog_')]
final class DogController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $dogs = $entityManager->getRepository(Dog::class)->findBy(['owner' => $this->getUser()]);

        return $this->render('dog/index.html.twig', [
            'dogs' => $dogs,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $dog = new Dog();
        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dog->setOwner($this->getUser());
            $dog->setCreatedAt(new \DateTime());
            $dog->setUpdatedAt(new \DateTime());

            $photoFile = $form->get('photo')->getData();
            if ($photoFile instanceof UploadedFile) {
                $filename = $this->uploadDogImage($photoFile, $slugger);
                $dog->setPhoto($filename);
            }

            $em->persist($dog);
            $em->flush();

            $this->addFlash('success', 'Votre chien a bien été ajouté avec succès !');
            return $this->redirectToRoute('app_dog_index');
        }

        return $this->render('dog/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(Request $request, EntityManagerInterface $em, Dog $dog, SluggerInterface $slugger): Response
    {
        if ($dog->getOwner() !== $this->getUser()) {
            throw $this->createNotFoundException('Chien non trouvé ou accès non autorisé.');
        }

        $form = $this->createForm(DogType::class, $dog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dog->setUpdatedAt(new \DateTime());

            $photoFile = $form->get('photo')->getData();
            if ($photoFile instanceof UploadedFile) {
                $filename = $this->uploadDogImage($photoFile, $slugger);
                $dog->setPhoto($filename);
            }

            $em->flush();

            $this->addFlash('success', 'Les informations de votre chien ont bien été modifiées avec succès !');
            return $this->redirectToRoute('app_dog_index');
        }

        return $this->render('dog/form.html.twig', [
            'form' => $form->createView(),
            'dog' => $dog,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(Request $request, EntityManagerInterface $em, Dog $dog): Response
    {
        if ($dog->getOwner() !== $this->getUser()) {
            throw $this->createNotFoundException('Chien non trouvé ou accès non autorisé.');
        }

        if ($request->isMethod('POST')) {
            $em->remove($dog);
            $em->flush();

            $this->addFlash('success', 'Les informations de votre chien ont bien été supprimées avec succès !');
            return $this->redirectToRoute('app_dog_index');
        }

        return $this->render('dog/delete.html.twig', [
            'dog' => $dog,
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(Dog $dog): Response
    {
        if ($dog->getOwner() !== $this->getUser()) {
            throw $this->createNotFoundException('Chien non trouvé ou accès non autorisé.');
        }

        return $this->render('dog/show.html.twig', [
            'dog' => $dog,
        ]);
    }

    private function uploadDogImage(UploadedFile $file, SluggerInterface $slugger): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($this->getParameter('dogs_images_directory'), $newFilename);

        return $newFilename;
    }
}
