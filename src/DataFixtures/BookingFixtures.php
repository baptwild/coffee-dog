<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\User;
use App\Entity\Dog;
use App\Entity\Rate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class BookingFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 20; $i++) {
            $booking = new Booking();

        // $users = $manager->getRepository(User::class)->findAll();
        // $dogs = $manager->getRepository(Dog::class)->findAll();
        // $rates = $manager->getRepository(Rate::class)->findAll();
            $user = $this->getReference('user_' . $faker->numberBetween(0, 9), User::class);
            $dog = $this->getReference('dog_' . $faker->numberBetween(0, 19), Dog::class);
            $rate = $this->getReference('rate_' . $faker->numberBetween(0, 4), Rate::class);

        // for ($i = 0; $i < 20; $i++) {
        //     $booking = new Booking();
        //     $user = $faker->randomElement($users);
        //     $dog = $faker->randomElement($dogs);
        //     $rate = $faker->randomElement($rates);

            $arrival = $faker->dateTimeBetween('-1 month', '+1 month');
            $departure = (clone $arrival)->modify('+'.mt_rand(1, 10).' days');

            $booking->setUser($user);
            $booking->setDog($dog);
            $booking->setRate($rate);
            $booking->setArrivalDatetime($arrival);
            $booking->setDepartureDatetime($departure);
            $booking->setStatus($faker->randomElement(['en_attente', 'confirmé', 'annulé']));
            // $booking->setTotalCost(mt_rand(50, 500));
            $booking->setCreatedAt(new \DateTime());
            $booking->setUpdatedAt(new \DateTime());

            $manager->persist($booking);
        
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            DogFixtures::class,
            RateFixtures::class,
        ];
    }
}
