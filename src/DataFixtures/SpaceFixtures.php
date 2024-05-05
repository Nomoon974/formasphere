<?php

namespace App\DataFixtures;

use App\Entity\Spaces;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SpaceFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager) {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $space = new Spaces();
            $space->setSpaceName($faker->company);
            $space->setThemeColor($faker->safeHexColor);
            $space->setDescription($faker->text);
            $space->setCreationDate($faker->dateTimeThisYear);
            $space->setSpaceImg($faker->imageUrl(640, 480, 'business', true));

            $manager->persist($space);
        }

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['group_space'];
    }

}