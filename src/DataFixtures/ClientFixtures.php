<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Client;

class ClientFixtures extends Fixture
{
    private $faker;
    public function __construct(){
        $this->faker = Factory::create("fr_FR");
      }
    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i<10;$i++){
            $client = new Client();
            $client->setNom($this->faker->lastName());
            $client->setPrenom($this->faker->firstName());
            $client->setRue($this->faker->streetname());
            $client->setCp((string)$this->faker->postcode());
            $client->setVille($this->faker->city());
            $client->setEmail($this->faker->email());
            $client->setTelFixe($this->faker->unique()->e164phoneNumber()); // random tel +33
            $client->setTelPortable($this->faker->unique()->e164phoneNumber()); // random tel +33
            $this->addReference('client'.$i,$client);
            $manager->persist($client);
        }
        $manager->flush();
    }
}
