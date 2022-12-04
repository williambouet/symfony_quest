<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Actor;
use App\DataFixtures\ProgramFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ActorFixtures extends Fixture
{
    public const NUMBER_OF_ACTOR = 10;

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $numberOfActor = self::NUMBER_OF_ACTOR;
        $numberOfProgram = ProgramFixtures::NUMBER_OF_PROGRAM;

        for ($i=1; $i <= $numberOfActor; $i++) { 
        
            $actor = new Actor();
            $actorName = $faker->name();
            $actor->setName($actorName);
            $manager->persist($actor);
            $this->addReference('actor_' . $i, $actor);
        
        }
        $manager->flush();
    }


    }

