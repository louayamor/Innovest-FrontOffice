<?php

namespace App\DataFixtures;

use App\Entity\Sector;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\String\Slugger\SluggerInterface;

class SectorFixtures extends Fixture
{
    private $counter = 12;

    public function __construct(private SluggerInterface $slugger) {}

    public function load(ObjectManager $manager): void
    {
        $this->createSector('Information Technology', $manager);
        $this->createSector('Finance and Banking', $manager);
        $this->createSector('Healthcare Services',  $manager);
        $this->createSector('Retail and E-commerce',  $manager);
        $this->createSector('Real Estate',  $manager);
        $this->createSector('Manufacturing', $manager);
        $this->createSector('Education and Training',  $manager);
        $this->createSector('Hospitality and Tourism',  $manager);
        $this->createSector('Transportation and Logistics',  $manager);
        $this->createSector('Media and Entertainment',  $manager);
        $this->createSector('Energy and Utilities',  $manager);
        $manager->flush();
    }

    public function createSector(string $name, ObjectManager $manager)
    {
        $sector = new Sector();
        $sector->setSectorName($name);
        $manager->persist($sector);

        $this->addReference('sector-'.$this->counter, $sector);
        $this->counter++;

        return $sector;
    }
}
