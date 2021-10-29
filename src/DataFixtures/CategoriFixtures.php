<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories =
        [
            'Informatique',
            'Immobilier',
            'Meuble',
            'Vetements',
            'Smartphone',
            'Samsung',
            'Iphone',
            'Ordinateur',
            'Automobile',
            'Voiture',
            'Moto',
            'Chausure',
            'Sac',
            'Chemise',
        ];
        foreach($categories as $key=> $v){
            $categorie = new Category();
            $categorie->setName($v)
            ->setIsActive(true);
            $manager->persist($categorie);
            $this->addReference('categorie_'.$key,$categorie);
        }
        $manager->flush();
    }
}
