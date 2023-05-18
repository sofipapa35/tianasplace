<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

// ====================================================== //
// ===================== PROPRIETES ===================== //
// ====================================================== //
public const CATEGORY_APERITIF = "category_aperitif";
public const CATEGORY_PLAT = "category_plat";
public const CATEGORY_DESSERT = "category_dessert";
public const CATEGORY_COCTAIL = "category_coctail";
// public const CATEGORY_SANS = "category_sans";

    public function load(ObjectManager $manager): void
    {
        $cat = new Category;
        $cat->setTitle('Apéritifs');
        $manager->persist($cat);
        $this->addReference(self::CATEGORY_APERITIF, $cat);

        $cat = new Category;
        $cat->setTitle('Plats');
        $manager->persist($cat);
        $this->addReference(self::CATEGORY_PLAT, $cat);

        $cat = new Category;
        $cat->setTitle('Desserts');
        $manager->persist($cat);
        $this->addReference(self::CATEGORY_DESSERT, $cat);

        $cat = new Category;
        $cat->setTitle('Cocktails');
        $manager->persist($cat);
        $this->addReference(self::CATEGORY_COCTAIL, $cat);

        // $cat = new Category;
        // $cat->setTitle('Sans alcool');
        // $manager->persist($cat);
        // $this->addReference(self::CATEGORY_SANS, $cat);

        $manager->flush();
    }
}
