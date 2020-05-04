<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Entity\Household;
use GreenHollow\Pantry\Entity\ServicePantry;
use GreenHollow\Pantry\Tests\BaseUnitTestCase;

class ServicePantryUnitTest extends BaseUnitTestCase
{
    /**
     * Verify that a service pantry can be constructed in relation to a
     * household.
     */
    public function testConstructWithHousehold(): void
    {
        // configure a household
        $household = new Household();

        // instantiate with the household
        $servicePantry = new ServicePantry($household);

        // confirm the associations
        $this->assertSame($household, $servicePantry->getHousehold());
        $this->assertNull($servicePantry->getClient());
    }

    /**
     * Verify that a service pantry can be constructed in relation to a
     * client.
     */
    public function testConstructWithClient(): void
    {
        // configure a client
        $client = new Client();

        // instantiate with the client
        $servicePantry = new ServicePantry($client);

        // confirm the associations
        $this->assertSame($client, $servicePantry->getClient());
        $this->assertNull($servicePantry->getHousehold());
    }
}
