<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    // ====================================================== //
    // ===================== PROPRIETES ===================== //
    // ====================================================== //
    private $encoder;
    //
     public const USER1 = "user1";
     public const USER2 = "user2";
     public const USER3 = "user3";
     public const USER4 = "user4";
    //
    // ====================================================== //
    // ==================== CONSTRUCTEUR ==================== //
    // ====================================================== //
    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->encoder = $userPasswordHasherInterface;
    }
    // ====================================================== //
    // ====================== METHODES ====================== //
    // ====================================================== //

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setFirstname('Tiana');
        $user->setName('of Maldonia');
        $user->setTelephone('0764563215');
        $user->setEmail('tiana@gmail.com');
        $password = $this->encoder->hashPassword($user, "soleil");
        $user->setPassword($password);
        $user->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $user->setIsVerified(true);
        $this->addReference(self::USER1, $user);
        $manager->persist($user);
        
        $user = new User();
        $user->setFirstname('Sofia');
        $user->setName('Papadopoulou');
        $user->setTelephone('0764215155');
        $user->setEmail('sofipapa@gmail.com');
        $password = $this->encoder->hashPassword($user, "soleil");
        $user->setPassword($password);
        $user->setAddress('36, rue de soleil');
        $user->setZip('77700');
        $user->setVille('Chessy');
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(true);
        $this->addReference(self::USER2, $user);
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Jean');
        $user->setName('Jean');
        $user->setTelephone('0764856321');
        $user->setEmail('jean@gmail.com');
        $password = $this->encoder->hashPassword($user, "soleil");
        $user->setPassword($password);
        $user->setAddress('12, rue de soleil');
        $user->setZip('77700');
        $user->setVille('Chessy');
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(true);
        $this->addReference(self::USER3, $user);
        $manager->persist($user);

        $user = new User();
        $user->setFirstname('Jean');
        $user->setName('Test');
        $user->setTelephone('0764856321');
        $user->setEmail('jean@test.com');
        $password = $this->encoder->hashPassword($user, "soleil");
        $user->setPassword($password);
        $user->setAddress('2, rue de soleil');
        $user->setZip('77700');
        $user->setVille('Chessy');
        $user->setRoles(['ROLE_USER']);
        $user->setIsVerified(true);
        $this->addReference(self::USER4, $user);
        $manager->persist($user);

        $manager->flush();
    }
}
