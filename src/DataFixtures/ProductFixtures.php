<?php

namespace App\DataFixtures;

use DateTimeImmutable;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setTitle('Bananas Foster');
        $product->setDescription('Une banane coupée en deux et glace à la vanille, avec une sauce à base de beurre, de cassonade, de cannelle, de rhum noir et de liqueur de banane.');
        $product->setImageName('BANANAS FOSTER1.jpg');
        $product->setUpdatedAt(new DateTimeImmutable());
        $product->setPrice(15);
        $product->setAddCart(true);
        $product->setActive(true);
        $product->setSold(5);
        $manager->persist($product);
        $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_DESSERT));

        $product = new Product();
        $product->setTitle('Beignets');
        $product->setDescription('Avec du sucre glace');
        $product->setImageName('BEIGNETS1.jpg');
        $product->setUpdatedAt(new DateTimeImmutable());
        $product->setPrice(12);
        $product->setAddCart(true);
        $product->setActive(true);
        $product->setSold(15);
        $manager->persist($product);
        $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_DESSERT));

        $product = new Product();
        $product->setTitle('King cake');
        $product->setDescription('Un anneau de pâte torsadée à la cannelle et au sucre coloré');
        $product->setImageName('NEW ORLEANS KING CAKES1.jpg');
        $product->setUpdatedAt(new DateTimeImmutable());
        $product->setPrice(15);
        $product->setAddCart(true);
        $product->setActive(true);
        $product->setSold(14);
        $manager->persist($product);
        $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_DESSERT));

        $product = new Product();
        $product->setTitle('Oysters');
        $product->setDescription('Servies par la douzaine empilée haut sur la glace concassée');
        $product->setImageName('OYSTERS1.jpg');
        $product->setUpdatedAt(new DateTimeImmutable());
        $product->setPrice(25);
        $product->setAddCart(true);
        $product->setActive(true);
        $product->setSold(0);
        $manager->persist($product);
        $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_PLAT));

        $product = new Product();
        $product->setTitle('Po-Boys');
        $product->setDescription('Pain français de la Nouvelle-Orléans, choix de garniture : crevettes frites, huîtres, poisson-chat, crabe à carapace molle ou rôti de bœuf, Pickles, Sauce piquante, Laitue, Tomate, Mayo, Ketchup, servie avec frites');
        $product->setImageName('PO-BOYS1.jpg');
        $product->setUpdatedAt(new DateTimeImmutable());
        $product->setPrice(24);
        $product->setAddCart(true);
        $product->setActive(true);
        $product->setSold(6);
        $manager->persist($product);
        $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_PLAT));

        $product = new Product();
        $product->setTitle('Eggs Sardou');
        $product->setDescription('Œufs pochés avec fond d’artichaut, épinards en crème et sauce hollandaise, parfois avec d’autres ingrédients comme des anchois ou du jambon haché');
        $product->setImageName('Eggs-Sardou.jpg');
        $product->setUpdatedAt(new DateTimeImmutable());
        $product->setPrice(24);
        $product->setAddCart(true);
        $product->setActive(true);
        $product->setSold(3);
        $manager->persist($product);
        $product->setCategory($this->getReference(CategoryFixtures::CATEGORY_APERITIF));

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoryFixtures::class,
        ];
    }
}
