<?php

namespace GreenHollow\Pantry\Entity;

use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use GreenHollow\Pantry\Dto\ClientDto;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use UnexpectedValueException;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\ClientRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Client implements RecipientInterface
{
    use RecipientTrait;

    /**
     * Client genders
     */
    const GENDER_FEMALE = 'F';
    const GENDER_MALE = 'M';

    /**
     * Client relationships - expectation is that one client is designated the
     * "primary" and all others are designated in relation to the primary
     * - "family" is any relation not immediate (e.g. grandparent or in-law)
     * - "foster" can be in relation to any household client, not only primary.
     */
    const RELATION_CHILD = 'child';
    const RELATION_FAMILY = 'family';
    const RELATION_FOSTER_CHILD = 'foster';
    const RELATION_INDIVIDUAL = 'self';
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
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetimetz")
     */
    private $created;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetimetz")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=10)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=8)
     */
    private $relationship;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="date", nullable=true)
     */
    private $dob;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=1, nullable=true)
     */
    private $gender;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $allergic;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $diabetic;

    /**
     * @var Household
     *
     * @ORM\ManyToOne(targetEntity="GreenHollow\Pantry\Entity\Household", inversedBy="clients")
     */
    private $household;

    /**
     * Construct with optional household.
     */
    public function __construct(?Household $household = null, string $relationship = null)
    {
        $this->relationship = $relationship ?? self::RELATION_UNKNOWN;

        if ($household instanceof Household) {
            $household->addClient($this);
        } else {
            $this->relationship = self::RELATION_INDIVIDUAL;
        }

        $this->status = self::STATUS_ENABLED;
        $this->allergic = false;
        $this->diabetic = false;
    }

    /**
     * Get all valid genders.
     */
    public static function getGenders(): array
    {
        return [
            self::GENDER_FEMALE,
            self::GENDER_MALE,
        ];
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
            self::RELATION_INDIVIDUAL,
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
     * Update from a DTO.  Null values will be ignored unless the DTO was
     * instantiated from this entity.
     *
     * @throws UnexpectedValueException
     */
    public function update(ClientDto $dto): self
    {
        // if the uuid is set, all properties should be updated from the DTO,
        // even nulls, as the DTO was created from this client
        $updateAll = !is_null($dto->getUuid());

        // if set, the UUID must match
        if ($updateAll && $dto->getUuid() !== $this->uuid) {
            throw new UnexpectedValueException('Attempting to update a client from another instance is not allowed.');
        }

        // iterate over the updateable properties
        foreach ([
            'allergic',
            'diabetic',
            'dob',
            'firstName',
            'gender',
            'household',
            'lastName',
            'relationship',
            'status',
        ] as $property) {
            if ($updateAll || !is_null($dto->$property)) {
                $this->$property = $dto->$property;
            }
        }

        // enforce the proper relationship for a client not in a household
        if (!($this->household instanceof Household)) {
            $this->relationship = self::RELATION_INDIVIDUAL;
        }

        // otherwise, enforce non-self relationship when not an individual
        elseif (self::RELATION_INDIVIDUAL === $this->relationship) {
            $this->relationship = self::RELATION_UNKNOWN;
        }

        return $this;
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
        // check gender value
        if ($this->gender && !in_array($this->gender, self::getGenders())) {
            throw new ConstraintDefinitionException(sprintf('Invalid gender "%s" in %s; must be null or one of: %s', $this->gender, get_class(), implode(', ', self::getGenders())));
        }

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

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function getCreated(): ?DateTimeInterface
    {
        return $this->created;
    }

    public function getUpdated(): ?DateTimeInterface
    {
        return $this->updated;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getRelationship(): string
    {
        return $this->relationship;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getDob(): ?DateTimeInterface
    {
        return $this->dob;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getAllergic(): ?bool
    {
        return $this->allergic;
    }

    public function getDiabetic(): ?bool
    {
        return $this->diabetic;
    }

    public function getHousehold(): ?Household
    {
        return $this->household;
    }
}
