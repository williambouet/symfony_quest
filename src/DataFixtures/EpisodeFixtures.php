<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\Entity\Episode;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public const NUMBER_OF_EPISODE_PER_SEASON = 8;

    public function load(ObjectManager $manager): void
    {

        $faker = Factory::create();

        $numberOfProgram = ProgramFixtures::NUMBER_OF_PROGRAM;
        $numberOfSeason = SeasonFixtures::NUMBER_OF_SEASON_PER_PROGRAM;
        $numberOfEpisode = self::NUMBER_OF_EPISODE_PER_SEASON;

        foreach (CategoryFixtures::CATEGORIES as $categoryName) {
            for ($i = 1; $i <= $numberOfProgram; $i++) {
                for ($j = 1; $j <= $numberOfSeason; $j++) {
                    for ($k = 1; $k <= $numberOfEpisode; $k++) {
                        $episode = new Episode();
                        $episode->setTitle($faker->sentence());
                        $episode->setSynopsis($faker->sentence(20, true));
                        $episode->setNumber($k);
                        $episode->setSeason($this->getReference('program_' . $i . '_' . $categoryName . '_season_' . $j));

                        $manager->persist($episode);
                    }
                }
            }
        }
        $manager->flush();
    }
    public function getDependencies()
    {
             return [
            SeasonFixtures::class,
        ];
    }
}
