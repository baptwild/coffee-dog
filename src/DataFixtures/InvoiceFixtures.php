<?php

namespace App\DataFixtures;

use App\Entity\Invoice;
use App\Entity\User;
use App\Entity\Booking;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class InvoiceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        // Assuming you have 10 users from UserFixtures (adjust count accordingly)
        for ($i = 0; $i < 10; $i++) {
            /** @var User $user */
            $user = $this->getReference('user_' . $i, User::class);


            $invoice = new Invoice();
            $invoice->setUser($user);
            $invoice->setMonth($faker->dateTimeBetween('-3 months', 'now'));
            $invoice->setTotalAmount($faker->randomFloat(2, 100, 2000));
            $invoice->setIsPaid($faker->boolean(70)); // 70% chance paid
            $invoice->setGeneratedAt(new \DateTime());
            $invoice->setInvoiceNumber('INV-' . strtoupper($faker->bothify('2025###??')));
            $invoice->setNotes($faker->optional()->sentence());

            // Optionally associate some bookings to this invoice:
            // Example: assign 0-3 random bookings of this user to the invoice
            $bookingCount = $faker->numberBetween(0, 3);
            for ($j = 0; $j < $bookingCount; $j++) {
                // Make sure booking references are set by your BookingFixtures (adjust accordingly)
                 /** @var Booking $booking */
                $booking = $this->getReference('booking_' . $faker->numberBetween(0, 19),  Booking::class); 
                if ($booking->getUser()->getId() === $user->getId()) {
                    $invoice->addBooking($booking);
                }
            }

            $manager->persist($invoice);

            // Store reference if needed later
            $this->addReference('invoice_' . $i, $invoice);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            BookingFixtures::class,
        ];
    }
}
