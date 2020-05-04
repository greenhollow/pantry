<?php

namespace GreenHollow\Pantry\Tests\Entity;

use GreenHollow\Pantry\Entity\PantryItem;
use GreenHollow\Pantry\Tests\BaseUnitTestCase;

class PantryItemUnitTest extends BaseUnitTestCase
{
    /**
     * Verify the valid units of measure.
     */
    public function testGetUnits(): void
    {
        $this->assertSame(
            [
                'qty',
                'g',
                'kg',
                'oz',
                'lb',
            ],
            PantryItem::getUnits()
        );
    }
}
