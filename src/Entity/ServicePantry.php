<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ServicePantryRepository")
 */
class ServicePantry
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetimetz")
     */
    private $created;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageAdult;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageSenior;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageUnknown;

    /**
     * @ORM\Column(type="smallint")
     */
    private $ageYouth;

    /**
     * @ORM\OneToMany(targetEntity="GreenHollow\Pantry\Entity\ServicePantryStatus", mappedBy="servicePantry", orphanRemoval=true)
     * @ORM\OrderBy({"created" = "DESC"})
     */
    private $statuses;

    /**
     * @ORM\OneToMany(targetEntity="GreenHollow\Pantry\Entity\ServicePantryItem", mappedBy="servicePantry", orphanRemoval=true)
     */
    private $items;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Household")
     */
    private $household;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Client")
     */
    private $client;

    /**
     * Construct with age aggregate snapshots at zero for a given recipient.
     */
    public function __construct(RecipientInterface $recipient)
    {
        $this->ageAdult = 0;
        $this->ageSenior = 0;
        $this->ageUnknown = 0;
        $this->ageYouth = 0;

        $this->household = $recipient instanceof Household ? $recipient : null;
        $this->client = $recipient instanceof Client ? $recipient : null;

        $this->statuses = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getAgeAdult(): ?int
    {
        return $this->ageAdult;
    }

    public function setAgeAdult(int $ageAdult): self
    {
        $this->ageAdult = $ageAdult;

        return $this;
    }

    public function getAgeSenior(): ?int
    {
        return $this->ageSenior;
    }

    public function setAgeSenior(int $ageSenior): self
    {
        $this->ageSenior = $ageSenior;

        return $this;
    }

    public function getAgeUnknown(): ?int
    {
        return $this->ageUnknown;
    }

    public function setAgeUnknown(int $ageUnknown): self
    {
        $this->ageUnknown = $ageUnknown;

        return $this;
    }

    public function getAgeYouth(): ?int
    {
        return $this->ageYouth;
    }

    public function setAgeYouth(int $ageYouth): self
    {
        $this->ageYouth = $ageYouth;

        return $this;
    }

    /**
     * @return Collection|ServicePantryStatus[]
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(ServicePantryStatus $status): self
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses[] = $status;
            $status->setServicePantry($this);
        }

        return $this;
    }

    public function removeStatus(ServicePantryStatus $status): self
    {
        if ($this->statuses->contains($status)) {
            $this->statuses->removeElement($status);
            // set the owning side to null (unless already changed)
            if ($status->getServicePantry() === $this) {
                $status->setServicePantry(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ServicePantryItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ServicePantryItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setServicePantry($this);
        }

        return $this;
    }

    public function removeItem(ServicePantryItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getServicePantry() === $this) {
                $item->setServicePantry(null);
            }
        }

        return $this;
    }

    public function getHousehold(): ?Household
    {
        return $this->household;
    }

    public function setHousehold(?Household $household): self
    {
        $this->household = $household;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
