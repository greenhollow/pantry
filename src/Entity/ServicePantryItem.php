<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ServicePantryItemRepository")
 */
class ServicePantryItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\PantryItem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\ServicePantry", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicePantry;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getItem(): ?PantryItem
    {
        return $this->item;
    }

    public function setItem(?PantryItem $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getServicePantry(): ?ServicePantry
    {
        return $this->servicePantry;
    }

    public function setServicePantry(?ServicePantry $servicePantry): self
    {
        $this->servicePantry = $servicePantry;

        return $this;
    }
}
