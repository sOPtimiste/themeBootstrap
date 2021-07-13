<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager)
    {
         $user = new User();
         $user->setEmail('sall@sall.com');
         $user->setUsername('op2');

         $user->setPassword($this->passwordHasher->hashPassword(
                        $user,
                       '12345678'
                    ));
         $manager->persist($user);

        $manager->flush();
    }
}
