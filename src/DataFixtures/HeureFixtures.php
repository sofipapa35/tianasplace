<?php

namespace App\DataFixtures;

use App\Entity\Heure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class HeureFixtures extends Fixture
{
        public const CRENAU1 = 'time1';
        public const CRENAU2 = 'time2';
        public const CRENAU3 = 'time3';

    public function load(ObjectManager $manager): void
    {
        $time = new Heure();
        $time->setHeure("18h - 20h");
        $manager->persist($time);
        $this->addReference(self::CRENAU1, $time);

        $time = new Heure();
        $time->setHeure("20h - 22h");
        $manager->persist($time);
        $this->addReference(self::CRENAU2, $time);

        $time = new Heure();
        $time->setHeure("22h - 24h");
        $manager->persist($time);
        $this->addReference(self::CRENAU3, $time);

        $manager->flush();
    }
}
