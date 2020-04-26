<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ServiceAssistanceStatusRepository")
 */
class ServiceAssistanceStatus
{
    /**
     * Service assistance status types.
     */
    const STATUS_APPLIED = 'applied';
    const STATUS_APPROVED = 'approved';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETE = 'complete';
    const STATUS_DENIED = 'denied';
    const STATUS_HOLD = 'hold';
    const STATUS_PROCESS = 'process';

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
     * @ORM\Column(type="string", length=255)
     * @Assert\Choice(callback="getStatuses")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\ServiceAssistance", inversedBy="statuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceAssistance;

    /**
     * Get all valid statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_APPLIED,
            self::STATUS_APPROVED,
            self::STATUS_CANCELED,
            self::STATUS_COMPLETE,
            self::STATUS_DENIED,
            self::STATUS_HOLD,
            self::STATUS_PROCESS,
        ];
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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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
