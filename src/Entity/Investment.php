<?php

namespace App\Entity;

use App\Repository\InvestmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestmentRepository::class)]
class Investment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'AllInvestments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Investor = null;

    #[ORM\ManyToOne(inversedBy: 'All_Business_Investments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Business $Business = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInvestor(): ?User
    {
        return $this->Investor;
    }

    public function setInvestor(?User $Investor): static
    {
        $this->Investor = $Investor;

        return $this;
    }

    public function getBusiness(): ?Business
    {
        return $this->Business;
    }

    public function setBusiness(?Business $Business): static
    {
        $this->Business = $Business;

        return $this;
    }
}
