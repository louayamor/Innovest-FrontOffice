<?php

namespace App\Entity;

use App\Repository\SectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SectorRepository::class)]
class Sector
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $SectorName = null;

    /**
     * @var Collection<int, Business>
     */
    #[ORM\OneToMany(targetEntity: Business::class, mappedBy: 'sector',fetch: 'EAGER')]
    private Collection $business;

    public function __construct()
    {
        $this->business = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectorName(): ?string
    {
        return $this->SectorName;
    }

    public function setSectorName(string $SectorName): static
    {
        $this->SectorName = $SectorName;

        return $this;
    }

    /**
     * @return Collection<int, Business>
     */
    public function getBusiness(): Collection
    {
        return $this->business;
    }

    public function addBusiness(Business $business): static
    {
        if (!$this->business->contains($business)) {
            $this->business->add($business);
            $business->setSector($this);
        }

        return $this;
    }

    public function removeBusiness(Business $business): static
    {
        if ($this->business->removeElement($business)) {
            // set the owning side to null (unless already changed)
            if ($business->getSector() === $this) {
                $business->setSector(null);
            }
        }

        return $this;
    }
}
