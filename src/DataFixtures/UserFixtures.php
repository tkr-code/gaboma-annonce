<?php

namespace App\DataFixtures;

use App\Entity\Personne;
use App\Entity\Phone;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private $em;
    private $passwordEncoder;
    public function __construct(EntityManagerInterface $entityManagerInterface, UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->em = $entityManagerInterface;
        $this->passwordEncoder = $userPasswordHasherInterface;
    }
    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'first_name' => 'Malick', 'last_name' => 'Tounkara', 'email' => 'admin@mail.com',
                'roles' => ["ROLE_ADMIN"],'compte'=>User::COMPTE_PROFESSIONNEL,'phone'=>'781278288','whatsapp'=>true
            ],
            [
                'first_name' => 'Mamadou', 'last_name' => 'Dieme', 'email' => 'editor@mail.com',
                'roles' => ["ROLE_EDITOR"],'compte'=>User::COMPTE_PROFESSIONNEL,'phone'=>'781278288','whatsapp'=>true
            ],
            [
                'first_name' => 'Pepin', 'last_name' => 'Ngoulou', 'email' => 'user@mail.com',
                'roles' => ["ROLE_USER"],'compte'=>User::COMPTE_PARTICULIER,'phone'=>'781278288','whatsapp'=>true
            ],
            [
                'first_name' => 'Pepin', 'last_name' => 'Ngoulou', 'email' => 'user1@mail.com',
                'roles' => ["ROLE_USER"],'compte'=>User::COMPTE_PARTICULIER,'phone'=>'781278288','whatsapp'=>false
            ],
        ];
        foreach ($users as $value) {
            $user = new User();
            $phone = new Phone();
            $phone->setNumber('781278288')->setIsWhatsapp(true);
            $personne = new Personne();
            $personne->setFirstName($value['first_name'])
                ->setLastName($value['last_name']);
            $user->setEmail($value['email']);
            $user->setIsVerified(true);
            $user->setAdresse('Dakar sacre coeur 2');
            $user->addPhone($phone);
            $user->setPassword($this->passwordEncoder->hashPassword($user, 'password'))
                ->setRoles($value['roles'])
                ->setCompte($value['compte'])
                ->setCredit(10)
                ->setPersonne($personne);
            $this->addReference('user_' . $value['email'], $user);
            $this->em->persist($user);
        }
        $this->em->flush();
    }
}
