<?php

namespace App\DataFixtures;

use App\Entity\Carousel;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarouselFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $carousel = new Carousel();
        $carousel -> setImageName('image2.webp');
        $carousel -> setUpdatedAt(new DateTimeImmutable());
        $manager->persist($carousel);        
        
        $carousel = new Carousel();
        $carousel -> setImageName('image4.webp');
        $carousel -> setUpdatedAt(new DateTimeImmutable());
        $manager->persist($carousel);

        $carousel = new Carousel();
        $carousel -> setImageName('image5.webp');
        $carousel -> setUpdatedAt(new DateTimeImmutable());
        $manager->persist($carousel);

        $carousel = new Carousel();
        $carousel -> setImageName('image6.webp');
        $carousel -> setUpdatedAt(new DateTimeImmutable());
        $manager->persist($carousel);

        $carousel = new Carousel();
        $carousel -> setImageName('image3.webp');
        $carousel -> setUpdatedAt(new DateTimeImmutable());
        $manager->persist($carousel);

        $manager->flush();
    }
}
