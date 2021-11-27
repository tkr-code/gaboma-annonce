<?php

namespace App\DataFixtures;

use App\Entity\Credit;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CreditFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i < 100; $i++) { 
            $credit =  new Credit();
            $codes = number_format(rand(100, 900).substr(time(),4,10),0,'','-').'-5'.rand(10,90);
            $credit->setCode($codes);
            $credit->setMontant(500)
            ->setQuantite(3)
            ->setIsUse(false);
            $manager->persist($credit);
        }
        $manager->flush();
    }
}
