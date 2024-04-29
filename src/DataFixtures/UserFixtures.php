<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class UserFixtures extends Fixture
{
    private int $counter = 1;
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher )
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin1@gmail.com');
        $admin->setUsername('admin1');
        $admin->setPassword(
            $this->userPasswordHasher->hashPassword($admin, 'admin')
        );
        $admin->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $faker = Factory::create();

        $admin = $this->createUser('admin@gmail.com', 'admin', ['ROLE_ADMIN'], $manager);

        for ($usr = 1; $usr <= 30; $usr++) {
            $email = $faker->unique()->safeEmail;
            $username = $faker->unique()->userName;
            $roles = ['ROLE_USER'];
            $this->createUser($email, $username, $roles, $manager);
        }

        $manager->flush();
    }

    public function createUser(string $email, string $username, array $roles, ObjectManager $manager): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'password123')); // Set a secure password or generate one
        $user->setRoles($roles);
        $manager->persist($user);

        $this->addReference('user-'.$this->counter, $user);
        $this->counter++;

        return $user;
    }
}
