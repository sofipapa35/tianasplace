<?php

namespace App\DataFixtures;

use App\Entity\Disponibility;
use App\DataFixtures\JourFixtures;
use App\DataFixtures\HeureFixtures;
use App\DataFixtures\PersonnesFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class DisponibilityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo); 

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR1));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);


        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR2));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(10);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE1));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(7);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE2));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU1));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU2));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);

        $dispo = new Disponibility();
        $dispo->setCount(2);
        $dispo->setJour($this->getReference(JourFixtures::JOUR3));
        $dispo->setHeure($this->getReference(HeureFixtures::CRENAU3));
        $dispo->setPersonnes($this->getReference(PersonnesFixtures::TABLE3));
        $manager->persist($dispo);


        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            JourFixtures::class,
            HeureFixtures::class,
            PersonnesFixtures::class
        ];
    }
}
