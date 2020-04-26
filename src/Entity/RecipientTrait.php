<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trait for an entity that can receive a service.
 */
trait RecipientTrait
{
    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phone;

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
