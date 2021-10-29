<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnnonceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $annonces =
        [
            [
                'name'=>''
            ]
        ];
        $annonce = new Annonce();

        // $manager->persist($product);

        $manager->flush();
    }
}
