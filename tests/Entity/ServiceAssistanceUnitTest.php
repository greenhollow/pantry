<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\Client;
use GreenHollow\Pantry\Entity\Household;
use GreenHollow\Pantry\Entity\ServiceAssistance;
use GreenHollow\Pantry\Tests\BaseUnitTestCase;

class ServiceAssistanceUnitTest extends BaseUnitTestCase
{
    /**
     * Verify that a service assistance can be constructed in relation to a
     * household.
     */
    public function testConstructWithHousehold(): void
    {
        // configure a household
        $household = new Household();

        // instantiate with the household
        $serviceAssistance = new ServiceAssistance($household);

        // confirm the associations
        $this->assertSame($household, $serviceAssistance->getHousehold());
        $this->assertNull($serviceAssistance->getClient());
    }

    /**
     * Verify that a service assistance can be constructed in relation to a
     * client.
     */
    public function testConstructWithClient(): void
    {
        // configure a client
        $client = new Client();

        // instantiate with the client
        $serviceAssistance = new ServiceAssistance($client);

        // confirm the associations
        $this->assertSame($client, $serviceAssistance->getClient());
        $this->assertNull($serviceAssistance->getHousehold());
    }
}
