<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ServiceAssistanceItemRepository")
 */
class ServiceAssistanceItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $dollarsInCents;

    /**
     * @ORM\Column(type="integer")
     */
    private $hoursInMinutes;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\AssistanceItem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $item;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\ServiceAssistance", inversedBy="items")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceAssistance;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getItem(): ?AssistanceItem
    {
        return $this->item;
    }

    public function setItem(?AssistanceItem $item): self
    {
        $this->item = $item;

        return $this;
    }

    public function getServiceAssistance(): ?ServiceAssistance
    {
        return $this->serviceAssistance;
    }

    public function setServiceAssistance(?ServiceAssistance $serviceAssistance): self
    {
        $this->serviceAssistance = $serviceAssistance;

        return $this;
    }
}
