<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as Faker;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker::create();
        for ($i=0; $i < 100 ; $i++) { 
            $annonce = new Annonce();
            $annonce->setTitle($faker->sentence(3,true))
            ->setPrice(rand(1000,500000))
            ->setIsActive(true)
            ->setContent($faker->sentence(5,true))
            ->setCategory($this->getReference('categorie_'.rand(0,6)))
            ->setUser($this->getReference('user_admin@mail.com'));
            $manager->persist($annonce);
        }

        $manager->flush();
    }
    public function getDependencies()
    {
        return [
            CategoriFixtures::class,
            UserFixtures::class
        ];
    }
}
