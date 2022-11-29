<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Category;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        foreach (CategoryFixtures::CATEGORIES as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('category_' . $categoryName, $category);
        }
        $manager->flush();
        /*--------------------------------------*/

        foreach (CategoryFixtures::CATEGORIES as $categoryName) {

            for ($i = 1; $i <= 10; $i++) {
                $program = new Program();
                $program->setTitle($faker->sentence());
                $program->setPoster($faker->sentence());
                $program->setSynopsis($faker->sentence(20, true));
                $program->setCategory($this->getReference('category_' . $categoryName));
                if ($categoryName === 'Action') $this->addReference('program_' . $i, $program);

                $manager->persist($program);
            }
        }
        $manager->flush();


        /*-------------------------------------*/
        for ($i = 1; $i <= 10; $i++) {
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


        /*------------------------------------------------*/
        for ($i = 0; $i < 10; $i++) {
            $episode = new Episode();
            //Ce Faker va nous permettre d'alimenter l'instance de Season que l'on souhaite ajouter en base
            $episode->setTitle($faker->sentence());
            $episode->setSynopsis($faker->sentence(20, true));
            $episode->setNumber($i);

            $episode->setSeasonId($this->getReference('season_' . $faker->numberBetween(1, 10)));
            $manager->persist($episode);
        }

        $manager->flush();
    }
}
