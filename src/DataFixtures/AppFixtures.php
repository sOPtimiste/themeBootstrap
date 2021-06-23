<?php

namespace App\DataFixtures;

use App\Entity\Announce;
use App\Entity\Comment;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Cocur\Slugify\Slugify;
use Doctrine\Common\Collections\ArrayCollection;
Use Faker\Factory;

class AppFixtures extends Fixture
{
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create("fr_FR");
        // $product = new Product();
        // $manager->persist($product);
        $slugger = new Slugify();
        for($i = 1; $i < 6; $i++)
        {
            $announce = new Announce();
            $announce->setTitle($faker->sentence(3,false));
            //$announce->setSlug($slugger->slugify($announce->getTitle()));
            $announce->setDescription($faker->text(200));
            $announce->setPrice(mt_rand(30000,60000));
            $announce->setAddress($faker->address());
            $announce->setCoverImage("https://via.placeholder.com/500x300");
            $announce->setRooms(mt_rand(0,5));
            $announce->setIsAvailable(mt_rand(0,1));
            $announce->setCreatedAt($faker->dateTimeBetween('-3 month','now'));

            for($j = 0; $j < mt_rand(0,7); $j++){
                $comment = new Comment();
                $comment->setAuthor($faker->name());
                $comment->setEmail($faker->email());
                $comment->setContent($faker->text(200));
                $comment->setCreatedAt($faker->dateTimeBetween('-3 month','now'));
    
                $manager->persist($comment);

                $announce->addComment($comment);
            }

            for($k = 0; $k < mt_rand(0,7); $k++){
                $image = new Image();
                $image->setImageUrl($faker->image());
                $image->setDescription($faker->sentence());
                
    
                $manager->persist($image);

                $announce->addImage($image);
            }

            
    
    
            $manager->persist($announce);
        }
        

        $manager->flush();
        
    }
}
