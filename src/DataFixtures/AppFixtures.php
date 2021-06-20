<?php

namespace App\DataFixtures;

use App\Entity\Announce;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        //$faker = Faker\Factory::create('fr_FR');
        for($i = 2; $i < 20; $i++)
        {
            $announce = new Announce();
            $announce->setTitle("chambre n°$i");
            $announce->setSlug("chambre-$i");
            $announce->setDescription("je vous loue ma chambre avec une salle de bain tres neuve...");
            $announce->setPrice(mt_rand(30000,60000));
            $announce->setAddress("Medina rue 12");
            $announce->setCoverImage("https://via.placeholder.com/500x300");
            $announce->setRooms(mt_rand(0,5));
            $announce->setIsAvailable(mt_rand(0,1));
            $announce->setCreatedAt(new DateTime());
    
    
            $manager->persist($announce);
        }
        

        $manager->flush();
    }
}
