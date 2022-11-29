<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Faker\Factory;
use App\Entity\Episode;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class EpisodeFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();

        /**
         * L'objet $faker que tu récupères est l'outil qui va te permettre 
         * de te générer toutes les données que tu souhaites
         */

/*         for ($i = 0; $i < 10; $i++) {
            $episode = new Episode();
            //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
            $episode->setTitle($faker->sentence());
            $episode->setSynopsis($faker->sentence(20, true));
            $episode->setNumber($i);

            $episode->setSeasonId($this->getReference('season_' . $faker->numberBetween(1, 10)));
            $manager->persist($episode);
        }

        $manager->flush(); */
    }
}
