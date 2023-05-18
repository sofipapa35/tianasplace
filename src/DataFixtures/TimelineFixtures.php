<?php

namespace App\DataFixtures;

use App\Entity\Timeline;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;
use DateTimeImmutable;

class TimelineFixtures extends Fixture
{
    //================================================//
    //=============== Proprietes =====================//
    //================================================//
    public const ACTU_1 = "actu_1";
    public const ACTU_2 = "actu_2";
    public const ACTU_3 = "actu_3";
    public const ACTU_4 = "actu_4";
    public const ACTU_5 = "actu_5";
    public const ACTU_6 = "actu_6";
    public const ACTU_7 = "actu_7";

    //================================================//
    //================= Methodes =====================//
    //================================================//
    public function load(ObjectManager $manager): void
    {
        $time = new Timeline();
        $time->setTitle('Lorem ipsum');
        $time->setDateActu(new DateTime("2022-01-24"));
        $time->setUpdatedAt(new DateTimeImmutable());
        $time -> setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce tristique elementum nulla, quis condimentum metus pulvinar at. Cras sapien nulla, consectetur sit amet nisl vitae.');
        $manager->persist($time);
        $this->addReference(self::ACTU_7, $time);

        $time = new Timeline();
        $time->setTitle('Duis malesuada in sem vel vestibulum');
        $time->setDateActu(new DateTime("2022-01-17"));
        $time->setUpdatedAt(new DateTimeImmutable());
        $time -> setDescription('Duis malesuada in sem vel vestibulum. Donec scelerisque varius placerat. Donec eget semper risus. Quisque hendrerit arcu id enim vestibulum semper. Aenean porttitor eu urna vitae auctor. Curabitur imperdiet dui sit amet orci semper pretium.');
        $manager->persist($time);
        $this->addReference(self::ACTU_6, $time);

        $time = new Timeline();
        $time->setTitle('Quisque non ligula eget ipsum');
        $time->setDateActu(new DateTime("2022-01-16"));
        $time->setUpdatedAt(new DateTimeImmutable());
        $time -> setDescription('Sed lacinia scelerisque nunc eget porta. Quisque non ligula eget ipsum lacinia mollis. Cras sit amet est dolor.');
        $manager->persist($time);
        $this->addReference(self::ACTU_5, $time);

        $time = new Timeline();
        $time->setTitle('Union pour la Solidarité');
        $time->setDateActu(new DateTime("2022-01-09"));
        $time->setUpdatedAt(new DateTimeImmutable());
        $manager->persist($time);
        $this->addReference(self::ACTU_4, $time);

        $time = new Timeline();
        $time->setTitle('Soiree jazz');
        $time->setDateActu(new DateTime("2022-01-08"));
        $time->setUpdatedAt(new DateTimeImmutable());
        $manager->persist($time);
        $this->addReference(self::ACTU_3, $time);

        $time = new Timeline();
        $time->setTitle('Union pour la Solidarité');
        $time->setDateActu(new DateTime("2022-01-02"));
        $time->setUpdatedAt(new DateTimeImmutable());
        $time->setdescription('Union pour la Solidarité vous convie, à partir de 19h à son repas de charité organisé tous les ans.
        L’animation musicale sera assurée par l’orchestre De La Chanson.');
        $manager->persist($time);
        $this->addReference(self::ACTU_2, $time);

        $time = new Timeline();
        $time->setTitle('Réveillon du Nouvel An');
        $time->setDateActu(new DateTime("2021-12-31"));
        $time->setUpdatedAt(new DateTimeImmutable());
        $time->setdescription('Faîtes un croix sur votre calendrier !
        Nous organisons une fête le 31 Décembre à partir de 21 heures !
        Apportez votre appétit et votre soif !
        Nous nous occupons du reste !');
        $manager->persist($time);
        $this->addReference(self::ACTU_1, $time);

        
        $manager->flush();
    }
}
