<?php

namespace App\DataFixtures;

use App\Entity\Posts;
use App\Entity\Spaces;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class DataFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $plainPassword = "123456";

        // Spaces

        for ($i = 0; $i < 5; $i++) {
            $space = new Spaces();
            $space->setSpaceName($faker->company);
            $space->setThemeColor($faker->safeHexColor);
            $space->setDescription($faker->text);
            $space->setCreationDate($faker->dateTimeThisYear);
            $space->setSpaceImg($faker->imageUrl(640, 480, 'business', true));

            $manager->persist($space);

            $this->addReference('space-' . $i, $space);

        }

        // User

        for ($j = 0; $j < 10; $j++) {
            $user = new User();
            $user->setName($faker->userName);
            $user->setFirstname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordHasher->hashpassword($user, $plainPassword));
            $user->setStatus("test");
            $user->setRoles(['ROLE_ADMIN']);

            $manager->persist($user);

            $this->addReference('user-' . $j, $user);


            // Posts

            for ($k = 0; $k < 20; $k++) {
                $post = new Posts();
                $post->setText($faker->paragraph);
                $post->setCreatedAt($faker->dateTimeThisYear);
                $post->setUser($user);

                $post->setSpace($this->getReference('space-' . rand(0, 4)));

                $manager->persist($post);
            }
        }

        $manager->flush();
    }
}
