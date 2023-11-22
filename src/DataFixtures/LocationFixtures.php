<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Location;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LocationFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    public function __construct(){
        $this->faker = Factory::create("fr_FR");
    }
    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i<10;$i++){
            $dateDebut = $this->faker->dateTime(); // date début de location
            $location = new Location();
            $location->setDateDebut($dateDebut);

            // On crée une date de fin de location avec la date de début + 8 ans
            $location->setDateFin($this->faker->dateTimeThisDecade($dateDebut = '+8 years')); 
            $location->setBijou($this->getReference('bijou'.mt_rand(0,9)));
            $location->setClient($this->getReference('client'.mt_rand(0,9)));
            $manager->persist($location);
        }
        $manager->flush();
    }
        public function getDependencies(){
            return [ClientFixtures::class,BijouFixtures::class];
   
    }
}
