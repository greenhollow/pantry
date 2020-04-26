<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\PantryItemRepository")
 */
class PantryItem
{
    /**
     * Units of measure.
     */
    const UNIT_COUNT = 'qty';
    const UNIT_GRAM = 'g';
    const UNIT_KILOGRAM = 'kg';
    const UNIT_OUNCE = 'oz';
    const UNIT_POUND = 'lb';

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
    private $measure;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(callback="getUnits")
     */
    private $measureUnit;

    /**
     * @ORM\Column(type="integer")
     */
    private $qty;

    /**
     * @ORM\Column(type="boolean")
     */
    private $hasItems;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\PantryItem", inversedBy="items")
     */
    private $container;

    /**
     * @ORM\OneToMany(targetEntity="GreenHollow\Pantry\Entity\PantryItem", mappedBy="container")
     */
    private $items;

    /**
     * Get all valid units of measure.
     */
    public static function getUnits(): array
    {
        return [
            self::UNIT_COUNT,
            self::UNIT_GRAM,
            self::UNIT_KILOGRAM,
            self::UNIT_OUNCE,
            self::UNIT_POUND,
        ];
    }

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

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

    public function getMeasure(): ?int
    {
        return $this->measure;
    }

    public function setMeasure(int $measure): self
    {
        $this->measure = $measure;

        return $this;
    }

    public function getMeasureUnit(): ?string
    {
        return $this->measureUnit;
    }

    public function setMeasureUnit(string $measureUnit): self
    {
        $this->measureUnit = $measureUnit;

        return $this;
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

    public function getHasItems(): ?bool
    {
        return $this->hasItems;
    }

    public function setHasItems(bool $hasItems): self
    {
        $this->hasItems = $hasItems;

        return $this;
    }

    public function getContainer(): ?self
    {
        return $this->container;
    }

    public function setContainer(?self $container): self
    {
        $this->container = $container;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(self $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items[] = $item;
            $item->setContainer($this);
        }

        return $this;
    }

    public function removeItem(self $item): self
    {
        if ($this->items->contains($item)) {
            $this->items->removeElement($item);
            // set the owning side to null (unless already changed)
            if ($item->getContainer() === $this) {
                $item->setContainer(null);
            }
        }

        return $this;
    }
}
