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

        // Debugging output to check sector references
        $sectorId = rand(13, 21);
        $sector = $this->getReference('sector-' . $sectorId);
        dump('Sector ID: ' . $sectorId);
        dump($sector);

        $business->setSector($sector);

        $manager->persist($business);
    }

    $manager->flush();
}


    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            SectorFixtures::class,
        ];
    }
}

