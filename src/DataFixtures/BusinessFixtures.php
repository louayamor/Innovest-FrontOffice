<?php

namespace App\DataFixtures;

use App\Entity\Business;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class BusinessFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 30; $i++) {
            $business = new Business();
            $business->setName($faker->company);
            $business->setDescription($faker->sentence);
            $business->setRevenue($faker->randomFloat(2, 1000, 100000));
            $business->setProfit($faker->randomFloat(2, 1000, 100000));

            $user = $this->getReference('user-' . rand(1, 30));
            $business->setOwner($user);

            $sectorId = rand(13, 21);
            $sectorName = $this->getReference('sector-' . $sectorId)->getSectorName();
            $business->setSector($sectorName);

            $manager->persist($business);
        }

        $manager->flush();
    }

    public function createBusiness(string $name, string $description, float $revenue, float $profit, ObjectManager $manager): Business
    {
        $faker = Factory::create();

        $business = new Business();
        $business->setName($name);
        $business->setDescription($description);
        $business->setRevenue($revenue);
        $business->setProfit($profit);

        $user = $this->getReference('user-' . rand(1, 30)); // Assuming you have user references
        $business->setOwner($user);

        $sectorId = rand(13, 21);
        $sectorName = $this->getReference('sector-' . $sectorId)->getSectorName();
        $business->setSector($sectorName);

        $manager->persist($business);
        $manager->flush();

        return $business;
    }


    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SectorFixtures::class,
        ];
    }
}

