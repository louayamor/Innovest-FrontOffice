<?php

namespace App\DataFixtures;

use App\Entity\Investment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\User;
use App\Entity\Business;
use Doctrine\ORM\EntityManagerInterface;

class InvestmentFixtures implements DependentFixtureInterface
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        
        $faker = Factory::create();

        $users = $this->entityManager->getRepository(User::class)->findAll();
        $businesses = $this->entityManager->getRepository(Business::class)->findAll();
        
        foreach ($users as $user) {
            foreach ($businesses as $business) {
                $investment = new Investment();
                $investment->setInvestor($user);
                $investment->setBusiness($business);
                $investment->setAmount($faker->randomFloat(3, 100, 10000));
                $investment->setComment($faker->sentence);

                $manager->persist($investment);
            }
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            BusinessFixtures::class,
        ];
    }
}

