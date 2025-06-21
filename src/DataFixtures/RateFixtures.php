<?php

namespace App\DataFixtures;

use App\Entity\Rate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RateFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $types = ['Jour', 'Semaine', 'Week-end', 'Vacances', 'Nuit'];

        foreach ($types as $rateIndex => $type) {
            $rate = new Rate();
            $rate->setRate(mt_rand(20, 100));
            $rate->setRateType($type);
            $rate->setIsActive(true);
            $manager->persist($rate);

            $this->addReference('rate_' . $rateIndex, $rate);

        }

        $manager->flush();
    }
}
