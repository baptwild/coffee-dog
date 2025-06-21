<?php

namespace App\DataFixtures;


use App\Entity\Notification;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class NotificationFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');
        $users = $manager->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            for ($i = 0; $i < 3; $i++) {
                $notification = new Notification();
                $notification->setUser($user);
                $notification->setMessage($faker->realText(50));
                $notification->setType($faker->randomElement(['confirmation', 'rappel', 'annulation', 'autre']));
                // $date = $faker->dateTimeThisYear();
                // $notification->setSentAt(\DateTimeImmutable::createFromMutable($date));
                $notification->setSentAt(\DateTimeImmutable::createFromMutable($faker->dateTimeThisYear()));
                $notification->setIsRead($faker->boolean());


                $manager->persist($notification);
            }
        }

        $manager->flush();
    }
}
