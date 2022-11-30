<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;
use Symfony\Component\DependencyInjection\Reference;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        /**
        * L'objet $faker que tu récupères est l'outil qui va te permettre 
        * de te générer toutes les données que tu souhaites
        */
        for($i = 1; $i <= 10; $i++) {
            $season = new Season();
            //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
            $season->setNumber($faker->numberBetween(1, 10));
            $season->setYear($faker->year());
            $season->setDescription($faker->paragraphs(3, true));
            $season->setProgramId($this->getReference('program_' . $faker->numberBetween(1, 10)));
            $this->addReference('season_' . $i, $season);
            
            $manager->persist($season);

        }
        $manager->flush();

    }

    public function getDependencies(): array
    {
        return [
           ProgramFixtures::class,
        ];
    }
}
