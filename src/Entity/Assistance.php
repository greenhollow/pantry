<?php

namespace GreenHollow\Pantry\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\LogicException;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\AssistanceRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Assistance
{
    /**
     * Types of assistance.
     */
    const TYPE_CHIPS = 'chips';
    const TYPE_FOOD_STAMPS = 'food_stamps';
    const TYPE_MEDICAID = 'medicaid';
    const TYPE_MEDICARE = 'medicare';
    const TYPE_VETERANS = 'veterans';
    const TYPE_WIC = 'wic';

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
    private $enabled;

    /**
     * @ORM\Column(type="datetimetz", nullable=true)
     */
    private $disabled;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Household")
     * @ORM\JoinColumn(nullable=false)
     */
    private $household;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Client")
     */
    private $client;

    /**
     * Construct as enabled for a given recipient.
     */
    public function __construct(RecipientInterface $recipient)
    {
        $this->enabled = new DateTime();

        $this->household = $recipient instanceof Household ? $recipient : null;
        $this->client = $recipient instanceof Client ? $recipient : null;
    }

    /**
     * Disable this assistance type.
     *
     * @throws LogicException
     */
    public function disable(): self
    {
        if (null !== $this->disabled) {
            throw new LogicException(sprintf('%s is already disabled!', get_class()));
        }

        $this->disabled = new DateTime();

        return $this;
    }

    /**
     * Get all valid types.
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_CHIPS,
            self::TYPE_FOOD_STAMPS,
            self::TYPE_MEDICAID,
            self::TYPE_MEDICARE,
            self::TYPE_VETERANS,
            self::TYPE_WIC,
        ];
    }

    /**
     * Check if this assistance is disabled.
     */
    public function isDisabled(): bool
    {
        return $this->disabled instanceof DateTime;
    }

    /**
     * Check if this assistance is enabled.
     */
    public function isEnabled(): bool
    {
        return is_null($this->disabled);
    }

    /**
     * Validate client state.
     *
     * @throws ConstraintDefinitionException
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function validate(): void
    {
        // check type value
        if (!in_array($this->type, self::getTypes())) {
            throw new ConstraintDefinitionException(sprintf('Invalid type "%s" in %s; must be one of: %s', $this->type, get_class(), implode(', ', self::getTypes())));
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

    public function getEnabled(): ?\DateTimeInterface
    {
        return $this->enabled;
    }

    public function setEnabled(\DateTimeInterface $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getDisabled(): ?\DateTimeInterface
    {
        return $this->disabled;
    }

    public function setDisabled(?\DateTimeInterface $disabled): self
    {
        $this->disabled = $disabled;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

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
