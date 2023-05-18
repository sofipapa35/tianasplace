<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\DataFixtures\UserFixtures;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $comment = new Comment();
        $comment->setTitle('Parfait!');
        $comment->setTexte('Sans aucun doute un des meilleurs burgers de Paris avec un très bon accueil de la part du patron et des serveurs. Signé, les angoumoisins');
        $comment->setCreatedAt(new DateTimeImmutable());
        $comment->setUser($this->getReference(UserFixtures::USER2));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setTitle('Tellement bon que j\'en rêve la nuit');
        $comment->setTexte('Pour notre récré du mercredi avec notre petit fils sur Paris j\'avais repéré sur Tripadvisor ce restaurant près de la Place d\'Italie. L\'accueil est chaleureux, on se sent comme chez des amis.');
        $comment->setCreatedAt(new DateTimeImmutable());
        $comment->setUser($this->getReference(UserFixtures::USER2));
        $manager->persist($comment);

        $comment = new Comment();
        $comment->setTitle('Merci à la team');
        $comment->setTexte('C\'est un resto que l\'on m\'avait recommandé chaudement.
        Je survalide, Bon y vivre, bon y manger, bon y tchatcher!!!');
        $comment->setCreatedAt(new DateTimeImmutable());
        $comment->setUser($this->getReference(UserFixtures::USER2));
        $manager->persist($comment);

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            UserFixtures::class, 
        ];
    }
}
