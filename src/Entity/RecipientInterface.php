<?php

namespace GreenHollow\Pantry\Entity;

/**
 * Represents an entity that can receive a service.  Can be satisfied by using
 * the RecipientTrait.
 */
interface RecipientInterface
{
    public function getBarcode(): ?string;

    public function setBarcode(?string $barcode): self;

    public function getPhone(): ?string;

    public function setPhone(?string $phone): self;
}
