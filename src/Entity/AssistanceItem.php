<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\AssistanceItemRepository")
 */
class AssistanceItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $barcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $dollarsInCents;

    /**
     * @ORM\Column(type="integer")
     */
    private $hoursInMinutes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): self
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
}
