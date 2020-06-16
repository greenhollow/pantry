<?php

namespace GreenHollow\Pantry\Tests\Entity;

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
        // instantiate with a relationship
        $client = new Client(null, Client::RELATION_CHILD);

        // confirm the relationshipe was set
        $this->assertSame('child', $client->getRelationship());
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
}
