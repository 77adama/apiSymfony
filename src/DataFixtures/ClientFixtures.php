<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ClientFixtures extends Fixture
{
   private $password;
    public function __Construct(UserPasswordHasherInterface  $password){
$this->password=$password;
    }
    public function load(ObjectManager $manager): void
    {

        $client = new Client();
        $client-> setPrenom("Modou");
        $client->setNom("Fall");
        $client->setRoles(["ROLE_CLIENT"]);
        $client->setEmail("modou@gmail.com");
        // $client->setPassword("modou");
        $client->setPassword($this->password->hashPassword($client,"modou"));
        $client->setTelephone("77 786 98 54");
        $manager->persist($client);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

        // $manager->flush();
    }
}
