<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Season;
use App\Entity\Program;
use App\DataFixtures\ActorFixtures;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public const NUMBER_OF_PROGRAM = 6;
    public const NUMBER_OF_ACTOR_IN_PROGRAM = 3;
    private SluggerInterface $slugger;
    
    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }
    
    
    
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $numberOfProgram = self::NUMBER_OF_PROGRAM;
        $numberOfActor = self::NUMBER_OF_ACTOR_IN_PROGRAM;
        foreach (CategoryFixtures::CATEGORIES as $categoryName) {
            for ($i = 1; $i <= $numberOfProgram; $i++) {
                $program = new Program();
                $title = $faker->sentence(3, true);
                $slug = $this->slugger->slug($title);
                $program->setSlug($slug);
                $program->setTitle($title);
                $program->setPoster($categoryName . '.jpg');
                $program->setSynopsis($faker->sentence(20, true));
                $program->setCategory($this->getReference('category_' . $categoryName));
                $this->addReference('program_' . $i . '_' . $categoryName, $program);
                for ($j=0; $j < $numberOfActor; $j++) { 
                    $program->addActor($this->getReference('actor_' . $faker->numberBetween(1, 10)));    
                }

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
            ActorFixtures::class,
        ];
    }
}
