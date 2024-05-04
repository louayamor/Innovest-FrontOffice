<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Trait\CreatedAtTrait;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{

    use CreatedAtTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Message = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $Sender = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $Reciever = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): static
    {
        $this->Message = $Message;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->Sender;
    }

    public function setSender(User $Sender): static
    {
        $this->Sender = $Sender;

        return $this;
    }

    public function getReciever(): ?User
    {
        return $this->Reciever;
    }

    public function setReciever(?User $Reciever): static
    {
        $this->Reciever = $Reciever;

        return $this;
    }
}
