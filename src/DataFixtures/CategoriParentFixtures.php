<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryParent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriParentFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $categories =
        [
            'Multimédiats',
            'Informatiques',
            'Immobilier',
            'Maisons',
            'Vetements',
            'Smartphones',
            'Automobiles',
        ];
        foreach($categories as $key=> $v){
            $categorie = new CategoryParent();
            $categorie->setName($v);
            $manager->persist($categorie);
            $this->addReference('parent_'.$v,$categorie);
        }
        $manager->flush();
    }
}
