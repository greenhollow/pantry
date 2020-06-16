<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ServicePantryStatusRepository")
 * @ORM\HasLifecycleCallbacks
 */
class ServicePantryStatus
{
    /**
     * Service pantry status types.
     */
    const STATUS_ACTIVE = 'active';
    const STATUS_CANCELED = 'canceled';
    const STATUS_COMPLETE = 'complete';
    const STATUS_DENIED = 'denied';
    const STATUS_HOLD = 'hold';
    const STATUS_PROCESS = 'process';
    const STATUS_REQUESTED = 'requested';

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
     * @ORM\Column(type="datetimetz")
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\ServicePantry", inversedBy="statuses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicePantry;

    /**
     * Get all valid statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_ACTIVE,
            self::STATUS_CANCELED,
            self::STATUS_COMPLETE,
            self::STATUS_DENIED,
            self::STATUS_HOLD,
            self::STATUS_PROCESS,
            self::STATUS_REQUESTED,
        ];
    }

    /**
     * Validate the entity state.
     *
     * @throws ConstraintDefinitionException
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function validate(): void
    {
        // check status value
        if (!in_array($this->status, self::getStatuses())) {
            throw new ConstraintDefinitionException(sprintf('Invalid status "%s" in %s; must be one of: %s', $this->status, get_class(), implode(', ', self::getStatuses())));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
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
