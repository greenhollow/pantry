<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\ServicePantryStatus;
use GreenHollow\Pantry\Tests\BaseUnitTestCase;

class ServicePantryStatusUnitTest extends BaseUnitTestCase
{
    /**
     * Verify the valid statuses.
     */
    public function testGetStatuses(): void
    {
        $this->assertSame(
            [
                'active',
                'canceled',
                'complete',
                'denied',
                'hold',
                'process',
                'requested',
            ],
            ServicePantryStatus::getStatuses()
        );
    }
}
