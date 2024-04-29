<?php

namespace App\DataFixtures;

use App\Entity\Investment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class InvestmentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /** 
        $faker = Factory::create();

        for ($i = 0; $i < 60; $i++) {
            $investment = new Investment();
            
            $investment->setAmount($faker->randomFloat(2, 1000, 100000));
            $investment->setInvestmentDate($faker->dateTimeThisYear());
            $investment->setStatus($faker->randomElement(['pending', 'approved', 'declined']));
            $investment->setPaymentMethod($faker->randomElement(['credit card', 'bank transfer']));
            $investment->setTransactionId($faker->uuid);
            $investment->setDuration($faker->randomElement(['short-term', 'long-term']));
            $investment->setReturnOnInvestment($faker->randomFloat(2, 0, 100));
            $investment->setNotes($faker->text);


            $user = $this->getReference(rand(1, 8));
            $investment->setInvestor($user);

            $business1 = $this->getReference(rand(1, 30));
            $investment->setBusiness($business1);
            $manager->persist($investment);
        }
        */
        $manager->flush();
    }
}

