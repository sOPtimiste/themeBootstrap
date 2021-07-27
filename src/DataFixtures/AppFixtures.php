<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Comment;
use App\Entity\Announce;
use Cocur\Slugify\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
Use Faker\Factory;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        // $product = new Product();
        // $manager->persist($product);
        //$slugger = new Slugify();
        for($i = 1; $i < 10; $i++)
        {
            $announce = new Announce();
            $announce->setTitle($faker->sentence(3,false));
            $announce->setIntroduction($faker->sentence());
            //$announce->setSlug($slugger->slugify($announce->getTitle()));
            $announce->setDescription($faker->text(300));
            $announce->setPrice(mt_rand(30000,60000));
            $announce->setAddress($faker->address());
            $announce->setCoverImage("2.jpeg");
            $announce->setRooms(mt_rand(1,8));
            $announce->setIsAvailable(mt_rand(0,1));
            $announce->setCreatedAt($faker->dateTimeBetween('-3 month','now'));

            $user = new User();
            $user->setEmail($faker->email());
            $user->setUsername($faker->userName());
            
            $user->setPassword($this->passwordHasher->hashPassword(
                $user,
               '12345678'
            ));
            $user->setRoles(['ROLE_USER']);
            $user->setFirstname($faker->firstName());
            $user->setLastname($faker->lastName());
            $user->setPhoneNumber('772931098');
            $user->setStatus(mt_rand(0,1));

            $announce->setUser($user);

            for($j = 0; $j < mt_rand(0,7); $j++){
                $comment = new Comment();
                $comment->setAuthor($faker->name());
                $comment->setEmail($faker->email());
                $comment->setContent($faker->text(300));
                $comment->setCreatedAt($faker->dateTimeBetween('-3 month','now'));
    
                //$manager->persist($comment);

                $announce->addComment($comment);
            }

            for($k = 0; $k < mt_rand(1,4); $k++){
                $image = new Image();
                $image->setImageUrl("house3.jpg");
                $image->setDescription($faker->sentence());
                
    
                //$manager->persist($image);

                $announce->addImage($image);
            }

            
    
    
            $manager->persist($announce);
        }
        

        $manager->flush();
        
    }
}
