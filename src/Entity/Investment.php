<?php

namespace App\Entity;

use App\Entity\Trait\CreatedAtTrait;
use App\Repository\InvestmentRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvestmentRepository::class)]
class Investment
{

    use CreatedAtTrait;

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

    

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 3)]
    private ?string $Amount = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $comment = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

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

    public function getAmount(): ?string
    {
        return $this->Amount;
    }

    public function setAmount(string $Amount): static
    {
        $this->Amount = $Amount;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }
}
