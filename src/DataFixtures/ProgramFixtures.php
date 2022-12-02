<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\Entity\Program;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const NUMBER_OF_PROGRAM = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $numberOfProgram = self::NUMBER_OF_PROGRAM;
        foreach (CategoryFixtures::CATEGORIES as $categoryName) {
            for ($i = 1; $i <= $numberOfProgram; $i++) {
                $program = new Program();
                $program->setTitle($faker->sentence(3, true));
                $program->setPoster($categoryName . '.jpg');
                $program->setSynopsis($faker->sentence(20, true));
                $program->setCategory($this->getReference('category_' . $categoryName));
                $this->addReference('program_' . $i . '_' . $categoryName, $program);

                $manager->persist($program);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
