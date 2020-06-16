<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Dto\ClientDto;
use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Entity\Household;
use GreenHollow\Pantry\Tests\BaseUnitTestCase;

class ClientUnitTest extends BaseUnitTestCase
{
    /**
     * Verify that a client can be constructed in relation to a household.
     */
    public function testConstructWithHousehold(): void
    {
        // configure a household
        $household = new Household();

        // instantiate with the household
        $client = new client($household);

        // confirm the associations
        $this->assertSame($household, $client->getHousehold());
        $this->assertCount(1, $household->getClients());
        $this->assertSame($client, $household->getClients()->first());

        // confirm other defaults
        $this->assertSame('unknown', $client->getRelationship());
        $this->assertSame('enabled', $client->getStatus());
    }

    /**
     * Verify that a client can be constructed with a relationship.
     */
    public function testConstructWithRelationship(): void
    {
        // configure a household
        $household = new Household();

        // instantiate with a specific relationship
        $client = new Client($household, Client::RELATION_CHILD);

        // confirm the relationshipe was set
        $this->assertSame('child', $client->getRelationship());
    }

    /**
     * Verify that a client can be constructed without a household will always
     * have the individual relationship.
     */
    public function testConstructWithoutHousehold(): void
    {
        // instantiate with a specific relationship
        $client = new Client(null, Client::RELATION_CHILD);

        // confirm the given relationshipe was ignored
        $this->assertSame('self', $client->getRelationship());
    }

    /**
     * Verify the valid genders.
     */
    public function testGetGenders(): void
    {
        $this->assertSame(
            [
                'F',
                'M',
            ],
            Client::getGenders()
        );
    }

    /**
     * Verify the valid relations.
     */
    public function testGetRelations(): void
    {
        $this->assertSame(
            [
                'child',
                'family',
                'foster',
                'self',
                'other',
                'parent',
                'primary',
                'roommate',
                'spouse',
                'unknown',
            ],
            Client::getRelations()
        );
    }

    /**
     * Verify the valid statuses.
     */
    public function testGetStatuses(): void
    {
        $this->assertSame(
            [
                'authorized',
                'disabled',
                'enabled',
            ],
            Client::getStatuses()
        );
    }

    /**
     * Verify that a client can be updated via a DTO for only the properties
     * with non-empty values.
     */
    public function testUpdateWithLimitedDataTransfer(): void
    {
        // instantiate a client
        $client = new client();

        // configure a DTO and update the client
        $clientDto = new ClientDto();
        $clientDto->firstName = 'Test';
        $client->update($clientDto);

        // change the DTO values and update the client again
        $clientDto->firstName = null;
        $clientDto->lastName = 'Client';

        // confirm only the non-empty values were set
        $this->assertSame('Test', $client->getFirstName());
        $this->assertSame('Client', $client->getLastName());
    }

    /**
     * Verify that a client can be updated via a DTO for all properties,
     * including empty values, when the DTO is instantiated with a
     * persisted client.
     */
    public function testUpdateWithFullDataTransfer(): void
    {
        // instantiate a client, setting the UUID as if persisted
        $client = new client();
        $this->setPropertyValue($client, 'uuid', 'test-uuid');

        // configure a DTO and update the client
        $clientDto = ClientDto::create($client);
        $clientDto->firstName = 'Test';
        $client->update($clientDto);

        // change the DTO values and update the client again
        $clientDto->firstName = null;
        $clientDto->lastName = 'Client';

        // confirm that the empty and non-empty values were both set
        $this->assertNull($client->getFirstName());
        $this->assertSame('Client', $client->getLastName());
    }
}
