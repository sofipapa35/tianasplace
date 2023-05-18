<?php

namespace App\DataFixtures;

use App\Entity\Jour;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class JourFixtures extends Fixture
{
    public const JOUR1 = 'jour1';
    public const JOUR2 = 'jour2';
    public const JOUR3 = 'jour3';

    public function load(ObjectManager $manager): void
    {
        $day = new Jour();
        $day->setJour(new DateTime("2022-05-05"));
        $this->addReference(self::JOUR1, $day);
        $manager->persist($day);

        $day = new Jour();
        $day->setJour(new DateTime("2022-05-06"));
        $this->addReference(self::JOUR2, $day);
        $manager->persist($day);

        $day = new Jour();
        $day->setJour(new DateTime("2022-05-07"));
        $this->addReference(self::JOUR3, $day);
        $manager->persist($day);

        $manager->flush();
    }
}
