<?php

namespace GreenHollow\Pantry\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ClientRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Client implements RecipientInterface
{
    use RecipientTrait;

    /**
     * Client relationships - expectation is that one client is designated the
     * "primary" and all others are designated in relation to the primary
     * - "family" is any relation not immediate (e.g. grandparent or in-law)
     * - "foster" can be in relation to any household client, not only primary.
     */
    const RELATION_CHILD = 'child';
    const RELATION_FAMILY = 'family';
    const RELATION_FOSTER_CHILD = 'foster';
    const RELATION_OTHER = 'other';
    const RELATION_PARENT = 'parent';
    const RELATION_PRIMARY = 'primary';
    const RELATION_ROOMMATE = 'roommate';
    const RELATION_SPOUSE = 'spouse';
    const RELATION_UNKNOWN = 'unknown';

    /**
     * Client statuses
     * - "authorized" client is not aggregated in household (e.g. a caretaker)
     * - "disabled" client is not aggregated and is not authorized to represent
     *   the household (e.g. no longer living in the household or deceased).
     */
    const STATUS_AUTHORIZED = 'authorized';
    const STATUS_DISABLED = 'disabled';
    const STATUS_ENABLED = 'enabled';

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
     * @ORM\Column(type="datetimetz")
     */
    private $updated;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $relationship;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $dob;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gender;

    /**
     * @ORM\Column(type="boolean")
     */
    private $allergic;

    /**
     * @ORM\Column(type="boolean")
     */
    private $diabetic;

    /**
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Household", inversedBy="clients")
     */
    private $household;

    /**
     * Construct with optional household.
     */
    public function __construct(?Household $household = null, string $relationship = null)
    {
        if ($household instanceof Household) {
            $household->addClient($this);
        }
        $this->relationship = $relationship ?? self::RELATION_UNKNOWN;
        $this->status = self::STATUS_ENABLED;
    }

    /**
     * Get all valid relations.
     */
    public static function getRelations(): array
    {
        return [
            self::RELATION_CHILD,
            self::RELATION_FAMILY,
            self::RELATION_FOSTER_CHILD,
            self::RELATION_OTHER,
            self::RELATION_PARENT,
            self::RELATION_PRIMARY,
            self::RELATION_ROOMMATE,
            self::RELATION_SPOUSE,
            self::RELATION_UNKNOWN,
        ];
    }

    /**
     * Get all valid statuses.
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_AUTHORIZED,
            self::STATUS_DISABLED,
            self::STATUS_ENABLED,
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
        // check relationship value
        if (!in_array($this->relationship, self::getRelations())) {
            throw new ConstraintDefinitionException(sprintf('Invalid relationship "%s" in %s; must be one of: %s', $this->relationship, get_class(), implode(', ', self::getRelations())));
        }

        // check status value
        if (!in_array($this->status, self::getStatuses())) {
            throw new ConstraintDefinitionException(sprintf('Invalid status "%s" in %s; must be one of: %s', $this->status, get_class(), implode(', ', self::getStatuses())));
        }
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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

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

    public function getRelationship(): ?string
    {
        return $this->relationship;
    }

    public function setRelationship(string $relationship): self
    {
        $this->relationship = $relationship;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDob(): ?\DateTimeInterface
    {
        return $this->dob;
    }

    public function setDob(?\DateTimeInterface $dob): self
    {
        $this->dob = $dob;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(?string $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAllergic(): ?bool
    {
        return $this->allergic;
    }

    public function setAllergic(bool $allergic): self
    {
        $this->allergic = $allergic;

        return $this;
    }

    public function getDiabetic(): ?bool
    {
        return $this->diabetic;
    }

    public function setDiabetic(bool $diabetic): self
    {
        $this->diabetic = $diabetic;

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
}
