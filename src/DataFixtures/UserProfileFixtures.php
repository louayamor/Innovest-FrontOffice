<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\UserProfile;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker\Factory;

class UserProfileFixtures extends Fixture implements DependentFixtureInterface
{
    private $usedUserIds = [];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 30; $i++) {
            $userProfile = new UserProfile();
            $userId = $this->getUniqueUserId();
            $this->usedUserIds[] = $userId;

            $userProfile->setFirstName($faker->firstName);
            $userProfile->setLastName($faker->lastName);

            $user = $this->getReference('user-' . $userId);
            $userProfile->setUser($user);

            $userProfile->setAge($faker->numberBetween(18, 80));
            $userProfile->setCountry($faker->country);
            $userProfile->setProfileImage($faker->imageUrl());
            $userProfile->setBio($faker->paragraph);
            $phoneNumber = $faker->numerify('##########');
            $userProfile->setPhoneNumber((int) $phoneNumber);
            $userProfile->setGender($faker->randomElement(['Male', 'Female']));

            $manager->persist($userProfile);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
        ];
    }

    private function getUniqueUserId(): int
    {
        do {
            $userId = rand(1, 30); // Assuming you have 30 users
        } while (in_array($userId, $this->usedUserIds));

        return $userId;
    }
}
