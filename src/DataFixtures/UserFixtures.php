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
         $user->setUsername('optimiste');
         $user->setRoles(['ROLE_ADMIN','ROLE_USER']);
         $user->setFirstname('serigne Mbacke');
         $user->setLastname('SALL');
         $user->setPhoneNumber('77453456');
         $user->setStatus(1);

         $user->setPassword($this->passwordHasher->hashPassword(
                        $user,
                       '12345678'
                    ));
         $manager->persist($user);

        $manager->flush();
    }
}
