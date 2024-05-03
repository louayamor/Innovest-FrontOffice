<?php

namespace App\Entity;

use App\Repository\BusinessRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;

#[ORM\Entity(repositoryClass: BusinessRepository::class)]
class Business
{

    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $revenue = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $Profit = null;

    #[ORM\Column(length: 255)]
    private ?string $sector = null;

    #[ORM\ManyToOne(inversedBy: 'businesses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Owner = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Country = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $ImageBlob = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getRevenue(): ?string
    {
        return $this->revenue;
    }

    public function setRevenue(string $revenue): static
    {
        $this->revenue = $revenue;

        return $this;
    }

    public function getProfit(): ?string
    {
        return $this->Profit;
    }

    public function setProfit(string $Profit): static
    {
        $this->Profit = $Profit;

        return $this;
    }

    public function getSector(): ?string
    {
        return $this->sector;
    }

    public function setSector(string $sector): static
    {
        $this->sector = $sector;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->Owner;
    }

    public function setOwner(?User $Owner): static
    {
        $this->Owner = $Owner;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(?string $Country): static
    {
        $this->Country = $Country;

        return $this;
    }

    public function getImageBlob()
    {
        return $this->ImageBlob;
    }

    public function setImageBlob($ImageBlob): static
    {
        $this->ImageBlob = $ImageBlob;

        return $this;
    }
}
