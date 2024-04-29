<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\BusinessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column(length: 255)]
    private ?string $Sector = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $Revenue = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $Profit = null;

    #[ORM\ManyToOne(inversedBy: 'AllBusinesses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Owner = null;

    /**
     * @var Collection<int, Investment>
     */
    #[ORM\OneToMany(targetEntity: Investment::class, mappedBy: 'Business')]
    private Collection $All_Business_Investments;

    /**
     * @ORM\ManyToOne(targetEntity=Sector::class, inversedBy="business")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Sector $sector;

    public function __construct()
    {
        $this->All_Business_Investments = new ArrayCollection();
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

    public function getSector(): ?Sector
    {
        return $this->sector;
    }

    public function setSector(?Sector $sector): self
    {
        $this->sector = $sector;

        return $this;
    }

    public function getRevenue(): ?string
    {
        return $this->Revenue;
    }

    public function setRevenue(string $Revenue): static
    {
        $this->Revenue = $Revenue;

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

    public function getOwner(): ?User
    {
        return $this->Owner;
    }

    public function setOwner(?User $Owner): static
    {
        $this->Owner = $Owner;

        return $this;
    }

    /**
     * @return Collection<int, Investment>
     */
    public function getAllBusinessInvestments(): Collection
    {
        return $this->All_Business_Investments;
    }

    public function addAllBusinessInvestment(Investment $allBusinessInvestment): static
    {
        if (!$this->All_Business_Investments->contains($allBusinessInvestment)) {
            $this->All_Business_Investments->add($allBusinessInvestment);
            $allBusinessInvestment->setBusiness($this);
        }

        return $this;
    }

    public function removeAllBusinessInvestment(Investment $allBusinessInvestment): static
    {
        if ($this->All_Business_Investments->removeElement($allBusinessInvestment)) {
            // set the owning side to null (unless already changed)
            if ($allBusinessInvestment->getBusiness() === $this) {
                $allBusinessInvestment->setBusiness(null);
            }
        }

        return $this;
    }
}
