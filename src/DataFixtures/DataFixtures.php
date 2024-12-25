<?php

namespace App\DataFixtures;

use App\Entity\Comment;
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
            $space->setCreationDate(new \DateTimeImmutable());  // Convert to DateTimeImmutable
            $space->setSpaceImg($faker->imageUrl(640, 480, 'business', true));
            $manager->persist($space);
            $this->addReference('space-' . $i, $space);
        }

        $manager->flush();  // Make sure all spaces are persisted before referencing

        // Users
        for ($j = 0; $j < 10; $j++) {
            $user = new User();
            $user->setName($faker->userName);
            $user->setFirstname($faker->firstName);
            $user->setEmail($faker->email);
            $user->setPassword($this->passwordHasher->hashPassword($user, $plainPassword));
            $user->setStatus("test");
            $user->setRoles(['ROLE_ADMIN']);
            for ($s = 0; $s < rand(1, 3); $s++) {
                $spaceIndex = rand(0, 4); // Index des espaces dans les références
                if ($this->hasReference('space-' . $spaceIndex)) {
                    $user->addSpace($this->getReference('space-' . $spaceIndex)); // Association User <-> Space
                }
            }
            $manager->persist($user);
            $this->addReference('user-' . $j, $user);
        }

        $manager->flush();  // Make sure all users are persisted before referencing

        // Posts and Comments
        for ($j = 0; $j < 10; $j++) {
            $user = $this->getReference('user-' . $j);
            for ($k = 0; $k < 20; $k++) {
                $post = new Posts();
                $post->setText($faker->paragraph);
                $post->setCreatedAt(new \DateTimeImmutable());  // Convert to DateTimeImmutable
                $post->setUser($user);
                $spaceIndex = rand(0, 4);
                if ($this->hasReference('space-' . $spaceIndex)) {
                    $post->setSpace($this->getReference('space-' . $spaceIndex));
                }
                $manager->persist($post);

                // Comments
                for ($m = 0; $m < rand(1, 5); $m++) {
                    $comment = new Comment();
                    $comment->setText($faker->sentence);
                    $comment->setCreatedAt(new \DateTimeImmutable());  // Consistent DateTimeImmutable usage
                    $userIndex = rand(0, 9);
                    if ($this->hasReference('user-' . $userIndex)) {
                        $comment->setUser($this->getReference('user-' . $userIndex));
                    }
                    $comment->setPost($post);
                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();  // Final flush to persist all posts and comments
    }
}
