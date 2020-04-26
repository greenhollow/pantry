<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ServiceAssistanceRepository")
 */
class ServiceAssistance
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
     * @ORM\Column(type="integer")
     */
    private $dollarsInCents;

    /**
     * @ORM\Column(type="integer")
     */
    private $hoursInMinutes;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Household")
     */
    private $household;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Client")
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="GreenHollow\Pantry\Entity\ServiceAssistanceStatus", mappedBy="serviceAssistance", orphanRemoval=true)
     * @ORM\OrderBy({"created" = "DESC"})
     */
    private $statuses;

    /**
     * @ORM\OneToMany(targetEntity="GreenHollow\Pantry\Entity\ServiceAssistanceItem", mappedBy="serviceAssistance", orphanRemoval=true)
     */
    private $items;

    /**
     * Construct for a given recipient.
     */
    public function __construct(RecipientInterface $recipient)
    {
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

    public function getDollarsInCents(): ?int
    {
        return $this->dollarsInCents;
    }

    public function setDollarsInCents(int $dollarsInCents): self
    {
        $this->dollarsInCents = $dollarsInCents;

        return $this;
    }

    public function getHoursInMinutes(): ?int
    {
        return $this->hoursInMinutes;
    }

    public function setHoursInMinutes(int $hoursInMinutes): self
    {
        $this->hoursInMinutes = $hoursInMinutes;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

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

    /**
     * @return Collection|ServiceAssistanceStatus[]
     */
    public function getStatuses(): Collection
    {
        return $this->statuses;
    }

    public function addStatus(ServiceAssistanceStatus $status): self
    {
        if (!$this->statuses->contains($status)) {
            $this->statuses[] = $status;
            $status->setServiceAssistance($this);
        }

        return $this;
    }

    public function removeStatus(ServiceAssistanceStatus $status): self
    {
        if ($this->statuses->contains($status)) {
            $this->statuses->removeElement($status);
            // set the owning side to null (unless already changed)
            if ($status->getServiceAssistance() === $this) {
                $status->setServiceAssistance(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ServiceAssistanceItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(ServiceAssistanceItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setServiceAssistance($this);
        }

        return $this;
    }

    public function removeItem(ServiceAssistanceItem $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getServiceAssistance() === $this) {
                $item->setServiceAssistance(null);
            }
        }

        return $this;
    }
}
