<?php

namespace GreenHollow\Pantry\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use GreenHollow\Pantry\Dto\ClientDto;
use Symfony\Component\Validator\Exception\LogicException;

/**
 * @ORM\Entity(repositoryClass="GreenHollow\Pantry\Repository\HouseholdRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Household implements RecipientInterface
{
    use RecipientTrait;

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
     * @ORM\Column(type="datetimetz")
     */
    private $updated;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zip;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $notes;

    /**
     * @ORM\OneToMany(targetEntity="GreenHollow\Pantry\Entity\Client", mappedBy="household")
     */
    private $clients;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    /**
     * Validate the entity state.
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function validate(): void
    {
        if (null === $this->created) {
            $this->created = new DateTime();
        }
        $this->updated = new DateTime();

        // if there are no clients, there is nothing to validate
        if (0 === $this->clients->count()) {
            return;
        }

        // filter for enabled primary client
        $clients = $this->clients->filter(function ($client) {
            return Client::RELATION_PRIMARY === $client->getRelationship()
                && Client::STATUS_ENABLED === $client->getStatus()
            ;
        });

        // if not exactly one match, household is invalid
        if (1 !== $clients->count()) {
            throw new LogicException(sprintf('Invalid %s; related %s list must have exactly one of "%s" relationship enabled, found %d!', Household::class, Client::class, Client::RELATION_PRIMARY, $clients->count()));
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

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): self
    {
        $this->address1 = $address1;

        return $this;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): self
    {
        $this->address2 = $address2;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(?string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): self
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;

            $clientDto = ClientDto::create($client);
            $clientDto->household = $this;
            $client->update($clientDto);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->contains($client)) {
            $this->clients->removeElement($client);

            // set the owning side to null (unless already changed)
            if ($client->getHousehold() === $this) {
                $clientDto = ClientDto::create($client);
                $clientDto->household = null;
                $client->update($clientDto);
            }
        }

        return $this;
    }
}
