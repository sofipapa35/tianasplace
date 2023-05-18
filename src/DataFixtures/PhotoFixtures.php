<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $photo = new Photo();
        $photo->setImageName('imageT1.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_1));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT2.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_1));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT3.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_2));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT4.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_1));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT5.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_3));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT6.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_5));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT7.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_2));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT8.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_6));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT9.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_4));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT10.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_4));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT11.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_2));
        $manager->persist($photo);

        $photo = new Photo();
        $photo->setImageName('imageT12.jpg');
        $photo->setUpdatedAt(new DateTimeImmutable());
        $photo-> setTimeline($this->getReference(TimelineFixtures::ACTU_7));
        $manager->persist($photo);

        $manager->flush();
    }
    public function getDependencies(){
        return [
            TimelineFixtures::class,
        ];
    }
}
