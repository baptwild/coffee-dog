<?php

namespace App\DataFixtures;

use App\Entity\Dog;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class DogFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $dogIndex = 0;
        // $users = $manager->getRepository(className: User::class)->findAll();
        for ($i = 0; $i < 10; $i++) {
            $user = $this->getReference('user_' . $i, User::class);

        
            for ($j = 0; $j < 2; $j++) {
                $dog = new Dog();
                $dog->setName($faker->firstName);
                $dog->setAge(mt_rand(1, 12));
                $dog->setBreed($faker->word);
                $dog->setSize($faker->randomElement(['petit', 'moyen', 'grand']));
                $dog->setNotes($faker->sentence);
                $dog->setOwner($user);
                $dog->setCreatedAt(new \DateTime());
                $dog->setUpdatedAt(new \DateTime());


                $manager->persist($dog);

                $this->addReference('dog_' . $dogIndex, $dog);
                $dogIndex++;
            }
        }

        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }
}

