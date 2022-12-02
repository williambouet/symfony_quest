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

    public const NUMBER_OF_SEASON_PER_PROGRAM = 7;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $numberOfProgram = ProgramFixtures::NUMBER_OF_PROGRAM;
        $numberOfSeason = self::NUMBER_OF_SEASON_PER_PROGRAM;

        foreach (CategoryFixtures::CATEGORIES as $categoryName) {
            for ($i = 1; $i <= $numberOfProgram; $i++) {
                for ($j = 1; $j <= $numberOfSeason; $j++) {
                    $season = new Season();
                    $season->setNumber($j);
                    $season->setYear($faker->year());
                    $season->setDescription($faker->paragraphs(3, true));
                    $season->setProgram($this->getReference('program_' . $i . '_' . $categoryName));
                    $this->addReference('program_' . $i . '_' . $categoryName . '_season_' . $j, $season);

                    $manager->persist($season);
                }
            }
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
