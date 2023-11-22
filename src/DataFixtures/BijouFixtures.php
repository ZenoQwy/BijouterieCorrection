<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\Bijou;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BijouFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;
    public function __construct(){
        $this->faker = Factory::create("fr_FR");
    }

    public function load(ObjectManager $manager): void
    {
        for ($i=0;$i<30;$i++){
            $bijou = new Bijou();
            $bijou->setDescription($this->faker->text()); // Text random

            // prix random entre 290 et 420 arrondu à deux chiffre apres la virgule
            $bijou->setPrixVente($this->faker->randomFloat(2, 290, 420));

            // prix random entre 90 et 175 arrondu à deux chiffre apres la virgule
            $bijou->setPrixLocation($this->faker->randomFloat(2, 90, 175)); 

            $bijou->setCategorie($this->getReference('categorie'.mt_rand(0,9)));
            $this->addReference('bijou'.$i,$bijou);
            $manager->persist($bijou);
        }
        $manager->flush();
    }

    public function getDependencies(){
        return [CategorieFixtures::class];
    }
}
