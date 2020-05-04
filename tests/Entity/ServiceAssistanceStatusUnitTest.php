<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\ServiceAssistanceStatus;
use GreenHollow\Pantry\Tests\BaseUnitTestCase;

class ServiceAssistanceStatusUnitTest extends BaseUnitTestCase
{
    /**
     * Verify the valid statuses.
     */
    public function testGetStatuses(): void
    {
        $this->assertSame(
            [
                'applied',
                'approved',
                'canceled',
                'complete',
                'denied',
                'hold',
                'process',
            ],
            ServiceAssistanceStatus::getStatuses()
        );
    }
}
