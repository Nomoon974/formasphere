<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;

class AppFixtures extends Fixture
{
public function load(ObjectManager $manager)
{
$faker = Factory::create();

for ($i = 0; $i < 10; $i++) {
$user = new User();
$user->setName($faker->userName);
$user->setEmail($faker->email);
$user->setPassword($faker->password);
$user->setStatus("test");

$manager->persist($user);
}

$manager->flush();
}
}
