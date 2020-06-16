<?php

namespace GreenHollow\Pantry\Dto;

use DateTimeInterface;
use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Entity\Household;

/**
 * Data transfer object for Client entities.
 */
class ClientDto
{
    /** @var bool|null */
    public $allergic;

    /** @var bool|null */
    public $diabetic;

    /** @var DateTimeInterface|null */
    public $dob;

    /** @var string|null */
    public $firstName;

    /** @var string|null */
    public $gender;

    /** @var Household|null */
    public $household;

    /** @var string|null */
    public $lastName;

    /** @var string */
    public $relationship;

    /** @var string|null */
    public $status;

    /** @var string|null */
    private $uuid;

    /**
     * Construct with a client UUID.
     */
    public function __construct(?string $uuid = null)
    {
        $this->uuid = $uuid;
    }

    /**
     * Instantiate from a Client.
     */
    public static function create(Client $client): self
    {
        $dto = new self($client->getUuid());

        $dto->allergic = $client->getAllergic();
        $dto->diabetic = $client->getDiabetic();
        $dto->dob = $client->getDob();
        $dto->firstName = $client->getFirstName();
        $dto->gender = $client->getGender();
        $dto->household = $client->getHousehold();
        $dto->lastName = $client->getLastName();
        $dto->relationship = $client->getRelationship();
        $dto->status = $client->getStatus();

        return $dto;
    }

    /**
     * UUID will only be set if instantiated from a Client.
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }
}
