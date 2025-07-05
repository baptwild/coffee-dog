<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Repository\UserRepository;

class RegistrationControllerTest extends WebTestCase
{
    public function testUserRegistration()
    {
        $client = static::createClient();

        // Accéder à la page d'inscription
        $crawler = $client->request('GET', '/register');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Inscription');

        // Remplir le formulaire d'inscription
        $form = $crawler->selectButton('Continuer')->form([
            'user_init_registration_form[firstName]' => 'John',
            'user_init_registration_form[lastName]' => 'Doe',
            'user_init_registration_form[email]' => 'john.doe@example.com',
            'user_init_registration_form[password][first]' => 'password123',
            'user_init_registration_form[password][second]' => 'password123',
        ]);

        // Soumettre le formulaire
        $client->submit($form);

        // Vérifier la redirection (par exemple vers une page de confirmation)
        $this->assertResponseRedirects();

        // Suivre la redirection
        $client->followRedirect();
    }
}
