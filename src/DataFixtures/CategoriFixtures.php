<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\CategoryParent;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoriFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $categories =
        [
            'Ordinateur',
            'Chargeur PC',
            'Clé Usb',
            'Cable HDMI',
            'Ecran',
            'Claviers',
            'Souris'
        ];
        foreach($categories as $key =>  $v){
            $categorie = new Category();
                $categorie->setName($v);
                $categorie->setParent($this->getReference('parent_Informatiques'))
                ->setIsActive(true);
                $manager->persist($categorie);
                $this->addReference('categorie_'.$key,$categorie);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CategoriParentFixtures::class,
        ];
    }
}
