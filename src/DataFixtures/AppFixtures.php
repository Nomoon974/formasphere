<?php

namespace App\DataFixtures;

use App\Entity\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $plainPassword = 123456;

        $role = new Roles();
        $role->setRoleName('ROLE_USER');

        $manager->persist($role);

        $role2 = new Roles();
        $role2->setRoleName('ROLE_ADMIN');

        $manager->persist($role2);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setName($faker->userName);
            $user->setFirstname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordHasher->hashpassword($user, $plainPassword));
            $user->setStatus("test");
            $user->setRoles((array)'ROLE_ADMIN');

            $manager->persist($user);
        }

        $manager->flush();
    }
}
