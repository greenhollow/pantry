<?php

namespace GreenHollow\Pantry\Tests\Controller;

use GreenHollow\Pantry\Tests\BaseFunctionalTestCase;

class PublicControllerFunctionalTest extends BaseFunctionalTestCase
{
    /**
     * Verify public access.
     */
    public function testHomeAction(): void
    {
        $this->client->request('GET', '/');

        $this->assertSame(200, $this->client->getResponse()->getStatusCode());
    }
}
