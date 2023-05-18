<?php

namespace App\DataFixtures;

use App\Entity\Personnes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonnesFixtures extends Fixture
{
        public const TABLE1 = 'table1';
        public const TABLE2 = 'table2';
        public const TABLE3 = 'table3';
    //
    public function load(ObjectManager $manager): void
    {
        $table = new Personnes();
        $table->setPersonnes(1);
        // $table->setCount(10);
        // $this->addReference(self::TABLE1, $table);
        $manager->persist($table);

        $table = new Personnes();
        $table->setPersonnes(2);
        $table->setCount(10);
        $this->addReference(self::TABLE1, $table);
        $manager->persist($table);

        $table = new Personnes();
        $table->setPersonnes(3);
        // $table->setCount(7);
        // $this->addReference(self::TABLE2, $table);
        $manager->persist($table);

        $table = new Personnes();
        $table->setPersonnes(4);
        $table->setCount(7);
        $this->addReference(self::TABLE2, $table);
        $manager->persist($table);

        $table = new Personnes();
        $table->setPersonnes(5);
        // $table->setCount(2);
        // $this->addReference(self::TABLE3, $table);
        $manager->persist($table);

        $table = new Personnes();
        $table->setPersonnes(6);
        $table->setCount(2);
        $this->addReference(self::TABLE3, $table);
        $manager->persist($table);

        $manager->flush();
    }
}
